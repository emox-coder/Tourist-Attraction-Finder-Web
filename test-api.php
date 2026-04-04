<?php
// Test API endpoint
header("Content-Type: application/json");

try {
    // Test database connection
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test if attractions table exists and has data
    $stmt = $pdo->query("SELECT COUNT(*) FROM attractions");
    $count = $stmt->fetchColumn();
    
    echo json_encode([
        "success" => true,
        "message" => "Database connection successful",
        "attractions_count" => $count,
        "database" => $config['db']['dbname']
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "debug" => "Database connection failed"
    ]);
}
?>
