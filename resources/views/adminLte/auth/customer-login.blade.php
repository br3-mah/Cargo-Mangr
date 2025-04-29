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
                <a href="{{ url('/') }}" class="block">
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
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-xl opacity-20 group-hover:opacity-25 group-focus-within:opacity-30 transition-opacity duration-300"></div>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="fas fa-envelope text-indigo-500 group-focus-within:text-indigo-600 transition-colors"></span>
                        </div>
                        <input type="email"
                            class="w-full h-14 pl-12 pr-4 rounded-xl border-2 border-gray-200 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 text-gray-700"
                            name="email"
                            id="email"
                            placeholder="{{ __('view.Email') }}"
                            autocomplete="off"
                            required
                            autofocus>
                        <div class="absolute -top-2.5 left-4 px-1 bg-white text-xs font-medium text-indigo-500 transition-all duration-300">Email</div>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="mb-6">
                    <div class="relative group">
                        <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 to-purple-500 rounded-xl opacity-20 group-hover:opacity-25 group-focus-within:opacity-30 transition-opacity duration-300"></div>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                            <span class="fas fa-lock text-indigo-500 group-focus-within:text-indigo-600 transition-colors"></span>
                        </div>
                        <input type="password"
                            class="w-full h-14 pl-12 pr-12 rounded-xl border-2 border-gray-200 bg-white focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition-all duration-300 text-gray-700"
                            name="password"
                            id="password"
                            placeholder="{{ __('view.Password') }}"
                            autocomplete="off"
                            required>
                        <div class="absolute -top-2.5 left-4 px-1 bg-white text-xs font-medium text-indigo-500 transition-all duration-300">Password</div>
                        <button type="button"
                                id="togglePassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-indigo-500 focus:outline-none transition-colors">
                            <span class="fas fa-eye" id="showPasswordIcon"></span>
                            <span class="fas fa-eye-slash hidden" id="hidePasswordIcon"></span>
                        </button>
                    </div>
                </div>

                <script>
                document.getElementById('togglePassword').addEventListener('click', function() {
                    const passwordField = document.getElementById('password');
                    const showIcon = document.getElementById('showPasswordIcon');
                    const hideIcon = document.getElementById('hidePasswordIcon');

                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        showIcon.classList.add('hidden');
                        hideIcon.classList.remove('hidden');
                    } else {
                        passwordField.type = 'password';
                        showIcon.classList.remove('hidden');
                        hideIcon.classList.add('hidden');
                    }
                });
                </script>

                <!-- Remember Me & Login Button -->
                <div class="flex flex-col sm:flex-row justify-between items-center mb-6">
                    <div class="flex items-center mb-4 sm:mb-0">
                        <div class="relative">
                            <input type="checkbox" id="remember" class="peer sr-only">
                            <div class="w-5 h-5 bg-white border-2 border-yellow-300 rounded-md peer-checked:bg-yellow-100 peer-checked:border-yellow-400 transition-colors duration-200"></div>
                            <div class="absolute text-yellow-500 top-[2px] left-[2px] opacity-0 peer-checked:opacity-100 transition-opacity duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>
                        <label for="remember" class="ml-2 text-sm font-medium mt-2 text-gray-600 cursor-pointer select-none">
                            {{ __('view.remember_me') }}
                        </label>
                    </div>
                    <button type="submit"
                            class="w-full sm:w-auto px-8 py-3 bg-primary-500 hover:bg-primary-600 active:bg-primary-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition duration-300 transform hover:-translate-y-0.5">
                        {{ __('view.login') }}
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
