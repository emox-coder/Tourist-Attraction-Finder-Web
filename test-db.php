<?php
// Test database connection
require_once 'Backend/config/config.php';
$config = require 'Backend/config/config.php';

echo "<h2>Database Connection Test</h2>";

try {
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✓ Database connection successful!</p>";
    
    // Check if admins table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'admins'");
    if ($stmt->rowCount() > 0) {
        echo "<p style='color: green;'>✓ Admins table exists</p>";
        
        // Check for admin accounts
        $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
        $count = $stmt->fetchColumn();
        echo "<p style='color: green;'>✓ Found $count admin account(s)</p>";
        
        // Show admin accounts (without passwords)
        $stmt = $pdo->query("SELECT id, email, created_at FROM admins");
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "<h3>Admin Accounts:</h3>";
        foreach ($admins as $admin) {
            echo "<p>ID: {$admin['id']}, Email: {$admin['email']}, Created: {$admin['created_at']}</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Admins table does not exist</p>";
        echo "<p>You need to run the database schema first.</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
    
    if (strpos($e->getMessage(), "Unknown database") !== false) {
        echo "<p style='color: orange;'>The database 'tourist_finder' doesn't exist. You need to create it first.</p>";
        echo "<p>Import the SQL file: Backend/database_schema.sql</p>";
    }
}
?>
