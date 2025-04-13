<!-- resources/views/admin/dashboard.blade.php -->
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
        
        .welcome-card {
            background: linear-gradient(135deg, #131b31 0%, #1a2342 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .welcome-card h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 10px;
            color: var(--primary-color);
        }
        
        .welcome-card p {
            font-size: 16px;
            color: var(--text-color);
            margin-bottom: 0;
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            font-size: 36px;
            margin-bottom: 15px;
            color: var(--primary-color);
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: white;
        }
        
        .stat-label {
            font-size: 14px;
            color: #a0a0a0;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
            overflow: hidden;
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
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: rgba(247, 194, 68, 0.2);
            color: #f7c244;
        }
        
        .status-confirmed {
            background-color: rgba(58, 191, 186, 0.2);
            color: #3abfba;
        }
        
        .status-completed {
            background-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
        }
        
        .status-canceled {
            background-color: rgba(231, 74, 59, 0.2);
            color: #e74a3b;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .stats-container {
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
        }
        
        @media (max-width: 576px) {
            .stats-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-brand">
            DearFuture
        </div>
        
        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="active">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.subjects.index') }}">
                    <i class="fas fa-book"></i>
                    <span>Subjects</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.sessions.index') }}">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Sessions</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.payments.index') }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Payments</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.news.index') }}">
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
        <!-- Welcome Card -->
        <div class="welcome-card">
            <h1>Welcome, {{ Auth::user()->name }}</h1>
            <p>Here's what's happening with DearFuture today.</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <div class="stat-value">{{ $totalStudents }}</div>
                <div class="stat-label">Students</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="stat-value">{{ $totalMentors }}</div>
                <div class="stat-label">Mentors</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-value">{{ $totalSessions }}</div>
                <div class="stat-label">Total Sessions</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="stat-value">{{ $pendingPayments }}</div>
                <div class="stat-label">Pending Payments</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="stat-value">{{ $totalSubjects }}</div>
                <div class="stat-label">Subjects</div>
            </div>
        </div>
        
        <!-- Recent Users -->
        <div class="card">
            <div class="card-header">
                <div>Recent Registrations</div>
                <a href="{{ route('admin.users.index') }}">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Registered</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->profile && $user->profile->photo ? asset('storage/' . $user->profile->photo) : 'https://via.placeholder.com/40' }}" alt="User" class="user-avatar">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role == 'mentor')
                                        <span class="badge bg-info">Mentor</span>
                                    @else
                                        <span class="badge bg-success">Student</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.index', $user->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.edit', $user->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Sessions -->
        <div class="card">
            <div class="card-header">
                <div>Recent Sessions</div>
                <a href="{{ route('admin.sessions.index') }}">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Student</th>
                                <th>Mentor</th>
                                <th>Subject</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSessions as $session)
                            <tr>
                                <td>#{{ $session->id }}</td>
                                <td>{{ $session->student->name }}</td>
                                <td>{{ $session->mentor->name }}</td>
                                <td>{{ $session->subject->name }}</td>
                                <td>{{ $session->date->format('d M Y') }}, {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}</td>
                                <td>
                                    @if($session->status == 'pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @elseif($session->status == 'confirmed')
                                        <span class="status-badge status-confirmed">Confirmed</span>
                                    @elseif($session->status == 'completed')
                                        <span class="status-badge status-completed">Completed</span>
                                    @else
                                        <span class="status-badge status-canceled">Canceled</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>