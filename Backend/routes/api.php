<?php
require_once "../app/Controllers/AuthController.php";
require_once "../app/Controllers/AdminController.php";
require_once "../app/Controllers/DashboardController.php";

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

if ($uri === "/login" && $method === "POST") {
    (new AuthController())->login();
}

if ($uri === "/attractions" && $method === "POST") {
    (new AdminController())->addAttraction();
}

if ($uri === "/attractions" && $method === "GET") {
    (new AdminController())->listAttractions();
}

if ($uri === "/dashboard") {
    (new DashboardController())->index();
}
