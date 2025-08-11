<div class="class-modal" id="classModal">
    <div class="class-modal-content">
        <!-- Mini Train Card Header -->
        <div class="class-modal-header">
            <button class="close-modal" onclick="closeClassModal()">
                <i class="fas fa-times"></i>
            </button>

            <div class="modal-route-summary">
                <div class="modal-station" id="modalDeparture">Loading...</div>
                <i class="fas fa-arrow-right modal-arrow"></i>
                <div class="modal-station" id="modalArrival">Loading...</div>
            </div>

            <div class="modal-journey-info">
                <span id="modalDate">Loading...</span>
                <span id="modalDuration">Loading...</span>
                <span id="modalTimes">Loading...</span>
            </div>
        </div>

        <!-- Horizontal Class Selection Body -->
        <div class="class-modal-body">
            <div class="class-selection-horizontal">
                <!-- Dynamic content will be loaded here -->
                <div class="loading-placeholder">
                    <i class="fas fa-spinner fa-spin"></i>
                    <span>{{ __('Loading seat classes...') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

@once
    @push('styles')
        <style>
            .class-modal {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                z-index: 1000;
                backdrop-filter: var(--backdrop-blur);
                animation: fadeIn 0.3s ease-out;
            }

            .class-modal.show {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .class-modal-content {
                background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
                border-radius: var(--modern-radius);
                max-width: 1100px;
                width: 95%;
                max-height: 90vh;
                overflow-y: auto;
                animation: scaleIn 0.4s ease-out;
                box-shadow: var(--shadow-strong);
                border: 1px solid var(--accent-green);
            }

            /* Loading placeholder */
            .loading-placeholder {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1rem;
                padding: 3rem;
                color: var(--text-medium);
                font-size: 1.1rem;
            }

            .loading-placeholder i {
                font-size: 2rem;
                color: var(--primary-green);
            }

            /* Mini Train Card Header */
            .class-modal-header {
                background: var(--gradient-overlay);
                color: white;
                padding: 0.5rem;
                position: relative;
                overflow: hidden;
            }

            .class-modal-header::after {
                content: '';
                position: absolute;
                top: 0;
                right: 0;
                width: 100px;
                height: 100%;
                background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1));
                transform: translateX(100px);
                animation: headerShimmer 3s ease-in-out infinite;
            }

            .modal-route-summary {
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 1.5rem;
            }

            .modal-station {
                font-weight: 700;
                font-size: 1.1rem;
            }

            .modal-arrow {
                color: rgba(255, 255, 255, 0.8);
                animation: modalArrowPulse 2s ease-in-out infinite;
            }

            .modal-journey-info {
                display: flex;
                justify-content: center;
                gap: 2rem;
                font-size: 0.9rem;
                opacity: 0.9;
            }

            .close-modal {
                position: absolute;
                top: 0.5rem;
                right: 0.5rem;
                background: rgba(255, 255, 255, 0.2);
                border: 1px solid rgba(255, 255, 255, 0.3);
                color: white;
                font-size: 1.2rem;
                cursor: pointer;
                padding: 0.5rem;
                width: 30px;
                height: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: var(--radius-md);
                transition: var(--transition-smooth);
                backdrop-filter: var(--backdrop-blur);
                z-index: 10;
            }

            .close-modal:hover {
                background: rgba(255, 255, 255, 0.3);
                transform: scale(1.1);
            }

            /* Horizontal Class Selection */
            .class-modal-body {
                padding: 2rem;
            }

            .class-selection-horizontal {
                display: flex;
                flex-direction: column;
                gap: 1.5rem;
            }

            .class-row {
                display: grid;
                grid-template-columns: 1fr 300px 120px 160px;
                gap: 2rem;
                align-items: center;
                background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
                border: 1px solid var(--gradient-green-soft);
                border-radius: var(--modern-radius);
                padding: 1rem;
                transition: var(--transition-smooth);
                cursor: pointer;
                position: relative;
                overflow: hidden;
            }

            .class-row::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, var(--gradient-green-soft), transparent);
                transition: left 0.6s ease;
            }

            .class-row:hover::before {
                left: 100%;
            }

            .class-row:hover {
                border-color: var(--primary-green);
                transform: translateY(-4px);
                box-shadow: var(--shadow-medium);
            }

            .class-row.selected {
                border-color: var(--primary-green);
                background: var(--gradient-green-soft);
                transform: translateY(-4px);
                box-shadow: var(--shadow-medium);
            }

            /* Class Description */
            .class-description {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }

            .class-header {
                display: flex;
                align-items: center;
                gap: 1rem;
                margin-bottom: 0.5rem;
            }

            .class-title {
                font-size: 1.4rem;
                font-weight: 800;
                color: var(--primary-green);
                margin: 0;
            }

            .class-subtitle {
                color: var(--text-medium);
                font-size: 0.9rem;
                margin: 0;
            }

            .seat-availability {
                font-size: 0.9rem;
                margin-top: 0.5rem;
            }

            /* Seat Image */
            .seat-image-container {
                text-align: center;
                position: relative;
            }

            .seat-image {
                width: auto;
                height: 100px;
                object-fit: scale-down;
                border-radius: var(--modern-radius);
                border: 3px solid var(--accent-green);
                box-shadow: var(--shadow-soft);
                transition: var(--transition-smooth);
            }

            .seat-image:hover {
                transform: scale(1.05);
                box-shadow: var(--shadow-medium);
            }

            /* Price Section */
            .price-section {
                text-align: center;
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }

            .price-amount {
                font-size: 1.5rem;
                font-weight: 800;
                color: var(--text-dark);
                line-height: 1;
            }

            .price-currency {
                font-size: 1rem;
                color: var(--text-medium);
                font-weight: 600;
            }

            /* Book Button */
            .book-class-btn {
                background: var(--gradient-green);
                border: none;
                color: white;
                padding: 0.75rem 0.75rem;
                border-radius: var(--modern-radius);
                font-weight: 700;
                font-size: 1rem;
                transition: var(--transition-smooth);
                position: relative;
                overflow: hidden;
                box-shadow: var(--shadow-medium);
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 0.5rem;
            }

            .book-class-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.6s ease;
            }

            .book-class-btn:hover::before {
                left: 100%;
            }

            .book-class-btn:hover {
                transform: var(--button-hover-transform);
                box-shadow: var(--shadow-strong);
            }

            .book-class-btn:disabled {
                background: #ccc;
                cursor: not-allowed;
                transform: none;
            }

            @keyframes modalArrowPulse {
                0%, 100% {
                    transform: translateX(0) scale(1);
                }
                50% {
                    transform: translateX(4px) scale(1.1);
                }
            }

            @keyframes headerShimmer {
                0%, 100% {
                    transform: translateX(100px);
                }
                50% {
                    transform: translateX(-100px);
                }
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                }
                to {
                    opacity: 1;
                }
            }

            @keyframes scaleIn {
                from {
                    opacity: 0;
                    transform: scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: scale(1);
                }
            }

            @media (max-width: 768px) {
                .class-modal-content {
                    width: 98%;
                    margin: 1rem;
                }

                .class-row {
                    grid-template-columns: 1fr;
                    gap: 1.5rem;
                    text-align: center;
                }

                .modal-route-summary {
                    gap: 0.5rem;
                }

                .modal-journey-info {
                    gap: 0.5rem;
                }

                .seat-image {
                    height: 150px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Class Selection Modal JavaScript
            function selectClass(classCode) {
                // Remove previous selections
                document.querySelectorAll('.class-row.selected').forEach(row => {
                    row.classList.remove('selected');
                });

                // Mark current selection
                const selectedRow = document.querySelector(`[data-class="${classCode}"]`);
                if (selectedRow) {
                    selectedRow.classList.add('selected');
                }
            }

            function confirmBooking(classCode, price, className) {
                if (!window.currentTrainData || !window.currentSearchParams) {
                    alert('{{ __("Error: Missing booking data") }}');
                    return;
                }

                const trainData = window.currentTrainData;
                const searchParams = window.currentSearchParams;

                const confirmed = confirm(`{{ __('Confirm your booking?') }}

{{ __('Train') }}: ${trainData.train_number}
{{ __('Route') }}: ${trainData.route.departure_station} → ${trainData.route.arrival_station}
{{ __('Date') }}: ${searchParams.travel_date}
{{ __('Time') }}: ${trainData.schedule.departure_time} - ${trainData.schedule.arrival_time}
{{ __('Class') }}: ${className}
{{ __('Price') }}: $${price}

{{ __('Click OK to proceed to payment') }}`);

                if (confirmed) {
                    // Create booking data
                    const bookingData = {
                        train_id: trainData.id,
                        schedule_id: trainData.schedule.id,
                        train_number: trainData.train_number,
                        seat_class_code: classCode,
                        seat_class_name: className,
                        price: price,
                        departure_station: trainData.route.departure_station,
                        arrival_station: trainData.route.arrival_station,
                        departure_time: trainData.schedule.departure_time,
                        arrival_time: trainData.schedule.arrival_time,
                        travel_date: searchParams.travel_date,
                        passengers: searchParams.passengers || 1
                    };

                    console.log('Booking data:', bookingData);

                    // Close modal
                    closeClassModal();

                    // TODO: Redirect to booking/payment page
                    alert('{{ __("Redirecting to booking page...") }}');

                    // Example redirect (implement your booking route)
                    // window.location.href = `/booking?data=${encodeURIComponent(JSON.stringify(bookingData))}`;
                }
            }

            function showClassModal() {
                const modal = document.getElementById('classModal');
                if (modal) {
                    modal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            }

            function closeClassModal() {
                const modal = document.getElementById('classModal');
                if (modal) {
                    modal.classList.remove('show');
                    document.body.style.overflow = '';

                    // Reset selections
                    document.querySelectorAll('.class-row.selected').forEach(row => {
                        row.classList.remove('selected');
                    });

                    // Clear data
                    window.currentTrainData = null;
                    window.currentSearchParams = null;
                }
            }

            // Modal event listeners
            document.addEventListener('DOMContentLoaded', function() {
                // Close modal when clicking outside
                document.addEventListener('click', function(event) {
                    const modal = document.getElementById('classModal');
                    if (modal && event.target === modal) {
                        closeClassModal();
                    }
                });

                // Close modal with Escape key
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape') {
                        closeClassModal();
                    }
                });
            });
        </script>
    @endpush
@endonce
