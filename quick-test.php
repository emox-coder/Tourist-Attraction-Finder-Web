<?php
// Quick database test
try {
    $config = require 'Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "Database connection: SUCCESS\n";
    
    // Check admins table
    $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
    $count = $stmt->fetchColumn();
    echo "Admin accounts found: $count\n";
    
    if ($count > 0) {
        $stmt = $pdo->query("SELECT email FROM admins LIMIT 1");
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "Admin email: " . $admin['email'] . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
