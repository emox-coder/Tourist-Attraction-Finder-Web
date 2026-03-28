<?php
require_once __DIR__ . "/../../Infrastructure/Repositories/UserRepositoryImpl.php";

class ManageUser {
    public function getAll() {
        return (new UserRepositoryImpl())->getAll();
    }
}
