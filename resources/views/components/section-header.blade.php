@props(['badge', 'title', 'subtitle'])

@once
    @push('styles')
        <style>
            .section-header {
                text-align: center;
                margin-bottom: 4rem;
            }

            .section-badge {
                display: inline-block;
                background: linear-gradient(135deg, #059669 0%, #10b981 100%);
                color: white;
                padding: 0.5rem 1.5rem;
                border-radius: 20px;
                font-size: 0.85rem;
                font-weight: 600;
                margin-bottom: 1rem;
                margin-top: 1rem;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }

            .section-title {
                font-size: clamp(2.5rem, 5vw, 4rem);
                font-weight: 700;
                margin-bottom: 1rem;
                color: #1f2937;
                line-height: 1.2;
            }

            .section-subtitle {
                font-size: 1.2rem;
                color: #6b7280;
                max-width: 600px;
                margin: 0 auto;
                line-height: 1.6;
            }
        </style>
    @endpush
@endonce

<div class="section-header animate-on-scroll">
    @if (isset($badge))
        <div class="section-badge">{{ $badge }}</div>
    @endif

    @if (isset($title))
        <h2 class="section-title">{{ $title }}</h2>
    @endif

    @if (isset($subtitle))
        <p class="section-subtitle">{{ $subtitle }}</p>
    @endif
</div>
