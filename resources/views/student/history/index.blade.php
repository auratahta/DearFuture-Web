<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DearFuture - History</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/history.css') }}">
    
    <style>
        /* Additional styles for dynamic content */
        .history-card {
            margin-bottom: 20px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .history-card:hover {
            transform: translateY(-5px);
        }
        
        .status-badge.confirmed {
            background: #28a745;
            color: white;
        }
        
        .status-badge.ongoing {
            background: #ffc107;
            color: #212529;
        }
        
        .status-badge.completed {
            background: #6c757d;
            color: white;
        }
        
        .status-badge.cancelled {
            background: #dc3545;
            color: white;
        }
        
        .no-sessions {
            text-align: center;
            padding: 60px 20px;
            color: #6c757d;
        }
        
        .no-sessions img {
            width: 120px;
            opacity: 0.5;
            margin-bottom: 20px;
        }
        
        .action-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        
        .meeting-link.disabled {
            color: #6c757d;
            pointer-events: none;
            text-decoration: none;
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
        
        .alert-info {
            background-color: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
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
        <!-- Main Content -->
        <div class="content-container">
            <!-- Page Header -->
            <div class="page-header">
                <h1>Your Learning History</h1>
                <p>Track your progress and revisit past sessions</p>
                
                <!-- Statistics Summary -->
                <div class="stats-summary" style="display: flex; gap: 20px; margin-top: 20px;">
                    <div class="stat-item">
                        <strong>{{ $sessions->total() }}</strong>
                        <span>Total Sessions</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ $sessions->where('status', 'completed')->count() }}</strong>
                        <span>Completed</span>
                    </div>
                    <div class="stat-item">
                        <strong>{{ $sessions->whereIn('status', ['confirmed', 'ongoing'])->count() }}</strong>
                        <span>Upcoming</span>
                    </div>
                </div>
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
            
            @if(session('info'))
                <div class="alert alert-info">
                    {{ session('info') }}
                </div>
            @endif
            
            <!-- History Cards -->
            <div class="history-cards">
                @forelse($sessions as $session)
                    <div class="history-card">
                        <div class="class-header">
                            <h2 class="class-title">{{ $session->subject->name ?? 'Subject Not Found' }}</h2>
                            <div class="mentor-name">{{ $session->mentor->name ?? 'Mentor Not Assigned' }}</div>
                        </div>
                        
                        <div class="class-details">
                            <div class="detail-row">
                                <div class="detail-item">
                                    <img src="{{ asset('image/money.png') }}" alt="Price" class="detail-icon">
                                    <span class="detail-text">
                                        @if($session->price)
                                            Rp{{ number_format($session->price, 0, ',', '.') }}
                                        @else
                                            Free
                                        @endif
                                    </span>
                                </div>
                                <div class="detail-item">
                                    <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="detail-icon">
                                    <span class="detail-text">
                                        {{ $session->date ? $session->date->format('l, d F Y') : 'Date TBA' }}
                                    </span>
                                </div>
                            </div>
                            <div class="detail-row">
                                <div class="detail-item">
                                    <img src="{{ asset('image/time.png') }}" alt="Time" class="detail-icon">
                                    <span class="detail-text">
                                        @if($session->start_time && $session->end_time)
                                            {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}
                                        @else
                                            Time TBA
                                        @endif
                                    </span>
                                </div>
                                <div class="detail-item link-item">
                                    <img src="{{ asset('image/link.png') }}" alt="Link" class="detail-icon">
                                    @if($session->meeting_link && in_array($session->status, ['confirmed', 'ongoing']))
                                        <a href="{{ $session->meeting_link }}" 
                                           class="meeting-link" 
                                           target="_blank"
                                           onclick="return confirm('Are you sure you want to join the meeting?')">
                                            Join Meeting
                                        </a>
                                    @elseif($session->meeting_link && $session->status == 'completed')
                                        <span class="meeting-link disabled">Meeting Ended</span>
                                    @else
                                        <span class="meeting-link disabled">Link Not Available</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer">
                            @switch($session->status)
                                @case('confirmed')
                                    <span class="status-badge confirmed">CONFIRMED</span>
                                    @if($session->meeting_link)
                                        <a href="{{ $session->meeting_link }}" 
                                           target="_blank" 
                                           class="action-btn"
                                           onclick="return confirm('Are you sure you want to join the meeting?')">
                                            Join Meeting
                                        </a>
                                    @else
                                        <button class="action-btn" disabled>Waiting for Meeting Link</button>
                                    @endif
                                    @break
                                    
                                @case('ongoing')
                                    <span class="status-badge ongoing">ONGOING</span>
                                    @if($session->meeting_link)
                                        <a href="{{ $session->meeting_link }}" 
                                           target="_blank" 
                                           class="action-btn"
                                           style="background: #28a745;">
                                            Join Now
                                        </a>
                                    @endif
                                    @break
                                    
                                @case('completed')
                                    <span class="status-badge completed">COMPLETED</span>
                                    <a href="{{ route('student.history.show', $session->id) }}" class="action-btn">
                                        View Details
                                    </a>
                                    @break
                                    
                                @case('cancelled')
                                    <span class="status-badge cancelled">CANCELLED</span>
                                    @break
                                    
                                @default
                                    <span class="status-badge">{{ strtoupper($session->status) }}</span>
                            @endswitch
                            
                            <!-- Additional Actions -->
                            <div style="margin-top: 10px;">
                                <a href="{{ route('student.history.show', $session->id) }}" 
                                   style="background: #6c757d; color: white; text-decoration: none; padding: 5px 10px; border-radius: 5px; font-size: 12px;">
                                    Details
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="no-sessions">
                        <img src="{{ asset('image/empty-history.png') }}" alt="No History" style="width: 120px; opacity: 0.5;">
                        <h3>No Sessions Found</h3>
                        <p>You haven't booked any sessions yet.</p>
                        <a href="{{ route('student.sessions.index') }}" class="action-btn" style="margin-top: 20px;">
                            Browse Sessions
                        </a>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            @if($sessions->hasPages())
                <div class="pagination">
                    @if($sessions->onFirstPage())
                        <span class="page-link disabled">← Previous</span>
                    @else
                        <a href="{{ $sessions->previousPageUrl() }}" class="page-link">← Previous</a>
                    @endif
                    
                    @foreach($sessions->getUrlRange(1, $sessions->lastPage()) as $page => $url)
                        @if($page == $sessions->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($sessions->hasMorePages())
                        <a href="{{ $sessions->nextPageUrl() }}" class="page-link next">Next →</a>
                    @else
                        <span class="page-link disabled">Next →</span>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Auto-refresh for ongoing sessions
        @if($sessions->where('status', 'ongoing')->count() > 0)
            setTimeout(function() {
                location.reload();
            }, 30000); // Refresh every 30 seconds if there are ongoing sessions
        @endif
    </script>
</body>
</html>