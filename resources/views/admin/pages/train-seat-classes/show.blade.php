@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết hạng ghế tàu</h5>
                        <div>
                            <a href="{{ route('admin.train-seat-classes.edit', $trainSeatClass->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.train-seat-classes.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <!-- Train Information -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Thông tin tàu</label>
                                @if($trainSeatClass->train)
                                    <div class="card border border-light">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fa fa-train text-primary me-2"></i>
                                                        <div>
                                                            <h6 class="mb-0">{{ $trainSeatClass->train->train_number }}</h6>
                                                            <p class="text-xs text-secondary mb-0">Số hiệu tàu</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fa fa-building text-success me-2"></i>
                                                        <div>
                                                            <h6 class="mb-0">{{ $trainSeatClass->train->operator ?? 'N/A' }}</h6>
                                                            <p class="text-xs text-secondary mb-0">Nhà điều hành</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($trainSeatClass->train->train_type)
                                                    <div class="col-md-6">
                                                        <span class="badge bg-gradient-info">{{ $trainSeatClass->train->train_type }}</span>
                                                    </div>
                                                @endif
                                                <div class="col-md-6">
                                                    @if($trainSeatClass->train->is_active)
                                                        <span class="badge bg-gradient-success">Tàu hoạt động</span>
                                                    @else
                                                        <span class="badge bg-gradient-secondary">Tàu không hoạt động</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-secondary mb-0">Chưa có thông tin tàu</p>
                                @endif
                            </div>
                        </div>

                        <!-- Seat Class Information -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Thông tin hạng ghế</label>
                                @if($trainSeatClass->seatClass)
                                    <div class="card border border-light">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fa fa-chair text-info me-2"></i>
                                                        <div>
                                                            <h6 class="mb-0">{{ $trainSeatClass->seatClass->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">Tên hạng ghế</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($trainSeatClass->seatClass->description)
                                                    <div class="col-md-6">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="fa fa-info-circle text-warning me-2"></i>
                                                            <div>
                                                                <p class="mb-0 text-sm">{{ $trainSeatClass->seatClass->description }}</p>
                                                                <p class="text-xs text-secondary mb-0">Mô tả</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-6">
                                                    @if($trainSeatClass->seatClass->is_active)
                                                        <span class="badge bg-gradient-success">Hạng ghế hoạt động</span>
                                                    @else
                                                        <span class="badge bg-gradient-secondary">Hạng ghế không hoạt động</span>
                                                    @endif
                                                </div>
                                                @if($trainSeatClass->seatClass->sort_order)
                                                    <div class="col-md-6">
                                                        <span class="badge bg-gradient-info">Thứ tự: {{ $trainSeatClass->seatClass->sort_order }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-secondary mb-0">Chưa có thông tin hạng ghế</p>
                                @endif
                            </div>
                        </div>

                        <!-- Seat Statistics -->
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tổng số ghế</label>
                                <p class="text-xl font-weight-bold mb-0 text-primary">
                                    <i class="fa fa-chair me-2"></i>{{ $trainSeatClass->total_seats }} ghế
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ghế có sẵn</label>
                                <p class="text-xl font-weight-bold mb-0 text-success">
                                    <i class="fa fa-check-circle me-2"></i>{{ $trainSeatClass->available_seats }} ghế
                                </p>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ghế đã đặt</label>
                                @php
                                    $occupiedSeats = $trainSeatClass->total_seats - $trainSeatClass->available_seats;
                                @endphp
                                <p class="text-xl font-weight-bold mb-0 text-warning">
                                    <i class="fa fa-times-circle me-2"></i>{{ $occupiedSeats }} ghế
                                </p>
                            </div>
                        </div>

                        <!-- Occupancy Rate -->
                        <div class="col-md-12">
                            <div class="mb-4">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tỷ lệ lấp đầy</label>
                                @php
                                    $occupancyRate = $trainSeatClass->total_seats > 0 ? ($occupiedSeats / $trainSeatClass->total_seats) * 100 : 0;
                                @endphp
                                <div class="d-flex align-items-center">
                                    <div class="progress me-3" style="width: 200px; height: 20px;">
                                        @if($occupancyRate <= 30)
                                            <div class="progress-bar bg-success" style="width: {{ $occupancyRate }}%">{{ number_format($occupancyRate, 1) }}%</div>
                                        @elseif($occupancyRate <= 70)
                                            <div class="progress-bar bg-warning" style="width: {{ $occupancyRate }}%">{{ number_format($occupancyRate, 1) }}%</div>
                                        @else
                                            <div class="progress-bar bg-danger" style="width: {{ $occupancyRate }}%">{{ number_format($occupancyRate, 1) }}%</div>
                                        @endif
                                    </div>
                                    <div>
                                        @if($occupancyRate <= 30)
                                            <span class="badge bg-gradient-success">Còn nhiều chỗ</span>
                                        @elseif($occupancyRate <= 70)
                                            <span class="badge bg-gradient-warning">Còn ít chỗ</span>
                                        @else
                                            <span class="badge bg-gradient-danger">Gần hết chỗ</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái hoạt động</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($trainSeatClass->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $trainSeatClass->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật cuối</label>
                                <p class="text-sm mb-0">{{ $trainSeatClass->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Schedule Prices -->
                    @if($trainSeatClass->schedulePrices && $trainSeatClass->schedulePrices->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Giá theo lịch trình ({{ $trainSeatClass->schedulePrices->count() }})</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Lịch trình</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Tuyến</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Giá</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder">Hiệu lực</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trainSeatClass->schedulePrices as $price)
                                        <tr>
                                            <td>
                                                @if($price->schedule)
                                                    <div>
                                                        <strong>{{ $price->schedule->departure_time }} → {{ $price->schedule->arrival_time }}</strong>
                                                        <br><small class="text-secondary">{{ $price->schedule->train->train_number ?? 'N/A' }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($price->schedule && $price->schedule->route)
                                                    {{ $price->schedule->route->name }}
                                                @else
                                                    <span class="text-secondary">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-gradient-success">{{ number_format($price->price) }} {{ $price->currency ?? 'LAK' }}</span>
                                            </td>
                                            <td>
                                                @if($price->effective_from)
                                                    <small>Từ: {{ $price->effective_from->format('d/m/Y') }}</small><br>
                                                @endif
                                                @if($price->effective_until)
                                                    <small>Đến: {{ $price->effective_until->format('d/m/Y') }}</small>
                                                @else
                                                    <small class="text-success">Vô thời hạn</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
