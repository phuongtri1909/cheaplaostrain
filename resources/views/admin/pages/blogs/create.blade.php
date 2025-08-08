@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Tạo Blog mới</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="featured_image">Ảnh đại diện <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="file" name="featured_image" id="featured_image" class="form-control"
                                            accept="image/*" onchange="previewImage(this);">
                                    </div>
                                    <small class="text-muted">Chọn ảnh đại diện cho blog (JPG, PNG, JPEG, WebP)</small>

                                    <!-- Image preview -->
                                    <div id="image-preview-container" class="mt-3" style="display: none;">
                                        <div class="card">
                                            <div class="card-header p-2 d-flex justify-content-between align-items-center">
                                                <small class="text-muted">Xem trước ảnh</small>
                                                <button type="button" class="btn btn-sm btn-danger" onclick="clearImagePreview();">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="card-body p-2 text-center">
                                                <img id="image-preview" src="#" alt="Xem trước" class="img-fluid" style="max-height: 200px;">
                                            </div>
                                        </div>
                                    </div>

                                    @error('featured_image')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title">Tiêu đề <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title') }}" required placeholder="Nhập tiêu đề blog">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="subtitle">Phụ đề</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                                        value="{{ old('subtitle') }}" placeholder="Nhập phụ đề (tùy chọn)">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="author_name">Tên tác giả</label>
                                    <input type="text" name="author_name" id="author_name" class="form-control @error('author_name') is-invalid @enderror"
                                        value="{{ old('author_name') }}" placeholder="Nhập tên tác giả (tùy chọn)">
                                    <small class="text-muted">Để trống sẽ hiển thị "Admin"</small>
                                    @error('author_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    <label for="slug">URL Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror"
                                        value="{{ old('slug') }}" placeholder="Để trống để tự động tạo từ tiêu đề">
                                    <small class="text-muted">URL thân thiện SEO (vd: bai-viet-cua-toi). Để trống để tự động tạo từ tiêu đề.</small>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="form-group">
                                    <label for="content">Nội dung <span class="text-danger">*</span></label>
                                    <textarea name="content" id="content" class="form-control @error('content') is-invalid @enderror"
                                        rows="10" required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" checked
                                                value="1" {{ old('is_published', true) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_published">Xuất bản Blog</label>
                                            <small class="d-block text-muted">Bỏ tick để lưu dưới dạng bản nháp</small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured"
                                                value="1" {{ old('is_featured') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Blog nổi bật</label>
                                            <small class="d-block text-muted">Hiển thị trong danh sách blog nổi bật</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">Lưu Blog</button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">Quay lại</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        // Image preview functionality
        function previewImage(input) {
            var previewContainer = document.getElementById('image-preview-container');
            var preview = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewContainer.style.display = 'block';
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function clearImagePreview() {
            var previewContainer = document.getElementById('image-preview-container');
            var preview = document.getElementById('image-preview');
            var fileInput = document.getElementById('featured_image');

            preview.src = '';
            previewContainer.style.display = 'none';
            fileInput.value = '';
        }

        // Initialize CKEditor with upload functionality
                    CKEDITOR.replace('content', {
                filebrowserUploadUrl: "{{ route('admin.blogs.upload.image', ['_token' => csrf_token()]) }}",
                filebrowserUploadMethod: 'form',
                height: 400,
                toolbarGroups: [{
                        name: 'document',
                        groups: ['mode', 'document', 'doctools']
                    },
                    {
                        name: 'clipboard',
                        groups: ['clipboard', 'undo']
                    },
                    {
                        name: 'editing',
                        groups: ['find', 'selection', 'spellchecker', 'editing']
                    },
                    {
                        name: 'forms',
                        groups: ['forms']
                    },
                    {
                        name: 'basicstyles',
                        groups: ['basicstyles', 'cleanup']
                    },
                    {
                        name: 'paragraph',
                        groups: ['list', 'indent', 'blocks', 'align', 'paragraph']
                    },
                    {
                        name: 'links',
                        groups: ['links']
                    },
                    {
                        name: 'insert',
                        groups: ['insert']
                    },
                    {
                        name: 'styles',
                        groups: ['styles']
                    },
                    {
                        name: 'colors',
                        groups: ['colors']
                    },
                    {
                        name: 'tools',
                        groups: ['tools']
                    },
                    {
                        name: 'others',
                        groups: ['others']
                    }
                ],
                // Thêm tùy chọn cho kích thước, màu sắc và định dạng
                fontSize_sizes: '8/8px;9/9px;10/10px;11/11px;12/12px;14/14px;16/16px;18/18px;20/20px;22/22px;24/24px;26/26px;28/28px;36/36px;48/48px;72/72px',
                font_names: 'Arial/Arial, Helvetica, sans-serif;Times New Roman/Times New Roman, Times, serif;Verdana/Verdana, Geneva, sans-serif;Roboto/Roboto, sans-serif;Open Sans/Open Sans, sans-serif;Lato/Lato, sans-serif;Montserrat/Montserrat, sans-serif;',
                colorButton_colors: '000,800000,8B4513,2F4F4F,008080,000080,4B0082,696969,B22222,A52A2A,DAA520,006400,40E0D0,0000CD,800080,808080,F00,FF8C00,FFD700,008000,0FF,00F,EE82EE,A9A9A9,FFA07A,FFA500,FFFF00,00FF00,AFEEEE,ADD8E6,DDA0DD,D3D3D3,FFF0F5,FAEBD7,FFFFE0,F0FFF0,F0FFFF,F0F8FF,E6E6FA,FFF',
                colorButton_enableMore: true,
                colorButton_foreStyle: {
                    element: 'span',
                    styles: {
                        'color': '#(color)'
                    },
                    overrides: [{
                        element: 'font',
                        attributes: {
                            'color': null
                        }
                    }]
                },
                colorButton_backStyle: {
                    element: 'span',
                    styles: {
                        'background-color': '#(color)'
                    }
                },
                // Cấu hình để thêm các plugin chèn ảnh nâng cao
                extraPlugins: 'uploadimage,clipboard,pastetext,font,colorbutton,justify,image2',
                uploadUrl: "{{ route('admin.blogs.upload.image', ['_token' => csrf_token()]) }}",

                // Hỗ trợ xử lý clipboard và paste ảnh
                clipboard_handleImages: true,
                pasteFilter: null,
                pasteUploadFileApi: "{{ route('admin.blogs.upload.image', ['_token' => csrf_token()]) }}",
                allowedContent: true,

                // Cấu hình xử lý hình ảnh
                image_previewText: ' ',
                image2_alignClasses: ['image-align-left', 'image-align-center', 'image-align-right'],
                image2_disableResizer: false,

                // Danh sách nút sẽ loại bỏ
                removeButtons: 'About,Scayt,Anchor',

                // Cấu hình chỉnh sửa hình ảnh nâng cao
                image2_prefillDimensions: true,
                image2_captionedClass: 'image-captioned',

                // Kích thước mặc định cho ảnh đặt vào
                imageUploadUrl: "{{ route('admin.blogs.upload.image', ['_token' => csrf_token()]) }}",
                imageUploadMethod: 'form',
                filebrowserImageUploadUrl: "{{ route('admin.blogs.upload.image', ['_token' => csrf_token()]) }}"
            });

            // CKEditor events để cập nhật dữ liệu khi submit form
            CKEDITOR.instances.content.on('change', function() {
                this.updateElement();
            });

        // Auto-generate slug from title
        document.getElementById('title').addEventListener('blur', function() {
            const slugField = document.getElementById('slug');
            if (slugField.value === '') {
                const titleValue = this.value.trim();
                if (titleValue) {
                    // Convert to slug
                    const slugValue = titleValue
                        .toLowerCase()
                        .normalize('NFD')
                        .replace(/[\u0300-\u036f]/g, '')
                        .replace(/đ/g, 'd')
                        .replace(/Đ/g, 'D')
                        .replace(/\s+/g, '-')
                        .replace(/[^\w\-]+/g, '')
                        .replace(/\-\-+/g, '-')
                        .replace(/^-+/, '')
                        .replace(/-+$/, '');

                    slugField.value = slugValue;
                }
            }
        });
    </script>
@endpush
