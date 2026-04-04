<?php
// Test delete with actual record ID (ID 2 - Alora Water Park)
header("Content-Type: application/json");

try {
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Delete ID 2 (Alora Water Park)
    $id = 2;
    $stmt = $pdo->prepare("DELETE FROM attractions WHERE id = ?");
    $result = $stmt->execute([$id]);
    
    echo json_encode([
        "success" => true,
        "message" => "Deleted Alora Water Park (ID: $id)",
        "affected_rows" => $stmt->rowCount()
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
