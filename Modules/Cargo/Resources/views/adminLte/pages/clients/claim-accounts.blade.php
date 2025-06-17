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
    overflow: hidden;
}

.button-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.1);
    opacity: 0;
    transition: opacity 0.2s ease-in-out;
    pointer-events: none;
}

.button-overlay.active {
    opacity: 1;
}

.loading-line {
    position: absolute;
    top: 0;
    left: 0;
    height: 2px;
    background: currentColor;
    animation: loading 1s ease-in-out infinite;
    width: 100%;
    transform-origin: left;
}

@keyframes loading {
    0% {
        transform: scaleX(0);
    }
    50% {
        transform: scaleX(0.5);
    }
    100% {
        transform: scaleX(1);
    }
}

button:disabled {
    cursor: not-allowed;
    opacity: 0.9;
}

.button-content {
    transition: opacity 0.2s ease-in-out;
}

.button-content.fade {
    opacity: 0;
}
</style>

<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-navy-900 to-navy-800 px-6 py-8">
                <div class="flex items-center space-x-4">
                    <div class="bg-white/20 rounded-full p-3">
                        <i class="fas fa-user-shield text-yellow-400 text-xl"></i>
                    </div>
                    <h4 class="text-white text-2xl font-semibold">{{ __('cargo::view.similar_accounts_found') }}</h4>
                </div>
            </div>

            <div class="p-6">
                <p class="text-gray-600 text-lg mb-8">{{ __('cargo::view.similar_accounts_message') }}</p>

                @if(isset($similar_accounts) && count($similar_accounts) > 0)
                    <div class="space-y-6">
                        <div>
                            <h5 class="text-navy-900 text-xl font-semibold mb-4 flex items-center">
                                <i class="fas fa-link text-yellow-500 mr-2"></i>
                                {{ __('cargo::view.claim_existing_account') }}
                            </h5>
                            <form action="{{ route('clients.process-claim') }}" method="POST" class="claim-form">
                                @csrf
                                @foreach($similar_accounts as $account)
                                    <div class="bg-white border border-gray-200 rounded-lg p-4 mb-4 hover:border-navy-900 hover:shadow-md transition-all duration-300">
                                        <div class="flex items-center">
                                            <input class="form-radio h-5 w-5 text-navy-900 border-gray-300 focus:ring-navy-900" 
                                                   type="radio" 
                                                   name="claim_account" 
                                                   id="account_{{ $account->id }}" 
                                                   value="{{ $account->id }}" 
                                                   required>
                                            <label class="ml-3" for="account_{{ $account->id }}">
                                                <span class="block text-navy-900 font-semibold text-lg">
                                                    {{ ucwords(strtolower($account->name)) }}
                                                </span>
                                                <span class="block text-gray-600 text-sm">
                                                    {{ $account->email }}
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="mt-6">
                                    <div class="button-wrapper">
                                        <button type="submit" class="w-full bg-navy-900 text-white px-6 py-3 rounded-lg font-medium hover:bg-navy-800 focus:outline-none focus:ring-2 focus:ring-navy-900 focus:ring-offset-2 transition-all duration-300 flex items-center justify-center">
                                            <span class="button-content">
                                                <i class="fas fa-check-circle mr-2"></i>
                                                {{ __('cargo::view.claim_selected_account') }}
                                            </span>
                                        </button>
                                        <div class="button-overlay">
                                            <div class="loading-line"></div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="relative my-8">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="px-4 bg-white text-gray-500 text-sm">{{ __('cargo::view.or') }}</span>
                            </div>
                        </div>

                        <div>
                            <h5 class="text-navy-900 text-xl font-semibold mb-4 flex items-center">
                                <i class="fas fa-plus-circle text-yellow-500 mr-2"></i>
                                {{ __('cargo::view.or_create_new') }}
                            </h5>
                            <form action="{{ route('clients.process-claim') }}" method="POST" class="create-form">
                                @csrf
                                <div class="button-wrapper">
                                    <button type="submit" class="w-full bg-yellow-400 text-navy-900 px-6 py-3 rounded-lg font-medium hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-all duration-300 flex items-center justify-center">
                                        <span class="button-content">
                                            <i class="fas fa-user-plus mr-2"></i>
                                            {{ __('cargo::view.create_new_account') }}
                                        </span>
                                    </button>
                                    <div class="button-overlay">
                                        <div class="loading-line"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-info-circle text-blue-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-blue-700">{{ __('cargo::view.no_similar_accounts') }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden form with initial registration data -->
                    <form action="{{ route('register.request') }}" method="POST" id="initialRegistrationForm" class="register-form">
                        @csrf
                        @if(isset($registration_data))
                            @foreach($registration_data as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                        @endif
                        <div class="button-wrapper">
                            <button type="submit" class="w-full bg-yellow-400 text-navy-900 px-6 py-3 rounded-lg font-medium hover:bg-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:ring-offset-2 transition-all duration-300 flex items-center justify-center">
                                <span class="button-content">
                                    <i class="fas fa-user-plus mr-2"></i>
                                    Proceed with registration
                                </span>
                            </button>
                            <div class="button-overlay">
                                <div class="loading-line"></div>
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