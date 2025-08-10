@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý ga tàu</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.stations.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm ga tàu
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.stations.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Tên ga hoặc mã ga..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="country_id" class="text-xs text-secondary mb-0">Quốc gia</label>
                            <select class="form-control form-control-sm" id="country_id" name="country_id">
                                <option value="">-- Tất cả quốc gia --</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ request('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="administrative_unit_id" class="text-xs text-secondary mb-0">Đơn vị hành chính</label>
                            <select class="form-control form-control-sm" id="administrative_unit_id" name="administrative_unit_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($administrativeUnits as $unit)
                                    <option value="{{ $unit->id }}" {{ request('administrative_unit_id') == $unit->id ? 'selected' : '' }}>
                                        {{ $unit->name }} ({{ $unit->country->name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="is_active" class="text-xs text-secondary mb-0">Trạng thái</label>
                            <select class="form-control form-control-sm" id="is_active" name="is_active">
                                <option value="">-- Tất cả --</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                            @if(request()->hasAny(['search', 'country_id', 'administrative_unit_id', 'is_active']))
                                <a href="{{ route('admin.stations.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã ga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên ga</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vị trí</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tọa độ</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stations as $key => $station)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($stations->currentPage() - 1) * $stations->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">
                                                <span class="badge badge-sm bg-gradient-info">{{ $station->code }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $station->name }}</h6>
                                                @if($station->address)
                                                    <p class="text-xs text-secondary mb-0">{{ Str::limit($station->address, 50) }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs font-weight-bold mb-0">{{ $station->administrativeUnit->name }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $station->administrativeUnit->country->name }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if($station->latitude && $station->longitude)
                                                <div class="d-flex flex-column justify-content-center">
                                                    <p class="text-xs mb-0">{{ $station->latitude }}, {{ $station->longitude }}</p>
                                                </div>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($station->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.stations.show', $station->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.stations.edit', $station->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $station->id,
                                                'route' => route('admin.stations.destroy', $station->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa ga tàu này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($stations->count() == 0)
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy ga tàu nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $stations->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
