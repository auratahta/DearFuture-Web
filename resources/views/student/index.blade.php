<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News - DearFuture</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- News CSS -->
    <link rel="stylesheet" href="{{ asset('css/news.css') }}">
</head>

<body>
    <!-- Navbar -->
    <nav class="header">
        <a href="{{ url('/student/menu') }}" class="logo">DearFuture</a>
        
        <nav class="nav-links">
            <a href="{{ url('/student/menu') }}">Home</a>
            <a href="{{ route('student.news.index') }}" style="color: var(--judul);">News</a>
            <a href="{{ url('/student/subjects') }}">Subjects</a>
            <a href="{{ url('/student/history') }}">History</a>
        </nav>
        
        <div class="user-profile">
            <span class="username">{{ Auth::user()->name ?? 'Student' }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="avatar">
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-container">
        <!-- News Header -->
        <div class="news-header">
            <h1 class="news-title">Latest News</h1>
            <div class="news-controls">
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" id="searchInput" placeholder="Search news..." value="{{ request('search') }}">
                </div>
                <select class="category-selector" id="categoryFilter">
                    <option value="">All Categories</option>
                    <option value="announcements" {{ request('category') == 'announcements' ? 'selected' : '' }}>Announcements</option>
                    <option value="events" {{ request('category') == 'events' ? 'selected' : '' }}>Events</option>
                    <option value="academic" {{ request('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                </select>
            </div>
        </div>

        <!-- News Grid -->
        <div class="news-grid" id="newsGrid">
            <!-- Featured News -->
            @if(isset($featuredNews) && $featuredNews)
            <div class="featured-news">
                <img src="{{ $featuredNews->image_url ?? 'https://via.placeholder.com/600x400' }}" alt="{{ $featuredNews->title }}" class="featured-img">
                <div class="featured-content">
                    <div>
                        <span class="featured-tag">{{ ucfirst($featuredNews->category) }}</span>
                        <h2 class="featured-title">{{ $featuredNews->title }}</h2>
                        <p class="featured-excerpt">{{ Str::limit($featuredNews->content, 200) }}</p>
                    </div>
                    <div class="featured-meta">
                        <div>
                            <small>By {{ $featuredNews->author->name ?? 'Admin' }}</small><br>
                            <small>{{ $featuredNews->created_at->format('M d, Y') }}</small>
                        </div>
                        <a href="{{ route('student.news.show', $featuredNews->id) }}" class="featured-btn">Read More</a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Regular News Cards -->
            @if(isset($news) && $news->count() > 0)
                @foreach($news as $article)
                <a href="{{ route('student.news.show', $article->id) }}" class="news-card">
                    <div class="card-img-container">
                        <img src="{{ $article->image_url ?? 'https://via.placeholder.com/300x160' }}" alt="{{ $article->title }}" class="card-img">
                    </div>
                    <div class="card-content">
                        <span class="card-tag">{{ ucfirst($article->category) }}</span>
                        <h3 class="card-title">{{ Str::limit($article->title, 80) }}</h3>
                        <p class="card-excerpt">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                        <div class="card-meta">
                            <div>
                                <small>By {{ $article->author->name ?? 'Admin' }}</small><br>
                                <small>{{ $article->created_at->format('M d, Y') }}</small>
                            </div>
                            <div>
                                @if($article->featured ?? false)
                                    <i class="fas fa-star" style="color: var(--judul); font-size: 12px;" title="Featured"></i>
                                @endif
                                <i class="fas fa-eye" style="color: var(--text); font-size: 11px;" title="Views"></i>
                                <span style="font-size: 11px;">{{ $article->views ?? rand(50, 500) }}</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach
            @else
                <div class="empty-state" style="grid-column: 1 / -1;">
                    <i class="fas fa-newspaper"></i>
                    <h3>No news found</h3>
                    <p>Try adjusting your search or filter criteria.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($news->hasPages())
        <div class="pagination">
            @if($news->onFirstPage())
                <span class="page-btn disabled">‹</span>
            @else
                <a href="{{ $news->previousPageUrl() }}" class="page-btn">‹</a>
            @endif
            
            @for($i = 1; $i <= $news->lastPage(); $i++)
                @if($i == $news->currentPage())
                    <span class="page-btn active">{{ $i }}</span>
                @else
                    <a href="{{ $news->url($i) }}" class="page-btn">{{ $i }}</a>
                @endif
            @endfor
            
            @if($news->hasMorePages())
                <a href="{{ $news->nextPageUrl() }}" class="page-btn">›</a>
            @else
                <span class="page-btn disabled">›</span>
            @endif
        </div>
        @endif
    </div>

    <!-- JavaScript for Search and Filter -->
    <script>
        let searchTimeout;
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const newsGrid = document.getElementById('newsGrid');

        function performSearch() {
            const search = searchInput.value;
            const category = categoryFilter.value;
            
            // Show loading state
            showLoading();
            
            // Make AJAX request
            fetch(`{{ route('student.news.search') }}?search=${encodeURIComponent(search)}&category=${encodeURIComponent(category)}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    newsGrid.innerHTML = data.html;
                    // Update pagination if provided
                    if (data.pagination) {
                        updatePagination(data.pagination);
                    }
                }
            })
            .catch(error => {
                console.error('Search error:', error);
                showError();
            });
        }

        function showLoading() {
            newsGrid.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin fa-2x"></i><br>Loading...</div>';
        }

        function showError() {
            newsGrid.innerHTML = '<div class="empty-state"><i class="fas fa-exclamation-triangle"></i><h3>Error loading news</h3><p>Please try again later.</p></div>';
        }

        function updatePagination(paginationHtml) {
            const paginationContainer = document.querySelector('.pagination');
            if (paginationContainer) {
                paginationContainer.innerHTML = paginationHtml;
            }
        }

        // Search input with debounce
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(performSearch, 300);
        });

        // Category filter
        categoryFilter.addEventListener('change', performSearch);
    </script>
</body>
</html>