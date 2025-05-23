{{-- resources/views/admin/news/partials/news-grid.blade.php --}}

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
                <small class="text-muted">
                    <i class="fas fa-eye"></i> {{ number_format($article->views) }} views
                </small>
            </div>
            <div class="news-actions">
                <a href="{{ route('admin.news.show', $article->id) }}" class="btn btn-info btn-sm" title="View">
                    <i class="fas fa-eye"></i>
                </a>
                <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-warning btn-sm" title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                
                <!-- Quick Actions -->
                @if($article->status == 'draft')
                    <form method="POST" action="{{ route('admin.news.update', $article->id) }}" class="d-inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="published">
                        <input type="hidden" name="publish_date" value="{{ now() }}">
                        <button type="submit" class="btn btn-success btn-sm" title="Publish" 
                                onclick="return confirm('Publish this news?')">
                            <i class="fas fa-globe"></i>
                        </button>
                    </form>
                @endif
                
                <form method="POST" action="{{ route('admin.news.toggle-featured', $article->id) }}" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $article->featured ? 'btn-warning' : 'btn-outline-warning' }} btn-sm" 
                            title="{{ $article->featured ? 'Remove Featured' : 'Make Featured' }}">
                        <i class="fas fa-star"></i>
                    </button>
                </form>
                
                <form method="POST" action="{{ route('admin.news.destroy', $article->id) }}" class="d-inline" 
                      onsubmit="return confirm('Are you sure you want to delete this news?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
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
        <p>No news articles match your current filters.</p>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">Create News</a>
    </div>
</div>
@endforelse