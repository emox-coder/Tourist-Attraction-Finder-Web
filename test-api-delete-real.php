<?php
// Test delete API with actual record ID
header("Content-Type: application/json");

// Test deleting ID 3 (Rizal Shrine)
$_GET['uri'] = '/api/admin/attractions/3';
$_SERVER['REQUEST_METHOD'] = 'DELETE';

// Include the API file
include 'Backend/routes/api.php';
?>
