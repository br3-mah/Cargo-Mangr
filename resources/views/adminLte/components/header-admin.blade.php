<!-- Left navbar links -->
<ul class="navbar-nav d-flex align-items-center">
    <!-- Toggle Menu Button -->
    <li class="nav-item">
        <a class="nav-link px-2 text-primary-hover transition-all" data-widget="pushmenu" href="#" role="button">
            <i class="fas fa-bars fa-fw"></i>
        </a>
    </li>

    <!-- Divider -->
    <li class="nav-item d-none d-sm-block">
        <div class="border-end h-75 mx-2 opacity-25"></div>
    </li>

    <!-- Website Link -->
    <li class="nav-item d-sm-inline-block mobile_section">
        <a href="https://www.newworldcargo.com"
           target="_blank"
           class="nav-link px-2 {{ active_route('/') }} d-flex align-items-center">
            <i class="fas fa-globe fa-fw me-1"></i>
            <span class="font-weight-medium">Website</span>
        </a>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">
    <!-- Currency Conversion Button -->

    @if ($defcurrency->code == 'ZMW')
    <li class="nav-item dropdown">
        <a class="nav-link d-flex align-items-center bg-light rounded-pill px-3 py-2 border-0" href="#" data-toggle="modal" data-target="#currencyModal">
            <span class="text-primary mr-2">{{ number_format(current_x_rate(), 2) }}</span>
            <i class="fas fa-money-bill-wave text-info animated-icon"></i>
        </a>
    </li>
    @endif
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
                <span class="dropdown-item dropdown-header">@lang('view.no_new_notifications')</span>
                <div class="dropdown-divider"></div>
            @endif
        </div>
    </li>

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
                    @lang('cargo::view.manage_address')
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
</ul>

