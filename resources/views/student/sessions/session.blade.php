@extends('layouts.student')

@section('title', $subject->name . ' Sessions')

@section('styles')
<style>
    .subject-header-card {
        background: linear-gradient(135deg, rgba(90, 247, 255, 0.2) 0%, rgba(90, 247, 255, 0.1) 100%);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
        border: 1px solid rgba(90, 247, 255, 0.3);
    }
    
    .subject-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }
    
    .subject-icon-large {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, var(--primary-color), #00d4ff);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: white;
        flex-shrink: 0;
    }
    
    .subject-details h2 {
        color: white;
        font-weight: 700;
        margin-bottom: 10px;
    }
    
    .subject-meta {
        display: flex;
        gap: 25px;
        align-items: center;
        flex-wrap: wrap;
    }
    
    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: rgba(255, 255, 255, 0.8);
        font-size: 14px;
    }
    
    .meta-value {
        color: var(--primary-color);
        font-weight: 600;
    }
    
    .filters-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 30px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .sessions-calendar {
        display: grid;
        gap: 25px;
    }
    
    .date-group {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .date-header {
        background: linear-gradient(135deg, rgba(90, 247, 255, 0.3), rgba(90, 247, 255, 0.2));
        padding: 15px 20px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .date-title {
        color: white;
        font-weight: 700;
        margin: 0;
        font-size: 18px;
    }
    
    .date-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        margin: 0;
    }
    
    .sessions-grid {
        padding: 20px;
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .session-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }
    
    .session-card:hover {
        background: rgba(255, 255, 255, 0.08);
        border-color: var(--primary-color);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(90, 247, 255, 0.2);
    }
    
    .session-time {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 15px;
        padding: 10px;
        background: rgba(90, 247, 255, 0.1);
        border-radius: 8px;
        border-left: 4px solid var(--primary-color);
    }
    
    .time-text {
        color: white;
        font-weight: 600;
        font-size: 16px;
    }
    
    .duration-text {
        color: rgba(255, 255, 255, 0.7);
        font-size: 14px;
        margin-left: auto;
    }
    
    .mentor-info {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 15px;
    }
    
    .mentor-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--primary-color);
    }
    
    .mentor-details h4 {
        color: white;
        font-size: 16px;
        font-weight: 600;
        margin: 0;
    }
    
    .mentor-details p {
        color: rgba(255, 255, 255, 0.6);
        font-size: 14px;
        margin: 0;
    }
    
    .session-price {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
        padding: 8px 15px;
        border-radius: 20px;
        font-weight: 600;
        text-align: center;
        margin-bottom: 15px;
        border: 1px solid rgba(40, 167, 69, 0.3);
    }
    
    .btn-book-session {
        width: 100%;
        background: linear-gradient(135deg, var(--primary-color), #00d4ff);
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    
    .btn-book-session:hover {
        background: linear-gradient(135deg, #00d4ff, var(--primary-color));
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(90, 247, 255, 0.4);
    }
    
    .empty-sessions {
        text-align: center;
        padding: 60px 20px;
        color: rgba(255, 255, 255, 0.5);
    }
    
    .empty-sessions i {
        font-size: 3rem;
        margin-bottom: 20px;
        opacity: 0.3;
    }
    
    .filter-form .form-control,
    .filter-form .form-select {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 8px;
    }
    
    .filter-form .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }
    
    .filter-form .form-control:focus,
    .filter-form .form-select:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: var(--primary-color);
        color: white;
        box-shadow: 0 0 0 0.2rem rgba(90, 247, 255, 0.25);
    }
    
    .mentor-filter-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }
    
    .mentor-chip {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .mentor-chip:hover,
    .mentor-chip.active {
        background: rgba(90, 247, 255, 0.2);
        border-color: var(--primary-color);
        color: var(--primary-color);
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
        font-size: 20px;
        font-weight: 700;
        color: white;
        margin-bottom: 5px;
    }
    
    .stat-label {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.7);
        margin: 0;
    }
    
    @media (max-width: 768px) {
        .subject-info {
            flex-direction: column;
            text-align: center;
        }
        
        .subject-meta {
            justify-content: center;
        }
        
        .sessions-grid {
            grid-template-columns: 1fr;
            padding: 15px;
        }
        
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    @media (max-width: 576px) {
        .stats-row {
            grid-template-columns: 1fr;
        }
        
        .mentor-filter-chips {
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')
<!-- Subject Header -->
<div class="subject-header-card">
    <div class="subject-info">
        <div class="subject-icon-large">
            <i class="fas {{ $subject->icon ?? 'fa-book' }}"></i>
        </div>
        <div class="subject-details">
            <h2>{{ $subject->name }}</h2>
            <div class="subject-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar-check"></i>
                    <span>Available Sessions: <span class="meta-value">{{ $availableSessions->flatten()->count() }}</span></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>Duration: <span class="meta-value">{{ $subject->duration ?? 60 }} minutes</span></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-coins"></i>
                    <span>Price: <span class="meta-value">{{ $subject->formatted_price ?? 'Rp 30.000' }}</span></span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-users"></i>
                    <span>Mentors: <span class="meta-value">{{ $mentors->count() }}</span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon text-success">
            <i class="fas fa-calendar-plus"></i>
        </div>
        <div class="stat-value">{{ $availableSessions->flatten()->count() }}</div>
        <p class="stat-label">Available Sessions</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon text-info">
            <i class="fas fa-user-tie"></i>
        </div>
        <div class="stat-value">{{ $mentors->count() }}</div>
        <p class="stat-label">Expert Mentors</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon text-warning">
            <i class="fas fa-calendar-day"></i>
        </div>
        <div class="stat-value">{{ $availableSessions->count() }}</div>
        <p class="stat-label">Available Days</p>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="color: var(--primary-color);">
            <i class="fas fa-star"></i>
        </div>
        <div class="stat-value">
            @if($availableSessions->flatten()->count() > 0)
                {{ $availableSessions->flatten()->min('price') == $availableSessions->flatten()->max('price') 
                   ? $subject->formatted_price ?? 'Rp 30.000'
                   : 'Rp ' . number_format($availableSessions->flatten()->min('price'), 0, ',', '.') . ' - ' . number_format($availableSessions->flatten()->max('price'), 0, ',', '.') }}
            @else
                {{ $subject->formatted_price ?? 'Rp 30.000' }}
            @endif
        </div>
        <p class="stat-label">Price Range</p>
    </div>
</div>

<!-- Filters -->
<div class="filters-card">
    <h5 class="text-white mb-3">
        <i class="fas fa-filter me-2" style="color: var(--primary-color);"></i>
        Filter Sessions
    </h5>
    <form class="filter-form" method="GET">
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label text-white">Date From</label>
                <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}" min="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">Date To</label>
                <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}" min="{{ date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">Time From</label>
                <input type="time" class="form-control" name="time_from" value="{{ request('time_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label text-white">Time To</label>
                <input type="time" class="form-control" name="time_to" value="{{ request('time_to') }}">
            </div>
        </div>
        <div class="row g-3 mt-2">
            <div class="col-md-4">
                <label class="form-label text-white">Max Price</label>
                <input type="number" class="form-control" name="max_price" value="{{ request('max_price') }}" placeholder="Maximum price" min="0">
            </div>
            <div class="col-md-4">
                <label class="form-label text-white">Mentor</label>
                <select class="form-select" name="mentor_id">
                    <option value="">All Mentors</option>
                    @foreach($mentors as $mentor)
                        <option value="{{ $mentor->id }}" {{ request('mentor_id') == $mentor->id ? 'selected' : '' }}>
                            {{ $mentor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2">
                    <i class="fas fa-search me-1"></i> Filter
                </button>
                <a href="{{ route('student.sessions.subject', $subject) }}" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Clear
                </a>
            </div>
        </div>
    </form>
    
    <!-- Mentor Filter Chips -->
    @if($mentors->count() > 0)
    <div class="mentor-filter-chips">
        <span class="text-white me-2">Quick filter:</span>
        <div class="mentor-chip {{ !request('mentor_id') ? 'active' : '' }}" onclick="filterByMentor('')">
            All Mentors
        </div>
        @foreach($mentors as $mentor)
        <div class="mentor-chip {{ request('mentor_id') == $mentor->id ? 'active' : '' }}" onclick="filterByMentor({{ $mentor->id }})">
            {{ $mentor->name }}
        </div>
        @endforeach
    </div>
    @endif
</div>

<!-- Sessions Calendar -->
@if($availableSessions->count() > 0)
<div class="sessions-calendar">
    @foreach($availableSessions as $date => $sessions)
    <div class="date-group">
        <div class="date-header">
            <div class="date-title">
                <i class="fas fa-calendar-day me-2"></i>
                {{ \Carbon\Carbon::parse($date)->format('l, F j, Y') }}
            </div>
            <div class="date-subtitle">
                {{ $sessions->count() }} session{{ $sessions->count() !== 1 ? 's' : '' }} available
            </div>
        </div>
        <div class="sessions-grid">
            @foreach($sessions as $session)
            <div class="session-card">
                <div class="session-time">
                    <i class="fas fa-clock text-primary"></i>
                    <span class="time-text">
                        {{ \Carbon\Carbon::parse($session->start_time)->format('H:i') }} - 
                        {{ \Carbon\Carbon::parse($session->end_time)->format('H:i') }}
                    </span>
                    <span class="duration-text">{{ $session->duration_formatted }}</span>
                </div>
                
                <div class="mentor-info">
                    <img src="{{ $session->mentor->photo ?? asset('image/profile.png') }}" 
                         alt="{{ $session->mentor->name }}" 
                         class="mentor-avatar">
                    <div class="mentor-details">
                        <h4>{{ $session->mentor->name }}</h4>
                        <p>{{ $session->mentor->title ?? 'Expert Mentor' }}</p>
                    </div>
                </div>
                
                <div class="session-price">
                    <i class="fas fa-coins me-1"></i>
                    {{ $session->formatted_price }}
                </div>
                
                <a href="{{ route('student.sessions.booking', $session) }}" class="btn-book-session">
                    <i class="fas fa-calendar-check me-2"></i>
                    Book This Session
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>
@else
<div class="date-group">
    <div class="empty-sessions">
        <i class="fas fa-calendar-times"></i>
        <h4>No Sessions Available</h4>
        @if(request()->hasAny(['date_from', 'date_to', 'time_from', 'time_to', 'max_price', 'mentor_id']))
            <p>No sessions found matching your filter criteria. Try adjusting your filters.</p>
            <a href="{{ route('student.sessions.subject', $subject) }}" class="btn btn-primary mt-3">
                <i class="fas fa-times me-2"></i>Clear Filters
            </a>
        @else
            <p>There are currently no available sessions for this subject. Please check back later.</p>
            <a href="{{ route('student.sessions.subjects') }}" class="btn btn-primary mt-3">
                <i class="fas fa-arrow-left me-2"></i>Choose Another Subject
            </a>
        @endif
    </div>
</div>
@endif

<!-- Back Button -->
<div class="mt-4">
    <a href="{{ route('student.sessions.subjects') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        Back to Subjects
    </a>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Book session button loading state
    const bookButtons = document.querySelectorAll('.btn-book-session');
    bookButtons.forEach(button => {
        button.addEventListener('click', function() {
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            this.disabled = true;
            
            // Re-enable after navigation (fallback)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.disabled = false;
            }, 3000);
        });
    });
    
    // Auto-submit filter form on mentor select change
    const mentorSelect = document.querySelector('select[name="mentor_id"]');
    if (mentorSelect) {
        mentorSelect.addEventListener('change', function() {
            this.closest('form').submit();
        });
    }
});

// Function for mentor filter chips
function filterByMentor(mentorId) {
    const url = new URL(window.location.href);
    if (mentorId) {
        url.searchParams.set('mentor_id', mentorId);
    } else {
        url.searchParams.delete('mentor_id');
    }
    window.location.href = url.toString();
}
</script>
@endsection