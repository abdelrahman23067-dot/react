<?php
session_start();
$page_title = "register";
include('includes/header.php');
include('includes/navbar.php');
include('database.php');
?>

<div class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header">
                        <h5>register form</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                            <div class="form-group mb-3">
                                <label for="">email address</label>
                                <input type="text" name="email" class="form-control">
                            </div>
                            <div class="form-group mb-3">
                                <label for="">password</label>
                                <input type="text" name="password" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">register now</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
require_once 'db_pdo_config.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit();
    }
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$email, $hashed_password])) {
        session_start();
        $_SESSION['username'] = $email;
        setcookie('username', $email, time() + 3600, '/');
        header('Location: index.php');
        exit();
    } else {    
        echo "Registration failed!";
    }
}
?>


<?php
 include('includes/footer.php');

 ?>