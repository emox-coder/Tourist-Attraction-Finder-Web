<?php
/**
 * Test Bootstrap File
 * Initialize testing environment
 */

// Define base path
if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

// Load configuration
require_once BASE_PATH . '/Backend/config/config.php';

// Set error reporting for tests
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload classes
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/Backend/app/Controllers/',
        BASE_PATH . '/Backend/app/Entities/',
        BASE_PATH . '/Backend/app/Repositories/',
        BASE_PATH . '/Backend/app/UseCases/',
        BASE_PATH . '/Backend/Infrastructure/Database/',
        BASE_PATH . '/Backend/Infrastructure/Repositories/',
        BASE_PATH . '/tests/Helpers/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Test configuration
define('TEST_DB_HOST', 'localhost');
define('TEST_DB_NAME', 'tourist_finder_db_test');
define('TEST_DB_USER', 'root');
define('TEST_DB_PASS', '');

// Helper functions
function getTestDbConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . TEST_DB_HOST . ";dbname=" . TEST_DB_NAME,
            TEST_DB_USER,
            TEST_DB_PASS
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        // Fallback to main database for testing
        $config = require BASE_PATH . '/Backend/config/config.php';
        $pdo = new PDO(
            "mysql:host={$config['db']['host']};dbname={$config['db']['dbname']}",
            $config['db']['user'],
            $config['db']['pass']
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}

echo "Test environment initialized.\n";