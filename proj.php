/* db_pdo_config.php */
<?php
$dsn = 'mysql:host=localhost;dbname=exam_db;charset=utf8mb4';
$username = 'root';
$password = '';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>

/* db_mysqli_config.php */
<?php
$mysqli = new mysqli("localhost", "root", "", "exam_db");
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>

/* register.php */
<?php
require_once 'db_pdo_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!$email) {
        $error = "Invalid email format";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        try {
            $stmt->execute([$email, $password]);
            $_SESSION['username'] = $email;
            setcookie("username", $email, time() + 3600, "/");
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Registration failed: " . $e->getMessage();
        }
    }
}
?>

/* login.php */
<?php
require_once 'db_mysqli_config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = $_POST['password'];

    if (!$email) {
        $error = "Invalid email format";
    } else {
        $stmt = $mysqli->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($hashed_password);
            $stmt->fetch();
            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $email;
                setcookie("username", $email, time() + 3600, "/");
                header("Location: index.php");
                exit;
            } else {
                $error = "Incorrect password";
            }
        } else {
            $error = "User not found";
        }
    }
}
?>

/* index.php */
<?php
session_start();
$loggedIn = isset($_SESSION['username']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php if ($loggedIn): ?>
        <h1>Hello, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>
        <a href="laravel_app_link">Go to Laravel App</a>
    <?php else: ?>
        <a href="login.php" class="btn btn-primary">Login</a>
        <a href="register.php" class="btn btn-secondary">Register</a>
    <?php endif; ?>
</div>
</body>
</html>
