@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý giá theo lịch trình</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.schedule-prices.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm giá
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.schedule-prices.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Giá, tiền tệ, tàu, hạng ghế..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="schedule_id" class="text-xs text-secondary mb-0">Lịch trình</label>
                            <select class="form-control form-control-sm" id="schedule_id" name="schedule_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($schedules as $schedule)
                                    <option value="{{ $schedule->id }}" {{ request('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                        {{ $schedule->train->train_number ?? 'N/A' }} - {{ $schedule->departure_time }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="train_seat_class_id" class="text-xs text-secondary mb-0">Hạng ghế</label>
                            <select class="form-control form-control-sm" id="train_seat_class_id" name="train_seat_class_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($seatClasses as $seatClass)
                                    <option value="{{ $seatClass->id }}" {{ request('train_seat_class_id') == $seatClass->id ? 'selected' : '' }}>
                                        {{ $seatClass->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Tìm
                            </button>
                            @if(request()->hasAny(['search', 'schedule_id', 'train_seat_class_id']))
                                <a href="{{ route('admin.schedule-prices.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lịch trình</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hạng ghế</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giá</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hiệu lực</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedulePrices as $key => $schedulePrice)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($schedulePrices->currentPage() - 1) * $schedulePrices->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $schedulePrice->schedule->train->train_number ?? 'N/A' }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $schedulePrice->schedule->departure_time ?? 'N/A' }} - {{ $schedulePrice->schedule->arrival_time ?? 'N/A' }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $schedulePrice->schedule->route->name ?? 'N/A' }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">{{ $schedulePrice->seatClass->name ?? 'N/A' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-lg bg-gradient-success">{{ number_format($schedulePrice->price) }} {{ $schedulePrice->currency ?? 'LAK' }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                @if($schedulePrice->effective_from)
                                                    <span class="text-xs">Từ: {{ $schedulePrice->effective_from->format('d/m/Y') }}</span>
                                                @endif
                                                @if($schedulePrice->effective_until)
                                                    <span class="text-xs text-secondary">Đến: {{ $schedulePrice->effective_until->format('d/m/Y') }}</span>
                                                @else
                                                    <span class="text-xs text-success">Vô thời hạn</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.schedule-prices.show', $schedulePrice->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.schedule-prices.edit', $schedulePrice->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $schedulePrice->id,
                                                'route' => route('admin.schedule-prices.destroy', $schedulePrice->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa giá này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($schedulePrices->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy giá nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $schedulePrices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
