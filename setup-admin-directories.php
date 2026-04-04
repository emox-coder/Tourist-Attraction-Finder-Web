<?php
// Create admin uploads directory for future admin-specific files
header("Content-Type: application/json");

$adminUploadDir = __DIR__ . '/assets/img/admin';
$logDir = __DIR__ . '/logs';

$created = [];

try {
    // Create admin uploads directory
    if (!is_dir($adminUploadDir)) {
        mkdir($adminUploadDir, 0755, true);
        $created[] = 'Admin uploads directory created';
    }
    
    // Create logs directory
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
        $created[] = 'Logs directory created';
    }
    
    // Create .gitkeep files to maintain directories
    if (!file_exists($adminUploadDir . '/.gitkeep')) {
        file_put_contents($adminUploadDir . '/.gitkeep', '');
        $created[] = 'Admin uploads .gitkeep created';
    }
    
    if (!file_exists($logDir . '/.gitkeep')) {
        file_put_contents($logDir . '/.gitkeep', '');
        $created[] = 'Logs .gitkeep created';
    }
    
    echo json_encode([
        "success" => true,
        "message" => "Admin directories are ready!",
        "created" => $created,
        "admin_upload_dir" => $adminUploadDir,
        "log_dir" => $logDir
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage()
    ]);
}
?>
