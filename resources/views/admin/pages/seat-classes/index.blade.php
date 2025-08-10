@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý hạng ghế</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.seat-classes.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm hạng ghế
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.seat-classes.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label for="search" class="text-xs text-secondary mb-0">Tìm kiếm</label>
                            <input type="text" class="form-control form-control-sm" id="search" name="search"
                                   placeholder="Tên hoặc mã hạng ghế..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="is_active" class="text-xs text-secondary mb-0">Trạng thái</label>
                            <select class="form-control form-control-sm" id="is_active" name="is_active">
                                <option value="">-- Tất cả --</option>
                                <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Hoạt động</option>
                                <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Không hoạt động</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>
                            @if(request()->hasAny(['search', 'is_active']))
                                <a href="{{ route('admin.seat-classes.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Hình ảnh</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên hạng ghế</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mô tả</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thứ tự</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($seatClasses as $key => $seatClass)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($seatClasses->currentPage() - 1) * $seatClasses->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            @if($seatClass->image)
                                                <img src="{{ asset($seatClass->image) }}" alt="{{ $seatClass->name }}" class="avatar avatar-sm me-3" style="object-fit: cover;">
                                            @else
                                                <div class="avatar avatar-sm me-3 bg-gradient-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fa fa-image text-white"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">
                                                <span class="badge badge-sm bg-gradient-info">{{ $seatClass->code }}</span>
                                            </p>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $seatClass->name }}</h6>
                                            </div>
                                        </td>
                                        <td>
                                            @if($seatClass->description)
                                                <p class="text-xs mb-0">{{ Str::limit($seatClass->description, 50) }}</p>
                                            @else
                                                <span class="text-xs text-secondary">Chưa có mô tả</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-gradient-primary">{{ $seatClass->sort_order ?? '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if($seatClass->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.seat-classes.show', $seatClass->id) }}" class="mx-3" title="Xem chi tiết">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.seat-classes.edit', $seatClass->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $seatClass->id,
                                                'route' => route('admin.seat-classes.destroy', $seatClass->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa hạng ghế này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($seatClasses->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy hạng ghế nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            {{ $seatClasses->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
