@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý tuyến đường</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.routes.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm tuyến đường
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.routes.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Tên hoặc mã tuyến..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="departure_station_id" class="text-xs text-secondary mb-0">Ga khởi hành</label>
                            <select class="form-control form-control-sm" id="departure_station_id" name="departure_station_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ request('departure_station_id') == $station->id ? 'selected' : '' }}>
                                        {{ $station->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="arrival_station_id" class="text-xs text-secondary mb-0">Ga đến</label>
                            <select class="form-control form-control-sm" id="arrival_station_id" name="arrival_station_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($stations as $station)
                                    <option value="{{ $station->id }}" {{ request('arrival_station_id') == $station->id ? 'selected' : '' }}>
                                        {{ $station->name }}
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
                            @if(request()->hasAny(['search', 'departure_station_id', 'arrival_station_id', 'is_active']))
                                <a href="{{ route('admin.routes.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên tuyến</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lộ trình</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Khoảng cách</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thời gian</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($routes as $key => $route)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($routes->currentPage() - 1) * $routes->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">
                                                <span class="badge badge-sm bg-gradient-info">{{ $route->code }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $route->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    <i class="fa fa-circle text-success me-1" style="font-size: 8px;"></i>
                                                    {{ $route->departureStation->name }}
                                                </p>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-circle text-danger me-1" style="font-size: 8px;"></i>
                                                    {{ $route->arrivalStation->name }}
                                                </p>
                                            </div>
                                        </td>
                                        <td>
                                            @if($route->distance_km)
                                                <span class="badge badge-sm bg-gradient-primary">{{ $route->distance_km }} km</span>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($route->estimated_duration_minutes)
                                                <span class="badge badge-sm bg-gradient-secondary">{{ intval($route->estimated_duration_minutes / 60) }}h {{ $route->estimated_duration_minutes % 60 }}m</span>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($route->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.routes.show', $route->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.routes.edit', $route->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $route->id,
                                                'route' => route('admin.routes.destroy', $route->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa tuyến đường này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($routes->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy tuyến đường nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $routes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
