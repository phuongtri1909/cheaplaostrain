@props(['train', 'index', 'searchParams'])

@once
    @push('styles')
        <style>
            .train-card-modern {
                background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
                border-radius: var(--modern-radius);
                overflow: hidden;
                box-shadow: var(--shadow-medium);
                border: 1px solid var(--gradient-green-soft);
                transition: var(--transition-smooth);
                cursor: pointer;
                animation: slideInUp 0.6s ease-out var(--delay, 0s) both;
            }

            .train-card-modern:hover {
                transform: var(--card-hover-transform);
                box-shadow: var(--shadow-strong);
            }

            .train-card-modern:hover {
                transform: translateX(-100px);
            }

            .train-info {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .train-details h3 {
                font-size: 1.8rem;
                font-weight: 800;
                margin-bottom: 0.5rem;
            }

            .train-type {
                opacity: 0.9;
                font-weight: 500;
            }

            .train-amenities {
                display: flex;
                gap: 0.75rem;
                flex-wrap: wrap;
            }

            .amenity-badge {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: var(--backdrop-blur);
                border-radius: var(--radius-xl);
                padding: 0.5rem 1rem;
                font-size: 0.85rem;
                font-weight: 600;
                transition: var(--transition-smooth);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .amenity-badge:hover {
                background: rgba(255, 255, 255, 0.35);
                transform: scale(1.05);
            }

            .train-schedule {
                padding: 2rem;
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                gap: 2rem;
                align-items: center;
                border: 1px solid var(--gradient-green-soft);
            }

            .schedule-point {
                text-align: center;
                border-radius: var(--modern-radius);
                background: var(--gradient-green-soft);
                border: 1px solid var(--gradient-green-soft);
            }

            .schedule-time {
                font-size: 2.5rem;
                font-weight: 800;
                color: var(--primary-green);
                margin-bottom: 0.5rem;
            }

            .schedule-city {
                font-size: 1.3rem;
                font-weight: 700;
                color: var(--text-dark);
                margin-bottom: 0.25rem;
            }

            .schedule-date {
                color: var(--text-medium);
                font-weight: 500;
            }

            .schedule-connector {
                display: flex;
                flex-direction: column;
                align-items: center;
                gap: 1rem;
                padding: 1rem;
            }

            .duration-line {
                width: 150px;
                height: 4px;
                background: var(--gradient-green);
                border-radius: 2px;
                position: relative;
                overflow: hidden;
            }

            .duration-line::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
                animation: shimmer 2s ease-in-out infinite;
            }

            .duration-line::after {
                content: '';
                position: absolute;
                right: -10px;
                top: -8px;
                width: 0;
                height: 0;
                border-left: 16px solid var(--accent-green);
                border-top: 10px solid transparent;
                border-bottom: 10px solid transparent;
            }

            .duration-text {
                font-weight: 700;
                color: var(--primary-green);
                font-size: 1.1rem;
                padding: 0.5rem 1rem;
                background: var(--gradient-green-soft);
                border-radius: var(--radius-lg);
            }

            .book-button {
                margin: 2rem;
                background: var(--gradient-green);
                border: none;
                color: white;
                padding: 1.25rem 2rem;
                border-radius: var(--modern-radius);
                font-weight: 700;
                font-size: 1.1rem;
                transition: var(--transition-smooth);
                width: calc(100% - 4rem);
                position: relative;
                overflow: hidden;
                box-shadow: var(--shadow-medium);
            }

            .book-button::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.6s ease;
            }

            .book-button:hover::before {
                left: 100%;
            }

            .book-button:hover {
                transform: var(--button-hover-transform);
                box-shadow: var(--shadow-strong);
            }

            @keyframes shimmer {
                0% {
                    left: -100%;
                }

                100% {
                    left: 100%;
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

            /* FIX MOBILE RESPONSIVE */
            @media (max-width: 768px) {
                .train-schedule {
                    grid-template-columns: 1fr 1fr;
                    grid-template-rows: auto auto;
                    gap: 0.75rem;
                    padding: 1rem;
                }

                .schedule-point {
                    padding: 0.75rem;
                }

                .schedule-connector {
                    grid-column: 1 / -1;
                    order: 2;
                    flex-direction: row;
                    justify-content: center;
                    gap: 0.5rem;
                    padding: 0.25rem;
                }

                .duration-line {
                    width: 60px;
                    height: 3px;
                }

                .duration-text {
                    font-size: 0.8rem;
                    padding: 0.25rem 0.5rem;
                }

                .schedule-time {
                    font-size: 1.5rem;
                    margin-bottom: 0.25rem;
                }

                .schedule-city {
                    font-size: 0.95rem;
                    margin-bottom: 0.1rem;
                }

                .schedule-date {
                    font-size: 0.8rem;
                }
            }

            @media (max-width: 480px) {
                .train-schedule {
                    padding: 0.75rem;
                    gap: 0.5rem;
                }

                .schedule-point {
                    padding: 0.5rem;
                }

                .schedule-time {
                    font-size: 1.3rem;
                }

                .schedule-city {
                    font-size: 0.85rem;
                }

                .schedule-date {
                    font-size: 0.75rem;
                }

                .duration-text {
                    font-size: 0.75rem;
                    padding: 0.2rem 0.4rem;
                }

                .duration-line {
                    width: 50px;
                }
            }
        </style>
    @endpush
@endonce

<div class="train-card-modern" style="--delay: {{ $index * 0.1 }}s" data-train-id="{{ $train['id'] }}"
    onclick="selectTrain({{ $train['id'] }})">
    <div class="train-schedule">
        <div class="schedule-point">
            <div class="schedule-time">{{ $train['departure_time'] }}</div>
            <div class="schedule-city">{{ $searchParams['departure'] ?? 'Vientiane' }}</div>
            <div class="schedule-date">{{ date('M d', strtotime($searchParams['date'] ?? 'tomorrow')) }}</div>
        </div>

        <div class="schedule-connector">
            <div class="duration-text">{{ $train['duration'] }}</div>
            <div class="duration-line"></div>
            <small style="color: var(--text-medium); font-weight: 600;">{{ __('Direct') }}</small>
        </div>

        <div class="schedule-point">
            <div class="schedule-time">{{ $train['arrival_time'] }}</div>
            <div class="schedule-city">{{ $searchParams['arrival'] ?? 'Vang Vieng' }}</div>
            <div class="schedule-date">{{ date('M d', strtotime($searchParams['date'] ?? 'tomorrow')) }}</div>
        </div>
    </div>
</div>
