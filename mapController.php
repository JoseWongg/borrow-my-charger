<?php

$view = new stdClass();
$view->pageTitle = 'Map';



require_once('View/header.phtml');
require_once('View/navbar.phtml');
require_once('View/map.phtml');


if(isset($_POST['editCharger']))
{
    $chargePointDataSet= new ChargePointDataSet();

    if($_POST['address1']!="")
    {
        $address1=$_POST['address1'];
        $chargePointDataSet->updateChargerAddress1($address1,$_SESSION['uid']);
    }

    if($_POST['address2']!="")
    {
        $address2=$_POST['address2'];
        $chargePointDataSet->updateChargerAddress2($address2,$_SESSION['uid']);
    }

    if($_POST['postcode']!="")
    {
        $postcode=$_POST['postcode'];
        $chargePointDataSet->updateChargerPostcode($postcode,$_SESSION['uid']);
    }

    if($_POST['lat']!="")
    {
        $lat=$_POST['lat'];
        $chargePointDataSet->updateChargerLatitude($lat,$_SESSION['uid']);
    }

    if($_POST['lng']!="")
    {
        $lng=$_POST['lng'];
        $chargePointDataSet->updateChargerLongitude($lng,$_SESSION['uid']);
    }

    if($_POST['cost']!="")
    {
        $lng=$_POST['cost'];
        $chargePointDataSet->updateChargerCost($cost,$_SESSION['uid']);
    }
    echo '<script>window.alert("Charger successfully updated!")</script>';
    require_once ('chargerLister.php');
}
