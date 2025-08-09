@props(['searchTitle', 'searchSubtitle'])

@once
    @push('styles')
        <style>
            /* Search Card - Floating between sections */
            .search-card-wrapper {
                position: relative;
                z-index: 10;
                margin-top: -150px;
                margin-bottom: 50px;
            }

            .search-card {
                background: white;
                border-radius: 16px;
                padding: 2rem;
                box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
                max-width: 1200px;
                margin: 0 auto;
                animation: slideInUp 1s ease-out 0.6s both;
            }

            .search-header {
                display: flex;
                align-items: center;
                margin-bottom: 1.5rem;
                padding-bottom: 0.5rem;
                border-bottom: 1px solid #e5e7eb;
            }

            .search-icon {
                width: 40px;
                height: 40px;
                background: #1f2937;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 1rem;
            }

            .search-icon i {
                color: white;
                font-size: 1.2rem;
            }

            .search-title {
                font-size: 1.1rem;
                font-weight: 600;
                color: #1f2937;
                margin: 0;
            }

            .search-subtitle {
                font-size: 0.9rem;
                color: #6b7280;
                margin: 0.25rem 0 0 0;
            }

            .search-form {
                display: grid;
                grid-template-columns: 1fr auto 1fr 1fr;
                gap: 1rem;
                align-items: end;
                margin-bottom: 1.5rem;
            }

            .form-group {
                position: relative;
            }

            .form-control-floating {
                width: 100%;
                padding: 1rem;
                background: white;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                color: #1f2937;
                font-size: 0.95rem;
                font-weight: 500;
                transition: all 0.3s ease;
                outline: none;
            }

            .form-control-floating:focus {
                border-color: #3b82f6;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            }

            .form-control-floating:focus+.form-label-floating,
            .form-control-floating:not(:placeholder-shown)+.form-label-floating,
            .form-control-floating.has-value+.form-label-floating {
                top: 0px;
                left: 12px;
                font-size: 0.75rem;
                color: #6b7280;
                font-weight: 500;
                background: white;
                padding: 0 4px;
            }

            .form-label-floating {
                position: absolute;
                top: 50%;
                left: 1rem;
                transform: translateY(-50%);
                color: #9ca3af;
                font-size: 0.95rem;
                font-weight: 400;
                transition: all 0.3s ease;
                pointer-events: none;
                background: transparent;
            }

            .route-swap {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 36px;
                height: 36px;
                background: white;
                border: 1px solid #d1d5db;
                border-radius: 8px;
                color: #6b7280;
                cursor: pointer;
                transition: all 0.3s ease;
                align-self: center;
                margin-top: 0.5rem;
            }

            .route-swap:hover {
                background: #f9fafb;
                border-color: #9ca3af;
                color: #374151;
                transform: scale(1.05);
            }

            .route-swap i {
                font-size: 0.9rem;
                transform: rotate(90deg);
            }

            .btn-search-modern {
                background: #1f2937;
                border: none;
                color: white;
                padding: 1rem 2rem;
                border-radius: 8px;
                font-weight: 600;
                font-size: 0.95rem;
                transition: all 0.3s ease;
                grid-column: 1 / -1;
                justify-self: center;
                min-width: 200px;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            .btn-search-modern:hover {
                background: #111827;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(31, 41, 55, 0.15);
                color: white;
            }

            .trust-indicators {
                display: flex;
                justify-content: center;
                gap: 2rem;
                margin-top: 1.5rem;
                padding-top: 1.5rem;
                border-top: 1px solid #e5e7eb;
                flex-wrap: wrap;
            }

            .trust-item {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: #6b7280;
                font-size: 0.85rem;
            }

            .trust-item i {
                color: #10b981;
                font-size: 0.9rem;
            }

            @media (max-width: 768px) {
                .search-card-wrapper {
                    margin-top: -100px;
                    margin-bottom: 20px;
                }

                .search-form {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                }

                .search-form .form-group:last-child {
                    display: flex;
                    gap: 0.75rem;
                    align-items: center;
                }

                .btn-search-modern {
                    width: 50px;
                    height: 50px;
                    min-width: auto;
                    padding: 1.7rem 2rem;
                    margin-top: 0;
                    border-radius: 8px;
                    grid-column: auto;
                    justify-self: auto;
                    flex-shrink: 0;
                    order: 2;
                }

                .search-form .form-group:last-child .form-control-floating {
                    flex: 1;
                }

                .btn-search-modern span {
                    display: none;
                }

                .btn-search-modern i {
                    font-size: 1.1rem;
                }

                .route-swap {
                    display: none;
                }

                .search-card {
                    padding: 1rem;
                }

                .trust-indicators {
                    gap: 1rem;
                }

                .trust-item {
                    font-size: 0.8rem;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush
@endonce

<div class="search-card-wrapper">
    <div class="container">
        <div class="search-card" id="searchCard">
            <div class="search-header">
                <div class="search-icon">
                    <i class="fas fa-train"></i>
                </div>
                <div>
                    <h2 class="search-title">{{ $searchTitle }}</h2>
                    <p class="search-subtitle">{{ $searchSubtitle }}</p>
                </div>
            </div>

            <form id="searchForm">
                <div class="search-form">
                    <div class="form-group">
                        <select class="form-control-floating" id="departure" required>
                            <option value="" disabled selected></option>
                            <option value="vientiane">{{ __('Vientiane') }}</option>
                            <option value="vangvieng">{{ __('Vang Vieng') }}</option>
                            <option value="luangprabang">{{ __('Luang Prabang') }}</option>
                            <option value="savannakhet">{{ __('Savannakhet') }}</option>
                            <option value="pakse">{{ __('Pakse') }}</option>
                        </select>
                        <label class="form-label-floating">{{ __('From') }}</label>
                    </div>

                    <button type="button" class="route-swap" onclick="swapStations()">
                        <i class="fas fa-exchange-alt"></i>
                    </button>

                    <div class="form-group">
                        <select class="form-control-floating" id="destination" required>
                            <option value="" disabled selected></option>
                            <option value="vientiane">{{ __('Vientiane') }}</option>
                            <option value="vangvieng">{{ __('Vang Vieng') }}</option>
                            <option value="luangprabang">{{ __('Luang Prabang') }}</option>
                            <option value="savannakhet">{{ __('Savannakhet') }}</option>
                            <option value="pakse">{{ __('Pakse') }}</option>
                        </select>
                        <label class="form-label-floating">{{ __('To') }}</label>
                    </div>

                    <div class="form-group">
                        <input type="text" class="form-control-floating" id="travel-date" placeholder=" " required
                            readonly>
                        <label class="form-label-floating">{{ __('Departure Date') }}</label>
                    </div>
                </div>

                <button type="submit" class="btn-search-modern">
                    <i class="fas fa-search"></i>
                    <span>{{ __('Search Trains') }}</span>
                </button>

                <div class="trust-indicators">
                    <div class="trust-item">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ __('Instant confirmation') }}</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ __('Secure booking') }}</span>
                    </div>
                    <div class="trust-item">
                        <i class="fas fa-headset"></i>
                        <span>{{ __('24/7 support') }}</span>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Flatpickr for date selection
                const locale = '{{ app()->getLocale() }}';

                const flatpickrConfig = {
                    minDate: "today",
                    defaultDate: new Date(Date.now() + 24 * 60 * 60 * 1000),
                    dateFormat: "Y-m-d",
                    allowInput: false,
                    clickOpens: true,
                    disableMobile: true,
                };

                flatpickr("#travel-date", flatpickrConfig);

                // Handle floating labels for select elements
                const selectElements = document.querySelectorAll('.form-control-floating');
                selectElements.forEach(select => {
                    if (select.value && select.value !== '') {
                        select.classList.add('has-value');
                    }

                    select.addEventListener('change', function() {
                        if (this.value && this.value !== '') {
                            this.classList.add('has-value');
                        } else {
                            this.classList.remove('has-value');
                        }
                    });
                });

                // Swap stations function
                window.swapStations = function() {
                    const departure = document.getElementById('departure');
                    const destination = document.getElementById('destination');

                    if (departure && destination) {
                        const temp = departure.value;
                        departure.value = destination.value;
                        destination.value = temp;

                        departure.dispatchEvent(new Event('change'));
                        destination.dispatchEvent(new Event('change'));
                    }
                };

                // Form submission handler
                const searchForm = document.getElementById('searchForm');
                if (searchForm) {
                    searchForm.addEventListener('submit', function(event) {
                        event.preventDefault();

                        const departure = document.getElementById('departure').value;
                        const destination = document.getElementById('destination').value;
                        const travelDate = document.getElementById('travel-date').value;

                        if (!departure || !destination || !travelDate) {
                            alert('{{ __('Please fill in all fields') }}');
                            return;
                        }

                        if (departure === destination) {
                            alert('{{ __('Please select different departure and destination stations') }}');
                            return;
                        }

                        // Redirect to ticket list instead of search results
                        window.location.href =
                            `/tickets?from=${departure}&to=${destination}&date=${travelDate}`;
                    });
                }
            });

            function handleResponsiveLayout() {
                const isMobile = window.innerWidth <= 768;
                const searchButton = document.querySelector('.btn-search-modern');
                const lastFormGroup = document.querySelector('.search-form .form-group:last-child');
                const searchForm = document.querySelector('.search-form');

                if (isMobile && searchButton && lastFormGroup) {
                    lastFormGroup.appendChild(searchButton);
                } else if (!isMobile && searchButton && searchForm) {
                    searchForm.appendChild(searchButton);
                }
            }

            window.addEventListener('load', handleResponsiveLayout);
            window.addEventListener('resize', handleResponsiveLayout);
        </script>
    @endpush
@endonce
