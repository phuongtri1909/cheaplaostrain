@extends('layouts.app')
@section('title', 'Train Tickets - ' . $searchParams['departure'] . ' to ' . $searchParams['arrival'])
@section('description', 'Book train tickets from ' . $searchParams['departure'] . ' to ' . $searchParams['arrival'] . ' on ' . $searchParams['date'])

@push('styles')
<style>
    .tickets-page {
        background: var(--soft-green);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .search-summary {
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 2rem;
        border: 2px solid var(--accent-green);
        box-shadow: var(--shadow-soft);
        animation: slideInDown 0.6s ease-out;
    }

    .search-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .route-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
        color: var(--text-dark);
    }

    .route-arrow {
        color: var(--primary-green);
        font-size: 1.2rem;
        animation: pulse 2s infinite;
    }

    .search-modify-btn {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: var(--transition-smooth);
        text-decoration: none;
        display: inline-block;
    }

    .search-modify-btn:hover {
        background: linear-gradient(135deg, var(--primary-green-dark) 0%, var(--primary-green) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .trains-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .train-card {
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        border: 2px solid var(--accent-green);
        box-shadow: var(--shadow-soft);
        overflow: hidden;
        transition: var(--transition-smooth);
        animation: slideInUp 0.6s ease-out var(--delay, 0s) both;
    }

    .train-card:hover {
        border-color: var(--primary-green);
        box-shadow: var(--shadow-medium);
        transform: translateY(-5px);
    }

    .train-header {
        background: var(--gradient-green);
        color: white;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .train-number {
        font-size: 1.2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .train-type {
        font-size: 0.9rem;
        opacity: 0.9;
    }

    .train-amenities {
        display: flex;
        gap: 0.5rem;
        margin-left: auto;
    }

    .amenity-icon {
        width: 30px;
        height: 30px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: var(--transition-smooth);
    }

    .amenity-icon:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.1);
    }

    .train-body {
        padding: 1.5rem;
    }

    .train-schedule {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 1rem;
        margin-bottom: 1.5rem;
        align-items: center;
    }

    .schedule-station {
        text-align: center;
    }

    .schedule-time {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.25rem;
    }

    .schedule-city {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .schedule-date {
        font-size: 0.9rem;
        color: var(--text-medium);
    }

    .schedule-duration {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 0 1rem;
    }

    .duration-line {
        width: 100px;
        height: 2px;
        background: var(--accent-green);
        position: relative;
        margin: 0.5rem 0;
    }

    .duration-line::before {
        content: '';
        position: absolute;
        right: -5px;
        top: -3px;
        width: 0;
        height: 0;
        border-left: 8px solid var(--accent-green);
        border-top: 4px solid transparent;
        border-bottom: 4px solid transparent;
    }

    .duration-text {
        font-size: 0.9rem;
        color: var(--text-medium);
        font-weight: 600;
    }

    .class-options {
        border-top: 1px solid var(--accent-green);
        padding-top: 1.5rem;
    }

    .class-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
    }

    .class-card {
        border: 2px solid var(--accent-green);
        border-radius: var(--radius-md);
        padding: 1rem;
        text-align: center;
        transition: var(--transition-smooth);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .class-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--accent-green), transparent);
        transition: left 0.6s;
        opacity: 0.1;
    }

    .class-card:hover::before {
        left: 100%;
    }

    .class-card:hover {
        border-color: var(--primary-green);
        transform: translateY(-3px);
        box-shadow: var(--shadow-soft);
    }

    .class-name {
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
        font-size: 1.1rem;
    }

    .class-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .class-currency {
        font-size: 0.9rem;
        color: var(--text-medium);
    }

    .class-available {
        font-size: 0.85rem;
        color: var(--text-medium);
        margin-bottom: 1rem;
    }

    .class-available.limited {
        color: #ff6b35;
        font-weight: 600;
    }

    .select-btn {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 0.5rem 1.5rem;
        border-radius: var(--radius-sm);
        font-weight: 600;
        transition: var(--transition-smooth);
        text-decoration: none;
        display: inline-block;
        position: relative;
        z-index: 2;
    }

    .select-btn:hover {
        background: linear-gradient(135deg, var(--primary-green-dark) 0%, var(--primary-green) 100%);
        color: white;
        transform: scale(1.05);
    }

    .no-trains {
        text-align: center;
        padding: 3rem;
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        border: 2px solid var(--accent-green);
    }

    .no-trains-icon {
        font-size: 4rem;
        color: var(--text-medium);
        margin-bottom: 1rem;
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .tickets-page {
            padding: 1rem 0;
        }

        .search-summary {
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .search-info {
            flex-direction: column;
            gap: 0.5rem;
        }

        .route-info {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .train-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }

        .train-amenities {
            margin-left: 0;
        }

        .train-schedule {
            grid-template-columns: 1fr;
            gap: 1rem;
            text-align: center;
        }

        .schedule-duration {
            order: 2;
            padding: 1rem 0;
        }

        .duration-line {
            width: 50px;
            transform: rotate(90deg);
        }

        .duration-line::before {
            transform: rotate(-90deg);
            right: 21px;
            top: 10px;
        }

        .class-grid {
            grid-template-columns: 1fr;
        }

        .schedule-time {
            font-size: 1.25rem;
        }
    }

    /* Animations */
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

@section('content')
<div class="tickets-page">
    <div class="container">
        <!-- Search Summary -->
        <div class="search-summary">
            <div class="search-info">
                <div class="route-info">
                    <span class="fw-bold">{{ $searchParams['departure'] }}</span>
                    <i class="fas fa-arrow-right route-arrow"></i>
                    <span class="fw-bold">{{ $searchParams['arrival'] }}</span>
                </div>
                <div class="text-muted">
                    <i class="fas fa-calendar me-1"></i>
                    {{ date('D, M d, Y', strtotime($searchParams['date'])) }}
                </div>
                <a href="{{ route('home') }}" class="search-modify-btn">
                    <i class="fas fa-edit me-1"></i>{{ __('Modify Search') }}
                </a>
            </div>
        </div>

        <!-- Available Trains -->
        <div class="trains-container">
            @if(count($trains) > 0)
                @foreach($trains as $index => $train)
                    <div class="train-card" style="--delay: {{ $index * 0.1 }}s">
                        <!-- Train Header -->
                        <div class="train-header">
                            <div>
                                <div class="train-number">{{ __('Train') }} {{ $train['train_number'] }}</div>
                                <div class="train-type">{{ $train['train_type'] }}</div>
                            </div>
                            <div class="train-amenities">
                                @foreach($train['amenities'] as $amenity)
                                    <div class="amenity-icon" title="{{ ucfirst($amenity) }}">
                                        @switch($amenity)
                                            @case('wifi')
                                                <i class="fas fa-wifi"></i>
                                                @break
                                            @case('ac')
                                                <i class="fas fa-snowflake"></i>
                                                @break
                                            @case('food')
                                                <i class="fas fa-utensils"></i>
                                                @break
                                        @endswitch
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Train Body -->
                        <div class="train-body">
                            <!-- Schedule -->
                            <div class="train-schedule">
                                <div class="schedule-station">
                                    <div class="schedule-time">{{ $train['departure_time'] }}</div>
                                    <div class="schedule-city">{{ $searchParams['departure'] }}</div>
                                    <div class="schedule-date">{{ date('M d', strtotime($searchParams['date'])) }}</div>
                                </div>

                                <div class="schedule-duration">
                                    <div class="duration-text">{{ $train['duration'] }}</div>
                                    <div class="duration-line"></div>
                                    <small class="text-muted">{{ __('Direct') }}</small>
                                </div>

                                <div class="schedule-station">
                                    <div class="schedule-time">{{ $train['arrival_time'] }}</div>
                                    <div class="schedule-city">{{ $searchParams['arrival'] }}</div>
                                    <div class="schedule-date">{{ date('M d', strtotime($searchParams['date'])) }}</div>
                                </div>
                            </div>

                            <!-- Class Options -->
                            <div class="class-options">
                                <div class="class-grid">
                                    <!-- Second Class -->
                                    <div class="class-card">
                                        <div class="class-name">{{ __('Second Class') }}</div>
                                        <div class="class-price">
                                            {{ number_format($train['price_2nd']) }}
                                            <span class="class-currency">LAK</span>
                                        </div>
                                        <div class="class-available {{ $train['available_2nd'] < 10 ? 'limited' : '' }}">
                                            {{ $train['available_2nd'] }} {{ __('seats available') }}
                                        </div>
                                        <a href="{{ route('tickets.select-seat', ['ticket' => $train['id'], 'class' => '2nd']) }}" 
                                           class="select-btn">
                                            {{ __('Select') }}
                                        </a>
                                    </div>

                                    <!-- First Class -->
                                    <div class="class-card">
                                        <div class="class-name">{{ __('First Class') }}</div>
                                        <div class="class-price">
                                            {{ number_format($train['price_1st']) }}
                                            <span class="class-currency">LAK</span>
                                        </div>
                                        <div class="class-available {{ $train['available_1st'] < 5 ? 'limited' : '' }}">
                                            {{ $train['available_1st'] }} {{ __('seats available') }}
                                        </div>
                                        <a href="{{ route('tickets.select-seat', ['ticket' => $train['id'], 'class' => '1st']) }}" 
                                           class="select-btn">
                                            {{ __('Select') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="no-trains">
                    <div class="no-trains-icon">
                        <i class="fas fa-train"></i>
                    </div>
                    <h3>{{ __('No trains available') }}</h3>
                    <p class="text-muted">{{ __('Please try a different date or route') }}</p>
                    <a href="{{ route('home') }}" class="search-modify-btn">
                        {{ __('Search Again') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add click animations to class cards
    const classCards = document.querySelectorAll('.class-card');
    
    classCards.forEach(card => {
        card.addEventListener('click', function() {
            // Add subtle click animation
            this.style.transform = 'scale(0.98)';
            setTimeout(() => {
                this.style.transform = '';
            }, 150);
        });
    });

    // Smooth scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, observerOptions);

    const trainCards = document.querySelectorAll('.train-card');
    trainCards.forEach(card => {
        card.style.animationPlayState = 'paused';
        observer.observe(card);
    });
});
</script>
@endpush