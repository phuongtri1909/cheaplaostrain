@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết tàu {{ $train->train_number }}</h5>
                        <div>
                            <a href="{{ route('admin.train-seat-classes.index', ['train_id' => $train->id]) }}" class="btn bg-gradient-info btn-sm me-2">
                                <i class="fa-solid fa-chair"></i> Quản lý hạng ghế
                            </a>
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
                        <!-- Basic Train Info -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Số hiệu tàu</label>
                                <p class="text-xl font-weight-bold mb-0 text-primary">
                                    <i class="fa fa-train me-2"></i>{{ $train->train_number }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Loại tàu</label>
                                <p class="text-lg font-weight-bold mb-0">
                                    <i class="fa fa-info-circle text-info me-2"></i>{{ $train->train_type }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Nhà vận hành</label>
                                <p class="text-lg font-weight-bold mb-0">
                                    <i class="fa fa-building text-success me-2"></i>{{ $train->operator }}
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tổng số ghế</label>
                                <p class="text-lg font-weight-bold mb-0 text-warning">
                                    <i class="fa fa-users me-2"></i>{{ $train->total_seats ?? 'Chưa xác định' }} ghế
                                </p>
                            </div>
                        </div>

                        <!-- Route Info -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tuyến đường</label>
                                @if($train->route)
                                    <div class="card border border-light">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <h6 class="mb-2">{{ $train->route->name }}</h6>
                                                    <div class="d-flex align-items-center">
                                                        <div class="d-flex align-items-center me-4">
                                                            <i class="fa fa-map-marker-alt text-success me-2"></i>
                                                            <div>
                                                                <strong>{{ $train->route->departureStation->name }}</strong>
                                                                <p class="text-xs text-secondary mb-0">Điểm đi</p>
                                                            </div>
                                                        </div>
                                                        <div class="mx-3">
                                                            <i class="fa fa-arrow-right text-secondary"></i>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="fa fa-map-marker-alt text-danger me-2"></i>
                                                            <div>
                                                                <strong>{{ $train->route->arrivalStation->name }}</strong>
                                                                <p class="text-xs text-secondary mb-0">Điểm đến</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @if($train->route->distance_km || $train->route->estimated_duration_minutes)
                                                        <div class="row mt-3">
                                                            @if($train->route->distance_km)
                                                                <div class="col-md-6">
                                                                    <small class="text-secondary">
                                                                        <i class="fa fa-road me-1"></i>
                                                                        Khoảng cách: {{ $train->route->distance_km }} km
                                                                    </small>
                                                                </div>
                                                            @endif
                                                            @if($train->route->estimated_duration_minutes)
                                                                <div class="col-md-6">
                                                                    <small class="text-secondary">
                                                                        <i class="fa fa-clock me-1"></i>
                                                                        Thời gian: {{ intval($train->route->estimated_duration_minutes / 60) }}h {{ $train->route->estimated_duration_minutes % 60 }}m
                                                                    </small>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-secondary mb-0">Chưa có tuyến đường</p>
                                @endif
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái hoạt động</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($train->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- System Info -->
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

                    <!-- Seat Classes -->
                    @if($train->trainSeatClasses && $train->trainSeatClasses->count() > 0)
                        <hr class="horizontal dark">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Hạng ghế ({{ $train->trainSeatClasses->count() }})</h6>
                            <a href="{{ route('admin.train-seat-classes.index', ['train_id' => $train->id]) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fa fa-external-link-alt"></i> Quản lý chi tiết
                            </a>
                        </div>
                        <div class="row">
                            @foreach($train->trainSeatClasses as $trainSeatClass)
                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-body p-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1">
                                                        <i class="fa fa-chair text-info me-2"></i>
                                                        {{ $trainSeatClass->seatClass->name ?? 'N/A' }}
                                                    </h6>
                                                    @if($trainSeatClass->seatClass && $trainSeatClass->seatClass->description)
                                                        <p class="text-xs text-secondary mb-2">{{ $trainSeatClass->seatClass->description }}</p>
                                                    @endif
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <small class="text-secondary">Tổng ghế:</small>
                                                            <div class="font-weight-bold">{{ $trainSeatClass->total_seats }}</div>
                                                        </div>
                                                        <div class="col-6">
                                                            <small class="text-secondary">Còn lại:</small>
                                                            <div class="font-weight-bold text-success">{{ $trainSeatClass->available_seats }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="text-end">
                                                    @if($trainSeatClass->is_active)
                                                        <span class="badge bg-gradient-success">Hoạt động</span>
                                                    @else
                                                        <span class="badge bg-gradient-secondary">Không hoạt động</span>
                                                    @endif
                                                    @php
                                                        $occupiedSeats = $trainSeatClass->total_seats - $trainSeatClass->available_seats;
                                                        $occupancyRate = $trainSeatClass->total_seats > 0 ? ($occupiedSeats / $trainSeatClass->total_seats) * 100 : 0;
                                                    @endphp
                                                    <div class="mt-2">
                                                        <div class="progress" style="height: 6px;">
                                                            @if($occupancyRate <= 30)
                                                                <div class="progress-bar bg-success" style="width: {{ $occupancyRate }}%"></div>
                                                            @elseif($occupancyRate <= 70)
                                                                <div class="progress-bar bg-warning" style="width: {{ $occupancyRate }}%"></div>
                                                            @else
                                                                <div class="progress-bar bg-danger" style="width: {{ $occupancyRate }}%"></div>
                                                            @endif
                                                        </div>
                                                        <small class="text-secondary">{{ number_format($occupancyRate, 1) }}% đã đặt</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <hr class="horizontal dark">
                        <div class="text-center py-4">
                            <i class="fa fa-chair fa-3x text-secondary mb-3"></i>
                            <h6 class="text-secondary">Chưa có hạng ghế nào được cấu hình</h6>
                            <p class="text-sm text-secondary mb-0">Hãy chỉnh sửa tàu để thêm hạng ghế</p>
                        </div>
                    @endif

                    <!-- Schedules -->
                    @if($train->schedules && $train->schedules->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Lịch trình liên quan ({{ $train->schedules->count() }})</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Ngày</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Giờ khởi hành</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Giờ đến</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($train->schedules->take(5) as $schedule)
                                        <tr>
                                            <td>
                                                @if($schedule->operating_days)
                                                    @php
                                                        $days = json_decode($schedule->operating_days, true);
                                                        $dayNames = ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'];
                                                    @endphp
                                                    @foreach($days as $day)
                                                        <span class="badge badge-sm bg-gradient-info">{{ $dayNames[$day] ?? $day }}</span>
                                                    @endforeach
                                                @else
                                                    <span class="text-secondary">Chưa có</span>
                                                @endif
                                            </td>
                                            <td><span class="badge bg-gradient-success">{{ $schedule->departure_time }}</span></td>
                                            <td><span class="badge bg-gradient-danger">{{ $schedule->arrival_time }}</span></td>
                                            <td>
                                                @if($schedule->is_active)
                                                    <span class="badge bg-gradient-success">Hoạt động</span>
                                                @else
                                                    <span class="badge bg-gradient-secondary">Không hoạt động</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($train->schedules->count() > 5)
                                <p class="text-center text-sm text-secondary">Và {{ $train->schedules->count() - 5 }} lịch trình khác...</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
