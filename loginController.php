<?php
require_once('autoloader.php'); 
require_once('View/login.phtml');
require_once ('autoloader.php');

if (isset($_POST["loginButton"]))
{
    $username = $_POST["username"];
    $password = $_POST["password"];


    $user = new User();

    if($user->authenticate($username, $password))
    {
        $_SESSION["login"]=$user->getUsername();
        $_SESSION["uid"]= $user->getuserID();


        echo '<script>window.alert("You are logged in")</script>';

    } else
        {
            echo '<script>window.alert("Incorrect login details")</script>';
        }
}

if (isset($_POST["logoutButton"]))
{
    $user = new User();
    $user->logout();

    echo '<script>window.alert("Logged Out")</script>';
    unset($_SESSION["login"]);

    session_destroy();
}

require_once ('View/footer.phtml');