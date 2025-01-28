<?php
class Database
{
    private static $instance = null;
    private $conn;
    private $servername = "localhost";  // Database host
    private $username = "root";         // Database username
    private $password = "";             // Database password
    private $dbname = "ecommerce_db";   // Database name


    private function __construct()
    {
        $this->conn = new mysqli(
            $this->servername,
            $this->username,
            $this->password,
            $this->dbname
        );

        if ($this->conn->connect_error) {
            throw new Exception("Connection failed: " . $this->conn->connect_error);
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function __destruct()
    {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
