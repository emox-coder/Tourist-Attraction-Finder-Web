<?php
// Test the public API endpoint for landing page
header("Content-Type: application/json");

// Simulate the API call from landing page
$_GET['uri'] = '/api/top-destinations';

// Include the API file
include 'Backend/routes/api.php';
?>
