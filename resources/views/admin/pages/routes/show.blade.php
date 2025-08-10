@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Chi tiết tuyến đường</h5>
                        <div>
                            <a href="{{ route('admin.routes.edit', $route->id) }}" class="btn bg-gradient-primary btn-sm">
                                <i class="fa-solid fa-pencil"></i> Chỉnh sửa
                            </a>
                            <a href="{{ route('admin.routes.index') }}" class="btn btn-secondary btn-sm ms-2">
                                <i class="fa-solid fa-arrow-left"></i> Quay lại
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-4 p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Mã tuyến</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    <span class="badge badge-lg bg-gradient-info">{{ $route->code }}</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Trạng thái</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($route->is_active)
                                        <span class="badge badge-lg bg-gradient-success">Hoạt động</span>
                                    @else
                                        <span class="badge badge-lg bg-gradient-secondary">Không hoạt động</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tên tuyến</label>
                                <p class="text-lg font-weight-bold mb-0">{{ $route->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ga khởi hành</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-circle text-success me-2" style="font-size: 10px;"></i>
                                    <div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $route->departureStation->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $route->departureStation->administrativeUnit->country->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ga đến</label>
                                <div class="d-flex align-items-center">
                                    <i class="fa fa-circle text-danger me-2" style="font-size: 10px;"></i>
                                    <div>
                                        <p class="text-sm font-weight-bold mb-0">{{ $route->arrivalStation->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $route->arrivalStation->administrativeUnit->country->name }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Khoảng cách</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($route->distance_km)
                                        <span class="badge badge-sm bg-gradient-primary">{{ $route->distance_km }} km</span>
                                    @else
                                        <span class="text-secondary">Chưa có thông tin</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Thời gian ước tính</label>
                                <p class="text-sm font-weight-bold mb-0">
                                    @if($route->estimated_duration_minutes)
                                        <span class="badge badge-sm bg-gradient-secondary">
                                            {{ intval($route->estimated_duration_minutes / 60) }}h {{ $route->estimated_duration_minutes % 60 }}m
                                        </span>
                                    @else
                                        <span class="text-secondary">Chưa có thông tin</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Ngày tạo</label>
                                <p class="text-sm mb-0">{{ $route->created_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Cập nhật cuối</label>
                                <p class="text-sm mb-0">{{ $route->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Related Data Section -->
                    @if($route->trains->count() > 0 || $route->routeSegments->count() > 0)
                        <hr class="horizontal dark">
                        <h6 class="mb-3">Thông tin liên quan</h6>

                        @if($route->trains->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Tàu chạy trên tuyến này</label>
                                <div class="d-flex flex-wrap">
                                    @foreach($route->trains as $train)
                                        <span class="badge badge-sm bg-gradient-primary me-2 mb-2">
                                            {{ $train->train_number }} - {{ $train->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($route->routeSegments->count() > 0)
                            <div class="mb-3">
                                <label class="text-uppercase text-secondary text-xs font-weight-bolder">Đoạn tuyến</label>
                                <div class="table-responsive mt-2">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th class="text-xs">Ga đi</th>
                                                <th class="text-xs">Ga đến</th>
                                                <th class="text-xs">Khoảng cách</th>
                                                <th class="text-xs">Thời gian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($route->routeSegments->take(10) as $segment)
                                                <tr>
                                                    <td class="text-xs">{{ $segment->departureStation->name }}</td>
                                                    <td class="text-xs">{{ $segment->arrivalStation->name }}</td>
                                                    <td class="text-xs">
                                                        @if($segment->distance_km)
                                                            {{ $segment->distance_km }} km
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                    <td class="text-xs">
                                                        @if($segment->duration_minutes)
                                                            {{ intval($segment->duration_minutes / 60) }}h {{ $segment->duration_minutes % 60 }}m
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    @if($route->routeSegments->count() > 10)
                                        <p class="text-xs text-secondary">+{{ $route->routeSegments->count() - 10 }} đoạn tuyến khác</p>
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
