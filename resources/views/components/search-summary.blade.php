@props(['searchParams', 'trainsCount' => 0])

@once
    @push('styles')
        <style>
            .route-station {
                font-size: 1.8rem;
                font-weight: 800;
                color: var(--text-dark);
                padding: 0.5rem 1rem;
                background: var(--gradient-green-soft);
                border-radius: var(--radius-lg);
                border: 2px solid var(--accent-green);
            }

            .route-arrow-animated {
                color: var(--primary-green);
                font-size: 2rem;
                animation: slideArrow 2s ease-in-out infinite;
            }

            .search-meta {
                display: flex;
                justify-content: start;
                gap: 1rem;
                align-items: center;
                flex-wrap: nowrap;
                flex-direction: row;
            }

            .meta-item {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                padding: 0.75rem 1.25rem;
                border-radius: var(--radius-md);
                border: 1px solid var(--gradient-green-soft);
                transition: var(--transition-smooth);
            }

            .meta-item:hover {
                transform: translateY(-2px);
            }

            .meta-item i {
                color: var(--primary-green);
            }

            .meta-item span {
                color: var(--text-dark);
                font-weight: 600;
            }

            @keyframes slideArrow {

                0%,
                100% {
                    transform: translateX(0) scale(1);
                }

                50% {
                    transform: translateX(8px) scale(1.1);
                }
            }
        </style>
    @endpush
@endonce

<div class="container">
    <div class="search-meta">
        <div class="meta-item">
            <i class="fas fa-calendar-alt"></i>
            <span>{{ date('D, M d, Y', strtotime($searchParams['date'] ?? 'tomorrow')) }}</span>
        </div>
        <div class="meta-item">
            <i class="fas fa-train"></i>
            <span>{{ $trainsCount }} {{ __('trains available') }}</span>
        </div>
    </div>
</div>
