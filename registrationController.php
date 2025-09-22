<?php
require_once('autoloader.php');  
require_once('View/header.phtml');
require_once('View/navbar.phtml');

if(isset($_POST['register']))
{
    require_once('Model/UserDataSet.php');

    $email = $_POST["email"];
    $name = $_POST["name"];
    $password = $_POST["password"];
    $phone = $_POST["phone"];

    $userDataSet = new UserDataSet();

    if($userDataSet->validateNewPassword($password))
    {
        if($_FILES['image']['size']==0)
        {
            $profilePicture="";
            $userDataSet->addUser($email,$name,$password,$phone,$profilePicture);
        }else
        {
            if($userDataSet->validateImage())
            {
                $profilePicture=$userDataSet->saveImage();
                $userDataSet->addUser($email,$name,$password,$phone,$profilePicture);
            }
        }

    }else
        {
            echo '<script>window.alert("Password does not meet criteria !")</script>';
            require_once('registrationController.php');
        }
}

if(isset($_POST['close']))
{
   require_once('View/registration.phtml');
}

require_once('View/registration.phtml');

require_once('View/footer.phtml');




