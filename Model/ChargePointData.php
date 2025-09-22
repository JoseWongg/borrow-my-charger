<?php

/**
 * Models a single charge point
 * Implements JsonSerializable
 */

class ChargePointData implements JsonSerializable
{
    protected $_chargerId, $_address1, $_address2, $_postcode, $_lat, $_lng, $_cost, $_owner;


    public function __construct($dbRow)
    {
        $this->_chargerId = $dbRow['charger_id'];
        $this->_address1 = $dbRow['address1'];
        //$this->_address2 = $dbRow['address2'];
        $this->_address2 = preg_replace('/[^A-Za-z0-9]/', '', $dbRow['address2']) ;
        $this->_postcode = $dbRow['postcode'];
        $this->_lat = $dbRow['lat'];
        $this->_lng = $dbRow['lng'];
        $this->_cost = $dbRow['cost'];
        $this->_owner = $dbRow['owner'];
    }

    /**
     * @return mixed
     */
    public function getChargerId()
    {
        return $this->_chargerId;
    }

    /**
     * @param mixed $chargerId
     */
    public function setChargerId($chargerId)
    {
        $this->_chargerId = $chargerId;
    }

    /**
     * @return mixed
     */
    public function getAddress1()
    {
        return $this->_address1;
    }

    /**
     * @param mixed $address1
     */
    public function setAddress1($address1)
    {
        $this->_address1 = $address1;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->_address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->_address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getPostcode()
    {
        return $this->_postcode;
    }

    /**
     * @param mixed $postcode
     */
    public function setPostcode($postcode)
    {
        $this->_postcode = $postcode;
    }

    /**
     * @return mixed
     */
    public function getLat()
    {
        return $this->_lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->_lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->_lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->_lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getCost()
    {
        return $this->_cost;
    }

    /**
     * @param mixed $cost
     */
    public function setCost($cost)
    {
        $this->_cost = $cost;
    }

    /**
     * @return mixed
     */
    public function getOwner()
    {
        return $this->_owner;
    }

    /**
     * @param mixed $owner
     */
    public function setOwner($owner)
    {
        $this->_owner = $owner;
    }
    // Returns an associative array with the object's attributes
    public function jsonSerialize(): array
    {
        return [
                'chargerId' => $this->_chargerId,
                'address1' => $this->_address1,
                'address2' => $this->_address2,
                'postcode' => $this->_postcode,
                'lat' => $this->_lat,
                'lng' => $this->_lng,
                'cost' => $this->_cost,
                'owner' => $this->_owner,
                ];
    }
}