@extends('cargo::adminLte.layouts.guest')

@section('title')
    {{ __('cargo::view.claim_accounts') }}
@endsection

@section('content')
<!-- Add Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
.button-wrapper {
    position: relative;
    overflow: visible;
}

.button-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.7);
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
    pointer-events: none;
    z-index: 10;
}
.button-overlay.active {
    opacity: 1;
}

.spinner {
    border: 2px solid #e5e7eb;
    border-top: 2px solid #1a237e;
    border-radius: 50%;
    width: 1.5rem;
    height: 1.5rem;
    animation: spin 0.7s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

button:disabled {
    cursor: not-allowed;
    opacity: 0.8;
}
.button-content {
    transition: opacity 0.2s ease-in-out;
}
.button-content.fade {
    opacity: 0;
}
</style>

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 py-8 px-2 sm:px-4 lg:px-0 flex items-center justify-center">
    <div class="w-full max-w-2xl mx-auto">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
            <!-- Header -->
            <div class="bg-gradient-to-r from-navy-900 to-navy-800 px-5 py-6 flex items-center gap-3">
                <div class="bg-white/30 rounded-full p-2 shadow">
                    <i class="fas fa-user-shield text-yellow-400 text-lg"></i>
                </div>
                <h4 class="text-white text-xl font-bold tracking-tight">{{ __('cargo::view.similar_accounts_found') }}</h4>
            </div>

            <div class="p-5 sm:p-7">
                <p class="text-gray-600 text-base mb-6 leading-relaxed">{{ __('cargo::view.similar_accounts_message') }}</p>

                @if(isset($similar_accounts) && count($similar_accounts) > 0)
                    <div class="space-y-5">
                        <div>
                            <h5 class="text-navy-900 text-lg font-semibold mb-3 flex items-center gap-2">
                                <i class="fas fa-link text-yellow-500"></i>
                                {{ __('cargo::view.claim_existing_account') }}
                            </h5>
                            <form action="{{ route('clients.process-claim') }}" method="POST" class="claim-form">
                                @csrf
                                @foreach($similar_accounts as $account)
                                    <div class="bg-gray-50 border border-gray-200 rounded-xl p-3 mb-3 flex items-center gap-3 hover:border-navy-900 hover:shadow transition-all duration-200">
                                        <input class="form-radio h-4 w-4 text-navy-900 border-gray-300 focus:ring-navy-900" 
                                               type="radio" 
                                               name="claim_account" 
                                               id="account_{{ $account->id }}" 
                                               value="{{ $account->id }}" 
                                               required>
                                        <label class="ml-2 cursor-pointer" for="account_{{ $account->id }}">
                                            <span class="block text-navy-900 font-medium text-base">
                                                {{ ucwords(strtolower($account->name)) }}
                                            </span>
                                            <span class="block text-gray-500 text-xs">
                                                {{ $account->email }}
                                            </span>
                                        </label>
                                    </div>
                                @endforeach

                                <div class="mt-5">
                                    <div class="button-wrapper">
                                        <button type="submit" class="w-full bg-navy-900 text-white px-4 py-2 rounded-lg font-medium text-sm hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-navy-900 focus:ring-offset-2 transition flex items-center justify-center gap-2 shadow-sm">
                                            <span class="button-content flex items-center gap-2">
                                                <i class="fas fa-check-circle"></i>
                                                {{ __('cargo::view.claim_selected_account') }}
                                            </span>
                                        </button>
                                        <div class="button-overlay">
                                            <div class="spinner"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-3 bg-white text-gray-400 text-xs font-medium uppercase tracking-wider">{{ __('cargo::view.or') }}</span>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-navy-900 text-lg font-semibold mb-3 flex items-center gap-2">
                                <i class="fas fa-plus-circle text-yellow-500"></i>
                                {{ __('cargo::view.or_create_new') }}
                            </h5>
                            <form action="{{ route('clients.process-claim') }}" method="POST" class="create-form">
                                @csrf
                                <div class="button-wrapper">
                                    <button type="submit" class="w-full bg-yellow-400 text-navy-900 px-4 py-2 rounded-lg font-medium text-sm hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition flex items-center justify-center gap-2 shadow-sm">
                                        <span class="button-content flex items-center gap-2">
                                            <i class="fas fa-user-plus"></i>
                                            {{ __('cargo::view.create_new_account') }}
                                        </span>
                                    </button>
                                    <div class="button-overlay">
                                        <div class="spinner"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3 mb-5 rounded-lg flex items-center gap-3">
                        <i class="fas fa-info-circle text-blue-400"></i>
                        <p class="text-blue-700 text-sm">{{ __('cargo::view.no_similar_accounts') }}</p>
                    </div>
                    <!-- Hidden form with initial registration data -->
                    <form action="{{ route('register.request') }}" method="POST" id="initialRegistrationForm" class="register-form">
                        @csrf
                        @if(isset($registration_data))
                            @foreach($registration_data as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        @endif
                        <div class="button-wrapper mt-2">
                            <button type="submit" class="w-full bg-yellow-400 text-navy-900 px-4 py-2 rounded-lg font-medium text-sm hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition flex items-center justify-center gap-2 shadow-sm">
                                <span class="button-content flex items-center gap-2">
                                    <i class="fas fa-user-plus"></i>
                                    Proceed with registration
                                </span>
                            </button>
                            <div class="button-overlay">
                                <div class="spinner"></div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add custom colors to Tailwind config -->
<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    navy: {
                        900: '#1a237e',
                        800: '#283593',
                    }
                }
            }
        }
    }
</script>

<!-- Add loading state handling -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Function to handle form submission and loading state
    function handleFormSubmit(form) {
        form.addEventListener('submit', function(e) {
            const button = form.querySelector('button[type="submit"]');
            const buttonWrapper = button.closest('.button-wrapper');
            const buttonContent = button.querySelector('.button-content');
            const buttonOverlay = buttonWrapper.querySelector('.button-overlay');
            // Disable the button and show loading state
            button.disabled = true;
            buttonContent.classList.add('fade');
            buttonOverlay.classList.add('active');
        });
    }
    // Initialize loading states for all forms
    const forms = document.querySelectorAll('form');
    forms.forEach(handleFormSubmit);
});
</script>
@endsection 