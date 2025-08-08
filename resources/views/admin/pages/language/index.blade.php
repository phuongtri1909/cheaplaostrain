@extends('admin.layouts.app')

@push('styles-admin')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/monokai.min.css">
    <style>
        .CodeMirror {
            height: 600px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .language-card {
            height: 100%;
        }
        .editor-header {
            background: #f8f9fa;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-bottom: none;
            border-radius: 4px 4px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .save-btn {
            transition: all 0.3s ease;
        }
        .save-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endpush

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ __('language.management') }}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card language-card">
                                <div class="editor-header">
                                    <h6 class="mb-0">English (en.json)</h6>
                                    <button type="button" class="btn btn-primary btn-sm save-btn" 
                                            id="saveEn" disabled>
                                        <i class="fas fa-save"></i> {{ __('form.buttons.save') }}
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <textarea id="enEditor">{{ $enContent }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card language-card">
                                <div class="editor-header">
                                    <h6 class="mb-0">Vietnamese (vi.json)</h6>
                                    <button type="button" class="btn btn-primary btn-sm save-btn" 
                                            id="saveVi" disabled>
                                        <i class="fas fa-save"></i> {{ __('form.buttons.save') }}
                                    </button>
                                </div>
                                <div class="card-body p-0">
                                    <textarea id="viEditor">{{ $viContent }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-admin')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/javascript/javascript.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize English editor
            const enEditor = CodeMirror.fromTextArea(document.getElementById('enEditor'), {
                mode: { name: 'javascript', json: true },
                theme: 'monokai',
                lineNumbers: true,
                matchBrackets: true,
                autoCloseBrackets: true,
                indentUnit: 4,
                tabSize: 4,
                lineWrapping: true,
                foldGutter: true,
                gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
                extraKeys: { 'Ctrl-Space': 'autocomplete' }
            });

            // Initialize Vietnamese editor
            const viEditor = CodeMirror.fromTextArea(document.getElementById('viEditor'), {
                mode: { name: 'javascript', json: true },
                theme: 'monokai',
                lineNumbers: true,
                matchBrackets: true,
                autoCloseBrackets: true,
                indentUnit: 4,
                tabSize: 4,
                lineWrapping: true,
                foldGutter: true,
                gutters: ['CodeMirror-linenumbers', 'CodeMirror-foldgutter'],
                extraKeys: { 'Ctrl-Space': 'autocomplete' }
            });

            // Save buttons
            const saveEn = document.getElementById('saveEn');
            const saveVi = document.getElementById('saveVi');

            // Track changes
            enEditor.on('change', () => saveEn.disabled = false);
            viEditor.on('change', () => saveVi.disabled = false);

            // Save handlers
            saveEn.addEventListener('click', () => saveLanguageFile('en', enEditor.getValue()));
            saveVi.addEventListener('click', () => saveLanguageFile('vi', viEditor.getValue()));

            function saveLanguageFile(locale, content) {
                fetch(`{{ route('admin.languages.update') }}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ locale, content })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Language file has been updated successfully!');
                        document.getElementById(`save${locale.charAt(0).toUpperCase() + locale.slice(1)}`).disabled = true;
                    } else {
                        showToast('Something went wrong!', data.message);
                    }
                })
                .catch(error => {
                    showToast('Something went wrong!', error.message);
                });
            }
        });
    </script>
@endpush