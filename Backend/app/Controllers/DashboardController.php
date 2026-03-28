<?php
require_once __DIR__ . "/../UseCases/ViewDashboard.php";

class DashboardController {
    public function index() {
        echo json_encode((new ViewDashboard())->stats());
    }
}
