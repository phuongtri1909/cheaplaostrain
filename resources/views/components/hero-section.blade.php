@props(['title', 'subtitle', 'badge' => null])

@once
@push('styles')
<style>
    /* Enhanced Hero Section - Shorter */
    .hero-section {
        background:
                    url('https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?ixlib=rb-4.0.3&auto=format&fit=crop&w=2069&q=80') center/cover;
        min-height: 60vh;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-section::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
        animation: float-grid 30s linear infinite;
    }

    @keyframes float-grid {
        0% { transform: translateY(0) translateX(0); }
        100% { transform: translateY(-100px) translateX(-100px); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        color: white;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        padding: 0 1rem;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 0.75rem 1.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.9rem;
        font-weight: 600;
        animation: slideInDown 1s ease-out;
    }

    .hero-badge i {
        color: #22c55e;
        margin-right: 0.5rem;
        animation: pulse 2s infinite;
    }

    .hero-title {
        font-size: clamp(2rem, 5vw, 3.5rem);
        font-weight: 800;
        margin-bottom: 1rem;
        line-height: 1.2;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        animation: slideInUp 1s ease-out 0.2s both;
    }

    .hero-subtitle {
        font-size: clamp(1rem, 2vw, 1.2rem);
        font-weight: 300;
        margin-bottom: 2rem;
        opacity: 0.95;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
        text-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);
        animation: slideInUp 1s ease-out 0.4s both;
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }
</style>
@endpush
@endonce

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            @if($badge)
                <div class="hero-badge">
                    <i class="fas fa-train"></i>
                    {{ $badge }}
                </div>
            @endif

            <h1 class="hero-title">
                {!! $title !!}
            </h1>

            <p class="hero-subtitle">
                {{ $subtitle }}
            </p>
        </div>
    </div>
</section>
