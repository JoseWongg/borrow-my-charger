<?php

include 'autoloader.php';

session_start();

// Retrieve the token from the session, if it exists
$token="";
if (isset($_SESSION["ajaxToken"]))
{
    $token = $_SESSION["ajaxToken"];
}

// Compare the token submitted in the request with the one in the session
if (!isset($_GET["token"]) || $_GET["token"] != $token)
{
    // If the tokens don't match, return an error response
    $data = new stdClass();
    $data->error = "Invalid Token";
    echo json_encode($data);
}else
{
    if(isset($_REQUEST["q"]))
    {
        // If the tokens match, process the AJAX request
        $chargePointDataSet= new ChargePointDataSet();
        $chargePoints=$chargePointDataSet->searchChargePoints($_REQUEST["q"]);
        return $chargePoints;
    }
}