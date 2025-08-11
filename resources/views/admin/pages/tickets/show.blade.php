@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết vé</h5>
                        <div>
                            <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Mã vé</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-lg bg-gradient-info">{{ $ticket->ticket_number ?? 'N/A' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày đi</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-lg bg-gradient-secondary">{{ $ticket->travel_date?->format('d/m/Y') ?? 'N/A' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Hành khách</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-user text-primary me-2"></i>
                                    <div>
                                        <p class="text-lg font-weight-bold mb-0">{{ $ticket->passenger_name }}</p>
                                        @if($ticket->passenger_email)
                                            <p class="text-xs text-secondary mb-0">{{ $ticket->passenger_email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tàu</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-train text-success me-2"></i>
                                    <div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $ticket->train->train_number ?? 'N/A' }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $ticket->train->operator ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Hạng ghế</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-chair text-info me-2"></i>
                                    <div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $ticket->seatClass->name ?? 'N/A' }}</p>
                                        @if($ticket->seat_number)
                                            <p class="text-xs text-secondary mb-0">Ghế: {{ $ticket->seat_number }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($ticket->route)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tuyến đường</label>
                                    <div class="d-flex align-items-center">
                                        <i class="fa fa-route text-warning me-2"></i>
                                        <div>
                                            <p class="text-sm font-weight-bold mb-0">{{ $ticket->route->name }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $ticket->route->code ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
    
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giá vé</label>
                                <p class="text-lg font-weight-bold mb-0 text-success">
                                    {{ number_format($ticket->price) }} {{ $ticket->currency ?? 'LAK' }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái</label>
                                <div class="d-flex flex-column">
                                    <span class="badge badge-sm
                                        @switch($ticket->booking_status)
                                            @case('pending') bg-gradient-warning @break
                                            @case('confirmed') bg-gradient-success @break
                                            @case('cancelled') bg-gradient-danger @break
                                            @default bg-gradient-secondary
                                        @endswitch
                                        mb-1">
                                        @switch($ticket->booking_status)
                                            @case('pending') Chờ xử lý @break
                                            @case('confirmed') Đã xác nhận @break
                                            @case('cancelled') Đã hủy @break
                                            @default {{ $ticket->booking_status }}
                                        @endswitch
                                    </span>
                                    <span class="badge badge-sm
                                        @switch($ticket->payment_status)
                                            @case('unpaid') bg-gradient-warning @break
                                            @case('paid') bg-gradient-success @break
                                            @case('refunded') bg-gradient-info @break
                                            @default bg-gradient-secondary
                                        @endswitch
                                    ">
                                        @switch($ticket->payment_status)
                                            @case('unpaid') Chưa thanh toán @break
                                            @case('paid') Đã thanh toán @break
                                            @case('refunded') Đã hoàn tiền @break
                                            @default {{ $ticket->payment_status }}
                                        @endswitch
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($ticket->payment_method || $ticket->payment_reference)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Thanh toán</label>
                                    <div>
                                        @if($ticket->payment_method)
                                            <p class="text-sm mb-0">Phương thức: {{ $ticket->payment_method }}</p>
                                        @endif
                                        @if($ticket->payment_reference)
                                            <p class="text-xs text-secondary mb-0">Mã: {{ $ticket->payment_reference }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($ticket->booked_at || $ticket->expires_at)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Thời gian</label>
                                    <div>
                                        @if($ticket->booked_at)
                                            <p class="text-sm mb-0">Đặt: {{ $ticket->booked_at->format('d/m/Y H:i') }}</p>
                                        @endif
                                        @if($ticket->expires_at)
                                            <p class="text-xs text-secondary mb-0">Hết hạn: {{ $ticket->expires_at->format('d/m/Y H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif
                        @if($ticket->ip_address)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">IP Address</label>
                                    <p class="text-sm mb-0">{{ $ticket->ip_address }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $ticket->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật cuối</label>
                                <p class="text-sm mb-0">{{ $ticket->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Schedule Info Section -->
                    @if($ticket->schedule)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Thông tin lịch trình</h6>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giờ khởi hành</label>
                                    <p class="text-sm font-weight-bold mb-0">{{ $ticket->schedule->departure_time ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Giờ đến</label>
                                    <p class="text-sm font-weight-bold mb-0">{{ $ticket->schedule->arrival_time ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái lịch</label>
                                    @if($ticket->schedule->is_active)
                                        <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
