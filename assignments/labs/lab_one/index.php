<?php 
// Header
require "header.php"; 
echo "<p> Follow the instructions outlined in instructions.txt to complete this lab. Good luck & have fun!😀 </p>";
// Body
include "car.php"; 
echo "Here are the details of the current vehicle I own: <br>";
$myCar = new Car("Kia", "Rio", 2013); // creates a new instance of the car class
echo $myCar->ShowDetails() . "<br>"; // displays details of the car intance in the body
echo "Connecting to localhost database: <br>";
include "connect.php"; // will attempt to connect to the localhost and created database
// Footer
require "footer.php"; 