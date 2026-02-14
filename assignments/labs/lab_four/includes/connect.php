<?php
//database variables
$host = "localhost"; //hostname
$db = "lab4"; //database name
$port = "3307"; //port on localhost
$user = "root"; //username
$password = ""; //password

//database pointer
$dsn = "mysql:host=$host;port=$port;dbname=$db";

try //try to connect
{
   $pdo = new PDO ($dsn, $user, $password); 
   $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) //catch errors when connecting
{
    die("Database connection failed: " . $e->getMessage()); 
}