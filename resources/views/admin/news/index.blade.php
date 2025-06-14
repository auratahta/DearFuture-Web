<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Management - Admin Dashboard</title>
    
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
            margin-bottom: 0;
            color: var(--primary-color);
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
        }
        
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .stat-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .stat-value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--primary-color);
        }
        
        .stat-label {
            font-size: 12px;
            color: #a0a0a0;
        }
        
        .filters-container {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .news-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }
        
        .news-card {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .news-card:hover {
            transform: translateY(-5px);
        }
        
        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .news-card-content {
            padding: 20px;
        }
        
        .news-category {
            background-color: var(--primary-color);
            color: #000;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 10px;
        }
        
        .news-title {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }
        
        .news-excerpt {
            font-size: 14px;
            color: #a0a0a0;
            margin-bottom: 15px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        
        .news-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #a0a0a0;
        }
        
        .news-actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .form-control, .form-select {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-color);
        }
        
        .form-control:focus, .form-select:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--primary-color);
            color: var(--text-color);
            box-shadow: 0 0 0 0.2rem rgba(90, 247, 255, 0.25);
        }
        
        .pagination {
            justify-content: center;
        }
        
        .page-link {
            background-color: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            color: var(--text-color);
        }
        
        .page-link:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
        }
        
        .page-item.active .page-link {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #000;
        }
        
        .badge {
            font-size: 10px;
            padding: 4px 8px;
        }
        
        .status-published {
            background-color: rgba(28, 200, 138, 0.2);
            color: #1cc88a;
        }
        
        .status-draft {
            background-color: rgba(247, 194, 68, 0.2);
            color: #f7c244;
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
                <h1>News Management</h1>
                <p class="mb-0">Manage news articles and announcements</p>
            </div>
            <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Create News
            </a>
        </div>
        
        <!-- Statistics -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total News</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">{{ $stats['published'] }}</div>
                <div class="stat-label">Published</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">{{ $stats['draft'] }}</div>
                <div class="stat-label">Draft</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">{{ $stats['featured'] }}</div>
                <div class="stat-label">Featured</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">{{ $stats['announcements'] }}</div>
                <div class="stat-label">Announcements</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">{{ $stats['events'] }}</div>
                <div class="stat-label">Events</div>
            </div>
            
            <div class="stat-card">
                <div class="stat-value">{{ $stats['academic'] }}</div>
                <div class="stat-label">Academic</div>
            </div>
        </div>
        
        <!-- Filters -->
        <div class="filters-container">
            <form method="GET" action="{{ route('admin.news.index') }}" class="row g-3">
                <div class="col-md-4">
                    <input type="text" class="form-control" name="search" placeholder="Search news..." value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="category">
                        <option value="">All Categories</option>
                        <option value="announcements" {{ request('category') == 'announcements' ? 'selected' : '' }}>Announcements</option>
                        <option value="events" {{ request('category') == 'events' ? 'selected' : '' }}>Events</option>
                        <option value="academic" {{ request('category') == 'academic' ? 'selected' : '' }}>Academic</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" name="status">
                        <option value="">All Status</option>
                        <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
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
        
        <!-- News Grid -->
        <div class="news-grid">
            @forelse($news as $article)
            <div class="news-card">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}">
                <div class="news-card-content">
                    <span class="news-category">{{ $article->category_label }}</span>
                    <h3 class="news-title">{{ $article->title }}</h3>
                    <p class="news-excerpt">{{ $article->excerpt }}</p>
                    <div class="news-meta">
                        <div>
                            <small>By {{ $article->author->name }}</small><br>
                            <small>{{ $article->formatted_publish_date }}</small><br>
                            <span class="badge {{ $article->status == 'published' ? 'status-published' : 'status-draft' }}">
                                {{ $article->status_label }}
                            </span>
                            @if($article->featured)
                                <span class="badge bg-warning text-dark">Featured</span>
                            @endif
                        </div>
                        <div class="news-actions">
                            <a href="{{ route('admin.news.show', $article->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.news.destroy', $article->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this news?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-newspaper fa-3x mb-3" style="color: #a0a0a0;"></i>
                    <h4>No news found</h4>
                    <p>Start by creating your first news article.</p>
                    <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Create News</a>
                </div>
            </div>
            @endforelse
        </div>
        
        <!-- Pagination -->
        @if($news->hasPages())
            <div class="d-flex justify-content-center">
                {{ $news->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>