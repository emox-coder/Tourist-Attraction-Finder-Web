<?php
require_once "../app/Controllers/AdminController.php";
require_once "../app/Controllers/DashboardController.php";

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Public API endpoints for landing page
if ($uri === "/api/top-destinations" && $method === "GET") {
    (new AdminController())->getTopDestinations();
    exit;
}

// Admin API endpoints for attractions management
if ($uri === "/api/admin/attractions" && $method === "GET") {
    (new AdminController())->listAttractions();
    exit;
}

if ($uri === "/api/admin/attractions" && $method === "POST") {
    (new AdminController())->addAttraction();
    exit;
}

// Handle PUT/PATCH for update (via _method override or direct)
if (preg_match('#^/api/admin/attractions/(\d+)$#', $uri, $matches)) {
    $id = $matches[1];
    
    if ($method === "GET") {
        (new AdminController())->getAttractionById($id);
        exit;
    }
    
    if ($method === "POST" && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
        (new AdminController())->updateAttraction($id);
        exit;
    }
    
    if ($method === "PUT") {
        (new AdminController())->updateAttraction($id);
        exit;
    }
    
    if ($method === "DELETE") {
        (new AdminController())->deleteAttraction($id);
        exit;
    }
}

// Dashboard endpoint
if ($uri === "/dashboard") {
    (new DashboardController())->index();
    exit;
}

// Handle 404
http_response_code(404);
echo json_encode(["error" => "Endpoint not found"]);
?>
