<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $news->title }} - Admin Dashboard</title>
    
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
        
        .page-header {
            background: linear-gradient(135deg, #131b31 0%, #1a2342 100%);
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .page-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary-color);
        }
        
        .news-container {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 25px;
        }
        
        .news-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .news-category {
            background-color: var(--primary-color);
            color: #000;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
            margin-bottom: 15px;
        }
        
        .news-title {
            font-size: 2.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            line-height: 1.3;
        }
        
        .news-meta {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            font-size: 14px;
            color: #888;
            flex-wrap: wrap;
        }
        
        .meta-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }
        
        .meta-item i {
            color: var(--primary-color);
        }
        
        .featured-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .news-excerpt {
            font-size: 1.2rem;
            font-weight: 500;
            color: #ccc;
            margin-bottom: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            border-left: 4px solid var(--primary-color);
        }
        
        .news-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--text-color);
        }
        
        .news-content h1,
        .news-content h2,
        .news-content h3,
        .news-content h4,
        .news-content h5,
        .news-content h6 {
            color: var(--primary-color);
            margin-top: 30px;
            margin-bottom: 15px;
        }
        
        .news-content p {
            margin-bottom: 20px;
        }
        
        .news-content ul,
        .news-content ol {
            margin-bottom: 20px;
            padding-left: 30px;
        }
        
        .news-content li {
            margin-bottom: 8px;
        }
        
        .news-content blockquote {
            border-left: 4px solid var(--primary-color);
            padding-left: 20px;
            margin: 20px 0;
            font-style: italic;
            color: #ccc;
        }
        
        .news-tags {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .tags-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 10px;
        }
        
        .tags-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .tag {
            background-color: rgba(255, 255, 255, 0.1);
            color: var(--text-color);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .admin-actions {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
            font-weight: 600;
        }
        
        .btn-primary:hover {
            background-color: #4ae6ed;
            border-color: #4ae6ed;
            color: #000;
        }
        
        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            color: var(--text-color);
        }
        
        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-color: rgba(255, 255, 255, 0.3);
            color: var(--text-color);
        }
        
        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #000;
        }
        
        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #e0a800;
            color: #000;
        }
        
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .btn-success:hover {
            background-color: #218838;
            border-color: #218838;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-published {
            background-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
        }
        
        .status-draft {
            background-color: rgba(247, 194, 68, 0.2);
            color: #f7c244;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .stat-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 15px;
            border-radius: 8px;
        }
        
        .stat-label {
            font-size: 12px;
            color: #888;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 16px;
            font-weight: 600;
            color: var(--primary-color);
        }
        
        .alert-success {
            background-color: rgba(28, 200, 138, 0.1);
            border-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            color: #f8d7da;
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
                <a href="{{ route('admin.users.index') }}">
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
                <a href="{{ route('admin.news.index') }}" class="active">
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
        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1>News Details</h1>
                <div class="d-flex align-items-center gap-2">
                    <span class="status-badge {{ $news->status == 'published' ? 'status-published' : 'status-draft' }}">
                        {{ $news->status_label }}
                    </span>
                    @if($news->featured)
                        <span class="badge bg-warning text-dark">Featured</span>
                    @endif
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to News
                </a>
            </div>
        </div>
        
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Admin Statistics -->
        <div class="admin-actions">
            <h5 class="mb-3">Article Statistics</h5>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-label">Views</div>
                    <div class="stat-value">{{ number_format($news->views) }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Status</div>
                    <div class="stat-value">{{ $news->status_label }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Category</div>
                    <div class="stat-value">{{ $news->category_label }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Author</div>
                    <div class="stat-value">{{ $news->author->name }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Created</div>
                    <div class="stat-value">{{ $news->created_at->format('M d, Y') }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-label">Updated</div>
                    <div class="stat-value">{{ $news->updated_at->format('M d, Y') }}</div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit News
                </a>
                
                @if($news->status == 'draft')
                    <form method="POST" action="{{ route('admin.news.update', $news->id) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="published">
                        <input type="hidden" name="publish_date" value="{{ now() }}">
                        <button type="submit" class="btn btn-success" onclick="return confirm('Are you sure you want to publish this news?')">
                            <i class="fas fa-globe"></i> Publish Now
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ route('admin.news.update', $news->id) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="draft">
                        <button type="submit" class="btn btn-secondary" onclick="return confirm('Are you sure you want to unpublish this news?')">
                            <i class="fas fa-eye-slash"></i> Unpublish
                        </button>
                    </form>
                @endif
                
                <form method="POST" action="{{ route('admin.news.toggle-featured', $news->id) }}" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $news->featured ? 'btn-warning' : 'btn-primary' }}">
                        <i class="fas fa-star"></i> {{ $news->featured ? 'Remove Featured' : 'Make Featured' }}
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.news.destroy', $news->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this news? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete News
                    </button>
                </form>
                
                @if($news->status == 'published')
                    <a href="{{ route('student.news.show', $news->id) }}" class="btn btn-info" target="_blank">
                        <i class="fas fa-external-link-alt"></i> View Live
                    </a>
                @endif
            </div>
        </div>
        
        <!-- News Content -->
        <div class="news-container">
            <!-- Header -->
            <div class="news-header">
                <span class="news-category">{{ $news->category_label }}</span>
                <h1 class="news-title">{{ $news->title }}</h1>
                <div class="news-meta">
                    <div class="meta-item">
                        <i class="fas fa-user"></i>
                        <span>{{ $news->author->name }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>{{ $news->formatted_publish_date }}</span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-eye"></i>
                        <span>{{ number_format($news->views) }} views</span>
                    </div>
                    @if($news->featured)
                        <div class="meta-item">
                            <i class="fas fa-star"></i>
                            <span>Featured</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Featured Image -->
            @if($news->image)
            <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="featured-image">
            @endif

            <!-- Excerpt -->
            <div class="news-excerpt">
                {{ $news->excerpt }}
            </div>

            <!-- Content -->
            <div class="news-content">
                {!! $news->content !!}
            </div>

            <!-- Tags -->
            @if($news->tags && count($news->tags) > 0)
            <div class="news-tags">
                <div class="tags-label">Tags:</div>
                <div class="tags-list">
                    @foreach($news->tags as $tag)
                    <span class="tag">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert.querySelector('.btn-close')) {
                    alert.querySelector('.btn-close').click();
                }
            });
        }, 5000);
    </script>
</body>
</html>