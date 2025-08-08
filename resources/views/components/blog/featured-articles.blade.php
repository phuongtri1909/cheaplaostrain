@props(['blogs', 'currentBlogId' => null])

@if($blogs->count() > 0)
    <div class="sidebar-section rounded-3">
        <h4 class="sidebar-title">
            <i class="fas fa-star sidebar-icon"></i>
            Featured Articles
        </h4>
        
        @foreach($blogs->take(4) as $featured)
            @if($currentBlogId === null || $featured->id !== $currentBlogId)
                <a href="{{ route('blogs.show', $featured->slug) }}" class="sidebar-blog-item">
                    <img src="{{ $featured->featured_image ? asset('storage/' . $featured->featured_image) : asset('assets/images/blog-placeholder.jpg') }}" 
                         class="sidebar-blog-image" 
                         alt="{{ $featured->title }}">
                    <div class="sidebar-blog-content">
                        <h6>{{ Str::limit($featured->title, 60) }}</h6>
                        <div class="sidebar-blog-date">
                            {{ $featured->created_at->format('M d, Y') }}
                            @if($featured->getAuthorDisplayName())
                                • by {{ $featured->getAuthorDisplayName() }}
                            @endif
                        </div>
                    </div>
                </a>
            @endif
        @endforeach
    </div>
@endif