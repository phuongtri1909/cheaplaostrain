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

                    <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST">
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
                                    <label for="arrival_time" class="form-label">Giờ đến <span class="text-danger">*</span></label>
                                    <input type="time" name="arrival_time" id="arrival_time" class="form-control @error('arrival_time') is-invalid @enderror"
                                        value="{{ old('arrival_time', $schedule->arrival_time) }}" required>
                                    @error('arrival_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label class="form-label">Ngày hoạt động</label>
                                    <div class="row">
                                        @php
                                            $daysOfWeek = [
                                                1 => 'Chủ nhật',
                                                2 => 'Thứ hai',
                                                3 => 'Thứ ba',
                                                4 => 'Thứ tư',
                                                5 => 'Thứ năm',
                                                6 => 'Thứ sáu',
                                                7 => 'Thứ bảy'
                                            ];
                                            $currentOperatingDays = old('operating_days', $schedule->operating_days ?? []);
                                        @endphp
                                        @foreach($daysOfWeek as $dayNumber => $dayName)
                                            <div class="col-md-3 mb-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="operating_days[]" value="{{ $dayNumber }}" id="day_{{ $dayNumber }}"
                                                        {{ in_array($dayNumber, $currentOperatingDays) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="day_{{ $dayNumber }}">
                                                        {{ $dayName }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <small class="text-muted">Để trống nếu tàu chạy hàng ngày</small>
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="effective_from" class="form-label">Có hiệu lực từ <span class="text-danger">*</span></label>
                                    <input type="date" name="effective_from" id="effective_from" class="form-control @error('effective_from') is-invalid @enderror"
                                        value="{{ old('effective_from', $schedule->effective_from?->format('Y-m-d')) }}" required>
                                    @error('effective_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="effective_until" class="form-label">Có hiệu lực đến</label>
                                    <input type="date" name="effective_until" id="effective_until" class="form-control @error('effective_until') is-invalid @enderror"
                                        value="{{ old('effective_until', $schedule->effective_until?->format('Y-m-d')) }}">
                                    <small class="text-muted">Để trống nếu không có ngày kết thúc</small>
                                    @error('effective_until')
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
