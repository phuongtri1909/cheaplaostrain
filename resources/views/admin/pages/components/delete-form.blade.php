<form id="formDelete{{ $id }}" method="post" action="{{ $route }}" data-id="{{ $id }}">
    @csrf
    @method('DELETE')
    <button type="button" class="btn_delete border-0 bg-transparent p-0" 
            title="{{ $title ?? __('form.buttons.delete') }}"
            data-id="{{ $id }}">
        <i class="fa-solid fa-trash text-danger"></i>
    </button>
</form>

<!-- Each modal has unique ID based on item ID -->
<div class="modal fade" id="deleteModal{{ $id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel{{ $id }}">{{ __('messages.confirm.delete.title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ isset($message) ? $message : __('messages.confirm.delete.title') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary text-dark" 
                        data-bs-dismiss="modal">{{ __('messages.confirm.cancel') }}</button>
                <button type="button" class="btn btn-danger confirm-delete" 
                        data-id="{{ $id }}">{{ __('form.buttons.delete') }}</button>
            </div>
        </div>
    </div>
</div>

@push('scripts-admin')
    <script>
        $('.btn_delete').click(function() {
            var id = $(this).data('id');
            $('#deleteModal' + id).modal('show');

            var formId = $(this).closest('form').attr('id');

            $('#deleteModal' + id + ' .confirm-delete').click(function() {
                $('#' + formId).submit();
            });
        });
    </script>
@endpush
