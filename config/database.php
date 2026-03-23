

<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "taf";
    
    public $conn;
    
    public function __construct() {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            
            if ($this->conn->connect_error) {
                // Try to create database if it doesn't exist
                $this->createDatabase();
                $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
            }
        } catch (Exception $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    
    private function createDatabase() {
        $conn = new mysqli($this->host, $this->username, $this->password);
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "CREATE DATABASE IF NOT EXISTS taf";
        if ($conn->query($sql)) {
            echo "Database created successfully\n";
        } else {
            echo "Error creating database: " . $conn->error;
        }
        
        $conn->close();
    }
    
    public function getConnection() {
        return $this->conn;
    }
    
    public function __destruct() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>
