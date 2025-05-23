@forelse($news as $article)
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
@empty
<div class="empty-state" style="grid-column: 1 / -1;">
    <i class="fas fa-newspaper"></i>
    <h3>No news found</h3>
    <p>Try adjusting your search or filter criteria.</p>
</div>
@endforelse