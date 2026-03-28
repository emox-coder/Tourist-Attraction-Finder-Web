<?php
require_once __DIR__ . "/../UseCases/ManageAttraction.php";

class AdminController {
    public function addAttraction() {
        $data = json_decode(file_get_contents("php://input"), true);
        $result = (new ManageAttraction())->create($data);

        echo json_encode(["success" => $result]);
    }

    public function listAttractions() {
        echo json_encode((new ManageAttraction())->getAll());
    }
}
