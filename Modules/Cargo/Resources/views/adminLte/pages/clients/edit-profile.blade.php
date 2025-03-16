@extends('cargo::adminLte.layouts.master')

@php
$user_role = auth()->user()->role;
$admin = 1;

$hasAvatar = isset($model) && $model->img;
$getAvatar = $hasAvatar ? $model->img : '';

$is_def_mile_or_fees = Modules\Cargo\Entities\ShipmentSetting::getVal('is_def_mile_or_fees');
@endphp
@include('cargo::adminLte.components.inputs.phone')

@section('pageTitle')
    Account Settings
@endsection
@section('content')
    <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="general-info-tab" data-bs-toggle="tab" data-bs-target="#general-info" role="tab" aria-controls="general-info" aria-selected="true">General Information</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="two-fa-tab" data-bs-toggle="tab" data-bs-target="#two-fa" role="tab" aria-controls="two-fa" aria-selected="false">2-Factor Authentication</a>
        </li>
    </ul>

    <div class="tab-content mt-4" id="settingsTabsContent">
        <div class="tab-pane fade show active" id="general-info" role="tabpanel" aria-labelledby="general-info-tab">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <div class="card-title m-0">
                        <h3 class="fw-bolder m-0">{{ __('cargo::view.edit_profile') }} - {{ $model->name }}</h3>
                    </div>
                </div>
                <div>
                    <!--begin::Form-->
                    <form id="kt_account_profile_details_form" class="form"
                        action="{{ fr_route('clients.update', ['client' => $model->id]) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body border-top p-9">
                            <div class="row mb-6">
                                <label class="col-form-label fw-bold fs-6">{{ __('cargo::view.table.avatar') }}</label>
                                <div class="col-md-12">
                                    <div class="container">
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <input
                                                    type="file"
                                                    id="imageUpload"
                                                    class="form-control d-none"
                                                    accept="image/jpeg,image/png,image/gif,image/webp"
                                                    name="image"
                                                >
                                                <label
                                                    for="imageUpload"
                                                    class="btn btn-primary w-100"
                                                >
                                                    Choose Image
                                                </label>

                                                <div id="fileInfo" class="text-muted mt-2 small"></div>

                                                <div
                                                    id="previewContainer"
                                                    class="mt-3 position-relative d-none"
                                                >
                                                    <div class="preview-wrapper" style="width: 200px; height: 200px; overflow: hidden; position: relative;">
                                                        <img
                                                            id="previewImage"
                                                            class="img-fluid position-absolute top-50 start-50 translate-middle"
                                                            style="min-width: 100%; min-height: 100%; object-fit: cover;"
                                                        >
                                                        <button
                                                            id="removeImageBtn"
                                                            class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle"
                                                        >
                                                            ×
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                    document.addEventListener('DOMContentLoaded', () => {
                                        const upload = document.getElementById('imageUpload');
                                        const preview = document.getElementById('previewImage');
                                        const previewContainer = document.getElementById('previewContainer');
                                        const fileInfo = document.getElementById('fileInfo');
                                        const removeBtn = document.getElementById('removeImageBtn');

                                        const showError = (message) => {
                                            fileInfo.textContent = message;
                                            fileInfo.className = 'text-danger mt-2 small';
                                            upload.value = '';
                                        };

                                        upload.addEventListener('change', (e) => {
                                            const file = e.target.files[0];
                                            if (!file) return;

                                            const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                                            if (!validTypes.includes(file.type)) {
                                                return showError('Invalid file type. Use JPEG, PNG, GIF, or WebP.');
                                            }

                                            if (file.size > 5 * 1024 * 1024) {
                                                return showError('File too large. Maximum 5MB.');
                                            }

                                            const reader = new FileReader();
                                            reader.onload = (e) => {
                                                preview.src = e.target.result;
                                                previewContainer.classList.remove('d-none');
                                                fileInfo.textContent = file.name;
                                                fileInfo.className = 'text-muted mt-2 small';
                                            };
                                            reader.readAsDataURL(file);
                                        });

                                        removeBtn.addEventListener('click', () => {
                                            upload.value = '';
                                            previewContainer.classList.add('d-none');
                                            fileInfo.textContent = '';
                                        });
                                    });
                                    </script>


                                    @error('avatar')
                                        <div class="is-invalid"></div>
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror

                                </div>
                            </div>
                            <div class="row mb-6">
                                <label
                                    class="col-form-label fw-bold fs-6 required">{{ __('cargo::view.table.full_name') }}</label>
                                <div class="col-lg-12 fv-row">
                                    <div class="input-group mb-4">
                                        <input type="text" name="name"
                                            class="form-control form-control-lg @error('name') is-invalid @enderror"
                                            placeholder="{{ __('cargo::view.table.full_name') }}"
                                            value="{{ old('name', isset($model) ? $model->name : '') }}" />
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <label class="col-form-label fw-bold fs-6 required">{{ __('cargo::view.table.email') }}</label>
                                <div class="col-lg-12 fv-row">
                                    <div class="input-group mb-4">
                                        <input type="text" name="email"
                                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                                            placeholder="{{ __('cargo::view.table.email') }}"
                                            value="{{ old('email', isset($model) ? $model->email : '') }}" />
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <div class="col-lg-6 fv-row">
                                    <label class="col-form-label fw-bold fs-6 ">{{ __('cargo::view.table.password') }}</label>
                                    <div class="input-group mb-4">
                                        <input type="password" id="password" name="password"
                                            class="form-control form-control-lg has-feedback @error('password') is-invalid @enderror"
                                            placeholder="{{ __('cargo::view.table.password') }}"
                                            value="{{ old('password', isset($model) ? $model->password : '') }}" />
                                        <i id="check" class="far fa-eye" id="togglePassword"
                                            style="cursor: pointer;position: absolute;right: 0;padding: 3%;font-size: 16px;"></i>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 fv-row">
                                <label
                                    class="col-form-label fw-bold fs-6 required">{{ __('cargo::view.table.owner_national_id') }}</label>

                                <div class="input-group mb-4">
                                    <input type="text" name="national_id"
                                        class="form-control form-control-lg @error('national_id') is-invalid @enderror"
                                        placeholder="{{ __('cargo::view.table.owner_national_id') }}"
                                        value="{{ old('national_id', isset($model) ? $model->national_id : '') }}" />
                                    @error('national_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="row mb-6">
                                <div class="col-lg-6 fv-row">
                                    <label
                                        class="col-form-label fw-bold fs-6 required">{{ __('cargo::view.table.owner_name') }}</label>
                                    <div class="input-group mb-4">
                                        <input type="text" name="responsible_name"
                                            class="form-control form-control-lg @error('responsible_name') is-invalid @enderror"
                                            placeholder="{{ __('cargo::view.table.owner_name') }}"
                                            value="{{ old('responsible_name', isset($model) ? $model->responsible_name : '') }}" />
                                        @error('responsible_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 fv-row">
                                    <label
                                        class="col-form-label fw-bold fs-6 required">{{ __('cargo::view.table.owner_phone') }}</label>
                                    <div class="input-group mb-4">
                                        <input type="tel" name="responsible_mobile"  id="phone" dir="ltr" autocomplete="off" required  class=" phone_input number-only form-control form-control-lg  inptFielsd @error('responsible_mobile') is-invalid @enderror" placeholder="{{ __('cargo::view.table.owner_phone') }}" value="{{ old('responsible_mobile', isset($model) ? $model->country_code.$model->responsible_mobile :  base_country_code()) }}" />
                                        <input type="hidden" class="country_code" name="country_code" value="{{ old('country_code', isset($model) ? $model->country_code : base_country_code()) }}" data-reflection="phone">
                                        @error('responsible_mobile')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-6">
                                <div class="col-lg-12 fv-row">
                                    <label
                                        class="col-form-label fw-bold fs-6 required">{{ __('cargo::view.table.address') }}</label>
                                    <div class="input-group mb-4">
                                        <input type="text" name="address"
                                            class="form-control form-control-lg @error('address') is-invalid @enderror"
                                            placeholder="{{ __('cargo::view.table.address') }}"
                                            value="{{ old('address', isset($model) ? $model->address : '') }}" />
                                        @error('address')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                                <div class="fv-row col-lg-12 form-group">
                                    <input type="hidden" name="branch_id"
                                        class="form-control form-control-lg @error('branch_id') is-invalid @enderror"
                                        value="{{ old('branch_id', isset($model) ? $model->branch_id : '') }}" />
                                </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <a href="{{ url()->previous() }}"
                                class="btn btn-light btn-active-light-primary me-2">@lang('view.discard')</a>
                            <button type="submit" class="btn btn-success"
                                id="kt_account_profile_details_submit">@lang('view.update')</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- 2-Factor Authentication Tab -->
        <div class="tab-pane fade" id="two-fa" role="tabpanel" aria-labelledby="two-fa-tab">
            @include('cargo::adminLte.account.2fa')
            {{-- <div class="card">
                <div class="card-body">
                    <h4>Enable Two-Factor Authentication</h4>
                    <p>Secure your account by enabling two-factor authentication (2FA).</p>

                    @if(!auth()->user()->two_factor_secret)
                        <form method="POST" action="{{ route('2fa.enable') }}">
                            @csrf
                            <input type="password" name="password" class="form-control input-group" placeholder="Your password">
                            <button type="submit" class="btn btn-primary">Enable 2FA</button>
                        </form>
                    @else
                        <p><strong>2FA is enabled.</strong></p>
                        <p>Scan the QR code below using your authentication app.</p>
                        <div class="my-3">{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>
                        <p>Backup Codes:</p>
                        <ul>
                            @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                                <li>{{ $code }}</li>
                            @endforeach
                        </ul>
                        <form method="POST" action="{{ route('2fa.regenerate') }}">
                            @csrf
                            <button type="submit" class="btn btn-warning">Regenerate Backup Codes</button>
                        </form>
                        <form method="POST" action="{{ route('2fa.disable') }}" class="mt-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Disable 2FA</button>
                        </form>
                    @endif
                </div>
            </div> --}}
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let triggerTabList = [].slice.call(document.querySelectorAll('#settingsTabs a'));
            triggerTabList.forEach(function (triggerEl) {
                let tabTrigger = new bootstrap.Tab(triggerEl);
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });
        });
    </script>
@endsection