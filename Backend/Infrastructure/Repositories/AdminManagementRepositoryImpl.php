<?php
require_once __DIR__ . "/../../Infrastructure/Database/Database.php";

class AdminManagementRepositoryImpl implements AdminManagementRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function getAll() {
        $stmt = $this->conn->query("SELECT id, name, email FROM admin_management");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
