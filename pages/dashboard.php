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
        <div class="navbar">
            <div>
                <img src="../assets/img/navbar-icon.png">
                <span>TAF NAVBAR</span>
            </div>
        </div>

        <div class="left-buttons">
            <div>
                <a>Search Spots</a>
                <img src="../assets/img/arrow-down.png">
            </div>
        </div>

        <div class="left-buttons">
            <div>
                <a>View Spots Details</a>
                <img src="../assets/img/arrow-down.png">
            </div>
        </div>

        <div class="left-buttons">
            <div>
                <a>Pinned</a>
            </div>
        </div>

        <div class="left-buttons">
            <div>
                <a>Ratings</a>
            </div>
        </div>

        <div class="left-buttons">
            <div>
                <a>Recommendation</a>
            </div>
        </div>

        <div>
            <a>SETTINGS</a>
        </div>

        <div>
            <a>Log out</a>
        </div>
       
    </div>
  
</body>    
</html>