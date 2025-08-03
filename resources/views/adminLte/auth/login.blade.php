@extends('adminLte.auth.layout')

@section('pageTitle')
    {{ __('view.sign_in') }}
@endsection

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#fff8e1',
                        100: '#ffecb3',
                        200: '#ffe082',
                        300: '#ffd54f',
                        400: '#ffca28',
                        500: '#ffc107',
                        600: '#ffb300',
                        700: '#ffa000',
                        800: '#ff8f00',
                        900: '#ff6f00',
                    },
                },
                fontFamily: {
                    sans: ['Poppins', 'sans-serif'],
                }
            }
        }
    }
</script>

<div class="min-h-screen w-full flex" style="background-image: url('https://www.newworldcargo.com/images/bg.webp'); background-size: cover; background-position: center;">
    <!-- Left Side - Login Card (Full Height) -->
    <div class="w-full lg:w-2/5 xl:w-1/3 bg-white/95 backdrop-blur-sm shadow-2xl flex flex-col">
        <div class="flex-1 flex flex-col justify-center px-8 py-12 lg:px-12">
            <!-- Logo -->
            <div class="flex justify-center mb-8">
                @php
                    $model = App\Models\Settings::where('group', 'general')->where('name','login_page_logo')->first();
                    $system_logo = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
                @endphp
                <a href="https://www.newworldcargo.com" class="block">
                    <img alt="Logo" src="{{ $model->getFirstMediaUrl('login_page_logo') ? $model->getFirstMediaUrl('login_page_logo') : ( $system_logo->getFirstMediaUrl('system_logo') ? $system_logo->getFirstMediaUrl('system_logo') : asset('assets/lte/cargo-logo.svg') ) }}" class="max-h-16 max-w-[200px] mx-auto object-contain" />
                </a>
            </div>

            <!-- Demo Mode Section -->
            @if(env('DEMO_MODE') == 'On')
                <div class="mb-8 bg-gradient-to-br from-amber-50 to-yellow-50 border border-amber-200 rounded-xl p-6">
                    <div class="text-center text-amber-800 font-semibold text-sm mb-4">
                        {{ __('view.demo_login_details') }}
                    </div>
                    <div class="text-xs text-amber-700 mb-4 text-center">
                        {{ __('view.demo_details') }}
                    </div>

                    <div class="grid grid-cols-1 gap-3">
                        <!-- Admin -->
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-lg hover:bg-white/80 transition-colors cursor-pointer" id="login_admin">
                            <div>
                                <div class="font-semibold text-xs text-gray-800">{{ __('view.ADMIN') }}</div>
                                <div class="text-xs text-primary-600 underline">{{ __('view.click_to_copy') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-600">admin@admin.com</div>
                                <div class="text-xs text-gray-500">123456</div>
                            </div>
                        </div>

                        <!-- Employee -->
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-lg hover:bg-white/80 transition-colors cursor-pointer" id="login_employee">
                            <div>
                                <div class="font-semibold text-xs text-gray-800">{{ __('view.EMPLOYEE') }}</div>
                                <div class="text-xs text-primary-600 underline">{{ __('view.click_to_copy') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-600">employee@cargo.com</div>
                                <div class="text-xs text-gray-500">123456</div>
                            </div>
                        </div>

                        <!-- Branch Manager -->
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-lg hover:bg-white/80 transition-colors cursor-pointer" id="login_branch">
                            <div>
                                <div class="font-semibold text-xs text-gray-800">{{ __('view.BRANCH_MANAGER') }}</div>
                                <div class="text-xs text-primary-600 underline">{{ __('view.click_to_copy') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-600">branch@cargo.com</div>
                                <div class="text-xs text-gray-500">123456</div>
                            </div>
                        </div>

                        <!-- Driver -->
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-lg hover:bg-white/80 transition-colors cursor-pointer" id="login_driver">
                            <div>
                                <div class="font-semibold text-xs text-gray-800">{{ __('view.DRIVER_CAPTAIN') }}</div>
                                <div class="text-xs text-primary-600 underline">{{ __('view.click_to_copy') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-600">driver@cargo.com</div>
                                <div class="text-xs text-gray-500">123456</div>
                            </div>
                        </div>

                        <!-- Customer -->
                        <div class="flex items-center justify-between p-3 bg-white/60 rounded-lg hover:bg-white/80 transition-colors cursor-pointer" id="login_client">
                            <div>
                                <div class="font-semibold text-xs text-gray-800">{{ __('view.CUSTOMER') }}</div>
                                <div class="text-xs text-primary-600 underline">{{ __('view.click_to_copy') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-xs text-gray-600">client@cargo.com</div>
                                <div class="text-xs text-gray-500">123456</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Title -->
            <div class="text-center mb-2">
                <h3 class="text-lg font-bold text-gray-900 uppercase tracking-wide">
                    Login Back to your Account
                </h3>
            </div>

            <!-- Error Message -->
            @error('email')
                <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg">
                    <div class="text-red-600 text-sm font-medium"> {{ $message }} </div>
                </div>
            @enderror

            <!-- Login Form -->
            <form method="POST" action="{{ route('login.request') }}" novalidate="novalidate" id="kt_sign_in_form" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="fas fa-envelope text-gray-400"></span>
                        </div>
                        <input type="email"
                            class="w-full h-12 pl-12 pr-4 rounded-lg border border-gray-300 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 text-gray-700 placeholder-gray-500"
                            name="email"
                            id="email"
                            placeholder="{{ __('view.Email') }}"
                            autocomplete="off"
                            required
                            autofocus>
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="fas fa-lock text-gray-400"></span>
                        </div>
                        <input type="password"
                               class="w-full h-12 pl-12 pr-4 rounded-lg border border-gray-300 bg-gray-50/50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition-all duration-200 text-gray-700 placeholder-gray-500"
                               name="password"
                               id="password"
                               placeholder="{{ __('view.Password') }}"
                               autocomplete="off"
                               required>
                    </div>
                </div>

                <!-- Remember Me & Login Button -->
                <div class="flex flex-col space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    class="peer appearance-none w-5 h-5 border-2 border-gray-300 rounded bg-white
                                           checked:bg-primary-500 checked:border-0
                                           focus:outline-none focus:ring-2 focus:ring-primary-200 focus:ring-offset-1
                                           hover:border-primary-400 transition-all duration-150
                                           cursor-pointer"
                                    aria-checked="false"
                                >
                                <svg
                                    class="absolute w-5 h-5 text-white top-0 left-0 opacity-0 peer-checked:opacity-100
                                          transition-opacity duration-150 pointer-events-none"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    aria-hidden="true"
                                >
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>
                            <label
                                for="remember"
                                class="ml-3 text-sm text-gray-700 select-none hover:text-gray-900 cursor-pointer transition-colors font-medium"
                            >
                                {{ __('view.remember_me') }}
                            </label>
                        </div>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-primary-600 hover:text-primary-700 font-medium transition-colors">
                                {{ __('view.forgot_password') }}
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <button type="submit" id="signin_submit" class="w-full flex items-center justify-center px-6 py-3 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-2 transition-all duration-200 transform hover:-translate-y-0.5 relative">
                        <span class="login-btn-text">{{ __('view.login') }}</span>
                        <svg class="ml-2 w-5 h-5 login-btn-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                        <svg class="animate-spin h-5 w-5 text-white absolute right-6 login-btn-spinner" style="display:none;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Register Link -->
            @if (check_module('cargo'))
                <div class="text-center mt-8">
                    <a href="{{ route('reg') }}" class="text-sm text-gray-600 hover:text-primary-600 font-medium transition-colors">
                        {{ __('view.register_as_a_customer') }}
                    </a>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="px-8 py-6 border-t border-gray-200 bg-gray-50/50">
            <p class="text-xs text-center text-gray-500">
                © {{ date('Y') }} New World Cargo. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Right Side - Background Image (Hidden on mobile) -->
    <div class="hidden lg:flex lg:w-3/5 xl:w-2/3 bg-gradient-to-br from-primary-600/20 to-primary-800/20">
        <!-- Optional overlay content can go here -->
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    function autoFill(){
        $('#email').val('admin@admin.com');
        $('#password').val('123456');
    }

    $(document).ready(function() {
        // Preloading state for login button
        $('#kt_sign_in_form').on('submit', function(e) {
            var btn = $('#signin_submit');
            btn.prop('disabled', true);
            btn.find('.login-btn-text').css('opacity', '0.5');
            btn.find('.login-btn-arrow').hide();
            btn.find('.login-btn-spinner').show();
        });

        @if(env('DEMO_MODE') == 'On')
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
        @endif
    });
</script>
@endsection
