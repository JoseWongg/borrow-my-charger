<?php

$view = new stdClass();
$view->pageTitle = 'Index';

//This autoloader loads the classes from the Model folder in each loaded window,
// so I don't have to include them each time they are being used
include 'autoloader.php';


// Start session if not already started
if(session_id()=="")
{
    session_start();

    //Generates a randomized token used to verify the authenticity of the AJAX requests
    $token = substr(str_shuffle((MD5(microtime()))),0,20);
    $_SESSION["ajaxToken"] = $token;

}


// Include header and navbar
require_once('View/header.phtml');
require_once('loginController.php');
require_once('View/navbar.phtml');


// Check if user is logged in
if(isset($_SESSION['login']))
{
    // Check if charger list has been displayed before
    if (!isset($_SESSION['chargerListDisplayed']))
    {
        require_once('chargerLister.php');
        $_SESSION['chargerListDisplayed'] = true;
    }


    // Check which button was clicked
    if(isset($_POST['map']))
    {
        require_once('View/map.phtml');
    }
    else if(isset($_POST['chargerLister'])||(isset($_POST['searchField'])))
    {
        require_once('View/chargerLister.phtml');

    }else
    {
        require_once ('View/chargerLister.phtml');
    }
}
else
{
    require_once('View/index.phtml');
}
