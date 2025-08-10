@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý quốc gia</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.countries.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2">
                                <i class="fa-solid fa-plus"></i> Thêm quốc gia
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.countries.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4 col-sm-6">
                            <label for="name_filter" class="text-xs text-secondary mb-0">Tên quốc gia</label>
                            <input type="text" class="form-control form-control-sm" id="name_filter" name="name"
                                   placeholder="Tìm kiếm tên..." value="{{ request('name') }}">
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label for="code_filter" class="text-xs text-secondary mb-0">Mã quốc gia</label>
                            <input type="text" class="form-control form-control-sm" id="code_filter" name="code"
                                   placeholder="VD: LAO, THA..." value="{{ request('code') }}">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Lọc
                            </button>
                            @if(request('name') || request('code'))
                                <a href="{{ route('admin.countries.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mã</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên quốc gia</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên địa phương</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tiền tệ</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Múi giờ</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($countries as $key => $country)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($countries->currentPage() - 1) * $countries->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">{{ $country->code }}</span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $country->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-secondary mb-0">{{ $country->local_name ?? '-' }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $country->currency_code }} ({{ $country->currency_symbol }})
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs text-secondary mb-0">{{ $country->timezone ?? '-' }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if($country->is_active)
                                                <span class="badge badge-sm bg-gradient-success">Hoạt động</span>
                                            @else
                                                <span class="badge badge-sm bg-gradient-secondary">Không hoạt động</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.countries.edit', $country->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $country->id,
                                                'route' => route('admin.countries.destroy', $country->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa quốc gia này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($countries->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy quốc gia nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            <x-pagination :paginator="$countries" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
