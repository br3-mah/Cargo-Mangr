@extends('adminLte.auth.layout')

@section('pageTitle')
    {{ __('view.sign_in') }}
@endsection

@section('content')
<div class="login-container">
    <div class="login-box">
        <div class="card card-outline">
            <div class="card-header text-center">
                <a href="{{ url('/') }}" class="logo-container">
                    @php 
                        $model = App\Models\Settings::where('group', 'general')->where('name','login_page_logo')->first();
                        $system_logo = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
                    @endphp
                    <img alt="Logo" src="{{ $model->getFirstMediaUrl('login_page_logo') ? $model->getFirstMediaUrl('login_page_logo') : ( $system_logo->getFirstMediaUrl('system_logo') ? $system_logo->getFirstMediaUrl('system_logo') : asset('assets/lte/cargo-logo.svg') ) }}" class="login-logo" />
                </a>
            </div>

            <div class="card-body">
                <h3 class="widget-title text-muted text-['#012624']">Sigin into your account</h3>
                
                @error('email')
                    <div class="alert-message">
                        <div class="text-danger"> {{ $message }} </div>
                    </div>
                @enderror

                <form method="POST" action="{{ route('login.request') }}" novalidate="novalidate" id="kt_sign_in_form">
                    @csrf
                    
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-icon">
                                <span class="fas fa-envelope"></span>
                            </div>
                            <input type="email" class="form-control" name="email" id="email" placeholder="{{ __('view.Email') }}" autocomplete="off" value="" required autofocus>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-icon">
                                <span class="fas fa-lock"></span>
                            </div>
                            <input type="password" class="form-control" name="password" id="password" placeholder="{{ __('view.Password') }}" autocomplete="off" required>
                        </div>
                    </div>
                    
                    <div class="form-options">
                        <div class="remember-me">
                            <div class="custom-checkbox">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    {{ __('view.remember_me') }}
                                </label>
                            </div>
                        </div>
                        <div class="login-button">
                            <button type="submit" class="btn text-white" style="background-color: #ffd000;">{{ __('view.login') }}</button>
                        </div>
                    </div>
                </form>

                <div class="social-login">
                    <button class="btn btn-danger" id="google-login"><i class="fab fa-google"></i>&nbsp;Signin with Google</button>
                    <button class="btn btn-primary" id="facebook-login"><i class="fab fa-facebook-f"></i>&nbsp;Signin with Facebook</button>
                </div>

                <div class="additional-links">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            {{ __('view.forgot_password') }}
                        </a>
                    @endif

                    @if (check_module('cargo'))
                        <a href="{{ route('reg') }}" class="register-link" style=" color:blue;">
                            {{ __('view.register_as_a_customer') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css" media="all">
    body {
        background: #f8f9fa !important;
        font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0;
        padding: 0;
    }

    .login-container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .login-box {
        width: 30%;
        margin: 0 auto;
    }

    .card {
        background: #fff;
        border-radius: 12px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08) !important;
        border: none !important;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1) !important;
    }

    .card-outline {
        padding: 2.5rem !important;
        border: none !important;
    }

    .card-header {
        background: transparent !important;
        padding: 0 !important;
        border: none !important;
        margin-bottom: 2rem !important;
    }

    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 1rem 0;
    }

    .login-logo {
        max-width: 180px;
        max-height: 120px;
        object-fit: contain;
    }

    .card-body {
        padding: 0 !important;
    }

    .widget-title {
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        color: #333 !important;
        text-align: center !important;
        margin-bottom: 2rem !important;
        letter-spacing: 0.5px !important;
    }

    .alert-message {
        background-color: #fff8f8;
        border-radius: 8px;
        padding: 12px 16px;
        margin-bottom: 20px;
        border-left: 4px solid #f44336;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .input-group {
        position: relative;
    }

    .input-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #adb5bd;
        z-index: 10;
    }

    .form-control {
        height: 56px !important;
        border-radius: 10px !important;
        padding-left: 48px !important;
        padding-right: 20px !important;
        border: 1px solid #e2e8f0 !important;
        background-color: #f8fafc !important;
        font-size: 15px !important;
        transition: all 0.3s ease !important;
        width: 100% !important;
        box-sizing: border-box !important;
    }

    .form-control:focus {
        border-color: #4299e1 !important;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15) !important;
        background-color: #fff !important;
    }

    .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .remember-me {
        display: flex;
        align-items: center;
    }

    .custom-checkbox {
        display: flex;
        align-items: center;
    }

    .custom-checkbox input[type="checkbox"] {
        margin-right: 8px;
        width: 16px;
        height: 16px;
    }

    .custom-checkbox label {
        font-size: 14px;
        color: #718096;
        cursor: pointer;
        user-select: none;
    }

    .btn {
        height: 48px !important;
        font-weight: 600 !important;
        font-size: 15px !important;
        padding: 0 24px !important;
        border-radius: 10px !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4299e1, #3182ce) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3) !important;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #3182ce, #2b6cb0) !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 15px rgba(66, 153, 225, 0.4) !important;
    }

    .additional-links {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 2rem;
        gap: 1rem;
    }

    .forgot-link, .register-link {
        color: #4a5568;
        font-size: 14px;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .forgot-link:hover, .register-link:hover {
        color: #4299e1;
        text-decoration: underline;
    }

    @media (max-width: 767px) {
        .login-box {
            width: 90%;
            padding: 0 15px;
        }

        .card-outline {
            padding: 1.5rem !important;
        }

        .form-options {
            flex-direction: column;
            gap: 1rem;
        }

        .login-button {
            width: 100%;
        }

        .btn {
            width: 100%;
        }
    }
    
    .social-login {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-top: 20px;
    }

    .social-login .btn {
        width: 100%;
        font-size: 16px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px;
    }

    .social-login .btn i {
        margin-right: 8px;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    function autoFill(){
        $('#email').val('admin@admin.com');
        $('#password').val('123456');
    }

    @if(env('DEMO_MODE') == 'On')
      $(document).ready(function() {
        autoFill();

        $('body').on('click','#login_admin', function(e){
          $('#email').val('admin@admin.com');
          $('#password').val('123456');
          $('#signin_submit').trigger('click');
        });
        $('body').on('click','#login_employee', function(e){
          $('#email').val('employee@cargo.com');
          $('#password').val('123456');
          $('#signin_submit').trigger('click');
        });
        $('body').on('click','#login_driver', function(e){
          $('#email').val('driver@cargo.com');
          $('#password').val('123456');
          $('#signin_submit').trigger('click');
        });
        $('body').on('click','#login_branch', function(e){
          $('#email').val('branch@cargo.com');
          $('#password').val('123456');
          $('#signin_submit').trigger('click');
        });
        $('body').on('click','#login_client', function(e){
          $('#email').val('client@cargo.com');
          $('#password').val('123456');
          $('#signin_submit').trigger('click');
        });
      });
    @endif
</script>
@endsection