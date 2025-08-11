@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo tàu mới</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.trains.store') }}" method="POST" id="trainForm">
                        @csrf
                        <div class="row">
                            <!-- Basic Train Info -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="train_number" class="form-label">Số hiệu tàu <span class="text-danger">*</span></label>
                                    <input type="text" name="train_number" id="train_number" class="form-control @error('train_number') is-invalid @enderror"
                                        value="{{ old('train_number') }}" placeholder="VD: LT001, EXP-VTE-BKK" required>
                                    @error('train_number')
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
                                            <option value="{{ $route->id }}" {{ old('route_id') == $route->id ? 'selected' : '' }}>
                                                {{ $route->name }} ({{ $route->departureStation->name }} - {{ $route->arrivalStation->name }})
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
                                    <label for="train_type" class="form-label">Loại tàu <span class="text-danger">*</span></label>
                                    <input type="text" name="train_type" id="train_type" class="form-control @error('train_type') is-invalid @enderror"
                                        value="{{ old('train_type') }}" placeholder="VD: Tốc hành, Thường, Cao tốc" required>
                                    @error('train_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="operator" class="form-label">Nhà vận hành <span class="text-danger">*</span></label>
                                    <input type="text" name="operator" id="operator" class="form-control @error('operator') is-invalid @enderror"
                                        value="{{ old('operator') }}" placeholder="VD: Lao Railway, Thai SRT" required>
                                    @error('operator')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="total_seats" class="form-label">Tổng số ghế</label>
                                    <input type="number" name="total_seats" id="total_seats" class="form-control @error('total_seats') is-invalid @enderror"
                                        value="{{ old('total_seats') }}" placeholder="Để trống để tự động tính" min="1" readonly>
                                    <small class="text-muted">Sẽ được tính tự động từ tổng ghế các hạng</small>
                                    @error('total_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>

                            <!-- Seat Classes Configuration -->
                            <div class="col-md-12">
                                <hr class="horizontal dark">
                                <h6 class="mb-3">Cấu hình hạng ghế <span class="text-danger">*</span></h6>

                                <div id="seatClassesContainer">
                                    @if(old('seat_classes'))
                                        @foreach(old('seat_classes') as $index => $seatClass)
                                            <div class="seat-class-row mb-3" data-index="{{ $index }}">
                                                <div class="card border">
                                                    <div class="card-body p-3">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <label class="form-label">Hạng ghế</label>
                                                                <select name="seat_classes[{{ $index }}][seat_class_id]" class="form-control seat-class-select" required>
                                                                    <option value="">-- Chọn hạng ghế --</option>
                                                                    @foreach($seatClasses as $class)
                                                                        <option value="{{ $class->id }}" {{ $seatClass['seat_class_id'] == $class->id ? 'selected' : '' }}>
                                                                            {{ $class->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Tổng ghế</label>
                                                                <input type="number" name="seat_classes[{{ $index }}][total_seats]" class="form-control total-seats-input" value="{{ $seatClass['total_seats'] }}" min="1" required>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label class="form-label">Ghế có sẵn</label>
                                                                <input type="number" name="seat_classes[{{ $index }}][available_seats]" class="form-control available-seats-input" value="{{ $seatClass['available_seats'] }}" min="0" required>
                                                            </div>
                                                            <div class="col-md-2 d-flex align-items-end">
                                                                <button type="button" class="btn btn-outline-danger btn-sm remove-seat-class">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="seat-class-row mb-3" data-index="0">
                                            <div class="card border">
                                                <div class="card-body p-3">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label class="form-label">Hạng ghế</label>
                                                            <select name="seat_classes[0][seat_class_id]" class="form-control seat-class-select" required>
                                                                <option value="">-- Chọn hạng ghế --</option>
                                                                @foreach($seatClasses as $class)
                                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Tổng ghế</label>
                                                            <input type="number" name="seat_classes[0][total_seats]" class="form-control total-seats-input" min="1" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Ghế có sẵn</label>
                                                            <input type="number" name="seat_classes[0][available_seats]" class="form-control available-seats-input" min="0" required>
                                                        </div>
                                                        <div class="col-md-2 d-flex align-items-end">
                                                            <button type="button" class="btn btn-outline-danger btn-sm remove-seat-class">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" id="addSeatClass" class="btn btn-outline-primary btn-sm">
                                    <i class="fa fa-plus"></i> Thêm hạng ghế
                                </button>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Lưu</button>
                                <a href="{{ route('admin.trains.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let seatClassIndex = {{ old('seat_classes') ? count(old('seat_classes')) : 1 }};

        // Add new seat class row
        document.getElementById('addSeatClass').addEventListener('click', function() {
            const container = document.getElementById('seatClassesContainer');
            const newRow = createSeatClassRow(seatClassIndex);
            container.appendChild(newRow);
            seatClassIndex++;
            updateTotalSeats();
        });

        // Remove seat class row
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-seat-class')) {
                const row = e.target.closest('.seat-class-row');
                if (document.querySelectorAll('.seat-class-row').length > 1) {
                    row.remove();
                    updateTotalSeats();
                } else {
                    alert('Phải có ít nhất một hạng ghế!');
                }
            }
        });

        // Auto-sync available seats with total seats
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('total-seats-input')) {
                const row = e.target.closest('.seat-class-row');
                const availableInput = row.querySelector('.available-seats-input');
                const totalSeats = parseInt(e.target.value) || 0;

                if (!availableInput.value || parseInt(availableInput.value) > totalSeats) {
                    availableInput.value = totalSeats;
                }
                availableInput.max = totalSeats;
                updateTotalSeats();
            }

            if (e.target.classList.contains('available-seats-input')) {
                const row = e.target.closest('.seat-class-row');
                const totalInput = row.querySelector('.total-seats-input');
                const totalSeats = parseInt(totalInput.value) || 0;
                const availableSeats = parseInt(e.target.value) || 0;

                if (availableSeats > totalSeats) {
                    e.target.value = totalSeats;
                    alert('Số ghế có sẵn không được lớn hơn tổng số ghế!');
                }
            }
        });

        // Check for duplicate seat classes
        document.addEventListener('change', function(e) {
            if (e.target.classList.contains('seat-class-select')) {
                const allSelects = document.querySelectorAll('.seat-class-select');
                const values = Array.from(allSelects).map(s => s.value).filter(v => v);
                const duplicates = values.filter((v, i) => values.indexOf(v) !== i);

                if (duplicates.length > 0) {
                    e.target.value = '';
                    alert('Hạng ghế này đã được chọn!');
                }
            }
        });

        function createSeatClassRow(index) {
            const div = document.createElement('div');
            div.className = 'seat-class-row mb-3';
            div.setAttribute('data-index', index);
            div.innerHTML = `
                <div class="card border">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="form-label">Hạng ghế</label>
                                <select name="seat_classes[${index}][seat_class_id]" class="form-control seat-class-select" required>
                                    <option value="">-- Chọn hạng ghế --</option>
                                    @foreach($seatClasses as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Tổng ghế</label>
                                <input type="number" name="seat_classes[${index}][total_seats]" class="form-control total-seats-input" min="1" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Ghế có sẵn</label>
                                <input type="number" name="seat_classes[${index}][available_seats]" class="form-control available-seats-input" min="0" required>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-seat-class">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            return div;
        }

        function updateTotalSeats() {
            const totalInputs = document.querySelectorAll('.total-seats-input');
            const total = Array.from(totalInputs).reduce((sum, input) => {
                return sum + (parseInt(input.value) || 0);
            }, 0);
            document.getElementById('total_seats').value = total;
        }

        // Initial calculation
        updateTotalSeats();
    </script>
@endsection
