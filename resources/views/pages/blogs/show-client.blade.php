@extends('layouts.app')

@section('title', $blog->title . ' - Blog')
@section('description', $blog->subtitle ?: Str::limit(strip_tags($blog->content), 160))
@section('keywords', 'blog, article, ' . str_replace(' ', ', ', $blog->title))

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog-common.css') }}">
<style>
    .blog-detail-container {
        padding: 60px 0;
        background: var(--soft-gray);
    }

    .breadcrumb-nav {
        background: var(--warm-white);
        padding: 1rem 0;
        border-bottom: 1px solid var(--accent-green);
    }

    .breadcrumb {
        background: none;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: var(--primary-green);
        text-decoration: none;
        font-weight: 500;
        transition: var(--blog-transition-fast);
    }

    .breadcrumb-item a:hover {
        color: var(--primary-green-dark);
    }

    .blog-detail-card {
        background: white;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .blog-header {
        padding: 2rem;
        border-bottom: 1px solid var(--accent-green);
    }

    .blog-detail-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--text-dark);
        line-height: 1.3;
        margin-bottom: 1rem;
    }

    .blog-detail-subtitle {
        font-size: 1.2rem;
        color: var(--text-medium);
        margin-bottom: 1.5rem;
        line-height: 1.5;
    }

    .blog-detail-meta {
        display: flex;
        align-items: center;
        gap: 20px;
        font-size: 0.95rem;
        color: var(--text-light);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .blog-featured-image {
        width: 100%;
        max-height: 450px;
        object-fit: scale-down;
    }

    .blog-detail-content {
        padding: 2rem;
    }

    .blog-detail-content h1,
    .blog-detail-content h2,
    .blog-detail-content h3,
    .blog-detail-content h4,
    .blog-detail-content h5,
    .blog-detail-content h6 {
        color: var(--text-dark);
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .blog-detail-content p {
        line-height: 1.8;
        margin-bottom: 1.5rem;
        color: var(--text-medium);
    }

    .blog-detail-content img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-md);
        margin: 1.5rem 0;
    }

    /* Blog Navigation */
    .blog-nav-item {
        text-decoration: none;
        color: var(--text-dark);
        transition: var(--blog-transition-smooth);
        flex: 1;
        padding: 1rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--accent-green);
        background: var(--warm-white);
    }

    .blog-nav-item:hover {
        color: var(--primary-green);
        background: var(--accent-green);
        transform: translateY(-2px);
    }

    .blog-nav-label {
        font-size: 0.85rem;
        color: var(--text-light);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
    }

    .blog-nav-title {
        font-weight: 600;
        line-height: 1.3;
        font-size: 0.95rem;
    }

    @media (max-width: 768px) {
        .blog-detail-title {
            font-size: 1.8rem;
        }
        
        .blog-header,
        .blog-detail-content {
            padding: 1.5rem;
        }
        
        .blog-nav-item {
            padding: 0.75rem;
        }

        .blog-detail-meta {
            flex-wrap: wrap;
            gap: 15px;
        }
    }
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<div class="breadcrumb-nav">
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Home
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('blogs') }}">Blog</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ Str::limit($blog->title, 50) }}
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Blog Detail Content -->
<div class="blog-detail-container">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Blog Navigation -->
                @if($previousBlog || $nextBlog)
                    <div class="blog-post-navigation mb-3">
                        <div class="d-flex gap-3">
                            @if($previousBlog)
                                <a href="{{ route('blogs.show', $previousBlog->slug) }}" class="blog-nav-item">
                                    <div class="blog-nav-label">
                                        <i class="fas fa-chevron-left"></i> Previous Article
                                    </div>
                                    <div class="blog-nav-title">{{ Str::limit($previousBlog->title, 60) }}</div>
                                </a>
                            @else
                                <div class="blog-nav-item" style="opacity: 0; pointer-events: none;"></div>
                            @endif
                            
                            @if($nextBlog)
                                <a href="{{ route('blogs.show', $nextBlog->slug) }}" class="blog-nav-item text-end">
                                    <div class="blog-nav-label justify-content-end">
                                        Next Article <i class="fas fa-chevron-right"></i>
                                    </div>
                                    <div class="blog-nav-title">{{ Str::limit($nextBlog->title, 60) }}</div>
                                </a>
                            @else
                                <div class="blog-nav-item" style="opacity: 0; pointer-events: none;"></div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Blog Article -->
                <article class="blog-detail-card rounded-3">
                    <div class="blog-header">
                        <h1 class="blog-detail-title">{{ $blog->title }}</h1>
                        
                        @if($blog->subtitle)
                            <p class="blog-detail-subtitle">{{ $blog->subtitle }}</p>
                        @endif
                        
                        <div class="blog-detail-meta">
                            <div class="meta-item">
                                <i class="far fa-calendar"></i>
                                <span>{{ $blog->created_at->format('F d, Y') }}</span>
                            </div>
                            @if($blog->getAuthorDisplayName())
                                <div class="meta-item">
                                    <i class="fas fa-user"></i>
                                    <span>{{ $blog->getAuthorDisplayName() }}</span>
                                </div>
                            @endif
                            <div class="meta-item">
                                <i class="far fa-clock"></i>
                                <span>{{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</span>
                            </div>
                            @if($blog->is_featured)
                                <div class="meta-item">
                                    <i class="fas fa-star text-warning"></i>
                                    <span>Featured</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($blog->featured_image)
                        <div class="blog-image-container">
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                 class="blog-featured-image" 
                                 alt="{{ $blog->title }}">
                        </div>
                    @endif
                    
                    <div class="blog-detail-content">
                        {!! $blog->content !!}
                    </div>
                </article>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Articles -->
                <x-blog.featured-articles :blogs="$featuredBlogs" :current-blog-id="$blog->id" />

                <!-- Related Articles -->
                <x-blog.related-articles :blogs="$relatedBlogs" />

                <!-- CTA Section -->
                <x-blog.cta-section />
            </div>
        </div>
    </div>
</div>
@endsection