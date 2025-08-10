@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết tàu</h5>
                        <div>
                            <a href="{{ route('admin.trains.edit', $train->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.trains.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Số hiệu tàu</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-lg bg-gradient-info">{{ $train->train_number }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($train->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Loại tàu</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-sm bg-gradient-primary">{{ $train->train_type }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Nhà vận hành</label>
                                <p class="text-lg font-weight-bold mb-0">{{ $train->operator }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tuyến đường</label>
                                @if($train->route)
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="text-sm font-weight-bold mb-0">{{ $train->route->name }}</p>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-circle text-success me-1" style="font-size: 8px;"></i>
                                                {{ $train->route->departureStation->name }}
                                                <i class="fa fa-arrow-right mx-2"></i>
                                                <i class="fa fa-circle text-danger me-1" style="font-size: 8px;"></i>
                                                {{ $train->route->arrivalStation->name }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-secondary mb-0">Chưa có tuyến</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tổng số ghế</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($train->total_seats)
                                        <span class="badge badge-sm bg-gradient-secondary">{{ $train->total_seats }} ghế</span>
                                    @else
                                        <span class="text-secondary">Chưa có thông tin</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $train->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật cuối</label>
                                <p class="text-sm mb-0">{{ $train->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Data Section -->
                    @if(isset($train->trainSeatClasses) && $train->trainSeatClasses->count() > 0 || isset($train->schedules) && $train->schedules->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Thông tin liên quan</h6>

                        @if(isset($train->trainSeatClasses) && $train->trainSeatClasses->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cấu hình hạng ghế</label>
                                <div class="table-responsive mt-2">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-xs">Hạng ghế</th>
                                                <th class="text-xs">Số ghế</th>
                                                <th class="text-xs">Giá cơ bản</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($train->trainSeatClasses as $trainSeatClass)
                                                <tr>
                                                    <td class="text-xs">{{ $trainSeatClass->seatClass->name ?? 'N/A' }}</td>
                                                    <td class="text-xs">{{ $trainSeatClass->total_seats ?? '-' }}</td>
                                                    <td class="text-xs">
                                                        @if(isset($trainSeatClass->base_price) && $trainSeatClass->base_price)
                                                            {{ number_format($trainSeatClass->base_price) }} ₭
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        @if(isset($train->schedules) && $train->schedules->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Lịch trình ({{ $train->schedules->count() }} lịch)</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($train->schedules->take(5) as $schedule)
                                        <span class="badge badge-sm bg-gradient-primary me-2 mb-2">
                                            {{ $schedule->departure_time ?? 'N/A' }} - {{ $schedule->arrival_time ?? 'N/A' }}
                                        </span>
                                    @endforeach
                                    @if($train->schedules->count() > 5)
                                        <span class="text-xs text-secondary">+{{ $train->schedules->count() - 5 }} khác</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
