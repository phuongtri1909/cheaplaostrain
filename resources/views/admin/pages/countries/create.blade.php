@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo quốc gia mới</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.countries.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Mã quốc gia <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code') }}" placeholder="VD: LAO, THA, VNM" maxlength="10" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên quốc gia <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name') }}" placeholder="VD: Laos, Thailand" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="local_name" class="form-label">Tên địa phương</label>
                                <input type="text" name="local_name" id="local_name" class="form-control @error('local_name') is-invalid @enderror"
                                    value="{{ old('local_name') }}" placeholder="VD: ລາວ, ไทย">
                                @error('local_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="timezone" class="form-label">Múi giờ</label>
                                <select name="timezone" id="timezone" class="form-control @error('timezone') is-invalid @enderror">
                                    <option value="">Chọn múi giờ</option>
                                    <option value="Asia/Vientiane" {{ old('timezone') == 'Asia/Vientiane' ? 'selected' : '' }}>Asia/Vientiane (UTC+7)</option>
                                    <option value="Asia/Bangkok" {{ old('timezone') == 'Asia/Bangkok' ? 'selected' : '' }}>Asia/Bangkok (UTC+7)</option>
                                    <option value="Asia/Ho_Chi_Minh" {{ old('timezone') == 'Asia/Ho_Chi_Minh' ? 'selected' : '' }}>Asia/Ho_Chi_Minh (UTC+7)</option>
                                    <option value="Asia/Phnom_Penh" {{ old('timezone') == 'Asia/Phnom_Penh' ? 'selected' : '' }}>Asia/Phnom_Penh (UTC+7)</option>
                                </select>
                                @error('timezone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="currency_code" class="form-label">Mã tiền tệ</label>
                                <input type="text" name="currency_code" id="currency_code" class="form-control @error('currency_code') is-invalid @enderror"
                                    value="{{ old('currency_code') }}" placeholder="VD: LAK, THB, VND" maxlength="10">
                                @error('currency_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="currency_symbol" class="form-label">Ký hiệu tiền tệ</label>
                                <input type="text" name="currency_symbol" id="currency_symbol" class="form-control @error('currency_symbol') is-invalid @enderror"
                                    value="{{ old('currency_symbol') }}" placeholder="VD: ₭, ฿, ₫" maxlength="10">
                                @error('currency_symbol')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                <a href="{{ route('admin.countries.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
