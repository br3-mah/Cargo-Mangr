@extends('adminLte.auth.layout')
@include('cargo::adminLte.components.inputs.phone')
@section('pageTitle')
    {{ __('Sign In') }}
@endsection
@section('content')
<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
        <a href="{{ url('/') }}" class="mb-12">
          @php
              $model = App\Models\Settings::where('group', 'general')->where('name','login_page_logo')->first();
              $system_logo = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
          @endphp
          <img alt="Logo" src="{{ $model->getFirstMediaUrl('login_page_logo') ? $model->getFirstMediaUrl('login_page_logo') : ( $system_logo->getFirstMediaUrl('system_logo') ? $system_logo->getFirstMediaUrl('system_logo') : asset('assets/lte/cargo-logo.svg') ) }}" style="max-width: 150px;max-height: 100px;" />
        </a>
    </div>
    <div class="card-body">
      <h3 class="widget-title">{{ __('cargo::view.create_a_new_account') }}</h3>
      <form method="POST" action="{{ route('register.request') }}" novalidate="novalidate" id="kt_sign_in_form">
        @csrf
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user"></i></span>
            </div>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" required placeholder="Your full names" autocomplete="off" value="{{ old('name') }}" required autofocus>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
            </div>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" 
            required id="email" placeholder="Your email address" autocomplete="off" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-lock"></i></span>
            </div>
            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" 
            required id="password" placeholder="Your new password" autocomplete="off" required>
            <div class="input-group-append">
                <span class="input-group-text toggle-password" style="cursor: pointer;"><i class="fas fa-eye"></i></span>
            </div>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-id-card"></i></span>
            </div>
            <input type="text" class="form-control @error('national_id') is-invalid @enderror" name="national_id" required placeholder="Your National ID" autocomplete="off" value="{{ old('national_id') }}" required autofocus>
            @error('national_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
            </div>
            <input type="text" class="form-control @error('responsible_name') is-invalid @enderror" name="responsible_name" required placeholder="{{ __('cargo::view.table.owner_name') }}" autocomplete="off" value="{{ old('responsible_name') }}" required autofocus>
            @error('responsible_name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        
        <div class="input-group mb-3">
            {{-- <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div> --}}
            <input type="tel" id="phone" dir="ltr" autocomplete="off" required class="phone_input number-only form-control inptFielsd @error('responsible_mobile') is-invalid @enderror" name="responsible_mobile" required placeholder="{{ __('cargo::view.table.owner_phone') }}" autocomplete="off" value="{{ old('responsible_mobile', isset($model->country_code) ?$model->country_code.$model->responsible_mobile : base_country_code()) }}" required autofocus>
            <input type="hidden" class="country_code" name="country_code" value="{{ old('country_code', isset($model) ?$model->country_code : base_country_code()) }}" data-reflection="phone">
            @error('responsible_mobile')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-building"></i></span>
            </div>
            <select class="form-control select-branch @error('branch_id') is-invalid @enderror" name="branch_id">
                <option></option>
                @foreach($branches as $branch)
                    <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
            @error('branch_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" name="terms_conditions" class="@error('terms_conditions') is-invalid @enderror" id="remember">
              <label for="remember" style="font-size: 13px; font-weight: normal" required>
                {{ __('cargo::view.terms_and_conditions') }}
              </label>
              @error('terms_conditions')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
              @enderror
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-block btn-register text-white" style="background-color: #ffd000;">{{ __('cargo::view.register') }}</button>
          </div>
          <p class="forgot-password">
            {{ __('cargo::view.already_have_an_account') }}
            <a href="{{ route('signin') }}" class="login-link">
                {{ __('cargo::view.login') }}
            </a>
          </p>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/lte') }}/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select-branch').select2({
            placeholder: "{{ __('cargo::view.table.choose_branch') }}",
            width: '100%',
            dropdownParent: $('.select-branch').parent()
        });
        
        $('.toggle-password').click(function() {
            const input = $(this).parent().siblings('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
        
        $('.form-control').focus(function() {
            $(this).parent().find('.input-group-text').css('border-color', '#4158D0');
        }).blur(function() {
            $(this).parent().find('.input-group-text').css('border-color', '#e2e5ec');
        });
        
        $('#kt_sign_in_form').on('submit', function() {
            $('.btn-register').html('<i class="fas fa-spinner fa-spin mr-2"></i> {{ __("cargo::view.register") }}');
        });
    });
</script>
@endsection