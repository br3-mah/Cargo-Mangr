    <!--begin::Navbar-->
@php
$user_role = auth()->user()->role;
$admin  = 1;
$branch  = 3;
$user = App\Models\User::where('id', $model->user_id)->first();
$model_tran = Modules\Cargo\Entities\Transaction::where('client_id', $model->id)->sum('value');
@endphp

<div class="card shadow-lg border-0 rounded-4 mb-8">
<!-- Header with tabs - always visible -->
<div class="card-header bg-light p-0 position-relative border-0">
    <div class="position-absolute start-0 top-0 ps-8 pt-7 z-index-3">
        <div class="symbol symbol-70px symbol-circle me-5 mb-2 d-none d-md-inline-flex">
            <img src="{{ $model->avatar ? Storage::url($model->avatar) : asset('assets/img/blank.png') }}" class="h-100 w-100 object-fit-cover" />
            <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-3 border-white h-15px w-15px"></div>
        </div>
    </div>
    
    <div class="d-flex justify-content-end overflow-auto py-2 px-5">
        <ul class="nav nav-pills nav-pills-custom border-0 flex-nowrap">
            @if(auth()->user()->can('view-clients') || $user_role == $admin || $user_role == $branch)
                <li class="nav-item">
                    <a class="nav-link rounded-pill {{ active_route('clients.show', $model->id) ? 'active' : 'text-gray-600' }} px-5" href="{{ fr_route('clients.show', $model->id) }}">{{ __('view.overview') }}</a>
                </li>
            @endif
            
            @if(auth()->user()->can('edit-customers') || $user_role == $admin || $user_role == $branch)
                <li class="nav-item">
                    <a class="nav-link rounded-pill {{ active_route('clients.edit', $model->id) ? 'active' : 'text-gray-600' }} px-5" href="{{ fr_route('clients.edit', $model->id) }}">{{ __('view.edit') }}</a>
                </li>
            @endif
        </ul>
    </div>
</div>

