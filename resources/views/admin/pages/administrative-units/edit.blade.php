@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Chỉnh sửa đơn vị hành chính</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.administrative-units.update', $administrativeUnit->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="country_id" class="form-label">Quốc gia <span class="text-danger">*</span></label>
                                <select name="country_id" id="country_id" class="form-control @error('country_id') is-invalid @enderror" required>
                                    <option value="">Chọn quốc gia</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country_id', $administrativeUnit->country_id) == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="parent_id" class="form-label">Đơn vị cha</label>
                                <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                                    <option value="">Không có (đơn vị gốc)</option>
                                    @foreach($parentUnits as $parent)
                                        <option value="{{ $parent->id }}" {{ old('parent_id', $administrativeUnit->parent_id) == $parent->id ? 'selected' : '' }}>
                                            {{ $parent->name }} ({{ $types[$parent->type] ?? $parent->type }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('parent_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="code" class="form-label">Mã đơn vị <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror"
                                    value="{{ old('code', $administrativeUnit->code) }}" placeholder="VD: VTE-PROV, VGV-DIST" maxlength="10" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên đơn vị <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $administrativeUnit->name) }}" placeholder="VD: Vientiane Province" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="local_name" class="form-label">Tên địa phương</label>
                                <input type="text" name="local_name" id="local_name" class="form-control @error('local_name') is-invalid @enderror"
                                    value="{{ old('local_name', $administrativeUnit->local_name) }}" placeholder="VD: ແຂວງວຽງຈັນ">
                                @error('local_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Loại đơn vị <span class="text-danger">*</span></label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">Chọn loại</option>
                                    @foreach($types as $key => $value)
                                        <option value="{{ $key }}" {{ old('type', $administrativeUnit->type) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="level" class="form-label">Cấp độ <span class="text-danger">*</span></label>
                                <select name="level" id="level" class="form-control @error('level') is-invalid @enderror" required>
                                    <option value="">Chọn cấp độ</option>
                                    <option value="1" {{ old('level', $administrativeUnit->level) == '1' ? 'selected' : '' }}>Cấp 1 (Tỉnh/Thành phố)</option>
                                    <option value="2" {{ old('level', $administrativeUnit->level) == '2' ? 'selected' : '' }}>Cấp 2 (Huyện/Quận)</option>
                                    <option value="3" {{ old('level', $administrativeUnit->level) == '3' ? 'selected' : '' }}>Cấp 3 (Xã/Phường)</option>
                                </select>
                                @error('level')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="latitude" class="form-label">Vĩ độ</label>
                                <input type="number" name="latitude" id="latitude" step="0.000001" min="-90" max="90"
                                    class="form-control @error('latitude') is-invalid @enderror"
                                    value="{{ old('latitude', $administrativeUnit->latitude) }}" placeholder="VD: 17.9757">
                                @error('latitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="longitude" class="form-label">Kinh độ</label>
                                <input type="number" name="longitude" id="longitude" step="0.000001" min="-180" max="180"
                                    class="form-control @error('longitude') is-invalid @enderror"
                                    value="{{ old('longitude', $administrativeUnit->longitude) }}" placeholder="VD: 102.6331">
                                @error('longitude')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $administrativeUnit->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Cập nhật</button>
                                <a href="{{ route('admin.administrative-units.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
