<?php
// Test delete endpoint
header("Content-Type: application/json");

// Simulate delete request
$_GET['uri'] = '/api/admin/attractions/1'; // Test deleting ID 1
$_SERVER['REQUEST_METHOD'] = 'DELETE';

// Include the API file
include 'Backend/routes/api.php';
?>
