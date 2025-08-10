@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý lịch trình</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.schedules.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm lịch trình
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.schedules.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Giờ khởi hành, đến hoặc số tàu..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="train_id" class="text-xs text-secondary mb-0">Tàu</label>
                            <select class="form-control form-control-sm" id="train_id" name="train_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($trains as $train)
                                    <option value="{{ $train->id }}" {{ request('train_id') == $train->id ? 'selected' : '' }}>
                                        {{ $train->train_number }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="route_id" class="text-xs text-secondary mb-0">Tuyến</label>
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
                            <label for="is_active" class="text-xs text-secondary mb-0">Trạng thái</label>
                            <select class="form-control form-control-sm" id="is_active" name="is_active">
                                <option value="">-- Tất cả --</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="effective_date" class="text-xs text-secondary mb-0">Ngày hiệu lực</label>
                            <input type="date" class="form-control form-control-sm" id="effective_date" name="effective_date"
                                   value="{{ request('effective_date') }}">
                        </div>
                        <div class="col-md-1">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                            @if(request()->hasAny(['search', 'train_id', 'route_id', 'is_active', 'effective_date']))
                                <a href="{{ route('admin.schedules.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tàu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tuyến</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giờ KH - Đến</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày hoạt động</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hiệu lực</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedules as $key => $schedule)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($schedules->currentPage() - 1) * $schedules->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $schedule->train->train_number ?? 'N/A' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $schedule->train->operator ?? 'N/A' }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            @if($schedule->route)
                                                <p class="text-xs font-weight-bold mb-0">{{ $schedule->route->name }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $schedule->route->code ?? 'N/A' }}</p>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có tuyến</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-sm bg-gradient-success me-2">{{ $schedule->departure_time }}</span>
                                                <i class="fa fa-arrow-right mx-1"></i>
                                                <span class="badge badge-sm bg-gradient-info">{{ $schedule->arrival_time }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($schedule->operating_days && count($schedule->operating_days) > 0)
                                                <div class="d-flex flex-wrap">
                                                    @php
                                                        $dayNames = [
                                                            1 => 'CN', 2 => 'T2', 3 => 'T3', 4 => 'T4',
                                                            5 => 'T5', 6 => 'T6', 7 => 'T7'
                                                        ];
                                                    @endphp
                                                    @foreach($schedule->operating_days as $day)
                                                        <span class="badge badge-xs bg-gradient-secondary me-1 mb-1">{{ $dayNames[$day] ?? $day }}</span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-xs text-secondary">Hàng ngày</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-xs">{{ $schedule->effective_from->format('d/m/Y') }}</span>
                                                @if($schedule->effective_until)
                                                    <span class="text-xs text-secondary">đến {{ $schedule->effective_until->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="text-xs text-secondary">vô thời hạn</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($schedule->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.schedules.show', $schedule->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $schedule->id,
                                                'route' => route('admin.schedules.destroy', $schedule->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa lịch trình này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($schedules->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy lịch trình nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $schedules->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
