@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('social.create_title') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('socials.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="platform">{{ __('social.fields.name') }}</label>
                                    <input type="text" name="platform" id="platform"
                                        class="form-control @error('platform') is-invalid @enderror"
                                        value="{{ old('platform') }}" required>
                                    <small class="text-muted">{{ __('social.hints.name') }}</small>
                                    @error('platform')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="icon">{{ __('social.fields.icon') }}</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i id="icon-preview"></i></span>
                                        <input type="text" name="icon" id="icon"
                                            class="form-control @error('icon') is-invalid @enderror"
                                            value="{{ old('icon') }}" required>
                                    </div>
                                    <small class="text-muted">{{ __('social.hints.icon') }}</small>
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="url">{{ __('social.fields.url') }}</label>
                                    <input type="url" name="url" id="url"
                                        class="form-control @error('url') is-invalid @enderror"
                                        value="{{ old('url') }}" required>
                                    <small class="text-muted">{{ __('social.hints.url') }}</small>
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="order">{{ __('social.fields.order') }}</label>
                                    <input type="number" name="order" id="order"
                                        class="form-control @error('order') is-invalid @enderror"
                                        value="{{ old('order', 0) }}" min="0">
                                    <small class="text-muted">{{ __('social.hints.order') }}</small>
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="status">{{ __('social.fields.status') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="status" value="0">
                                        <input class="form-check-input" type="checkbox" id="status" name="status" value="1" checked>
                                        <label class="form-check-label" for="status">
                                            <span id="status-text">{{ __('social.status.active') }}</span>
                                        </label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">{{ __('form.buttons.save') }}</button>
                                <a href="{{ route('admin.socials.index') }}" class="btn btn-secondary">{{ __('form.buttons.back') }}</a>
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
        // Icon preview
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('icon-preview');

        function updateIconPreview() {
            iconPreview.className = iconInput.value || 'fas fa-link';
        }

        iconInput.addEventListener('input', updateIconPreview);
        updateIconPreview();

        // Status toggle
        const statusCheckbox = document.getElementById('status');
        const statusText = document.getElementById('status-text');

        statusCheckbox.addEventListener('change', function() {
            if (this.checked) {
                statusText.textContent = "{{ __('social.status.active') }}";
            } else {
                statusText.textContent = "{{ __('social.status.inactive') }}";
            }
        });
    });
</script>
@endpush
