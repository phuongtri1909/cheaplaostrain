@extends('layouts.app')
@section('title', 'Cheap Laos Train - Book Train Tickets Online')
@section('description', 'Book Laos train tickets online. Fast and convenient booking for Vientiane, Vang Vieng, Luang Prabang routes. Best prices guaranteed.')
@section('keyword', 'Cheap Laos Train, Laos Train, Train Booking, Laos Travel, Vientiane, Luang Prabang, Vang Vieng')

@push('styles')
<style>
    /* Enhanced Hero Section with Animations */
    .hero-section {
        background: var(--gradient-green);
        min-height: 450px;
        position: relative;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    .hero-section::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="30" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="70" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
        animation: float-particles 20s infinite linear;
    }

    @keyframes float-particles {
        0% { transform: translateY(0) rotate(0deg); }
        100% { transform: translateY(-100px) rotate(360deg); }
    }

    .hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
        color: white;
        animation: fadeInUp 1s ease-out;
    }

    .hero-title {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 1rem;
        animation: slideInDown 1s ease-out 0.2s both;
    }

    .hero-subtitle {
        font-size: 1.2rem;
        margin-bottom: 1rem;
        opacity: 0.9;
        animation: slideInUp 1s ease-out 0.4s both;
    }

    .lead {
        animation: fadeIn 1s ease-out 0.6s both;
        line-height: 1.6;
    }

    /* Hero Section Wrapper */
    .hero-wrapper {
        position: relative;
        margin-bottom: 8rem;
    }

    /* Floating Search Form */
    .floating-search-form {
        position: absolute;
        top: 70%;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 800px;
        z-index: 100;
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-strong);
        padding: 2rem;
        border: 1px solid var(--accent-green);
    }

    .form-control-custom {
        border: 2px solid var(--accent-green);
        border-radius: var(--radius-md);
        padding: 12px 16px;
        font-size: 16px;
        background: var(--soft-gray);
        transition: var(--transition-smooth);
        color: var(--text-dark);
    }

    .form-control-custom:focus {
        border-color: var(--primary-green);
        box-shadow: 0 0 0 0.25rem rgba(127, 176, 105, 0.15);
        background: var(--warm-white);
        outline: none;
    }

    .form-label {
        color: var(--text-medium);
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-search {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 12px 24px;
        border-radius: var(--radius-md);
        font-weight: 600;
        text-transform: uppercase;
        width: 100%;
        transition: var(--transition-smooth);
        font-size: 16px;
    }

    .btn-search:hover {
        background: linear-gradient(135deg, var(--primary-green-dark) 0%, var(--primary-green) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .swap-btn {
        background: var(--accent-green);
        border: 2px solid var(--primary-green);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--primary-green);
        font-size: 18px;
        margin: 0 auto;
        transition: var(--transition-smooth);
    }

    .swap-btn:hover {
        background: var(--primary-green);
        color: white;
        transform: rotate(180deg);
        box-shadow: var(--shadow-soft);
    }

    /* Enhanced Popular Routes Section */
    .popular-routes {
        background: var(--soft-green);
        padding: 8rem 0 4rem;
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
    }

    .section-title p {
        font-size: 1.1rem;
        color: var(--text-medium);
        max-width: 600px;
        margin: 0 auto;
    }

    .routes-container {
        margin-top: 3rem;
    }

    .route-card {
        background: var(--warm-white);
        border-radius: var(--radius-md);
        padding: 1.5rem;
        text-decoration: none;
        color: var(--text-dark);
        border: 2px solid var(--accent-green);
        display: block;
        margin-bottom: 1rem;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
        animation: slideInLeft 0.6s ease-out var(--delay, 0s) both;
    }

    .route-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--accent-green), transparent);
        transition: left 0.6s;
    }

    .route-card:hover::before {
        left: 100%;
    }

    .route-card:hover {
        background: var(--accent-green);
        color: var(--primary-green);
        text-decoration: none;
        border-color: var(--primary-green);
        transform: translateX(10px);
        box-shadow: var(--shadow-medium);
    }

    .route-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: relative;
        z-index: 2;
    }

    .route-cities {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .route-city {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .route-arrow {
        color: var(--primary-green);
        font-size: 1.2rem;
        margin: 0 15px;
        transition: var(--transition-smooth);
    }

    .route-card:hover .route-arrow {
        transform: translateX(5px);
        animation: pulse 1s infinite;
    }

    .route-price {
        font-weight: 700;
        color: var(--primary-green);
        font-size: 1.1rem;
        white-space: nowrap;
    }

    /* Enhanced Booking Process */
    .booking-process {
        padding: 4rem 0;
        background: var(--warm-white);
    }

    .process-step {
        text-align: center;
        padding: 1.5rem;
        animation: fadeInUp 0.8s ease-out var(--delay, 0s) both;
        transition: var(--transition-smooth);
    }

    .process-step:hover {
        transform: translateY(-10px);
    }

    .process-icon {
        width: 80px;
        height: 80px;
        background: var(--gradient-green);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 2rem;
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .process-icon::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(255,255,255,0.3);
        border-radius: 50%;
        transition: var(--transition-smooth);
        transform: translate(-50%, -50%);
    }

    .process-step:hover .process-icon {
        transform: scale(1.1) rotate(10deg);
        box-shadow: var(--shadow-medium);
    }

    .process-step:hover .process-icon::before {
        width: 100%;
        height: 100%;
    }

    /* Enhanced News Section */
    .news-section {
        background: var(--soft-green);
        padding: 4rem 0;
    }

    .news-card {
        background: var(--warm-white);
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid var(--accent-green);
        height: 100%;
        transition: var(--transition-smooth);
        animation: slideInUp 0.8s ease-out var(--delay, 0s) both;
    }

    .news-card:hover {
        border-color: var(--primary-green);
        transform: translateY(-10px);
        box-shadow: var(--shadow-medium);
    }

    .news-image {
        height: 200px;
        background: var(--gradient-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        color: white;
        transition: var(--transition-smooth);
    }

    .news-card:hover .news-image {
        transform: scale(1.05);
    }

    /* Enhanced Cities Section */
    .cities-section {
        padding: 4rem 0;
        background: var(--warm-white);
    }

    .city-card {
        background: var(--warm-white);
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 2px solid var(--accent-green);
        height: 100%;
        transition: var(--transition-smooth);
        animation: zoomIn 0.8s ease-out var(--delay, 0s) both;
    }

    .city-card:hover {
        border-color: var(--primary-green);
        transform: scale(1.02);
        box-shadow: var(--shadow-strong);
    }

    .city-image {
        height: 250px;
        background: var(--gradient-green);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        color: white;
        transition: var(--transition-smooth);
    }

    .city-card:hover .city-image {
        transform: scale(1.1);
    }

    .rating-stars {
        color: #ffc107;
        animation: fadeInUp 0.6s ease-out 0.3s both;
    }

    .rating-stars i {
        display: inline-block;
        animation: starTwinkle 2s infinite var(--star-delay, 0s);
    }

    /* Animation Keyframes */
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

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes zoomIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
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

    @keyframes starTwinkle {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.8;
        }
    }

    /* Scroll reveal animations */
    .animate-on-scroll {
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.8s ease-out;
    }

    .animate-on-scroll.animate {
        opacity: 1;
        transform: translateY(0);
    }

    /* ========== MOBILE RESPONSIVE ========== */
    
    /* Large Mobile & Small Tablets */
    @media (max-width: 991.98px) {
        .hero-wrapper {
            margin-bottom: 2rem;
        }

        .floating-search-form {
            padding: 1.5rem;
            width: 95%;
        }

        .hero-title {
            font-size: 2.5rem;
        }

        .hero-subtitle {
            font-size: 1.1rem;
        }

        .section-title h2 {
            font-size: 2rem;
        }

        .popular-routes {
            padding: 6rem 0 3rem;
        }

        .route-card {
            padding: 1.25rem;
        }

        .route-city {
            font-size: 1rem;
        }

        .route-arrow {
            margin: 0 10px;
            font-size: 1.1rem;
        }

        .route-price {
            font-size: 1rem;
        }
    }

    /* Standard Mobile */
    @media (max-width: 767.98px) {
        .hero-section {
            min-height: 350px;
            padding: 2rem 0;
        }

        .hero-wrapper {
            margin-bottom: 2rem;
        }

        .hero-title {
            font-size: 2rem;
            line-height: 1.2;
            margin-bottom: 0.75rem;
        }

        .hero-subtitle {
            font-size: 1rem;
            margin-bottom: 0.75rem;
        }

        .lead {
            font-size: 0.95rem;
            line-height: 1.5;
            padding: 0 1rem;
        }

        /* Floating Search Form Mobile */
        .floating-search-form {
            position: relative;
            top: auto;
            left: auto;
            transform: none;
            width: 100%;
            margin: -3rem auto 0;
            padding: 1.5rem;
            border-radius: var(--radius-md);
           
        }

        .form-control-custom {
            padding: 10px 12px;
            font-size: 14px;
        }

        .form-label {
            font-size: 11px;
            margin-bottom: 6px;
        }

        .btn-search {
            padding: 12px 20px;
            font-size: 14px;
            margin-top: 0.5rem;
        }

        .swap-btn {
            width: 40px;
            height: 40px;
            font-size: 16px;
            margin: 0.5rem auto;
        }

        /* Form Layout Mobile */
        .search-form-row {
            flex-direction: column;
        }

        .search-form-row .col-md-5,
        .search-form-row .col-md-2 {
            width: 100%;
            margin-bottom: 1rem;
        }

        .search-form-row .col-md-2 {
            order: 3;
            margin-bottom: 0.5rem;
        }

        /* Popular Routes Mobile */
        .popular-routes {
            padding: 4rem 0 3rem;
        }

        .section-title {
            margin-bottom: 2rem;
            padding: 0 1rem;
        }

        .section-title h2 {
            font-size: 1.75rem;
            line-height: 1.3;
        }

        .section-title p {
            font-size: 1rem;
        }

        .routes-container {
            margin-top: 2rem;
        }

        .route-card {
            padding: 1rem;
            margin-bottom: 0.75rem;
            border-radius: var(--radius-sm);
        }

        .route-card:hover {
            transform: translateX(5px);
        }

        .route-content {
            flex-direction: column;
            gap: 0.75rem;
        }

        .route-cities {
            width: 100%;
            justify-content: center;
        }

        .route-city {
            font-size: 0.95rem;
            text-align: center;
        }

        .route-arrow {
            margin: 0 8px;
            font-size: 1rem;
        }

        .route-price {
            font-size: 0.9rem;
            text-align: center;
            width: 100%;
        }

        /* Process Steps Mobile */
        .process-step {
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .process-step:hover {
            transform: translateY(-5px);
        }

        .process-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
            margin-bottom: 0.75rem;
        }

        .process-step h4 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .process-step p {
            font-size: 0.9rem;
        }

        /* News & Cities Mobile */
        .news-card,
        .city-card {
            margin-bottom: 1.5rem;
        }

        .news-image,
        .city-image {
            height: 180px;
            font-size: 2.5rem;
        }

        .city-card:hover {
            transform: scale(1.01);
        }

        .news-card .p-4,
        .city-card .p-4 {
            padding: 1.25rem !important;
        }

        .rating-stars {
            margin-bottom: 1rem !important;
        }

        .rating-stars span {
            font-size: 0.9rem;
        }
    }

    /* Small Mobile */
    @media (max-width: 575.98px) {
        .hero-section {
            min-height: 300px;
            padding: 1.5rem 0;
        }

        .hero-wrapper {
            margin-bottom: 2rem;
        }

        .hero-title {
            font-size: 1.75rem;
            padding: 0 0.5rem;
        }

        .hero-subtitle {
            font-size: 0.95rem;
        }

        .lead {
            font-size: 0.9rem;
            padding: 0 0.5rem;
        }

        .floating-search-form {
            margin: -2.5rem 0.5rem 0;
            padding: 1.25rem;
        }

        .section-title {
            padding: 0 0.5rem;
        }

        .section-title h2 {
            font-size: 1.5rem;
        }

        .section-title p {
            font-size: 0.95rem;
        }

        .popular-routes {
            padding: 3rem 0 2rem;
        }

        .route-card {
            margin: 0 0.5rem 0.75rem;
            padding: 0.875rem;
        }

        .route-city {
            font-size: 0.9rem;
        }

        .route-arrow {
            font-size: 0.9rem;
            margin: 0 6px;
        }

        .route-price {
            font-size: 0.85rem;
        }

        /* Process Steps Mobile */
        .process-step {
            padding: 0.75rem;
        }

        .process-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        /* News & Cities Mobile */
        .news-card,
        .city-card {
            margin-bottom: 1.5rem;
        }

        .news-image,
        .city-image {
            height: 150px;
            font-size: 2rem;
        }

        .news-card .p-4,
        .city-card .p-4 {
            padding: 1rem !important;
        }

        .news-card h5,
        .city-card h3 {
            font-size: 1rem;
            line-height: 1.3;
        }

        .news-card p,
        .city-card p {
            font-size: 0.85rem;
        }
    }

    /* Extra Small Mobile */
    @media (max-width: 375px) {
        .hero-title {
            font-size: 1.5rem;
        }

        .floating-search-form {
            margin: -2rem 0.25rem 0;
            padding: 1rem;
        }

        .btn-search {
            padding: 10px 16px;
            font-size: 13px;
        }

        .form-control-custom {
            padding: 8px 10px;
            font-size: 13px;
        }

        .swap-btn {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }

        .section-title h2 {
            font-size: 1.3rem;
        }

        .route-card {
            margin: 0 0.25rem 0.5rem;
            padding: 0.75rem;
        }
    }

    /* Custom Flatpickr styles */
    .flatpickr-calendar {
        background: var(--warm-white);
        border: 2px solid var(--accent-green);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-medium);
    }

    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: var(--primary-green);
        color: white;
    }

    .flatpickr-day.selected {
        background: var(--primary-green);
        border-color: var(--primary-green);
    }

    .flatpickr-day:hover {
        background: var(--accent-green);
        border-color: var(--primary-green);
    }

    .flatpickr-weekday {
        background: var(--soft-green);
        color: var(--text-dark);
    }
