<?php
// Check what records exist in the database
header("Content-Type: application/json");

try {
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get all attractions with their IDs
    $stmt = $pdo->query("SELECT id, name, location, is_top_destination FROM attractions ORDER BY id");
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        "success" => true,
        "total_attractions" => count($attractions),
        "attractions" => $attractions
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
