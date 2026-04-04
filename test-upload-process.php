<?php
// Test the upload process step by step
header("Content-Type: application/json");

// Simulate the upload process
if ($_FILES['image']) {
    $image = $_FILES['image'];
    
    $result = [
        "upload_error" => $image['error'],
        "upload_size" => $image['size'],
        "upload_tmp_name" => $image['tmp_name'],
        "upload_name" => $image['name'],
        "upload_type" => $image['type']
    ];
    
    // Test the upload logic
    $uploadDir = __DIR__ . '/assets/img/destinations/';
    $extension = pathinfo($image['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '_' . time() . '.' . $extension;
    $filepath = $uploadDir . $filename;
    
    $result['generated_filename'] = $filename;
    $result['filepath'] = $filepath;
    $result['relative_path'] = 'assets/img/destinations/' . $filename;
    $result['move_uploaded_file'] = move_uploaded_file($image['tmp_name'], $filepath);
    
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode(["error" => "No file uploaded"]);
}
?>
