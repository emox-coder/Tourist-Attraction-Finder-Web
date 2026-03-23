<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../config/db.php';

try {
    $sql = "SELECT id, location, name, image_url FROM top_destinations ORDER BY id DESC";
    $result = $conn->query($sql);
    
    $destinations = [];
    
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $destinations[] = [
                'id' => $row['id'],
                'location' => $row['location'],
                'name' => $row['name'],
                'image_url' => $row['image_url']
            ];
        }
    }
    
    echo json_encode($destinations);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}

$conn->close();
?>
