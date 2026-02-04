<?php  
$host = "localhost"; //hostname
$db = "bitumi"; //database name
$port = "3307"; //port to connect to (mysql configutation)
$user = "root"; //username
$password = ""; //password

//points to the database
$dsn = "mysql:host=$host;port=$port;dbname=$db";

//try to connect, if connected echo a yay!
try {
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
//what happens if there is an error connecting 
catch(PDOException $e) {
    die("Database connection failed: " . $e->getMessage()); 
}
