<?php
// Debug admin accounts loading
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Testing admin API...\n";

try {
    // Test database connection
    $config = require 'Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection: OK\n";
    
    // Test admin query
    $stmt = $pdo->prepare("SELECT id, username, email, role, created_at FROM admins ORDER BY created_at DESC");
    $stmt->execute();
    $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Admin query: OK\n";
    echo "Found " . count($admins) . " admins\n";
    
    // Test ManageAdmin class
    require_once 'Backend/app/UseCases/ManageAdmin.php';
    $manageAdmin = new ManageAdmin();
    $allAdmins = $manageAdmin->getAllAdmins();
    
    echo "ManageAdmin class: OK\n";
    echo "ManageAdmin found " . count($allAdmins) . " admins\n";
    
    echo json_encode([
        "success" => true,
        "admins" => $allAdmins,
        "message" => "All tests passed"
    ]);
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "file" => $e->getFile(),
        "line" => $e->getLine()
    ]);
}
?>
