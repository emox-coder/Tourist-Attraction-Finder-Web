<?php
// Fix the admin username
header("Content-Type: application/json");

try {
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Update the admin username
    $stmt = $pdo->prepare("UPDATE admins SET username = 'admin' WHERE username IS NULL OR username = ''");
    $result = $stmt->execute();
    
    // Check the result
    $stmt = $pdo->prepare("SELECT id, username, email, role FROM admins");
    $stmt->execute();
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);
    
    echo json_encode([
        "success" => true,
        "message" => "Admin username fixed",
        "updated" => $result,
        "admin" => $admin
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
