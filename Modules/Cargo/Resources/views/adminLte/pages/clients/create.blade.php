@php
    $countries = Modules\Cargo\Entities\Country::where('covered',1)->get();
@endphp

@extends('cargo::adminLte.layouts.master')

@section('pageTitle')
    {{ __('cargo::view.create_new_client') }}
@endsection

@section('content')
    
    <!--begin::Basic info-->
    <div class="card mb-5 mb-xl-10">
        <!--begin::Card header-->
        {{-- <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details"> --}}
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">{{ __('cargo::view.create_new_client') }}</h3>
            </div>
            <!--end::Card title-->
        </div>
        <!--begin::Card header-->
        <!--begin::Content-->
        <div class="mp-5">
            @if(auth()->user()->can('add-covered-countries') || $user_role == $admin )
                @if(count($countries) == 0 || Modules\Cargo\Entities\State::where('covered', 1)->count() == 0)
                <div class="row">
                    <div class=" notification alert alert-danger col-lg-8" style="margin: auto;margin-top:10px;" role="alert">
                        {{ __('cargo::view.please_configure_your_covered_countries_and_regions') }},
                        <a class="alert-link" href="{{ route('countries.index') }}">{{ __('cargo::view.configure_now') }}</a>
                    </div>
                </div>
                @endif
            @endif

            @if(auth()->user()->can('manage-areas') || $user_role == $admin )
                @if(Modules\Cargo\Entities\Area::count() == 0)
                <div class="row">
                    <div class=" notification alert alert-danger col-lg-8" style="margin: auto;margin-top:10px;" role="alert">
                        {{ __('cargo::view.please_add_areas_before_creating_your_first_shipment') }},
                        <a class="alert-link" href="{{ route('areas.create') }}">{{ __('cargo::view.configure_now') }}</a>
                    </div>
                </div>
                @endif
            @endif


            @if(auth()->user()->can('manage-branches') || $user_role == $admin )
                @if($branches->count() == 0)
                <div class="row">
                    <div class=" notification alert alert-danger col-lg-8" style="margin: auto;margin-top:10px;" role="alert">
                        {{ __('cargo::view.please_add_branches_types_before_creating_your_first_shipment') }},
                        <a class="alert-link" href="{{ route('branches.create') }}">{{ __('cargo::view.configure_now') }}</a>
                    </div>
                </div>
                @endif
            @endif
        </div>
        <div>
            <!--begin::Form-->
            <form id="kt_account_profile_details_form" class="form" action="{{ fr_route('clients.store') }}" method="post" enctype="multipart/form-data">
                <!--begin::Card body-->
                <div class="card-body border-top p-9">
                    @include('cargo::adminLte.pages.clients.form', ['typeForm' => 'create'])
                </div>
                <!--end::Card body-->
                <!--begin::Actions-->
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ url()->previous() }}" class="btn btn-light btn-active-light-primary me-2">@lang('view.discard')</a>
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">@lang('view.create')</button>
                </div>
                <!--end::Actions-->
            </form>
            <!--end::Form-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Basic info-->

@endsection