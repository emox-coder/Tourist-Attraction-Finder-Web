<?php
require_once __DIR__ . "/../../Infrastructure/Repositories/AdminManagementRepositoryImpl.php";

class ManageAdminManagement {
    public function getAll() {
        return (new AdminManagementRepositoryImpl())->getAll();
    }
}
