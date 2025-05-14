<x-auth-layout>
    <form method="POST" action="{{ theme()->getPageUrl('password.confirm') }}" class="form w-100" novalidate="novalidate">
    @csrf
        <div class="text-center mb-10">
            <h1 class="text-dark mb-3">
                {{ __('Confirm Password') }}
            </h1>
            <div class="text-gray-400 fw-bold fs-4">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>
        </div>

        <div class="fv-row mb-10">
            <label class="form-label fw-bolder text-gray-900 fs-6">{{ __('Password') }}</label>
            <input class="form-control form-control-solid" type="password" name="password" autocomplete="current-password" required autofocus/>
        </div>

        <div class="d-flex flex-wrap justify-content-center pb-lg-0">
            <button type="submit" id="kt_password_reset_submit" class="btn btn-lg btn-primary fw-bolder me-4">
                @include('partials.general._button-indicator')
            </button>
            <a href="{{ theme()->getPageUrl('login') }}" class="btn btn-lg btn-light-primary fw-bolder">{{ __('Cancel') }}</a>
        </div>
    </form>
</x-auth-layout>
