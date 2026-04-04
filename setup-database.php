<?php
/**
 * Database Setup Script for Tourist Attraction Finder
 * Run this script to create the database and tables
 */

echo "<h2>Database Setup</h2>";

// Database configuration
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'tourist_finder_db';

try {
    // Connect to MySQL without specifying database
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<p style='color: green;'>✓ Connected to MySQL server</p>";
    
    // Create database if not exists
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "<p style='color: green;'>✓ Database '$dbname' created or already exists</p>";
    
    // Select the database
    $pdo->exec("USE `$dbname`");
    
    // Create admins table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `admins` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `password` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "<p style='color: green;'>✓ Admins table created</p>";
    
    // Insert default admin if not exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins WHERE email = 'admin@example.com'");
    $stmt->execute();
    if ($stmt->fetchColumn() == 0) {
        $hashedPassword = password_hash('password123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");
        $stmt->execute(['admin@example.com', $hashedPassword]);
        echo "<p style='color: green;'>✓ Default admin account created</p>";
    } else {
        echo "<p style='color: blue;'>ℹ Default admin account already exists</p>";
    }
    
    // Create attractions table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS `attractions` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `location` VARCHAR(255) NOT NULL,
            `description` TEXT,
            `category` VARCHAR(100) NOT NULL,
            `image_url` VARCHAR(500) DEFAULT NULL,
            `is_top_destination` TINYINT(1) DEFAULT 0,
            `display_order` INT DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "<p style='color: green;'>✓ Attractions table created</p>";
    
    echo "<h3 style='color: green;'>✓ Database setup completed successfully!</h3>";
    echo "<p><strong>Default Login:</strong></p>";
    echo "<p>Email: admin@example.com</p>";
    echo "<p>Password: password123</p>";
    echo "<p><a href='admin/login.php'>Go to Admin Login</a></p>";
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    echo "<p>Please check your MySQL configuration and make sure it's running.</p>";
}
?>
