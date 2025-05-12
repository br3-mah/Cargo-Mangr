@extends('adminLte.auth.layout')

@section('pageTitle')
    Verify OTP
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <div class="text-center">
                        <img src="https://www.newworldcargo.com/images/logo.png" alt="Secure Verification" width="60" class="mb-3">
                        <h3 class="font-weight-bold text-primary">Verify Your Account</h3>
                        <p class="text-muted">We've sent a 6-digit code to your email {{ Auth::user()->email ?? '' }}</p>
                    </div>
                </div>
                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('otp.verify') }}" method="POST" id="otpForm">
                        @csrf
                        <div class="form-group">
                            <div class="otp-input-group d-flex justify-content-between mb-4">
                                @for ($i = 1; $i <= 6; $i++)
                                    <input type="text" name="otp_digit{{$i}}" id="otp_digit{{$i}}"
                                           class="form-control otp-input text-center"
                                           maxlength="1" autocomplete="off">
                                @endfor
                                <input type="hidden" name="otp" id="complete_otp">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg">
                            <i class="fas fa-shield-alt mr-2"></i>Verify & Continue
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <p class="text-muted">Didn't receive the code? <span id="timer" class="font-weight-bold">00:30</span></p>
                        <form action="{{ route('otp.resend') }}" method="POST" id="resendForm">
                            @csrf
                            <button type="submit" id="resendBtn" class="btn btn-outline-secondary" disabled>
                                <i class="fas fa-sync-alt mr-1"></i>Resend Code
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-footer bg-white border-top-0 text-center pb-4">
                    <a href="{{ route('signin') }}" class="text-decoration-none">
                        <i class="fas fa-arrow-left mr-1"></i>Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.otp-input {
    width: 55px;
    height: 55px;
    font-size: 1.5rem;
    font-weight: bold;
    border-radius: 12px;
    border: 2px solid #dee2e6;
    transition: all 0.2s;
}

.otp-input:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.alert {
    border-radius: 10px;
    border-left: 4px solid;
}

.alert-success {
    border-left-color: #28a745;
}

.alert-danger {
    border-left-color: #dc3545;
}

.card {
    border-radius: 15px;
    border: none;
}

.btn-primary {
    border-radius: 8px;
    padding: 12px;
    transition: all 0.3s;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
}

.btn-outline-secondary {
    border-radius: 8px;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const otpInputs = document.querySelectorAll('.otp-input');
    const completeOtp = document.getElementById('complete_otp');
    const otpForm = document.getElementById('otpForm');
    const resendBtn = document.getElementById('resendBtn');
    const timerElement = document.getElementById('timer');

    // Focus on first input
    otpInputs[0].focus();

    // Handle input and auto-focus next field
    otpInputs.forEach((input, index) => {
        input.addEventListener('keyup', function(e) {
            if (e.key >= '0' && e.key <= '9') {
                // Auto focus next input
                if (index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }

                // Update hidden complete otp field
                updateCompleteOtp();
            } else if (e.key === 'Backspace') {
                // Handle backspace
                if (index > 0 && input.value === '') {
                    otpInputs[index - 1].focus();
                }
            }
        });

        // Handle paste event
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text');
            const digits = pastedData.replace(/\D/g, '').split('').slice(0, 6);

            if (digits.length > 0) {
                digits.forEach((digit, i) => {
                    if (i < otpInputs.length) {
                        otpInputs[i].value = digit;
                    }
                });

                updateCompleteOtp();

                // Focus on appropriate field
                if (digits.length < 6) {
                    otpInputs[digits.length].focus();
                } else {
                    otpInputs[5].focus();
                }
            }
        });
    });

    // Update hidden input with complete OTP
    function updateCompleteOtp() {
        let otp = '';
        otpInputs.forEach(input => {
            otp += input.value;
        });
        completeOtp.value = otp;
    }

    // Countdown timer for resend button
    let timeLeft = 30;
    let countdownTimer = setInterval(function() {
        timeLeft--;

        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;

        timerElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft <= 0) {
            clearInterval(countdownTimer);
            resendBtn.disabled = false;
            timerElement.textContent = '';
        }
    }, 1000);

    // Submit form when all digits are entered
    function tryAutoSubmit() {
        let isFilled = true;
        otpInputs.forEach(input => {
            if (!input.value) {
                isFilled = false;
            }
        });

        if (isFilled) {
            updateCompleteOtp();
            // Allow a small delay before submitting
            setTimeout(() => {
                otpForm.submit();
            }, 300);
        }
    }

    // Check for auto-submit after each input
    otpInputs.forEach(input => {
        input.addEventListener('input', tryAutoSubmit);
    });
});
</script>
@endsection