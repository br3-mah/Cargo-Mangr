<x-base-layout>

    <x-slot name="pageTitle">
        {{ __('cargo::view.covered_states') }}
    </x-slot>


    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        <div class="card-header" role="button">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">Add state</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->

        <!--begin::Content-->
        <!--begin::Form-->
        <form id="kt_account_profile_details_form" class="form" action="{{route('states.store')}}" method="post">
            <!--begin::Card body-->
            <div class="card-body border-top p-9">
                @include('cargo::adminLte.pages.states.form')
            </div>
            <!--end::Card body-->
            <!--begin::Actions-->
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <a href="{{ url()->previous() }}" class="btn btn-light btn-active-light-primary me-2">@lang('view.discard')</a>
                <button type="submit" class="btnclicky btn btn-primary" id="kt_account_profile_details_submit">@lang('view.save')</button>
            </div>
            <!--end::Actions-->
        </form>
        <!--end::Form-->
        <!--end::Content-->

    </div>
    <!--end::Basic info-->

</x-base-layout>
