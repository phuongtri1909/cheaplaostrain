@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết giá lịch trình</h5>
                        <div>
                            <a href="{{ route('admin.schedule-prices.edit', $schedulePrice->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.schedule-prices.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giá</label>
                                <p class="text-xl font-weight-bold mb-0 text-success">
                                    <i class="fa fa-money-bill me-2"></i>{{ number_format($schedulePrice->price) }} {{ $schedulePrice->currency ?? 'LAK' }}
                                </p>
                            </div>
                        </div>

                        <!-- Schedule Information -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Lịch trình</label>
                                @if($schedulePrice->schedule)
                                    <div class="card border border-light">
                                        <div class="card-body p-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fa fa-train text-primary me-2"></i>
                                                        <div>
                                                            <h6 class="mb-0">{{ $schedulePrice->schedule->train->train_number ?? 'N/A' }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $schedulePrice->schedule->train->operator ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="fa fa-route text-success me-2"></i>
                                                        <div>
                                                            <h6 class="mb-0">{{ $schedulePrice->schedule->route->name ?? 'N/A' }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $schedulePrice->schedule->route->code ?? 'N/A' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-clock text-info me-2"></i>
                                                        <span class="text-sm">Khởi hành: {{ $schedulePrice->schedule->departure_time }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa fa-clock text-warning me-2"></i>
                                                        <span class="text-sm">Đến: {{ $schedulePrice->schedule->arrival_time }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-secondary mb-0">Không có thông tin lịch trình</p>
                                @endif
                            </div>
                        </div>

                        <!-- Seat Class Information -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Hạng ghế</label>
                                @if($schedulePrice->seatClass)
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-chair text-info me-2"></i>
                                        <div>
                                            <p class="text-lg font-weight-bold mb-0">{{ $schedulePrice->seatClass->name }}</p>
                                            @if($schedulePrice->seatClass->description)
                                                <p class="text-xs text-secondary mb-0">{{ $schedulePrice->seatClass->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-secondary mb-0">Không có thông tin hạng ghế</p>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tiền tệ</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-sm bg-gradient-secondary">{{ $schedulePrice->currency ?? 'LAK' }}</span>
                                </p>
                            </div>
                        </div>

                        <!-- Effective Period -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Có hiệu lực từ</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($schedulePrice->effective_from)
                                        <i class="fa fa-calendar text-success me-2"></i>{{ $schedulePrice->effective_from->format('d/m/Y') }}
                                    @else
                                        <span class="text-secondary">Không xác định</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Có hiệu lực đến</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($schedulePrice->effective_until)
                                        <i class="fa fa-calendar text-danger me-2"></i>{{ $schedulePrice->effective_until->format('d/m/Y') }}
                                    @else
                                        <span class="text-success"><i class="fa fa-infinity me-2"></i>Vô thời hạn</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Status Check -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái hiệu lực</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @php
                                        $now = now();
                                        $isActive = true;

                                        if ($schedulePrice->effective_from && $now < $schedulePrice->effective_from) {
                                            $isActive = false;
                                            $statusText = 'Chưa có hiệu lực';
                                            $statusClass = 'bg-gradient-warning';
                                        } elseif ($schedulePrice->effective_until && $now > $schedulePrice->effective_until) {
                                            $isActive = false;
                                            $statusText = 'Đã hết hiệu lực';
                                            $statusClass = 'bg-gradient-danger';
                                        } else {
                                            $statusText = 'Đang có hiệu lực';
                                            $statusClass = 'bg-gradient-success';
                                        }
                                    @endphp
                                    <span class="badge badge-lg {{ $statusClass }}">{{ $statusText }}</span>
                                </p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $schedulePrice->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật cuối</label>
                                <p class="text-sm mb-0">{{ $schedulePrice->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule's Operating Days -->
                    @if($schedulePrice->schedule && $schedulePrice->schedule->operating_days)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Ngày hoạt động của lịch trình</h6>

                        <div class="row">
                            <div class="col-md-12">
                                @if(count($schedulePrice->schedule->operating_days) > 0)
                                    <div class="d-flex flex-wrap">
                                        @php
                                            $dayNames = [
                                                1 => 'Chủ nhật', 2 => 'Thứ hai', 3 => 'Thứ ba', 4 => 'Thứ tư',
                                                5 => 'Thứ năm', 6 => 'Thứ sáu', 7 => 'Thứ bảy'
                                            ];
                                        @endphp
                                        @foreach($schedulePrice->schedule->operating_days as $day)
                                            <span class="badge badge-sm bg-gradient-secondary me-2 mb-2">{{ $dayNames[$day] ?? $day }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm mb-0">
                                        <span class="badge badge-sm bg-gradient-primary">Hàng ngày</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
