<?php

/**
 * Models a single user with an account in the application
 * Implements JsonSerializable
 */
class UserData implements JsonSerializable
{
    protected $_userId, $_username, $_realname, $_password, $_phonenumber, $_profilephoto;


    public Function __construct($dbRow)
    {
        $this->_userId = $dbRow['user_id'];
        $this->_username = $dbRow['username'];
        $this->_realname = $dbRow['real_name'];
        $this->_password = $dbRow['password'];
        $this->_phonenumber = $dbRow['phone_number'];
        $this->_profilephoto = $dbRow['profile_photo'];
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->_userId;
    }

    /**
     * @param mixed $userId
     */
    public function setUserId($userId)
    {
        $this->_userId = $userId;
    }

    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @return mixed
     */
    public function getRealname()
    {
        return $this->_realname;
    }

    /**
     * @param mixed $realname
     */
    public function setRealname($realname)
    {
        $this->_realname = $realname;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @return mixed
     */
    public function getPhonenumber()
    {
        return $this->_phonenumber;
    }

    /**
     * @param mixed $phonenumber
     */
    public function setPhonenumber($phonenumber)
    {
        $this->_phonenumber = $phonenumber;
    }

    /**
     * @return mixed
     */
    public function getProfilephoto()
    {
        return $this->_profilephoto;
    }

    /**
     * @param mixed $profilephoto
     */
    public function setProfilephoto($profilephoto)
    {
        $this->_profilephoto = $profilephoto;
    }


    // Returns an associative array with the object's attributes
    public function jsonSerialize(): array
    {
        return
            [
            'userId' => $this->_userId,
            'username' => $this->_username,
            'realname' => $this->_realname,
            'password' => $this->_password,
            'phonenumber' => $this->_phonenumber,
            'profilephoto' => $this->_profilephoto,
            ];
    }

}