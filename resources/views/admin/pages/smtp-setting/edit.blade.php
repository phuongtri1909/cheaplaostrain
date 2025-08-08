<!-- filepath: d:\fociloans\resources\views\admin\pages\smtp-setting\edit.blade.php -->
@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4 mx-4">
                <div class="card-header pb-0 px-3">
                    <h5 class="mb-0">{{ __('smtp.title') }}</h5>
                </div>
                <div class="card-body pt-4 p-3">
                    @include('admin.pages.components.success-error')

                    <form action="{{ route('admin.smtp-settings.update') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="host">{{ __('smtp.fields.host') }}</label>
                                    <input type="text" name="host" id="host"
                                        class="form-control @error('host') is-invalid @enderror"
                                        value="{{ old('host', $smtpSetting->host) }}" required>
                                    <small class="text-muted">{{ __('smtp.hints.host') }}</small>
                                    @error('host')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="port">{{ __('smtp.fields.port') }}</label>
                                    <input type="number" name="port" id="port"
                                        class="form-control @error('port') is-invalid @enderror"
                                        value="{{ old('port', $smtpSetting->port) }}" required>
                                    <small class="text-muted">{{ __('smtp.hints.port') }}</small>
                                    @error('port')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="username">{{ __('smtp.fields.username') }}</label>
                                    <input type="text" name="username" id="username"
                                        class="form-control @error('username') is-invalid @enderror"
                                        value="{{ old('username', $smtpSetting->username) }}" required>
                                    <small class="text-muted">{{ __('smtp.hints.username') }}</small>
                                    @error('username')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="password">{{ __('smtp.fields.password') }}</label>
                                    <input type="password" name="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        value="{{ old('password', $smtpSetting->password) }}" required>
                                    <small class="text-muted">{{ __('smtp.hints.password') }}</small>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="encryption">{{ __('smtp.fields.encryption') }}</label>
                                    <select name="encryption" id="encryption"
                                        class="form-control @error('encryption') is-invalid @enderror" required>
                                        <option value="tls" {{ old('encryption', $smtpSetting->encryption) == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ old('encryption', $smtpSetting->encryption) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    </select>
                                    <small class="text-muted">{{ __('smtp.hints.encryption') }}</small>
                                    @error('encryption')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="is_active">{{ __('smtp.fields.status') }}</label>
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="is_active" id="is_active"
                                            class="form-check-input" value="1"
                                            {{ old('is_active', $smtpSetting->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_active">
                                            <span id="status-text">
                                                {{ $smtpSetting->is_active ? __('smtp.status.active') : __('smtp.status.inactive') }}
                                            </span>
                                        </label>
                                    </div>
                                    <small class="text-muted">{{ __('smtp.hints.status') }}</small>
                                    @error('is_active')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="from_address">{{ __('smtp.fields.from_address') }}</label>
                                    <input type="email" name="from_address" id="from_address"
                                        class="form-control @error('from_address') is-invalid @enderror"
                                        value="{{ old('from_address', $smtpSetting->from_address) }}" required>
                                    <small class="text-muted">{{ __('smtp.hints.from_address') }}</small>
                                    @error('from_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="from_name">{{ __('smtp.fields.from_name') }}</label>
                                    <input type="text" name="from_name" id="from_name"
                                        class="form-control @error('from_name') is-invalid @enderror"
                                        value="{{ old('from_name', $smtpSetting->from_name) }}" required>
                                    <small class="text-muted">{{ __('smtp.hints.from_name') }}</small>
                                    @error('from_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Admin Email Field -->
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="admin_email">Mail nhận thông báo</label>
                                    <input type="email" name="admin_email" id="admin_email"
                                        class="form-control @error('admin_email') is-invalid @enderror"
                                        value="{{ old('admin_email', $smtpSetting->admin_email) }}">
                                    <small class="text-muted">Mail nhận thông báo</small>
                                    @error('admin_email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label>{{ __('smtp.test.title') }}</label>
                                    <div class="input-group">
                                        <input type="email" id="test_email"
                                            class="form-control"
                                            placeholder="{{ __('smtp.test.placeholder') }}">
                                        <button type="button" id="send_test_btn" class="btn btn-primary mb-0">
                                            {{ __('smtp.test.button') }}
                                        </button>
                                    </div>
                                    <small class="text-muted">{{ __('smtp.test.hint') }}</small>
                                    <div id="test_result" class="mt-2"></div>
                                </div>
                            </div>

                            <div class="col-md-12 text-center mt-4">
                                <button type="submit" class="btn bg-gradient-primary">{{ __('form.buttons.save') }}</button>
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
        // Status toggle
        const statusCheckbox = document.getElementById('is_active');
        const statusText = document.getElementById('status-text');

        statusCheckbox.addEventListener('change', function() {
            if (this.checked) {
                statusText.textContent = "{{ __('smtp.status.active') }}";
            } else {
                statusText.textContent = "{{ __('smtp.status.inactive') }}";
            }
        });

        // Test email
        const sendTestBtn = document.getElementById('send_test_btn');
        const testEmailInput = document.getElementById('test_email');
        const testResult = document.getElementById('test_result');

        sendTestBtn.addEventListener('click', function() {
            const email = testEmailInput.value.trim();

            if (!email) {
                testResult.innerHTML = '<div class="alert alert-danger">{{ __("smtp.test.email_required") }}</div>';
                return;
            }

            // Disable button and show loading
            sendTestBtn.disabled = true;
            sendTestBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> {{ __("smtp.test.sending") }}';

            // Send test email
            fetch('{{ route("admin.smtp-settings.test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ test_email: email })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    testResult.innerHTML = '<div class="alert alert-success">' + data.message + '</div>';
                } else {
                    testResult.innerHTML = '<div class="alert alert-danger">' + data.message + '</div>';
                }
            })
            .catch(error => {
                testResult.innerHTML = '<div class="alert alert-danger">{{ __("smtp.test.error") }}</div>';
            })
            .finally(() => {
                // Re-enable button
                sendTestBtn.disabled = false;
                sendTestBtn.innerHTML = '{{ __("smtp.test.button") }}';
            });
        });
    });
</script>
@endpush
