<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Create User</title>
    
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
        
        .form-control, .form-select {
            background-color: #1e2132;
            border-color: #2c3044;
            color: #e4e4e4;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: #1e2132;
            border-color: #5af7ff;
            color: #e4e4e4;
            box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
        }
        
        .form-label {
            color: #e4e4e4;
            font-weight: 500;
        }
        
        .form-check-input {
            background-color: #1e2132;
            border-color: #2c3044;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
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
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-color: #1cc88a;
            color: #1cc88a;
        }
        
        .invalid-feedback {
            color: #e74a3b;
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
            <h1 class="content-title">Create New User</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-light">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
        
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="userTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">Basic Info</button>
                    </li>
                    <li class="nav-item" role="presentation" id="student-tab-container" style="display: none;">
                        <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">Personal Details</button>
                    </li>
                    <li class="nav-item" role="presentation" id="mentor-tab-container" style="display: none;">
                        <button class="nav-link" id="mentor-tab" data-bs-toggle="tab" data-bs-target="#mentor" type="button" role="tab" aria-controls="mentor" aria-selected="false">Mentor Info</button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="tab-content" id="userTabsContent">
                        <!-- Basic Info Tab -->
                        <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                                    <option value="" selected disabled>Select Role</option>
                                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                    <option value="mentor" {{ old('role') === 'mentor' ? 'selected' : '' }}>Mentor</option>
                                    <option value="pelajar" {{ old('role') === 'pelajar' ? 'selected' : '' }}>Student</option>
                                </select>
                                @error('role')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control" id="address" name="address" rows="3">{{ old('address') }}</textarea>
                            </div>
                        </div>
                        
                        <!-- Student Personal Details Tab -->
                        <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                            <div class="mb-3">
                                <label for="school" class="form-label">School</label>
                                <input type="text" class="form-control" id="school" name="school" value="{{ old('school') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birth Date</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ old('birthdate') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="parent_name" class="form-label">Parent's Name</label>
                                <input type="text" class="form-control" id="parent_name" name="parent_name" value="{{ old('parent_name') }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="parent_phone" class="form-label">Parent's Phone</label>
                                <input type="text" class="form-control" id="parent_phone" name="parent_phone" value="{{ old('parent_phone') }}">
                            </div>
                        </div>
                        
                        <!-- Mentor Tab -->
                        <div class="tab-pane fade" id="mentor" role="tabpanel" aria-labelledby="mentor-tab">
                            <div class="mb-3">
                                <label for="bio" class="form-label">Bio</label>
                                <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="hourly_rate" class="form-label">Hourly Rate (Rp)</label>
                                <input type="number" step="0.01" class="form-control" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', 0) }}">
                            </div>
                            
                            <div class="mb-3">
                                <label for="experience" class="form-label">Experience</label>
                                <textarea class="form-control" id="experience" name="experience" rows="3">{{ old('experience') }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="education" class="form-label">Education</label>
                                <textarea class="form-control" id="education" name="education" rows="3">{{ old('education') }}</textarea>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active (Available for Mentoring)</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Create User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ms-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Script to handle showing/hiding tabs based on role selection
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const studentTabContainer = document.getElementById('student-tab-container');
            const mentorTabContainer = document.getElementById('mentor-tab-container');
            
            // Function to update tab visibility
            function updateTabs() {
                const selectedRole = roleSelect.value;
                
                // Hide all role-specific tabs initially
                studentTabContainer.style.display = 'none';
                mentorTabContainer.style.display = 'none';
                
                // Show tab based on selected role
                if (selectedRole === 'pelajar') {
                    studentTabContainer.style.display = 'block';
                } else if (selectedRole === 'mentor') {
                    mentorTabContainer.style.display = 'block';
                }
                
                // Always reset to basic tab when role changes
                document.getElementById('basic-tab').click();
            }
            
            // Check initial state
            updateTabs();
            
            // Add change event listener
            roleSelect.addEventListener('change', updateTabs);
        });
    </script>
</body>
</html>