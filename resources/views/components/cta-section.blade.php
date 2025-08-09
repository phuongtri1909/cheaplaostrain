@props(['title', 'subtitle', 'buttonText', 'buttonLink'])

@once
@push('styles')
<style>
    .cta-section {
        background:
                    url('https://images.unsplash.com/photo-1517263904808-5dc91e3e7044?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80') center/cover;
        color: white;
        padding: 6rem 0;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .cta-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(45, 55, 72, 0.8);
    }

    .cta-content {
        position: relative;
        z-index: 2;
        max-width: 600px;
        margin: 0 auto;
    }

    .cta-title {
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 700;
        margin-bottom: 1.5rem;
    }

    .cta-subtitle {
        font-size: 1.2rem;
        opacity: 0.9;
        margin-bottom: 2rem;
    }

    .btn-hero-primary {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        border: none;
        color: white;
        padding: 1rem 2rem;
        border-radius: 16px;
        font-weight: 600;
        font-size: 1.1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        position: relative;
        overflow: hidden;
        text-decoration: none;
        display: inline-block;
    }

    .btn-hero-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .btn-hero-primary:hover::before {
        left: 100%;
    }

    .btn-hero-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        color: white;
    }
</style>
@endpush
@endonce

<section class="cta-section">
    <div class="container">
        <div class="cta-content animate-on-scroll">
            <h2 class="cta-title">{{ $title }}</h2>
            <p class="cta-subtitle">{{ $subtitle }}</p>
            <a href="{{ $buttonLink }}" class="btn-hero-primary">
                <i class="fas fa-ticket-alt me-2"></i>{{ $buttonText }}
            </a>
        </div>
    </div>
</section>
