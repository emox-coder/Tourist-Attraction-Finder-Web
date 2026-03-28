<?php
require_once __DIR__ . "/../../Infrastructure/Database/Database.php";

class UserRepositoryImpl implements UserRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT id, name, email FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
