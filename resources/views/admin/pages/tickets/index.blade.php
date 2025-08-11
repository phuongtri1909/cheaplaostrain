@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý vé tàu</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.tickets.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm vé
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.tickets.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-2">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Mã vé, tên, email..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <label for="booking_status" class="text-xs text-secondary mb-0">Trạng thái đặt</label>
                            <select class="form-control form-control-sm" id="booking_status" name="booking_status">
                                <option value="">-- Tất cả --</option>
                                <option value="pending" {{ request('booking_status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="confirmed" {{ request('booking_status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="cancelled" {{ request('booking_status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="payment_status" class="text-xs text-secondary mb-0">Thanh toán</label>
                            <select class="form-control form-control-sm" id="payment_status" name="payment_status">
                                <option value="">-- Tất cả --</option>
                                <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                                <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                            </select>
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
                            <label for="travel_date" class="text-xs text-secondary mb-0">Ngày đi</label>
                            <input type="date" class="form-control form-control-sm" id="travel_date" name="travel_date"
                                   value="{{ request('travel_date') }}">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Tìm
                            </button>
                            @if(request()->hasAny(['search', 'booking_status', 'payment_status', 'train_id', 'travel_date']))
                                <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã vé</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hành khách</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tàu</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày đi</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Giá</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $key => $ticket)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($tickets->currentPage() - 1) * $tickets->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">
                                                <span class="badge badge-sm bg-gradient-info">{{ $ticket->ticket_number }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $ticket->passenger_name }}</h6>
                                                @if($ticket->passenger_email)
                                                    <p class="text-xs text-secondary mb-0">{{ $ticket->passenger_email }}</p>
                                                @endif
                                                @if($ticket->seat_number)
                                                    <p class="text-xs text-secondary mb-0">Ghế: {{ $ticket->seat_number }}</p>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $ticket->train->train_number ?? 'N/A' }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $ticket->seatClass->name ?? 'N/A' }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-secondary">{{ $ticket->travel_date->format('d/m/Y') }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-success">{{ number_format($ticket->price) }} {{ $ticket->currency ?? 'LAK' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column">
                                                <span class="badge badge-xs
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
                                                <span class="badge badge-xs
                                                    @switch($ticket->payment_status)
                                                        @case('unpaid') bg-gradient-warning @break
                                                        @case('paid') bg-gradient-success @break
                                                        @case('refunded') bg-gradient-info @break
                                                        @default bg-gradient-secondary
                                                    @endswitch
                                                ">
                                                    @switch($ticket->payment_status)
                                                        @case('unpaid') Chưa TT @break
                                                        @case('paid') Đã TT @break
                                                        @case('refunded') Hoàn tiền @break
                                                        @default {{ $ticket->payment_status }}
                                                    @endswitch
                                                </span>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.tickets.edit', $ticket->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $ticket->id,
                                                'route' => route('admin.tickets.destroy', $ticket->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa vé này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($tickets->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy vé nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $tickets->links('components.pagination') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
