@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-0 mx-md-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Danh mục câu hỏi thường gặp</h5>
                        </div>
                        <a href="{{ route('admin.faq-categories.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> Thêm danh mục
                        </a>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.faq-categories.index') }}" method="GET" class="row g-3 align-items-center">
                        <div class="col-md-4 col-sm-6">
                            <label for="name_filter" class="text-xs text-secondary mb-0">Tên danh mục</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="name_filter" name="name"
                                       placeholder="Tìm kiếm danh mục..." value="{{ request('name') }}">
                                <button class="btn btn-outline-secondary mb-0" type="submit">
                                    <i class="fa fa-search"></i>
                                </button>
                                @if(request('name'))
                                    <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-outline-secondary mb-0">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thứ tự</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tên danh mục</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Slug</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Số câu hỏi</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $key => $category)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($categories->currentPage() - 1) * $categories->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">{{ $category->order }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $category->name }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $category->slug }}</p>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-gradient-info">{{ $category->faqs_count }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-sm bg-gradient-{{ $category->is_active ? 'success' : 'secondary' }}">
                                                {{ $category->is_active ? 'Hoạt động' : 'Không hoạt động' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.faq-categories.edit', $category->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $category->id,
                                                'route' => route('admin.faq-categories.destroy', $category->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa danh mục này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($categories->count() == 0)
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy danh mục nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            <x-pagination :paginator="$categories" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
