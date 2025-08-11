@props(['train', 'index', 'searchParams'])

@if (isset($train))
    <div class="train-card-modern" style="--delay: {{ $index * 0.1 }}s" data-train-id="{{ $train['id'] }}"
        onclick="openClassModal({{ json_encode($train) }}, {{ json_encode($searchParams) }})">

        <div class="train-schedule">
            <div class="schedule-point">
                <div class="schedule-time">{{ $train['schedule']['departure_time'] }}</div>
                <div class="schedule-city">{{ $train['route']['departure_station'] }}</div>
                <div class="schedule-date">{{ date('Y-m-d', strtotime($train['schedule']['departure_datetime'])) }}</div>
            </div>

            <div class="schedule-connector">
                <div class="duration-text">{{ $train['schedule']['duration'] }}</div>
                <div class="duration-line"></div>
                <small style="color: var(--text-medium); font-weight: 600;">{{ $train['train_number'] }}</small>
                <div class="train-type">{{ $train['train_type'] }}</div>
            </div>

            <div class="schedule-point">
                <div class="schedule-time">{{ $train['schedule']['arrival_time'] }}</div>
                <div class="schedule-city">{{ $train['route']['arrival_station'] }}</div>
                <div class="schedule-date">{{ date('Y-m-d', strtotime($train['schedule']['arrival_datetime'])) }}</div>
            </div>
        </div>
    </div>
@endif

@once


    @push('scripts')
        <script>
            function openClassModal(trainData, searchParams) {
                window.currentTrainData = trainData;
                window.currentSearchParams = searchParams;

                updateModalContent(trainData, searchParams);

                showClassModal();
            }

            function updateModalContent(trainData, searchParams) {
                const modalDeparture = document.getElementById('modalDeparture');
                const modalArrival = document.getElementById('modalArrival');
                const modalDate = document.getElementById('modalDate');
                const modalDuration = document.getElementById('modalDuration');
                const modalTimes = document.getElementById('modalTimes');

                if (modalDeparture) modalDeparture.textContent = trainData.route.departure_station;
                if (modalArrival) modalArrival.textContent = trainData.route.arrival_station;
                if (modalDate) {
                    const date = new Date(searchParams.travel_date);
                    modalDate.textContent = date.toLocaleDateString('en-US', {
                        weekday: 'short',
                        month: 'short',
                        day: 'numeric'
                    });
                }
                if (modalDuration) modalDuration.textContent = trainData.schedule.duration;
                if (modalTimes) modalTimes.textContent =
                    `${trainData.schedule.departure_time} - ${trainData.schedule.arrival_time}`;

                updateSeatClasses(trainData.seat_classes);
            }

            function updateSeatClasses(seatClasses) {

                const classContainer = document.querySelector('.class-selection-horizontal');
                if (!classContainer) return;

                classContainer.innerHTML = '';

                seatClasses.forEach(seatClass => {
                    const classRow = createClassRow(seatClass);
                    classContainer.appendChild(classRow);
                });
            }

            function createClassRow(seatClass) {
                const classRow = document.createElement('div');
                classRow.className = 'class-row';
                classRow.setAttribute('data-class', seatClass.code);
                classRow.onclick = () => selectClass(seatClass.code);

                classRow.innerHTML = `
                    <div class="class-description">
                        <div class="class-header">
                            <div>
                                <h4 class="class-title">${seatClass.name}</h4>
                                <p class="class-subtitle">${seatClass.description}</p>
                            </div>
                        </div>
                        <div class="seat-availability">
                            <span style="color: var(--primary-green); font-weight: 600;">
                                ${seatClass.available_seats} {{ __('seats available') }} / ${seatClass.total_seats} {{ __('total') }}
                            </span>
                        </div>
                    </div>

                    <div class="seat-image-container">
                        <img src="${seatClass.image}" alt="${seatClass.name} Seats" class="seat-image">
                    </div>

                    <div class="price-section">
                        <div class="price-amount">
                            <span>$${seatClass.price}</span>
                        </div>
                        <div class="price-currency">${seatClass.currency}</div>
                    </div>

                    <button class="book-class-btn" onclick="event.stopPropagation(); confirmBooking('${seatClass.code}', ${seatClass.price}, '${seatClass.name}')">
                        {{ __('Book') }}
                    </button>
                `;

                return classRow;
            }
        </script>
    @endpush

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
                position: relative;
            }

            .train-card-modern:hover {
                transform: var(--card-hover-transform);
                box-shadow: var(--shadow-strong);
                border-color: var(--primary-green);
            }


            .train-number {
                font-size: 1.2rem;
                font-weight: 800;
                color: var(--primary-green);
                margin-bottom: 0.25rem;
            }

            .train-type {
                font-size: 0.85rem;
                color: var(--text-medium);
                margin-bottom: 0.25rem;
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
                padding: 1rem;
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

            /* Mobile Responsive */
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

                .train-info-overlay {
                    position: static;
                    margin: 1rem;
                    text-align: center;
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
