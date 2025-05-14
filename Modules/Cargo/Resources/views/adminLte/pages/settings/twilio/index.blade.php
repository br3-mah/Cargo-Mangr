@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    Twilio SMS Settings
@endsection

@section('content')
<div class="py-4">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark-blue text-white py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-sms mr-2"></i>Twilio SMS Configuration
                    </h5>
                </div>
                
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3 border-left border-success border-left-wide" role="alert">
                        <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                
                <div class="card-body p-4">
                    <p class="text-muted mb-4">Configure your Twilio credentials to enable SMS notifications in the system.</p>
                    
                    <form action="{{ route('twilio.settings.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-bold text-dark-blue">Account SID</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-dark-blue text-white"><i class="fas fa-key"></i></span>
                                </div>
                                <input type="text" name="account_sid" value="{{ old('account_sid', $setting->account_sid ?? '') }}" class="form-control" placeholder="Enter your Twilio Account SID" required>
                            </div>
                            <small class="form-text text-muted">You can find this in your Twilio dashboard</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-dark-blue">Auth Token</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-dark-blue text-white"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" name="auth_token" value="{{ old('auth_token', $setting->auth_token ?? '') }}" class="form-control" placeholder="Enter your Twilio Auth Token" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <small class="form-text text-muted">Keep this secure and never share with anyone</small>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-dark-blue">From Number</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-dark-blue text-white"><i class="fas fa-phone"></i></span>
                                </div>
                                <input type="text" name="from_number" value="{{ old('from_number', $setting->from_number ?? '') }}" class="form-control" placeholder="+260772147755" required>
                            </div>
                            <small class="form-text text-muted">Include country code (e.g., +26 for Zambia)</small>
                        </div>

                        <div class="form-group mt-4">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="enabled" class="custom-control-input" id="enabledCheck" value="1" {{ old('enabled', $setting->enabled ?? false) ? 'checked' : '' }}>
                                <label class="custom-control-label font-weight-bold" for="enabledCheck">Enable Twilio SMS</label>
                            </div>
                            <small class="form-text text-muted">Turn on to activate SMS notifications</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left mr-1"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary bg-accent-yellow text-dark font-weight-bold border-0">
                                <i class="fas fa-save mr-1"></i> Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-dark-blue {
        background-color: #102B4C !important;
    }
    
    .text-dark-blue {
        color: #102B4C !important;
    }
    
    .bg-accent-yellow {
        background-color: #FFCC00 !important;
    }
    
    .btn-primary.bg-accent-yellow:hover {
        background-color: #F0C000 !important;
    }
    
    .border-left-wide {
        border-left-width: 4px !important;
    }
    
    .card {
        border-radius: 0.5rem;
    }
    
    .card-header {
        border-top-left-radius: 0.5rem !important;
        border-top-right-radius: 0.5rem !important;
    }
    
    .form-control {
        border-radius: 0.25rem;
    }
    
    .input-group-text {
        border: none;
    }
</style>

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle password visibility
        $('.toggle-password').click(function() {
            const input = $(this).closest('.input-group').find('input');
            const icon = $(this).find('i');
            
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('fa-eye').addClass('fa-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('fa-eye-slash').addClass('fa-eye');
            }
        });
    });
</script>
@endpush
@endsection