@props(['routes'])

@once
@push('styles')
<style>
    .routes-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .route-card-modern {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        border: 1px solid #10b981;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        cursor: pointer;
    }

    .route-card-modern:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-color: #059669;
    }

    .route-image {
        height: 200px;
        background-size: cover;
        background-position: center;
        position: relative;
    }

    .route-image::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, rgba(5, 150, 105, 0.8) 0%, rgba(16, 185, 129, 0.6) 100%);
    }

    .route-content {
        padding: 1.5rem;
        position: relative;
    }

    .route-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .route-cities {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .city-info {
        text-align: center;
    }

    .city-code {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1f2937;
    }

    .city-name {
        font-size: 0.8rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }

    .route-arrow {
        color: #059669;
        font-size: 1.2rem;
        animation: slideArrow 2s ease-in-out infinite;
    }

    @keyframes slideArrow {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(3px); }
    }

    .route-price {
        text-align: right;
    }

    .price-amount {
        font-size: 1.3rem;
        font-weight: 700;
        color: #059669;
    }

    .price-label {
        font-size: 0.75rem;
        color: #6b7280;
    }

    .route-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #10b981;
        font-size: 0.85rem;
    }

    .route-duration {
        color: #6b7280;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .route-availability {
        color: #22c55e;
        font-weight: 500;
    }

    @media (max-width: 768px) {
        .route-image {
            height: 150px;
        }
    }
</style>
@endpush
@endonce

<div class="routes-grid">
    @foreach($routes as $route)
        <div class="route-card-modern animate-on-scroll">
            <div class="route-image" style="background-image: url('{{ $route['image'] }}')"></div>
            <div class="route-content">
                <div class="route-header">
                    <div class="route-cities">
                        <div class="city-info">
                            <div class="city-code">{{ $route['from_code'] }}</div>
                            <div class="city-name">{{ $route['from_name'] }}</div>
                        </div>
                        <i class="fas fa-arrow-right route-arrow"></i>
                        <div class="city-info">
                            <div class="city-code">{{ $route['to_code'] }}</div>
                            <div class="city-name">{{ $route['to_name'] }}</div>
                        </div>
                    </div>
                    <div class="route-price">
                        <div class="price-amount">{{ $route['price'] }}</div>
                        <div class="price-label">{{ __('from') }}</div>
                    </div>
                </div>
                <div class="route-details">
                    <div class="route-duration">
                        <i class="fas fa-clock"></i>
                        {{ $route['duration'] }}
                    </div>
                    <div class="route-availability">{{ $route['availability'] }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>
