<?php
// Direct test of AdminController methods
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "Testing AdminController directly...\n";

try {
    // Include the required files
    require_once 'Backend/app/Controllers/AdminController.php';
    require_once 'Backend/app/UseCases/ManageAdmin.php';
    require_once 'Backend/Infrastructure/Repositories/AdminRepositoryImpl.php';
    
    echo "Files included: OK\n";
    
    // Test the controller directly
    $controller = new AdminController();
    echo "Controller created: OK\n";
    
    // Capture output
    ob_start();
    $controller->getAllAdmins();
    $output = ob_get_clean();
    
    echo "Controller output: " . $output . "\n";
    
    // Test the ManageAdmin directly
    $manageAdmin = new ManageAdmin();
    $admins = $manageAdmin->getAllAdmins();
    
    echo "ManageAdmin result: " . json_encode($admins) . "\n";
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
?>
