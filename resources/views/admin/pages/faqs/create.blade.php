@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo câu hỏi thường gặp</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.faqs.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="faq_category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                                    <select name="faq_category_id" id="faq_category_id" class="form-control @error('faq_category_id') is-invalid @enderror" required>
                                        <option value="">Chọn danh mục</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('faq_category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('faq_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="order" class="form-label">Thứ tự</label>
                                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', 0) }}" min="0" placeholder="Thứ tự hiển thị">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Số thứ tự để sắp xếp câu hỏi</small>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="question">Câu hỏi <span class="text-danger">*</span></label>
                                    <textarea name="question" id="question"
                                        class="form-control @error('question') is-invalid @enderror" rows="3"
                                        required placeholder="Nhập câu hỏi">{{ old('question') }}</textarea>
                                    @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="answer">Câu trả lời <span class="text-danger">*</span></label>
                                    <textarea name="answer" id="answer"
                                        class="form-control @error('answer') is-invalid @enderror" rows="5"
                                        required>{{ old('answer') }}</textarea>
                                    @error('answer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Lưu</button>
                                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles-admin')
    <link href="{{ asset('assets/libs/ckeditor/contents.css') }}" rel="stylesheet">
@endpush

@push('scripts-admin')
    <script>
        CKEDITOR.replace('answer', {
            on: {
                change: function(evt) {
                    this.updateElement();
                }
            },
            height: 200,
            removePlugins: 'uploadimage,image2,uploadfile,filebrowser',
        });
    </script>
@endpush
