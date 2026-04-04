<?php
// Simple API test without routing
header("Content-Type: application/json");

try {
    // Test database connection directly
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get all attractions
    $stmt = $pdo->query("SELECT * FROM attractions ORDER BY display_order ASC, id DESC");
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode($attractions);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
?>
