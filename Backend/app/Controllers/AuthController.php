<?php
require_once __DIR__ . "/../UseCases/LoginAdmin.php";

class AuthController {
    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode((new LoginAdmin())->execute($data));
    }
}
