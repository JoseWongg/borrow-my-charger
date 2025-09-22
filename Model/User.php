<?php
require_once ('UserDataSet.php');
/**
 * Models a session's user (A logged in user)
 */
class User
{
    protected $_username,  $_loggedin, $_userID;

    public function __construct()
    {
        $this->_username = "No user";
        $this->_loggedin = false;
        $this->_userID = "0";
    }

    public function authenticate($uname, $pword) : bool
    {
        $users = new UserDataSet();
        $usersDataSet = $users->checkUsersCredentials($uname, $pword);


        if ($usersDataSet!=null)
        {
            $this->_loggedin=true;
            $this->_username=$uname;
            $this->_userID= $usersDataSet[0]->getuserID();
            return true;
        }
        else
        {
            $this->_loggedin=false;
            return false;
        }
    }


    public function logout()
    {
        unset($_SESSION["login"]);
        $this->_loggedin=false;
        $this->_username= "No user";
        $this->_userID = "0";
    }


    public function getUsername(): string
    {
        return $this->_username;
    }

    public function getUserID(): string
    {
        return $this->_userID;
    }
}