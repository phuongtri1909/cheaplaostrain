@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết hạng ghế</h5>
                        <div>
                            <a href="{{ route('admin.seat-classes.edit', $seatClass->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.seat-classes.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Mã hạng ghế</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-lg bg-gradient-info">{{ $seatClass->code }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($seatClass->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tên hạng ghế</label>
                                <p class="text-lg font-weight-bold mb-0">{{ $seatClass->name }}</p>
                            </div>
                        </div>
                        @if($seatClass->description)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Mô tả</label>
                                    <p class="text-sm mb-0">{{ $seatClass->description }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Thứ tự sắp xếp</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-sm bg-gradient-primary">{{ $seatClass->sort_order ?? '-' }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $seatClass->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        @if($seatClass->image)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Hình ảnh</label>
                                    <div class="mt-2">
                                        <img src="{{ asset($seatClass->image) }}" alt="{{ $seatClass->name }}" class="img-thumbnail" style="max-width: 300px; max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Related Data Section -->
                    @if($seatClass->trainSeatClasses->count() > 0 || $seatClass->segmentPrices->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Thông tin liên quan</h6>

                        @if($seatClass->trainSeatClasses->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tàu sử dụng hạng ghế này</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($seatClass->trainSeatClasses->unique('train_id') as $trainSeatClass)
                                        <span class="badge badge-sm bg-gradient-primary me-2 mb-2">
                                            {{ $trainSeatClass->train->train_number }} ({{ $trainSeatClass->total_seats }} ghế)
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
