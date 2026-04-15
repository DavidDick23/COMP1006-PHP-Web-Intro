<?php
//=========================================================================
// #region Variables
//-------------------------------------------------------------------------
$host = "localhost";
$db   = "finalexam";
$port = "3307";
$dbUser = "root";
$password = "";
$dsn = "mysql:host=$host;port=$port;dbname=$db";
//-------------------------------------------------------------------------
// #endregion Variables
//=========================================================================

//=========================================================================
// #region Attempt To Connect
//-------------------------------------------------------------------------
//try to connect to the database and display a message when successful
try
{
    //create a new instance of the connection and set error handling attributes
    $pdo = new PDO($dsn, $dbUser, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //sets error mode to throw exceptions for any database errors

    //at this point the connection has been made
    //DEBUG - uncomment line below to display message
    //echo htmlspecialchars("Connection Successful!");
}
//if there was an error connecting, terminate the code and display an error message
catch (PDOException $error)
{
    die("Connection Failed: " . htmlspecialchars($error->getMessage())); //terminate code and show error message
}
//-------------------------------------------------------------------------
// #endregion Attempt To Connect
//=========================================================================