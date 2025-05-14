{{-- Flash Message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show m-3 border-left border-success border-left-wide" role="alert">
        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
{{-- End Flash Message --}}