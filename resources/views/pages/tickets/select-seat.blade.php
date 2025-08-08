@extends('layouts.app')
@section('title', 'Select Seat - Train ' . $ticket['train_number'])
@section('description', 'Select your preferred seat for train ' . $ticket['train_number'] . ' from ' . $ticket['departure'] . ' to ' . $ticket['arrival'])

@push('styles')
<style>
    .seat-selection-page {
        background: var(--soft-green);
        min-height: 100vh;
        padding: 2rem 0;
    }

    .ticket-info-card {
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        border: 2px solid var(--accent-green);
        box-shadow: var(--shadow-soft);
        margin-bottom: 2rem;
        overflow: hidden;
        animation: slideInDown 0.6s ease-out;
    }

    .ticket-header {
        background: var(--gradient-green);
        color: white;
        padding: 1.5rem;
        text-align: center;
    }

    .ticket-details {
        padding: 1.5rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        align-items: center;
    }

    .detail-item {
        text-align: center;
    }

    .detail-label {
        font-size: 0.9rem;
        color: var(--text-medium);
        margin-bottom: 0.25rem;
    }

    .detail-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .route-arrow {
        color: var(--primary-green);
        font-size: 1.5rem;
        animation: pulse 2s infinite;
    }

    .seat-map-container {
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        border: 2px solid var(--accent-green);
        box-shadow: var(--shadow-soft);
        padding: 2rem;
        animation: slideInUp 0.6s ease-out 0.2s both;
    }

    .seat-map-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .seat-map-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
    }

    .legend {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: var(--text-medium);
    }

    .legend-seat {
        width: 20px;
        height: 20px;
        border-radius: var(--radius-sm);
        border: 2px solid;
    }

    .legend-available .legend-seat {
        background: var(--accent-green);
        border-color: var(--primary-green);
    }

    .legend-selected .legend-seat {
        background: var(--primary-green);
        border-color: var(--primary-green);
    }

    .legend-occupied .legend-seat {
        background: #ff6b35;
        border-color: #e55a31;
    }

    .train-car {
        max-width: 600px;
        margin: 0 auto;
        background: #f8f9fa;
        border-radius: var(--radius-lg);
        padding: 2rem;
        border: 3px solid var(--accent-green);
        position: relative;
    }

    .car-header {
        text-align: center;
        margin-bottom: 1.5rem;
        font-weight: 700;
        color: var(--primary-green);
    }

    .seat-rows {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .seat-row {
        display: grid;
        grid-template-columns: 1fr auto 1fr;
        gap: 2rem;
        align-items: center;
    }

    .seat-side {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .seat {
        width: 40px;
        height: 40px;
        border-radius: var(--radius-sm);
        border: 2px solid;
        background: var(--accent-green);
        border-color: var(--primary-green);
        cursor: pointer;
        transition: var(--transition-smooth);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--primary-green);
        position: relative;
        overflow: hidden;
    }

    .seat::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: var(--primary-green);
        border-radius: 50%;
        transition: var(--transition-smooth);
        transform: translate(-50%, -50%);
        opacity: 0.1;
    }

    .seat:hover::before {
        width: 100%;
        height: 100%;
    }

    .seat:hover {
        transform: scale(1.1);
        box-shadow: var(--shadow-soft);
    }

    .seat.selected {
        background: var(--primary-green);
        border-color: var(--primary-green);
        color: white;
        transform: scale(1.1);
        box-shadow: var(--shadow-medium);
    }

    .seat.occupied {
        background: #ff6b35;
        border-color: #e55a31;
        color: white;
        cursor: not-allowed;
    }

    .seat.occupied:hover {
        transform: none;
        box-shadow: none;
    }

    .seat.occupied::before {
        display: none;
    }

    .row-number {
        font-weight: 700;
        color: var(--text-medium);
        font-size: 0.9rem;
        width: 30px;
        text-align: center;
    }

    .aisle {
        width: 2px;
        background: var(--accent-green);
        height: 40px;
        border-radius: 1px;
    }

    .booking-summary {
        background: var(--warm-white);
        border-radius: var(--radius-lg);
        border: 2px solid var(--accent-green);
        box-shadow: var(--shadow-soft);
        padding: 1.5rem;
        margin-top: 2rem;
        animation: slideInUp 0.6s ease-out 0.4s both;
    }

    .summary-header {
        font-size: 1.2rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 1rem;
        text-align: center;
    }

    .selected-seats {
        margin-bottom: 1rem;
    }

    .selected-seat-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem;
        background: var(--accent-green);
        border-radius: var(--radius-sm);
        margin-bottom: 0.5rem;
        color: var(--primary-green);
        font-weight: 600;
    }

    .seat-remove {
        background: none;
        border: none;
        color: #ff6b35;
        cursor: pointer;
        font-size: 1.1rem;
        transition: var(--transition-smooth);
    }

    .seat-remove:hover {
        transform: scale(1.2);
    }

    .total-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background: var(--soft-green);
        border-radius: var(--radius-sm);
        margin-bottom: 1rem;
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
    }

    .price-amount {
        color: var(--primary-green);
        font-size: 1.3rem;
    }

    .booking-actions {
        display: flex;
        gap: 1rem;
        justify-content: center;
    }

    .btn-book {
        background: var(--gradient-green);
        border: none;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-transform: uppercase;
        transition: var(--transition-smooth);
        text-decoration: none;
        display: inline-block;
    }

    .btn-book:hover {
        background: linear-gradient(135deg, var(--primary-green-dark) 0%, var(--primary-green) 100%);
        color: white;
        transform: translateY(-2px);
        box-shadow: var(--shadow-medium);
    }

    .btn-book:disabled {
        background: var(--text-medium);
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .btn-back {
        background: transparent;
        border: 2px solid var(--primary-green);
        color: var(--primary-green);
        padding: 0.75rem 2rem;
        border-radius: var(--radius-md);
        font-weight: 700;
        text-decoration: none;
        transition: var(--transition-smooth);
        display: inline-block;
    }

    .btn-back:hover {
        background: var(--primary-green);
        color: white;
    }

    /* Mobile Responsive */
    @media (max-width: 767.98px) {
        .seat-selection-page {
            padding: 1rem 0;
        }

        .ticket-details {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .seat-map-container {
            padding: 1rem;
        }

        .legend {
            gap: 1rem;
        }

        .train-car {
            padding: 1rem;
        }

        .seat-row {
            gap: 1rem;
        }

        .seat {
            width: 35px;
            height: 35px;
        }

        .booking-actions {
            flex-direction: column;
        }

        .seat-map-title {
            font-size: 1.25rem;
        }
    }

    /* Animations */
    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
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

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
    }

    @keyframes seatSelect {
        0% { transform: scale(1); }
        50% { transform: scale(1.3); }
        100% { transform: scale(1.1); }
    }
</style>
@endpush

@section('content')
<div class="seat-selection-page">
    <div class="container">
        <!-- Ticket Information -->
        <div class="ticket-info-card">
            <div class="ticket-header">
                <h2>{{ __('Select Your Seats') }}</h2>
                <p class="mb-0">{{ __('Train') }} {{ $ticket['train_number'] }} - {{ ucfirst($ticket['class']) }} {{ __('Class') }}</p>
            </div>
            <div class="ticket-details">
                <div class="detail-item">
                    <div class="detail-label">{{ __('From') }}</div>
                    <div class="detail-value">{{ $ticket['departure'] }}</div>
                </div>
                <div class="detail-item">
                    <i class="fas fa-arrow-right route-arrow"></i>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('To') }}</div>
                    <div class="detail-value">{{ $ticket['arrival'] }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('Date') }}</div>
                    <div class="detail-value">{{ date('M d, Y', strtotime($ticket['date'])) }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('Departure') }}</div>
                    <div class="detail-value">{{ $ticket['departure_time'] }}</div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">{{ __('Arrival') }}</div>
                    <div class="detail-value">{{ $ticket['arrival_time'] }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Seat Map -->
                <div class="seat-map-container">
                    <div class="seat-map-header">
                        <h3 class="seat-map-title">{{ __('Choose Your Seats') }}</h3>
                        
                        <!-- Legend -->
                        <div class="legend">
                            <div class="legend-item legend-available">
                                <div class="legend-seat"></div>
                                <span>{{ __('Available') }}</span>
                            </div>
                            <div class="legend-item legend-selected">
                                <div class="legend-seat"></div>
                                <span>{{ __('Selected') }}</span>
                            </div>
                            <div class="legend-item legend-occupied">
                                <div class="legend-seat"></div>
                                <span>{{ __('Occupied') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Train Car -->
                    <div class="train-car">
                        <div class="car-header">
                            {{ __('Car') }} 1 - {{ ucfirst($ticket['class']) }} {{ __('Class') }}
                        </div>
                        
                        <div class="seat-rows" id="seatMap">
                            <!-- Seats will be generated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Booking Summary -->
                <div class="booking-summary">
                    <div class="summary-header">{{ __('Booking Summary') }}</div>
                    
                    <div class="selected-seats" id="selectedSeats">
                        <p class="text-muted text-center">{{ __('No seats selected') }}</p>
                    </div>

                    <div class="total-price">
                        <span>{{ __('Total Price') }}:</span>
                        <span class="price-amount" id="totalPrice">0 LAK</span>
                    </div>

                    <div class="booking-actions">
                        <a href="{{ url()->previous() }}" class="btn-back">{{ __('Back') }}</a>
                        <button type="button" class="btn-book" id="bookBtn" disabled>
                            {{ __('Continue to Payment') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const seatPrice = {{ $ticket['price'] }};
    const seatMap = document.getElementById('seatMap');
    const selectedSeatsContainer = document.getElementById('selectedSeats');
    const totalPriceElement = document.getElementById('totalPrice');
    const bookBtn = document.getElementById('bookBtn');
    
    let selectedSeats = [];
    
    // Mock occupied seats
    const occupiedSeats = ['1A', '1B', '3C', '3D', '5A', '7B', '9C', '9D'];
    
    // Generate seat map (10 rows, 4 seats per row - 2A 2B | aisle | 2C 2D)
    function generateSeatMap() {
        seatMap.innerHTML = '';
        
        for (let row = 1; row <= 10; row++) {
            const seatRow = document.createElement('div');
            seatRow.className = 'seat-row';
            
            // Left side seats (A, B)
            const leftSide = document.createElement('div');
            leftSide.className = 'seat-side';
            
            ['A', 'B'].forEach(letter => {
                const seatId = `${row}${letter}`;
                const seat = createSeat(seatId, occupiedSeats.includes(seatId));
                leftSide.appendChild(seat);
            });
            
            // Row number
            const rowNumber = document.createElement('div');
            rowNumber.className = 'row-number';
            rowNumber.textContent = row;
            
            // Right side seats (C, D)  
            const rightSide = document.createElement('div');
            rightSide.className = 'seat-side';
            
            ['C', 'D'].forEach(letter => {
                const seatId = `${row}${letter}`;
                const seat = createSeat(seatId, occupiedSeats.includes(seatId));
                rightSide.appendChild(seat);
            });
            
            seatRow.appendChild(leftSide);
            seatRow.appendChild(rowNumber);
            seatRow.appendChild(rightSide);
            
            seatMap.appendChild(seatRow);
        }
    }
    
    function createSeat(seatId, isOccupied) {
        const seat = document.createElement('div');
        seat.className = 'seat';
        seat.dataset.seatId = seatId;
        seat.textContent = seatId;
        
        if (isOccupied) {
            seat.classList.add('occupied');
        } else {
            seat.addEventListener('click', () => toggleSeat(seatId, seat));
        }
        
        return seat;
    }
    
    function toggleSeat(seatId, seatElement) {
        if (seatElement.classList.contains('selected')) {
            // Deselect seat
            seatElement.classList.remove('selected');
            selectedSeats = selectedSeats.filter(seat => seat !== seatId);
            seatElement.style.animation = '';
        } else {
            // Select seat (limit to 4 seats)
            if (selectedSeats.length >= 4) {
                alert('{{ __("Maximum 4 seats can be selected") }}');
                return;
            }
            
            seatElement.classList.add('selected');
            selectedSeats.push(seatId);
            seatElement.style.animation = 'seatSelect 0.3s ease-out';
        }
        
        updateSummary();
    }
    
    function updateSummary() {
        const selectedSeatsContainer = document.getElementById('selectedSeats');
        const totalPrice = selectedSeats.length * seatPrice;
        
        if (selectedSeats.length === 0) {
            selectedSeatsContainer.innerHTML = '<p class="text-muted text-center">{{ __("No seats selected") }}</p>';
            bookBtn.disabled = true;
        } else {
            let seatsHtml = '';
            selectedSeats.forEach(seatId => {
                seatsHtml += `
                    <div class="selected-seat-item">
                        <span>{{ __("Seat") }} ${seatId}</span>
                        <button type="button" class="seat-remove" onclick="removeSeat('${seatId}')">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `;
            });
            selectedSeatsContainer.innerHTML = seatsHtml;
            bookBtn.disabled = false;
        }
        
        totalPriceElement.textContent = `${totalPrice.toLocaleString()} LAK`;
    }
    
    window.removeSeat = function(seatId) {
        const seatElement = document.querySelector(`[data-seat-id="${seatId}"]`);
        if (seatElement) {
            seatElement.classList.remove('selected');
            selectedSeats = selectedSeats.filter(seat => seat !== seatId);
            updateSummary();
        }
    };
    
    // Book button action
    bookBtn.addEventListener('click', function() {
        if (selectedSeats.length > 0) {
            // In real application, this would redirect to payment page
            alert(`{{ __("Proceeding to payment for seats") }}: ${selectedSeats.join(', ')}\n{{ __("Total") }}: ${(selectedSeats.length * seatPrice).toLocaleString()} LAK`);
        }
    });
    
    // Initialize seat map
    generateSeatMap();
});
</script>
@endpush