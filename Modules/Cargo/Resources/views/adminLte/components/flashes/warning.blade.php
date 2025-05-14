@if(session('warning'))
    <div class="alert alert-warning alert-dismissible fade show m-3 border-left border-warning border-left-wide" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('warning') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{-- End Flash Message --}}