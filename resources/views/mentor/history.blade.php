<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Session History - DearFuture</title>
    
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

        .navbar .navbar-nav {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .navbar .navbar-nav a {
            color: #fff;
            font-family: Rubik;
            font-size: 17px;
            font-weight: 400;
            text-decoration: none;
            transition: color 0.3s;
            position: relative;
        }

        .navbar .navbar-nav a:hover,
        .navbar .navbar-nav a.active {
            color: var(--judul);
        }

        .navbar .navbar-nav a.active::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--judul);
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

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background-color: var(--mentor-primary);
        }

        .stat-card.success::before {
            background-color: var(--success);
        }

        .stat-card.info::before {
            background-color: var(--info);
        }

        .stat-card.warning::before {
            background-color: var(--warning);
        }

        .stat-card.secondary::before {
            background-color: #6c757d;
        }

        .stat-card.dark::before {
            background-color: #343a40;
        }

        .stat-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-text {
            flex: 1;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: var(--mentor-primary);
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .stat-card.success .stat-label {
            color: var(--success);
        }

        .stat-card.info .stat-label {
            color: var(--info);
        }

        .stat-card.warning .stat-label {
            color: var(--warning);
        }

        .stat-card.secondary .stat-label {
            color: #6c757d;
        }

        .stat-card.dark .stat-label {
            color: #343a40;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 0;
        }

        .stat-icon {
            font-size: 2rem;
            color: #e0e0e0;
            opacity: 0.8;
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

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #45a049;
        }

        .btn-sm {
            padding: 8px 16px;
            font-size: 12px;
        }

        .btn-outline-primary {
            background-color: transparent;
            color: var(--mentor-primary);
            border: 1px solid var(--mentor-primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--mentor-primary);
            color: white;
        }

        .btn-outline-secondary {
            background-color: transparent;
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .btn-outline-info {
            background-color: transparent;
            color: var(--info);
            border: 1px solid var(--info);
        }

        .btn-outline-info:hover {
            background-color: var(--info);
            color: white;
        }

        .btn-outline-success {
            background-color: transparent;
            color: var(--success);
            border: 1px solid var(--success);
        }

        .btn-outline-success:hover {
            background-color: var(--success);
            color: white;
        }

        /* Status Badges */
        .badge-secondary {
            background-color: #6c757d;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
        }

        .badge-warning {
            background-color: var(--warning);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
        }

        .badge-success {
            background-color: var(--success);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
        }

        .badge-info {
            background-color: var(--info);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
        }

        .badge-dark {
            background-color: #343a40;
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
        }

        .badge-danger {
            background-color: var(--accent);
            color: white;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
        }

        .badge-light {
            background-color: #f8f9fa;
            color: #6c757d;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
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

        /* Filter Form */
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        /* Form Controls */
        .form-control {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s, box-shadow 0.3s;
            background: white;
        }

        .form-control:focus {
            border-color: var(--mentor-primary);
            box-shadow: 0 0 0 0.2rem rgba(124, 58, 237, 0.25);
            outline: none;
        }

        .form-label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }

        /* Utilities */
        .text-primary {
            color: var(--mentor-primary) !important;
        }

        .text-success {
            color: var(--success) !important;
        }

        .text-info {
            color: var(--info) !important;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .font-weight-bold {
            font-weight: 600 !important;
        }

        .text-center {
            text-align: center;
        }

        .mb-3 {
            margin-bottom: 1rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .mt-4 {
            margin-top: 1.5rem;
        }

        .py-5 {
            padding-top: 3rem;
            padding-bottom: 3rem;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-center {
            justify-content: center;
        }

        .gap-2 {
            gap: 0.5rem;
        }

        .btn-group {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #6c757d;
        }

        .empty-state i {
            font-size: 4rem;
            color: #dee2e6;
            margin-bottom: 20px;
        }

        .empty-state h5 {
            color: #6c757d;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #999;
        }

        /* Modal Styles */
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1040;
        }

        .modal-dialog {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            max-width: 500px;
            width: 90%;
        }

        .modal-content {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--mentor-primary), var(--mentor-light));
            color: white;
            padding: 20px;
            border: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-body {
            padding: 30px;
        }

        .modal-footer {
            padding: 20px 30px;
            background: #f8f9fa;
            border: none;
            display: flex;
            gap: 10px;
            justify-content: flex-end;
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
                gap: 0;
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
                grid-template-columns: repeat(2, 1fr);
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }

            .btn-group {
                flex-direction: column;
            }

            .table-responsive {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ route('mentor.dashboard_mentor') }}">Home</a>
        </div>
        
        <div class="navbar-extra" onclick="window.location.href='{{ route('mentor.profile') }}';" style="cursor: pointer;">
        <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>

        <!-- Mobile Menu Toggle -->
        <div class="mobile-menu-toggle" id="mobileMenuToggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="main-container">
        <div class="container">
            <!-- Display Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ session('warning') }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- Page Header -->
            <div class="page-header">
                <h1>Session History</h1>
                <p>Manage and view your mentoring sessions</p>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-text">
                            <div class="stat-label">Total Sessions</div>
                            <div class="stat-number">{{ $stats['total_sessions'] }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-calendar"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-content">
                        <div class="stat-text">
                            <div class="stat-label">Completed</div>
                            <div class="stat-number">{{ $stats['completed_sessions'] }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card info">
                    <div class="stat-content">
                        <div class="stat-text">
                            <div class="stat-label">Upcoming</div>
                            <div class="stat-number">{{ $stats['upcoming_sessions'] }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-content">
                        <div class="stat-text">
                            <div class="stat-label">Available</div>
                            <div class="stat-number">{{ $stats['available_sessions'] }}</div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sessions List -->
            <div class="card">
                <h3><i class="fas fa-list"></i> Sessions ({{ $sessions->total() }} total)</h3>
                
                @if($sessions->count() > 0)
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Subject</th>
                                    <th>Student</th>
                                    <th>Date & Time</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Meeting Link</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sessions as $session)
                                    <tr>
                                        <td>
                                            <div class="font-weight-bold">{{ $session->subject->name }}</div>
                                            <small class="text-muted">{{ $session->subject->category }}</small>
                                        </td>
                                        <td>
                                            @if($session->student)
                                                <div class="font-weight-bold">{{ $session->student->name }}</div>
                                                <small class="text-muted">{{ $session->student->email }}</small>
                                            @else
                                                <span class="text-muted">No student booked</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">
                                                <i class="fas fa-calendar text-primary"></i>
                                                {{ \Carbon\Carbon::parse($session->date)->format('d M Y') }}
                                            </div>
                                            <div>
                                                <i class="fas fa-clock text-info"></i>
                                                {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - 
                                                {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="font-weight-bold">Rp {{ number_format($session->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td>
                                            @switch($session->status)
                                                @case('available')
                                                    <span class="badge-secondary">Available</span>
                                                    @break
                                                @case('booked')
                                                    <span class="badge-warning">Booked</span>
                                                    @break
                                                @case('confirmed')
                                                    <span class="badge-success">Confirmed</span>
                                                    @break
                                                @case('ongoing')
                                                    <span class="badge-info">Ongoing</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge-dark">Completed</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge-danger">Cancelled</span>
                                                    @break
                                                @default
                                                    <span class="badge-light">{{ ucfirst($session->status) }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @if($session->meeting_link)
                                                <a href="{{ $session->meeting_link }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-video"></i> Join Meeting
                                                </a>
                                            @else
                                                <span class="text-muted" style="font-size: 12px;">Meeting link will be provided by admin</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="/mentor/session/{{ $session->id }}" class="btn btn-outline-info btn-sm">
                                                    <i class="fas fa-eye"></i> Details
                                                </a>
                                                
                                                @if(in_array($session->status, ['confirmed', 'booked', 'ongoing']))
                                                    <a href="/mentor/session/{{ $session->id }}/complete" class="btn btn-outline-success btn-sm" 
                                                       onclick="return confirm('Are you sure you want to mark this session as completed?')">
                                                        <i class="fas fa-check"></i> Complete
                                                    </a>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $sessions->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-times"></i>
                        <h5>No sessions found</h5>
                        <p>Try adjusting your filters to see more results.</p>
                    </div>
                @endif
            </div>
        </div>
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

            // Auto-submit form when filter changes
            const filterSelect = document.getElementById('filter');
            if (filterSelect) {
                filterSelect.addEventListener('change', function() {
                    this.form.submit();
                });
            }

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
        });
    </script>
</body>
</html>