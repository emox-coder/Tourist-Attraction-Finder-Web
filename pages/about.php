<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tourist Attraction Finder</title>
        <link rel="stylesheet" href="../assets/css/about.css">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
         
    </head>
<body>
    <!--header-->
    <div class="content-1">
       <div data-aos="fade-down" data-aos-duration="1500" data-aos-delay="300" class="container">
            <div class="logo">
                <img src="../assets/img/logo.png">
            </div>
            <div class="search-home-container">
                <ul>
                    <a href="landing-page.php" class="nav-link">Home</a>
                    <a href="packages.php" class="nav-link">Packages</a>
                    <a href="community.php" class="nav-link">Community</a>
                    <a href="about.php" class="nav-link-active">About</a>
                </ul>
            </div>
            <div class="signin-button">
                <a href="dashboard.php" id="loginModalBtn">Get Started</a>
            </div>
       </div>
       
       <div class="our-story">
            <div class="our-story-text">
                <h1>Our Story</h1>
                <h3>From Lost Tourist to Travel Innovators, </h3>
                <p style="margin-bottom:20px;">At Tourist Attraction Finder, our journey began<br>
                    with a shared passion for exploration beyond the<br>
                    typical tourist path.
                </p>
                <p>We saw a need for a resource that focused on<br>
                    authenticity, local connections, and hidden gems.
                </p>
            </div>
            <div class="logo-ver2">
                <img src="../assets/img/logo-ver2.png">
            </div>
       </div>
       
       <div class="our-mission">
            <div class="our-mission-background">
                <div class="our-mission-group">  
                    <img src="../assets/img/our-mission-.png">
                </div>
            </div>
        </div>
    </div>
    <!--header-->

    
   
    <script src="../assets/js/app.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
        document.querySelectorAll('.smooth-link').forEach(link => {
        link.addEventListener('click', function(e) {
        e.preventDefault(); 
        document.body.classList.add('fade-out');
        setTimeout(() => {
        window.location.href = this.href; 
        }, 500); 
    });
    });
</script>
    

</body>    
</html>