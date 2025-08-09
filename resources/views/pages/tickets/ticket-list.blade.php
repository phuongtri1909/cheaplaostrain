@extends('layouts.app')
@section('title', 'Train Tickets - ' . ($searchParams['departure'] ?? 'Vientiane') . ' to ' . ($searchParams['arrival']
    ?? 'Vang Vieng'))

    @push('styles')
        <style>
            .ticket-list-page {
                min-height: 100vh;
            }

            .trains-container {
                display: flex;
                flex-direction: column;
                gap: var(--element-gap);
            }

            .no-trains-card {
                background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
                border-radius: var(--modern-radius);
                padding: 4rem;
                text-align: center;
                box-shadow: var(--shadow-medium);
                border: 1px solid var(--accent-green);
            }

            .no-trains-icon {
                font-size: 5rem;
                color: var(--text-light);
                margin-bottom: 2rem;
            }

            .no-trains-title {
                font-size: 2rem;
                font-weight: 800;
                color: var(--text-dark);
                margin-bottom: 1rem;
            }

            .no-trains-text {
                color: var(--text-medium);
                font-size: 1.1rem;
                margin-bottom: 2rem;
            }

            .search-again-btn {
                background: var(--gradient-green);
                border: none;
                color: white;
                padding: 1rem 2rem;
                border-radius: var(--modern-radius);
                font-weight: 700;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                gap: 0.75rem;
                transition: var(--transition-smooth);
                box-shadow: var(--shadow-medium);
            }

            .search-again-btn:hover {
                transform: var(--button-hover-transform);
                box-shadow: var(--shadow-strong);
                color: white;
            }
        </style>
    @endpush

@section('content')
    <div class="ticket-list-page">
        <x-global-animations />
        <x-hero-section :title="__('Find & Book Your Train Tickets')" :subtitle="__('Select your preferred train and class in one convenient place')" />
        <x-search-card :searchTitle="__('Search Train Tickets')" :searchSubtitle="__('Enter your travel details to find available train.')" />

        <x-search-summary :searchParams="$searchParams" :trainsCount="count($trains ?? [])" />
        <div class="container">
            <div class="trains-container my-3 my-md-5" id="trainsContainer">
                @if (isset($trains) && count($trains) > 0)
                    @foreach ($trains as $index => $train)
                        <x-train-card :train="$train" :index="$index" :searchParams="$searchParams" />
                    @endforeach
                @else
                    <div class="no-trains-card">
                        <i class="fas fa-train no-trains-icon"></i>
                        <h3 class="no-trains-title">{{ __('No trains available') }}</h3>
                        <p class="no-trains-text">{{ __('Please try a different date or route') }}</p>
                        <a href="{{ route('home') }}" class="search-again-btn">
                            <i class="fas fa-search"></i>
                            {{ __('Search Again') }}
                        </a>
                    </div>
                @endif
            </div>

            <section class="section-modern alt" style="padding: 4rem 0;">
                <x-section-header :badge="__('How It Works')" :title="__('Book in 3 Simple Steps')" :subtitle="__('Select train, choose class, and pay - all in one place')" />
                <x-process-steps :steps="[
                    [
                        'icon' => 'fas fa-search',
                        'title' => __('Choose Train'),
                        'description' => __(
                            'Select your preferred train from available options with different amenities',
                        ),
                    ],
                    [
                        'icon' => 'fas fa-crown',
                        'title' => __('Select Class'),
                        'description' => __(
                            'Pick between Second Class or First Class based on your comfort preferences',
                        ),
                    ],
                    [
                        'icon' => 'fas fa-credit-card',
                        'title' => __('Pay & Travel'),
                        'description' => __('Complete secure payment and receive your e-tickets instantly via email'),
                    ],
                ]" />
            </section>

            <x-policy-section />
        </div>
    </div>

    <x-class-selection-modal :searchParams="$searchParams" />
@endsection

@push('scripts')
    <script>
        window.currentTrain = null;
        window.currentTrainData = null;

        // Main function to select train and open modal
        function selectTrain(trainId) {
            const trains = @json($trains ?? []);
            window.currentTrainData = trains.find(train => train.id == trainId);
            window.currentTrain = trainId;

            if (!window.currentTrainData) {
                console.error('Train not found:', trainId);
                return;
            }

            // Update modal with train data (function from modal component)
            if (typeof updateClassModal === 'function') {
                updateClassModal();
            }

            // Show class selection modal (function from modal component)
            if (typeof showClassModal === 'function') {
                showClassModal();
            }
        }
    </script>
@endpush
