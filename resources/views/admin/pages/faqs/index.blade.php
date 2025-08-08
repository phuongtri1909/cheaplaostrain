@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">Câu hỏi thường gặp</h5>
                        </div>
                        <div>
                            <a href="{{ route('admin.faq-categories.index') }}" class="btn btn-outline-primary btn-sm mb-0 me-2">
                                <i class="fa-solid fa-list"></i> Quản lý danh mục
                            </a>
                            <a href="{{ route('admin.faqs.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                                <i class="fa-solid fa-plus"></i> Thêm câu hỏi
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Filter Section -->
                <div class="card-header pb-0">
                    <form action="{{ route('admin.faqs.index') }}" method="GET" class="row g-3 align-items-end">
                        <div class="col-md-4 col-sm-6">
                            <label for="question_filter" class="text-xs text-secondary mb-0">Câu hỏi</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control" id="question_filter" name="question"
                                       placeholder="Tìm kiếm câu hỏi..." value="{{ request('question') }}">
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label for="category_filter" class="text-xs text-secondary mb-0">Danh mục</label>
                            <select class="form-control form-control-sm" id="category_filter" name="category_id">
                                <option value="">Tất cả danh mục</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-outline-secondary btn-sm mb-0" type="submit">
                                <i class="fa fa-search"></i> Lọc
                            </button>
                            @if(request('question') || request('category_id'))
                                <a href="{{ route('admin.faqs.index') }}" class="btn btn-outline-secondary btn-sm mb-0 ms-1">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
                <!-- End Filter Section -->

                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.components.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STT</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Danh mục</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thứ tự</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Câu hỏi</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Câu trả lời</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $key => $faq)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ ($faqs->currentPage() - 1) * $faqs->perPage() + $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">
                                                @if($faq->faqCategory)
                                                    <span class="badge badge-sm bg-gradient-info">
                                                        {{ $faq->faqCategory->name }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">Không có danh mục</span>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0 ps-3">{{ $faq->order }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ Str::limit($faq->question, 50) }}</p>
                                        </td>
                                        <td class="text-center">
                                            <p class="text-xs font-weight-bold mb-0">
                                                {{ cleanDescription($faq->answer, 300) }}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="mx-3" title="Chỉnh sửa">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $faq->id,
                                                'route' => route('admin.faqs.destroy', $faq->id),
                                                'title' => 'Xóa',
                                                'message' => 'Bạn có chắc chắn muốn xóa câu hỏi này?'
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if($faqs->count() == 0)
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">Không tìm thấy câu hỏi nào</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="px-3">
                            <x-pagination :paginator="$faqs" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
