@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('banner.edit_title') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('banner-home.update', $bannerHome->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="image">{{ __('banner.fields.image') }}</label>
                                    <input type="file" name="image" id="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        accept="image/jpeg,image/png,image/jpg,image/webp">
                                    <small class="text-muted">{{ __('banner.hints.image_edit') }}</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mt-3" id="image-preview-container">
                                    <p>{{ __('banner.current_image') }}:</p>
                                    <img src="{{ Storage::url($bannerHome->image) }}"
                                        alt="Current Banner"
                                        class="img-fluid rounded"
                                        style="max-width: 300px; max-height: 200px;">
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="status">{{ __('banner.fields.status') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1"
                                            {{ $bannerHome->status ? 'checked' : '' }}>
                                        <label class="form-check-label" for="status">
                                            <span id="status-text">
                                                {{ $bannerHome->status ? __('banner.status.active') : __('banner.status.inactive') }}
                                            </span>
                                        </label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="order">{{ __('banner.fields.order') }}</label>
                                    <input type="number" name="order" id="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', $bannerHome->order) }}" min="0">
                                    <small class="text-muted">{{ __('banner.hints.order') }}</small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">{{ __('form.buttons.update') }}</button>
                                <a href="{{ route('admin.banner-home.index') }}" class="btn btn-secondary">{{ __('form.buttons.back') }}</a>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Image preview
        const imageInput = document.getElementById('image');
        const imagePreviewContainer = document.getElementById('image-preview-container');

        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // Create a new image element for the new preview
                    const newPreview = document.createElement('div');
                    newPreview.classList.add('mt-3');
                    newPreview.innerHTML = `
                        <p>{{ __('banner.new_image') }}:</p>
                        <img src="${e.target.result}" alt="New Banner" class="img-fluid rounded" style="max-width: 300px; max-height: 200px;">
                    `;

                    // Replace the current preview if there's a "new" preview already
                    const existingNewPreview = document.querySelector('.mt-3 + .mt-3');
                    if (existingNewPreview) {
                        existingNewPreview.remove();
                    }

                    // Add the new preview after the current image preview
                    imagePreviewContainer.insertAdjacentElement('afterend', newPreview);
                }

                reader.readAsDataURL(this.files[0]);
            }
        });

        // Status toggle
        const statusCheckbox = document.getElementById('status');
        const statusText = document.getElementById('status-text');

        statusCheckbox.addEventListener('change', function() {
            if (this.checked) {
                statusText.textContent = "{{ __('banner.status.active') }}";
            } else {
                statusText.textContent = "{{ __('banner.status.inactive') }}";
            }
        });
    });
</script>
@endpush
