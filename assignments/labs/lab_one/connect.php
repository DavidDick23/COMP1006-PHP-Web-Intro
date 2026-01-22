<?php
// Ensure loose variable types are NOT used
declare(strict_types=1);

// Variable configurations for connecting to host and database
$host = 'localhost'; // host name
$database = 'lab1'; // name of the locally created database
$user = 'root';  // default user (verified it's existance)
$password = '';  // root user password (none exists so an empty string should work)

// Combined 
$dsn = "mysql:host=$host;dbname=$database";

// Handles connectivity by trying to connect with the above variables
try
{
    // Create a new PDO instance to attempt to connect to host and database
    $pdo = new PDO($dsn, $user, $password); 

    // Set the error mode to 'Exception' (for handling the catch if fails to connect)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Show a message if connection is succesful
    echo "Connected to: " . $host;
}
catch (PDOException $exception)
{
    // Show a message if connection failed (message contains more details as it is generated from error attributes)
    echo "Connection Failed: " . $exception->getMessage(); // changed from 'die' to 'echo' as footer was dissapearing
}

//Comments:
/*
    This lab has been a bit challenging as there were quite a few technical issues in setting up
    XAMPP and gaining access to phpmyadmin through my local host.

    I also had an interesting time getting used to the syntax involved with php and some functionality
    as it is quite different from C#. I wish there were #regions available to keep my code a bit
    more organized but I did not find any solution as of yet.

    All in all I found this to be a bit of a struggle, however, as this course continues I am sure
    the syntax will come a bit more naturally and the growing pains of working with XAMPP will
    diminish.

    **New Comment As Of 01/21/2026**
    -Workflow challenges due to change in forked branch and gaining new perspective as to the creation of branches through VS Code... growing pains.
*/