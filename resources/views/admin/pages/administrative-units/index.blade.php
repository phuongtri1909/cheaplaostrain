@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý đơn vị hành chính</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.administrative-units.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm đơn vị
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.administrative-units.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3 col-sm-6">
                            <label for="name_filter" class="text-xs text-secondary mb-0">Tên đơn vị</label>
                            <input type="text" class="form-control form-control-sm" id="name_filter" name="name"
                                   placeholder="Tìm kiếm tên..." value="{{ request('name') }}">
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label for="type_filter" class="text-xs text-secondary mb-0">Loại</label>
                            <select class="form-control form-control-sm" id="type_filter" name="type">
                                <option value="">Tất cả</option>
                                @foreach($types as $key => $value)
                                    <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label for="level_filter" class="text-xs text-secondary mb-0">Cấp độ</label>
                            <select class="form-control form-control-sm" id="level_filter" name="level">
                                <option value="">Tất cả</option>
                                <option value="1" {{ request('level') == '1' ? 'selected' : '' }}>Cấp 1</option>
                                <option value="2" {{ request('level') == '2' ? 'selected' : '' }}>Cấp 2</option>
                                <option value="3" {{ request('level') == '3' ? 'selected' : '' }}>Cấp 3</option>
                            </select>
                        </div>

                        <div class="col-md-2 col-sm-6">
                            <label for="country_filter" class="text-xs text-secondary mb-0">Quốc gia</label>
                            <select class="form-control form-control-sm" id="country_filter" name="country_id">
                                <option value="">Tất cả</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Lọc
                            </button>
                            @if(request('name') || request('type') || request('country_id') || request('level'))
                                <a href="{{ route('admin.administrative-units.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.components.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Loại</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cấp độ</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Quốc gia</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Đơn vị cha</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($administrativeUnits as $key => $unit)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($administrativeUnits->currentPage() - 1) * $administrativeUnits->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">{{ $unit->code }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <p class="text-xs font-weight-bold mb-0">{{ $unit->name }}</p>
                                                @if($unit->local_name)
                                                    <p class="text-xs text-secondary mb-0">{{ $unit->local_name }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm
                                                @if($unit->type == 'province') bg-gradient-primary
                                                @elseif($unit->type == 'district') bg-gradient-success
                                                @elseif($unit->type == 'town') bg-gradient-warning
                                                @else bg-gradient-secondary
                                                @endif">
                                                {{ $types[$unit->type] ?? $unit->type }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-gradient-dark">{{ $unit->level }}</span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $unit->country->name }}</p>
                                        </td>
                                        <td>
                                            @if($unit->parent)
                                                <p class="text-xs text-secondary mb-0">{{ $unit->parent->name }}</p>
                                            @else
                                                <span class="text-xs text-muted">-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($unit->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.administrative-units.edit', $unit->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $unit->id,
                                                'route' => route('admin.administrative-units.destroy', $unit->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa đơn vị hành chính này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($administrativeUnits->count() == 0)
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy đơn vị hành chính nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            <x-pagination :paginator="$administrativeUnits" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
