@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo ga tàu mới</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.stations.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="code" class="form-label">Mã ga <span class="text-danger">*</span></label>
                                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code') }}" placeholder="VD: VTE-MAIN, BOT-CENTRAL" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="name" class="form-label">Tên ga <span class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}" placeholder="VD: Vientiane Railway Station" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="administrative_unit_id" class="form-label">Đơn vị hành chính <span class="text-danger">*</span></label>
                                    <select name="administrative_unit_id" id="administrative_unit_id" class="form-control @error('administrative_unit_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn đơn vị hành chính --</option>
                                        @foreach($administrativeUnits as $unit)
                                            <option value="{{ $unit->id }}" {{ old('administrative_unit_id') == $unit->id ? 'selected' : '' }}>
                                                {{ $unit->name }} - {{ $unit->country->name }}
                                                @if($unit->parent)
                                                    ({{ $unit->parent->name }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('administrative_unit_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="address" class="form-label">Địa chỉ</label>
                                    <textarea name="address" id="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Nhập địa chỉ chi tiết của ga tàu">{{ old('address') }}</textarea>
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="latitude" class="form-label">Vĩ độ</label>
                                    <input type="number" step="0.000001" name="latitude" id="latitude" class="form-control @error('latitude') is-invalid @enderror"
                                        value="{{ old('latitude') }}" placeholder="VD: 17.9757">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="longitude" class="form-label">Kinh độ</label>
                                    <input type="number" step="0.000001" name="longitude" id="longitude" class="form-control @error('longitude') is-invalid @enderror"
                                        value="{{ old('longitude') }}" placeholder="VD: 102.6331">
                                    @error('longitude')
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
                                <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
