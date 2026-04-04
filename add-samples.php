<?php
// Add sample attractions to test the system
header("Content-Type: application/json");

try {
    $config = require __DIR__ . '/Backend/config/config.php';
    $pdo = new PDO(
        "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
        $config['db']['user'],
        $config['db']['pass']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if table exists and has correct structure
    $stmt = $pdo->query("SHOW TABLES LIKE 'attractions'");
    if ($stmt->rowCount() === 0) {
        // Create table if it doesn't exist
        $pdo->exec("
            CREATE TABLE attractions (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                location VARCHAR(255) NOT NULL,
                description TEXT,
                category VARCHAR(100) NOT NULL,
                image_url VARCHAR(500) DEFAULT NULL,
                is_top_destination TINYINT(1) DEFAULT 0,
                display_order INT DEFAULT 0,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        ");
    }
    
    // Add sample attractions if table is empty
    $stmt = $pdo->query("SELECT COUNT(*) FROM attractions");
    $count = $stmt->fetchColumn();
    
    if ($count == 0) {
        // Insert sample data
        $sampleAttractions = [
            [
                'name' => 'Dakak Beach Resort',
                'location' => 'Dapitan City',
                'description' => 'A beautiful beach resort known for its pristine white sand and clear waters.',
                'category' => 'city',
                'image_url' => 'assets/img/destinations/dakak.jpg',
                'is_top_destination' => 1,
                'display_order' => 1
            ],
            [
                'name' => 'Alora Water Park',
                'location' => 'Dipolog City', 
                'description' => 'Family-friendly water park with exciting slides and pools.',
                'category' => 'city',
                'image_url' => 'assets/img/destinations/alora.jpg',
                'is_top_destination' => 1,
                'display_order' => 2
            ],
            [
                'name' => 'Rizal Shrine',
                'location' => 'Dapitan City',
                'description' => 'Historical site where national hero Dr. Jose Rizal was exiled.',
                'category' => 'city',
                'image_url' => 'assets/img/destinations/rizal_shrine.jpg',
                'is_top_destination' => 1,
                'display_order' => 3
            ],
            [
                'name' => 'Sicayab Beach',
                'location' => 'Dipolog City',
                'description' => 'Scenic beach perfect for swimming and sunset viewing.',
                'category' => 'city',
                'image_url' => 'assets/img/destinations/sicayab.jpg',
                'is_top_destination' => 1,
                'display_order' => 4
            ],
            [
                'name' => 'Linabo Peak',
                'location' => 'Dipolog City',
                'description' => 'Mountain peak offering panoramic views and hiking trails.',
                'category' => 'city',
                'image_url' => 'assets/img/destinations/linabo.jpg',
                'is_top_destination' => 1,
                'display_order' => 5
            ]
        ];
        
        $stmt = $pdo->prepare("
            INSERT INTO attractions (name, location, description, category, image_url, is_top_destination, display_order)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        foreach ($sampleAttractions as $attraction) {
            $stmt->execute([
                $attraction['name'],
                $attraction['location'],
                $attraction['description'],
                $attraction['category'],
                $attraction['image_url'],
                $attraction['is_top_destination'],
                $attraction['display_order']
            ]);
        }
        
        $newCount = $pdo->query("SELECT COUNT(*) FROM attractions")->fetchColumn();
        
        echo json_encode([
            "success" => true,
            "message" => "Sample attractions added successfully",
            "attractions_added" => count($sampleAttractions),
            "total_attractions" => $newCount
        ]);
    } else {
        echo json_encode([
            "success" => true,
            "message" => "Attractions already exist",
            "total_attractions" => $count
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
