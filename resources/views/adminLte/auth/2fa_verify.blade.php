@extends('adminLte.auth.layout')

@section('pageTitle', '2 Factor Authentication')

@section('content')
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4 rounded" style="max-width: 400px; width: 100%;">
        <div class="card-body text-center">
            <h2 class="text-primary fw-bold">🔒 Two-Factor Authentication</h2>
            <p class="text-muted">Enter the verification code from Google Authenticator.</p>

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>❌ Error:</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('2fa.verify.post') }}" class="mt-3">
                @csrf
                <div class="mb-3">
                    <label for="otp" class="form-label fw-semibold">Authentication Code</label>
                    <input type="text" class="form-control text-center fs-4 py-2 border-primary"
                           name="otp" required minlength="6" maxlength="6" placeholder="●●●●●●">
                </div>
                <button type="submit" class="btn btn-lg btn-primary w-100 fw-bold">✅ Verify</button>
            </form>

            <div class="mt-3">
                <small class="text-muted">Lost access? <a href="#" class="text-decoration-none">Use recovery codes</a></small>
            </div>
        </div>
    </div>
</div>
@endsection
