<?php
// Test the exact path the login form uses
echo "<h2>Testing LoginController Path</h2>";

// Test the backend path
$loginControllerPath = __DIR__ . '/Backend/app/Controllers/LoginController.php';
echo "<p>Looking for: $loginControllerPath</p>";

if (file_exists($loginControllerPath)) {
    echo "<p style='color: green;'>✓ LoginController.php exists</p>";
    
    // Try to include and test the database connection
    try {
        require_once $loginControllerPath;
        echo "<p style='color: green;'>✓ LoginController.php loaded successfully</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error loading LoginController: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ LoginController.php not found</p>";
}

// Test database connection directly
echo "<h2>Testing Database Connection</h2>";
try {
    $config = require __DIR__ . '/Backend/config/config.php';
    echo "<p style='color: green;'>✓ Config loaded</p>";
    
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
        
        $stmt = $pdo->query("SELECT COUNT(*) FROM admins");
        $count = $stmt->fetchColumn();
        echo "<p style='color: green;'>✓ Found $count admin account(s)</p>";
    } else {
        echo "<p style='color: red;'>✗ Admins table does not exist</p>";
    }
    
} catch (PDOException $e) {
    echo "<p style='color: red;'>✗ Database connection failed: " . $e->getMessage() . "</p>";
}

// Test the actual login endpoint
echo "<h2>Testing Login Endpoint</h2>";
$testData = ['email' => 'admin@example.com', 'password' => 'password123'];
$ch = curl_init('http://localhost/TAF/Backend/app/Controllers/LoginController.php');
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "<p>HTTP Status Code: $httpCode</p>";
echo "<p>Response: " . htmlspecialchars($response) . "</p>";

if ($httpCode == 200) {
    echo "<p style='color: green;'>✓ Login endpoint responding</p>";
} else {
    echo "<p style='color: red;'>✗ Login endpoint not responding (HTTP $httpCode)</p>";
}
?>
