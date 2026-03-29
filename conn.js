const mysql=require('mysql2');
const conn=mysql.createConnection({
    host:"localhost",
    user:"root",
    password:"",
    database:"stu-db",  
})
module.exports=conn