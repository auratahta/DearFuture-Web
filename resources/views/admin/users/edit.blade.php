<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Edit User</title>
    
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
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background-color: #45d6e0;
            border-color: #45d6e0;
            color: #131b31;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(90, 247, 255, 0.3);
        }
        
        .btn-secondary {
            background-color: #2c3044;
            border-color: #2c3044;
            color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .btn-secondary:hover {
            background-color: #3a3e56;
            border-color: #3a3e56;
            color: var(--text-color);
            transform: translateY(-2px);
        }
        
        .btn-outline-light {
            color: var(--text-color);
            border-color: var(--text-color);
            transition: all 0.3s ease;
        }
        
        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--primary-color);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }
        
        .card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .form-container {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            margin-top: 30px;
        }
        
        .user-profile-container {
            flex: 1;
            min-width: 200px;
            text-align: center;
        }
        
        .user-form-container {
            flex: 2;
            min-width: 300px;
        }
        
        .form-group {
            margin-bottom: 20px;
            background-color: rgba(255, 255, 255, 0.03);
            padding: 15px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .form-group:hover {
            background-color: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }
        
        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 8px;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .form-control, .form-select {
            background-color: rgba(30, 33, 50, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            border-radius: 8px;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus, .form-select:focus {
            background-color: rgba(30, 33, 50, 0.9);
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(90, 247, 255, 0.25);
            color: #ffffff;
        }
        
        .form-control::placeholder {
            color: rgba(228, 228, 228, 0.5);
        }
        
        .form-check-input {
            background-color: rgba(30, 33, 50, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.2);
            width: 1.2rem;
            height: 1.2rem;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: var(--text-color);
            font-weight: 500;
            padding-left: 5px;
        }
        
        .nav-tabs {
            border-bottom-color: #2c3044;
        }
        
        .nav-tabs .nav-link {
            color: #a0a0a0;
            border: none;
            border-bottom: 2px solid transparent;
            background: transparent;
            font-weight: 500;
            padding: 12px 20px;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover {
            color: #e4e4e4;
            border-color: transparent;
            transform: translateY(-3px);
        }
        
        .nav-tabs .nav-link.active {
            color: #5af7ff;
            background-color: transparent;
            border-color: transparent;
            border-bottom: 2px solid #5af7ff;
            transform: translateY(-3px);
        }
        
        /* User profile photo */
        .user-profile-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto 20px;
            display: block;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }
        
        .user-profile-photo:hover {
            border-color: #ffffff;
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(90, 247, 255, 0.4);
        }
        
        .user-name {
            font-size: 28px;
            font-weight: 600;
            margin: 10px 0;
            color: #ffffff;
        }
        
        .photo-upload-container {
            position: relative;
            margin-bottom: 30px;
        }
        
        .photo-upload-btn {
            position: absolute;
            bottom: 0;
            right: 50%;
            transform: translateX(75px);
            background-color: var(--primary-color);
            color: #131b31;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
        }
        
        .photo-upload-btn:hover {
            background-color: #ffffff;
            transform: translateX(75px) scale(1.1);
        }
        
        .badge-role {
            padding: 8px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
            margin-top: 10px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        
        .badge-role:hover {
            transform: scale(1.05);
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
        
        .form-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }
        
        .form-buttons .btn {
            min-width: 150px;
            padding: 12px 20px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .form-buttons .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-color: #1cc88a;
            color: #1cc88a;
            border-radius: 8px;
        }
        
        .invalid-feedback {
            color: #e74a3b;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .form-container {
                flex-direction: column;
            }
            
            .user-profile-container, 
            .user-form-container {
                width: 100%;
            }
            
            .photo-upload-btn {
                right: calc(50% - 75px);
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
            
            .form-buttons {
                flex-direction: column;
            }
            
            .form-buttons .btn {
                width: 100%;
            }
            
            .nav-tabs .nav-link {
                padding: 10px 12px;
                font-size: 14px;
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
           <h1 class="content-title">Edit User</h1>
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
                       <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basic" aria-selected="true">
                           <i class="fas fa-user me-2"></i>Basic Info
                       </button>
                   </li>
                   <li class="nav-item" role="presentation" id="student-tab-container" style="{{ $user->role == 'pelajar' ? 'display: block' : 'display: none' }}">
                       <button class="nav-link" id="student-tab" data-bs-toggle="tab" data-bs-target="#student" type="button" role="tab" aria-controls="student" aria-selected="false">
                           <i class="fas fa-graduation-cap me-2"></i>Personal Details
                       </button>
                   </li>
                   <li class="nav-item" role="presentation" id="mentor-tab-container" style="{{ $user->role == 'mentor' ? 'display: block' : 'display: none' }}">
                       <button class="nav-link" id="mentor-tab" data-bs-toggle="tab" data-bs-target="#mentor" type="button" role="tab" aria-controls="mentor" aria-selected="false">
                           <i class="fas fa-chalkboard-teacher me-2"></i>Mentor Info
                       </button>
                   </li>
               </ul>
           </div>
           <div class="card-body">
               <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                   @csrf
                   @method('PUT')
                   
                   <div class="tab-content" id="userTabsContent">
                       <!-- Basic Info Tab -->
                       <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                           <div class="form-container">
                               <!-- Left Side - Profile Photo -->
                               <div class="user-profile-container">
                                   <div class="photo-upload-container">
                                       <img src="{{ $user->photo ? asset('storage/' . $user->photo) : asset('image/profile.png') }}" alt="{{ $user->name }}" class="user-profile-photo" id="photoPreview">
                                       <label for="photo" class="photo-upload-btn">
                                           <i class="fas fa-camera"></i>
                                       </label>
                                       <input type="file" name="photo" id="photo" class="d-none" onchange="previewPhoto(this)">
                                   </div>
                                   
                                   <div class="form-group">
                                       <label for="role" class="form-label"><i class="fas fa-user-tag me-2"></i>Role</label>
                                       <select name="role" id="role" class="form-select @error('role') is-invalid @enderror">
                                           <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                           <option value="mentor" {{ $user->role == 'mentor' ? 'selected' : '' }}>Mentor</option>
                                           <option value="pelajar" {{ $user->role == 'pelajar' ? 'selected' : '' }}>Student</option>
                                       </select>
                                       @error('role')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <!-- Right Side - User Details Form -->
                               <div class="user-form-container">
                                   <div class="form-group">
                                       <label for="name" class="form-label"><i class="fas fa-user me-2"></i>Name</label>
                                       <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                       @error('name')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                                   
                                   <div class="form-group">
                                       <label for="email" class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                                       <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                       @error('email')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                                   
                                   <div class="form-group">
                                       <label for="phone" class="form-label"><i class="fas fa-phone me-2"></i>Phone Number</label>
                                       <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                       @error('phone')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                                   
                                   <div class="form-group">
                                       <label for="address" class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Address</label>
                                       <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                                       @error('address')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                                   
                                   <div class="form-group">
                                       <label for="password" class="form-label"><i class="fas fa-lock me-2"></i>Password (leave empty to keep current)</label>
                                       <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                       <small class="text-light">Only fill this if you want to change the password</small>
                                       @error('password')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                                   
                                   <div class="form-group">
                                       <label for="password_confirmation" class="form-label"><i class="fas fa-lock me-2"></i>Confirm Password</label>
                                       <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                   </div>
                               </div>
                           </div>
                       </div>
                       
                       <!-- Student Personal Details Tab -->
                       <div class="tab-pane fade" id="student" role="tabpanel" aria-labelledby="student-tab">
                           <div class="row mt-4">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="school" class="form-label"><i class="fas fa-school me-2"></i>School</label>
                                       <input type="text" class="form-control @error('school') is-invalid @enderror" id="school" name="school" value="{{ old('school', $user->school) }}">
                                       @error('school')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="birthdate" class="form-label"><i class="fas fa-birthday-cake me-2"></i>Birth Date</label>
                                       <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate', $user->birthdate) }}">
                                       @error('birthdate')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="parent_name" class="form-label"><i class="fas fa-user-friends me-2"></i>Parent's Name</label>
                                       <input type="text" class="form-control @error('parent_name') is-invalid @enderror" id="parent_name" name="parent_name" value="{{ old('parent_name', $user->parent_name) }}">
                                       @error('parent_name')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="parent_phone" class="form-label"><i class="fas fa-phone-alt me-2"></i>Parent's Phone</label>
                                       <input type="text" class="form-control @error('parent_phone') is-invalid @enderror" id="parent_phone" name="parent_phone" value="{{ old('parent_phone', $user->parent_phone) }}">
                                       @error('parent_phone')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                           </div>
                       </div>
                       
                       <!-- Mentor Tab -->
                       <div class="tab-pane fade" id="mentor" role="tabpanel" aria-labelledby="mentor-tab">
                           <div class="row mt-4">
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label for="hourly_rate" class="form-label"><i class="fas fa-money-bill-wave me-2"></i>Hourly Rate (Rp)</label>
                                       <input type="number" class="form-control @error('hourly_rate') is-invalid @enderror" id="hourly_rate" name="hourly_rate" value="{{ old('hourly_rate', $user->mentorProfile->hourly_rate ?? 0) }}">
                                       @error('hourly_rate')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-6">
                                   <div class="form-group">
                                       <label class="form-label"><i class="fas fa-check-circle me-2"></i>Status</label>
                                       <div class="form-check mt-2">
                                           <input type="checkbox" class="form-check-input" id="is_active" name="is_active" {{ old('is_active', $user->mentorProfile->is_active ?? false) ? 'checked' : '' }}>
                                           <label class="form-check-label" for="is_active">Active (Available for Mentoring)</label>
                                       </div>
                                       @error('is_active')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-12">
                                   <div class="form-group">
                                       <label for="bio" class="form-label"><i class="fas fa-info-circle me-2"></i>Bio</label>
                                       <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
                                       @error('bio')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-12">
                                   <div class="form-group">
                                       <label for="experience" class="form-label"><i class="fas fa-briefcase me-2"></i>Experience</label>
                                       <textarea class="form-control @error('experience') is-invalid @enderror" id="experience" name="experience" rows="3">{{ old('experience', $user->mentorProfile->experience ?? '') }}</textarea>
                                       @error('experience')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                               
                               <div class="col-md-12">
                                   <div class="form-group">
                                       <label for="education" class="form-label"><i class="fas fa-graduation-cap me-2"></i>Education</label>
                                       <textarea class="form-control @error('education') is-invalid @enderror" id="education" name="education" rows="3">{{ old('education', $user->mentorProfile->education ?? '') }}</textarea>
                                       @error('education')
                                           <div class="invalid-feedback">{{ $message }}</div>
                                       @enderror
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   
                   <div class="form-buttons">
                       <button type="submit" class="btn btn-primary">
                           <i class="fas fa-save me-2"></i> Save Changes

</button>
<a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-secondary">
   <i class="fas fa-times me-2"></i> Cancel
</a>
</div>
</form>
</div>
</div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

<script>
   // Function to preview photo before upload
   function previewPhoto(input) {
       if (input.files && input.files[0]) {
           const reader = new FileReader();
           
           reader.onload = function(e) {
               document.getElementById('photoPreview').src = e.target.result;
           }
           
           reader.readAsDataURL(input.files[0]);
       }
   }
   
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