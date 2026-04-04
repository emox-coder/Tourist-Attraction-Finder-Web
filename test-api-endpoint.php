<?php
// Test API endpoint directly
header("Content-Type: application/json");

// Simulate the API call
$_GET['uri'] = '/api/admin/attractions';

// Include the API file
include 'Backend/routes/api.php';
?>
