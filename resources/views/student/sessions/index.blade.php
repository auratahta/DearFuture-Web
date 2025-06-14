@extends('layouts.student')

@section('title', 'Browse Sessions')

@section('styles')
<style>
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    /* Page Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
        padding: 30px;
        background: linear-gradient(135deg, #1d293d 0%, #262f4b 100%);
        border-radius: 20px;
        color: white;
    }

    .header-content h1 {
        font-size: 32px;
        margin-bottom: 10px;
        color: var(--judul);
    }

    .header-content p {
        font-size: 16px;
        color: #a8b2c8;
    }

    .header-image img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 15px;
    }

    /* Search Section */
    .search-section {
        margin-bottom: 40px;
    }

    .search-container {
        display: flex;
        gap: 15px;
        margin-bottom: 20px;
    }

    .search-input {
        flex: 1;
        padding: 15px 20px;
        border: 2px solid #e0e0e0;
        border-radius: 25px;
        font-size: 16px;
        background-color: white;
        color: #333;
        transition: border-color 0.3s;
    }

    .search-input:focus {
        border-color: var(--judul);
        outline: none;
    }

    .search-button {
        padding: 15px 30px;
        background-color: var(--judul);
        color: var(--bg);
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .search-button:hover {
        background-color: #4ddee6;
        transform: translateY(-2px);
    }

    /* Filter Section */
    .filter-section {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 30px;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .filter-label {
        font-size: 14px;
        color: var(--text);
        font-weight: 500;
    }

    .filter-select {
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        background-color: white;
        color: #333;
        min-width: 150px;
    }

    .filter-select:focus {
        border-color: var(--judul);
        outline: none;
    }

    /* Featured Tutors */
    .featured-section {
        margin-bottom: 40px;
    }

    .section-title {
        font-size: 24px;
        color: white;
        margin-bottom: 20px;
    }

    .tutors-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .tutor-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .tutor-card:hover {
        transform: translateY(-5px);
    }

    .tutor-img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 15px;
    }

    .tutor-info h3 {
        color: #333;
        margin-bottom: 5px;
    }

    .tutor-info p {
        color: #666;
        font-size: 14px;
    }

    /* Sessions Section */
    .sessions-section {
        margin-bottom: 40px;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .sort-by {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--text);
    }

    .sort-select {
        padding: 8px 12px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        background-color: white;
        color: #333;
    }

    /* Course Cards */
    .course-list {
        display: grid;
        gap: 25px;
        margin-bottom: 40px;
    }

    .course-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        position: relative;
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .course-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
    }

    .course-card.popular {
        border: 2px solid var(--judul);
    }

    .card-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: var(--accent);
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 600;
    }

    .popular-badge {
        background-color: var(--judul);
        color: var(--bg);
    }

    .course-title {
        font-size: 24px;
        color: #333;
        margin-bottom: 15px;
    }

    .course-details {
        display: grid;
        gap: 12px;
    }

    .tutor-name {
        font-size: 18px;
        color: var(--judul);
        font-weight: 600;
    }

    .rating {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .stars {
        color: #ffc107;
        font-size: 16px;
    }

    .rating-count {
        color: #666;
        font-size: 14px;
    }

    .price-info {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }

    .price-icon {
        width: 20px;
        height: 20px;
    }

    .discount {
        text-decoration: line-through;
        color: #999;
        font-size: 14px;
        margin-left: 8px;
    }

    .schedule-info {
        display: flex;
        align-items: center;
        gap: 15px;
        color: #666;
        flex-wrap: wrap;
    }

    .calendar-icon, .time-icon {
        width: 16px;
        height: 16px;
    }

    .topics-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin: 10px 0;
    }

    .topic-tag {
        background-color: #f0f8ff;
        color: var(--info);
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        font-weight: 500;
    }

    .book-button {
        background-color: var(--judul);
        color: var(--bg);
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .book-button:hover {
        background-color: #4ddee6;
        transform: translateY(-2px);
    }

    .book-button:disabled {
        background-color: #ccc;
        cursor: not-allowed;
        transform: none;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-top: 40px;
    }

    .page-link {
        padding: 10px 15px;
        background-color: #1d293d;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.3s;
    }

    .page-link:hover,
    .page-link.active {
        background-color: var(--judul);
        color: var(--bg);
    }

    /* Help Section */
    .help-section {
        background: linear-gradient(135deg, var(--judul), #4ddee6);
        padding: 40px;
        border-radius: 20px;
        text-align: center;
        margin: 40px 0;
    }

    .help-content h2 {
        color: var(--bg);
        margin-bottom: 10px;
    }

    .help-content p {
        color: var(--bg);
        margin-bottom: 20px;
        opacity: 0.8;
    }

    .contact-button {
        background-color: var(--bg);
        color: var(--judul);
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }

    .contact-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        margin: 40px 0;
    }

    .empty-state i {
        font-size: 64px;
        color: var(--text);
        margin-bottom: 20px;
    }

    .empty-state h3 {
        color: #333;
        margin-bottom: 10px;
    }

    .empty-state p {
        color: #666;
        margin-bottom: 20px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-header {
            flex-direction: column;
            text-align: center;
            gap: 20px;
        }

        .search-container {
            flex-direction: column;
        }

        .section-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .schedule-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .filter-section {
            flex-direction: column;
        }

        .tutors-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
    }
</style>
@endsection

@section('content')
<div class="container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h1>Find Your Perfect Mentor</h1>
            <p>Choose from our selected tutors to help you succeed</p>
        </div>

        <div class="header-image">
            <img src="{{ asset('image/findyour.png') }}" alt="Learning" onerror="this.src='{{ asset('image/default-subject-icon.png') }}'">
        </div>
    </div>
    
    <!-- Search Section -->
    <div class="search-section">
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-group">
                    <label class="filter-label">Subject:</label>
                    <select name="subject_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Subjects</option>
                        @foreach($subjects as $subject)
                            <option value="{{ $subject->id }}" {{ request('subject_id') == $subject->id ? 'selected' : '' }}>
                                {{ $subject->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Mentor:</label>
                    <select name="mentor_id" class="filter-select" onchange="this.form.submit()">
                        <option value="">All Mentors</option>
                        @foreach($mentors as $mentor)
                            <option value="{{ $mentor->id }}" {{ request('mentor_id') == $mentor->id ? 'selected' : '' }}>
                                {{ $mentor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Date From:</label>
                    <input type="date" name="date_from" class="filter-select" 
                           value="{{ request('date_from') }}" 
                           onchange="this.form.submit()">
                </div>
                
                <div class="filter-group">
                    <label class="filter-label">Price Range:</label>
                    <select name="price_range" class="filter-select" onchange="this.form.submit()">
                        <option value="">Any Price</option>
                        <option value="0-50000" {{ request('price_range') == '0-50000' ? 'selected' : '' }}>Under Rp 50,000</option>
                        <option value="50000-100000" {{ request('price_range') == '50000-100000' ? 'selected' : '' }}>Rp 50,000 - 100,000</option>
                        <option value="100000-150000" {{ request('price_range') == '100000-150000' ? 'selected' : '' }}>Rp 100,000 - 150,000</option>
                        <option value="150000+" {{ request('price_range') == '150000+' ? 'selected' : '' }}>Above Rp 150,000</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
    
    <!-- Featured Mentors Section -->
    @if($mentors->count() > 0)
    <div class="featured-section">
        <h2 class="section-title">Featured Mentors</h2>
        <div class="tutors-grid">
            @foreach($mentors->take(6) as $mentor)
            <div class="tutor-card">
                <img src="{{ $mentor->avatar ? asset('storage/'.$mentor->avatar) : asset('image/profile.png') }}" 
                     alt="{{ $mentor->name }}" class="tutor-img">
                <div class="tutor-info">
                    <h3>{{ $mentor->name }}</h3>
                    <p>Expert Mentor • ⭐ 4.8</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
    
    <!-- Available Sessions Section -->
    <div class="sessions-section">
        <div class="section-header">
            <h2 class="section-title">Available Sessions</h2>
            <div class="sort-by">
                <span>Sort by:</span>
                <select class="sort-select" onchange="sortSessions(this.value)">
                    <option value="newest">Newest</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                    <option value="date">Date</option>
                </select>
            </div>
        </div>
        
        @if($sessions->count() > 0)
            <!-- Course Cards Container -->
            <div class="course-list" id="sessionsList">
                @foreach($sessions as $index => $session)
                <div class="course-card {{ $index === 1 ? 'popular' : '' }}">
                    @if($index === 0)
                        <div class="card-badge">Limited Seats</div>
                    @elseif($index === 1)
                        <div class="card-badge popular-badge">Popular</div>
                    @endif
                    
                    <h2 class="course-title">{{ $session->subject->name ?? 'Subject' }}</h2>
                    <div class="course-details">
                        <div class="tutor-name">{{ $session->mentor->name ?? 'Mentor' }}</div>
                        <div class="rating">
                            <span class="stars">★★★★★</span>
                            <span class="rating-count">({{ rand(20, 60) }} reviews)</span>
                        </div>
                        <div class="price-info">
                            <img src="{{ asset('image/money.png') }}" alt="Price" class="price-icon" 
                                 onerror="this.style.display='none'"> 
                            Rp {{ number_format($session->price, 0, ',', '.') }}
                            @if($index === 1)
                                <span class="discount">Rp {{ number_format($session->price * 1.25, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div class="schedule-info">
                            <img src="{{ asset('image/calendar.png') }}" alt="Calendar" class="calendar-icon"
                                 onerror="this.style.display='none'"> 
                            {{ $session->date->format('l, d F Y') }}
                            <img src="{{ asset('image/time.png') }}" alt="Time" class="time-icon"
                                 onerror="this.style.display='none'"> 
                            {{ $session->start_time->format('H:i') }} - {{ $session->end_time->format('H:i') }}
                        </div>
                        <div class="topics-tags">
                            <span class="topic-tag">{{ $session->subject->category ?? 'General' }}</span>
                            <span class="topic-tag">Interactive</span>
                            @if($session->notes)
                                <span class="topic-tag">Guided Learning</span>
                            @endif
                        </div>
                        
                        @if($session->can_be_booked)
                            <form action="{{ route('student.sessions.book', $session->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="phone" value="{{ auth()->user()->phone ?? '081234567890' }}">
                                <button type="submit" class="book-button">BOOK NOW</button>
                            </form>
                        @else
                            <button class="book-button" disabled>NOT AVAILABLE</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($sessions->hasPages())
            <div class="pagination">
                @if($sessions->onFirstPage())
                    <span class="page-link" style="opacity: 0.5;">Previous</span>
                @else
                    <a href="{{ $sessions->previousPageUrl() }}" class="page-link">Previous</a>
                @endif
                
                @foreach($sessions->getUrlRange(1, $sessions->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="page-link {{ $page == $sessions->currentPage() ? 'active' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach
                
                @if($sessions->hasMorePages())
                    <a href="{{ $sessions->nextPageUrl() }}" class="page-link">Next →</a>
                @else
                    <span class="page-link" style="opacity: 0.5;">Next →</span>
                @endif
            </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="empty-state">
                <i class="fas fa-calendar-times"></i>
                <h3>No Sessions Available</h3>
                <p>There are currently no available sessions. Check back later or contact support.</p>
                <a href="{{ route('student.sessions.subjects') }}" class="btn btn-primary">
                    <i class="fas fa-book"></i> Browse Subjects
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Need Help Section -->
<div class="help-section">
    <div class="help-content">
        <h2>Need Help Finding the Right Class?</h2>
        <p>Our education advisors can help you find the perfect mentor for your needs</p>
        <button class="contact-button" onclick="window.location.href='mailto:dearfuture090@gmail.com'">Contact Us</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-submit search form with debounce
    let searchTimeout;
    const searchInput = document.getElementById('searchInput');
    
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                if (this.value.length > 2 || this.value.length === 0) {
                    document.getElementById('searchForm').submit();
                }
            }, 500);
        });
    }
});

function sortSessions(sortBy) {
    const url = new URL(window.location);
    url.searchParams.set('sort', sortBy);
    window.location.href = url.toString();
}

// Book session with confirmation
function bookSession(sessionId) {
    if (confirm('Are you sure you want to book this session?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/student/sessions/${sessionId}/book`;
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        
        const phoneInput = document.createElement('input');
        phoneInput.type = 'hidden';
        phoneInput.name = 'phone';
        phoneInput.value = '{{ auth()->user()->phone ?? "081234567890" }}';
        
        form.appendChild(csrfToken);
        form.appendChild(phoneInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection