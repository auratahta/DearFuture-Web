@extends('layouts.student')

@section('title', 'Sesi Saya')

@section('styles')
<style>
    :root {
        --primary-color: #3490dc;
        --secondary-color: #6cb2eb;
        --success-color: #38c172;
        --warning-color: #f6993f;
        --danger-color: #e3342f;
        --info-color: #17a2b8;
        --dark-color: #343a40;
    }

    .sessions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
        gap: 20px;
    }
    
    .header-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }
    
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .stat-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-2px);
    }
    
    .stat-icon {
        font-size: 24px;
        margin-bottom: 10px;
    }
    
    .stat-value {
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .filter-tabs {
        display: flex;
        gap: 5px;
        margin-bottom: 25px;
        background: rgba(255, 255, 255, 0.05);
        padding: 5px;
        border-radius: 10px;
        overflow-x: auto;
    }
    
    .filter-tab {
        background: none;
        border: none;
        color: rgba(255, 255, 255, 0.6);
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        flex-shrink: 0;
    }
    
    .filter-tab.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--dark-color);
    }
    
    .filter-tab:hover:not(.active) {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
    }
    
    .filter-badge {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        font-size: 11px;
        padding: 2px 6px;
        border-radius: 10px;
        margin-left: 5px;
    }
    
    .filter-tab.active .filter-badge {
        background: rgba(0, 0, 0, 0.2);
        color: var(--dark-color);
    }
    
    .sessions-container {
        display: grid;
        gap: 20px;
    }
    
    .session-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 25px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .session-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--session-color, linear-gradient(90deg, var(--primary-color), var(--secondary-color)));
    }
    
    .session-card.status-booked::before {
        background: linear-gradient(90deg, var(--warning-color), #f1b91c);
    }
    
    .session-card.status-confirmed::before {
        background: linear-gradient(90deg, var(--success-color), #17a673);
    }
    
    .session-card.status-completed::before {
        background: linear-gradient(90deg, var(--info-color), #2e9996);
    }
    
    .session-card.status-cancelled::before {
        background: linear-gradient(90deg, var(--danger-color), #c82333);
    }
    
    .session-card.status-ongoing::before {
        background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    }
    
    .session-card:hover {
        background: rgba(255, 255, 255, 0.08);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }
    
    .session-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 20px;
        gap: 15px;
    }
    
    .session-info {
        flex: 1;
    }
    
    .session-subject {
        color: white;
        font-weight: 700;
        font-size: 20px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .subject-icon {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: var(--dark-color);
    }
    
    .session-mentor {
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
        margin-bottom: 5px;
    }
    
    .session-id {
        color: rgba(255, 255, 255, 0.5);
        font-size: 12px;
        font-family: 'Courier New', monospace;
    }
    
    .session-status {
        text-align: right;
    }
    
    .status-badge {
        padding: 8px 15px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: inline-block;
    }
    
    .status-booked {
        background: rgba(247, 194, 68, 0.2);
        color: var(--warning-color);
        border: 1px solid rgba(247, 194, 68, 0.3);
    }
    
    .status-confirmed {
        background: rgba(28, 200, 138, 0.2);
        color: var(--success-color);
        border: 1px solid rgba(28, 200, 138, 0.3);
    }
    
    .status-ongoing {
        background: rgba(90, 247, 255, 0.2);
        color: var(--primary-color);
        border: 1px solid rgba(90, 247, 255, 0.3);
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
    
    .session-details {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .detail-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }
    
    .detail-icon {
        color: var(--primary-color);
        width: 16px;
        text-align: center;
    }
    
    .session-countdown {
        background: rgba(90, 247, 255, 0.1);
        border: 1px solid rgba(90, 247, 255, 0.3);
        border-radius: 8px;
        padding: 10px 15px;
        text-align: center;
        margin-bottom: 15px;
    }
    
    .countdown-label {
        color: var(--primary-color);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    
    .countdown-time {
        color: var(--primary-color);
        font-weight: 700;
        font-family: 'Courier New', monospace;
    }
    
    .meeting-info {
        background: rgba(28, 200, 138, 0.1);
        border: 1px solid rgba(28, 200, 138, 0.3);
        border-radius: 8px;
        padding: 12px 15px;
        margin: 15px 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .meeting-info i {
        color: var(--success-color);
    }
    
    .meeting-text {
        color: rgba(255, 255, 255, 0.8);
        font-size: 13px;
        margin: 0;
    }
    
    .session-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }
    
    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-weight: 500;
        font-size: 14px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: var(--dark-color);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        color: var(--dark-color);
        transform: translateY(-1px);
    }
    
    .btn-success {
        background: var(--success-color);
        color: white;
    }
    
    .btn-success:hover {
        background: #17a673;
        color: white;
        transform: translateY(-1px);
    }
    
    .btn-warning {
        background: rgba(247, 194, 68, 0.2);
        color: var(--warning-color);
        border: 1px solid rgba(247, 194, 68, 0.3);
    }
    
    .btn-warning:hover {
        background: rgba(247, 194, 68, 0.3);
        color: var(--warning-color);
    }
    
    .btn-danger {
        background: rgba(231, 74, 59, 0.2);
        color: var(--danger-color);
        border: 1px solid rgba(231, 74, 59, 0.3);
    }
    
    .btn-danger:hover {
        background: rgba(231, 74, 59, 0.3);
        color: var(--danger-color);
    }
    
    .btn-secondary {
        background: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .btn-secondary:hover {
        background: rgba(255, 255, 255, 0.15);
        color: white;
    }
    
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    
    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }
    
    .rating-display {
        display: flex;
        align-items: center;
        gap: 5px;
        margin-top: 10px;
    }
    
    .star {
        color: #ffc107;
        font-size: 14px;
    }
    
    .star.empty {
        color: rgba(255, 255, 255, 0.3);
    }
    
    .rating-input {
        display: flex;
        gap: 5px;
        justify-content: center;
        margin: 10px 0;
    }
    
    .star-label {
        cursor: pointer;
        font-size: 24px;
        color: #ddd;
        transition: color 0.2s;
    }
    
    .star-label:hover {
        color: #ffc107;
    }
    
    @media (max-width: 768px) {
        .sessions-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
        
        .session-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .session-status {
            text-align: left;
            margin-bottom: 15px;
        }
        
        .session-details {
            grid-template-columns: 1fr;
        }
        
        .session-actions {
            justify-content: flex-start;
        }
        
        .filter-tabs {
            overflow-x: auto;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        
        .filter-tabs::-webkit-scrollbar {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="sessions-header">
    <div>
        <h1>
            <i class="fas fa-calendar-alt me-2" style="color: var(--primary-color);"></i>
            Sesi Saya
        </h1>
        <p class="text-muted">Kelola dan pantau semua sesi mentoring Anda</p>
    </div>
    <div class="header-actions">
        <a href="{{ route('student.sessions.subjects') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i>
            Pesan Sesi Baru
        </a>
        <a href="{{ route('student.history.index') }}" class="btn btn-secondary">
            <i class="fas fa-history me-2"></i>
            Riwayat Sesi
        </a>
    </div>
</div>

<!-- Statistics -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon text-info">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
        <p class="stat-label">Total Sesi</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon text-primary">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-value">{{ $stats['upcoming'] ?? 0 }}</div>
        <p class="stat-label">Mendatang</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon text-success">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
        <p class="stat-label">Selesai</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon text-danger">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-value">{{ $stats['cancelled'] ?? 0 }}</div>
        <p class="stat-label">Dibatalkan</p>
    </div>
</div>

<!-- Filter Tabs -->
<div class="filter-tabs">
    <button class="filter-tab active" data-filter="all">
        Semua Sesi
        <span class="filter-badge">{{ $sessions->total() }}</span>
    </button>
    <button class="filter-tab" data-filter="upcoming">
        Mendatang
        <span class="filter-badge">{{ $stats['upcoming'] ?? 0 }}</span>
    </button>
    <button class="filter-tab" data-filter="confirmed">
        Dikonfirmasi
        <span class="filter-badge">{{ $sessions->where('status', 'confirmed')->count() }}</span>
    </button>
    <button class="filter-tab" data-filter="completed">
        Selesai
        <span class="filter-badge">{{ $stats['completed'] ?? 0 }}</span>
    </button>
    <button class="filter-tab" data-filter="cancelled">
        Dibatalkan
        <span class="filter-badge">{{ $stats['cancelled'] ?? 0 }}</span>
    </button>
</div>

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

<!-- Sessions List -->
@if($sessions->count() > 0)
<div class="sessions-container" id="sessionsContainer">
    @foreach($sessions as $session)
    <div class="session-card status-{{ $session->status }}" data-status="{{ $session->status }}" data-upcoming="{{ $session->is_upcoming ? 'true' : 'false' }}">
        <div class="session-header">
            <div class="session-info">
                <div class="session-subject">
                    <div class="subject-icon">
                        <i class="fas {{ $session->subject->icon_class ?? 'fa-book' }}"></i>
                    </div>
                    {{ $session->subject->name }}
                </div>
                <div class="session-mentor">
                    <i class="fas fa-user-tie me-1"></i>
                    Mentor: {{ $session->mentor->name }}
                </div>
                <div class="session-id">ID: {{ $session->id }}</div>
            </div>
            <div class="session-status">
                <span class="status-badge status-{{ $session->status }}">
                    {{ $session->status_text }}
                </span>
                @if($session->rating)
                <div class="rating-display">
                    @for($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= $session->rating ? '' : 'empty' }}"></i>
                    @endfor
                    <span class="ms-1 text-muted">({{ $session->rating }}/5)</span>
                </div>
                @endif
            </div>
        </div>

        <div class="session-details">
            <div class="detail-item">
                <i class="fas fa-calendar detail-icon"></i>
                {{ $session->date ? $session->date->format('d M Y') : 'Tidak tersedia' }}
            </div>
            <div class="detail-item">
                <i class="fas fa-clock detail-icon"></i>
                {{ $session->time_formatted ?? 'Tidak tersedia' }}
            </div>
            <div class="detail-item">
                <i class="fas fa-hourglass-half detail-icon"></i>
                {{ $session->duration_formatted }}
            </div>
            <div class="detail-item">
                <i class="fas fa-coins detail-icon"></i>
                {{ $session->formatted_price }}
            </div>
        </div>

        <!-- Meeting Info for Confirmed/Ongoing Sessions -->
        @if(in_array($session->status, ['confirmed', 'ongoing']) && $session->meeting_link)
        <div class="meeting-info">
            <i class="fas fa-video"></i>
            <p class="meeting-text">
                Link meeting sudah siap! 
                @if($session->status === 'ongoing')
                    <strong>Sesi sedang berlangsung</strong>
                @else
                    Tersedia 15 menit sebelum sesi dimulai
                @endif
            </p>
        </div>
        @endif

        <!-- Countdown for Upcoming Sessions -->
        @if($session->is_upcoming && in_array($session->status, ['confirmed', 'ongoing']))
        <div class="session-countdown">
            <div class="countdown-label">
                @if($session->status === 'ongoing')
                    Sesi sedang berlangsung
                @else
                    Dimulai dalam
                @endif
            </div>
            <div class="countdown-time" data-session-time="{{ $session->session_date_time ? $session->session_date_time->toISOString() : '' }}">
                {{ $session->time_remaining ?? 'Menghitung...' }}
            </div>
        </div>
        @endif

        <!-- Session Actions -->
        <div class="session-actions">
            <!-- View Details -->
            <a href="{{ route('student.sessions.show', $session) }}" class="btn-action btn-secondary">
                <i class="fas fa-eye"></i>
                Detail
            </a>

            @if($session->can_start && $session->has_meeting_link)
                <!-- Join Meeting -->
                <a href="{{ $session->meeting_link }}" target="_blank" class="btn-action btn-success">
                    <i class="fas fa-video"></i>
                    Gabung Meeting
                </a>
            @elseif($session->status === 'confirmed' && $session->meeting_link)
                <!-- Meeting Available Soon -->
                <button class="btn-action btn-primary" disabled title="Meeting tersedia 15 menit sebelum sesi">
                    <i class="fas fa-clock"></i>
                    Segera Tersedia
                </button>
            @endif

            @if($session->status === 'completed' && !$session->rating)
                <!-- Give Feedback -->
                <button class="btn-action btn-primary" data-bs-toggle="modal" data-bs-target="#feedbackModal{{ $session->id }}">
                    <i class="fas fa-star"></i>
                    Beri Rating
                </button>
            @endif

            @if($session->can_be_cancelled)
                <!-- Cancel Session -->
                <button class="btn-action btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal{{ $session->id }}">
                    <i class="fas fa-times"></i>
                    Batalkan
                </button>
            @endif

            @if($session->can_be_rescheduled)
                <!-- Request Reschedule -->
                <button class="btn-action btn-warning" data-bs-toggle="modal" data-bs-target="#rescheduleModal{{ $session->id }}">
                    <i class="fas fa-calendar-alt"></i>
                    Reschedule
                </button>
            @endif
        </div>
    </div>

    <!-- Feedback Modal -->
    @if($session->status === 'completed' && !$session->rating)
    <div class="modal fade" id="feedbackModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-primary">Beri Rating Sesi Anda</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('student.sessions.feedback', $session) }}" method="POST">
                    @csrf
                    <div class="modal-body text-white">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div class="rating-input">
                                @for($i = 1; $i <= 5; $i++)
                                <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $session->id }}_{{ $i }}" hidden>
                                <label for="rating{{ $session->id }}_{{ $i }}" class="star-label">
                                    <i class="fas fa-star"></i>
                                </label>
                                @endfor
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ulasan (Opsional)</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" name="feedback" rows="3" placeholder="Bagikan pengalaman Anda dengan sesi ini..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Rating</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Cancel Modal -->
    @if($session->can_be_cancelled)
    <div class="modal fade" id="cancelModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-danger">Batalkan Sesi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('student.sessions.cancel', $session) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body text-white">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Pemberitahuan Pembatalan:</strong><br>
                            Sesi ini akan dibatalkan dan dikembalikan ke slot yang tersedia untuk siswa lain.
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alasan pembatalan (Opsional)</label>
                            <textarea class="form-control bg-secondary text-white border-secondary" name="reason" rows="3" placeholder="Mohon beritahu kami mengapa Anda membatalkan..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tetap Lanjutkan</button>
                        <button type="submit" class="btn btn-danger">Batalkan Sesi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Reschedule Modal -->
    @if($session->can_be_rescheduled)
    <div class="modal fade" id="rescheduleModal{{ $session->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-primary">Minta Reschedule</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('student.sessions.request-reschedule', $session) }}" method="POST">
                    @csrf
                    <div class="modal-body text-white">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal yang Diinginkan</label>
                                <input type="date" class="form-control bg-secondary text-white border-secondary" name="preferred_date" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Waktu yang Diinginkan</label>
                                <input type="time" class="form-control bg-secondary text-white border-secondary" name="preferred_time" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Alasan reschedule</label>
                                <textarea class="form-control bg-secondary text-white border-secondary" name="reason" rows="3" placeholder="Mohon jelaskan mengapa Anda perlu reschedule..." required></textarea>
                            </div>
                        </div>
                        <div class="alert alert-info mt-3">
                            <i class="fas fa-info-circle me-2"></i>
                            Ini akan mengirim permintaan reschedule ke mentor Anda untuk persetujuan.
                        </div>
                    </div>
                    <div class="modal-footer border-secondary">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @endforeach
</div>

<!-- Pagination -->
@if($sessions->hasPages())
<div class="pagination-wrapper">
    {{ $sessions->links() }}
</div>
@endif

@else
<div class="empty-state">
    <i class="fas fa-calendar-times"></i>
    <h4>Tidak Ada Sesi Ditemukan</h4>
    <p>Anda belum memesan sesi apapun. Mulai perjalanan belajar Anda dengan memesan sesi pertama!</p>
    <a href="{{ route('student.sessions.subjects') }}" class="btn btn-primary mt-3">
        <i class="fas fa-plus-circle me-2"></i>
        Pesan Sesi Pertama Anda
    </a>
</div>
@endif
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterTabs = document.querySelectorAll('.filter-tab');
    const sessionCards = document.querySelectorAll('.session-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            // Filter sessions
            sessionCards.forEach(card => {
                const status = card.dataset.status;
                const isUpcoming = card.dataset.upcoming === 'true';
                
                let show = false;
                
                switch(filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'upcoming':
                        show = isUpcoming && ['confirmed', 'ongoing'].includes(status);
                        break;
                    case 'confirmed':
                        show = status === 'confirmed';
                        break;
                    case 'completed':
                        show = status === 'completed';
                        break;
                    case 'cancelled':
                        show = status === 'cancelled';
                        break;
                }
                
                card.style.display = show ? 'block' : 'none';
            });
        });
    });
    
    // Countdown timers for upcoming sessions
    const countdownElements = document.querySelectorAll('[data-session-time]');
    
    function updateCountdowns() {
        countdownElements.forEach(element => {
            const sessionTimeString = element.dataset.sessionTime;
            if (!sessionTimeString) return;
            
            const sessionTime = new Date(sessionTimeString);
            const now = new Date();
            const timeDiff = sessionTime - now;
            
            if (timeDiff <= 0) {
                element.textContent = 'Waktu Sesi!';
                element.style.color = 'var(--success-color)';
                return;
            }
            
            const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));
            
            let countdownText = '';
            if (days > 0) {
                countdownText = `${days}h ${hours}j ${minutes}m`;
            } else if (hours > 0) {
                countdownText = `${hours}j ${minutes}m`;
            } else {
                countdownText = `${minutes}m`;
            }
            
            element.textContent = countdownText;
        });
    }
    
    // Update countdowns every minute
    updateCountdowns();
    setInterval(updateCountdowns, 60000);
    
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
    
    // Form validation and loading states
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Memproses...';
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }, 5000);
            }
        });
    });
    
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                alert.style.transition = 'opacity 0.5s ease-out';
                setTimeout(() => {
                    if (alert.parentNode) {
                        alert.remove();
                    }
                }, 500);
            }
        }, 5000);
    });
    
    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }
    
    // Smooth scroll to top when pagination is clicked
    const paginationLinks = document.querySelectorAll('.pagination a');
    paginationLinks.forEach(link => {
        link.addEventListener('click', function() {
            setTimeout(() => {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            }, 100);
        });
    });
    
    // Add loading state to external links
    const externalLinks = document.querySelectorAll('a[target="_blank"]');
    externalLinks.forEach(link => {
        link.addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (icon) {
                const originalClass = icon.className;
                icon.className = 'fas fa-spinner fa-spin';
                setTimeout(() => {
                    icon.className = originalClass;
                }, 2000);
            }
        });
    });
    
    // Auto-refresh countdown timers and session status
    let refreshInterval = setInterval(function() {
        updateCountdowns();
        
        // Optional: Refresh session status via AJAX
        // Uncomment if you want to implement real-time updates
        /*
        fetch('/student/api/session-status-updates')
            .then(response => response.json())
            .then(data => {
                data.updates.forEach(update => {
                    const sessionCard = document.querySelector(`[data-session-id="${update.session_id}"]`);
                    if (sessionCard) {
                        // Update session card with new status
                        const statusBadge = sessionCard.querySelector('.status-badge');
                        const sessionActions = sessionCard.querySelector('.session-actions');
                        
                        if (statusBadge) {
                            statusBadge.textContent = update.status_text;
                            statusBadge.className = `status-badge status-${update.status}`;
                        }
                        
                        // Update available actions based on new status
                        if (update.actions_html) {
                            sessionActions.innerHTML = update.actions_html;
                        }
                    }
                });
            })
            .catch(error => console.log('Status update check failed:', error));
        */
    }, 30000); // Update every 30 seconds
    
    // Clean up interval when page is unloaded
    window.addEventListener('beforeunload', function() {
        clearInterval(refreshInterval);
    });
    
    // Modal events
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('shown.bs.modal', function() {
            // Focus on first input when modal opens
            const firstInput = modal.querySelector('input, textarea, select');
            if (firstInput) {
                firstInput.focus();
            }
        });
        
        modal.addEventListener('hidden.bs.modal', function() {
            // Reset form when modal closes
            const form = modal.querySelector('form');
            if (form) {
                form.reset();
                // Reset star ratings
                const starLabels = form.querySelectorAll('.star-label i');
                starLabels.forEach(star => {
                    star.style.color = '#ddd';
                });
            }
        });
    });
    
    // Add confirmation to destructive actions
    const dangerButtons = document.querySelectorAll('.btn-danger');
    dangerButtons.forEach(button => {
        if (!button.dataset.bsToggle) { // Skip modal trigger buttons
            button.addEventListener('click', function(e) {
                const action = this.textContent.trim();
                if (!confirm(`Apakah Anda yakin ingin ${action.toLowerCase()}?`)) {
                    e.preventDefault();
                }
            });
        }
    });
    
    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Escape key to close modals
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                const closeButton = openModal.querySelector('.btn-close');
                if (closeButton) {
                    closeButton.click();
                }
            }
        }
        
        // Ctrl+Enter to submit forms in modals
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            const openModal = document.querySelector('.modal.show');
            if (openModal) {
                const submitButton = openModal.querySelector('button[type="submit"]');
                if (submitButton && !submitButton.disabled) {
                    submitButton.click();
                }
            }
        }
    });
    
    // Auto-save draft for long forms (reschedule modal)
    const rescheduleTextareas = document.querySelectorAll('textarea[name="reason"]');
    rescheduleTextareas.forEach(textarea => {
        const sessionId = textarea.closest('.modal').id.replace('rescheduleModal', '');
        const storageKey = `reschedule_draft_${sessionId}`;
        
        // Load saved draft
        const savedDraft = localStorage.getItem(storageKey);
        if (savedDraft) {
            textarea.value = savedDraft;
        }
        
        // Auto-save on input
        textarea.addEventListener('input', function() {
            localStorage.setItem(storageKey, this.value);
        });
        
        // Clear draft on form submit
        const form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                localStorage.removeItem(storageKey);
            });
        }
    });
    
    // Performance optimization: Lazy load session cards
    if ('IntersectionObserver' in window) {
        const cardObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('loaded');
                    cardObserver.unobserve(entry.target);
                }
            });
        }, {
            rootMargin: '50px'
        });
        
        sessionCards.forEach(card => {
            cardObserver.observe(card);
        });
    }
    
    console.log('Sesi Saya page initialized successfully');
});
</script>
@endsection