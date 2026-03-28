<?php
require_once __DIR__ . "/../../Infrastructure/Database/Database.php";

class AdminRepositoryImpl implements AdminRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function findByEmail($email) {
        $stmt = $this->conn->prepare("SELECT * FROM admins WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
