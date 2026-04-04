<?php
// Test the full delete chain
header("Content-Type: application/json");

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    require_once __DIR__ . '/Backend/Infrastructure/Database/Database.php';
    require_once __DIR__ . '/Backend/Infrastructure/Repositories/AttractionRepositoryImpl.php';
    require_once __DIR__ . '/Backend/app/UseCases/ManageAttraction.php';
    
    $id = 2; // Test deleting ID 2
    
    echo "Testing delete chain for ID: $id\n";
    
    // Test database connection
    $db = new Database();
    $conn = $db->connect();
    echo "Database connected\n";
    
    // Test repository
    $repo = new AttractionRepositoryImpl();
    echo "Repository created\n";
    
    // Test use case
    $useCase = new ManageAttraction();
    echo "Use case created\n";
    
    // Test delete
    $result = $useCase->delete($id);
    echo "Delete result: " . ($result ? 'true' : 'false') . "\n";
    
    echo json_encode([
        "success" => true,
        "message" => "Delete chain test successful",
        "result" => $result
    ]);
    
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "error" => $e->getMessage(),
        "trace" => $e->getTraceAsString()
    ]);
} catch (Error $e) {
    echo json_encode([
        "success" => false,
        "error" => "Fatal error: " . $e->getMessage(),
        "trace" => $e->getTraceAsString()
    ]);
}
?>
