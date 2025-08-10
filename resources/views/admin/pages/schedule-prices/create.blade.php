@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo giá lịch trình mới</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.schedule-prices.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="schedule_id" class="form-label">Lịch trình <span class="text-danger">*</span></label>
                                    <select name="schedule_id" id="schedule_id" class="form-control @error('schedule_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn lịch trình --</option>
                                        @foreach($schedules as $schedule)
                                            <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                                {{ $schedule->train->train_number ?? 'N/A' }} - {{ $schedule->departure_time }} → {{ $schedule->arrival_time }}
                                                ({{ $schedule->route->name ?? 'N/A' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('schedule_id')
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
                                            <option value="{{ $seatClass->id }}" {{ old('seat_class_id') == $seatClass->id ? 'selected' : '' }}>
                                                {{ $seatClass->name }}
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
                                    <label for="price" class="form-label">Giá <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}" placeholder="0.00" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="currency" class="form-label">Tiền tệ</label>
                                    <input type="text" name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror"
                                        value="{{ old('currency', 'LAK') }}" placeholder="LAK">
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="effective_from" class="form-label">Có hiệu lực từ</label>
                                    <input type="date" name="effective_from" id="effective_from" class="form-control @error('effective_from') is-invalid @enderror"
                                        value="{{ old('effective_from') }}">
                                    @error('effective_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="effective_until" class="form-label">Có hiệu lực đến</label>
                                    <input type="date" name="effective_until" id="effective_until" class="form-control @error('effective_until') is-invalid @enderror"
                                        value="{{ old('effective_until') }}">
                                    <small class="text-muted">Để trống nếu không có ngày kết thúc</small>
                                    @error('effective_until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Lưu</button>
                                <a href="{{ route('admin.schedule-prices.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
