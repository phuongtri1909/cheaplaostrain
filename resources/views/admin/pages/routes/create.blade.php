@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo tuyến đường mới</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.routes.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="code" class="form-label">Mã tuyến <span class="text-danger">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code') }}" placeholder="VD: VTE-BKK, LNT-HUE" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Tên tuyến <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="VD: Vientiane - Bangkok" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="departure_station_id" class="form-label">Ga khởi hành <span class="text-danger">*</span></label>
                                    <select name="departure_station_id" id="departure_station_id" class="form-control @error('departure_station_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn ga khởi hành --</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('departure_station_id') == $station->id ? 'selected' : '' }}>
                                                {{ $station->name }} - {{ $station->administrativeUnit->country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('departure_station_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="arrival_station_id" class="form-label">Ga đến <span class="text-danger">*</span></label>
                                    <select name="arrival_station_id" id="arrival_station_id" class="form-control @error('arrival_station_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn ga đến --</option>
                                        @foreach($stations as $station)
                                            <option value="{{ $station->id }}" {{ old('arrival_station_id') == $station->id ? 'selected' : '' }}>
                                                {{ $station->name }} - {{ $station->administrativeUnit->country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('arrival_station_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="distance_km" class="form-label">Khoảng cách (km)</label>
                                    <input type="number" step="0.1" name="distance_km" id="distance_km" class="form-control @error('distance_km') is-invalid @enderror"
                                        value="{{ old('distance_km') }}" placeholder="VD: 654.5" min="0">
                                    @error('distance_km')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="estimated_duration_minutes" class="form-label">Thời gian ước tính (phút)</label>
                                    <input type="number" name="estimated_duration_minutes" id="estimated_duration_minutes" class="form-control @error('estimated_duration_minutes') is-invalid @enderror"
                                        value="{{ old('estimated_duration_minutes') }}" placeholder="VD: 720 (12 giờ)" min="0">
                                    @error('estimated_duration_minutes')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Lưu</button>
                                <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
