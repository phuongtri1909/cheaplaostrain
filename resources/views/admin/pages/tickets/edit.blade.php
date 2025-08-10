@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Chỉnh sửa vé</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.tickets.update', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="ticket_number" class="form-label">Mã vé</label>
                                    <input type="text" name="ticket_number" id="ticket_number" class="form-control @error('ticket_number') is-invalid @enderror"
                                        value="{{ old('ticket_number', $ticket->ticket_number) }}" placeholder="Tự động tạo nếu để trống">
                                    @error('ticket_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="travel_date" class="form-label">Ngày đi <span class="text-danger">*</span></label>
                                    <input type="date" name="travel_date" id="travel_date" class="form-control @error('travel_date') is-invalid @enderror"
                                        value="{{ old('travel_date', $ticket->travel_date?->format('Y-m-d')) }}" required>
                                    @error('travel_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="schedule_id" class="form-label">Lịch trình <span class="text-danger">*</span></label>
                                    <select name="schedule_id" id="schedule_id" class="form-control @error('schedule_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn lịch trình --</option>
                                        @foreach($schedules as $schedule)
                                            <option value="{{ $schedule->id }}" {{ old('schedule_id', $ticket->schedule_id) == $schedule->id ? 'selected' : '' }}>
                                                {{ $schedule->train->train_number ?? 'N/A' }} - {{ $schedule->departure_time }} → {{ $schedule->arrival_time }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('schedule_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="train_id" class="form-label">Tàu <span class="text-danger">*</span></label>
                                    <select name="train_id" id="train_id" class="form-control @error('train_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn tàu --</option>
                                        @foreach($trains as $train)
                                            <option value="{{ $train->id }}" {{ old('train_id', $ticket->train_id) == $train->id ? 'selected' : '' }}>
                                                {{ $train->train_number }} - {{ $train->operator }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('train_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="route_id" class="form-label">Tuyến đường <span class="text-danger">*</span></label>
                                    <select name="route_id" id="route_id" class="form-control @error('route_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn tuyến đường --</option>
                                        @foreach($routes as $route)
                                            <option value="{{ $route->id }}" {{ old('route_id', $ticket->route_id) == $route->id ? 'selected' : '' }}>
                                                {{ $route->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('route_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="route_segment_id" class="form-label">Đoạn tuyến</label>
                                    <select name="route_segment_id" id="route_segment_id" class="form-control @error('route_segment_id') is-invalid @enderror">
                                        <option value="">-- Chọn đoạn tuyến --</option>
                                        @foreach($routeSegments as $segment)
                                            <option value="{{ $segment->id }}" {{ old('route_segment_id', $ticket->route_segment_id) == $segment->id ? 'selected' : '' }}>
                                                {{ $segment->originStation->name ?? 'N/A' }} → {{ $segment->destinationStation->name ?? 'N/A' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('route_segment_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="seat_class_id" class="form-label">Hạng ghế <span class="text-danger">*</span></label>
                                    <select name="seat_class_id" id="seat_class_id" class="form-control @error('seat_class_id') is-invalid @enderror" required>
                                        <option value="">-- Chọn hạng ghế --</option>
                                        @foreach($seatClasses as $seatClass)
                                            <option value="{{ $seatClass->id }}" {{ old('seat_class_id', $ticket->seat_class_id) == $seatClass->id ? 'selected' : '' }}>
                                                {{ $seatClass->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('seat_class_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="seat_number" class="form-label">Số ghế</label>
                                    <input type="text" name="seat_number" id="seat_number" class="form-control @error('seat_number') is-invalid @enderror"
                                        value="{{ old('seat_number', $ticket->seat_number) }}" placeholder="VD: A01, B15">
                                    @error('seat_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="passenger_name" class="form-label">Tên hành khách <span class="text-danger">*</span></label>
                                    <input type="text" name="passenger_name" id="passenger_name" class="form-control @error('passenger_name') is-invalid @enderror"
                                        value="{{ old('passenger_name', $ticket->passenger_name) }}" placeholder="Họ và tên đầy đủ" required>
                                    @error('passenger_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="passenger_email" class="form-label">Email hành khách</label>
                                    <input type="email" name="passenger_email" id="passenger_email" class="form-control @error('passenger_email') is-invalid @enderror"
                                        value="{{ old('passenger_email', $ticket->passenger_email) }}" placeholder="email@example.com">
                                    @error('passenger_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="price" class="form-label">Giá vé <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="price" id="price" class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price', $ticket->price) }}" placeholder="0.00" min="0" required>
                                    @error('price')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="currency" class="form-label">Tiền tệ</label>
                                    <input type="text" name="currency" id="currency" class="form-control @error('currency') is-invalid @enderror"
                                        value="{{ old('currency', $ticket->currency) }}" placeholder="LAK">
                                    @error('currency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="booking_status" class="form-label">Trạng thái đặt vé <span class="text-danger">*</span></label>
                                    <select name="booking_status" id="booking_status" class="form-control @error('booking_status') is-invalid @enderror" required>
                                        <option value="pending" {{ old('booking_status', $ticket->booking_status) == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                        <option value="confirmed" {{ old('booking_status', $ticket->booking_status) == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                        <option value="cancelled" {{ old('booking_status', $ticket->booking_status) == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                                    </select>
                                    @error('booking_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_status" class="form-label">Trạng thái thanh toán <span class="text-danger">*</span></label>
                                    <select name="payment_status" id="payment_status" class="form-control @error('payment_status') is-invalid @enderror" required>
                                        <option value="unpaid" {{ old('payment_status', $ticket->payment_status) == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                                        <option value="paid" {{ old('payment_status', $ticket->payment_status) == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                                        <option value="refunded" {{ old('payment_status', $ticket->payment_status) == 'refunded' ? 'selected' : '' }}>Đã hoàn tiền</option>
                                    </select>
                                    @error('payment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                                    <input type="text" name="payment_method" id="payment_method" class="form-control @error('payment_method') is-invalid @enderror"
                                        value="{{ old('payment_method', $ticket->payment_method) }}" placeholder="VD: Cash, Credit Card, Bank Transfer">
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="payment_reference" class="form-label">Mã tham chiếu thanh toán</label>
                                    <input type="text" name="payment_reference" id="payment_reference" class="form-control @error('payment_reference') is-invalid @enderror"
                                        value="{{ old('payment_reference', $ticket->payment_reference) }}" placeholder="Transaction ID">
                                    @error('payment_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="booked_at" class="form-label">Thời gian đặt</label>
                                    <input type="datetime-local" name="booked_at" id="booked_at" class="form-control @error('booked_at') is-invalid @enderror"
                                        value="{{ old('booked_at', $ticket->booked_at?->format('Y-m-d\TH:i')) }}">
                                    @error('booked_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="expires_at" class="form-label">Thời gian hết hạn</label>
                                    <input type="datetime-local" name="expires_at" id="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                        value="{{ old('expires_at', $ticket->expires_at?->format('Y-m-d\TH:i')) }}">
                                    @error('expires_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="ip_address" class="form-label">Địa chỉ IP</label>
                                    <input type="text" name="ip_address" id="ip_address" class="form-control @error('ip_address') is-invalid @enderror"
                                        value="{{ old('ip_address', $ticket->ip_address) }}" placeholder="IP Address">
                                    @error('ip_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Cập nhật</button>
                                <a href="{{ route('admin.tickets.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
