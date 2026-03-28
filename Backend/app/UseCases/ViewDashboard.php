<?php
require_once __DIR__ . "/../../Infrastructure/Database/Database.php";

class ViewDashboard {
    public function stats() {
        $conn = (new Database())->connect();

        return [
            "admin_management" => $conn->query("SELECT COUNT(*) FROM admin_management")->fetchColumn(),
            "attractions" => $conn->query("SELECT COUNT(*) FROM attractions")->fetchColumn()
        ];
    }
}
