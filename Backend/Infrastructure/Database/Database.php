<?php

require_once __DIR__ . "/PDOConnection.php";

class Database {
    private $conn;

    public function connect() {
        if ($this->conn === null) {
            $this->conn = (new PDOConnection())->connect();
            }
        return $this->conn;
    }
}
