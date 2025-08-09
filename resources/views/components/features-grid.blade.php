@props(['features'])

@once
@push('styles')
<style>
    .features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .feature-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        border: 1px solid #10b981;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .feature-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        transform: scaleX(0);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .feature-card:hover::before {
        transform: scaleX(1);
    }

    .feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        background: rgba(16, 185, 129, 0.1);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: #059669;
        font-size: 1.5rem;
    }

    .feature-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #1f2937;
    }

    .feature-description {
        color: #6b7280;
        line-height: 1.6;
    }
</style>
@endpush
@endonce

<div class="features-grid">
    @foreach($features as $feature)
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">
                <i class="{{ $feature['icon'] }}"></i>
            </div>
            <h3 class="feature-title">{{ $feature['title'] }}</h3>
            <p class="feature-description">{{ $feature['description'] }}</p>
        </div>
    @endforeach
</div>
