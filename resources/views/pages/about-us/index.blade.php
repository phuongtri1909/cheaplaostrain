@extends('layouts.app')
@section('title', $aboutUs->title ?? 'About Us')
@section('description', $aboutUs->subtitle ?? 'About Us - Cheap Laos Train')
@section('keyword', 'About Us, Cheap Laos Train, Train Booking, Laos Travel')

@push('styles')
<style>
    .about-hero {
        background: var(--gradient-green);
        color: white;
        padding: 100px 0 80px 0;
        position: relative;
        overflow: hidden;
    }

    .about-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="1000,100 1000,0 0,100"/></svg>') no-repeat center center;
        background-size: cover;
    }

    .about-hero h1 {
        font-size: 3.5rem;
        font-weight: 700;
        margin-bottom: 1.5rem;
        animation: fadeInUp 1s ease-out;
    }

    .about-hero p {
        font-size: 1.3rem;
        opacity: 0.95;
        animation: fadeInUp 1s ease-out 0.2s both;
        line-height: 1.6;
    }

    .hero-image {
        position: relative;
        z-index: 1;
        animation: fadeInUp 1s ease-out 0.4s both;
    }

    .hero-image img {
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-strong);
        max-height: 400px;
        width: 100%;
        object-fit: cover;
    }

    .about-content {
        padding: 80px 0;
        background: var(--warm-white);
    }

    .content-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 3rem;
        box-shadow: var(--shadow-soft);
        margin-bottom: 3rem;
        border-left: 4px solid var(--primary-green);
        transition: var(--transition-smooth);
    }

    .content-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-medium);
    }

    .content-card h2 {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 1.5rem;
        font-size: 2rem;
    }

    .content-card p {
        color: var(--text-medium);
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .mvv-section {
        padding: 80px 0;
        background: var(--soft-green);
    }

    .mvv-card {
        background: white;
        border-radius: var(--radius-lg);
        padding: 2.5rem;
        text-align: center;
        transition: var(--transition-smooth);
        border: 1px solid var(--accent-green);
        height: 100%;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .mvv-card:nth-child(1) { animation-delay: 0.1s; }
    .mvv-card:nth-child(2) { animation-delay: 0.3s; }
    .mvv-card:nth-child(3) { animation-delay: 0.5s; }

    .mvv-card:hover {
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
        border-color: var(--primary-green);
    }

    .mvv-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: white;
        font-size: 2rem;
        transition: var(--transition-smooth);
    }

    .mvv-card:hover .mvv-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .mvv-card h4 {
        color: var(--text-dark);
        font-weight: 700;
        margin-bottom: 1rem;
        font-size: 1.4rem;
    }

    .mvv-card p {
        color: var(--text-medium);
        line-height: 1.6;
    }

    .features-section {
        padding: 80px 0;
        background: var(--warm-white);
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-item {
        background: white;
        padding: 2rem;
        border-radius: var(--radius-lg);
        text-align: center;
        transition: var(--transition-smooth);
        border: 1px solid var(--accent-green);
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .feature-item:nth-child(odd) { animation-delay: 0.2s; }
    .feature-item:nth-child(even) { animation-delay: 0.4s; }

    .feature-item:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-medium);
        border-color: var(--primary-green);
    }

    .feature-icon {
        width: 70px;
        height: 70px;
        background: var(--accent-green);
        color: var(--primary-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 1.8rem;
        transition: var(--transition-smooth);
    }

    .feature-item:hover .feature-icon {
        background: var(--primary-green);
        color: white;
        transform: scale(1.1);
    }

    .feature-item h5 {
        color: var(--text-dark);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .feature-item p {
        color: var(--text-medium);
        line-height: 1.6;
        margin: 0;
    }

    .stats-section {
        padding: 80px 0;
        background: var(--gradient-green);
        color: white;
        position: relative;
        overflow: hidden;
    }

    .stats-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" fill="white" opacity="0.1"><circle cx="50" cy="50" r="40"/></svg>') repeat;
        background-size: 100px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 2rem;
        position: relative;
        z-index: 1;
    }

    .stat-item {
        text-align: center;
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease-out forwards;
    }

    .stat-item:nth-child(1) { animation-delay: 0.1s; }
    .stat-item:nth-child(2) { animation-delay: 0.3s; }
    .stat-item:nth-child(3) { animation-delay: 0.5s; }
    .stat-item:nth-child(4) { animation-delay: 0.7s; }

    .stat-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.9;
    }

    .stat-number {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        display: block;
    }

    .stat-label {
        font-size: 1.1rem;
        opacity: 0.9;
        font-weight: 500;
    }

    .section-title {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title h2 {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        position: relative;
        display: inline-block;
    }

    .section-title h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        width: 60px;
        height: 4px;
        background: var(--gradient-green);
        transform: translateX(-50%);
        border-radius: 2px;
    }

    .section-title p {
        font-size: 1.2rem;
        color: var(--text-medium);
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
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

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 2.5rem;
        }
        
        .about-hero {
            padding: 80px 0 60px 0;
        }
        
        .content-card,
        .mvv-card {
            padding: 2rem;
        }

        .section-title h2 {
            font-size: 2rem;
        }

        .features-grid,
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-number {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<div class="about-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1>{{ $aboutUs->title }}</h1>
                @if($aboutUs->subtitle)
                    <p>{{ $aboutUs->subtitle }}</p>
                @endif
            </div>
            @if($aboutUs->hero_image)
                <div class="col-lg-6">
                    <div class="hero-image">
                        <img src="{{ asset('storage/' . $aboutUs->hero_image) }}" alt="{{ $aboutUs->title }}" class="img-fluid">
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="about-content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-card">
                    <h2>Our Story</h2>
                    <div class="content-text">
                        {!! $aboutUs->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mission, Vision, Values -->
@if($aboutUs->mission_title || $aboutUs->vision_title || $aboutUs->values_title)
    <div class="mvv-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Foundation</h2>
                <p>The core principles that guide everything we do</p>
            </div>
            
            <div class="row">
                @if($aboutUs->mission_title)
                    <div class="col-lg-4 mb-4">
                        <div class="mvv-card">
                            <div class="mvv-icon">
                                <i class="fas fa-bullseye"></i>
                            </div>
                            <h4>{{ $aboutUs->mission_title }}</h4>
                            @if($aboutUs->mission_content)
                                <p>{{ $aboutUs->mission_content }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($aboutUs->vision_title)
                    <div class="col-lg-4 mb-4">
                        <div class="mvv-card">
                            <div class="mvv-icon">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h4>{{ $aboutUs->vision_title }}</h4>
                            @if($aboutUs->vision_content)
                                <p>{{ $aboutUs->vision_content }}</p>
                            @endif
                        </div>
                    </div>
                @endif

                @if($aboutUs->values_title)
                    <div class="col-lg-4 mb-4">
                        <div class="mvv-card">
                            <div class="mvv-icon">
                                <i class="fas fa-heart"></i>
                            </div>
                            <h4>{{ $aboutUs->values_title }}</h4>
                            @if($aboutUs->values_content)
                                <p>{{ $aboutUs->values_content }}</p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif

<!-- Features Section -->
@if($aboutUs->features && count($aboutUs->features) > 0)
    <div class="features-section">
        <div class="container">
            <div class="section-title">
                <h2>Why Choose Us</h2>
                <p>Discover what makes our train booking service special</p>
            </div>
            
            <div class="features-grid">
                @foreach($aboutUs->features as $feature)
                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="{{ $feature['icon'] ?? 'fas fa-check' }}"></i>
                        </div>
                        <h5>{{ $feature['title'] }}</h5>
                        <p>{{ $feature['description'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Stats Section -->
@if($aboutUs->stats && count($aboutUs->stats) > 0)
    <div class="stats-section">
        <div class="container">
            <div class="section-title">
                <h2 style="color: white;">Our Numbers</h2>
                <p style="color: rgba(255,255,255,0.9);">The impact we've made in train travel</p>
            </div>
            
            <div class="stats-grid">
                @foreach($aboutUs->stats as $stat)
                    <div class="stat-item">
                        <div class="stat-icon">
                            <i class="{{ $stat['icon'] ?? 'fas fa-chart-line' }}"></i>
                        </div>
                        <span class="stat-number">{{ $stat['number'] }}</span>
                        <div class="stat-label">{{ $stat['label'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif
@endsection

@push('scripts')
<script>
    // Intersection Observer for animations
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.mvv-card, .feature-item, .stat-item').forEach(el => {
        el.style.animationPlayState = 'paused';
        observer.observe(el);
    });

    // Smooth scroll for internal links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush
