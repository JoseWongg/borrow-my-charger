<?php
require_once('Database.php');
require_once ('UserData.php');

/**
 * Models the collection of user objects in the application
 * Retrieves entries from the database and returns the collection or a subset of the collection
 */
class UserDataSet
{
    protected PDO $_dbHandle;
    protected Database $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();//gets the application's database (static)
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    public function fetchUserById($userId)
    {
        $sqlQuery = "SELECT * FROM Users WHERE user_id = :id";
        $statement = $this->_dbHandle->prepare($sqlQuery);

        $statement->bindParam(':id', $userId);
        $statement->execute();
        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new UserData($row);
        }
        return $dataSet;
    }


    public function checkUsersCredentials($username, $password)
    {
        $sqlQuery = 'SELECT * 
                     FROM Users
                     WHERE username = :uname';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':uname', $username);
        $statement->execute();
        $dataSet = [];
        $dataSet2 = [];
        while ($row = $statement->fetch())
        {
            $dataSet[] = new UserData($row);
        }
        //validates the argument password with the hashed password returned from the db
        foreach ($dataSet as $userData)
        {
           if(password_verify($password, $userData->getPassword() ))
           {
               $dataSet2[] = $userData;
           }
            #return $dataSet2;
        }
        return $dataSet2;
    }









































    public function hashAllPasswords()
    {
        $sqlQuery='SELECT * FROM Users';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->execute();

        while ($row = $statement->fetch())
        {
           $id=$row['user_id'];
           $password=$row['password'];
           $this->updatePassword($id, $password);
        }
    }

    public function updatePassword($id, $password)
    {
        $hashPassword = password_hash($password, PASSWORD_DEFAULT);
        $sqlQuery = 'UPDATE Users SET password = :hashedPassword WHERE user_id = :user_id';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':hashedPassword', $hashPassword);
        $statement->bindParam(':user_id', $id);
        $statement->execute();
    }
    //Avoids registering a user with a username(email) already in use
    public function checkUniqueUserName($userName)
    {
        $sqlQuery='SELECT * FROM Users WHERE username = :user_name';
        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':user_name', $userName);
        $statement->execute();
        $dataSet=[];

        while ($row = $statement->fetch())
        {
            $dataSet[]=new UserData($row);
        }
        return $dataSet;
    }

    public function addUser($_username, $_realname, $_password, $_phonenumber, $_profilephoto)
    {
        if($this->checkUniqueUserName($_username))
        {
            echo '<script>window.alert("Username(email) already exists !")</script>';
            require_once ('registrationController.php');
        }else
            {
                $_hashedPassword=$this->encryptPassword($_password);

                $sqlQuery = "INSERT INTO Users(username, real_name, password, phone_number,profile_photo)
                         VALUES(:username,:realname,:password,:phonenumber,:profilephoto)";

                //binds the parameters to the SQL query and tells the database what the parameters are.
                $statement = $this->_dbHandle->prepare($sqlQuery);

                $statement->bindParam(':username', $_username);
                $statement->bindParam(':realname', $_realname);
                $statement->bindParam(':password', $_hashedPassword);
                $statement->bindParam(':phonenumber', $_phonenumber);
                $statement->bindParam(':profilephoto', $_profilephoto);

                $statement->execute();
                echo '<script>window.alert("Successfully registered!")</script>';
            }
    }

    //check new password meets criteria during registration
    public function validateNewPassword($password)
    {
        $validNewPassword=false;

        //at least one upper case letter
        $uppercase = preg_match('@[A-Z]@', $password);
        //at least one lower case letter
        $lowercase = preg_match('@[a-z]@', $password);
        //at least one number
        $number    = preg_match('@[0-9]@', $password);
        //password length between 1 and 60 characters
        $length=strlen($password);

        if($length>7 && $length<=60 && $uppercase && $lowercase && $number )
        {
                $validNewPassword = true;
        }
        return $validNewPassword;
    }

    public function encryptPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    public function validateImage()
    {
        $validImage=true;
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $tempFilePath=$_FILES["image"]["tmp_name"];
        $filename = $_FILES["image"]["name"];
        $filesize = $_FILES["image"]["size"];

        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed))
        {
            $validImage=false;
            echo '<script>window.alert("Formats allowed: jpeg, gif, png !")</script>';
            require_once('registrationController.php');
        }else {
            // Verify file size - 5MB maximum
            $maxsize = 5 * 1024 * 1024;
            if ($filesize > $maxsize)
            {
                $validImage=false;
                echo '<script>window.alert("Error: File size is larger than the allowed limit!")</script>';
                require_once('registrationController.php');
            } else
            {
                // Check whether file exists before uploading it
                if (file_exists("Images/" . $filename))
                {
                    $validImage=false;
                    echo $filename . " already exists!";
                    require_once('registrationController.php');
                }
            }
        }
        return $validImage;
    }

    public function saveImage()//does not compress image
    {
        $rootPath="";
        $tempFilePath=$_FILES["image"]["tmp_name"];
        $filename = $_FILES["image"]["name"];

        {
            //Check if file upload succeeds
            if (move_uploaded_file($tempFilePath, "Images/" . $filename))
            {
                $rootPath="Images/" . $filename;

            } else
                {
                    echo '<script>window.alert("Error uploading image!")</script>';
                }
        }
     return $rootPath;
    }

    public function saveImage2()//compresses image
    {
        $rootPath="";
        $tempFilePath=$_FILES["image"]["tmp_name"];
        $filename = $_FILES["image"]["name"];
        $rootPath="Images/" . $filename;
        $this->compressImage($tempFilePath,$rootPath);

        return $rootPath;
    }

    function compressImage($source, $destination)//needs fixing php.ini extension=gd
    {
        $quality = 60;
        $info = getimagesize($source);
        if ($info['mime'] == 'image/jpeg')
        {
            $image = imagecreatefromjpeg($source);
        } elseif ($info['mime'] == 'image/gif')
        {
            $image = imagecreatefromgif($source);
        } elseif ($info['mime'] == 'image/png')
        {
            $image = imagecreatefrompng($source);
        }
        imagejpeg($image, $destination, $quality);
    }

    public function fetchAllUsers()
    {
        $sqlQuery = '
        SELECT * FROM  Users';

        $statement =$this->_dbHandle->prepare($sqlQuery); //prepare a POD statement
        $statement->execute(); //execute the PDO statement

        $dataSet=[];
        while($row = $statement->fetch())
        {
            //instantiates a user object for every row in the query result
            $dataSet[] = new UserData($row);
        }

        //Returns query output as Json. Flags to deal with special characters and ensure clean Json string
        echo json_encode($dataSet, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }

}