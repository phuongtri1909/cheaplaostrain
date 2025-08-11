@props(['searchParams', 'trainsCount'])

@if(isset($trainsCount) && $trainsCount > 0)
<div class="container">
    <div class="search-summary">
        <div class="summary-header">
            <div class="summary-route">
                <span>{{ $searchParams['departure_name'] ?? 'Unknown' }}</span>
                <i class="fas fa-arrow-right"></i>
                <span>{{ $searchParams['arrival_name'] ?? 'Unknown' }}</span>
            </div>
            <div class="summary-count">
                {{ $trainsCount }} {{ __('trains found') }}
            </div>
        </div>
        <div class="summary-details">
            <div class="summary-item">
                <i class="fas fa-calendar"></i>
                <span>{{ date('l, F j, Y', strtotime($searchParams['travel_date'])) }}</span>
            </div>
        </div>
    </div>
</div>
@endif
@push('styles')
<style>
    .search-summary {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-radius: 12px;
        padding: 1.5rem;
        margin: 2rem 0;
        border: 1px solid #cbd5e1;
    }

    .summary-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .summary-route {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 600;
        color: #1f2937;
    }

    .summary-route i {
        color: #10b981;
    }

    .summary-count {
        background: #10b981;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .summary-details {
        display: flex;
        gap: 2rem;
        font-size: 0.9rem;
        color: #6b7280;
    }

    .summary-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .summary-header {
            flex-direction: column;
            gap: 1rem;
            align-items: flex-start;
        }

        .summary-details {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endpush
