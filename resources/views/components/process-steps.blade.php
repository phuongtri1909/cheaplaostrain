@props(['steps'])

@once
@push('styles')
<style>
    .process-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 2rem;
        margin-top: 3rem;
    }

    .process-card {
        text-align: center;
        padding: 2rem;
        background: white;
        border-radius: 16px;
        border: 1px solid #10b981;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .process-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }

    .process-icon-wrapper {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, #059669 0%, #10b981 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .process-card:hover .process-icon-wrapper {
        transform: scale(1.1) rotateY(10deg);
    }

    .process-icon {
        font-size: 2rem;
        color: white;
    }

    .process-step-number {
        position: absolute;
        top: -10px;
        right: -10px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #f59e0b;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        font-weight: 700;
    }

    .process-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 1rem;
        color: #1f2937;
    }

    .process-description {
        color: #6b7280;
        line-height: 1.6;
    }
</style>
@endpush
@endonce

<div class="process-grid">
    @foreach($steps as $index => $step)
        <div class="process-card animate-on-scroll">
            <div class="process-step-number">{{ $index + 1 }}</div>
            <div class="process-icon-wrapper">
                <i class="{{ $step['icon'] }} process-icon"></i>
            </div>
            <h3 class="process-title">{{ $step['title'] }}</h3>
            <p class="process-description">{{ $step['description'] }}</p>
        </div>
    @endforeach
</div>
