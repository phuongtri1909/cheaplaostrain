@props(['searchTitle', 'searchSubtitle', 'stations' => collect()])

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

            <form action="{{ route('tickets.list') }}" method="GET" id="searchForm">
                <div class="search-form">
                    <div class="form-group">
                        <select class="form-control-floating" name="departure" id="departure" required>
                            @foreach ($stations as $station)
                                <option value="{{ $station->code }}"
                                    {{ request('departure') == $station->code ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form-label-floating">{{ __('From') }}</label>
                    </div>

                    <button type="button" class="route-swap" onclick="swapStations()">
                        <i class="fas fa-exchange-alt"></i>
                    </button>

                    <div class="form-group">
                        <select class="form-control-floating" name="arrival" id="destination" required>
                            @foreach ($stations as $station)
                                <option value="{{ $station->code }}"
                                    {{ request('arrival') == $station->code ? 'selected' : '' }}>
                                    {{ $station->name }}
                                </option>
                            @endforeach
                        </select>
                        <label class="form-label-floating">{{ __('To') }}</label>
                    </div>

                    <div class="form-group">
                        @php
                            // ✅ Tính default date theo timezone Lào
                            $laosToday = \Carbon\Carbon::now('Asia/Vientiane');
                            $defaultTravelDate = $laosToday->copy()->addDays(2)->format('Y-m-d');
                            $travelDateValue = request('travel_date', $defaultTravelDate);
                        @endphp

                        <input type="text" class="form-control-floating" name="travel_date" id="travel-date"
                            placeholder=" " required readonly
                            value="{{ $travelDateValue }}"
                            data-laos-timezone="Asia/Vientiane"
                            data-laos-today="{{ $laosToday->format('Y-m-d') }}"
                            data-laos-default="{{ $defaultTravelDate }}">
                        <label class="form-label-floating">{{ __('Departure Date') }} ({{ __('Laos Time') }})</label>

                        {{-- Debug info (có thể xóa sau) --}}
                        <small style="font-size: 10px; color: #999; position: absolute; bottom: -15px; left: 0;">
                            Laos Today: {{ $laosToday->format('Y-m-d H:i') }} | Default: {{ $defaultTravelDate }}
                        </small>
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    @endpush

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const travelDateInput = document.getElementById('travel-date');
                const currentTravelDate = travelDateInput.value;

                const laosTimezone = travelDateInput.getAttribute('data-laos-timezone');
                const laosToday = travelDateInput.getAttribute('data-laos-today');
                const laosDefault = travelDateInput.getAttribute('data-laos-default');

                let defaultDate;
                if (currentTravelDate && currentTravelDate !== '') {
                    defaultDate = new Date(currentTravelDate);
                } else {
                    defaultDate = new Date(laosDefault);
                }

                const flatpickrInstance = flatpickr("#travel-date", {
                    defaultDate: defaultDate,
                    dateFormat: "Y-m-d",
                    allowInput: false,
                    clickOpens: true,
                    disableMobile: true,

                    disable: [
                        function(date) {
                            const dateStr = date.getFullYear() + '-' +
                                          String(date.getMonth() + 1).padStart(2, '0') + '-' +
                                          String(date.getDate()).padStart(2, '0');

                            return dateStr < laosToday;
                        }
                    ],

                    locale: {
                        firstDayOfWeek: 1,
                        weekdays: {
                            shorthand: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                            longhand: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
                        },
                        months: {
                            shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            longhand: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
                        }
                    },

                    onReady: function(selectedDates, dateStr, instance) {
                        if (currentTravelDate && currentTravelDate !== '') {
                            instance.setDate(currentTravelDate, false);
                        }
                    },

                    onChange: function(selectedDates, dateStr, instance) {
                        
                    }
                });

                if (currentTravelDate && currentTravelDate !== '') {
                    travelDateInput.value = currentTravelDate;
                    travelDateInput.classList.add('has-value');
                }

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

                const inputElements = document.querySelectorAll('input.form-control-floating');
                inputElements.forEach(input => {
                    if (input.value && input.value !== '') {
                        input.classList.add('has-value');
                    }

                    input.addEventListener('input', function() {
                        if (this.value && this.value !== '') {
                            this.classList.add('has-value');
                        } else {
                            this.classList.remove('has-value');
                        }
                    });
                });

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
@endonce
