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

                    <form action="{{ route('admin.trains.store') }}" method="POST">
                        @csrf
                        <div class="row">
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
                                        value="{{ old('total_seats') }}" placeholder="VD: 300" min="1">
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
@endsection
