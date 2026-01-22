<?php
// Class that will represent a car
class Car
{
    // Properties that will be required when creating an instance of this class
    // Set to private so they can only be set through the constructor
    private $make;
    private $model;
    private $year;

    // Constructor method that will set the properties when an instance is being created
    public function __construct($make, string $model, int $year)
    {
        // acts as getter and setters 
        $this->make = $make;
        $this->model = $model;
        $this->year = $year;
    }
    
    // Calling this method will return the properties that were set for the instance
    // Using echo in conjuction will display the properties
    public function ShowDetails()
    {
        // local variables to make the information more legible 
        $makeInfo = "Make:  " . $this->make . "<br>";
        $modelInfo = "Model: " . $this->model . "<br>";
        $yearInfo = "Year: " . $this->year . "<br>";

        // concatenates the above info to be returned
        return $makeInfo . $modelInfo . $yearInfo;
    }
}