<?php

/**
 * Models the application's database
 * Singleton design pattern
 */
class Database
{
    /**
     * @var Database
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO
     */
    protected $_dbHandle;

    /**
     * @param $username
     * @param $password
     * @param $host
     * @param $database
     * instantiates a connection with the database
     */
    private function __construct($username, $password, $host, $database)
    {
        try {
            // creates the database handle with connection info
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);

            // catch any failure to connect to the database
            } catch (Exception $e)
                {
                    echo $e->getMessage();
                }
    }

    /**
     * @return Database
     *
     */
    public static function getInstance()
    {
        $host     = $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? '127.0.0.1';
        $dbName   = $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? 'borrowmycharger';
        $username = $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? 'root';
        $password = $_ENV['DB_PASS'] ?? $_SERVER['DB_PASS'] ?? '';

        if (self::$_dbInstance === null) {
            self::$_dbInstance = new self($username, $password, $host, $dbName);
        }

        return self::$_dbInstance;
    }


    /**
     * @return PDO
     */
    public function getdbConnection()
    {
        // returns the PDO handle
        return $this->_dbHandle;
    }

    public function __destruct()
    {
        // destroys the PDO handle
        $this->_dbHandle = null;
    }
}