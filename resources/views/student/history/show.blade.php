<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - Session Details</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    
    <style>
        .session-detail {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 20px;
        }
        
        .detail-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
        }
        
        .detail-section h3 {
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #007bff;
            padding-bottom: 5px;
        }
        
        .detail-item {
            margin-bottom: 10px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #666;
            display: inline-block;
            width: 120px;
        }
        
        .detail-value {
            color: #333;
        }
        
        .status-indicator {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
        }
        
        .status-confirmed {
            background: #28a745;
            color: white;
        }
        
        .status-ongoing {
            background: #ffc107;
            color: #212529;
        }
        
        .status-completed {
            background: #6c757d;
            color: white;
        }
        
        .status-cancelled {
            background: #dc3545;
            color: white;
        }
        
        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
        }
        
        .btn-success {
            background: #28a745;
            color: white;
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }
        
        .rating-section {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
        
        .rating-section h3 {
            color: #333;
        }
        
        .rating-section p {
            color: #333;
        }
        
        .stars {
            display: flex;
            gap: 5px;
            margin: 10px 0;
        }
        
        .star {
            font-size: 24px;
            color: #ddd;
            cursor: pointer;
        }
        
        .star.active {
            color: #ffc107;
        }
        
        .feedback-textarea {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            resize: vertical;
            min-height: 100px;
            font-family: inherit;
            color: #333;
        }
        
        .meeting-info {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .meeting-info h3 {
            color: white;
        }
        
        .meeting-info p {
            color: white;
        }
        
        .meeting-link {
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }
        
        .meeting-link a {
            color: white;
            font-weight: 600;
            text-decoration: none;
            word-break: break-all;
        }
        
        .back-button {
            margin-bottom: 20px;
        }
        
        /* Main page heading */
        .session-detail h1 {
            color: #333;
        }
        
        /* Session subtitle */
        .session-detail p {
            color: #666;
        }
        
        /* Student notes section */
        .detail-section p {
            color: #333;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .timeline {
            position: relative;
            padding-left: 30px;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #ddd;
        }
        
        .timeline-item {
            position: relative;
            margin-bottom: 25px;
        }
        
        .timeline-dot {
            position: absolute;
            left: -23px;
            top: 5px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #ddd;
        }
        
        .timeline-item.completed .timeline-dot {
            background: #28a745;
        }
        
        .timeline-item.current .timeline-dot {
            background: #ffc107;
            animation: pulse 2s infinite;
        }
        
        .timeline-item.cancelled .timeline-dot {
            background: #dc3545;
        }
        
        .timeline-content h4 {
            margin: 0 0 5px 0;
            font-size: 14px;
            font-weight: 600;
            color: #333;
        }
        
        .timeline-content p {
            margin: 0;
            font-size: 13px;
            color: #666;
        }
        
        /* Session Timeline heading */
        .session-detail h3 {
            color: #333;
        }
        
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            border-left: 4px solid;
        }
        
        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
        <div class="navbar-nav">
            <a href="{{ route('student.menu') }}">Home</a>
            <a href="{{ route('student.history.index') }}" class="active">History</a>
        </div>
        
        <div class="navbar-extra" onclick="window.location.href='{{ route('student.profile') }}';" style="cursor: pointer;">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->
    
    <div class="container">
        <div class="content-container">
            <!-- Back Button -->
            <div class="back-button">
                <a href="{{ route('student.history.index') }}" class="btn btn-secondary">
                    ← Back to History
                </a>
            </div>
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            <!-- Session Detail -->
            <div class="session-detail">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 20px;">
                    <div>
                        <h1>{{ $session->subject->name ?? 'Subject Not Found' }}</h1>
                        <p style="color: #666; font-size: 18px; margin: 5px 0;">
                            with {{ $session->mentor->name ?? 'Mentor Not Assigned' }}
                        </p>
                    </div>
                    <span class="status-indicator status-{{ $session->status }}">
                        {{ ucfirst($session->status) }}
                    </span>
                </div>
                
                <!-- Detail Grid -->
                <div class="detail-grid">
                    <!-- Session Information -->
                    <div class="detail-section">
                        <h3>Session Information</h3>
                        <div class="detail-item">
                            <span class="detail-label">Date:</span>
                            <span class="detail-value">
                                {{ $session->date ? $session->date->format('l, d F Y') : 'Date TBA' }}
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Time:</span>
                            <span class="detail-value">
                                @if($session->start_time && $session->end_time)
                                    {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}
                                @else
                                    Time TBA
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Duration:</span>
                            <span class="detail-value">
                                @if($session->start_time && $session->end_time)
                                    {{ $session->start_time->diffInMinutes($session->end_time) }} minutes
                                @else
                                    TBA
                                @endif
                            </span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Price:</span>
                            <span class="detail-value">
                                @if($session->price)
                                    Rp{{ number_format($session->price, 0, ',', '.') }}
                                @else
                                    Free
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <!-- Mentor Information -->
                    <div class="detail-section">
                        <h3>Mentor Information</h3>
                        <div class="detail-item">
                            <span class="detail-label">Name:</span>
                            <span class="detail-value">{{ $session->mentor->name ?? 'Not Assigned' }}</span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-label">Email:</span>
                            <span class="detail-value">{{ $session->mentor->email ?? 'Not Available' }}</span>
                        </div>
                        @if($session->mentor && $session->mentor->phone)
                            <div class="detail-item">
                                <span class="detail-label">Phone:</span>
                                <span class="detail-value">{{ $session->mentor->phone }}</span>
                            </div>
                        @endif
                        @if($session->mentor && $session->mentor->bio)
                            <div class="detail-item">
                                <span class="detail-label">Bio:</span>
                                <span class="detail-value">{{ Str::limit($session->mentor->bio, 100) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Meeting Information -->
                @if($session->meeting_link && in_array($session->status, ['confirmed', 'ongoing', 'completed']))
                    <div class="meeting-info">
                        <h3 style="margin: 0 0 10px 0;">
                            <i class="fas fa-video"></i> Meeting Information
                        </h3>
                        <p>Join your session using the link below:</p>
                        <div class="meeting-link">
                            @if(in_array($session->status, ['confirmed', 'ongoing']))
                                <a href="{{ $session->meeting_link }}" target="_blank" onclick="return confirm('Are you sure you want to join the meeting?')">
                                    {{ $session->meeting_link }}
                                </a>
                            @else
                                <span style="opacity: 0.7;">{{ $session->meeting_link }} (Meeting Ended)</span>
                            @endif
                        </div>
                        
                        @if($session->status === 'ongoing')
                            <p style="margin: 15px 0 0 0; font-weight: 600;">
                                🔴 Session is currently ongoing! Click the link above to join.
                            </p>
                        @elseif($session->status === 'confirmed' && $session->date >= now()->toDateString())
                            <p style="margin: 15px 0 0 0;">
                                📅 Session starts at {{ $session->start_time->format('H:i') }}. You can join 15 minutes before.
                            </p>
                        @endif
                    </div>
                @endif
                
                <!-- Student Notes -->
                @if($session->student_notes)
                    <div class="detail-section" style="margin-top: 20px;">
                        <h3>Your Notes</h3>
                        <p>{{ $session->student_notes }}</p>
                    </div>
                @endif
                
                <!-- Rating and Feedback Section -->
                @if($session->status === 'completed')
                    @if(!$session->rating)
                        <div class="rating-section">
                            <h3>Rate Your Session</h3>
                            <p>How was your session with {{ $session->mentor->name ?? 'your mentor' }}?</p>
                            
                            <form method="POST" action="{{ route('student.history.review', $session->id) }}">
                                @csrf
                                <div class="stars" id="rating">
                                    <span class="star" data-rating="1">★</span>
                                    <span class="star" data-rating="2">★</span>
                                    <span class="star" data-rating="3">★</span>
                                    <span class="star" data-rating="4">★</span>
                                    <span class="star" data-rating="5">★</span>
                                </div>
                                <input type="hidden" name="rating" id="rating-input" required>
                                
                                <textarea name="feedback" 
                                          class="feedback-textarea" 
                                          placeholder="Share your experience with this session..."
                                          rows="4"></textarea>
                                
                                <div style="margin-top: 15px;">
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="rating-section">
                            <h3>Your Review</h3>
                            <div class="stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="star {{ $i <= $session->rating ? 'active' : '' }}">★</span>
                                @endfor
                            </div>
                            @if($session->feedback)
                                <p style="margin-top: 15px; padding: 15px; background: white; border-radius: 8px; border: 1px solid #ddd; color: #333;">
                                    "{{ $session->feedback }}"
                                </p>
                            @endif
                            <p style="font-size: 14px; color: #666; margin-top: 10px;">
                                Reviewed on {{ $session->updated_at->format('d M Y, H:i') }}
                            </p>
                        </div>
                    @endif
                @endif
                
                <!-- Action Buttons -->
                <div class="action-buttons">
                    @switch($session->status)
                        @case('confirmed')
                            @if($session->meeting_link)
                                <a href="{{ $session->meeting_link }}" 
                                   target="_blank" 
                                   class="btn btn-success"
                                   onclick="return confirm('Are you sure you want to join the meeting?')">
                                    <i class="fas fa-video"></i> Join Meeting
                                </a>
                            @endif
                            @break
                            
                        @case('ongoing')
                            @if($session->meeting_link)
                                <a href="{{ $session->meeting_link }}" 
                                   target="_blank" 
                                   class="btn btn-success"
                                   style="animation: pulse 2s infinite;">
                                    <i class="fas fa-video"></i> Join Now - Session Ongoing!
                                </a>
                            @endif
                            @break
                            
                        @case('completed')
                            <a href="{{ route('student.sessions.index') }}" class="btn btn-primary">
                                <i class="fas fa-search"></i> Book Another Session
                            </a>
                            @break
                            
                        @case('cancelled')
                            <a href="{{ route('student.sessions.index') }}" class="btn btn-primary">
                                <i class="fas fa-search"></i> Find New Session
                            </a>
                            @break
                    @endswitch
                    
                    <!-- Download/Export Options -->
                    @if(in_array($session->status, ['completed', 'cancelled']))
                        <a href="{{ route('student.history.export', ['session' => $session->id]) }}" class="btn btn-secondary">
                            <i class="fas fa-download"></i> Download Summary
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Session Timeline -->
            <div class="session-detail">
                <h3>Session Timeline</h3>
                <div style="margin-top: 20px;">
                    <div class="timeline">
                        <div class="timeline-item completed">
                            <div class="timeline-dot"></div>
                            <div class="timeline-content">
                                <h4>Session Booked</h4>
                                <p>{{ $session->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        @if($session->status !== 'cancelled')
                            <div class="timeline-item {{ in_array($session->status, ['confirmed', 'ongoing', 'completed']) ? 'completed' : '' }}">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Session Confirmed</h4>
                                    <p>{{ $session->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($session->status === 'ongoing')
                            <div class="timeline-item current">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Session In Progress</h4>
                                    <p>Currently ongoing</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($session->status === 'completed')
                            <div class="timeline-item completed">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Session Completed</h4>
                                    <p>{{ $session->updated_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        @endif
                        
                        @if($session->status === 'cancelled')
                            <div class="timeline-item cancelled">
                                <div class="timeline-dot"></div>
                                <div class="timeline-content">
                                    <h4>Session Cancelled</h4>
                                    <p>{{ $session->cancelled_at ? $session->cancelled_at->format('d M Y, H:i') : $session->updated_at->format('d M Y, H:i') }}</p>
                                    @if($session->cancellation_reason)
                                        <p style="font-style: italic; color: #666;">Reason: {{ $session->cancellation_reason }}</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Rating stars functionality
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star[data-rating]');
            const ratingInput = document.getElementById('rating-input');
            
            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = parseInt(this.getAttribute('data-rating'));
                    ratingInput.value = rating;
                    
                    stars.forEach((s, index) => {
                        if (index < rating) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                });
            });
        });
        
        // Auto-refresh for ongoing sessions
        @if($session->status === 'ongoing')
            setTimeout(function() {
                location.reload();
            }, 30000); // Refresh every 30 seconds for ongoing sessions
        @endif
    </script>
</body>
</html>