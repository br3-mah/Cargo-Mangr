<x-auth-layout>
    <div class="register-container">
        <div class="register-box">
            <div class="card card-outline">
                <div class="card-body">
                    <!--begin::Heading-->
                    <div class="text-center mb-10">
                        <h1 class="widget-title">
                            {{ __('Create an Account') }}
                        </h1>

                        <div class="subtitle">
                            {{ __('Already have an account?') }}
                            <a href="https://www.newworldcargo.com" class="link-primary">
                                {{ __('Sign in here') }}
                            </a>
                        </div>
                    </div>
                    <!--end::Heading-->
                    <!--begin::Signup Form-->
                    <form method="POST" action="{{ theme()->getPageUrl('register') }}" class="form w-100" novalidate="novalidate" id="kt_sign_up_form">
                        @csrf

                        <!--begin::Social Sign-in-->
                        <div class="social-signin">
                            <button type="button" class="btn btn-social">
                                <img alt="Google" src="{{ asset('media/svg/brand-logos/google-icon.svg') }}" class="social-icon"/>
                                {{ __('Sign in with Google') }}
                            </button>
                        </div>
                        <!--end::Social Sign-in-->

                        <!--begin::Separator-->
                        <div class="separator">
                            <div class="separator-line"></div>
                            <span class="separator-text">{{ __('OR') }}</span>
                            <div class="separator-line"></div>
                        </div>
                        <!--end::Separator-->

                        <!--begin::Input group-->
                        <div class="row form-row">
                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('First Name') }}</label>
                                    <input class="form-control" type="text" name="first_name" autocomplete="off" value="{{ old('first_name') }}"/>
                                </div>
                            </div>
                            <!--end::Col-->

                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Last Name') }}</label>
                                    <input class="form-control" type="text" name="last_name" autocomplete="off" value="{{ old('last_name') }}"/>
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="form-group">
                            <label class="form-label">{{ __('Email') }}</label>
                            <div class="input-group">
                                <div class="input-icon">
                                    <span class="fas fa-envelope"></span>
                                </div>
                                <input class="form-control" type="email" name="email" autocomplete="off" value="{{ old('email') }}"/>
                            </div>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="form-group password-group" data-kt-password-meter="true">
                            <label class="form-label">{{ __('Password') }}</label>
                            <div class="input-group">
                                <div class="input-icon">
                                    <span class="fas fa-lock"></span>
                                </div>
                                <input class="form-control" type="password" name="password" autocomplete="new-password"/>
                                <span class="password-toggle" data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash show-icon"></i>
                                    <i class="bi bi-eye hide-icon"></i>
                                </span>
                            </div>

                            <!--begin::Meter-->
                            <div class="password-strength">
                                <div class="strength-meter">
                                    <div class="strength-segment"></div>
                                    <div class="strength-segment"></div>
                                    <div class="strength-segment"></div>
                                    <div class="strength-segment"></div>
                                </div>
                            </div>
                            <!--end::Meter-->

                            <div class="password-hint">
                                {{ __('Use 8 or more characters with a mix of letters, numbers & symbols.') }}
                            </div>
                        </div>
                        <!--end::Input group--->

                        <!--begin::Input group-->
                        <div class="form-group">
                            <label class="form-label">{{ __('Confirm Password') }}</label>
                            <div class="input-group">
                                <div class="input-icon">
                                    <span class="fas fa-lock"></span>
                                </div>
                                <input class="form-control" type="password" name="password_confirmation" autocomplete="off"/>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="form-group terms-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" name="toc" value="1"/>
                                <span class="checkmark"></span>
                                <span class="terms-text">
                                    {{ __('I Agree &') }} <a href="#" class="terms-link">{{ __('Terms and conditions') }}</a>.
                                </span>
                            </label>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="form-actions">
                            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                <span class="indicator-label">{{ __('Create Account') }}</span>
                                <span class="indicator-progress">
                                    {{ __('Please wait...') }} 
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <div class="social-login">
                        <button class="btn btn-danger" id="google-login"><i class="fab fa-google"></i>&nbsp;Signup with Google</button>
                        <button class="btn btn-primary" id="facebook-login"><i class="fab fa-facebook-f"></i>&nbsp;Signup with Facebook</button>
                    </div>
                    <!--end::Signup Form-->
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

        .register-container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem 0;
        }

        .register-box {
            width: 580px;
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

        .card-body {
            padding: 0 !important;
        }

        .widget-title {
            font-size: 1.75rem !important;
            font-weight: 700 !important;
            color: #333 !important;
            text-align: center !important;
            margin-bottom: 0.75rem !important;
            letter-spacing: 0.5px !important;
        }

        .subtitle {
            color: #6b7280;
            font-size: 15px;
            font-weight: 500;
            margin-bottom: 1.5rem;
        }

        .link-primary {
            color: #4299e1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .link-primary:hover {
            color: #3182ce;
            text-decoration: underline;
        }

        .social-signin {
            margin-bottom: 1.5rem;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 50px;
            background: #fff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            color: #4a5568;
            transition: all 0.3s ease;
            font-size: 15px;
        }

        .btn-social:hover {
            background: #f7fafc;
            border-color: #cbd5e0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .social-icon {
            height: 24px;
            margin-right: 10px;
        }

        .separator {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
        }

        .separator-line {
            flex-grow: 1;
            height: 1px;
            background-color: #e2e8f0;
        }

        .separator-text {
            margin: 0 1rem;
            font-size: 14px;
            color: #a0aec0;
            font-weight: 500;
        }

        .form-row {
            display: flex;
            margin-left: -10px;
            margin-right: -10px;
            margin-bottom: 0;
        }

        .form-row > div {
            padding-left: 10px;
            padding-right: 10px;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            font-size: 14px;
            color: #4a5568;
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
            height: 52px !important;
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

        .password-group .form-control {
            padding-right: 45px !important;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #a0aec0;
            z-index: 10;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: #4a5568;
        }

        .password-toggle .hide-icon {
            display: none;
        }

        .password-strength {
            margin-top: 10px;
        }

        .strength-meter {
            display: flex;
            gap: 6px;
            margin-top: 6px;
        }

        .strength-segment {
            height: 4px;
            flex-grow: 1;
            background-color: #e2e8f0;
            border-radius: 2px;
            transition: background-color 0.3s ease;
        }

        .password-hint {
            margin-top: 6px;
            font-size: 12px;
            color: #718096;
        }

        .terms-group {
            margin-top: 1.5rem;
        }

        .custom-checkbox {
            display: flex;
            align-items: flex-start;
            position: relative;
            padding-left: 28px;
            cursor: pointer;
            font-size: 14px;
        }

        .custom-checkbox input {
            position: absolute;
            opacity: 0;
            height: 0;
            width: 0;
        }

        .checkmark {
            position: absolute;
            top: 2px;
            left: 0;
            height: 18px;
            width: 18px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            transition: all 0.3s ease;
        }

        .custom-checkbox:hover input ~ .checkmark {
            background-color: #edf2f7;
        }

        .custom-checkbox input:checked ~ .checkmark {
            background-color: #4299e1;
            border-color: #4299e1;
        }

        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        .custom-checkbox input:checked ~ .checkmark:after {
            display: block;
        }

        .custom-checkbox .checkmark:after {
            left: 6px;
            top: 2px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }

        .terms-text {
            color: #718096;
            font-size: 14px;
            line-height: 1.4;
        }

        .terms-link {
            color: #4299e1;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .terms-link:hover {
            color: #3182ce;
            text-decoration: underline;
        }

        .form-actions {
            text-align: center;
            margin-top: 2rem;
        }

        .btn {
            height: 52px !important;
            font-weight: 600 !important;
            font-size: 15px !important;
            padding: 0 32px !important;
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
            min-width: 200px;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #3182ce, #2b6cb0) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 15px rgba(66, 153, 225, 0.4) !important;
        }

        .btn .indicator-progress {
            display: none;
        }

        .btn.is-loading .indicator-label {
            display: none;
        }

        .btn.is-loading .indicator-progress {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media (max-width: 767px) {
            .register-box {
                width: 90%;
                padding: 0 15px;
            }

            .card-outline {
                padding: 1.5rem !important;
            }

            .form-row {
                flex-direction: column;
            }

            .form-row > div {
                width: 100%;
                max-width: 100%;
                flex: 0 0 100%;
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password visibility toggle
            const toggleElements = document.querySelectorAll('[data-kt-password-meter-control="visibility"]');
            
            toggleElements.forEach(function(toggle) {
                toggle.addEventListener('click', function() {
                    const passwordInput = this.closest('.input-group').querySelector('input');
                    const showIcon = this.querySelector('.show-icon');
                    const hideIcon = this.querySelector('.hide-icon');
                    
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        showIcon.style.display = 'none';
                        hideIcon.style.display = 'block';
                    } else {
                        passwordInput.type = 'password';
                        showIcon.style.display = 'block';
                        hideIcon.style.display = 'none';
                    }
                });
            });
            
            // Password strength meter
            const passwordInputs = document.querySelectorAll('input[name="password"]');
            
            passwordInputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    const meter = this.closest('[data-kt-password-meter="true"]').querySelector('.strength-meter');
                    const segments = meter.querySelectorAll('.strength-segment');
                    const value = this.value;
                    
                    // Simple password strength calculation
                    let strength = 0;
                    
                    if (value.length >= 8) strength++;
                    if (value.match(/[A-Z]/)) strength++;
                    if (value.match(/[0-9]/)) strength++;
                    if (value.match(/[^A-Za-z0-9]/)) strength++;
                    
                    // Update meter UI
                    segments.forEach(function(segment, index) {
                        if (index < strength) {
                            switch(strength) {
                                case 1:
                                    segment.style.backgroundColor = '#F56565'; // red
                                    break;
                                case 2:
                                    segment.style.backgroundColor = '#ED8936'; // orange
                                    break;
                                case 3:
                                    segment.style.backgroundColor = '#ECC94B'; // yellow
                                    break;
                                case 4:
                                    segment.style.backgroundColor = '#48BB78'; // green
                                    break;
                            }
                        } else {
                            segment.style.backgroundColor = '#E2E8F0'; // gray
                        }
                    });
                });
            });
            
            // Form submission loading state
            const form = document.getElementById('kt_sign_up_form');
            const submitButton = document.getElementById('kt_sign_up_submit');
            
            if (form && submitButton) {
                form.addEventListener('submit', function() {
                    submitButton.classList.add('is-loading');
                    submitButton.disabled = true;
                });
            }
        });
    </script>
</x-auth-layout>