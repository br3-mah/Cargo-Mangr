@extends('adminLte.auth.layout')
@include('cargo::adminLte.components.inputs.phone')
@section('pageTitle')
    {{ __('Sign In') }}
@endsection
@section('content')
<style>
  /* Page background image */
  body {
    background: url('https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=1500&q=80') no-repeat center center fixed;
    background-size: cover;
    min-height: 100vh;
  }
  /* Overlay for the whole page */
  body:before {
    content: '';
    position: fixed;
    left: 0; top: 0; right: 0; bottom: 0;
    background: rgba(33, 37, 41, 0.45);
    z-index: 0;
    pointer-events: none;
  }
  /* Pre-questionnaire modal styles */
  #preQuestionnaireModal {
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
  }
  #preQuestionnaireModal .modal-bg {
    background: url('https://images.unsplash.com/photo-1465101046530-73398c7f28ca?auto=format&fit=crop&w=800&q=80') no-repeat center center;
    background-size: cover;
    border-radius: 16px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.18);
    max-width: 420px;
    width: 100%;
    position: relative;
    overflow: hidden;
  }
  #preQuestionnaireModal .modal-overlay {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(255,255,255,0.92);
    z-index: 1;
  }
  #preQuestionnaireModal .modal-content {
    position: relative;
    z-index: 2;
    padding: 2.5rem 2rem 2rem 2rem;
    text-align: center;
  }
  #preQuestionnaireModal h2 {
    font-size: 1.6rem;
    margin-bottom: 1.2rem;
    color: #4158D0;
    font-weight: 700;
  }
  #preQuestionnaireModal p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    color: #333;
  }
  #preQuestionnaireModal .btn-preq {
    padding: 0.7rem 2.2rem;
    margin: 0 0.5rem;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s;
    box-shadow: 0 2px 8px rgba(65,88,208,0.08);
  }
  #preQuestionnaireModal .btn-yes {
    background: #4158D0;
    color: #fff;
  }
  #preQuestionnaireModal .btn-no {
    background: #ffd000;
    color: #222;
  }
  @media (max-width: 500px) {
    #preQuestionnaireModal .modal-content {
      padding: 1.5rem 0.5rem 1.5rem 0.5rem;
    }
    #preQuestionnaireModal .modal-bg {
      max-width: 98vw;
    }
  }
  /* Registration card enhancements */
  .login-box {
    position: relative;
    z-index: 2;
  }
  .login-box .card {
    background: rgba(255,255,255,0.93);
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(65,88,208,0.10);
    backdrop-filter: blur(2px);
    border: none;
  }
  .login-box .card-header {
    background: transparent;
    border-bottom: none;
  }
  .login-box .widget-title {
    color: #4158D0;
    font-weight: 700;
    margin-bottom: 1.5rem;
  }
  /* Enhanced password toggle */
  .input-group .input-group-append .toggle-password {
    display: flex;
    align-items: center;
    padding: 0 0.8rem;
    font-size: 1.2rem;
    color: #4158D0;
    background: transparent;
    border: none;
    cursor: pointer;
    transition: color 0.2s;
  }
  .input-group .input-group-append .toggle-password:hover {
    color: #ffd000;
  }
</style>

<div id="preQuestionnaireModal">
  <div class="modal-bg">
    <div class="modal-overlay"></div>
    <div class="modal-content">
      <h2>Welcome!</h2>
      <p>Is this your first time using <b>Newworld Cargo Limited</b>?</p>
      <button class="btn-preq btn-yes" id="preqYes">Yes</button>
      <button class="btn-preq btn-no" id="preqNo">No</button>
    </div>
  </div>
</div>

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
                <button type="button" class="input-group-text toggle-password" tabindex="0" aria-label="Show password" aria-pressed="false" title="Show/Hide Password"><i class="fas fa-eye"></i></button>
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
<script>
    $(document).ready(function() {
        $('.toggle-password').on('click keypress', function(e) {
            if (e.type === 'click' || (e.type === 'keypress' && (e.which === 13 || e.which === 32))) {
                e.preventDefault();
                var $btn = $(this);
                var $input = $btn.closest('.input-group').find('input[type="password"], input[type="text"]').first();
                var $icon = $btn.find('i');
                var isPassword = $input.attr('type') === 'password';
                $input.attr('type', isPassword ? 'text' : 'password');
                $icon.toggleClass('fa-eye fa-eye-slash');
                $btn.attr('aria-label', isPassword ? 'Hide password' : 'Show password');
                $btn.attr('aria-pressed', isPassword ? 'true' : 'false');
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('preQuestionnaireModal');
    var formBox = document.querySelector('.login-box');
    if (formBox) {
      formBox.style.display = 'none';
    }
    function showForm() {
      if (modal) modal.style.display = 'none';
      if (formBox) formBox.style.display = '';
    }
    document.getElementById('preqYes').onclick = showForm;
    document.getElementById('preqNo').onclick = showForm;
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