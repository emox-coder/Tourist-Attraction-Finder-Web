<?php
// Check current attractions and their image paths
header("Content-Type: application/json");

try {
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query("SELECT id, name, location, image_url FROM attractions ORDER BY id");
    $attractions = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Check if image files exist
    foreach ($attractions as &$attraction) {
        if ($attraction['image_url']) {
            $imagePath = __DIR__ . '/' . $attraction['image_url'];
            $attraction['image_exists'] = file_exists($imagePath);
            $attraction['full_path'] = $imagePath;
        }
    }
    
    echo json_encode([
        "success" => true,
        "attractions" => $attractions
    ], JSON_PRETTY_PRINT);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
