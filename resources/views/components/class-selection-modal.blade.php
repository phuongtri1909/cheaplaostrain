<div class="class-modal" id="classModal">
    <div class="class-modal-content">
        <!-- Mini Train Card Header -->
        <div class="class-modal-header">
            <button class="close-modal" onclick="closeClassModal()">
                <i class="fas fa-times"></i>
            </button>

            <div class="modal-route-summary">
                <div class="modal-station" id="modalDeparture">{{ $searchParams['departure'] ?? 'Vientiane' }}</div>
                <i class="fas fa-arrow-right modal-arrow"></i>
                <div class="modal-station" id="modalArrival">{{ $searchParams['arrival'] ?? 'Vang Vieng' }}</div>
            </div>

            <div class="modal-journey-info">
                <span id="modalDate">{{ date('D, M d', strtotime($searchParams['date'] ?? 'tomorrow')) }}</span>
                <span id="modalDuration">3h 30m</span>
                <span id="modalTimes">08:00 - 11:30</span>
            </div>
        </div>

        <!-- Horizontal Class Selection Body -->
        <div class="class-modal-body">
            <div class="class-selection-horizontal">
                <!-- Second Class Row -->
                <div class="class-row" data-class="2nd" onclick="selectClass('2nd')">
                    <div class="class-description">
                        <div class="class-header">

                            <div>
                                <h4 class="class-title">{{ __('Second Class') }}</h4>
                                <p class="class-subtitle">{{ __('Comfortable standard seating') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="seat-image-container">
                        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?w=300&h=180&fit=crop&crop=center"
                            alt="Second Class Seats" class="seat-image">
                    </div>

                    <div class="price-section">
                        <div class="price-amount">
                            <span id="price2nd">25$</span>
                        </div>
                    </div>

                    <button class="book-class-btn" onclick="event.stopPropagation(); confirmBooking('2nd')">

                        {{ __('Book') }}
                    </button>
                </div>

                <!-- First Class Row -->
                <div class="class-row" data-class="1st" onclick="selectClass('1st')">
                    <div class="class-description">
                        <div class="class-header">

                            <div>
                                <h4 class="class-title">{{ __('First Class') }}</h4>
                                <p class="class-subtitle">{{ __('Premium luxury experience') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="seat-image-container">
                        <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=300&h=180&fit=crop&crop=center"
                            alt="First Class Seats" class="seat-image">
                    </div>

                    <div class="price-section">
                        <div class="price-amount">
                            <span id="price1st">45$</span>
                        </div>
                    </div>

                    <button class="book-class-btn" onclick="event.stopPropagation(); confirmBooking('1st')">

                        {{ __('Book') }}
                    </button>
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

            .modal-train-details h3 {
                font-size: 1.5rem;
                font-weight: 800;
                margin: 0 0 0.25rem 0;
            }

            .modal-train-type {
                opacity: 0.9;
                font-weight: 500;
                font-size: 0.9rem;
            }

            .modal-amenities {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }

            .modal-amenity-badge {
                background: rgba(255, 255, 255, 0.25);
                backdrop-filter: var(--backdrop-blur);
                border-radius: var(--radius-xl);
                padding: 0.4rem 0.8rem;
                font-size: 0.8rem;
                font-weight: 600;
                border: 1px solid rgba(255, 255, 255, 0.2);
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

            .feature-tag {
                background: var(--gradient-green-soft);
                color: var(--primary-green);
                padding: 0.25rem 0.75rem;
                border-radius: var(--radius-lg);
                font-size: 0.85rem;
                font-weight: 600;
                border: 1px solid var(--accent-green);
            }

            /* Seat Image */
            .seat-image-container {
                text-align: center;
                position: relative;
            }

            .seat-image {
                width: 100%;
                height: 90px;
                object-fit: cover;
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

            .price-note {
                font-size: 0.8rem;
                color: var(--text-medium);
                font-style: italic;
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

            .book-class-btn:hover::before {
                left: 100%;
            }

            .book-class-btn:hover {
                transform: var(--button-hover-transform);
                box-shadow: var(--shadow-strong);
            }

            @keyframes modalArrowPulse {

                0%,
                100% {
                    transform: translateX(0) scale(1);
                }

                50% {
                    transform: translateX(4px) scale(1.1);
                }
            }

            @keyframes headerShimmer {

                0%,
                100% {
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
            function selectClass(classType) {
                // Remove previous selections
                document.querySelectorAll('.class-row.selected').forEach(row => {
                    row.classList.remove('selected');
                });

                // Mark current selection
                const selectedRow = document.querySelector(`[data-class="${classType}"]`);
                if (selectedRow) {
                    selectedRow.classList.add('selected');
                }
            }

            function confirmBooking(classType) {
                if (!window.currentTrainData) return;

                const price = classType === '1st' ? window.currentTrainData.price_1st : window.currentTrainData.price_2nd;
                const className = classType === '1st' ? '{{ __('First Class') }}' : '{{ __('Second Class') }}';

                const confirmed = confirm(`{{ __('Confirm your booking?') }}

{{ __('Train') }}: ${window.currentTrainData.train_number}
{{ __('Class') }}: ${className}
{{ __('Price') }}: ${price.toLocaleString()} LAK

{{ __('Click OK to proceed to payment') }}`);

                if (confirmed) {
                    alert('{{ __('Redirecting to payment...') }}');
                    closeClassModal();

                    const bookingData = {
                        train: window.currentTrain,
                        train_number: window.currentTrainData.train_number,
                        class: classType,
                        price: price,
                        departure: @json($searchParams['departure'] ?? 'Vientiane'),
                        arrival: @json($searchParams['arrival'] ?? 'Vang Vieng'),
                        date: @json($searchParams['date'] ?? 'tomorrow')
                    };

                    console.log('Booking data:', bookingData);
                    // window.location.href = '/payment?booking=' + btoa(JSON.stringify(bookingData));
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
                }
            }

            function updateClassModal() {
                if (!window.currentTrainData) return;

                // Update header info
                const modalTrainNumber = document.getElementById('modalTrainNumber');
                const modalTrainType = document.getElementById('modalTrainType');

                if (modalTrainNumber) {
                    modalTrainNumber.textContent = `{{ __('Train') }} ${window.currentTrainData.train_number}`;
                }
                if (modalTrainType) {
                    modalTrainType.textContent = window.currentTrainData.train_type;
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
