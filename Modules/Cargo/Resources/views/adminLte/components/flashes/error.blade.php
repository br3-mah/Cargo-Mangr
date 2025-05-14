{{-- Flash Message --}}
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-3 border-left border-danger border-left-wide" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{-- End Flash Message --}}