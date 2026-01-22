<?php
// Turn on error reporting so syntax and runtime errors are visible during development
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Connection variables
$host = "localhost";
$dbname = "test";
$port = "3307"; // <- required to properly connect since XAMMP needed to be reconfigured
$username = "root";
$password = "";

// Points to the database
$dsn = "mysql:host=$host;port=$port;dbname=$dbname";

try 
{
    // Attempt to connect to the database
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

    // Display message if connection is made
    echo "Connected to database!";
}
catch (PDOException $e) 
{
    // Display message if connection failed
    echo "Database error: " . $e;
}
