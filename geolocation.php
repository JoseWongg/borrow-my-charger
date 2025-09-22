<?php
include ('Model/LocationClass.php');

$view = new stdClass();
$view->location = ""; // initialise location to an empty string

// Instantiate LocationClass
$loc = new LocationClass();

// Gets JavaScript code for obtaining the user's location
$locationCode = $loc->getLocationCode();

// Inject location code into $view object
$view->location = $locationCode;

