<?php
// Check and fix admin accounts table structure
header("Content-Type: application/json");

try {
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if admins table exists and has the right structure
    $stmt = $pdo->query("DESCRIBE admins");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $requiredColumns = ['id', 'username', 'email', 'password', 'role', 'created_at'];
    $existingColumns = array_column($columns, 'Field');
    
    $missingColumns = array_diff($requiredColumns, $existingColumns);
    
    if (!empty($missingColumns)) {
        // Add missing columns
        foreach ($missingColumns as $column) {
            if ($column === 'username') {
                $pdo->exec("ALTER TABLE admins ADD COLUMN username VARCHAR(50) AFTER id");
            } elseif ($column === 'role') {
                $pdo->exec("ALTER TABLE admins ADD COLUMN role VARCHAR(20) DEFAULT 'admin' AFTER password");
            } elseif ($column === 'created_at') {
                $pdo->exec("ALTER TABLE admins ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER role");
            }
        }
    }
    
    // Check if there are any admin accounts
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM admins");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result['count'] == 0) {
        // Create a default admin account if none exists
        $defaultPassword = password_hash('admin123', PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("INSERT INTO admins (username, email, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
        $stmt->execute(['admin', 'admin@taf.com', $defaultPassword, 'admin']);
    }
    
    echo json_encode([
        "success" => true,
        "message" => "Admin accounts table is ready!",
        "admin_count" => $result['count']
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
