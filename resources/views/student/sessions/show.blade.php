@extends('layouts.student')

@section('title', 'Session Details - ' . $session->subject->name)

@section('styles')
<style>
    .session-detail-container {
        max-width: 1000px;
        margin: 0 auto;
    }
    
    .session-hero-card {
        background: linear-gradient(135deg, rgba(90, 247, 255, 0.2) 0%, rgba(90, 247, 255, 0.1) 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        border: 1px solid rgba(90, 247, 255, 0.3);
        position: relative;
        overflow: hidden;
    }
    
    .session-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--session-color, linear-gradient(90deg, var(--primary-color), var(--secondary-color)));
    }
    
    .session-hero-card.status-confirmed::before {
        background: linear-gradient(90deg, var(--success-color), #17a673);
    }
    
    .session-hero-card.status-pending::before {
        background: linear-gradient(90deg, var(--warning-color), #f1b91c);
    }
    
    .session-hero-card.status-completed::before {
        background: linear-gradient(90deg, var(--info-color), #2e9996);
    }
    
    .session-hero-card.status-cancelled::before {
        background: linear-gradient(90deg, var(--danger-color), #c82333);
    }
    
    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        gap: 20px;
    }
    
    .session-main-info {
        flex: 1;
    }
    
    .session-title {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    
    .subject-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: var(--dark-color);
    }
    
    .title-text h1 {
        color: white;
        font-weight: 700;
        font-size: 28px;
        margin: 0;
    }
    
    .title-text p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 16px;
    }
    
    .session-status-info {
        text-align: right;
    }
    
    .status-badge {
        padding: 10px 20px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 15px;
        display: inline-block;
    }
    
    .status-confirmed {
        background: rgba(28, 200, 138, 0.2);
        color: var(--success-color);
        border: 1px solid rgba(28, 200, 138, 0.3);
    }
    
    .status-pending {
        background: rgba(247, 194, 68, 0.2);
        color: var(--warning-color);
        border: 1px solid rgba(247, 194, 68, 0.3);
    }
    
    .status-completed {
        background: rgba(58, 191, 186, 0.2);
        color: var(--info-color);
        border: 1px solid rgba(58, 191, 186, 0.3);
    }
    
    .status-cancelled {
        background: rgba(231, 74, 59, 0.2);
        color: var(--danger-color);
        border: 1px solid rgba(231, 74, 59, 0.3);
    }
    
    .session-id {
        color: rgba(255, 255, 255, 0.5);
        font-family: 'Courier New', monospace;
        font-size: 14px;
    }
    
    .session-details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }
    
    .detail-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .detail-card:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
    }
    
    .detail-icon {
        font-size: 24px;
        color: var(--primary-color);
        margin-bottom: 12px;
    }
    
    .detail-label {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        margin-bottom: 8px;
        font-weight: 500;
    }
    
    .detail-value {
        color: white;
        font-weight: 600;
        font-size: 16px;
    }
    
    .countdown-card {
        background: rgba(90, 247, 255, 0.1);
        border: 1px solid rgba(90, 247, 255, 0.3);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        margin-bottom: 25px;
    }
    
    .countdown-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 15px;
        font-size: 18px;
    }
    
    .countdown-display {
        font-size: 32px;
        font-weight: 700;
        color: var(--primary-color);
        font-family: 'Courier New', monospace;
        margin-bottom: 10px;
    }
    
    .countdown-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
    }
    
    .mentor-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .mentor-header {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }
    
    .mentor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--primary-color);
    }
    
    .mentor-info h3 {
        color: white;
        font-weight: 700;
        margin-bottom: 5px;
    }
    
    .mentor-info p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 14px;
    }
    
    .mentor-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }
    
    .mentor-stat {
        text-align: center;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
    }
    
    .stat-number {
        font-size: 20px;
        font-weight: 700;
        color: var(--primary-color);
        display: block;
    }
    
    .stat-text {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        text-transform: uppercase;
    }
    
    .meeting-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .meeting-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
    }
    
    .meeting-header h4 {
        color: var(--primary-color);
        font-weight: 600;
        margin: 0;
    }
    
    .meeting-link-container {
        background: rgba(90, 247, 255, 0.1);
        border: 1px solid rgba(90, 247, 255, 0.3);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
    }
    
    .meeting-link {
        font-family: 'Courier New', monospace;
        color: var(--primary-color);
        word-break: break-all;
        background: rgba(255, 255, 255, 0.1);
        padding: 12px;
        border-radius: 6px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .meeting-link:hover {
        background: rgba(255, 255, 255, 0.15);
    }
    
    .meeting-instructions {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        line-height: 1.6;
    }
    
    .payment-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .payment-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    
    .payment-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .payment-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }
    
    .payment-icon.pending {
        background: rgba(247, 194, 68, 0.2);
        color: var(--warning-color);
    }
    
    .payment-icon.paid {
        background: rgba(28, 200, 138, 0.2);
        color: var(--success-color);
    }
    
    .payment-details h5 {
        color: white;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .payment-details p {
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        font-size: 14px;
    }
    
    .payment-amount {
        font-size: 20px;
        font-weight: 700;
        color: var(--success-color);
    }
    
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
        margin: 30px 0;
    }
    
    .btn-action {
        padding: 12px 24px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 16px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-width: 160px;
        justify-content: center;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--dark-color);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        color: var(--dark-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(90, 247, 255, 0.4);
    }
    
    .btn-success {
        background: var(--success-color);
        color: white;
    }
    
    .btn-success:hover {
        background: #17a673;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(28, 200, 138, 0.4);
    }
    
    .btn-warning {
        background: rgba(247, 194, 68, 0.2);
        color: var(--warning-color);
        border: 1px solid rgba(247, 194, 68, 0.3);
    }
    
    .btn-warning:hover {
        background: rgba(247, 194, 68, 0.3);
        color: var(--warning-color);
        border-color: var(--warning-color);
    }
    
    .btn-danger {
        background: rgba(231, 74, 59, 0.2);
        color: var(--danger-color);
        border: 1px solid rgba(231, 74, 59, 0.3);
    }
    
    .btn-danger:hover {
        background: rgba(231, 74, 59, 0.3);
        color: var(--danger-color);
        border-color: var(--danger-color);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
        border-color: var(--primary-color);
    }
    
    .session-notes {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
    }
    
    .notes-title {
        color: var(--primary-color);
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .notes-content {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        font-style: italic;
    }
    
    .rating-section {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 25px;
        text-align: center;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .rating-display {
        display: flex;
        justify-content: center;
        gap: 5px;
        margin: 15px 0;
    }
    
    .star {
        font-size: 24px;
        color: #ffc107;
    }
    
    .star.empty {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .feedback-text {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 8px;
        padding: 15px;
        color: rgba(255, 255, 255, 0.8);
        font-style: italic;
        margin-top: 15px;
    }
    
    @media (max-width: 768px) {
        .session-header {
            flex-direction: column;
            text-align: center;
        }
        
        .session-status-info {
            text-align: center;
        }
        
        .session-details-grid {
            grid-template-columns: 1fr 1fr;
        }
        
        .mentor-header {
            flex-direction: column;
            text-align: center;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-action {
            width: 100%;
        }
    }
    
    @media (max-width: 576px) {
        .session-details-grid {
            grid-template-columns: 1fr;
        }
        
        .mentor-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')
<div class="session-detail-container">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="{{ route('student.sessions.my-sessions') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i>
            Back to My Sessions
        </a>
    </div>

    <!-- Session Hero Card -->
    <div class="session-hero-card status-{{ $session->status }}">
        <div class="session-header">
            <div class="session-main-info">
                <div class="session-title">
                    <div class="subject-icon">
                        <i class="fas {{ $session->subject->icon ?? 'fa-book' }}"></i>
                    </div>
                    <div class="title-text">
                        <h1>{{ $session->subject->name }}</h1>
                        <p>Mentoring Session with {{ $session->mentor->name }}</p>
                    </div>
                </div>
            </div>
            <div class="session-status-info">
                <span class="status-badge status-{{ $session->status }}">
                    {{ $session->status_text }}
                </span>
                <div class="session-id">Session ID: #{{ $session->id }}</div>
            </div>
        </div>

        <!-- Session Details Grid -->
        <div class="session-details-grid">
            <div class="detail-card">
                <div class="detail-icon">
                    <i class="fas fa-calendar"></i>
                </div>
                <div class="detail-label">Date</div>
                <div class="detail-value">{{ $session->date ? $session->date->format('l, F j, Y') : 'N/A' }}</div>
            </div>
            <div class="detail-card">
                <div class="detail-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="detail-label">Time</div>
                <div class="detail-value">
                    {{ $session->start_time ? \Carbon\Carbon::parse($session->start_time)->format('H:i') : 'N/A' }} - 
                    {{ $session->end_time ? \Carbon\Carbon::parse($session->end_time)->format('H:i') : 'N/A' }}
                </div>
            </div>
            <div class="detail-card">
                <div class="detail-icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div class="detail-label">Duration</div>
                <div class="detail-value">{{ $session->duration_formatted ?? 'N/A' }}</div>
            </div>
            <div class="detail-card">
                <div class="detail-icon">
                    <i class="fas fa-coins"></i>
                </div>
                <div class="detail-label">Price</div>
                <div class="detail-value">{{ $session->formatted_price }}</div>
            </div>
        </div>
    </div>

    <!-- Countdown for Upcoming Sessions -->
    @if($session->is_upcoming && in_array($session->status, ['confirmed', 'ongoing']))
    <div class="countdown-card">
        <div class="countdown-title">
            {{ $session->status === 'ongoing' ? 'Session in Progress' : 'Session Starts In' }}
        </div>
        <div class="countdown-display" id="sessionCountdown" data-session-time="{{ $session->session_date_time ? $session->session_date_time->toISOString() : '' }}">
            {{ $session->time_remaining ?? 'Soon' }}
        </div>
        <div class="countdown-subtitle">
            Be ready to join 5 minutes before the scheduled time
        </div>
    </div>
    @endif

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <!-- Mentor Information -->
            <div class="mentor-card">
                <div class="mentor-header">
                    <img src="{{ $session->mentor->photo ?? asset('image/profile.png') }}" 
                         alt="{{ $session->mentor->name }}" 
                         class="mentor-avatar">
                    <div class="mentor-info">
                        <h3>{{ $session->mentor->name }}</h3>
                        <p>{{ $session->mentor->title ?? 'Expert Mentor' }}</p>
                        <p>{{ $session->mentor->bio ?? 'Experienced mentor ready to help you achieve your learning goals.' }}</p>
                    </div>
                </div>
                
                <div class="mentor-stats">
                    <div class="mentor-stat">
                        <span class="stat-number">{{ $session->mentor->completed_sessions_count ?? '10+' }}</span>
                        <div class="stat-text">Sessions</div>
                    </div>
                    <div class="mentor-stat">
                        <span class="stat-number">{{ $session->mentor->average_rating ?? '4.8' }}</span>
                        <div class="stat-text">Rating</div>
                    </div>
                    <div class="mentor-stat">
                        <span class="stat-number">{{ $session->mentor->experience_years ?? '5+' }}</span>
                        <div class="stat-text">Years Exp</div>
                    </div>
                    <div class="mentor-stat">
                        <span class="stat-number">{{ $session->mentor->students_count ?? '50+' }}</span>
                        <div class="stat-text">Students</div>
                    </div>
                </div>
            </div>

            <!-- Meeting Information -->
            @if($session->meeting_link && in_array($session->status, ['confirmed', 'ongoing', 'completed']))
            <div class="meeting-card">
                <div class="meeting-header">
                    <i class="fas fa-video"></i>
                    <h4>Meeting Information</h4>
                </div>
                
                <div class="meeting-link-container">
                    <div class="meeting-link" onclick="copyToClipboard('{{ $session->meeting_link }}')" title="Click to copy">
                        {{ $session->meeting_link }}
                    </div>
                    <button class="btn btn-sm btn-primary" onclick="copyToClipboard('{{ $session->meeting_link }}')">
                        <i class="fas fa-copy me-1"></i> Copy Link
                    </button>
                </div>
                
                <div class="meeting-instructions">
                    <strong>Meeting Instructions:</strong><br>
                    • Join the meeting 5 minutes before the scheduled time<br>
                    • Ensure you have a stable internet connection<br>
                    • Test your camera and microphone beforehand<br>
                    • Have your questions and materials ready<br>
                    • Be respectful and professional during the session
                </div>
            </div>
            @endif

            <!-- Session Notes -->
            @if($session->student_notes || $session->mentor_notes)
            <div class="session-notes">
                @if($session->student_notes)
                <div class="notes-section mb-3">
                    <div class="notes-title">
                        <i class="fas fa-user"></i>
                        Your Notes
                    </div>
                    <div class="notes-content">{{ $session->student_notes }}</div>
                </div>
                @endif
                
                @if($session->mentor_notes && in_array($session->status, ['completed']))
                <div class="notes-section">
                    <div class="notes-title">
                        <i class="fas fa-user-tie"></i>
                        Mentor's Feedback
                    </div>
                    <div class="notes-content">{{ $session->mentor_notes }}</div>
                </div>
                @endif
            </div>
            @endif

            <!-- Rating & Feedback (for completed sessions) -->
            @if($session->status === 'completed')
            <div class="rating-section">
                <h5 class="text-white mb-3">
                    <i class="fas fa-star me-2" style="color: #ffc107;"></i>
                    Session Rating
                </h5>
                
                @if($session->rating)
                <div class="rating-display">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $session->rating ? '' : 'empty' }}"></i>
                    @endfor
                </div>
                <p class="text-white-50">You rated this session {{ $session->rating }}/5 stars</p>
                
                @if($session->feedback)
                <div class="feedback-text">
                    "{{ $session->feedback }}"
                </div>
                @endif
                @else
                <p class="text-white-50 mb-3">Rate your experience with this session</p>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ratingModal">
                    <i class="fas fa-star me-2"></i>
                    Rate Session
                </button>
                @endif
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Payment Information -->
            @if($session->payment)
            <div class="payment-card">
                <div class="payment-status">
                    <div class="payment-info">
                        <div class="payment-icon {{ $session->payment->status === 'paid' ? 'paid' : 'pending' }}">
                            <i class="fas {{ $session->payment->status === 'paid' ? 'fa-check-circle' : 'fa-clock' }}"></i>
                        </div>
                        <div class="payment-details">
                            <h5>{{ $session->payment->status_text }}</h5>
                            <p>{{ $session->payment->payment_method_text }}</p>
                        </div>
                    </div>
                    <div class="payment-amount">{{ $session->payment->formatted_amount }}</div>
                </div>
                
                @if($session->payment->status === 'pending')
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <small>
                        Payment expires {{ $session->payment->expires_at ? $session->payment->expires_at->diffForHumans() : 'soon' }}
                    </small>
                </div>
                @endif
                
                <div class="text-center">
                    <small class="text-white-50">
                        Payment Code: <code>{{ $session->payment->payment_code }}</code>
                    </small>
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="action-buttons">
                @if($session->status === 'pending' && $session->payment)
                    <a href="{{ route('student.sessions.payment', $session->payment) }}" class="btn-action btn-warning">
                        <i class="fas fa-credit-card"></i>
                        Complete Payment
                    </a>
                @endif

                @if($session->can_start)
                    <a href="{{ route('student.sessions.join-meeting', $session) }}" class="btn-action btn-success">
                        <i class="fas fa-video"></i>
                        Join Meeting
                    </a>
                @elseif($session->status === 'confirmed')
                    <button class="btn-action btn-primary" disabled>
                        <i class="fas fa-clock"></i>
                        Available Soon
                    </button>
                @endif

                @if($session->can_be_cancelled)
                    <button class="btn-action btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">
                        <i class="fas fa-times"></i>
                        Cancel Session
                    </button>
                @endif

                @if($session->can_be_rescheduled)
                    <button class="btn-action btn-warning" data-bs-toggle="modal" data-bs-target="#rescheduleModal">
                        <i class="fas fa-calendar-alt"></i>
                        Reschedule
                    </button>
                @endif

                <a href="{{ route('student.sessions.my-sessions') }}" class="btn-action btn-secondary">
                    <i class="fas fa-list"></i>
                    All Sessions
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Rating Modal -->
@if($session->status === 'completed' && !$session->rating)
<div class="modal fade" id="ratingModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: rgba(19, 27, 49, 0.95); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <h5 class="modal-title" style="color: var(--primary-color);">Rate Your Session</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('student.sessions.feedback', $session) }}" method="POST">
                @csrf
                <div class="modal-body" style="color: white;">
                    <div class="text-center mb-4">
                        <h6>How was your session with {{ $session->mentor->name }}?</h6>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Rating</label>
                        <div class="rating-input d-flex gap-2 justify-content-center mb-3">
                            @for($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}" id="rating_{{ $i }}" hidden>
                            <label for="rating_{{ $i }}" class="star-label" style="font-size: 32px; color: #ddd; cursor: pointer;">
                                <i class="fas fa-star"></i>
                            </label>
                            @endfor
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Your Feedback (Optional)</label>
                        <textarea class="form-control" name="feedback" rows="4" placeholder="Share your experience and help other students..."></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Rating</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Cancel Modal -->
@if($session->can_be_cancelled)
<div class="modal fade" id="cancelModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: rgba(19, 27, 49, 0.95); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <h5 class="modal-title" style="color: var(--danger-color);">Cancel Session</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('student.sessions.cancel', $session) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body" style="color: white;">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Cancellation Policy:</strong><br>
                        • More than 24 hours: 100% refund<br>
                        • 12-24 hours: 50% refund<br>
                        • Less than 12 hours: No refund
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Reason for cancellation</label>
                        <textarea class="form-control" name="reason" rows="3" placeholder="Please tell us why you're cancelling this session..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Keep Session</button>
                    <button type="submit" class="btn btn-danger">Cancel Session</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- Reschedule Modal -->
@if($session->can_be_rescheduled)
<div class="modal fade" id="rescheduleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="background-color: rgba(19, 27, 49, 0.95); border: 1px solid rgba(255, 255, 255, 0.1);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(255, 255, 255, 0.1);">
                <h5 class="modal-title" style="color: var(--primary-color);">Request Reschedule</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('student.sessions.request-reschedule', $session) }}" method="POST">
                @csrf
                <div class="modal-body" style="color: white;">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        This will send a reschedule request to {{ $session->mentor->name }} for approval.
                    </div>
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Preferred Date</label>
                            <input type="date" class="form-control" name="preferred_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Preferred Time</label>
                            <input type="time" class="form-control" name="preferred_time" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Reason for reschedule</label>
                            <textarea class="form-control" name="reason" rows="3" placeholder="Please explain why you need to reschedule..." required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255, 255, 255, 0.1);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Session countdown timer
    const countdownElement = document.getElementById('sessionCountdown');
    if (countdownElement) {
        const sessionTime = new Date(countdownElement.dataset.sessionTime);
        
        function updateCountdown() {
            const now = new Date();
            const timeDiff = sessionTime - now;
            
            if (timeDiff <= 0) {
                countdownElement.textContent = 'Session Time!';
                countdownElement.style.color = 'var(--success-color)';
                return;
            }
            
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeDiff % (1000 * 60)) / 1000);
            
            let countdownText = '';
            if (days > 0) {
                countdownText = `${days}d ${hours}h ${minutes}m`;
            } else if (hours > 0) {
                countdownText = `${hours}h ${minutes}m ${seconds}s`;
            } else {
                countdownText = `${minutes}m ${seconds}s`;
            }
            
            countdownElement.textContent = countdownText;
        }
        
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
    
    // Star rating functionality
    const ratingInputs = document.querySelectorAll('.rating-input');
    
    ratingInputs.forEach(ratingInput => {
        const stars = ratingInput.querySelectorAll('.star-label');
        const radioInputs = ratingInput.querySelectorAll('input[type="radio"]');
        
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', function() {
                updateStarDisplay(stars, index + 1);
            });
            
            star.addEventListener('click', function() {
                radioInputs[index].checked = true;
                updateStarDisplay(stars, index + 1);
            });
        });
        
        ratingInput.addEventListener('mouseleave', function() {
            const checked = ratingInput.querySelector('input[type="radio"]:checked');
            const checkedIndex = checked ? Array.from(radioInputs).indexOf(checked) + 1 : 0;
            updateStarDisplay(stars, checkedIndex);
        });
    });
    
    function updateStarDisplay(stars, rating) {
        stars.forEach((star, index) => {
            const icon = star.querySelector('i');
            if (index < rating) {
                icon.style.color = '#ffc107';
            } else {
                icon.style.color = '#ddd';
            }
        });
    }
});

// Copy to clipboard function
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show temporary success message
        const alert = document.createElement('div');
        alert.className = 'alert alert-success position-fixed';
        alert.style.cssText = 'top: 20px; right: 20px; z-index: 9999; width: auto;';
        alert.innerHTML = '<i class="fas fa-check me-2"></i>Meeting link copied!';
        document.body.appendChild(alert);
        
        setTimeout(() => {
            alert.remove();
        }, 2000);
    }).catch(function() {
        alert('Unable to copy to clipboard. Please copy manually: ' + text);
    });
}
</script>
@endsection