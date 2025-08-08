@props(['blogs'])

@if($blogs->count() > 0)
    <div class="sidebar-section rounded-3">
        <h4 class="sidebar-title">
            <i class="fas fa-newspaper sidebar-icon"></i>
            Related Articles
        </h4>
        
        @foreach($blogs as $related)
            <a href="{{ route('blogs.show', $related->slug) }}" class="sidebar-blog-item">
                <img src="{{ $related->featured_image ? asset('storage/' . $related->featured_image) : asset('assets/images/blog-placeholder.jpg') }}" 
                     class="sidebar-blog-image" 
                     alt="{{ $related->title }}">
                <div class="sidebar-blog-content">
                    <h6>{{ Str::limit($related->title, 60) }}</h6>
                    <div class="sidebar-blog-date">
                        {{ $related->created_at->format('M d, Y') }}
                        @if($related->getAuthorDisplayName())
                            • by {{ $related->getAuthorDisplayName() }}
                        @endif
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endif