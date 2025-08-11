@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Chỉnh sửa lịch trình</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" id="scheduleForm">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="train_id" class="form-label">Tàu <span class="text-danger">*</span></label>
                                    <select name="train_id" id="train_id" class="form-control @error('train_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn tàu --</option>
                                        @foreach($trains as $train)
                                            <option value="{{ $train->id }}" {{ old('train_id', $schedule->train_id) == $train->id ? 'selected' : '' }}>
                                                {{ $train->train_number }} - {{ $train->operator }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('train_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="route_id" class="form-label">Tuyến đường <span class="text-danger">*</span></label>
                                    <select name="route_id" id="route_id" class="form-control @error('route_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn tuyến đường --</option>
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id }}" {{ old('route_id', $schedule->route_id) == $route->id ? 'selected' : '' }}>
                                                {{ $route->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('route_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="departure_date" class="form-label">Ngày khởi hành <span class="text-danger">*</span></label>
                                    <input type="date" name="departure_date" id="departure_date" class="form-control @error('departure_date') is-invalid @enderror"
                                        value="{{ old('departure_date', $schedule->departure_date) }}" required>
                                    @error('departure_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="departure_time" class="form-label">Giờ khởi hành <span class="text-danger">*</span></label>
                                    <input type="time" name="departure_time" id="departure_time" class="form-control @error('departure_time') is-invalid @enderror"
                                        value="{{ old('departure_time', $schedule->departure_time) }}" required>
                                    @error('departure_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="arrival_date" class="form-label">Ngày đến <span class="text-danger">*</span></label>
                                    <input type="date" name="arrival_date" id="arrival_date" class="form-control @error('arrival_date') is-invalid @enderror"
                                        value="{{ old('arrival_date', $schedule->arrival_date) }}" required>
                                    @error('arrival_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="arrival_time" class="form-label">Giờ đến <span class="text-danger">*</span></label>
                                    <input type="time" name="arrival_time" id="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror"
                                        value="{{ old('arrival_time', $schedule->arrival_time) }}" required>
                                    @error('arrival_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $schedule->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>

                            <!-- Seat Class Prices Section -->
                            <div class="col-md-12 mb-4">
                                <div id="seat-classes-section">
                                    <hr>
                                    <h6 class="mb-3">Giá vé theo hạng ghế <span class="text-danger">*</span></h6>
                                    <div id="seat-classes-container" class="row">
                                        <!-- Dynamic seat classes will be loaded here -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Cập nhật</button>
                                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const departureDate = document.getElementById('departure_date');
    const arrivalDate = document.getElementById('arrival_date');
    const trainSelect = document.getElementById('train_id');
    const seatClassesSection = document.getElementById('seat-classes-section');
    const seatClassesContainer = document.getElementById('seat-classes-container');

    // Existing prices from server
    const existingPrices = @json($existingPrices ?? []);
    console.log('Existing prices:', existingPrices);

    // Auto set arrival date when departure date changes
    departureDate.addEventListener('change', function() {
        arrivalDate.min = this.value;
        if (arrivalDate.value && arrivalDate.value < this.value) {
            arrivalDate.value = this.value;
        }
    });

    // Validate arrival date
    arrivalDate.addEventListener('change', function() {
        if (departureDate.value && this.value < departureDate.value) {
            alert('Ngày đến không thể trước ngày khởi hành');
            this.value = departureDate.value;
        }
    });

    // Load seat classes when train is selected
    function loadSeatClasses(trainId) {
        if (!trainId) {
            seatClassesContainer.innerHTML = '';
            return;
        }

        console.log('Loading seat classes for train ID:', trainId);

        // Show loading
        seatClassesContainer.innerHTML = '<div class="col-12 text-center"><i class="fa fa-spinner fa-spin"></i> Đang tải...</div>';

        // Make AJAX request to get seat classes
        const url = `{{ route('admin.schedules.get-train-seat-classes') }}?train_id=${trainId}`;
        console.log('Request URL:', url);

        fetch(url, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const contentType = response.headers.get("content-type");
            if (!contentType || !contentType.includes("application/json")) {
                throw new TypeError("Oops, we haven't got JSON!");
            }

            return response.json();
        })
        .then(data => {
            console.log('Response data:', data);

            if (data.error) {
                alert('Lỗi: ' + data.error);
                seatClassesContainer.innerHTML = '<div class="col-12 text-center text-danger">Có lỗi xảy ra</div>';
                return;
            }

            if (!Array.isArray(data) || data.length === 0) {
                seatClassesContainer.innerHTML = '<div class="col-12 text-center text-muted">Không có hạng ghế nào</div>';
                return;
            }

            // Build seat classes form
            let html = '';
            data.forEach(seatClass => {
                const oldPrices = {!! json_encode(old('prices', [])) !!};
                const oldPrice = oldPrices[seatClass.id] || '';
                const existingPrice = existingPrices[seatClass.id] || '';
                const currentPrice = oldPrice || existingPrice || '';

                html += `
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="price_${seatClass.id}" class="form-label">
                                ${seatClass.seat_class_name}
                                <small class="text-muted">(${seatClass.available_seats}/${seatClass.total_seats} ghế)</small>
                                <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <input type="number"
                                       name="prices[${seatClass.id}]"
                                       id="price_${seatClass.id}"
                                       class="form-control"
                                       placeholder="Nhập giá (USD)"
                                       min="0"
                                       step="0.01"
                                       value="${currentPrice}"
                                       required>
                                <span class="input-group-text">$</span>
                            </div>
                        </div>
                    </div>
                `;
            });

            seatClassesContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Fetch error:', error);
            seatClassesContainer.innerHTML = '<div class="col-12 text-center text-danger">Có lỗi xảy ra khi tải thông tin hạng ghế</div>';
            alert('Có lỗi xảy ra khi tải thông tin hạng ghế: ' + error.message);
        });
    }

    trainSelect.addEventListener('change', function() {
        console.log('Train selected:', this.value);
        loadSeatClasses(this.value);
    });

    // Set initial min date
    if (departureDate.value) {
        arrivalDate.min = departureDate.value;
    }

    // Load seat classes on page load
    if (trainSelect.value) {
        console.log('Loading initial seat classes for train:', trainSelect.value);
        loadSeatClasses(trainSelect.value);
    }
});
</script>
@endpush
