@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Chỉnh sửa hạng ghế tàu</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.train-seat-classes.update', $trainSeatClass->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="train_id" class="form-label">Tàu <span class="text-danger">*</span></label>
                                    <select name="train_id" id="train_id" class="form-control @error('train_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn tàu --</option>
                                        @foreach($trains as $train)
                                            <option value="{{ $train->id }}" {{ old('train_id', $trainSeatClass->train_id) == $train->id ? 'selected' : '' }}>
                                                {{ $train->train_number }} - {{ $train->operator ?? 'N/A' }}
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
                                    <label for="seat_class_id" class="form-label">Hạng ghế <span class="text-danger">*</span></label>
                                    <select name="seat_class_id" id="seat_class_id" class="form-control @error('seat_class_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn hạng ghế --</option>
                                        @foreach($seatClasses as $seatClass)
                                            <option value="{{ $seatClass->id }}" {{ old('seat_class_id', $trainSeatClass->seat_class_id) == $seatClass->id ? 'selected' : '' }}>
                                                {{ $seatClass->name }}
                                                @if($seatClass->description)
                                                    - {{ $seatClass->description }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seat_class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="total_seats" class="form-label">Tổng số ghế <span class="text-danger">*</span></label>
                                    <input type="number" name="total_seats" id="total_seats" class="form-control @error('total_seats') is-invalid @enderror"
                                        value="{{ old('total_seats', $trainSeatClass->total_seats) }}" placeholder="50" min="1" required>
                                    @error('total_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="available_seats" class="form-label">Số ghế có sẵn <span class="text-danger">*</span></label>
                                    <input type="number" name="available_seats" id="available_seats" class="form-control @error('available_seats') is-invalid @enderror"
                                        value="{{ old('available_seats', $trainSeatClass->available_seats) }}" placeholder="50" min="0" required>
                                    <small class="text-muted">Số ghế có sẵn không được lớn hơn tổng số ghế</small>
                                    @error('available_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $trainSeatClass->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Cập nhật</button>
                                <a href="{{ route('admin.train-seat-classes.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-sync available_seats with total_seats
        document.getElementById('total_seats').addEventListener('input', function() {
            const totalSeats = parseInt(this.value) || 0;
            const availableSeatsInput = document.getElementById('available_seats');
            const currentAvailable = parseInt(availableSeatsInput.value) || 0;

            // If available seats is greater than new total, adjust it
            if (currentAvailable > totalSeats) {
                availableSeatsInput.value = totalSeats;
            }

            availableSeatsInput.max = totalSeats;
        });

        document.getElementById('available_seats').addEventListener('input', function() {
            const totalSeats = parseInt(document.getElementById('total_seats').value) || 0;
            const availableSeats = parseInt(this.value) || 0;

            if (availableSeats > totalSeats) {
                this.value = totalSeats;
                alert('Số ghế có sẵn không được lớn hơn tổng số ghế!');
            }
        });
    </script>
@endsection
