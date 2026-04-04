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

    public function getTopDestinations() {
        header("Content-Type: application/json");
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET");
        echo json_encode((new ManageAttraction())->getTopDestinations());
    }

    public function getAttractionById($id) {
        header("Content-Type: application/json");
        $result = (new ManageAttraction())->getById($id);
        echo json_encode($result ? $result : ["error" => "Attraction not found"]);
    }

    public function updateAttraction($id) {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);
        $result = (new ManageAttraction())->update($id, $data);
        echo json_encode(["success" => $result]);
    }

    public function deleteAttraction($id) {
        header("Content-Type: application/json");
        $result = (new ManageAttraction())->delete($id);
        echo json_encode(["success" => $result]);
    }
}
?>
