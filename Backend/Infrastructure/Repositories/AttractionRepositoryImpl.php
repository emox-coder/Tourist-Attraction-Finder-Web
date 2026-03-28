<?php
require_once __DIR__ . "/../../Infrastructure/Database/Database.php";

class AttractionRepositoryImpl implements AttractionRepository {
    private $conn;

    public function __construct() {
        $this->conn = (new Database())->connect();
    }

    public function create($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO attractions (name, location, description, category)
             VALUES (?, ?, ?, ?)"
        );
        return $stmt->execute([
            $data['name'],
            $data['location'],
            $data['description'],
            $data['category']
        ]);
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM attractions")
                          ->fetchAll(PDO::FETCH_ASSOC);
    }
}