<!-- Main content area with profile details -->
<div class="card-body pt-9 pb-0">
    <div class="row g-0">
        <!-- Left column for mobile view of profile image -->
        <div class="col-12 d-flex d-md-none mb-7 justify-content-center">
            <div class="symbol symbol-100px symbol-circle mb-3">
                <img src="{{ $model->avatar ? Storage::url($model->avatar) : asset('assets/img/blank.png') }}" class="h-100 w-100 object-fit-cover" />
                <div class="position-absolute bottom-0 end-0 bg-success rounded-circle border border-3 border-white h-20px w-20px"></div>
            </div>
        </div>
        
        <!-- Center column: User details -->
        <div class="col-12 col-md-8 px-5 ps-md-8">
            <div class="ms-md-9">
                <!-- User name and verification -->
                <div class="d-flex align-items-center flex-wrap mb-1">
                    <h2 class="text-gray-900 fs-1 fw-bolder me-2 mb-0">{{ $model->name }}</h2>
                    <div class="d-flex align-items-center mb-md-2">
                        <span class="svg-icon svg-icon-primary svg-icon-1 mx-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24">
                                <path d="M10.0813 3.7242C10.8849 2.16438 13.1151 2.16438 13.9187 3.7242V3.7242C14.4016 4.66147 15.4909 5.1127 16.4951 4.79139V4.79139C18.1663 4.25668 19.7433 5.83365 19.2086 7.50485V7.50485C18.8873 8.50905 19.3385 9.59842 20.2758 10.0813V10.0813C21.8356 10.8849 21.8356 13.1151 20.2758 13.9187V13.9187C19.3385 14.4016 18.8873 15.491 19.2086 16.4951V16.4951C19.7433 18.1663 18.1663 19.7433 16.4951 19.2086V19.2086C15.491 18.8873 14.4016 19.3385 13.9187 20.2758V20.2758C13.1151 21.8356 10.8849 21.8356 10.0813 20.2758V20.2758C9.59842 19.3385 8.50905 18.8873 7.50485 19.2086V19.2086C5.83365 19.7433 4.25668 18.1663 4.79139 16.4951V16.4951C5.1127 15.491 4.66147 14.4016 3.7242 13.9187V13.9187C2.16438 13.1151 2.16438 10.8849 3.7242 10.0813V10.0813C4.66147 9.59842 5.1127 8.50905 4.79139 7.50485V7.50485C4.25668 5.83365 5.83365 4.25668 7.50485 4.79139V4.79139C8.50905 5.1127 9.59842 4.66147 10.0813 3.7242V3.7242Z" fill="#00A3FF" />
                                <path class="permanent" d="M14.8563 9.1903C15.0606 8.94984 15.3771 8.9385 15.6175 9.14289C15.858 9.34728 15.8229 9.66433 15.6185 9.9048L11.863 14.6558C11.6554 14.9001 11.2876 14.9258 11.048 14.7128L8.47656 12.4271C8.24068 12.2174 8.21944 11.8563 8.42911 11.6204C8.63877 11.3845 8.99996 11.3633 9.23583 11.5729L11.3706 13.4705L14.8563 9.1903Z" fill="white" />
                            </svg>
                        </span>
                        <span class="badge badge-sm fw-bold px-3 fs-8 bg-{{ $model->role == 1 ? 'success' : 'primary' }} text-white ms-2">{{ $user->user_role }}</span>
                    </div>
                </div>
                
                <!-- User email -->
                <div class="d-flex align-items-center mb-4">
                    <span class="svg-icon svg-icon-4 text-gray-500 me-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none">
                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor" />
                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <a href="mailto:{{ $model->email }}" class="text-gray-600 text-hover-primary fs-6">{{ $model->email }}</a>
                </div>
            </div>
        </div>
        
        <!-- Right column: Stats -->
        <div class="col-12 col-md-4 ps-5 pe-5 border-start-md">
            <h4 class="text-gray-600 fs-6 fw-semibold mb-3">Statistics</h4>
            <div class="row g-4">
                <div class="col-6">
                    <a @if(auth()->user()->can('manage-transactions')) href="{{ fr_route('transactions.index',['client_id' => $model->id ]) }}"@else href="{{ fr_route('transactions.index') }}" @endif class="text-decoration-none">
                        <div class="bg-light-primary bg-opacity-70 rounded-4 p-4 h-100 position-relative overflow-hidden">
                            <span class="svg-icon svg-icon-3 svg-icon-primary position-absolute opacity-15" style="right: -10px; bottom: -10px; width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                </svg>
                            </span>
                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{__('cargo::view.transacations')}}</div>
                            <div class="d-flex align-items-center">
                                <div class="fs-2 fw-bolder text-gray-800" data-kt-countup="true" data-kt-countup-value="{{$model_tran}}" data-kt-countup-prefix="{{currency_symbol()}}">0</div>
                            </div>
                        </div>
                    </a>
                </div>
                
                <div class="col-6">
                    <a @if(auth()->user()->can('manage-shipments')) href="{{ fr_route('shipments.index',['client_id' => $model->id ])}}" @else href="{{ fr_route('shipments.index')}}" @endif class="text-decoration-none">
                        <div class="bg-light-success bg-opacity-70 rounded-4 p-4 h-100 position-relative overflow-hidden">
                            <span class="svg-icon svg-icon-3 svg-icon-success position-absolute opacity-15" style="right: -10px; bottom: -10px; width: 80px; height: 80px;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                    <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                </svg>
                            </span>
                            <div class="fw-bold fs-7 text-gray-600 mb-1">{{__('cargo::view.shipments')}}</div>
                            <div class="d-flex align-items-center">
                                <div class="fs-2 fw-bolder text-gray-800" data-kt-countup="true" data-kt-countup-value="{{$shipments}}">0</div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!--end::Navbar-->