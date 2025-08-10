@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết lịch trình</h5>
                        <div>
                            <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tàu</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-train text-primary me-2"></i>
                                    <div>
                                        <p class="text-lg font-weight-bold mb-0">{{ $schedule->train->train_number ?? 'N/A' }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $schedule->train->operator ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tuyến đường</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-route text-success me-2"></i>
                                    <div>
                                        <p class="text-lg font-weight-bold mb-0">{{ $schedule->route->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $schedule->route->code ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giờ khởi hành</label>
                                <p class="text-lg font-weight-bold mb-0 text-success">
                                    <i class="fa fa-clock me-2"></i>{{ $schedule->departure_time }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giờ đến</label>
                                <p class="text-lg font-weight-bold mb-0 text-info">
                                    <i class="fa fa-clock me-2"></i>{{ $schedule->arrival_time }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày hoạt động</label>
                                @if($schedule->operating_days && count($schedule->operating_days) > 0)
                                    <div class="d-flex flex-wrap">
                                        @php
                                            $dayNames = [
                                                1 => 'Chủ nhật', 2 => 'Thứ hai', 3 => 'Thứ ba', 4 => 'Thứ tư',
                                                5 => 'Thứ năm', 6 => 'Thứ sáu', 7 => 'Thứ bảy'
                                            ];
                                        @endphp
                                        @foreach($schedule->operating_days as $day)
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Có hiệu lực từ</label>
                                <p class="text-sm font-weight-bold mb-0">{{ $schedule->effective_from?->format('d/m/Y') ?? 'N/A' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Có hiệu lực đến</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($schedule->effective_until)
                                        {{ $schedule->effective_until->format('d/m/Y') }}
                                    @else
                                        <span class="text-success">Vô thời hạn</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($schedule->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $schedule->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật cuối</label>
                                <p class="text-sm mb-0">{{ $schedule->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Data Section -->
                    @if(isset($schedule->tickets) && $schedule->tickets->count() > 0 || isset($schedule->schedulePrices) && $schedule->schedulePrices->count() > 0 || isset($schedule->segmentPrices) && $schedule->segmentPrices->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Thông tin liên quan</h6>

                        @if(isset($schedule->tickets) && $schedule->tickets->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Vé đã đặt ({{ $schedule->tickets->count() }} vé)</label>
                                <div class="table-responsive mt-2">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-xs">Mã vé</th>
                                                <th class="text-xs">Hành khách</th>
                                                <th class="text-xs">Ngày đi</th>
                                                <th class="text-xs">Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($schedule->tickets->take(5) as $ticket)
                                                <tr>
                                                    <td class="text-xs">{{ $ticket->ticket_number ?? 'N/A' }}</td>
                                                    <td class="text-xs">{{ $ticket->passenger_name }}</td>
                                                    <td class="text-xs">{{ $ticket->travel_date?->format('d/m/Y') ?? 'N/A' }}</td>
                                                    <td class="text-xs">
                                                        <span class="badge badge-xs
                                                            @switch($ticket->booking_status)
                                                                @case('pending') bg-gradient-warning @break
                                                                @case('confirmed') bg-gradient-success @break
                                                                @case('cancelled') bg-gradient-danger @break
                                                                @default bg-gradient-secondary
                                                            @endswitch
                                                        ">
                                                            @switch($ticket->booking_status)
                                                                @case('pending') Chờ @break
                                                                @case('confirmed') Đã xác nhận @break
                                                                @case('cancelled') Đã hủy @break
                                                                @default {{ $ticket->booking_status }}
                                                            @endswitch
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($schedule->tickets->count() > 5)
                                        <p class="text-xs text-secondary mt-2">+{{ $schedule->tickets->count() - 5 }} vé khác</p>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(isset($schedule->schedulePrices) && $schedule->schedulePrices->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giá theo lịch trình ({{ $schedule->schedulePrices->count() }} mục)</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($schedule->schedulePrices->take(5) as $price)
                                        <span class="badge badge-sm bg-gradient-primary me-2 mb-2">
                                            {{ $price->seatClass->name ?? 'N/A' }}: {{ number_format($price->price ?? 0) }} {{ $price->currency ?? 'LAK' }}
                                        </span>
                                    @endforeach
                                    @if($schedule->schedulePrices->count() > 5)
                                        <span class="text-xs text-secondary">+{{ $schedule->schedulePrices->count() - 5 }} khác</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if(isset($schedule->segmentPrices) && $schedule->segmentPrices->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giá theo đoạn tuyến ({{ $schedule->segmentPrices->count() }} mục)</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($schedule->segmentPrices->take(5) as $price)
                                        <span class="badge badge-sm bg-gradient-info me-2 mb-2">
                                            {{ $price->routeSegment->originStation->name ?? 'N/A' }} - {{ $price->routeSegment->destinationStation->name ?? 'N/A' }}: {{ number_format($price->price ?? 0) }} {{ $price->currency ?? 'LAK' }}
                                        </span>
                                    @endforeach
                                    @if($schedule->segmentPrices->count() > 5)
                                        <span class="text-xs text-secondary">+{{ $schedule->segmentPrices->count() - 5 }} khác</span>
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
