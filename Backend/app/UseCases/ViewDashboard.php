<?php
require_once __DIR__ . "/../../Infrastructure/Database/Database.php";

class ViewDashboard {
    public function stats() {
        $conn = (new Database())->connect();

        return [
            "users" => $conn->query("SELECT COUNT(*) FROM users")->fetchColumn(),
            "attractions" => $conn->query("SELECT COUNT(*) FROM attractions")->fetchColumn()
        ];
    }
}
