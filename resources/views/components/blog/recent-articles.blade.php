@props(['blogs'])

@if($blogs->count() > 0)
    <div class="sidebar-section rouned-3">
        <h4 class="sidebar-title">
            <i class="fas fa-clock sidebar-icon"></i>
            Recent Articles
        </h4>
        
        @foreach($blogs as $recent)
            <a href="{{ route('blogs.show', $recent->slug) }}" class="sidebar-blog-item">
                <img src="{{ $recent->featured_image ? asset('storage/' . $recent->featured_image) : asset('assets/images/blog-placeholder.jpg') }}" 
                     class="sidebar-blog-image" 
                     alt="{{ $recent->title }}">
                <div class="sidebar-blog-content">
                    <h6>{{ Str::limit($recent->title, 60) }}</h6>
                    <div class="sidebar-blog-date">
                        {{ $recent->created_at->format('M d, Y') }}
                        @if($recent->getAuthorDisplayName())
                            • by {{ $recent->getAuthorDisplayName() }}
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif