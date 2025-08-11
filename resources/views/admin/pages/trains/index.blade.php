@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý tàu hỏa</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.trains.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm tàu
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.trains.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Số hiệu hoặc nhà vận hành..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="route_id" class="text-xs text-secondary mb-0">Tuyến đường</label>
                            <select class="form-control form-control-sm" id="route_id" name="route_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($routes as $route)
                                    <option value="{{ $route->id }}" {{ request('route_id') == $route->id ? 'selected' : '' }}>
                                        {{ $route->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="train_type" class="text-xs text-secondary mb-0">Loại tàu</label>
                            <input type="text" class="form-control form-control-sm" id="train_type" name="train_type"
                                   placeholder="Loại tàu..." value="{{ request('train_type') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="is_active" class="text-xs text-secondary mb-0">Trạng thái</label>
                            <select class="form-control form-control-sm" id="is_active" name="is_active">
                                <option value="">-- Tất cả --</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Tìm
                            </button>
                            @if(request()->hasAny(['search', 'route_id', 'train_type', 'is_active']))
                                <a href="{{ route('admin.trains.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số hiệu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Loại tàu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nhà vận hành</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tuyến đường</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số ghế</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trains as $key => $train)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($trains->currentPage() - 1) * $trains->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">
                                                <span class="badge badge-sm bg-gradient-info">{{ $train->train_number }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-primary">{{ $train->train_type }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $train->operator }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            @if($train->route)
                                                <p class="text-xs font-weight-bold mb-0">{{ $train->route->name }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $train->route->code }}</p>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có tuyến</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($train->total_seats)
                                                <span class="badge badge-sm bg-gradient-secondary">{{ $train->total_seats }} ghế</span>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if($train->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.trains.show', $train->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.trains.edit', $train->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $train->id,
                                                'route' => route('admin.trains.destroy', $train->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa tàu này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($trains->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy tàu nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $trains->links('components.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
