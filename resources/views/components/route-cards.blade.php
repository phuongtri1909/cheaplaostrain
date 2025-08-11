@props(['routes'])

<div class="routes-grid">
    @foreach ($routes as $route)
        <div class="route-card-modern animate-on-scroll"
            onclick="searchRoute('{{ $route['from_code'] }}', '{{ $route['to_code'] }}')">
            <div class="route-content">
                <div class="route-header">
                    <div class="route-cities">
                        <div class="city-info">
                            <div class="city-code">{{ Str::limit($route['from_code'], 8) }}</div>
                            <div class="city-name">{{ $route['from_name'] }}</div>
                        </div>
                        <i class="fas fa-arrow-right route-arrow"></i>
                        <div class="city-info">
                            <div class="city-code">{{ Str::limit($route['to_code'], 8) }}</div>
                            <div class="city-name">{{ $route['to_name'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="route-details">
                     <div class="route-price">
                        <div class="price-amount-route">{{ $route['price'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

@once
    @push('scripts')
        <script>
            function searchRoute(fromCode, toCode) {
                // Tính ngày 2 ngày sau
                const today = new Date();
                const futureDate = new Date(today.getTime() + (2 * 24 * 60 * 60 * 1000));

                // Format ngày theo yyyy-mm-dd
                const year = futureDate.getFullYear();
                const month = String(futureDate.getMonth() + 1).padStart(2, '0');
                const day = String(futureDate.getDate()).padStart(2, '0');
                const dateStr = `${year}-${month}-${day}`;

                // Tạo URL với query parameters cho GET request
                const params = new URLSearchParams({
                    departure: fromCode,
                    arrival: toCode,
                    travel_date: dateStr
                });

                // Redirect to tickets.list route với GET parameters
                window.location.href = '{{ route("tickets.list") }}?' + params.toString();
            }
        </script>
    @endpush
@endonce

@once
    @push('styles')
        <style>
            .routes-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
                gap: 2rem;
                margin-top: 3rem;
            }

            .route-card-modern {
                background: white;
                border-radius: 16px;
                overflow: hidden;
                border: 1px solid #10b981;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
                position: relative;
                cursor: pointer;
            }

            .route-card-modern:hover {
                transform: translateY(-8px) scale(1.02);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
                border-color: #059669;
            }

            .route-image {
                height: 200px;
                background-size: cover;
                background-position: center;
                position: relative;
            }

            .route-image::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: linear-gradient(135deg, rgba(5, 150, 105, 0.8) 0%, rgba(16, 185, 129, 0.6) 100%);
            }

            .route-content {
                padding: 1rem;
                position: relative;
            }

            .route-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                margin-bottom: 1rem;
            }

            .route-cities {
                display: flex;
                align-items: center;
                gap: 1rem;
            }

            .city-info {
                text-align: center;
            }

            .city-code {
                font-size: 1.2rem;
                font-weight: 700;
                color: #1f2937;
            }

            .city-name {
                font-size: 0.8rem;
                color: #6b7280;
                margin-top: 0.25rem;
            }

            .route-arrow {
                color: #059669;
                font-size: 1.2rem;
                animation: slideArrow 2s ease-in-out infinite;
            }

            @keyframes slideArrow {
                0%, 100% { transform: translateX(0); }
                50% { transform: translateX(3px); }
            }

            .route-price {
                text-align: right;
            }

            .price-label {
                font-size: 0.75rem;
                color: #6b7280;
            }

            .route-details {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding-top: 0.5rem;
                border-top: 1px solid #10b981;
                font-size: 0.85rem;
                font-weight: 500;
            }

            .price-amount-route {
                color: #22c55e;
                font-weight: 500;
            }

            @media (max-width: 768px) {
                .route-image {
                    height: 150px;
                }
            }
        </style>
    @endpush
@endonce
