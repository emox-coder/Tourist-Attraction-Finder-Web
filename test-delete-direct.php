<?php
// Test delete operation directly
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
    
    // Test delete operation
    $id = 1; // Test deleting ID 1
    $stmt = $pdo->prepare("DELETE FROM attractions WHERE id = ?");
    $result = $stmt->execute([$id]);
    
    echo json_encode([
        "success" => true,
        "message" => "Delete test successful",
        "affected_rows" => $stmt->rowCount()
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "debug" => "Database delete test failed"
    ]);
}
?>