</style>
@endpush

@section('content')
<!-- Hero Wrapper -->
<div class="hero-wrapper">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <h1 class="hero-title">{{ __('Inside Laos/Laos-China cross-border train') }}</h1>
                        <h2 class="hero-subtitle">{{ __('Online booking') }}</h2>
                        <p class="lead">{{ __('We support train ticket booking at: Vientiane, Vangvieng, Luang Prabang, Muangxai, Nathu, Boten and China: Kunming, Mohan, Pu\'er, Xishuangbanna, Bangkok, Thailand, Vietnam and other stations') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Floating Search Form -->
    <div class="container">
        <div class="floating-search-form">
            <form id="searchForm">
                <div class="row align-items-end search-form-row">
                    <div class="col-md-5">
                        <label class="form-label">{{ __('DEPARTURE') }}</label>
                        <select class="form-control form-control-custom" id="departure" required>
                            <option value="">{{ __('Select departure') }}</option>
                            <option value="vientiane">{{ __('Vientiane') }}</option>
                            <option value="vangvieng">{{ __('Vang Vieng') }}</option>
                            <option value="luangprabang">{{ __('Luang Prabang') }}</option>
                            <option value="bangkok">{{ __('Bangkok') }}</option>
                        </select>
                    </div>

                    <div class="col-md-2 text-center">
                        <button type="button" class="swap-btn" onclick="swapLocations()">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                    </div>

                    <div class="col-md-5">
                        <label class="form-label">{{ __('ARRIVAL') }}</label>
                        <select class="form-control form-control-custom" id="arrival" required>
                            <option value="">{{ __('Select arrival') }}</option>
                            <option value="vientiane">{{ __('Vientiane') }}</option>
                            <option value="vangvieng">{{ __('Vang Vieng') }}</option>
                            <option value="luangprabang">{{ __('Luang Prabang') }}</option>
                            <option value="bangkok">{{ __('Bangkok') }}</option>
                        </select>
                    </div>
                </div>

                <div class="row g-3 mt-md-3">
                    <div class="col-md-6">
                        <label class="form-label">{{ __('TRAVEL DATE') }}</label>
                        <input type="text" class="form-control form-control-custom" id="travel-date" 
                               placeholder="{{ __('Select travel date') }}" required readonly>
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-search">
                            <i class="fas fa-search me-2"></i>{{ __('SEARCH') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Popular Routes -->
<section class="popular-routes animate-on-scroll">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('Popular Train Routes') }}</h2>
            <p>{{ __('Discover the most traveled routes with best prices and convenient schedules') }}</p>
        </div>
        
        <div class="row">
            <div class="col-lg-6">
                <h3 class="h4 fw-bold mb-4 text-primary-green">{{ __('Laos Popular Routes') }}</h3>
                <div class="routes-container">
                    <a href="#" class="route-card" style="--delay: 0.1s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Vientiane') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Bangkok') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $25') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.2s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Vientiane') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Vang Vieng') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $15') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.3s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Vientiane') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Luang Prabang') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $20') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.4s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Luang Prabang') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Vientiane') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $20') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.5s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Vang Vieng') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Vientiane') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $15') }}</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <h3 class="h4 fw-bold mb-4 text-primary-green">{{ __('Thailand Popular Routes') }}</h3>
                <div class="routes-container">
                    <a href="#" class="route-card" style="--delay: 0.1s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Bangkok') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Vientiane') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $25') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.2s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Bangkok') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Chiang Mai') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $30') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.3s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Bangkok') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Hua Hin') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $18') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.4s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Bangkok') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Surat Thani') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $22') }}</div>
                        </div>
                    </a>
                    <a href="#" class="route-card" style="--delay: 0.5s">
                        <div class="route-content">
                            <div class="route-cities">
                                <span class="route-city">{{ __('Chiang Mai') }}</span>
                                <i class="fas fa-arrow-right route-arrow"></i>
                                <span class="route-city">{{ __('Bangkok') }}</span>
                            </div>
                            <div class="route-price">{{ __('From $30') }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Booking Process -->
<section class="booking-process animate-on-scroll">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('Simple and fast booking process') }}</h2>
            <p>{{ __('Book your train tickets in just a few simple steps') }}</p>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="process-step" style="--delay: 0.1s">
                    <div class="process-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h4 class="h5 fw-bold">{{ __('Book train tickets') }}</h4>
                    <p class="text-muted">{{ __('Search and select your preferred train route and schedule') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="process-step" style="--delay: 0.2s">
                    <div class="process-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h4 class="h5 fw-bold">{{ __('Multiple payment methods') }}</h4>
                    <p class="text-muted">{{ __('Pay securely with various payment options available') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="process-step" style="--delay: 0.3s">
                    <div class="process-icon">
                        <i class="fas fa-ticket-alt"></i>
                    </div>
                    <h4 class="h5 fw-bold">{{ __('Get electronic ticket') }}</h4>
                    <p class="text-muted">{{ __('Receive your e-ticket via email within 60 minutes') }}</p>
                </div>
            </div>

            <div class="col-md-3">
                <div class="process-step" style="--delay: 0.4s">
                    <div class="process-icon">
                        <i class="fas fa-train"></i>
                    </div>
                    <h4 class="h5 fw-bold">{{ __('Board the train') }}</h4>
                    <p class="text-muted">{{ __('Show your e-ticket and enjoy your comfortable journey') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- News Section -->
<section class="news-section animate-on-scroll">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('Laos Latest Travel News') }}</h2>
            <p>{{ __('Stay updated with the latest travel information and tips') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="news-card" style="--delay: 0.1s">
                    <div class="news-image">📰</div>
                    <div class="p-4">
                        <p class="text-muted small">{{ __('By Laostrain') }} • 2024-10-11</p>
                        <h5 class="fw-bold">{{ __('Vientiane Railway Station Location and Introduction') }}</h5>
                        <p class="text-muted">{{ __('Complete guide to Vientiane Railway Station with location details and facilities information.') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="news-card" style="--delay: 0.2s">
                    <div class="news-image">🚄</div>
                    <div class="p-4">
                        <p class="text-muted small">{{ __('By Laostrain') }} • 2024-10-11</p>
                        <h5 class="fw-bold">{{ __('Vang Vieng Railway Station Location and Introduction') }}</h5>
                        <p class="text-muted">{{ __('Everything you need to know about Vang Vieng Railway Station and its services.') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="news-card" style="--delay: 0.3s">
                    <div class="news-image">🎫</div>
                    <div class="p-4">
                        <p class="text-muted small">{{ __('By Laostrain') }} • 2024-10-11</p>
                        <h5 class="fw-bold">{{ __('Luang Prabang Railway Station Location and Introduction') }}</h5>
                        <p class="text-muted">{{ __('Discover Luang Prabang Railway Station and plan your trip to this UNESCO World Heritage city.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Cities Section -->
<section class="cities-section animate-on-scroll">
    <div class="container">
        <div class="section-title">
            <h2>{{ __('Popular Cities') }}</h2>
            <p>{{ __('Explore the most beautiful destinations in Laos') }}</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="city-card" style="--delay: 0.1s">
                    <div class="city-image">🏛️</div>
                    <div class="p-4">
                        <h3 class="h4 fw-bold">{{ __('Vientiane - the capital and largest city of Laos') }}</h3>
                        <div class="rating-stars mb-3">
                            <span class="fw-bold">{{ __('Recommendation worth five stars') }}</span>
                            <div>
                                <i class="fas fa-star" style="--star-delay: 0.1s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.2s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.3s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.4s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.5s"></i>
                            </div>
                        </div>
                        <p class="text-muted">{{ __('Explore the charming capital city of Laos with its French colonial architecture, Buddhist temples, and vibrant markets.') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="city-card" style="--delay: 0.2s">
                    <div class="city-image">⛰️</div>
                    <div class="p-4">
                        <h3 class="h4 fw-bold">{{ __('Luang Prabang - the quiet ancient capital of Laos') }}</h3>
                        <div class="rating-stars mb-3">
                            <span class="fw-bold">{{ __('Recommendation worth five stars') }}</span>
                            <div>
                                <i class="fas fa-star" style="--star-delay: 0.1s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.2s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.3s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.4s"></i>
                                <i class="fas fa-star" style="--star-delay: 0.5s"></i>
                            </div>
                        </div>
                        <p class="text-muted">{{ __('UNESCO World Heritage site known for its well-preserved architecture, ancient temples, and spiritual atmosphere.') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<!-- Flatpickr CSS & JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
// Initialize Flatpickr with localization
document.addEventListener('DOMContentLoaded', function() {
    // Get current locale
    const locale = '{{ app()->getLocale() }}';
    
    // Configure Flatpickr
    const flatpickrConfig = {
        minDate: "today",
        defaultDate: new Date(Date.now() + 24 * 60 * 60 * 1000), // Tomorrow
        dateFormat: "Y-m-d",
        allowInput: false,
        clickOpens: true,
        disableMobile: true, // Force desktop version for consistency
    };

    // Add locale-specific settings
    if (locale === 'en') {
        flatpickrConfig.locale = {
            weekdays: {
                shorthand: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                longhand: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                longhand: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
            }
        };
    } else if (locale === 'vi') {
        flatpickrConfig.locale = {
            weekdays: {
                shorthand: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
                longhand: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy']
            },
            months: {
                shorthand: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
                longhand: ['Tháng Một', 'Tháng Hai', 'Tháng Ba', 'Tháng Tư', 'Tháng Năm', 'Tháng Sáu', 'Tháng Bảy', 'Tháng Tám', 'Tháng Chín', 'Tháng Mười', 'Tháng Mười Một', 'Tháng Mười Hai']
            }
        };
    }

    // Initialize date picker
    flatpickr("#travel-date", flatpickrConfig);

    // Rest of your existing JavaScript...
    function swapLocations() {
        const departure = document.getElementById('departure');
        const arrival = document.getElementById('arrival');

        if (departure && arrival) {
            const temp = departure.value;
            departure.value = arrival.value;
            arrival.value = temp;
        }
    }

    // Make swapLocations global
    window.swapLocations = swapLocations;

    // Form handler
    const searchForm = document.getElementById('searchForm');

    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const departure = document.getElementById('departure').value;
            const arrival = document.getElementById('arrival').value;
            const travelDate = document.getElementById('travel-date').value;

            if (!departure || !arrival || !travelDate) {
                alert('{{ __("Please fill in all fields") }}');
                return;
            }

            if (departure === arrival) {
                alert('{{ __("Please select different departure and arrival cities") }}');
                return;
            }

            alert('{{ __("Searching for trains from") }} ' + departure + ' {{ __("to") }} ' + arrival + ' {{ __("on") }} ' + travelDate);
        });
    }

    // Scroll reveal animation
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate');
            }
        });
    }, observerOptions);

    const sections = document.querySelectorAll('.animate-on-scroll');
    sections.forEach(section => {
        observer.observe(section);
    });
});
</script>
@endpush