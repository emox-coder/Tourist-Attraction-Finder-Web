class AuthManager {
    constructor() {
        this.apiBase = '../api/auth.php';
        this.currentUser = null;
        this.checkAuthStatus();
    }

    async checkAuthStatus() {
        try {
            const response = await fetch(this.apiBase, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'check' })
            });
            
            const result = await response.json();
            if (result.success) {
                this.currentUser = result.user;
                this.updateUI(true);
            } else {
                this.updateUI(false);
            }
        } catch (error) {
            console.error('Auth check failed:', error);
            this.updateUI(false);
        }
    }

    async register(formData) {
        try {
            const response = await fetch(this.apiBase, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'register',
                    fullname: formData.get('fullname'),
                    email: formData.get('email'),
                    password: formData.get('password')
                })
            });

            const result = await response.json();
            
            if (result.success) {
                this.showMessage('success', result.message);
                // Clear form
                document.querySelector('.register-modal-form').reset();
                // Switch to login modal after successful registration
                setTimeout(() => {
                    document.getElementById('registerModal').style.display = 'none';
                    document.getElementById('loginModal').style.display = 'block';
                }, 1500);
            } else {
                this.showMessage('error', result.message);
            }
            
            return result;
        } catch (error) {
            console.error('Registration failed:', error);
            this.showMessage('error', 'Registration failed. Please try again.');
            return { success: false };
        }
    }

    async login(formData) {
        try {
            const response = await fetch(this.apiBase, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'login',
                    email: formData.get('email'),
                    password: formData.get('password')
                })
            });

            const result = await response.json();
            
            if (result.success) {
                this.currentUser = result.user;
                this.showMessage('success', result.message);
                this.updateUI(true);
                
                // Close modal and redirect to dashboard
                setTimeout(() => {
                    document.getElementById('loginModal').style.display = 'none';
                    document.body.style.overflow = 'auto';
                    window.location.href = 'dashboard.php';
                }, 1500);
            } else {
                this.showMessage('error', result.message);
            }
            
            return result;
        } catch (error) {
            console.error('Login failed:', error);
            this.showMessage('error', 'Login failed. Please try again.');
            return { success: false };
        }
    }

    async logout() {
        try {
            const response = await fetch(this.apiBase, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ action: 'logout' })
            });

            const result = await response.json();
            
            if (result.success) {
                this.currentUser = null;
                this.updateUI(false);
                
                // Show logout message and redirect immediately
                this.showMessage('success', result.message);
                setTimeout(() => {
                    window.location.href = 'landing-page.php';
                }, 500);
            }
            
            return result;
        } catch (error) {
            console.error('Logout failed:', error);
            return { success: false };
        }
    }

    updateUI(isLoggedIn) {
        const loginBtn = document.getElementById('loginModalBtn');
        
        if (isLoggedIn && this.currentUser) {
            loginBtn.textContent = `Welcome, ${this.currentUser.name}`;
            loginBtn.style.background = '#F2C94C';
            loginBtn.style.color = '#2B662E';
            
            // Add logout functionality
            loginBtn.onclick = (e) => {
                e.preventDefault();
                if (confirm('Do you want to logout?')) {
                    this.logout();
                }
            };
        } else {
            loginBtn.textContent = 'Log in';
            loginBtn.style.background = '';
            loginBtn.style.color = '';
            
            // Restore login modal functionality
            loginBtn.onclick = (e) => {
                e.preventDefault();
                document.getElementById('loginModal').style.display = 'block';
                document.body.style.overflow = 'hidden';
            };
        }
    }

    showMessage(type, message) {
        // Remove existing messages
        const existingMessage = document.querySelector('.auth-message');
        if (existingMessage) {
            existingMessage.remove();
        }

        // Create message element
        const messageDiv = document.createElement('div');
        messageDiv.className = `auth-message ${type}`;
        messageDiv.textContent = message;
        messageDiv.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
            max-width: 300px;
        `;

        if (type === 'success') {
            messageDiv.style.background = 'linear-gradient(135deg, #28a745, #20c997)';
        } else {
            messageDiv.style.background = 'linear-gradient(135deg, #dc3545, #c82333)';
        }

        document.body.appendChild(messageDiv);

        // Auto remove after 3 seconds
        setTimeout(() => {
            messageDiv.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => messageDiv.remove(), 300);
        }, 3000);
    }

    showWelcomeMessage() {
        if (this.currentUser) {
            this.showMessage('success', `Welcome back, ${this.currentUser.name}!`);
        }
    }

    validateForm(formType, formData) {
        const errors = [];
        
        if (formType === 'register') {
            const fullname = formData.get('fullname');
            const email = formData.get('email');
            const password = formData.get('password');
            
            if (!fullname || fullname.trim().length < 2) {
                errors.push('Full name must be at least 2 characters');
            }
            
            if (!email || !this.isValidEmail(email)) {
                errors.push('Please enter a valid email address');
            }
            
            if (!password || password.length < 6) {
                errors.push('Password must be at least 6 characters');
            }
            
            const agreeTerms = formData.get('terms');
            if (!agreeTerms) {
                errors.push('You must agree to the terms and conditions');
            }
        } else if (formType === 'login') {
            const email = formData.get('email');
            const password = formData.get('password');
            
            if (!email || !this.isValidEmail(email)) {
                errors.push('Please enter a valid email address');
            }
            
            if (!password) {
                errors.push('Password is required');
            }
        }
        
        return errors;
    }

    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
    
    .input-group.error input {
        border-color: #dc3545 !important;
    }
    
    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: block;
    }
`;
document.head.appendChild(style);

// Initialize auth manager
const authManager = new AuthManager();
