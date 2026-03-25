<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: landing-page.php');
    exit();
}

$user = [
    'fullname' => $_SESSION['user_name'] ?? 'User',
    'email' => $_SESSION['user_email'] ?? 'user@example.com'
];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tourist Attraction Finder</title>
        <link rel="stylesheet" href="../assets/css/dashboard.css">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         
    </head>
<body>
    <div class="left-navigator">
        <h1>Sample Dashboard</h1>
        
        <!-- Profile Section -->
        <div class="profile-section">
            <div class="profile-info">
                <img src="../assets/img/user-icon.png" alt="Profile" class="profile-avatar">
                <div class="user-details">
                    <h3><?php echo htmlspecialchars($user['fullname']); ?></h3>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
        </div>
        
        <!-- Logout Button -->
        <div class="logout-section">
            <button class="logout-btn" onclick="handleLogout()">
                <i class="fas fa-sign-out-alt"></i>
                <span>Logout</span>
            </button>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../assets/js/auth.js"></script>
    <script>
        // Direct logout function
        function handleLogout() {
            if (confirm('Are you sure you want to logout?')) {
                // Direct API call for logout
                fetch('../api/auth.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ action: 'logout' })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        // Show success message and redirect
                        alert('Logged out successfully!');
                        window.location.href = 'landing-page.php';
                    } else {
                        alert('Logout failed');
                    }
                })
                .catch(error => {
                    console.error('Logout error:', error);
                    alert('Logout error');
                });
            }
        }
        
        // Fallback function
        function logout() {
            handleLogout();
        }
    </script>
</body>    
</html>