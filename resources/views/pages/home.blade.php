@extends('layouts.app')
@section('title', 'Cheap Laos Train - Book Train Tickets Online')
@section('description', 'Book Laos train tickets online. Fast and convenient booking for Vientiane, Vang Vieng, Luang Prabang routes. Best prices guaranteed.')
@section('keyword', 'Cheap Laos Train, Laos Train, Train Booking, Laos Travel, Vientiane, Luang Prabang, Vang Vieng')

@section('content')
<!-- Global Animations -->
<x-global-animations />

<!-- Hero Section -->
<x-hero-section
    :title="__('Book Laos Train Tickets') . '<br>'"
    :subtitle="__('Experience comfortable train travel across Laos. Book tickets for Vientiane.')"
/>

<!-- Search Card -->
<x-search-card
    :searchTitle="__('Find Train Tickets')"
    :searchSubtitle="__('Search and book train tickets across Laos with the best prices and schedules')"
    :stations="$stations"
/>

<!-- Popular Routes Section -->
@if($popularRoutes->count() > 0)
<section class="section-modern mt-5" id="routes">
    <div class="container">
        <x-section-header
            :badge="__('Available Routes')"
            :title="__('Popular Train Routes in Laos')"
            :subtitle="__('Book tickets for these popular routes with multiple daily departures')"
        />

        <x-route-cards :routes="$popularRoutes->toArray()" />
    </div>
</section>
@else
<section class="section-modern mt-5" id="routes">
    <div class="container">
        <x-section-header
            :badge="__('Popular Routes')"
            :title="__('Most Popular Train Routes in Laos')"
            :subtitle="__('Discover the most traveled train routes connecting major cities in Laos')"
        />

        <x-route-cards :routes="[
            [
                'image' => 'https://images.unsplash.com/photo-1553913861-c0fddf2619ee?ixlib=rb-4.0.3&auto=format&fit=crop&w=1469&q=80',
                'from_code' => '1', // Station ID for Vientiane
                'from_name' => __('Vientiane'),
                'to_code' => '2', // Station ID for Vang Vieng
                'to_name' => __('Vang Vieng'),
                'price' => '$2.00',
                'duration' => __('3h 0m'),
                'availability' => __('Daily departures')
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1480&q=80',
                'from_code' => '1', // Station ID for Vientiane
                'from_name' => __('Vientiane'),
                'to_code' => '3', // Station ID for Luang Prabang
                'to_name' => __('Luang Prabang'),
                'price' => '$5.00',
                'duration' => __('8h 0m'),
                'availability' => __('Daily departures')
            ],
            [
                'image' => 'https://images.unsplash.com/photo-1563906267088-b029e7101114?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80',
                'from_code' => '1', // Station ID for Vientiane
                'from_name' => __('Vientiane'),
                'to_code' => '4', // Station ID for Pakse
                'to_name' => __('Pakse'),
                'price' => '$8.00',
                'duration' => __('13h 0m'),
                'availability' => __('Daily departures')
            ]
        ]" />
    </div>
</section>
@endif

<!-- How It Works Section -->
<section class="section-modern alt mt-5 p-3" id="features">
    <div class="container">
        <x-section-header
            :badge="__('How It Works')"
            :title="__('Book in 3 Simple Steps')"
            :subtitle="__('Our streamlined booking process makes it easy to secure your train tickets')"
        />

        <x-process-steps :steps="[
            [
                'icon' => 'fas fa-search',
                'title' => __('Search Routes'),
                'description' => __('Enter your departure and destination cities along with your travel date to find available trains')
            ],
            [
                'icon' => 'fas fa-credit-card',
                'title' => __('Select & Pay'),
                'description' => __('Choose your preferred seat class and complete secure payment with multiple payment options')
            ],
            [
                'icon' => 'fas fa-ticket-alt',
                'title' => __('Travel'),
                'description' => __('Receive your e-ticket instantly and enjoy a comfortable journey on modern trains')
            ]
        ]" />
    </div>
</section>

<!-- Features Section -->
<section class="section-modern mt-5">
    <div class="container">
        <x-section-header
            :badge="__('Why Choose Us')"
            :title="__('Travel with Confidence')"
            :subtitle="__('Experience the best in train travel with our comprehensive booking platform')"
        />

        <x-features-grid :features="[
            [
                'icon' => 'fas fa-shield-alt',
                'title' => __('Secure Booking'),
                'description' => __('Your personal and payment information is protected with bank-level security')
            ],
            [
                'icon' => 'fas fa-clock',
                'title' => __('Instant Confirmation'),
                'description' => __('Get your e-tickets immediately after payment confirmation')
            ],
            [
                'icon' => 'fas fa-headset',
                'title' => __('24/7 Support'),
                'description' => __('Our customer support team is available round the clock to assist you')
            ],
            [
                'icon' => 'fas fa-mobile-alt',
                'title' => __('Mobile Friendly'),
                'description' => __('Book tickets on any device with our responsive mobile-first design')
            ],
            [
                'icon' => 'fas fa-star',
                'title' => __('Best Prices'),
                'description' => __('Compare prices and find the best deals for your train journey')
            ],
            [
                'icon' => 'fas fa-globe',
                'title' => __('Multi-Language'),
                'description' => __('Available in multiple languages for travelers from around the world')
            ]
        ]" />
    </div>
</section>

<!-- Stats Section -->
@php
    $stationsCount = $stations->count();
@endphp

<x-stats-section :stats="[
    ['number' => 10000, 'label' => __('Happy Travelers')],
    ['number' => 500, 'label' => __('Daily Bookings')],
    ['number' => $stationsCount, 'label' => __('Cities Connected')],
    ['number' => 99, 'label' => __('Success Rate') . '%']
]" />

<!-- CTA Section -->
<x-cta-section
    :title="__('Start Your Journey Today')"
    :subtitle="__('Join thousands of travelers who trust us for their train booking needs in Laos')"
    :buttonText="__('Book Your Ticket')"
    buttonLink="#searchCard"
/>
@endsection
