<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Session Details - DearFuture</title>
    
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
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Page Header */
        .page-header {
            margin-bottom: 30px;
            padding: 20px 0;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .breadcrumb a {
            color: var(--text);
            text-decoration: none;
        }

        .breadcrumb a:hover {
            color: var(--judul);
        }

        .breadcrumb .separator {
            color: var(--text);
        }

        .breadcrumb .current {
            color: white;
            font-weight: 500;
        }

        .page-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
        }

        .page-title h1 {
            font-size: 28px;
            color: white;
            margin: 0;
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
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card p {
            color: #666;
            line-height: 1.6;
        }

        /* Status Badge */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.available {
            background-color: rgba(108, 117, 125, 0.1);
            color: #6c757d;
        }

        .status-badge.booked {
            background-color: rgba(255, 152, 0, 0.1);
            color: var(--warning);
        }

        .status-badge.confirmed {
            background-color: rgba(76, 175, 80, 0.1);
            color: var(--success);
        }

        .status-badge.ongoing {
            background-color: rgba(33, 150, 243, 0.1);
            color: var(--info);
            animation: pulse 2s infinite;
        }

        .status-badge.completed {
            background-color: rgba(52, 58, 64, 0.1);
            color: #343a40;
        }

        .status-badge.cancelled {
            background-color: rgba(255, 107, 107, 0.1);
            color: var(--accent);
        }

        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.7; }
            100% { opacity: 1; }
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid var(--mentor-primary);
        }

        .info-item.subject {
            border-left-color: var(--success);
        }

        .info-item.student {
            border-left-color: var(--info);
        }

        .info-item.schedule {
            border-left-color: var(--warning);
        }

        .info-item.price {
            border-left-color: var(--accent);
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 16px;
            font-weight: 500;
            color: #333;
            margin-bottom: 5px;
        }

        .info-detail {
            font-size: 14px;
            color: #666;
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

        .btn-outline-secondary {
            background-color: transparent;
            color: #6c757d;
            border: 1px solid #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Notes Section */
        .notes-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .notes-section h4 {
            color: #333;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .notes-content {
            color: #666;
            line-height: 1.6;
            font-style: italic;
        }

        .no-notes {
            color: #999;
            font-style: italic;
        }

        /* Meeting Link Section */
        .meeting-section {
            background: linear-gradient(135deg, var(--mentor-primary), var(--mentor-light));
            color: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .meeting-section h4 {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .meeting-link {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .meeting-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .no-meeting-link {
            color: rgba(255, 255, 255, 0.8);
            font-style: italic;
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

            .page-title {
                flex-direction: column;
                align-items: flex-start;
            }

            .page-title h1 {
                font-size: 24px;
            }

            .navbar .navbar-extra .user-name {
                display: none;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
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
                <!-- Breadcrumb -->
                <div class="breadcrumb">
                    <a href="{{ route('mentor.dashboard_mentor') }}">
                        <i class="fas fa-home"></i> Dashboard
                    </a>
                    <span class="separator">/</span>
                    <a href="{{ route('mentor.history') }}">History</a>
                    <span class="separator">/</span>
                    <span class="current">Session Details</span>
                </div>

                <!-- Page Title -->
                <div class="page-title">
                    <h1>Session Details</h1>
                    <div class="action-buttons">
                        <a href="{{ route('mentor.history') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Back to History
                        </a>
                        @if(in_array($session->status, ['confirmed', 'booked', 'ongoing']))
                            <a href="/mentor/session/{{ $session->id }}/complete" class="btn btn-success" 
                               onclick="return confirm('Are you sure you want to mark this session as completed?')">
                                <i class="fas fa-check"></i> Mark as Completed
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Session Status -->
            <div class="card">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3><i class="fas fa-info-circle"></i> Session Status</h3>
                    <span class="status-badge {{ strtolower($session->status) }}">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
                
                <div class="info-grid">
                    <div class="info-item subject">
                        <div class="info-label">Subject</div>
                        <div class="info-value">{{ $session->subject->name }}</div>
                        <div class="info-detail">{{ $session->subject->category }}</div>
                    </div>

                    <div class="info-item student">
                        <div class="info-label">Student</div>
                        @if($session->student)
                            <div class="info-value">{{ $session->student->name }}</div>
                            <div class="info-detail">{{ $session->student->email }}</div>
                        @else
                            <div class="info-value text-muted">No student assigned</div>
                            <div class="info-detail">Waiting for booking</div>
                        @endif
                    </div>

                    <div class="info-item schedule">
                        <div class="info-label">Schedule</div>
                        <div class="info-value">
                            {{ \Carbon\Carbon::parse($session->date)->format('l, d F Y') }}
                        </div>
                        <div class="info-detail">
                            {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - 
                            {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }} WIB
                        </div>
                    </div>

                    <div class="info-item price">
                        <div class="info-label">Session Price</div>
                        <div class="info-value">Rp {{ number_format($session->price, 0, ',', '.') }}</div>
                        <div class="info-detail">Per session</div>
                    </div>
                </div>
            </div>

            <!-- Meeting Information -->
            @if($session->meeting_link || in_array($session->status, ['confirmed', 'booked', 'ongoing']))
                <div class="meeting-section">
                    <h4><i class="fas fa-video"></i> Meeting Information</h4>
                    @if($session->meeting_link)
                        <p style="margin-bottom: 15px; opacity: 0.9;">
                            Your meeting link is ready. Click the button below to join the session.
                        </p>
                        <a href="{{ $session->meeting_link }}" target="_blank" class="meeting-link">
                            <i class="fas fa-external-link-alt"></i>
                            Join Meeting Now
                        </a>
                    @else
                        <p class="no-meeting-link">
                            <i class="fas fa-clock"></i>
                            Meeting link will be provided by admin before the session starts.
                        </p>
                    @endif
                </div>
            @endif

            <!-- Session Details -->
            <div class="card">
                <h3><i class="fas fa-calendar-alt"></i> Session Information</h3>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
                    <div>
                        <h5 style="color: #333; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 8px;">
                            <i class="fas fa-book"></i> Subject Details
                        </h5>
                        <div style="color: #333; margin-bottom: 10px;">
                            <strong>Subject:</strong> {{ $session->subject->name }}
                        </div>
                        <div style="color: #333; margin-bottom: 10px;">
                            <strong>Category:</strong> {{ $session->subject->category }}
                        </div>
                        @if($session->subject->description)
                            <div style="color: #333; margin-bottom: 10px;">
                                <strong>Description:</strong> {{ $session->subject->description }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <h5 style="color: #333; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 8px;">
                            <i class="fas fa-clock"></i> Time Details
                        </h5>
                        <div style="color: #333; margin-bottom: 10px;">
                            <strong>Date:</strong> {{ \Carbon\Carbon::parse($session->date)->format('l, d F Y') }}
                        </div>
                        <div style="color: #333; margin-bottom: 10px;">
                            <strong>Start Time:</strong> {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} WIB
                        </div>
                        <div style="color: #333; margin-bottom: 10px;">
                            <strong>End Time:</strong> {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }} WIB
                        </div>
                        <div style="color: #333; margin-bottom: 10px;">
                            <strong>Duration:</strong> 
                            {{ \Carbon\Carbon::parse($session->start_time)->diffInMinutes(\Carbon\Carbon::parse($session->end_time)) }} minutes
                        </div>
                    </div>
                </div>

                @if($session->student)
                    <div style="margin-top: 30px;">
                        <h5 style="color: #333; margin-bottom: 15px; border-bottom: 2px solid #eee; padding-bottom: 8px;">
                            <i class="fas fa-user-graduate"></i> Student Information
                        </h5>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                            <div>
                                <div style="color: #333; margin-bottom: 10px;">
                                    <strong>Name:</strong> {{ $session->student->name }}
                                </div>
                                <div style="color: #333; margin-bottom: 10px;">
                                    <strong>Email:</strong> {{ $session->student->email }}
                                </div>
                            </div>
                            <div>
                                @if($session->booked_at)
                                    <div style="color: #333; margin-bottom: 10px;">
                                        <strong>Booked At:</strong> 
                                        {{ \Carbon\Carbon::parse($session->booked_at)->format('d M Y, H:i') }} WIB
                                    </div>
                                @endif
                                @if($session->student->phone)
                                    <div style="color: #333; margin-bottom: 10px;">
                                        <strong>Phone:</strong> {{ $session->student->phone }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Session Notes -->
            @if($session->mentor_notes || $session->student_notes)
                <div class="card">
                    <h3><i class="fas fa-sticky-note"></i> Session Notes</h3>
                    
                    @if($session->mentor_notes)
                        <div class="notes-section">
                            <h4><i class="fas fa-user-tie"></i> Mentor Notes</h4>
                            <div class="notes-content">{{ $session->mentor_notes }}</div>
                        </div>
                    @endif

                    @if($session->student_notes)
                        <div class="notes-section" style="margin-top: 15px;">
                            <h4><i class="fas fa-user-graduate"></i> Student Notes</h4>
                            <div class="notes-content">{{ $session->student_notes }}</div>
                        </div>
                    @endif

                    @if(!$session->mentor_notes && !$session->student_notes)
                        <div class="no-notes">
                            <i class="fas fa-info-circle"></i>
                            No notes available for this session.
                        </div>
                    @endif
                </div>
            @endif

            <!-- Session History Timeline -->
            <div class="card">
                <h3><i class="fas fa-history"></i> Session Timeline</h3>
                
                <div style="position: relative; padding-left: 30px;">
                    <!-- Timeline line -->
                    <div style="position: absolute; left: 15px; top: 0; bottom: 0; width: 2px; background: #e9ecef;"></div>
                    
                    <!-- Session Created -->
                    <div style="position: relative; margin-bottom: 20px;">
                        <div style="position: absolute; left: -22px; top: 5px; width: 12px; height: 12px; background: var(--mentor-primary); border-radius: 50%;"></div>
                        <div style="font-weight: 600; color: #333; margin-bottom: 5px;">Session Created</div>
                        <div style="color: #666; font-size: 14px;">
                            {{ \Carbon\Carbon::parse($session->created_at)->format('d M Y, H:i') }} WIB
                        </div>
                    </div>

                    @if($session->booked_at)
                        <!-- Session Booked -->
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -22px; top: 5px; width: 12px; height: 12px; background: var(--warning); border-radius: 50%;"></div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 5px;">Session Booked</div>
                            <div style="color: #666; font-size: 14px;">
                                {{ \Carbon\Carbon::parse($session->booked_at)->format('d M Y, H:i') }} WIB
                            </div>
                            @if($session->student)
                                <div style="color: #666; font-size: 14px; margin-top: 3px;">
                                    by {{ $session->student->name }}
                                </div>
                            @endif
                        </div>
                    @endif

                    @if($session->status == 'confirmed')
                        <!-- Session Confirmed -->
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -22px; top: 5px; width: 12px; height: 12px; background: var(--success); border-radius: 50%;"></div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 5px;">Session Confirmed</div>
                            <div style="color: #666; font-size: 14px;">
                                Ready for meeting
                            </div>
                        </div>
                    @endif

                    @if($session->status == 'ongoing')
                        <!-- Session Ongoing -->
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -22px; top: 5px; width: 12px; height: 12px; background: var(--info); border-radius: 50%; animation: pulse 2s infinite;"></div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 5px;">Session in Progress</div>
                            <div style="color: #666; font-size: 14px;">
                                Currently ongoing
                            </div>
                        </div>
                    @endif

                    @if($session->status == 'completed')
                        <!-- Session Completed -->
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -22px; top: 5px; width: 12px; height: 12px; background: #343a40; border-radius: 50%;"></div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 5px;">Session Completed</div>
                            <div style="color: #666; font-size: 14px;">
                                @if($session->completed_at)
                                    {{ \Carbon\Carbon::parse($session->completed_at)->format('d M Y, H:i') }} WIB
                                @else
                                    Session marked as completed
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($session->status == 'cancelled')
                        <!-- Session Cancelled -->
                        <div style="position: relative; margin-bottom: 20px;">
                            <div style="position: absolute; left: -22px; top: 5px; width: 12px; height: 12px; background: var(--accent); border-radius: 50%;"></div>
                            <div style="font-weight: 600; color: #333; margin-bottom: 5px;">Session Cancelled</div>
                            <div style="color: #666; font-size: 14px;">
                                @if($session->cancelled_at)
                                    {{ \Carbon\Carbon::parse($session->cancelled_at)->format('d M Y, H:i') }} WIB
                                @else
                                    Session has been cancelled
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
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