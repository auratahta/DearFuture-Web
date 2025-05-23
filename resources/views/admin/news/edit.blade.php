<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit News - Admin Dashboard</title>
    
    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Krona+One&family=Rubik:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- CKEditor -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    
    <style>
        :root {
            --primary-color: #5af7ff;
            --secondary-color: #131b31;
            --text-color: #e4e4e4;
            --text-muted: #a0a0a0;
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
        
        .page-header p {
            color: var(--text-muted) !important;
            margin-bottom: 0;
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
        
        .form-container {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        
        .form-control, .form-select, .form-check-input {
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
        
        .form-label {
            color: var(--text-color) !important;
            font-weight: 500;
            margin-bottom: 8px;
        }
        
        /* Form Text & Small Text - Fixed */
        .form-text, 
        .text-muted, 
        small.text-muted,
        .small.text-muted {
            color: var(--text-muted) !important;
        }
        
        /* Statistics Section - Fixed */
        .small.text-muted div,
        .text-muted div {
            color: var(--text-muted) !important;
        }
        
        /* Character Counter */
        .char-counter {
            color: var(--text-muted) !important;
        }
        
        .char-counter.text-warning {
            color: #ffc107 !important;
        }
        
        .char-counter.text-danger {
            color: #dc3545 !important;
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
        
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }
        
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: #fff;
        }
        
        .preview-image {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            margin-top: 10px;
        }
        
        .current-image {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            margin-bottom: 10px;
        }
        
        .form-check-label {
            color: var(--text-color) !important;
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            color: #f8d7da;
        }
        
        .invalid-feedback {
            color: #f8d7da;
        }
        
        .is-invalid {
            border-color: #dc3545 !important;
        }

        /* CKEditor Dark Theme Override */
        .ck-editor__editable {
            min-height: 300px;
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: var(--text-color) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .ck-editor__editable:focus {
            border-color: var(--primary-color) !important;
            box-shadow: 0 0 0 0.2rem rgba(90, 247, 255, 0.25) !important;
        }

        .ck.ck-toolbar {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .ck.ck-button {
            color: var(--text-color) !important;
        }

        .ck.ck-button:hover {
            background-color: rgba(90, 247, 255, 0.1) !important;
        }

        /* Image Preview Text */
        #imagePreview .small {
            color: var(--text-muted) !important;
        }

        /* Bootstrap Override for Dark Theme */
        .text-muted {
            color: var(--text-muted) !important;
        }

        /* Ensure all small text is visible */
        small, 
        .small {
            color: var(--text-muted) !important;
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
                <h1>Edit News</h1>
                <p class="mb-0">Update news article: {{ $news->title }}</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.news.show', $news->id) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> View
                </a>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to News
                </a>
            </div>
        </div>
        
        <!-- Error Messages -->
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h6 class="mb-2">Please fix the following errors:</h6>
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        
        <!-- Form -->
        <div class="form-container">
            <form method="POST" action="{{ route('admin.news.update', $news->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <!-- Title -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Title *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $news->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Excerpt -->
                        <div class="mb-3">
                            <label for="excerpt" class="form-label">Excerpt *</label>
                            <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                      id="excerpt" name="excerpt" rows="3" required>{{ old('excerpt', $news->excerpt) }}</textarea>
                            <small class="form-text text-muted">Brief summary of the news (max 500 characters)</small>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Content -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Content *</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="10" required>{{ old('content', $news->content) }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Tags -->
                        <div class="mb-3">
                            <label for="tags" class="form-label">Tags</label>
                            <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" name="tags" value="{{ old('tags', $news->tags_as_string) }}" 
                                   placeholder="Separate tags with commas">
                            <small class="form-text text-muted">Example: announcement, important, semester</small>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-4">
                        <!-- Category -->
                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="announcements" {{ old('category', $news->category) == 'announcements' ? 'selected' : '' }}>
                                    Announcements
                                </option>
                                <option value="events" {{ old('category', $news->category) == 'events' ? 'selected' : '' }}>
                                    Events
                                </option>
                                <option value="academic" {{ old('category', $news->category) == 'academic' ? 'selected' : '' }}>
                                    Academic
                                </option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select @error('status') is-invalid @enderror" 
                                    id="status" name="status" required>
                                <option value="draft" {{ old('status', $news->status) == 'draft' ? 'selected' : '' }}>
                                    Draft
                                </option>
                                <option value="published" {{ old('status', $news->status) == 'published' ? 'selected' : '' }}>
                                    Published
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Publish Date -->
                        <div class="mb-3">
                            <label for="publish_date" class="form-label">Publish Date *</label>
                            <input type="datetime-local" class="form-control @error('publish_date') is-invalid @enderror" 
                                   id="publish_date" name="publish_date" 
                                   value="{{ old('publish_date', $news->publish_date ? $news->publish_date->format('Y-m-d\TH:i') : '') }}" required>
                            @error('publish_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- Featured -->
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="featured" name="featured" 
                                       {{ old('featured', $news->featured) ? 'checked' : '' }}>
                                <label class="form-check-label" for="featured">
                                    Featured News
                                </label>
                            </div>
                            <small class="form-text text-muted">Featured news will be highlighted on the homepage</small>
                        </div>
                        
                        <!-- Current Image -->
                        @if($news->image)
                        <div class="mb-3">
                            <label class="form-label">Current Image</label>
                            <div>
                                <img src="{{ $news->image_url }}" alt="Current Image" class="current-image">
                            </div>
                        </div>
                        @endif
                        
                        <!-- Image Upload -->
                        <div class="mb-3">
                            <label for="image" class="form-label">{{ $news->image ? 'Replace Image' : 'Featured Image' }}</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <small class="form-text text-muted">{{ $news->image ? 'Leave empty to keep current image' : 'Recommended size: 800x600px' }}</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div id="imagePreview"></div>
                        </div>
                        
                        <!-- Stats -->
                        <div class="mb-3">
                            <label class="form-label">Statistics</label>
                            <div class="small text-muted">
                                <div>Views: {{ $news->views }}</div>
                                <div>Created: {{ $news->created_at->format('M d, Y H:i') }}</div>
                                <div>Updated: {{ $news->updated_at->format('M d, Y H:i') }}</div>
                                <div>Author: {{ $news->author->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update News
                            </button>
                            <a href="{{ route('admin.news.show', $news->id) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View News
                            </a>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Initialize CKEditor
        ClassicEditor
            .create(document.querySelector('#content'), {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'link', 'blockQuote', '|',
                        'insertTable', '|',
                        'undo', 'redo'
                    ]
                },
                heading: {
                    options: [
                        { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                        { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                        { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                        { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                    ]
                }
            })
            .catch(error => {
                console.error(error);
            });
        
        // Image preview function
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'preview-image';
                    const label = document.createElement('div');
                    label.className = 'small text-muted mt-1';
                    label.textContent = 'New image preview:';
                    preview.appendChild(label);
                    preview.appendChild(img);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Character count for excerpt
        document.getElementById('excerpt').addEventListener('input', function() {
            const maxLength = 500;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            
            // Find or create counter element
            let counter = this.parentNode.querySelector('.char-counter');
            if (!counter) {
                counter = document.createElement('small');
                counter.className = 'form-text text-muted char-counter';
                this.parentNode.appendChild(counter);
            }
            
            counter.textContent = `${currentLength}/${maxLength} characters`;
            
            if (remaining < 0) {
                counter.className = 'form-text text-danger char-counter';
            } else if (remaining < 50) {
                counter.className = 'form-text text-warning char-counter';
            } else {
                counter.className = 'form-text text-muted char-counter';
            }
        });
        
        // Trigger character count on load
        document.getElementById('excerpt').dispatchEvent(new Event('input'));
    </script>
</body>
</html>