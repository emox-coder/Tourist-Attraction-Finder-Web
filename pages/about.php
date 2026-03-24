<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Tourist Attraction Finder</title>
        <link rel="stylesheet" href="../assets/css/packages.css">
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
    <div class="background">
       <div data-aos="fade-down" data-aos-duration="1500" data-aos-delay="300" class="container">
            <div class="logo">
                <img src="../assets/img/logo.png">
            </div>
            <div class="search-home-container">
                <ul>
                    <a href="landing-page.php" class="nav-link">Home</a>
                    <a href="packages.php" class="nav-link">Packages</a>
                    <a href="community.php" class="nav-link">Community</a>
                    <a href="about.php" class="nav-link active">About</a>
                </ul>
            </div>
            <div class="signin-button">
                <a href="#" id="loginModalBtn">Log in</a>
            </div>
       </div>
     <!--header-->
        <div class="our-story-container">
                <div style="margin-left:200px;">
                    <h1>Our Story</h1>
                    <h3>From Lost Tourist to Travel Innovators, </h3>
                    <p style="margin-bottom:30px;">At Tourist Attraction Finder, our journey began<br>
                        with a shared passion for exploration beyond the<br>
                        typical tourist path.
                    </p>
                    <p>We saw a need for a resource that focused on<br>
                        authenticity, local connections, and hidden gems.
                    </p>
                </div>
                <div  class="logo-ver2-container">
                    <div style="position:absolute;
                        max-width:550px;;
                        left:30px;">
                        <img src="../assets/img/logo-ver2.png">
                    </div>
                </div>
        </div>






























































    
    <!-- Login Modal -->
    <div id="loginModal" class="login-modal">
        <div class="login-modal-content">
            <div class="login-modal-header">
                <span class="close-modal">&times;</span>
                <img src="../assets/img/logo.png" alt="Tourist Attraction Finder Logo" class="modal-logo">
                <h2>Sign In To Your Account</h2>
            </div>
            
            <form class="login-modal-form" id="loginForm">
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="options">
                    <label><input type="checkbox" name="remember"> Remember Me</label>
                    <a href="../pages/forgot-password.php">Forgot Password?</a>
                </div>

                <button type="submit" class="login-btn">Sign in</button>

                <p class="continue">Or continue with</p>

                <div class="social">
                    <i class="fab fa-google"></i>
                    <i class="fab fa-facebook-f"></i>
                </div>

                <p class="signup">
                    Don't have an account?
                    <a href="#" id="showRegisterModal">[Sign Up]</a>
                </p>
            </form>
        </div>
    </div>

    <!-- Register Modal -->
    <div id="registerModal" class="login-modal">
        <div class="register-modal-content">
            <div class="register-modal-header">
                <span class="close-register-modal">&times;</span>
                <img src="../assets/img/logo.png" alt="Tourist Attraction Finder Logo" class="modal-logo">
                <h2>Create Your Account</h2>
            </div>
            
            <form class="register-modal-form" id="registerForm">
                <div class="input-group">
                    <i class="fa fa-user"></i>
                    <input type="text" name="fullname" placeholder="Full Name" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-envelope"></i>
                    <input type="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="input-group">
                    <i class="fa fa-lock"></i>
                    <input type="password" name="password" placeholder="Password" required>
                </div>

                <div class="terms">
                    <label>
                        <input type="checkbox" name="terms" required>
                        I agree to the <span>Terms of Service</span> and <span>Privacy Policy</span>
                    </label>
                </div>

                <button type="submit" class="signup-btn">Sign Up</button>

                <p class="continue">Or continue with</p>

                <div class="social">
                    <i class="fab fa-google"></i>
                    <i class="fab fa-facebook-f"></i>
                </div>

                <p class="signin">
                    Already have an account?
                    <a href="#" id="showLoginModal">[Sign In]</a>
                </p>
            </form>
        </div>
    </div>


    <script src="../assets/js/app.js"></script>
    <script src="../assets/js/auth.js"></script>
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

    // Login and Register Modal Functionality
    const loginModal = document.getElementById('loginModal');
    const registerModal = document.getElementById('registerModal');
    const modalBtn = document.getElementById('loginModalBtn');
    const closeBtn = document.querySelector('.close-modal');
    const closeRegisterBtn = document.querySelector('.close-register-modal');
    const showRegisterModal = document.getElementById('showRegisterModal');
    const showLoginModal = document.getElementById('showLoginModal');

    // Form elements
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    // Open login modal when clicking login button
    modalBtn.addEventListener('click', function(e) {
        e.preventDefault();
        loginModal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    });

    // Close login modal when clicking X button
    closeBtn.addEventListener('click', function() {
        loginModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    // Close register modal when clicking X button
    closeRegisterBtn.addEventListener('click', function() {
        registerModal.style.display = 'none';
        document.body.style.overflow = 'auto';
    });

    // Switch from login to register modal
    showRegisterModal.addEventListener('click', function(e) {
        e.preventDefault();
        loginModal.style.display = 'none';
        registerModal.style.display = 'block';
    });

    // Switch from register to login modal
    showLoginModal.addEventListener('click', function(e) {
        e.preventDefault();
        registerModal.style.display = 'none';
        loginModal.style.display = 'block';
    });

    // Close modals when clicking outside
    window.addEventListener('click', function(e) {
        if (e.target === loginModal) {
            loginModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
        if (e.target === registerModal) {
            registerModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    });

    // Handle login form submission
    loginForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(loginForm);
        const errors = authManager.validateForm('login', formData);
        
        if (errors.length > 0) {
            authManager.showMessage('error', errors[0]);
            return;
        }
        
        // Disable submit button during processing
        const submitBtn = loginForm.querySelector('.login-btn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Signing in...';
        
        try {
            await authManager.login(formData);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });

    // Handle register form submission
    registerForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(registerForm);
        const errors = authManager.validateForm('register', formData);
        
        if (errors.length > 0) {
            authManager.showMessage('error', errors[0]);
            return;
        }
        
        // Disable submit button during processing
        const submitBtn = registerForm.querySelector('.signup-btn');
        const originalText = submitBtn.textContent;
        submitBtn.disabled = true;
        submitBtn.textContent = 'Creating account...';
        
        try {
            await authManager.register(formData);
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    });
    </script>
        

</body>    
</html>