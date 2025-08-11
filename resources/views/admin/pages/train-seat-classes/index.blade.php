@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý hạng ghế tàu</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.train-seat-classes.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm hạng ghế tàu
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.train-seat-classes.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Số ghế, tàu..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
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
                            <label for="seat_class_id" class="text-xs text-secondary mb-0">Hạng ghế</label>
                            <select class="form-control form-control-sm" id="seat_class_id" name="seat_class_id">
                                <option value="">-- Tất cả --</option>
                                @foreach($seatClasses as $seatClass)
                                    <option value="{{ $seatClass->id }}" {{ request('seat_class_id') == $seatClass->id ? 'selected' : '' }}>
                                        {{ $seatClass->name }}
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
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                            @if(request()->hasAny(['search', 'train_id', 'seat_class_id', 'is_active']))
                                <a href="{{ route('admin.train-seat-classes.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hạng ghế</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tổng ghế</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ghế có sẵn</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tỷ lệ lấp đầy</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($trainSeatClasses as $key => $trainSeatClass)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($trainSeatClasses->currentPage() - 1) * $trainSeatClasses->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            @if($trainSeatClass->train)
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $trainSeatClass->train->train_number }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $trainSeatClass->train->operator ?? 'N/A' }}</p>
                                                </div>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có tàu</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($trainSeatClass->seatClass)
                                                <div class="d-flex align-items-center">
                                                    <i class="fa fa-chair text-info me-2"></i>
                                                    <div>
                                                        <h6 class="mb-0 text-sm">{{ $trainSeatClass->seatClass->name }}</h6>
                                                        @if($trainSeatClass->seatClass->description)
                                                            <p class="text-xs text-secondary mb-0">{{ $trainSeatClass->seatClass->description }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có hạng ghế</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">{{ $trainSeatClass->total_seats }} ghế</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-success">{{ $trainSeatClass->available_seats }} ghế</span>
                                        </td>
                                        <td>
                                            @php
                                                $occupiedSeats = $trainSeatClass->total_seats - $trainSeatClass->available_seats;
                                                $occupancyRate = $trainSeatClass->total_seats > 0 ? ($occupiedSeats / $trainSeatClass->total_seats) * 100 : 0;
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 60px; height: 8px;">
                                                    @if($occupancyRate <= 30)
                                                        <div class="progress-bar bg-success" style="width: {{ $occupancyRate }}%"></div>
                                                    @elseif($occupancyRate <= 70)
                                                        <div class="progress-bar bg-warning" style="width: {{ $occupancyRate }}%"></div>
                                                    @else
                                                        <div class="progress-bar bg-danger" style="width: {{ $occupancyRate }}%"></div>
                                                    @endif
                                                </div>
                                                <span class="text-xs">{{ number_format($occupancyRate, 1) }}%</span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @if($trainSeatClass->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.train-seat-classes.show', $trainSeatClass->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.train-seat-classes.edit', $trainSeatClass->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $trainSeatClass->id,
                                                'route' => route('admin.train-seat-classes.destroy', $trainSeatClass->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa hạng ghế tàu này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($trainSeatClasses->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy hạng ghế tàu nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $trainSeatClasses->links('components.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
