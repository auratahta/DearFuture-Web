<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - DearFuture</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- News Show CSS -->
    <link rel="stylesheet" href="{{ asset('css/news-show.css') }}">
</head>

<body>
    <!-- Navbar -->
     <!-- Navbar Start -->
    <nav class="navbar">
        <a href="#" class="navbar-logo">DearFuture</a>
        
         <div class="nav-links">
            <a href="{{ url('/student/menu') }}">Home</a>
            <a href="{{ route('student.news.index') }}">News</a>
            <a href="{{ url('/student/subjects') }}">Subjects</a>
            <a href="{{ url('/student/history') }}">History</a>
        </div>
        
        <div class="navbar-extra" onclick="window.location.href='{{ route('student.profile') }}';" style="cursor: pointer;">
            <span class="user-name">{{ Auth::user()->name }}</span>
            <img src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('image/profile.png') }}" alt="User Profile" class="user-avatar">
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Main Content -->
    <div class="article-container">
        <!-- Back Button -->
        <a href="{{ route('student.news.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i>
            Back to News
        </a>

        <!-- Article Header -->
        <div class="article-header">
            <span class="article-category">{{ ucfirst($news->category) }}</span>
            <h1 class="article-title">{{ $news->title }}</h1>
            
            <div class="article-meta">
                <div class="author-info">
                    <div>
                        <strong>By {{ $news->author->name ?? 'Admin' }}</strong>
                    </div>
                </div>
                <div class="publication-info">
                    <div>Published: {{ $news->created_at->format('M d, Y') }}</div>
                    <div>Reading time: {{ $news->reading_time ?? '5' }} min read</div>
                </div>
            </div>
        </div>

        <!-- Article Image -->
        @if($news->image_url)
        <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="article-image">
        @endif

        <!-- Article Content -->
        <div class="article-content">
            {!! $news->content !!}
        </div>

        <!-- Social Share -->
        <div class="share-section">
            <h3 class="share-title">Share this article</h3>
            <div class="share-buttons">
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($news->title) }}" target="_blank" class="share-btn twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="share-btn linkedin">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . request()->fullUrl()) }}" target="_blank" class="share-btn whatsapp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>

        <!-- Related News -->
        @if($relatedNews && $relatedNews->count() > 0)
        <div class="related-section">
            <h2 class="related-title">Related Articles</h2>
            <div class="related-grid">
                @foreach($relatedNews as $related)
                <a href="{{ route('student.news.show', $related->id) }}" class="related-card">
                    <img src="{{ $related->image_url ?? 'https://via.placeholder.com/300x120' }}" alt="{{ $related->title }}" class="related-img">
                    <div class="related-content">
                        <span class="related-category">{{ ucfirst($related->category) }}</span>
                        <h4 class="related-card-title">{{ Str::limit($related->title, 60) }}</h4>
                        <div class="related-date">{{ $related->created_at->format('M d, Y') }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- JavaScript for smooth interactions -->
    <script>
        // Smooth scroll for internal links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Social share tracking (optional)
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const platform = this.classList[1];
                console.log(`Shared on ${platform}`);
                // Add analytics tracking here if needed
            });
        });
    </script>
</body>
</html>