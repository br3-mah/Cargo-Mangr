<!-- Left navbar links -->
<ul class="navbar-nav">
    {{-- <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li> --}}
    <li class="nav-item d-sm-inline-block mobile_section">

        <a href="{{ fr_route('/') }}" target="_blank"
            class="nav-link {{ active_route('/') }}" style="display: flex; align-items: center;">
            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-globe2" viewBox="0 0 16 16">
                <path d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m7.5-6.923c-.67.204-1.335.82-1.887 1.855q-.215.403-.395.872c.705.157 1.472.257 2.282.287zM4.249 3.539q.214-.577.481-1.078a7 7 0 0 1 .597-.933A7 7 0 0 0 3.051 3.05q.544.277 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9 9 0 0 1-1.565-.667A6.96 6.96 0 0 0 1.018 7.5zm1.4-2.741a12.3 12.3 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332M8.5 5.09V7.5h2.99a12.3 12.3 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.6 13.6 0 0 1 7.5 10.91V8.5zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741zm-3.282 3.696q.18.469.395.872c.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a7 7 0 0 1-.598-.933 9 9 0 0 1-.481-1.079 8.4 8.4 0 0 0-1.198.49 7 7 0 0 0 2.276 1.522zm-1.383-2.964A13.4 13.4 0 0 1 3.508 8.5h-2.49a6.96 6.96 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667m6.728 2.964a7 7 0 0 0 2.275-1.521 8.4 8.4 0 0 0-1.197-.49 9 9 0 0 1-.481 1.078 7 7 0 0 1-.597.933M8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855q.216-.403.395-.872A12.6 12.6 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.96 6.96 0 0 0 14.982 8.5h-2.49a13.4 13.4 0 0 1-.437 3.008M14.982 7.5a6.96 6.96 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008zM11.27 2.461q.266.502.482 1.078a8.4 8.4 0 0 0 1.196-.49 7 7 0 0 0-2.275-1.52c.218.283.418.597.597.932m-.488 1.343a8 8 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z"/>
            </svg>
            &nbsp;
            <small>
                View website
            </small>
        </a>
    </li>

    @if (check_module('Cargo'))
        @if($user_role == $auth_branch || $user_role == $auth_client || auth()->user()->can('create-shipments'))
        <li class="nav-item d-sm-inline-block mobile_section">
            <a href="{{ LaravelLocalization::localizeUrl(route('shipments.create')) }}"
                class="nav-link {{ active_route('shipments.create') }}" style="display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" fill="currentColor" class="bi bi-truck-flatbed" viewBox="0 0 16 16">
                    <path d="M11.5 4a.5.5 0 0 1 .5.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-4 0 1 1 0 0 1-1-1v-1h11V4.5a.5.5 0 0 1 .5-.5M3 11a1 1 0 1 0 0 2 1 1 0 0 0 0-2m9 0a1 1 0 1 0 0 2 1 1 0 0 0 0-2m1.732 0h.768a.5.5 0 0 0 .5-.5V8.35a.5.5 0 0 0-.11-.312l-1.48-1.85A.5.5 0 0 0 13.02 6H12v4a2 2 0 0 1 1.732 1"/>
                  </svg>
                  &nbsp;
                <small>
                    @if ($user_role == 4)
                        Book new shipment
                    @else
                        {{ __('cargo::view.create_new_shipment') }}
                    @endif
                </small>
            </a>
        </li>
        @endif
    @endif
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">

    <!-- Navbar Search -->
    <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
            <form class="form-inline">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                        <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
            </form>
        </div>
    </li> -->

    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span
                class="badge badge-warning navbar-badge">{{ \Auth::user()->unreadNotifications->count() }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            @if (\Auth::user()->unreadNotifications->count() > 0)
                <span class="dropdown-item dropdown-header">{{ \Auth::user()->unreadNotifications->count() }}
                    @lang('view.notifications')</span>
                <div class="dropdown-divider"></div>
                @foreach (\Auth::user()->unreadNotifications as $key => $item)
                    <a href="{{ route('notification.view', ['id' => $item->id]) }}" class="dropdown-item">
                        <i
                            class="@if ($item->icon) {{ $item->icon }} @else fas fa-bell @endif mr-2"></i>
                        {{ $item->data['message']['subject'] }}
                        <span
                            class="float-right text-muted text-sm ml-2">{{ $item->created_at->diffForHumans(null, null, true) }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @endforeach
                <a href="#" class="dropdown-item dropdown-footer">@lang('view.see_all_notifications')</a>
            @else
                <!--begin::Nav-->
                <span class="dropdown-item dropdown-header">@lang('view.no_new_notifications')</span>
                <div class="dropdown-divider"></div>
                <!--end::Nav-->
            @endif
        </div>
    </li>

    <!-- User Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="fas fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">{{ auth()->user()->name }}</span>
            <div class="dropdown-divider"></div>
            @checkModule('users')

            {{-- Admin --}}
            @if ($user_role == $admin)
                <a href="{{ fr_route('users.show', ['id' => auth()->id()]) }}" class="dropdown-item">
                    @lang('users::view.my_profile')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ fr_route('users.edit', ['id' => auth()->id()]) }}" class="dropdown-item">
                    @lang('users::view.account_settings')
                </a>
                <div class="dropdown-divider"></div>
            @endif

            {{-- client --}}
            @if ($user_role == $auth_client)
                @php
                    $item_id = Modules\Cargo\Entities\Client::where('user_id', auth()->user()->id)
                        ->pluck('id')
                        ->first();
                @endphp

                <a href="{{ fr_route('clients.show', ['client' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.my_profile')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ fr_route('clients.profile', ['id' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.account_settings')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ fr_route('clients.manage-address') }}" class="dropdown-item">
                    Manage Address Book
                    {{-- @lang('cargo::view.manage_address') --}}
                </a>
                <div class="dropdown-divider"></div>
            @endif

            {{-- branch --}}
            @if ($user_role == $auth_branch)
                @php
                    $item_id = Modules\Cargo\Entities\Branch::where('user_id', auth()->user()->id)
                        ->pluck('id')
                        ->first();
                @endphp
                <a href="{{ fr_route('branches.show', ['branch' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.my_profile')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ fr_route('branches.profile', ['id' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.account_settings')
                </a>
                <div class="dropdown-divider"></div>
            @endif


            {{-- driver --}}
            @if ($user_role == $auth_dilver)
                @php
                    $item_id = Modules\Cargo\Entities\Driver::where('user_id', auth()->user()->id)
                        ->pluck('id')
                        ->first();
                @endphp
                <a href="{{ fr_route('drivers.show', ['driver' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.my_profile')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ fr_route('drivers.profile', ['id' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.account_settings')
                </a>
                <div class="dropdown-divider"></div>
            @endif


            {{-- staff --}}
            @if ($user_role == $auth_staff)
                @php
                    $item_id = Modules\Cargo\Entities\Staff::where('user_id', auth()->user()->id)
                        ->pluck('id')
                        ->first();
                @endphp
                <a href="{{ fr_route('staffs.show', ['staff' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.my_profile')
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ fr_route('staffs.profile', ['id' => $item_id]) }}" class="dropdown-item">
                    @lang('users::view.account_settings')
                </a>
                <div class="dropdown-divider"></div>
            @endif



            @endcheckModule
            <form id="formLogout" method="POST" action="{{ fr_route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">@lang('view.sign_out')</button>
            </form>
            <div class="dropdown-divider"></div>
        </div>
    </li>

    <!-- Language Dropdown Menu -->
    <li class="nav-item dropdown">
        @if (check_module('Localization'))
            <a class="nav-link" data-toggle="dropdown" href="#">
                @if (Config::get('current_lang_image'))
                    <img src="{{ Config::get('current_lang_image') }}" alt="" class="flag-icon mx-1" />
                @endif{{ LaravelLocalization::getCurrentLocaleName() }}
            </a>
            <div class="dropdown-menu dropdown-menu-right p-0">
                @foreach (Modules\Localization\Entities\Language::all() as $key => $language  )
                {{-- {{ dd($language) }} --}}
                    <a href="{{ LaravelLocalization::getLocalizedURL($language->code) }}" class="dropdown-item">
                        @if ($language->imageUrl)
                            <img class="flag-icon mr-2" src="{{ $language->imageUrl }}" alt="" />
                        @endif {{ $language->name }}
                    </a>
                @endforeach
            </div>
        @endif
    </li>

    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
    <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <i class="fas fa-th-large"></i>
        </a>
    </li> -->
</ul>
