<?php
// Test admin API endpoint
header("Content-Type: application/json");

try {
    // Test the API endpoint directly
    $response = file_get_contents('http://localhost/TAF/Backend/routes/api.php?uri=/api/admin/admins');
    echo json_encode([
        "success" => true,
        "response" => $response,
        "message" => "API test completed"
    ]);
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
