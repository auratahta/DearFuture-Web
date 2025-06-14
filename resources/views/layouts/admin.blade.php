<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DearFuture</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #5af7ff;
            --secondary-color: #131b31;
            --text-color: #e4e4e4;
            --sidebar-width: 250px;
        }
        
        body {
            font-family: 'Rubik', sans-serif;
            background-color: #0d1339;
            color: var(--text-color);
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background-color: var(--secondary-color);
            min-height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px 0;
            color: var(--text-color);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 100;
        }
        
        .sidebar-brand {
            font-family: 'Krona One', sans-serif;
            font-size: 24px;
            color: var(--primary-color);
            text-align: center;
            padding: 15px 20px;
            margin-bottom: 30px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-menu {
            list-style: none;
            padding: 0;
        }
        
        .sidebar-menu li {
            margin-bottom: 5px;
        }
        
        .sidebar-menu a {
            display: block;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
            font-size: 16px;
        }
        
        .sidebar-menu a:hover, 
        .sidebar-menu a.active {
            background-color: rgba(90, 247, 255, 0.1);
            color: var(--primary-color);
            border-left: 4px solid var(--primary-color);
        }
        
        .sidebar-menu a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s;
        }
        
        .header-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        
        .header-container h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0;
        }
        
        .header-container .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #0d1339;
            font-weight: 500;
        }
        
        .header-container .btn-outline-primary {
            border-color: var(--primary-color);
            color: var(--primary-color);
        }
        
        .header-container .btn-outline-primary:hover {
            background-color: var(--primary-color);
            color: #0d1339;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
            border: none;
        }
        
        .card-header {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--primary-color);
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header a {
            color: var(--primary-color);
            font-size: 14px;
            text-decoration: none;
        }
        
        .card-header a:hover {
            text-decoration: underline;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
            border: 1px solid rgba(28, 200, 138, 0.3);
        }
        
        .table {
            color: var(--text-color);
        }
        
        .table th {
            border-top: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-weight: 600;
            padding: 12px 15px;
        }
        
        .table td {
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            padding: 12px 15px;
            vertical-align: middle;
        }
        
        .table tbody tr:hover {
            background-color: rgba(255, 255, 255, 0.05);
        }
        
        .user-avatar, .subject-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
        
        .btn-secondary {
            background-color: #858796;
            border-color: #858796;
        }
        
        .btn-info {
            background-color: #3abfba;
            border-color: #3abfba;
            color: white;
        }
        
        .btn-warning {
            background-color: #f7c244;
            border-color: #f7c244;
            color: white;
        }
        
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        
        .form-label {
            color: var(--primary-color);
            font-weight: 500;
        }
        
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            padding: 10px 15px;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
        }
        
        .text-muted {
            color: rgba(255, 255, 255, 0.5) !important;
        }
        
        /* Search bar and view toggle */
        .search-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .search-bar {
            position: relative;
            max-width: 300px;
            width: 100%;
        }
        
        .search-icon {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: #6c757d;
        }
        
        .search-bar input {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            padding-left: 40px;
            border-radius: 20px;
        }
        
        .search-bar input:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
        }
        
        .view-toggle {
            display: flex;
            gap: 10px;
        }
        
        .view-toggle .btn {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
        }
        
        .view-toggle .btn.active {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #0d1339;
        }
        
        /* Subject grid */
        .subject-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .subject-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .subject-card:hover {
            transform: translateY(-5px);
        }
        
        .subject-card img {
            height: 80px;
            width: auto;
            margin-bottom: 15px;
        }
        
        .subject-card .action-buttons {
            margin-top: 15px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        
        .action-btns {
            display: flex;
            gap: 5px;
        }
        
        .form-control-color {
            width: 100%;
            height: 38px;
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .subject-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 70px;
                overflow: hidden;
            }
            
            .sidebar-brand {
                font-size: 20px;
                padding: 15px 5px;
            }
            
            .sidebar-menu a span {
                display: none;
            }
            
            .sidebar-menu a i {
                margin-right: 0;
                font-size: 18px;
            }
            
            .main-content {
                margin-left: 70px;
            }
            
            .header-container {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .header-container h1 {
                margin-bottom: 15px;
            }
        }
        
        @media (max-width: 576px) {
            .subject-grid {
                grid-template-columns: 1fr;
            }
            
            .search-container {
                flex-direction: column;
                gap: 15px;
            }
            
            .search-bar {
                max-width: 100%;
            }
        }
    </style>
    
    @yield('styles')
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            DearFuture
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="{{ Request::routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.subjects.index') }}" class="{{ Request::routeIs('admin.subjects.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i>
                    <span>Subjects</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.sessions.index') }}" class="{{ Request::routeIs('admin.sessions.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Sessions</span>
                </a>
            </li>
            
            <li>
                <a href="{{ route('admin.news.index') }}" class="{{ Request::routeIs('admin.news.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>News</span>
                </a>
            </li>
            <li>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    @yield('scripts')
</body>
</html>