<?php
// all-cards.php — API endpoint

header('Content-Type: application/json');
include 'db.php';

// Query all cards
$sql = "SELECT id, name, location, image_url, recommended FROM cards";
$result = $conn->query($sql);

$cards = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Cast recommended to boolean
        $row['recommended'] = (bool)$row['recommended'];
        $cards[] = $row;
    }
}

// Return JSON
echo json_encode($cards);

$conn->close();
?>
