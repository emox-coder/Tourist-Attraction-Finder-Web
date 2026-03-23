<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once '../config/database.php';

class AuthAPI {
    private $db;
    
    public function __construct() {
        $this->db = new Database();
    }
    
    public function register($data) {
        $fullname = trim($data['fullname']);
        $email = trim($data['email']);
        $password = $data['password'];
        
        // Validation
        if (empty($fullname) || empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'All fields are required'];
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['success' => false, 'message' => 'Invalid email format'];
        }
        
        if (strlen($password) < 6) {
            return ['success' => false, 'message' => 'Password must be at least 6 characters'];
        }
        
        try {
            // Check if email already exists
            $conn = $this->db->getConnection();
            $check_sql = "SELECT id FROM users WHERE email = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->bind_param("s", $email);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                return ['success' => false, 'message' => 'Email already exists'];
            }
            
            // Hash password and create user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_sql = "INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $fullname, $email, $hashed_password);
            
            if ($insert_stmt->execute()) {
                return ['success' => true, 'message' => 'Registration successful!'];
            } else {
                $error = $insert_stmt->error;
                return ['success' => false, 'message' => 'Registration failed: ' . $error];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Database error: ' . $e->getMessage()];
        }
    }
    
    public function login($data) {
        $email = trim($data['email']);
        $password = $data['password'];
        
        // Validation
        if (empty($email) || empty($password)) {
            return ['success' => false, 'message' => 'Email and password are required'];
        }
        
        $conn = $this->db->getConnection();
        $sql = "SELECT id, fullname, email, password FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 0) {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
        
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['fullname'];
            $_SESSION['user_email'] = $user['email'];
            
            return [
                'success' => true, 
                'message' => 'Login successful!',
                'user' => [
                    'id' => $user['id'],
                    'name' => $user['fullname'],
                    'email' => $user['email']
                ]
            ];
        } else {
            return ['success' => false, 'message' => 'Invalid email or password'];
        }
    }
    
    public function logout() {
        session_start();
        session_destroy();
        return ['success' => true, 'message' => 'Logged out successfully'];
    }
    
    public function isLoggedIn() {
        session_start();
        if (isset($_SESSION['user_id'])) {
            return [
                'success' => true,
                'user' => [
                    'id' => $_SESSION['user_id'],
                    'name' => $_SESSION['user_name'],
                    'email' => $_SESSION['user_email']
                ]
            ];
        }
        return ['success' => false, 'message' => 'Not logged in'];
    }
}

// Handle requests
$auth = new AuthAPI();

try {
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Invalid request']);
        exit;
    }
    
    $action = $input['action'] ?? '';
    
    switch ($action) {
        case 'register':
            echo json_encode($auth->register($input));
            break;
        case 'login':
            echo json_encode($auth->login($input));
            break;
        case 'logout':
            echo json_encode($auth->logout());
            break;
        case 'check':
            echo json_encode($auth->isLoggedIn());
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Server error: ' . $e->getMessage()]);
}
?>
