<?php

namespace App\Services;

use mysqli;

class DatabaseService
{
    private static $instance = null;
    private $host = 'localhost';
    private $username;
    private $password;
    private $database;
    public $conn = null;

    
    private function __construct($username, $password, $database)
    {
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        
      
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
      
        if ($this->conn->connect_error) {
            die('Connection failed: ' . $this->conn->connect_error);
        }
        
       
        $this->conn->set_charset('utf8mb4');
    }

   
    private function __clone() {}


    public static function getInstance($username, $password, $database)
    {
        if (!self::$instance) {
            self::$instance = new self($username, $password, $database);
        }
        return self::$instance;
    }

    public function __destruct()
    {
 
        if ($this->conn) {
            $this->conn->close();
        }
    }

    
    public function executeQuery($sql)
    {
        $result = $this->conn->query($sql);
        if (!$result) {
            die('Query failed: ' . $this->conn->error);
        }
        return $result;
    }
}
?>
