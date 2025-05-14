<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Users Management</title>
    
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
        
        .content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .content-title {
            font-size: 28px;
            font-weight: 600;
            color: var(--text-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #131b31;
            font-weight: 500;
        }
        
        .btn-primary:hover {
            background-color: #45d6e0;
            border-color: #45d6e0;
            color: #131b31;
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
        }
        
        .card-header {
            background-color: rgba(255, 255, 255, 0.05);
            color: var(--primary-color);
            font-weight: 600;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .form-select, .form-control {
            background-color: #1e2132;
            border-color: #2c3044;
            color: var(--text-color);
        }
        
        .form-select:focus, .form-control:focus {
            background-color: #1e2132;
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
        }
        
        .form-label {
            color: var(--text-color);
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
        
        .badge-role {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .badge-admin {
            background-color: rgba(231, 74, 59, 0.2);
            color: #e74a3b;
        }
        
        .badge-mentor {
            background-color: rgba(54, 185, 204, 0.2);
            color: #36b9cc;
        }
        
        .badge-pelajar {
            background-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
        }
        
        .btn-group .btn {
            padding: 5px 10px;
            font-size: 14px;
        }
        
        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
        }
        
        .btn-info:hover {
            background-color: #2c9faf;
            border-color: #2c9faf;
        }
        
        .btn-warning {
            background-color: #f6c23e;
            border-color: #f6c23e;
        }
        
        .btn-warning:hover {
            background-color: #dda20a;
            border-color: #dda20a;
        }
        
        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
        }
        
        .btn-danger:hover {
            background-color: #d52a1a;
            border-color: #d52a1a;
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-color: #1cc88a;
            color: #1cc88a;
        }
        
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        
        .pagination .page-item .page-link {
            background-color: #1e2132;
            border-color: #2c3044;
            color: var(--text-color);
        }
        
        .pagination .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #131b31;
        }
        
        .pagination .page-item .page-link:hover {
            background-color: rgba(90, 247, 255, 0.1);
            color: var(--primary-color);
        }
        
        /* User avatar specific styles */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
        }
        
        /* Responsive */
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
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.users.index') }}" class="active">
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
        <div class="content-header">
            <h1 class="content-title">Users Management</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New User
            </a>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('admin.users.index') }}" method="GET" class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="role" class="form-label">Filter by Role</label>
                        <select name="role" id="role" class="form-select" onchange="this.form.submit()">
                            <option value="all" {{ request('role') == 'all' ? 'selected' : '' }}>All Users</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                            <option value="mentor" {{ request('role') == 'mentor' ? 'selected' : '' }}>Mentors</option>
                            <option value="pelajar" {{ request('role') == 'pelajar' ? 'selected' : '' }}>Students</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Users Table -->
        <div class="card">
            <div class="card-header">
                <i class="fas fa-users me-1"></i>
                Users List
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('image/profile.png') }}" alt="User" class="user-avatar">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->role == 'admin')
                                        <span class="badge badge-role badge-admin">Admin</span>
                                    @elseif($user->role == 'mentor')
                                        <span class="badge badge-role badge-mentor">Mentor</span>
                                    @else
                                        <span class="badge badge-role badge-pelajar">Student</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">No users found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>