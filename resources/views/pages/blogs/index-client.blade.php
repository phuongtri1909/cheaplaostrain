@extends('layouts.app')

@section('title', 'Blog & News - Latest Updates')
@section('description', 'Stay updated with the latest news, insights, and updates from our blog')
@section('keywords', 'blog, news, updates, articles, insights')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/blog-common.css') }}">
<style>
    .blog-hero {
        background: var(--gradient-green);
        color: white;
        padding: 80px 0 60px 0;
        position: relative;
        overflow: hidden;
    }

    .blog-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>') no-repeat center center;
        background-size: cover;
    }

    .blog-hero h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        animation: fadeInUp 1s ease-out;
    }

    .blog-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        animation: fadeInUp 1s ease-out 0.2s both;
    }

    .blog-container {
        padding: 80px 0;
        background: var(--soft-gray);
    }

    .blog-card {
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        overflow: hidden;
        transition: var(--blog-transition-smooth);
        margin-bottom: 2rem;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .blog-card:hover {
        transform: translateY(-10px);
    }

    .blog-image-wrapper {
        position: relative;
        overflow: hidden;
        height: 360px;
    }

    .blog-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: var(--blog-transition-slow);
    }

    .blog-card:hover .blog-image {
        transform: scale(1.1);
    }

    .blog-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        background: var(--primary-green);
        color: white;
        padding: 6px 12px;
        border-radius: var(--radius-md);
        font-size: 0.8rem;
        font-weight: 600;
    }

    .blog-content {
        padding: 1.5rem;
    }

    .blog-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        color: var(--text-light);
    }

    .blog-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.8rem;
        line-height: 1.4;
        transition: var(--blog-transition-fast);
    }

    .blog-card:hover .blog-title {
        color: var(--primary-green);
    }

    .blog-excerpt {
        color: var(--text-medium);
        line-height: 1.6;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }

    .read-more {
        color: var(--primary-green);
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: var(--blog-transition-fast);
    }

    .read-more:hover {
        color: var(--primary-green-dark);
        gap: 12px;
    }

    /* Pagination */
    .custom-pagination {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .custom-pagination .pagination {
        gap: 8px;
    }

    .custom-pagination .page-link {
        border: 2px solid var(--accent-green);
        color: var(--primary-green);
        background: var(--warm-white);
        padding: 10px 16px;
        border-radius: var(--radius-md);
        font-weight: 500;
        transition: var(--blog-transition-fast);
    }

    .custom-pagination .page-link:hover,
    .custom-pagination .page-item.active .page-link {
        background: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
        transform: translateY(-2px);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .blog-hero h1 {
            font-size: 2.2rem;
        }
        
        .blog-hero {
            padding: 60px 0 40px 0;
        }
        
        .blog-container {
            padding: 60px 0;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="blog-hero">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h1>Blog & News</h1>
                <p>Stay updated with the latest insights, tips, and news from our experts</p>
            </div>
        </div>
    </div>
</div>

<!-- Blog Content -->
<div class="blog-container">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                @if($blogs->count() > 0)
                    <div class="blog-grid">
                        @foreach($blogs as $index => $blog)
                            <article class="blog-card" style="animation-delay: {{ $index * 0.1 }}s">
                                <a href="{{ route('blogs.show', $blog->slug) }}" class="text-decoration-none">
                                    <div class="blog-image-wrapper">
                                        @if($blog->featured_image)
                                            <img src="{{ asset('storage/' . $blog->featured_image) }}" 
                                                 class="blog-image" 
                                                 alt="{{ $blog->title }}">
                                        @else
                                            <img src="{{ asset('assets/images/blog-placeholder.jpg') }}" 
                                                 class="blog-image" 
                                                 alt="{{ $blog->title }}">
                                        @endif
                                        
                                        @if($blog->is_featured)
                                            <span class="blog-badge">
                                                <i class="fas fa-star"></i> Featured
                                            </span>
                                        @endif
                                    </div>
                                    
                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <span><i class="far fa-calendar"></i> {{ $blog->created_at->format('M d, Y') }}</span>
                                            @if($blog->getAuthorDisplayName())
                                                <span><i class="fas fa-user"></i> {{ $blog->getAuthorDisplayName() }}</span>
                                            @endif
                                            <span><i class="far fa-clock"></i> {{ ceil(str_word_count(strip_tags($blog->content)) / 200) }} min read</span>
                                        </div>
                                        
                                        <h3 class="blog-title">{{ $blog->title }}</h3>
                                        
                                        @if($blog->subtitle)
                                            <p class="blog-excerpt">{{ Str::limit($blog->subtitle, 120) }}</p>
                                        @endif
                                        
                                        <span class="read-more">
                                            Read More <i class="fas fa-arrow-right"></i>
                                        </span>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="custom-pagination">
                        {{ $blogs->links('components.pagination') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h3>No Articles Yet</h3>
                        <p class="text-muted">We're working on bringing you great content. Check back soon!</p>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Featured Articles -->
                <x-blog.featured-articles :blogs="$featuredBlogs" />

                <!-- Recent Articles -->
                <x-blog.recent-articles :blogs="$recentBlogs" />

                <!-- CTA Section -->
                <x-blog.cta-section />
            </div>
        </div>
    </div>
</div>
@endsection