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

<div class="min-h-screen w-full bg-cover bg-center flex items-center justify-center py-8 px-4 sm:px-6 lg:px-8" style="background-image: url('https://www.newworldcargo.com/images/bg.webp')">
    <div class="w-full max-w-sm">
        <!-- Significantly reduced padding and made card more compact -->
        <div class="bg-white/95 backdrop-blur-sm shadow-xl border border-gray-100 transform transition-all hover:-translate-y-1 hover:shadow-2xl p-4">
            <!-- Logo - reduced size and margin -->
            <div class="flex justify-center mb-4">
                @php
                    $model = App\Models\Settings::where('group', 'general')->where('name','login_page_logo')->first();
                    $system_logo = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
                @endphp
                <a href="https://www.newworldcargo.com" class="block">
                    <img alt="Logo" src="{{ $model->getFirstMediaUrl('login_page_logo') ? $model->getFirstMediaUrl('login_page_logo') : ( $system_logo->getFirstMediaUrl('system_logo') ? $system_logo->getFirstMediaUrl('system_logo') : asset('assets/lte/cargo-logo.svg') ) }}" class="max-h-14 max-w-[140px] mx-auto object-contain" />
                </a>
            </div>

            <!-- Error Message - slimmer styling -->
            @error('email')
                <div class="mb-3 bg-red-50 border-l-4 border-red-400 p-3 rounded-md">
                    <div class="text-red-600 text-xs font-medium"> {{ $message }} </div>
                </div>
            @enderror

            <form method="POST" action="{{ route('login.request') }}" novalidate="novalidate" id="kt_sign_in_form">
                @csrf
                
                <!-- Email Input - reduced height and margins -->
                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="fas fa-envelope text-gray-400 text-sm"></span>
                        </div>
                        <input type="email"
                            class="w-full h-11 pl-10 pr-3 rounded-lg border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-400 focus:ring-1 focus:ring-primary-200 transition-all duration-200 text-gray-700 text-sm placeholder-gray-400"
                            name="email"
                            id="email"
                            placeholder="{{ __('view.Email') }}"
                            autocomplete="off"
                            required
                            autofocus>
                    </div>
                </div>
                
                <!-- Password Input - reduced height and margins -->
                <div class="mb-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <span class="fas fa-lock text-gray-400 text-sm"></span>
                        </div>
                        <input type="password"
                               class="w-full h-11 pl-10 pr-10 rounded-lg border border-gray-200 bg-gray-50/50 focus:bg-white focus:border-primary-400 focus:ring-1 focus:ring-primary-200 transition-all duration-200 text-gray-700 text-sm placeholder-gray-400"
                               name="password"
                               id="password"
                               placeholder="{{ __('view.Password') }}"
                               autocomplete="off"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="button" onclick="togglePassword()" class="focus:outline-none">
                                <span id="toggleIcon" class="fas fa-eye text-gray-400 text-sm hover:text-gray-600 transition-colors"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <script>
                    function togglePassword() {
                        const passwordInput = document.getElementById('password');
                        const toggleIcon = document.getElementById('toggleIcon');

                        if (passwordInput.type === 'password') {
                            passwordInput.type = 'text';
                            toggleIcon.classList.remove('fa-eye');
                            toggleIcon.classList.add('fa-eye-slash');
                        } else {
                            passwordInput.type = 'password';
                            toggleIcon.classList.remove('fa-eye-slash');
                            toggleIcon.classList.add('fa-eye');
                        }
                    }
                </script>

                <!-- Remember Me & Login - more compact layout -->
                <div class="flex flex-col space-y-3 mb-5">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="relative">
                                <input
                                    type="checkbox"
                                    id="remember"
                                    class="peer appearance-none w-4 h-4 border-2 border-gray-300 rounded bg-white
                                           checked:bg-primary-500 checked:border-0
                                           focus:outline-none focus:ring-2 focus:ring-primary-200 focus:ring-offset-1
                                           hover:border-primary-400 transition-all duration-150
                                           cursor-pointer"
                                    aria-checked="false"
                                >
                                <svg
                                    class="absolute w-4 h-4 text-white top-0 left-0 opacity-0 peer-checked:opacity-100
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
                                class="ml-2 text-sm text-gray-600 select-none hover:text-gray-800 cursor-pointer transition-colors"
                            >
                                {{ __('view.remember_me') }}
                            </label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs text-primary-600 hover:text-primary-700 font-medium transition-colors">
                                {{ __('view.forgot_password') }}
                            </a>
                        @endif
                    </div>

                    <!-- Login Button - more compact -->
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-primary-500 to-primary-600 hover:from-primary-600 hover:to-primary-700 text-white text-sm font-semibold rounded-lg shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-primary-400 focus:ring-offset-1 transition-all duration-200">
                        <span>{{ __('view.login') }}</span>
                        <svg class="ml-2 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Social Login - more compact spacing -->
            <div class="space-y-2 mb-5">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="px-2 bg-white text-gray-500">or continue with</span>
                    </div>
                </div>

                <button id="google-login"
                        class="w-full flex items-center justify-center px-3 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-200 rounded-lg shadow-sm hover:shadow transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="#EA4335">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    Google
                </button>

                <button id="facebook-login"
                        class="w-full flex items-center justify-center px-3 py-2.5 bg-[#1877F2] hover:bg-[#166fe5] text-white text-sm font-medium rounded-lg shadow-sm hover:shadow transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9.101,23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085,1.848-5.978,5.858-5.978c0.401,0,0.955,0.042,1.468,0.103 v3.149h-1.978c-1.608,0-2.376,0.83-2.376,2.386v1.92h3.341l-0.726,3.667h-2.615v7.98H9.101z"/>
                    </svg>
                    Facebook
                </button>
            </div>

            <!-- Register Link - compact -->
            @if (check_module('cargo'))
                <div class="text-center">
                    <a href="{{ route('reg') }}" class="text-xs text-gray-600 hover:text-primary-600 font-medium transition-colors">
                        {{ __('view.register_as_a_customer') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    document.getElementById('google-login').addEventListener('click', function () {
        window.location.href = "/auth/google";
    });

    document.getElementById('facebook-login').addEventListener('click', function () {
        window.location.href = "/auth/facebook";
    });
</script>
@endsection