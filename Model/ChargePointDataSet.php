<?php

require_once ('Database.php');
require_once ('ChargePointData.php');

/**
 * Models the collection of charge point objects in the application
 * Retrieves entries from the database and returns the collection
 */
class ChargePointDataSet
{
    protected $_dbHandle, $_dbInstance;

    public function __construct()
    {
        $this->_dbInstance = Database::getInstance();//gets the application's database (static)
        $this->_dbHandle = $this->_dbInstance->getdbConnection();
    }

    /**
     * @return mixed
     */

    public function fetchAllChargePoints()
    {
        $sqlQuery = '
        SELECT * FROM (SELECT * FROM ChargePoints
        )ChargePoints
        INNER JOIN Users WHERE
            Users.user_id = ChargePoints.owner';

        $statement =$this->_dbHandle->prepare($sqlQuery); //prepare a POD statement
        $statement->execute(); //execute the PDO statement

        $dataSet=[];
        while($row = $statement->fetch())
        {
            //instantiates a charge point object for every row in the query result
            $dataSet[] = new ChargePointData($row);
        }
        return $dataSet;
    }

    public function findByCityOrPostcode($cityPostcodeName)
    {
        $sqlQuery = "SELECT * FROM ChargePoints WHERE (address2 LIKE :cityName) OR (postcode LIKE :postcode)";
        $statement =$this->_dbHandle->prepare($sqlQuery); //prepare a PDO statement
        $statement->bindParam(':cityName',$cityPostcodeName);
        $statement->bindParam('postcode', $cityPostcodeName);
        $statement->execute(); //execute the PDO statement

        $dataSet=[];
        while($row = $statement->fetch())
        {
            //instantiates a charge point object for every sow in the query result
            $dataSet[] = new ChargePointData($row);
        }
        return $dataSet;
    }

    public function fetchChargePointByUserId($userId)
    {
        $sqlQuery = "SELECT * FROM ChargePoints WHERE owner LIKE :userId";
        $statement =$this->_dbHandle->prepare($sqlQuery); //prepare a PDO statement
        $statement->bindParam(':userId',$userId);
        $statement->execute(); //execute the PDO statement

        $dataSet=[];
        while($row = $statement->fetch())
        {
            //instantiates a charge point object for every sow in the query result
            $dataSet[] = new ChargePointData($row);
        }
        return $dataSet;
    }

    public function addCharger($address1, $address2, $postcode, $lat, $lng, $cost, $owner)
    {
            $sqlQuery = "INSERT INTO ChargePoints(address1, address2, postcode, lat, lng, cost, owner)
                         VALUES(:address1, :address2, :postcode, :lat, :lng,:cost, :owner)";

            //binds the parameters to the SQL query and tells the database what the parameters are.
            $statement = $this->_dbHandle->prepare($sqlQuery);

            $statement->bindParam(':address1', $address1);
            $statement->bindParam(':address2', $address2);
            $statement->bindParam(':postcode', $postcode);
            $statement->bindParam(':lat', $lat);
            $statement->bindParam(':lng', $lng);
            $statement->bindParam(':cost', $cost);
            $statement->bindParam(':owner', $owner);

            $statement->execute();
            echo '<script>window.alert("Charger Successfully added!")</script>';
    }

    public function updateChargerAddress1($address1, $owner)
    {
        $sqlQuery = 'UPDATE ChargePoints SET address1 = :address1 WHERE owner = :owner';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':address1', $address1);
        $statement->bindParam(':owner', $owner);
        $statement->execute();
    }

    public function updateChargerAddress2($address2, $owner)
    {
        $sqlQuery = 'UPDATE ChargePoints SET address2 = :address2 WHERE owner = :owner';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':address2', $address2);
        $statement->bindParam(':owner', $owner);
        $statement->execute();
    }

    public function updateChargerPostcode($postcode, $owner)
    {
        $sqlQuery = 'UPDATE ChargePoints SET postcode = :address2 WHERE owner = :owner';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':postcode', $postcode);
        $statement->bindParam(':owner', $owner);
        $statement->execute();
    }


    public function updateChargerLatitude($lat, $owner)
    {
        $sqlQuery = 'UPDATE ChargePoints SET lat = :address2 WHERE owner = :owner';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':lat', $lat);
        $statement->bindParam(':owner', $owner);
        $statement->execute();
    }

    public function updateChargerLongitude($lng, $owner)
    {
        $sqlQuery = 'UPDATE ChargePoints SET lng = :address2 WHERE owner = :owner';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':lng', $lng);
        $statement->bindParam(':owner', $owner);
        $statement->execute();
    }

    public function updateChargerCost($cost, $owner)
    {
        $sqlQuery = 'UPDATE ChargePoints SET cost = :address2 WHERE owner = :owner';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':cost', $cost);
        $statement->bindParam(':owner', $owner);
        $statement->execute();
    }

    public function searchChargePoints($searchedTerm)
    {
        $searchedTerm2 = $searchedTerm . '%';

        $sqlQuery = 'SELECT DISTINCT * FROM ChargePoints 
                  WHERE postcode LIKE :searchedTerm 
                  UNION 
                  SELECT DISTINCT * FROM ChargePoints 
                  WHERE address2 LIKE :searchedTerm';

        $statement = $this->_dbHandle->prepare($sqlQuery);
        $statement->bindParam(':searchedTerm', $searchedTerm2);
        $statement->execute();
        $chargePointDataSet= [];

        while ($row = $statement->fetch())
        {
            $chargePointDataSet[]=new ChargePointData($row);
        }

        //Returns query output as Json. Flags to deal with special characters and ensure clean Json string
        echo json_encode($chargePointDataSet, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);

    }

    public function mapData()
    {
        $sqlQuery = '
        SELECT * FROM  ChargePoints';

        $statement =$this->_dbHandle->prepare($sqlQuery); //prepare a POD statement
        $statement->execute(); //execute the PDO statement

        $dataSet=[];
        while($row = $statement->fetch())
        {
            //instantiates a charge point object for every row in the query result
            $dataSet[] = new ChargePointData($row);
        }

        //Returns query output as Json. Flags to deal with special characters and ensure clean Json string
        echo json_encode($dataSet, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
    }
}