@extends('layouts.app')
@section('title', 'Train Tickets - ' . ($searchParams['departure'] ?? 'Vientiane') . ' to ' . ($searchParams['arrival'] ?? 'Vang Vieng'))
@section('description', 'Book train tickets with seat selection. Choose your preferred train and seats in one place.')

@push('styles')
<style>
    /* Main Container */
    .ticket-list-page {
        background: var(--gradient-green-soft);
        min-height: 100vh;
    }

    /* Search Summary */
    .search-summary-card {
        background: white;
        border-radius: var(--modern-radius);
        padding: 1.5rem;
        margin: 2rem 0;
        box-shadow: var(--shadow-medium);
        border: 1px solid var(--accent-green);
        animation: slideInDown 0.6s ease-out;
    }

    .search-route-info {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .route-station {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        text-align: center;
    }

    .route-arrow-animated {
        color: var(--primary-green);
        font-size: 1.5rem;
        animation: slideArrow 2s ease-in-out infinite;
    }

    .search-meta {
        display: flex;
        justify-content: center;
        gap: 2rem;
        align-items: center;
        flex-wrap: wrap;
        color: var(--text-medium);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modify-search-btn {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: var(--transition-smooth);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modify-search-btn:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
        color: white;
    }

    /* Train Cards */
    .trains-container {
        display: flex;
        flex-direction: column;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .train-card-modern {
        background: white;
        border-radius: var(--modern-radius);
        overflow: hidden;
        box-shadow: var(--shadow-medium);
        border: 1px solid var(--accent-green);
        transition: var(--transition-smooth);
        animation: slideInUp 0.6s ease-out var(--delay, 0s) both;
    }

    .train-card-modern:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-strong);
        border-color: var(--primary-green);
    }

    .train-header {
        background: var(--gradient-green);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .train-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .train-number {
        font-size: 1.5rem;
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
    }

    .amenity-badge {
        background: rgba(255,255,255,0.2);
        border-radius: var(--radius-lg);
        padding: 0.5rem;
        font-size: 0.8rem;
        transition: var(--transition-smooth);
    }

    .amenity-badge:hover {
        background: rgba(255,255,255,0.3);
        transform: scale(1.05);
    }

    .train-schedule {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 2rem;
        align-items: center;
        border-bottom: 1px solid var(--accent-green);
    }

    .schedule-point {
        text-align: center;
    }

    .schedule-time {
        font-size: 2rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 0.5rem;
    }

    .schedule-city {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.25rem;
    }

    .schedule-date {
        color: var(--text-medium);
    }

    .schedule-connector {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .duration-line {
        width: 120px;
        height: 3px;
        background: var(--accent-green);
        border-radius: 2px;
        position: relative;
    }

    .duration-line::after {
        content: '';
        position: absolute;
        right: -8px;
        top: -5px;
        width: 0;
        height: 0;
        border-left: 12px solid var(--accent-green);
        border-top: 6px solid transparent;
        border-bottom: 6px solid transparent;
    }

    .duration-text {
        font-weight: 600;
        color: var(--text-medium);
    }

    /* Class Selection */
    .class-selection {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .class-option {
        border: 2px solid var(--accent-green);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        text-align: center;
        transition: var(--transition-smooth);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        background: white;
    }

    .class-option::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(16, 185, 129, 0.1), transparent);
        transition: left 0.6s;
    }

    .class-option:hover::before {
        left: 100%;
    }

    .class-option:hover {
        border-color: var(--primary-green);
        transform: translateY(-3px);
        box-shadow: var(--shadow-medium);
    }

    .class-option.selected {
        border-color: var(--primary-green);
        background: var(--gradient-green-soft);
        transform: translateY(-3px);
        box-shadow: var(--shadow-medium);
    }

    .class-name {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1rem;
    }

    .class-price {
        font-size: 2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
    }

    .class-currency {
        font-size: 1rem;
        color: var(--text-medium);
    }

    .class-available {
        color: var(--text-medium);
        margin-bottom: 1rem;
    }

    .class-available.limited {
        color: #f59e0b;
        font-weight: 600;
    }

    .select-class-btn {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: var(--transition-smooth);
        width: 100%;
    }

    .select-class-btn:hover {
        transform: scale(1.05);
        box-shadow: var(--shadow-medium);
    }

    .select-class-btn:disabled {
        background: var(--text-light);
        cursor: not-allowed;
        transform: none;
    }

    /* Seat Selection Modal */
    .seat-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.8);
        z-index: 1000;
        backdrop-filter: blur(5px);
        animation: fadeIn 0.3s ease-out;
    }

    .seat-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .seat-modal-content {
        background: white;
        border-radius: var(--modern-radius);
        max-width: 900px;
        width: 90%;
        max-height: 90vh;
        overflow-y: auto;
        animation: scaleIn 0.3s ease-out;
        box-shadow: var(--shadow-strong);
    }

    .seat-modal-header {
        background: var(--gradient-green);
        color: white;
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .seat-modal-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: var(--transition-smooth);
    }

    .close-modal:hover {
        background: rgba(255,255,255,0.2);
    }

    .seat-modal-body {
        padding: 2rem;
    }

    /* Seat Map */
    .seat-legend {
        display: flex;
        justify-content: center;
        gap: 2rem;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-medium);
    }

    .legend-seat {
        width: 20px;
        height: 20px;
        border-radius: var(--radius-sm);
        border: 2px solid;
    }

    .legend-available .legend-seat {
        background: var(--accent-green);
        border-color: var(--primary-green);
    }

    .legend-selected .legend-seat {
        background: var(--primary-green);
        border-color: var(--primary-green);
    }

    .legend-occupied .legend-seat {
        background: #f59e0b;
        border-color: #d97706;
    }

    .train-car {
        max-width: 500px;
        margin: 0 auto 2rem;
        background: #f8fafc;
        border-radius: var(--radius-lg);
        padding: 2rem;
        border: 2px solid var(--accent-green);
    }

    .car-header {
        text-align: center;
        font-weight: 700;
        color: var(--primary-green);
        margin-bottom: 1.5rem;
    }

    .seat-rows {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .seat-row {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 1.5rem;
        align-items: center;
    }

    .seat-side {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .seat {
        width: 35px;
        height: 35px;
        border-radius: var(--radius-sm);
        border: 2px solid var(--primary-green);
        background: var(--accent-green);
        cursor: pointer;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary-green);
        position: relative;
    }

    .seat:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-soft);
    }

    .seat.selected {
        background: var(--primary-green);
        color: white;
        transform: scale(1.1);
        animation: seatPulse 0.3s ease-out;
    }

    .seat.occupied {
        background: #f59e0b;
        border-color: #d97706;
        color: white;
        cursor: not-allowed;
    }

    .seat.occupied:hover {
        transform: none;
        box-shadow: none;
    }

    .row-label {
        font-weight: 600;
        color: var(--text-medium);
        text-align: center;
        width: 30px;
    }

    /* Selected Seats Summary */
    .selected-summary {
        background: var(--gradient-green-soft);
        border-radius: var(--radius-lg);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .summary-title {
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .selected-seat-list {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        margin-bottom: 1rem;
    }

    .selected-seat-tag {
        background: var(--primary-green);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: var(--radius-lg);
        font-size: 0.9rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .remove-seat {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 0;
        transition: var(--transition-smooth);
    }

    .remove-seat:hover {
        transform: scale(1.2);
    }

    .total-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: white;
        border-radius: var(--radius-md);
        font-weight: 700;
        color: var(--text-dark);
        border: 2px solid var(--accent-green);
    }

    .price-amount {
        color: var(--primary-green);
        font-size: 1.5rem;
    }

    .modal-actions {
        padding: 1.5rem;
        border-top: 1px solid var(--accent-green);
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
    }

    .btn-cancel {
        background: transparent;
        border: 2px solid var(--text-medium);
        color: var(--text-medium);
        padding: 0.75rem 1.5rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: var(--transition-smooth);
        cursor: pointer;
    }

    .btn-cancel:hover {
        background: var(--text-medium);
        color: white;
    }

    .btn-confirm {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: var(--radius-md);
        font-weight: 600;
        transition: var(--transition-smooth);
        cursor: pointer;
    }

    .btn-confirm:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-confirm:disabled {
        background: var(--text-light);
        cursor: not-allowed;
        transform: none;
    }

    /* Policy Tabs */
    .policy-section {
        background: white;
        border-radius: var(--modern-radius);
        box-shadow: var(--shadow-medium);
        margin: 3rem 0;
        overflow: hidden;
        border: 1px solid var(--accent-green);
    }

    .policy-header {
        background: var(--gradient-green);
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .policy-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
    }

    .policy-tabs {
        display: flex;
        background: #f8fafc;
        border-bottom: 1px solid var(--accent-green);
    }

    .policy-tab {
        flex: 1;
        padding: 1rem;
        text-align: center;
        background: none;
        border: none;
        cursor: pointer;
        transition: var(--transition-smooth);
        font-weight: 600;
        color: var(--text-medium);
        border-bottom: 3px solid transparent;
    }

    .policy-tab:hover {
        background: var(--gradient-green-soft);
        color: var(--primary-green);
    }

    .policy-tab.active {
        background: white;
        color: var(--primary-green);
        border-bottom-color: var(--primary-green);
    }

    .policy-content {
        padding: 2rem;
        display: none;
    }

    .policy-content.active {
        display: block;
        animation: fadeInUp 0.3s ease-out;
    }

    .policy-item {
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: var(--gradient-green-soft);
        border-radius: var(--radius-md);
        border-left: 4px solid var(--primary-green);
    }

    .policy-item h4 {
        color: var(--primary-green);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .policy-item p {
        color: var(--text-medium);
        margin: 0;
        line-height: 1.6;
    }

    /* Loading States */
    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--modern-radius);
        backdrop-filter: blur(2px);
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid var(--accent-green);
        border-top: 4px solid var(--primary-green);
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .search-route-info {
            flex-direction: column;
            gap: 0.5rem;
        }

        .search-meta {
            flex-direction: column;
            gap: 1rem;
        }

        .train-schedule {
            grid-template-columns: 1fr;
            gap: 1rem;
            text-align: center;
        }

        .schedule-connector {
            order: 2;
            transform: rotate(90deg);
        }

        .duration-line {
            width: 60px;
        }

        .duration-line::after {
            right: -8px;
            top: -5px;
            transform: rotate(-90deg);
        }

        .class-selection {
            grid-template-columns: 1fr;
        }

        .seat-modal-content {
            width: 95%;
            margin: 1rem;
        }

        .seat-modal-body {
            padding: 1rem;
        }

        .train-car {
            padding: 1rem;
        }

        .seat {
            width: 30px;
            height: 30px;
            font-size: 0.7rem;
        }

        .policy-tabs {
            flex-direction: column;
        }

        .modal-actions {
            flex-direction: column;
        }
    }

    /* Animations */
    @keyframes slideInDown {
        from { opacity: 0; transform: translateY(-30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes slideArrow {
        0%, 100% { transform: translateX(0); }
        50% { transform: translateX(5px); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scaleIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @keyframes seatPulse {
        0% { transform: scale(1.1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1.1); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
@endpush

@section('content')
<div class="ticket-list-page">
    <!-- Global Animations -->
    <x-global-animations />

    <!-- Hero Section -->
    <x-hero-section
        :title="__('Find & Book Your Train Tickets')"
        :subtitle="__('Select your preferred train and seats in one convenient place')"
        :badge="__('Fast & Easy Booking')"
    />

    <!-- Search Card -->
    <x-search-card
        :searchTitle="__('Search Train Tickets')"
        :searchSubtitle="__('Enter your travel details to find available trains and select seats')"
    />

    <div class="container">
        <!-- Search Summary -->
        <div class="search-summary-card">
            <div class="search-route-info">
                <div class="route-station">{{ $searchParams['departure'] ?? 'Vientiane' }}</div>
                <i class="fas fa-arrow-right route-arrow-animated"></i>
                <div class="route-station">{{ $searchParams['arrival'] ?? 'Vang Vieng' }}</div>
            </div>
            <div class="search-meta">
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>{{ date('D, M d, Y', strtotime($searchParams['date'] ?? 'tomorrow')) }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-users"></i>
                    <span>{{ count($trains ?? []) }} {{ __('trains available') }}</span>
                </div>
                <a href="{{ route('home') }}" class="modify-search-btn">
                    <i class="fas fa-edit"></i>
                    {{ __('Modify Search') }}
                </a>
            </div>
        </div>

        <!-- How It Works Section -->
        <section class="section-modern alt" style="padding: 4rem 0;">
            <x-section-header
                :badge="__('How It Works')"
                :title="__('Book in 3 Simple Steps')"
                :subtitle="__('Select train, choose seats, and pay - all in one place')"
            />

            <x-process-steps :steps="[
                [
                    'icon' => 'fas fa-search',
                    'title' => __('Choose Train'),
                    'description' => __('Select your preferred train from available options with different classes and amenities')
                ],
                [
                    'icon' => 'fas fa-chair',
                    'title' => __('Select Seats'),
                    'description' => __('Pick your favorite seats from our interactive seat map with real-time availability')
                ],
                [
                    'icon' => 'fas fa-credit-card',
                    'title' => __('Pay & Travel'),
                    'description' => __('Complete secure payment and receive your e-tickets instantly via email')
                ]
            ]" />
        </section>

        <!-- Available Trains -->
        <div class="trains-container" id="trainsContainer">
            @if(isset($trains) && count($trains) > 0)
                @foreach($trains as $index => $train)
                    <div class="train-card-modern" style="--delay: {{ $index * 0.1 }}s" data-train-id="{{ $train['id'] }}">
                        <!-- Train Header -->
                        <div class="train-header">
                            <div class="train-info">
                                <div>
                                    <div class="train-number">{{ __('Train') }} {{ $train['train_number'] }}</div>
                                    <div class="train-type">{{ $train['train_type'] }}</div>
                                </div>
                            </div>
                            <div class="train-amenities">
                                @foreach($train['amenities'] as $amenity)
                                    <div class="amenity-badge" title="{{ ucfirst($amenity) }}">
                                        @switch($amenity)
                                            @case('wifi')
                                                <i class="fas fa-wifi"></i> WiFi
                                                @break
                                            @case('ac')
                                                <i class="fas fa-snowflake"></i> A/C
                                                @break
                                            @case('food')
                                                <i class="fas fa-utensils"></i> Food
                                                @break
                                        @endswitch
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Train Schedule -->
                        <div class="train-schedule">
                            <div class="schedule-point">
                                <div class="schedule-time">{{ $train['departure_time'] }}</div>
                                <div class="schedule-city">{{ $searchParams['departure'] ?? 'Vientiane' }}</div>
                                <div class="schedule-date">{{ date('M d', strtotime($searchParams['date'] ?? 'tomorrow')) }}</div>
                            </div>

                            <div class="schedule-connector">
                                <div class="duration-text">{{ $train['duration'] }}</div>
                                <div class="duration-line"></div>
                                <small class="text-muted">{{ __('Direct') }}</small>
                            </div>

                            <div class="schedule-point">
                                <div class="schedule-time">{{ $train['arrival_time'] }}</div>
                                <div class="schedule-city">{{ $searchParams['arrival'] ?? 'Vang Vieng' }}</div>
                                <div class="schedule-date">{{ date('M d', strtotime($searchParams['date'] ?? 'tomorrow')) }}</div>
                            </div>
                        </div>

                        <!-- Class Selection -->
                        <div class="class-selection">
                            <!-- Second Class -->
                            <div class="class-option" data-class="2nd" data-price="{{ $train['price_2nd'] }}" data-train="{{ $train['id'] }}">
                                <div class="class-name">{{ __('Second Class') }}</div>
                                <div class="class-price">
                                    {{ number_format($train['price_2nd']) }}
                                    <span class="class-currency">LAK</span>
                                </div>
                                <div class="class-available {{ $train['available_2nd'] < 10 ? 'limited' : '' }}">
                                    {{ $train['available_2nd'] }} {{ __('seats available') }}
                                </div>
                                <button class="select-class-btn" onclick="selectClass({{ $train['id'] }}, '2nd', {{ $train['price_2nd'] }})">
                                    {{ __('Select & Choose Seats') }}
                                </button>
                            </div>

                            <!-- First Class -->
                            <div class="class-option" data-class="1st" data-price="{{ $train['price_1st'] }}" data-train="{{ $train['id'] }}">
                                <div class="class-name">{{ __('First Class') }}</div>
                                <div class="class-price">
                                    {{ number_format($train['price_1st']) }}
                                    <span class="class-currency">LAK</span>
                                </div>
                                <div class="class-available {{ $train['available_1st'] < 5 ? 'limited' : '' }}">
                                    {{ $train['available_1st'] }} {{ __('seats available') }}
                                </div>
                                <button class="select-class-btn" onclick="selectClass({{ $train['id'] }}, '1st', {{ $train['price_1st'] }})">
                                    {{ __('Select & Choose Seats') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="train-card-modern">
                    <div style="padding: 3rem; text-align: center;">
                        <i class="fas fa-train" style="font-size: 4rem; color: var(--text-light); margin-bottom: 1rem;"></i>
                        <h3>{{ __('No trains available') }}</h3>
                        <p class="text-muted">{{ __('Please try a different date or route') }}</p>
                        <a href="{{ route('home') }}" class="modify-search-btn">
                            {{ __('Search Again') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Policy Section -->
        <div class="policy-section">
            <div class="policy-header">
                <h3 class="policy-title">{{ __('Booking Policies & Information') }}</h3>
            </div>

            <div class="policy-tabs">
                <button class="policy-tab active" onclick="showPolicyTab('cancellation')">
                    {{ __('Cancellation') }}
                </button>
                <button class="policy-tab" onclick="showPolicyTab('refund')">
                    {{ __('Refund Policy') }}
                </button>
                <button class="policy-tab" onclick="showPolicyTab('rules')">
                    {{ __('Travel Rules') }}
                </button>
                <button class="policy-tab" onclick="showPolicyTab('baggage')">
                    {{ __('Baggage') }}
                </button>
            </div>

            <div class="policy-content active" id="cancellation">
                <div class="policy-item">
                    <h4>{{ __('Free Cancellation') }}</h4>
                    <p>{{ __('Cancel your booking free of charge up to 24 hours before departure time.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Partial Cancellation') }}</h4>
                    <p>{{ __('Cancellations between 12-24 hours before departure incur a 25% fee.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Late Cancellation') }}</h4>
                    <p>{{ __('Cancellations within 12 hours of departure incur a 50% fee.') }}</p>
                </div>
            </div>

            <div class="policy-content" id="refund">
                <div class="policy-item">
                    <h4>{{ __('Processing Time') }}</h4>
                    <p>{{ __('Refunds are processed within 5-7 business days to your original payment method.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Refund Amount') }}</h4>
                    <p>{{ __('Refund amount depends on the cancellation timing and applicable fees.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('No-Show Policy') }}</h4>
                    <p>{{ __('No refund is available for no-show passengers or missed departures.') }}</p>
                </div>
            </div>

            <div class="policy-content" id="rules">
                <div class="policy-item">
                    <h4>{{ __('Valid ID Required') }}</h4>
                    <p>{{ __('All passengers must carry valid government-issued photo identification.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Arrival Time') }}</h4>
                    <p>{{ __('Please arrive at the station at least 30 minutes before departure.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Age Restrictions') }}</h4>
                    <p>{{ __('Children under 12 must be accompanied by an adult. Infants under 2 travel free.') }}</p>
                </div>
            </div>

            <div class="policy-content" id="baggage">
                <div class="policy-item">
                    <h4>{{ __('Free Allowance') }}</h4>
                    <p>{{ __('Each passenger is allowed one carry-on bag (max 7kg) and one checked bag (max 20kg).') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Prohibited Items') }}</h4>
                    <p>{{ __('Dangerous goods, flammable materials, and weapons are strictly prohibited.') }}</p>
                </div>
                <div class="policy-item">
                    <h4>{{ __('Excess Baggage') }}</h4>
                    <p>{{ __('Additional baggage fees apply for items exceeding the free allowance.') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Seat Selection Modal -->
<div class="seat-modal" id="seatModal">
    <div class="seat-modal-content">
        <div class="seat-modal-header">
            <h3 class="seat-modal-title" id="modalTitle">{{ __('Select Your Seats') }}</h3>
            <button class="close-modal" onclick="closeSeatModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="seat-modal-body">
            <!-- Loading State -->
            <div class="loading-overlay" id="seatLoading">
                <div class="loading-spinner"></div>
            </div>

            <!-- Seat Legend -->
            <div class="seat-legend">
                <div class="legend-item">
                    <div class="legend-seat" style="background: var(--accent-green); border-color: var(--primary-green);"></div>
                    <span>{{ __('Available') }}</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat" style="background: var(--primary-green); border-color: var(--primary-green);"></div>
                    <span>{{ __('Selected') }}</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat" style="background: #f59e0b; border-color: #d97706;"></div>
                    <span>{{ __('Occupied') }}</span>
                </div>
            </div>

            <!-- Train Car -->
            <div class="train-car">
                <div class="car-header" id="carHeader">
                    {{ __('Car') }} 1 - {{ __('Second Class') }}
                </div>

                <div class="seat-rows" id="seatMap">
                    <!-- Seats will be generated by JavaScript -->
                </div>
            </div>

            <!-- Selected Seats Summary -->
            <div class="selected-summary">
                <div class="summary-title">{{ __('Selected Seats') }}</div>
                <div class="selected-seat-list" id="selectedSeatsList">
                    <span class="text-muted">{{ __('No seats selected') }}</span>
                </div>
                <div class="total-price">
                    <span>{{ __('Total Price') }}:</span>
                    <span class="price-amount" id="modalTotalPrice">0 LAK</span>
                </div>
            </div>
        </div>

        <div class="modal-actions">
            <button type="button" class="btn-cancel" onclick="closeSeatModal()">
                {{ __('Cancel') }}
            </button>
            <button type="button" class="btn-confirm" id="confirmBooking" disabled onclick="confirmBooking()">
                {{ __('Confirm Booking') }}
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Global variables
let currentTrain = null;
let currentClass = null;
let currentPrice = 0;
let selectedSeats = [];
let occupiedSeats = [];

document.addEventListener('DOMContentLoaded', function() {
    // Initialize page
    initializePage();
});

function initializePage() {
    // Add hover effects to train cards
    const trainCards = document.querySelectorAll('.train-card-modern');
    trainCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
}

function selectClass(trainId, classType, price) {
    // Remove previous selections
    document.querySelectorAll('.class-option.selected').forEach(option => {
        option.classList.remove('selected');
    });

    // Mark current selection
    const selectedOption = document.querySelector(`[data-train="${trainId}"][data-class="${classType}"]`);
    selectedOption.classList.add('selected');

    // Store current selection
    currentTrain = trainId;
    currentClass = classType;
    currentPrice = price;
    selectedSeats = [];

    // Show seat modal
    showSeatModal(trainId, classType, price);
}

function showSeatModal(trainId, classType, price) {
    const modal = document.getElementById('seatModal');
    const modalTitle = document.getElementById('modalTitle');
    const carHeader = document.getElementById('carHeader');
    const loading = document.getElementById('seatLoading');

    // Update modal title
    modalTitle.textContent = `${__('Select Seats')} - ${__('Train')} ${getTrainNumber(trainId)} (${classType === '1st' ? __('First Class') : __('Second Class')})`;
    carHeader.textContent = `${__('Car')} 1 - ${classType === '1st' ? __('First Class') : __('Second Class')}`;

    // Show modal
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';

    // Show loading
    loading.style.display = 'flex';

    // Simulate API call to fetch seat data
    setTimeout(() => {
        fetchSeatMap(trainId, classType);
        loading.style.display = 'none';
    }, 1000);
}

function fetchSeatMap(trainId, classType) {
    // Mock occupied seats data - In real app, this would be an AJAX call
    occupiedSeats = ['1A', '1B', '3C', '5A', '7B', '9D'];

    generateSeatMap();
}

function generateSeatMap() {
    const seatMap = document.getElementById('seatMap');
    seatMap.innerHTML = '';

    // Generate 10 rows with 4 seats each (A, B | aisle | C, D)
    for (let row = 1; row <= 10; row++) {
        const seatRow = document.createElement('div');
        seatRow.className = 'seat-row';

        // Left side seats (A, B)
        const leftSide = document.createElement('div');
        leftSide.className = 'seat-side';

        ['A', 'B'].forEach(letter => {
            const seatId = `${row}${letter}`;
            const seat = createSeat(seatId);
            leftSide.appendChild(seat);
        });

        // Row label
        const rowLabel = document.createElement('div');
        rowLabel.className = 'row-label';
        rowLabel.textContent = row;

        // Right side seats (C, D)
        const rightSide = document.createElement('div');
        rightSide.className = 'seat-side';

        ['C', 'D'].forEach(letter => {
            const seatId = `${row}${letter}`;
            const seat = createSeat(seatId);
            rightSide.appendChild(seat);
        });

        seatRow.appendChild(leftSide);
        seatRow.appendChild(rowLabel);
        seatRow.appendChild(rightSide);

        seatMap.appendChild(seatRow);
    }
}

function createSeat(seatId) {
    const seat = document.createElement('div');
    seat.className = 'seat';
    seat.dataset.seatId = seatId;
    seat.textContent = seatId;

    if (occupiedSeats.includes(seatId)) {
        seat.classList.add('occupied');
        seat.title = `${__('Seat')} ${seatId} - ${__('Occupied')}`;
    } else {
        seat.addEventListener('click', () => toggleSeat(seatId));
        seat.title = `${__('Seat')} ${seatId} - ${__('Available')}`;
    }

    return seat;
}

function toggleSeat(seatId) {
    const seatElement = document.querySelector(`[data-seat-id="${seatId}"]`);

    if (seatElement.classList.contains('selected')) {
        // Deselect seat
        seatElement.classList.remove('selected');
        selectedSeats = selectedSeats.filter(seat => seat !== seatId);
    } else {
        // Select seat (limit to 4 seats)
        if (selectedSeats.length >= 4) {
            alert('{{ __("Maximum 4 seats can be selected") }}');
            return;
        }

        seatElement.classList.add('selected');
        selectedSeats.push(seatId);
    }

    updateSeatSummary();
}

function updateSeatSummary() {
    const selectedSeatsList = document.getElementById('selectedSeatsList');
    const totalPriceElement = document.getElementById('modalTotalPrice');
    const confirmBtn = document.getElementById('confirmBooking');

    if (selectedSeats.length === 0) {
        selectedSeatsList.innerHTML = `<span class="text-muted">${__('No seats selected')}</span>`;
        confirmBtn.disabled = true;
    } else {
        let seatsHtml = '';
        selectedSeats.forEach(seatId => {
            seatsHtml += `
                <div class="selected-seat-tag">
                    ${__('Seat')} ${seatId}
                    <button type="button" class="remove-seat" onclick="removeSeat('${seatId}')">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        });
        selectedSeatsList.innerHTML = seatsHtml;
        confirmBtn.disabled = false;
    }

    const totalPrice = selectedSeats.length * currentPrice;
    totalPriceElement.textContent = `${totalPrice.toLocaleString()} LAK`;
}

function removeSeat(seatId) {
    const seatElement = document.querySelector(`[data-seat-id="${seatId}"]`);
    if (seatElement) {
        seatElement.classList.remove('selected');
        selectedSeats = selectedSeats.filter(seat => seat !== seatId);
        updateSeatSummary();
    }
}

function closeSeatModal() {
    const modal = document.getElementById('seatModal');
    modal.classList.remove('show');
    document.body.style.overflow = '';

    // Reset selections
    selectedSeats = [];

    // Remove visual selections from class options
    document.querySelectorAll('.class-option.selected').forEach(option => {
        option.classList.remove('selected');
    });
}

function confirmBooking() {
    if (selectedSeats.length === 0) {
        alert('{{ __("Please select at least one seat") }}');
        return;
    }

    const totalPrice = selectedSeats.length * currentPrice;
    const bookingData = {
        train: currentTrain,
        class: currentClass,
        seats: selectedSeats,
        price: currentPrice,
        total: totalPrice,
        date: '{{ $searchParams["date"] ?? "tomorrow" }}',
        departure: '{{ $searchParams["departure"] ?? "Vientiane" }}',
        arrival: '{{ $searchParams["arrival"] ?? "Vang Vieng" }}'
    };

    // In real application, this would be an AJAX call to book the tickets
    console.log('Booking data:', bookingData);

    // Show success message
    alert(`${__('Booking confirmed!')}
${__('Train')}: ${getTrainNumber(currentTrain)}
${__('Class')}: ${currentClass === '1st' ? __('First Class') : __('Second Class')}
${__('Seats')}: ${selectedSeats.join(', ')}
${__('Total')}: ${totalPrice.toLocaleString()} LAK

${__('You will receive a confirmation email shortly.')}`);

    // Close modal
    closeSeatModal();

    // In real app, redirect to confirmation page
    // window.location.href = '/booking/confirmation/' + bookingId;
}

function showPolicyTab(tabName) {
    // Remove active class from all tabs and contents
    document.querySelectorAll('.policy-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    document.querySelectorAll('.policy-content').forEach(content => {
        content.classList.remove('active');
    });

    // Add active class to clicked tab and corresponding content
    event.target.classList.add('active');
    document.getElementById(tabName).classList.add('active');
}

function getTrainNumber(trainId) {
    // Mock function to get train number by ID
    const trainNumbers = {
        1: 'C1',
        2: 'C3',
        3: 'C5'
    };
    return trainNumbers[trainId] || 'C1';
}

// Helper function for translations
function __(key) {
    const translations = {
        'Select Seats': '{{ __("Select Seats") }}',
        'Train': '{{ __("Train") }}',
        'First Class': '{{ __("First Class") }}',
        'Second Class': '{{ __("Second Class") }}',
        'Car': '{{ __("Car") }}',
        'Seat': '{{ __("Seat") }}',
        'Available': '{{ __("Available") }}',
        'Occupied': '{{ __("Occupied") }}',
        'Maximum 4 seats can be selected': '{{ __("Maximum 4 seats can be selected") }}',
        'No seats selected': '{{ __("No seats selected") }}',
        'Please select at least one seat': '{{ __("Please select at least one seat") }}',
        'Booking confirmed!': '{{ __("Booking confirmed!") }}',
        'Class': '{{ __("Class") }}',
        'Seats': '{{ __("Seats") }}',
        'Total': '{{ __("Total") }}',
        'You will receive a confirmation email shortly.': '{{ __("You will receive a confirmation email shortly.") }}'
    };

    return translations[key] || key;
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    const modal = document.getElementById('seatModal');
    if (event.target === modal) {
        closeSeatModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSeatModal();
    }
});
</script>
@endpush
