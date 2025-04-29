@extends('adminLte.auth.layout')

@section('pageTitle')
    {{ __('view.sign_in') }}
@endsection

@section('content')
<!-- Tailwind CSS CDN -->
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

<div class="min-h-screen w-full bg-cover bg-center flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8" style="background-image: url('https://www.newworldcargo.com/images/bg.webp')">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl transform transition-all hover:-translate-y-1 hover:shadow-3xl p-8">
            <!-- Logo -->
            <div class="flex justify-center">
                @php
                    $model = App\Models\Settings::where('group', 'general')->where('name','login_page_logo')->first();
                    $system_logo = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
                @endphp
                <a href="https://www.newworldcargo.com" class="block">
                    <img alt="Logo" src="{{ $model->getFirstMediaUrl('login_page_logo') ? $model->getFirstMediaUrl('login_page_logo') : ( $system_logo->getFirstMediaUrl('system_logo') ? $system_logo->getFirstMediaUrl('system_logo') : asset('assets/lte/cargo-logo.svg') ) }}" class="max-h-20 max-w-[180px] mx-auto object-contain" />
                </a>
            </div>

            <!-- Title -->
            {{-- <h6 class="text-center text-sm font-bold text-gray-800 mb-6">Sign into your account</h6> --}}

            <!-- Error Message -->
            @error('email')
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                    <div class="text-red-600 text-sm"> {{ $message }} </div>
                </div>
            @enderror

            <form method="POST" action="{{ route('login.request') }}" novalidate="novalidate" id="kt_sign_in_form">
                @csrf

                <!-- Email Field -->
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="fas fa-envelope text-gray-400"></span>
                        </div>
                        <input type="email"
                               class="w-full h-14 pl-12 pr-4 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition duration-200 text-gray-700"
                               name="email"
                               id="email"
                               placeholder="{{ __('view.Email') }}"
                               autocomplete="off"
                               required
                               autofocus>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="fas fa-lock text-gray-400"></span>
                        </div>
                        <input type="password"
                               class="w-full h-14 pl-12 pr-12 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary-500 focus:ring-2 focus:ring-primary-200 transition duration-200 text-gray-700"
                               name="password"
                               id="password"
                               placeholder="{{ __('view.Password') }}"
                               autocomplete="off"
                               required>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4">
                            <button type="button" onclick="togglePassword()" class="focus:outline-none">
                                <span id="toggleIcon" class="fas fa-eye text-gray-400"></span>
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
                <!-- Remember Me & Login Button -->
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0 px-3 py-2 rounded-md bg-gradient-to-r from-yellow-50 to-white border-l-4 border-yellow-400">
                    <div class="flex items-center">
                        <div class="relative">
                            <!-- Improved checkbox with better focus styles and transitions -->
                            <input
                                type="checkbox"
                                id="remember"
                                class="peer appearance-none w-5 h-5 border-2 border-yellow-400 rounded-md bg-white
                                       checked:bg-yellow-500 checked:border-0
                                       focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2
                                       hover:border-yellow-500 transition-all duration-150
                                       cursor-pointer"
                                aria-checked="false"
                            >
                            <!-- Better checkmark with animation -->
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
                        <!-- Improved label with hover state and better spacing -->
                        <label
                            for="remember"
                            class="ml-3 text-base font-medium text-gray-700 select-none
                                   hover:text-gray-900 cursor-pointer transition-colors"
                        >
                            {{ __('view.remember_me') }}
                        </label>
                    </div>
                    <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 bg-yellow-500 text-white text-sm font-semibold rounded-md shadow-sm hover:bg-yellow-400 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-1 transition-colors duration-150">
                        <span>{{ __('view.login') }}</span>
                        <svg class="ml-1.5 w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Social Login -->
            <div class="space-y-3 mt-8">
                <button id="google-login"
                        class="w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-gray-50 text-gray-700 font-medium border border-gray-300 rounded-xl shadow-sm hover:shadow transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="#EA4335">
                        <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z"/>
                    </svg>
                    Sign in with Google
                </button>
                <button id="facebook-login"
                        class="w-full flex items-center justify-center px-4 py-3 bg-[#1877F2] hover:bg-[#166fe5] text-white font-medium rounded-xl shadow-sm hover:shadow transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-3" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M9.101,23.691v-7.98H6.627v-3.667h2.474v-1.58c0-4.085,1.848-5.978,5.858-5.978c0.401,0,0.955,0.042,1.468,0.103 v3.149h-1.978c-1.608,0-2.376,0.83-2.376,2.386v1.92h3.341l-0.726,3.667h-2.615v7.98H9.101z"/>
                    </svg>
                    Sign in with Facebook
                </button>
            </div>

            <!-- Additional Links -->
            <div class="mt-8 flex flex-col items-center space-y-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-primary-600 transition duration-200">
                        {{ __('view.forgot_password') }}
                    </a>
                @endif

                @if (check_module('cargo'))
                    <a href="{{ route('reg') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium transition duration-200">
                        {{ __('view.register_as_a_customer') }}
                    </a>
                @endif
            </div>
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
