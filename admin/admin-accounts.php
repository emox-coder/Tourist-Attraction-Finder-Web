<?php
require_once 'includes/auth.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Account Management - TAF Admin</title>
    <link rel="stylesheet" href="../assets/css/landing-page.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .admin-layout {
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            color: white;
        }
        
        .sidebar-logo {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 30px;
        }
        
        .sidebar-logo img {
            width: 40px;
            height: 40px;
        }
        
        .sidebar-nav a {
            display: block;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: background 0.3s;
        }
        
        .sidebar-nav a:hover, .sidebar-nav a.active {
            background: rgba(255, 255, 255, 0.2);
        }
        
        .main-content {
            flex: 1;
            padding: 30px;
            background: #f5f5f5;
        }
        
        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .admin-user {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .logout-btn {
            padding: 8px 16px;
            background: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        
        .logout-btn:hover {
            background: #c82333;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .stat-card h3 {
            font-size: 28px;
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .stat-card p {
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .admin-card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }
        
        .table-container {
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        
        th {
            background: #f8f9fa;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .actions {
            display: flex;
            gap: 8px;
        }
        
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }
        
        .modal-overlay.show {
            display: flex;
        }
        
        .modal {
            background: white;
            padding: 30px;
            border-radius: 10px;
            max-width: 500px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
        }
        
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .modal-close {
            background: none;
            border: none;
            font-size: 24px;
            cursor: pointer;
            color: #666;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }
        
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
        }
        
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.2);
        }
        
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        
        .empty-state i {
            font-size: 48px;
            margin-bottom: 20px;
            color: #ddd;
        }
        
        .notification {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 15px 20px;
            border-radius: 6px;
            color: white;
            font-weight: 500;
            z-index: 2000;
            display: none;
        }
        
        .notification.show {
            display: block;
        }
        
        .notification.success {
            background: #28a745;
        }
        
        .notification.error {
            background: #dc3545;
        }
        
        .badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-success {
            background: #28a745;
            color: white;
        }
        
        .badge-warning {
            background: #ffc107;
            color: #212529;
        }
        
        .current-user {
            background: #e8f5e8;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            color: #28a745;
            font-weight: 500;
        }
        
        .password-strength {
            margin-top: 5px;
            font-size: 12px;
        }
        
        .strength-weak { color: #dc3545; }
        .strength-medium { color: #ffc107; }
        .strength-strong { color: #28a745; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-logo">
                <img src="../assets/img/logo.png" alt="TAF">
                <h2>TAF Admin</h2>
            </div>
            <nav class="sidebar-nav">
                <a href="top-destinations.php">
                    <i class="fas fa-star"></i>
                    Top Destinations
                </a>
                <a href="three-cards.php">
                    <i class="fas fa-th-large"></i>
                    Three Cards
                </a>
                <a href="attractions.php">
                    <i class="fas fa-map-marker-alt"></i>
                    All Attractions
                </a>
                <a href="admin-accounts.php" class="active">
                    <i class="fas fa-users-cog"></i>
                    Admin Accounts
                </a>
                <a href="../pages/landing-page.php" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    View Website
                </a>
            </nav>
        </aside>

        <main class="main-content">
            <div class="admin-header">
                <h1>Admin Account Management</h1>
                <div class="admin-user">
                    <span id="admin-email"><?php echo getAdminEmail(); ?></span>
                    <a href="logout.php" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        Logout
                    </a>
                </div>
            </div>

            <!-- Stats -->
            <div class="stats-grid">
                <div class="stat-card">
                    <h3 id="totalAdmins">0</h3>
                    <p>Total Admin Accounts</p>
                </div>
                <div class="stat-card">
                    <h3 id="activeAdmins">0</h3>
                    <p>Active Admins</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="admin-card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="color: #2c3e50;">Admin Accounts</h2>
                    <button class="btn btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        Add Admin Account
                    </button>
                </div>

                <div class="table-container">
                    <table id="adminsTable">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="adminsTableBody">
                            <!-- Data will be loaded here -->
                        </tbody>
                    </table>
                </div>

                <div id="emptyState" class="empty-state" style="display: none;">
                    <i class="fas fa-users-cog"></i>
                    <h3>No Admin Accounts Yet</h3>
                    <p>Add your first admin account to manage the system</p>
                    <button class="btn btn-primary" onclick="openAddModal()">
                        <i class="fas fa-plus"></i>
                        Add Your First Admin
                    </button>
                </div>
            </div>
        </main>
    </div>

    <!-- Add/Edit Modal -->
    <div class="modal-overlay" id="adminModal">
        <div class="modal">
            <div class="modal-header">
                <h2 id="modalTitle">Add New Admin Account</h2>
                <button class="modal-close" onclick="closeModal()">&times;</button>
            </div>

            <form id="adminForm">
                <input type="hidden" id="adminId" name="id">

                <div class="form-group">
                    <label for="username">Username *</label>
                    <input type="text" id="username" name="username" required placeholder="e.g., admin123" minlength="3">
                </div>

                <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" id="email" name="email" required placeholder="e.g., admin@example.com">
                </div>

                <div class="form-group" id="passwordGroup">
                    <label for="password">Password *</label>
                    <input type="password" id="password" name="password" required minlength="6" placeholder="Minimum 6 characters">
                    <div class="password-strength" id="passwordStrength"></div>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 6px;">
                        <option value="admin">Admin</option>
                        <option value="super_admin">Super Admin</option>
                    </select>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end; margin-top: 30px;">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()" style="background: #95a5a6; color: white;">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Save Admin Account
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal" style="max-width: 400px;">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
                <button class="modal-close" onclick="closeDeleteModal()">&times;</button>
            </div>
            <p style="color: #7f8c8d; margin-bottom: 20px;">Are you sure you want to delete this admin account? This action cannot be undone.</p>
            <input type="hidden" id="deleteId">
            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <button type="button" class="btn btn-secondary" onclick="closeDeleteModal()" style="background: #95a5a6; color: white;">
                    Cancel
                </button>
                <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                    <i class="fas fa-trash"></i>
                    Delete
                </button>
            </div>
        </div>
    </div>

    <!-- Notification -->
    <div class="notification" id="notification"></div>

    <script>
        // API Base URL
        const API_BASE = '../Backend/routes/api.php';

        // Current admin email (from PHP)
        const currentAdminEmail = '<?php echo getAdminEmail(); ?>';

        // Load admins on page load
        document.addEventListener('DOMContentLoaded', loadAdmins);

        // Form submission
        document.getElementById('adminForm').addEventListener('submit', handleFormSubmit);

        // Password strength checker
        document.getElementById('password').addEventListener('input', checkPasswordStrength);

        // Helper function for safe JSON parsing with BOM handling
        async function safeJSONParse(response) {
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const text = await response.text();
            const cleanText = text.replace(/^\uFEFF/, '').trim();
            
            try {
                return JSON.parse(cleanText);
            } catch (parseError) {
                console.error('JSON parse error:', parseError);
                console.error('Response text:', cleanText);
                throw new Error('Invalid server response: ' + cleanText.substring(0, 100));
            }
        }

        async function loadAdmins() {
            try {
                const response = await fetch(`${API_BASE}?uri=/api/admin/admins`);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const text = await response.text();
                const cleanText = text.replace(/^\uFEFF/, '').trim();
                const admins = JSON.parse(cleanText);

                updateStats(admins);
                renderTable(admins);
            } catch (error) {
                console.error('Error loading admins:', error);
                showNotification('Error loading admins: ' + error.message, 'error');
            }
        }

        function updateStats(admins) {
            document.getElementById('totalAdmins').textContent = admins.length;
            document.getElementById('activeAdmins').textContent = admins.length;
        }

        function renderTable(admins) {
            const tbody = document.getElementById('adminsTableBody');
            const emptyState = document.getElementById('emptyState');
            const table = document.getElementById('adminsTable');

            if (admins.length === 0) {
                table.style.display = 'none';
                emptyState.style.display = 'block';
                return;
            }

            table.style.display = 'table';
            emptyState.style.display = 'none';

            tbody.innerHTML = admins.map(admin => `
                <tr>
                    <td>
                        <strong>${admin.username}</strong>
                        ${admin.email === currentAdminEmail ? '<span class="current-user">YOU</span>' : ''}
                    </td>
                    <td>${admin.email}</td>
                    <td>
                        <span class="badge ${admin.role === 'super_admin' ? 'badge-warning' : 'badge-success'}">
                            ${admin.role === 'super_admin' ? 'Super Admin' : 'Admin'}
                        </span>
                    </td>
                    <td>
                        <span class="badge badge-success">Active</span>
                    </td>
                    <td>${new Date(admin.created_at).toLocaleDateString()}</td>
                    <td>
                        <div class="actions">
                            ${admin.email !== currentAdminEmail ? `
                                <button class="btn btn-sm btn-danger" onclick="openDeleteModal(${admin.id})">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            ` : `
                                <span style="color: #999; font-size: 12px;">Current User</span>
                            `}
                        </div>
                    </td>
                </tr>
            `).join('');
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Admin Account';
            document.getElementById('adminForm').reset();
            document.getElementById('adminId').value = '';
            document.getElementById('passwordGroup').style.display = 'block';
            document.getElementById('password').required = true;
            document.getElementById('adminModal').classList.add('show');
        }

        function closeModal() {
            document.getElementById('adminModal').classList.remove('show');
        }

        function openDeleteModal(id) {
            document.getElementById('deleteId').value = id;
            document.getElementById('deleteModal').classList.add('show');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.remove('show');
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthDiv = document.getElementById('passwordStrength');
            
            if (password.length === 0) {
                strengthDiv.innerHTML = '';
                return;
            }

            let strength = 0;
            if (password.length >= 6) strength++;
            if (password.length >= 10) strength++;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if (/[0-9]/.test(password)) strength++;
            if (/[^a-zA-Z0-9]/.test(password)) strength++;

            let strengthText = '';
            let strengthClass = '';

            if (strength <= 2) {
                strengthText = 'Weak password';
                strengthClass = 'strength-weak';
            } else if (strength <= 3) {
                strengthText = 'Medium strength';
                strengthClass = 'strength-medium';
            } else {
                strengthText = 'Strong password';
                strengthClass = 'strength-strong';
            }

            strengthDiv.innerHTML = `<span class="${strengthClass}">${strengthText}</span>`;
        }

        async function handleFormSubmit(e) {
            e.preventDefault();

            const formData = new FormData(e.target);
            const data = {
                username: formData.get('username'),
                email: formData.get('email'),
                password: formData.get('password'),
                role: formData.get('role')
            };

            const id = formData.get('id');
            const url = '../Backend/routes/api.php?uri=/api/admin/admins';
            const method = 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                });

                const result = await safeJSONParse(response);

                if (result.success) {
                    showNotification('Admin account added successfully', 'success');
                    closeModal();
                    loadAdmins();
                } else {
                    showNotification(result.message || 'Error saving admin account', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error saving admin account: ' + error.message, 'error');
            }
        }

        async function confirmDelete() {
            const id = document.getElementById('deleteId').value;

            try {
                const response = await fetch(`../Backend/routes/api.php?uri=/api/admin/admins/${id}`, {
                    method: 'DELETE'
                });
                
                const result = await safeJSONParse(response);
                
                if (result.success) {
                    showNotification('Admin account deleted successfully', 'success');
                    closeDeleteModal();
                    loadAdmins();
                } else {
                    showNotification(result.message || 'Error deleting admin account', 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Error deleting admin account: ' + error.message, 'error');
            }
        }

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.className = `notification ${type} show`;

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Close modals when clicking outside
        document.querySelectorAll('.modal-overlay').forEach(overlay => {
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    overlay.classList.remove('show');
                }
            });
        });
    </script>
</body>
</html>
