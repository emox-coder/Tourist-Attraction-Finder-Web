<?php
require_once __DIR__ . "/../../Infrastructure/Repositories/AdminRepositoryImpl.php";

class LoginAdmin {
    public function execute($data) {
        $repo = new AdminRepositoryImpl();
        $admin = $repo->findByEmail($data['email']);

        if ($admin && password_verify($data['password'], $admin['password'])) {
            return ["status" => "success", "admin" => $admin];
        }

        return ["status" => "error", "message" => "Invalid login"];
    }
}
