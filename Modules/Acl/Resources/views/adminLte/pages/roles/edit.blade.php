<x-base-layout>

    <x-slot name="pageTitle">
        {{ __('acl::view.edit_role') }} - {{$model->name}}
    </x-slot>

    
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __('acl::view.edit_role') }}</h3>
            </div>
            <!--end::Card title-->

        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div id="kt_account_profile_details" class="collapse show">
            <!--begin::Form-->
            <form id="kt_account_profile_details_form" class="form" action="{{ route('roles.update', ['id' => $model->id]) }}" method="post">
                @method('PUT')
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    @include('acl::adminLte.pages.roles.form', ['typeForm' => 'edit'])
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-active-light-primary me-2">@lang('view.discard')</a>
                    <button type="submit" class="btn btn-success btnclicky" id="kt_account_profile_details_submit">
                        <span class="btn-text">@lang('view.update')</span>
                        <span class="btn-loader d-none">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            <span class="ms-2">Updating...</span>
                        </span>
                    </button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('kt_account_profile_details_form');
            const submitBtn = document.getElementById('kt_account_profile_details_submit');
            const btnText = submitBtn.querySelector('.btn-text');
            const btnLoader = submitBtn.querySelector('.btn-loader');

            form.addEventListener('submit', function(e) {
                // Disable the submit button
                submitBtn.disabled = true;
                
                // Hide the text and show the loader
                btnText.classList.add('d-none');
                btnLoader.classList.remove('d-none');
                
                // Optional: Add a class to change button appearance
                submitBtn.classList.add('btn-loading');
            });

            // Optional: Re-enable button if form submission fails (useful for validation errors)
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    // Reset button state if user navigates back
                    submitBtn.disabled = false;
                    btnText.classList.remove('d-none');
                    btnLoader.classList.add('d-none');
                    submitBtn.classList.remove('btn-loading');
                }
            });
        });
    </script>

    <style>
        .btn-loading {
            opacity: 0.8;
            cursor: not-allowed;
        }
        
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
        }
    </style>

</x-base-layout>