@once
@push('styles')
<style>
    .policy-section {
        background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        border-radius: var(--modern-radius);
        box-shadow: var(--shadow-medium);
        margin: 4rem 0;
        overflow: hidden;
        border: 1px solid var(--accent-green);
    }

    .policy-header {
        background: var(--gradient-green);
        color: white;
        padding: 2.5rem;
        text-align: center;
        position: relative;
    }

    .policy-title {
        font-size: 2rem;
        font-weight: 800;
        margin: 0;
    }

    .policy-tabs {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        background: var(--gradient-green-soft);
    }

    .policy-tab {
        padding: 1.5rem;
        text-align: center;
        background: none;
        border: none;
        cursor: pointer;
        transition: var(--transition-smooth);
        font-weight: 700;
        color: var(--text-medium);
        border-bottom: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .policy-tab::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, var(--gradient-green-soft), transparent);
        transition: left 0.6s ease;
    }

    .policy-tab:hover::before {
        left: 100%;
    }

    .policy-tab:hover {
        background: var(--gradient-green-soft);
        color: var(--primary-green);
        transform: var(--button-hover-transform);
    }

    .policy-tab.active {
        background: #ffffff;
        color: var(--primary-green);
        border-bottom-color: var(--primary-green);
        box-shadow: var(--shadow-soft);
    }

    .policy-content {
        padding: 3rem;
        display: none;
        background: #ffffff;
    }

    .policy-content.active {
        display: block;
        animation: fadeInUp 0.4s ease-out;
    }

    .policy-item {
        margin-bottom: 2rem;
        padding: 2rem;
        background: var(--gradient-green-soft);
        border-radius: var(--modern-radius);
        border-left: 6px solid var(--primary-green);
        transition: var(--transition-smooth);
        position: relative;
        overflow: hidden;
    }

    .policy-item::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 100px;
        height: 100%;
        background: linear-gradient(45deg, transparent, var(--gradient-green-soft));
        transform: translateX(100px);
        transition: transform 0.6s ease;
    }

    .policy-item:hover::before {
        transform: translateX(-100px);
    }

    .policy-item:hover {
        transform: translateX(10px);
        box-shadow: var(--shadow-medium);
    }

    .policy-item h4 {
        color: var(--primary-green);
        font-weight: 800;
        font-size: 1.3rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .policy-item h4 i {
        font-size: 1.1rem;
        padding: 0.5rem;
        background: var(--gradient-green-soft);
        border-radius: var(--radius-md);
    }

    .policy-item p {
        color: var(--text-medium);
        margin: 0;
        line-height: 1.7;
        font-size: 1.05rem;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .policy-tabs {
            grid-template-columns: 1fr;
        }

        .policy-content {
            padding: 2rem;
        }

        .policy-item {
            padding: 1.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
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
    const targetContent = document.getElementById(tabName);
    if (targetContent) {
        targetContent.classList.add('active');
    }
}
</script>
@endpush
@endonce

<div class="policy-section">
    <div class="policy-header">
        <h3 class="policy-title">{{ __('Booking Policies & Information') }}</h3>
    </div>

    <div class="policy-tabs">
        <button class="policy-tab active" onclick="showPolicyTab('cancellation')">
            <i class="fas fa-times-circle me-2"></i>
            {{ __('Cancellation') }}
        </button>
        <button class="policy-tab" onclick="showPolicyTab('refund')">
            <i class="fas fa-money-bill-wave me-2"></i>
            {{ __('Refund Policy') }}
        </button>
        <button class="policy-tab" onclick="showPolicyTab('rules')">
            <i class="fas fa-clipboard-list me-2"></i>
            {{ __('Travel Rules') }}
        </button>
        <button class="policy-tab" onclick="showPolicyTab('baggage')">
            <i class="fas fa-suitcase me-2"></i>
            {{ __('Baggage') }}
        </button>
    </div>

    <div class="policy-content active" id="cancellation">
        <div class="policy-item">
            <h4><i class="fas fa-check-circle"></i>{{ __('Free Cancellation') }}</h4>
            <p>{{ __('Cancel your booking free of charge up to 24 hours before departure time.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-exclamation-triangle"></i>{{ __('Partial Cancellation') }}</h4>
            <p>{{ __('Cancellations between 12-24 hours before departure incur a 25% fee.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-clock"></i>{{ __('Late Cancellation') }}</h4>
            <p>{{ __('Cancellations within 12 hours of departure incur a 50% fee.') }}</p>
        </div>
    </div>

    <div class="policy-content" id="refund">
        <div class="policy-item">
            <h4><i class="fas fa-hourglass-half"></i>{{ __('Processing Time') }}</h4>
            <p>{{ __('Refunds are processed within 5-7 business days to your original payment method.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-calculator"></i>{{ __('Refund Amount') }}</h4>
            <p>{{ __('Refund amount depends on the cancellation timing and applicable fees.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-ban"></i>{{ __('No-Show Policy') }}</h4>
            <p>{{ __('No refund is available for no-show passengers or missed departures.') }}</p>
        </div>
    </div>

    <div class="policy-content" id="rules">
        <div class="policy-item">
            <h4><i class="fas fa-id-card"></i>{{ __('Valid ID Required') }}</h4>
            <p>{{ __('All passengers must carry valid government-issued photo identification.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-clock"></i>{{ __('Arrival Time') }}</h4>
            <p>{{ __('Please arrive at the station at least 30 minutes before departure.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-child"></i>{{ __('Age Restrictions') }}</h4>
            <p>{{ __('Children under 12 must be accompanied by an adult. Infants under 2 travel free.') }}</p>
        </div>
    </div>

    <div class="policy-content" id="baggage">
        <div class="policy-item">
            <h4><i class="fas fa-suitcase-rolling"></i>{{ __('Free Allowance') }}</h4>
            <p>{{ __('Each passenger is allowed one carry-on bag (max 7kg) and one checked bag (max 20kg).') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-exclamation-triangle"></i>{{ __('Prohibited Items') }}</h4>
            <p>{{ __('Dangerous goods, flammable materials, and weapons are strictly prohibited.') }}</p>
        </div>
        <div class="policy-item">
            <h4><i class="fas fa-weight-hanging"></i>{{ __('Excess Baggage') }}</h4>
            <p>{{ __('Additional baggage fees apply for items exceeding the free allowance.') }}</p>
        </div>
    </div>
</div>
