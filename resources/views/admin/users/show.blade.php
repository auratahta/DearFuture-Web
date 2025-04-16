<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - User Details</title>
    
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
        
        .btn-secondary {
            background-color: #2c3044;
            border-color: #2c3044;
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background-color: #3a3e56;
            border-color: #3a3e56;
            color: var(--text-color);
        }
        
        .btn-outline-light {
            color: var(--text-color);
            border-color: var(--text-color);
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
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
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .info-item {
            margin-bottom: 20px;
        }
        
        .info-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        
        .info-value {
            color: var(--text-color);
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
        
        .nav-tabs {
            border-bottom-color: #2c3044;
        }
        
        .nav-tabs .nav-link {
            color: #a0a0a0;
            border: none;
            border-bottom: 2px solid transparent;
            background: transparent;
        }
        
        .nav-tabs .nav-link:hover {
            color: #e4e4e4;
            border-color: transparent;
        }
        
        .nav-tabs .nav-link.active {
            color: #5af7ff;
            background-color: transparent;
            border-color: transparent;
            border-bottom: 2px solid #5af7ff;
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
            <h1 class="content-title">User Details</h1>
            <div>
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit User
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light ms-2">
                    <i class="fas fa-arrow-left"></i> Back to Users
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Basic Info</button>
                    </li>
                    @if($user->role == 'pelajar')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">Personal Details</button>
                    </li>
                    @endif
                    @if($user->role == 'mentor')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="mentor-tab" data-bs-toggle="tab" data-bs-target="#mentor" type="button" role="tab" aria-controls="mentor" aria-selected="false">Mentor Info</button>
                    </li>
                    @endif
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="actions-tab" data-bs-toggle="tab" data-bs-target="#actions" type="button" role="tab" aria-controls="actions" aria-selected="false">Actions</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="userTabsContent">
                    <!-- Basic Info Tab -->
                    <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                        <div class="info-item">
                            <div class="info-label">Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Phone</div>
                            <div class="info-value">{{ $user->phone ?: 'Not provided' }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Role</div>
                            <div class="info-value">
                                @if($user->role == 'admin')
                                    <span class="badge badge-role badge-admin">Admin</span>
                                @elseif($user->role == 'mentor')
                                    <span class="badge badge-role badge-mentor">Mentor</span>
                                @else
                                    <span class="badge badge-role badge-pelajar">Student</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Registered On</div>
                            <div class="info-value">{{ $user->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Address</div>
                            <div class="info-value">{{ $user->address ?: 'Not provided' }}</div>
                        </div>
                        
                        @if($user->role == 'mentor')
                        <div class="info-item">
                            <div class="info-label">Bio</div>
                            <div class="info-value">{{ $user->bio ?: 'Not provided' }}</div>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Student Personal Details Tab -->
                    @if($user->role == 'pelajar')
                    <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                        <div class="info-item">
                            <div class="info-label">School</div>
                            <div class="info-value">{{ $user->school ?: 'Not provided' }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Birth Date</div>
                            <div class="info-value">
                                {{ $user->birthdate ? date('d M Y', strtotime($user->birthdate)) : 'Not provided' }}
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Parent's Name</div>
                            <div class="info-value">{{ $user->parent_name ?: 'Not provided' }}</div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Parent's Phone</div>
                            <div class="info-value">{{ $user->parent_phone ?: 'Not provided' }}</div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Mentor Tab -->
                    @if($user->role == 'mentor')
                    <div class="tab-pane fade" id="mentor" role="tabpanel" aria-labelledby="mentor-tab">
                        <div class="info-item">
                            <div class="info-label">Hourly Rate</div>
                            <div class="info-value">
                                Rp {{ number_format($user->mentorProfile->hourly_rate ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Experience</div>
                            <div class="info-value">
                                {{ $user->mentorProfile->experience ?? 'Not provided' }}
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Education</div>
                            <div class="info-value">
                                {{ $user->mentorProfile->education ?? 'Not provided' }}
                            </div>
                        </div>
                        
                        <div class="info-item">
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                @if(isset($user->mentorProfile) && $user->mentorProfile->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Actions Tab -->
                    <div class="tab-pane fade" id="actions" role="tabpanel" aria-labelledby="actions-tab">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary mb-3">
                                <i class="fas fa-edit me-1"></i> Edit User
                            </a>
                            
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-trash me-1"></i> Delete User
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>