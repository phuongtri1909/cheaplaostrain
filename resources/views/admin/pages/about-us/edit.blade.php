@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">Chỉnh sửa About Us</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.about-us.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Basic Information -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="title" class="form-label">Tiêu đề chính <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $aboutUs->title) }}" required placeholder="Tiêu đề trang About Us">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="subtitle" class="form-label">Phụ đề</label>
                                    <input type="text" name="subtitle" id="subtitle" class="form-control @error('subtitle') is-invalid @enderror"
                                        value="{{ old('subtitle', $aboutUs->subtitle) }}" placeholder="Phụ đề mô tả ngắn">
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="hero_image" class="form-label">Hình ảnh chính</label>
                                    <input type="file" name="hero_image" id="hero_image" class="form-control @error('hero_image') is-invalid @enderror"
                                        accept="image/*">
                                    @if($aboutUs->hero_image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $aboutUs->hero_image) }}" alt="Hero Image" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    @error('hero_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <div class="form-group">
                                    <label for="content" class="form-label">Nội dung chính <span class="text-danger">*</span></label>
                                    <textarea name="content" id="content"
                                        class="form-control @error('content') is-invalid @enderror" rows="5"
                                        required>{{ old('content', $aboutUs->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Mission, Vision, Values -->
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="mission_title" class="form-label">Tiêu đề Mission</label>
                                    <input type="text" name="mission_title" id="mission_title" class="form-control"
                                        value="{{ old('mission_title', $aboutUs->mission_title) }}" placeholder="Sứ mệnh">
                                </div>
                                <div class="form-group mt-2">
                                    <textarea name="mission_content" class="form-control" rows="3"
                                        placeholder="Nội dung sứ mệnh">{{ old('mission_content', $aboutUs->mission_content) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="vision_title" class="form-label">Tiêu đề Vision</label>
                                    <input type="text" name="vision_title" id="vision_title" class="form-control"
                                        value="{{ old('vision_title', $aboutUs->vision_title) }}" placeholder="Tầm nhìn">
                                </div>
                                <div class="form-group mt-2">
                                    <textarea name="vision_content" class="form-control" rows="3"
                                        placeholder="Nội dung tầm nhìn">{{ old('vision_content', $aboutUs->vision_content) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4 mb-3">
                                <div class="form-group">
                                    <label for="values_title" class="form-label">Tiêu đề Values</label>
                                    <input type="text" name="values_title" id="values_title" class="form-control"
                                        value="{{ old('values_title', $aboutUs->values_title) }}" placeholder="Giá trị">
                                </div>
                                <div class="form-group mt-2">
                                    <textarea name="values_content" class="form-control" rows="3"
                                        placeholder="Nội dung giá trị">{{ old('values_content', $aboutUs->values_content) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Features Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6>Tính năng nổi bật</h6>
                                <div id="features-container">
                                    @if($aboutUs->features)
                                        @foreach($aboutUs->features as $index => $feature)
                                            <div class="feature-item border p-3 mb-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="text" name="features[{{ $index }}][icon]" class="form-control mb-2"
                                                            value="{{ $feature['icon'] ?? 'fas fa-check' }}" placeholder="Icon class (VD: fas fa-check)">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="features[{{ $index }}][title]" class="form-control mb-2"
                                                            value="{{ $feature['title'] ?? '' }}" placeholder="Tiêu đề tính năng">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="features[{{ $index }}][description]" class="form-control mb-2"
                                                            value="{{ $feature['description'] ?? '' }}" placeholder="Mô tả tính năng">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm remove-feature">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-feature">Thêm tính năng</button>
                            </div>
                        </div>

                        <!-- Stats Section -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <h6>Thống kê</h6>
                                <div id="stats-container">
                                    @if($aboutUs->stats)
                                        @foreach($aboutUs->stats as $index => $stat)
                                            <div class="stat-item border p-3 mb-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <input type="text" name="stats[{{ $index }}][icon]" class="form-control mb-2"
                                                            value="{{ $stat['icon'] ?? 'fas fa-chart-line' }}" placeholder="Icon class">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input type="text" name="stats[{{ $index }}][number]" class="form-control mb-2"
                                                            value="{{ $stat['number'] ?? '' }}" placeholder="Số liệu (VD: 1000+)">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input type="text" name="stats[{{ $index }}][label]" class="form-control mb-2"
                                                            value="{{ $stat['label'] ?? '' }}" placeholder="Nhãn thống kê">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm remove-stat">Xóa</button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="add-stat">Thêm thống kê</button>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1"
                                        {{ old('is_active', $aboutUs->is_active) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Kích hoạt
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-center mt-4">
                            <button type="submit" class="btn bg-gradient-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script>
        CKEDITOR.replace('content', {
            height: 300,
            removePlugins: 'uploadimage,image2,uploadfile,filebrowser',
        });

        // Add Feature
        let featureIndex = {{ $aboutUs->features ? count($aboutUs->features) : 0 }};
        document.getElementById('add-feature').addEventListener('click', function() {
            const container = document.getElementById('features-container');
            const featureHtml = `
                <div class="feature-item border p-3 mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="features[${featureIndex}][icon]" class="form-control mb-2"
                                value="fas fa-check" placeholder="Icon class (VD: fas fa-check)">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="features[${featureIndex}][title]" class="form-control mb-2"
                                placeholder="Tiêu đề tính năng">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="features[${featureIndex}][description]" class="form-control mb-2"
                                placeholder="Mô tả tính năng">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-feature">Xóa</button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', featureHtml);
            featureIndex++;
        });

        // Remove Feature
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-feature')) {
                e.target.closest('.feature-item').remove();
            }
        });

        // Add Stat
        let statIndex = {{ $aboutUs->stats ? count($aboutUs->stats) : 0 }};
        document.getElementById('add-stat').addEventListener('click', function() {
            const container = document.getElementById('stats-container');
            const statHtml = `
                <div class="stat-item border p-3 mb-3">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="stats[${statIndex}][icon]" class="form-control mb-2"
                                value="fas fa-chart-line" placeholder="Icon class">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="stats[${statIndex}][number]" class="form-control mb-2"
                                placeholder="Số liệu (VD: 1000+)">
                        </div>
                        <div class="col-md-5">
                            <input type="text" name="stats[${statIndex}][label]" class="form-control mb-2"
                                placeholder="Nhãn thống kê">
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-stat">Xóa</button>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', statHtml);
            statIndex++;
        });

        // Remove Stat
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-stat')) {
                e.target.closest('.stat-item').remove();
            }
        });
    </script>
@endpush