<?php
class Database {
    private $conn;

    public function connect() {
        $config = require __DIR__ . "/../../config/config.php";

        try {
            $this->conn = new PDO(
                "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
                $config['db']['user'],
                $config['db']['pass']
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("DB Error: " . $e->getMessage());
        }

        return $this->conn;
    }
}
