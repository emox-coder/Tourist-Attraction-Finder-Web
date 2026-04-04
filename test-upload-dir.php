<?php
// Test image upload directory and paths
header("Content-Type: application/json");

$uploadDir = __DIR__ . '/assets/img/destinations/';

$result = [
    "upload_dir_exists" => file_exists($uploadDir),
    "upload_dir_writable" => is_writable($uploadDir),
    "upload_dir_path" => $uploadDir,
    "files_in_dir" => []
];

if (file_exists($uploadDir)) {
    $files = scandir($uploadDir);
    foreach ($files as $file) {
        if ($file !== '.' && $file !== '..') {
            $result['files_in_dir'][] = [
                'name' => $file,
                'size' => filesize($uploadDir . $file),
                'web_path' => 'assets/img/destinations/' . $file
            ];
        }
    }
}

echo json_encode($result, JSON_PRETTY_PRINT);
?>
