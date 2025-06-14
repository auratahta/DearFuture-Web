<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Mentor Portal') - DearFuture</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --bg: #131b31;
            --primary: #e4e4e4;
            --text: #70798b;
            --judul: #5af7ff;
            --accent: #ff6b6b;
            --success: #4caf50;
            --warning: #ff9800;
            --info: #2196f3;
            --mentor-primary: #7c3aed;
            --mentor-light: #a855f7;
            --mentor-dark: #5b21b6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            outline: none;
            border: none;
            text-decoration: none;
        }

        body {
            font-family: "Rubik", sans-serif;
            background-color: var(--bg);
            color: var(--primary);
            min-height: 100vh;
        }

        /* Navbar */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            padding: 1.4rem 7%;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999;
            border-bottom: 1px solid #a39b9b;
            background-color: #131b31;
            width: 100%;
        }

        .navbar .navbar-logo {
            font-size: 30px;
            font-family: "Krona One";
            font-weight: 400;
            color: var(--judul);
            text-decoration: none;
            text-shadow: 0px 4px 7px rgba(90, 247, 255, 0.25);
        }

        .navbar .navbar-nav a,
        .navbar .navbar-extra a {
            color: #fff;
            font-family: Rubik;
            font-size: 17px;
            font-weight: 400;
            margin: 0 1.5rem;
            text-decoration: none;
        }

        .navbar .navbar-nav a:hover,
        .navbar .navbar-extra a:hover {
            color: var(--judul);
            transition: 0.1s;
        }

        .navbar .navbar-extra .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .navbar .navbar-extra {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .navbar .navbar-extra .user-name {
            color: #fff;
            margin-right: 10px;
            font-family: "Krona One", sans-serif;
        }

        /* User profile in navbar */
        .navbar .navbar-extra {
            display: flex;
            align-items: center;
        }

        .navbar .navbar-extra .user-name {
            color: #fff;
            margin-right: 10px;
            font-family: "Krona One", "Rubik";
        }

        .navbar .navbar-extra .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* Mobile Menu Toggle */
        .mobile-menu-toggle {
            display: none;
            flex-direction: column;
            cursor: pointer;
            gap: 4px;
        }

        .mobile-menu-toggle span {
            width: 25px;
            height: 3px;
            background-color: var(--mentor-light);
            transition: 0.3s;
        }

        /* Main Container */
        .main-container {
            margin-top: 80px;
            min-height: calc(100vh - 80px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Page Header */
        .page-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px 0;
        }

        .page-header h1 {
            font-size: 32px;
            color: white;
            margin-bottom: 10px;
        }

        .page-header p {
            color: var(--text);
            font-size: 16px;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        /* Mentor-specific Cards */
        .mentor-card {
            background: linear-gradient(135deg, var(--mentor-primary), var(--mentor-light));
            color: white;
            border: none;
        }

        .mentor-card h3 {
            color: white;
        }

        .mentor-card p {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Buttons */
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }

        .btn-mentor {
            background-color: var(--mentor-primary);
            color: white;
        }

        .btn-mentor:hover {
            background-color: var(--mentor-dark);
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: var(--judul);
            color: var(--bg);
        }

        .btn-primary:hover {
            background-color: #4ddee6;
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-danger {
            background-color: var(--accent);
            color: white;
        }

        .btn-danger:hover {
            background-color: #e55a5a;
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #45a049;
        }

        .btn-warning {
            background-color: var(--warning);
            color: white;
        }

        .btn-warning:hover {
            background-color: #e68900;
        }

        /* Status Badges */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.active {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info);
        }

        .status-badge.confirmed {
            background-color: rgba(124, 58, 237, 0.1);
            color: var(--mentor-primary);
        }

        .status-badge.completed {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .status-badge.cancelled {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--accent);
        }

        .status-badge.pending {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning);
        }

        .status-badge.ongoing {
            background-color: rgba(124, 58, 237, 0.2);
            color: var(--mentor-light);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card .stat-icon {
            font-size: 2.5rem;
            color: var(--mentor-primary);
            margin-bottom: 15px;
        }

        .stat-card .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 5px;
        }

        .stat-card .stat-label {
            color: #666;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Alerts */
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
            border: 1px solid rgba(76, 175, 80, 0.3);
        }

        .alert-danger {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--accent);
            border: 1px solid rgba(255, 107, 107, 0.3);
        }

        .alert-warning {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning);
            border: 1px solid rgba(255, 152, 0, 0.3);
        }

        .alert-info {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info);
            border: 1px solid rgba(33, 150, 243, 0.3);
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        .table th {
            background-color: var(--mentor-primary);
            color: white;
            font-weight: 600;
        }

        .table td {
            color: #666;
        }

        .table tr:hover {
            background-color: #f8f9fa;
        }

        /* Quick Actions */
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 30px;
        }

        .quick-action {
            background: linear-gradient(135deg, var(--mentor-primary), var(--mentor-light));
            color: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            transition: transform 0.3s;
        }

        .quick-action:hover {
            transform: translateY(-3px);
            color: white;
        }

        .quick-action i {
            font-size: 2rem;
            margin-bottom: 10px;
            display: block;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .navbar {
                padding: 1rem 5%;
            }

            .navbar .navbar-nav {
                position: fixed;
                top: 80px;
                left: -100%;
                width: 100%;
                height: calc(100vh - 80px);
                background-color: var(--bg);
                flex-direction: column;
                justify-content: flex-start;
                align-items: center;
                padding-top: 2rem;
                transition: left 0.3s;
                border-top: 1px solid #a39b9b;
            }

            .navbar .navbar-nav.active {
                left: 0;
            }

            .navbar .navbar-nav a {
                padding: 1rem;
                width: 80%;
                text-align: center;
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }

            .mobile-menu-toggle {
                display: flex;
            }

            .mobile-menu-toggle.active span:nth-child(1) {
                transform: rotate(45deg) translate(5px, 5px);
            }

            .mobile-menu-toggle.active span:nth-child(2) {
                opacity: 0;
            }

            .mobile-menu-toggle.active span:nth-child(3) {
                transform: rotate(-45deg) translate(7px, -6px);
            }

            .container {
                padding: 15px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            .navbar .navbar-extra .user-name {
                display: none;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
    
    @yield('styles')
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="{{ url('/mentor/dashboard') }}" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav" id="navbarNav">
            <a href="{{ url('/student/menu') }}">Home</a>
            <a href="{{ url('/student/history') }}">History</a>
        </div>
        
        <div class="navbar-extra" onclick="window.location.href='{{ route('student.profile') }}';" style="cursor: pointer;">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu-toggle" id="mobileMenuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <!-- Display Alerts -->
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if(session('warning'))
            <div class="container">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="container">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuToggle = document.getElementById('mobileMenuToggle');
            const navbarNav = document.getElementById('navbarNav');
            
            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', function() {
                    this.classList.toggle('active');
                    navbarNav.classList.toggle('active');
                });
            }

            // Close mobile menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!e.target.closest('.navbar')) {
                    mobileMenuToggle?.classList.remove('active');
                    navbarNav?.classList.remove('active');
                }
            });

            // Auto-hide alerts after 5 seconds
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            });

            // Loading states for buttons
            const buttons = document.querySelectorAll('.btn[href]:not([href="#"])');
            buttons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!this.classList.contains('no-loading')) {
                        const originalHTML = this.innerHTML;
                        this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
                        this.style.pointerEvents = 'none';
                        
                        setTimeout(() => {
                            this.innerHTML = originalHTML;
                            this.style.pointerEvents = 'auto';
                        }, 3000);
                    }
                });
            });

            // Set active navigation
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.navbar-nav a');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });
        });

        // Helper function for CSRF token
        function getCsrfToken() {
            return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        }

        // Helper function for AJAX requests
        function makeAjaxRequest(url, method = 'GET', data = {}) {
            const options = {
                method: method,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                }
            };

            if (method !== 'GET' && method !== 'HEAD') {
                options.headers['Content-Type'] = 'application/json';
                options.body = JSON.stringify(data);
            }

            return fetch(url, options);
        }

        // Real-time notifications (WebSocket or polling)
        function checkForUpdates() {
            // Implement real-time updates for mentor dashboard
            // This could check for new bookings, messages, etc.
        }

        // Auto-refresh for ongoing sessions
        setInterval(checkForUpdates, 30000); // Check every 30 seconds
    </script>
    
    @yield('scripts')
</body>
</html>