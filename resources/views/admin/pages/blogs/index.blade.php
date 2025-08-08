@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Quản lý Blog</h5>
                        </div>
                        <a href="{{ route('admin.blogs.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> Thêm Blog
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.components.success-error')

                    <!-- Search & Filter -->
                    <div class="px-3 py-3">
                        <form action="{{ route('admin.blogs.index') }}" method="GET" class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                                    <input type="text" name="title" class="form-control form-control-sm" placeholder="Tìm tiêu đề..."
                                           value="{{ request('title') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <select name="status" class="form-select form-select-sm" aria-label="Trạng thái">
                                    <option value="">Tất cả trạng thái</option>
                                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>
                                        Đã xuất bản
                                    </option>
                                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>
                                        Bản nháp
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="featured" class="form-select form-select-sm" aria-label="Nổi bật">
                                    <option value="">Tất cả</option>
                                    <option value="featured" {{ request('featured') == 'featured' ? 'selected' : '' }}>
                                        Nổi bật
                                    </option>
                                    <option value="not_featured" {{ request('featured') == 'not_featured' ? 'selected' : '' }}>
                                        Không nổi bật
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-sm btn-outline-secondary mb-0" type="submit">
                                    <i class="fa fa-search"></i> Lọc
                                </button>
                                @if(request()->hasAny(['title', 'status', 'featured']))
                                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary mb-0 ms-1">
                                        <i class="fa fa-times"></i>
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ảnh đại diện</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tiêu đề</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Slug</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nổi bật</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trạng thái</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Ngày xuất bản</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($blogs as $key => $blog)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $blogs->firstItem() + $key }}</p>
                                        </td>
                                        <td>
                                            @if($blog->featured_image)
                                                <img src="{{ asset('storage/' . $blog->featured_image) }}" alt="Ảnh đại diện" class="avatar avatar-sm me-3">
                                            @else
                                                <i class="fas fa-newspaper text-primary"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ Str::limit($blog->title, 50) }}</p>
                                            @if($blog->subtitle)
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($blog->subtitle, 40) }}</p>
                                            @endif
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $blog->slug }}</p>
                                        </td>
                                        <td class="text-center">
                                            @if($blog->is_featured)
                                                <span class="badge badge-sm bg-gradient-warning">
                                                    <i class="fa fa-star"></i> Nổi bật
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $blog->is_published ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                {{ $blog->is_published ? 'Đã xuất bản' : 'Bản nháp' }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ $blog->published_at ? $blog->published_at->format('d/m/Y') : '-' }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            @if($blog->is_published)
                                                <a href="{{ route('blogs.show', $blog->slug) }}" target="_blank" class="mx-2" title="Xem">
                                                    <i class="fa-solid fa-eye text-info"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('admin.blogs.edit', $blog->id) }}" class="mx-2" title="Sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $blog->id,
                                                'route' => route('admin.blogs.destroy', $blog->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa blog này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($blogs->count() == 0)
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy blog nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <div class="px-3">
                            <x-pagination :paginator="$blogs" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
