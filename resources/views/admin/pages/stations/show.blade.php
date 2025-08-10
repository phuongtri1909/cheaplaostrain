@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết ga tàu</h5>
                        <div>
                            <a href="{{ route('admin.stations.edit', $station->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Mã ga</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-lg bg-gradient-info">{{ $station->code }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($station->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tên ga</label>
                                <p class="text-lg font-weight-bold mb-0">{{ $station->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Vị trí hành chính</label>
                                <p class="text-sm font-weight-bold mb-0">{{ $station->getFullLocationPath() }}</p>
                                <p class="text-xs text-secondary mb-0">Quốc gia: {{ $station->administrativeUnit->country->name }}</p>
                            </div>
                        </div>
                        @if($station->address)
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Địa chỉ</label>
                                    <p class="text-sm mb-0">{{ $station->address }}</p>
                                </div>
                            </div>
                        @endif
                        @if($station->latitude && $station->longitude)
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Vĩ độ</label>
                                    <p class="text-sm font-weight-bold mb-0">{{ $station->latitude }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="text-uppercase text-secondary text-xs font-weight-bolder">Kinh độ</label>
                                    <p class="text-sm font-weight-bold mb-0">{{ $station->longitude }}</p>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $station->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật lần cuối</label>
                                <p class="text-sm mb-0">{{ $station->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Data Section -->
                    @if($station->trainStops->count() > 0 || $station->departureRoutes->count() > 0 || $station->arrivalRoutes->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Thông tin liên quan</h6>

                        @if($station->trainStops->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tàu dừng tại ga này</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($station->trainStops->unique('train_id') as $trainStop)
                                        <span class="badge badge-sm bg-gradient-primary me-2 mb-2">
                                            {{ $trainStop->train->train_number }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($station->departureRoutes->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tuyến khởi hành</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($station->departureRoutes as $route)
                                        <span class="badge badge-sm bg-gradient-success me-2 mb-2">
                                            {{ $route->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($station->arrivalRoutes->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tuyến đến</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($station->arrivalRoutes as $route)
                                        <span class="badge badge-sm bg-gradient-warning me-2 mb-2">
                                            {{ $route->name }}
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
