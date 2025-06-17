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
      <h3 class="widget-title text-lg">Create a new account today</h3>
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
            <input type="tel" id="phone" dir="ltr" autocomplete="off" required class="phone_input number-only form-control inptFielsd @error('responsible_mobile') is-invalid @enderror" name="responsible_mobile" required placeholder="{{ __('cargo::view.table.owner_phone') }}" autocomplete="off" value="" required autofocus>
            <input type="hidden" class="country_code" name="country_code" value="" data-reflection="phone">
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
                <option selected value="1">
                    Lusaka 
                </option>
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

@section('scripts')
<script>
    $(function () {
        var phoneNumbers = $('.phone_input'),
            wrong_number = window.wrong_number_msg,
            required_phone = window.required_phone

        phoneNumbers.each(function () {
            var self = $(this),
                input = self[0],
                type = self.attr('data-type');
                // initialise plugin
            var iti = window.intlTelInput(input, {
                separateDialCode: true,
                utilsScript: window.static_asset_utils_file,
                initialCountry: "",
                preferredCountries: ["eg","ng", "zm"],
                autoPlaceholder: "aggressive",
                allowDropdown: true,
                nationalMode: true,
                formatOnDisplay: true,
                separateDialCode: true,
                initialCountry: "",
                geoIpLookup: function(callback) {
                    callback("");
                }
            });

            // Clear any initial value
            self.val('');

            input.addEventListener("countrychange", function() {
                var countryCode = iti.getSelectedCountryData().dialCode;
                $('.country_code').val('+'+countryCode);
                // Clear the input when country changes
                self.val('');
            });

            // Handle form submission
            $('form').on('submit', function(e) {
                if (!iti.isValidNumber()) {
                    e.preventDefault();
                    self.addClass('is-invalid');
                    return false;
                }
                var number = iti.getNumber();
                var countryCode = iti.getSelectedCountryData().dialCode;
                $('.country_code').val('+'+countryCode);
                self.val(number);
            });

            var reset = function() {
                self.parent().next('.invalid-feedback').remove();
                self.parent().removeClass('not-valid');
                self.removeClass("error is-invalid");
            };

            var addError = function(msg) {
                self.addClass('error is-invalid');
                self.parent().addClass('not-valid');
                self.parent().after("<span style='display: block' class=\"invalid-feedback\" role=\"alert\">\n" +
                    " <strong>" + msg + "</strong>\n" +
                    " </span>");
                return false;
            };
            // on blur: validate
            input.addEventListener('blur', function() {
                reset();

                if (self.attr('required')) {
                    if (input.value.trim() == '') {
                        return addError('field is empty')
                    }
                }

                if (input.value.trim() && !iti.isValidNumber()) {
                    return addError('reqierd')
                }
                // run code if verified
            });
            // on keyup / change flag: reset
            input.addEventListener('change', reset);
            input.addEventListener('keyup', reset);
        });

        $(".number-only").keypress(function(event){
            var ewn = event.which;
            if(ewn >= 48 && ewn <= 57) {
                return true;
            }
            return false;
        });

        $(".phone-validation").on("submit", function(evt) {
            var phoneField = $(this).find(".phone_input");
            if (phoneField.hasClass('error')) {
                evt.preventDefault();
                return false
            } else {
                //do the rest of your validations here
                $(this).submit();
            }
        });
    });
</script>
@endsection