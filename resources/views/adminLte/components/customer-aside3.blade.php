<!--begin::Aside-->
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="
    margin-bottom: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    background: rgb(255, 191, 0);
    backdrop-filter: blur(30px);
    -webkit-backdrop-filter: blur(30px);
    border: none;
    width: auto; /* Increased width */
">
    <!-- Logo Container -->
    <div class="aside-logo flex-column-auto brand-link" id="kt_aside_logo" style="
        padding: 1.5rem;
        text-align: center;
    ">
        @php
            $model = App\Models\Settings::where('group', 'general')->where('name','system_logo')->first();
        @endphp
        <a href="{{ aurl('/') }}" style="display: inline-block;">
            <img src="{{ $model->getFirstMediaUrl('system_logo') ? $model->getFirstMediaUrl('system_logo') : asset('assets/lte/cargo-logo-white.svg') }}" alt="Logo" style="height: 50px; filter: drop-shadow(0 2px 5px rgba(0, 191, 255, 0.5));" class="logo" />
        </a>
    </div>

    <div class="sidebar" style="padding-top: 1rem;">
        <!-- User Panel with Streamlined styling -->
        <div class="user-panel mt-2 pb-3 mb-2 d-flex" style="
            padding: 0.75rem 1rem;
            align-items: center;
            margin: 0 15px;
            border-radius: 15px;
            background: rgba(0, 191, 255, 0.15);
        ">
            <div class="image">
                <img src="{{ auth()->user()->avatar ? url('storage/app/public/'.auth()->user()->avatar) : asset('assets/lte/media/avatars/blank.png') }}"
                    class="img-circle elevation-2" alt="User Image" style="
                        width: 40px;
                        height: 40px;
                        border: 2px solid #00bfff;
                    ">
            </div>
            <div class="info" style="margin-left: 0.75rem;">
                <a href="#" class="d-block" style="
                    color: #343a40;
                    font-weight: 500;
                    text-shadow: 0 1px 2px rgba(0,0,0,0.1);
                    font-size: 0.9rem;
                ">{{ auth()->user()->name }}
                    <span
                        class="badge {{ auth()->user()->role == 1 ? 'badge-light-success' : 'badge-light-primary' }} fw-bolder fs-8 px-2 py-1 ms-2"
                        style="
                            background: {{ auth()->user()->role == 1 ? 'rgba(0, 191, 255, 0.9)' : 'rgba(255, 255, 255, 0.9)' }};
                            color: {{ auth()->user()->role == 1 ? '#000' : '#000' }};
                            border-radius: 10px;
                            font-size: 0.7rem;
                        ">
                        {{ auth()->user()->user_role }}
                    </span>
                </a>
            </div>
        </div>

        <!--begin::Aside menu-->
        <nav class="mt-2" style="padding-bottom: 30px !important;">
            <!--begin::Aside Menu-->
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

                <!-- Dashboard Shortcut Buttons -->
                {{-- <li class="nav-item">
                    <a href="#" class="nav-link dashboard-shortcut">
                        <i class="nav-icon fas fa-plus" style="color: #00bfff;"></i>
                        <p>New Shipment</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link dashboard-shortcut">
                        <i class="nav-icon fas fa-users" style="color: #00bfff;"></i>
                        <p>Manage Clients</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ fr_route('admin.dashboard') }}" class="nav-link dashboard-shortcut {{ areActiveRoutes(['admin.dashboard']) }}">
                        <i class="nav-icon fas fa-chart-line" style="color: #00bfff;"></i>
                        <p>Dashboard</p>
                    </a>
                </li> --}}

                <li class="nav-header" style="
                    padding: 0.75rem 1rem;
                    font-size: 0.8rem;
                    text-transform: uppercase;
                    color: #00bfff;
                    letter-spacing: 0.5px;
                    margin-top: 1rem;
                ">@lang('view.pages')</li>

                @if (app('hook')->get('aside_menu'))
                    @foreach (aasort(app('hook')->get('aside_menu'), 'order') as $componentView)
                        {!! $componentView !!}
                    @endforeach
                @endif

                <li class="nav-item {{ areActiveRoutes(['shipments.report','missions.report','clients.report','drivers.report','branches.report','transactions.report'],'menu-is-opening menu-open active') }}">
                    <a href="#" class="nav-link {{ areActiveRoutes(['shipments.report','missions.report','clients.report','drivers.report','branches.report','transactions.report'],'menu-is-opening menu-open active') }}">
                        <i class="fas fa-book nav-icon" style="color: #00bfff;"></i>
                        <p>
                            {{ __('view.reports') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="padding-left: 10px;">
                        @if (app('hook')->get('aside_menu_reports'))
                            @foreach (app('hook')->get('aside_menu_reports') as $componentView)
                                {!! $componentView !!}
                            @endforeach
                        @endif
                    </ul>
                </li>
                
                 {{-- <li class="nav-item {{ areActiveRoutes(['countries.index','areas.index','deliveryTime.index','packages.index','shipments.settings.fees','shipments.settings','admin.settings','admin.settings.notifications','theme-setting.edit','languages.index','currencies.index','shipments.index','fees.index','admin.settings.google','default-theme.edit','backup.database'],'menu-is-opening menu-open active') }}">
                    <a href="#" class="nav-link {{ areActiveRoutes(['countries.index','areas.index','deliveryTime.index','packages.index','shipments.settings.fees','shipments.settings','admin.settings','admin.settings.notifications','theme-setting.edit','languages.index','currencies.index','shipments.index','fees.index','admin.settings.google','default-theme.edit','backup.database'],'menu-is-opening menu-open active') }}">
                        <i class="fas fa-cogs nav-icon" style="color: #00bfff;"></i>
                        <p>
                            {{ __('view.setting') }}
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" style="padding-left: 10px;">
                        @can('manage-setting')
                            <li class="nav-item">
                                <a href="{{ fr_route('admin.settings') }}" class="nav-link {{ areActiveRoutes(['admin.settings']) }}">
                                    <i class="fas fa-cog fa-fw" style="color: #00bfff;"></i>
                                    <p>@lang('view.general_setting')</p>
                                </a>
                            </li>
                        @endcan
                        @if (app('hook')->get('aside_menu_settings'))
                            @foreach (app('hook')->get('aside_menu_settings') as $componentView)
                                {!! $componentView !!}
                            @endforeach
                        @endif
                        @can('manage-notifications-setting')
                            <li class="nav-item">
                                <a href="{{ fr_route('admin.settings.notifications') }}" class="nav-link {{ areActiveRoutes(['admin.settings.notifications']) }}">
                                    <i class="fa fa-bell fa-fw" style="color: #00bfff;"></i>
                                    <p>@lang('view.notifications_settings')</p>
                                </a>
                            </li>
                        @endcan
                        @can('manage-google-setting')
                            <li class="nav-item">
                                <a href="{{ fr_route('admin.settings.google') }}" class="nav-link {{ areActiveRoutes(['admin.settings.google']) }}">
                                    <i class="fas fa-cog fa-fw" style="color: #00bfff;"></i>
                                    <p>@lang('view.google_settings')</p>
                                </a>
                            </li>
                        @endcan
                        @can('manage-theme-setting')
                            <li class="nav-item">
                                <a href="{{ fr_route('default-theme.edit') }}" class="nav-link {{ active_route('default-theme.edit') }}  {{ areActiveRoutes(['default-theme.edit']) }}">
                                    <i class="fab fa-affiliatetheme fa-fw" style="color: #00bfff;"></i>
                                    <p>@lang('view.themes')</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ fr_route('theme-setting.edit', ['place' => 'homepage']) }}" class="nav-link {{ active_route('theme-setting.edit', ['place' => 'homepage']) }}  {{ areActiveRoutes(['theme-setting.edit']) }}">
                                    <i class="fab fa-affiliatetheme fa-fw" style="color: #00bfff;"></i>
                                    <p>@lang('view.theme_setting')</p>
                                </a>
                            </li>
                        @endcan
                        @if (auth()->user()->can('update-system') || auth()->user()->role == 1)
                            <li class="nav-item">
                                <a href="{{ fr_route('backup.database') }}" class="nav-link {{ active_route('backup.database') }}  {{ areActiveRoutes(['backup.database']) }}">
                                    <i class="fa-brands fa-ubuntu fa-fw" style="color: #00bfff;"></i>
                                    <p>@lang('view.backup_database')</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li> --}}

                @if (auth()->user()->can('update-system') || auth()->user()->role == 1)
                    <li class="nav-item">
                        <a href="{{ fr_route('system.update') }}" class="nav-link {{ areActiveRoutes(['system.update']) }}">
                            <i class="fa-brands fa-ubuntu nav-icon" style="color: #00bfff;"></i>
                            <p>@lang('view.system_update')</p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->role == 1)
                    <li class="nav-item">
                        <a href="{{ fr_route('system.support') }}" class="nav-link {{ areActiveRoutes(['system.support']) }}">
                            <i class="fa-sharp fa-solid fa-circle-info nav-icon" style="color: #00bfff;"></i>
                            <p>{{__('cargo::view.support')}}</p>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
        <!--end::Aside menu-->
    </div> <!-- Custom bottom decoration -->
    <div style="position: sticky; bottom: 0; left: 0; right: 0; height: 60px; background: linear-gradient(to top, rgba(0,0,0,0.3), transparent); pointer-events: none;"></div>
</aside>
<!--end::Aside-->

<style>/* Enhanced Glassmorphism with Animated Background */
    .main-sidebar {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.3), rgba(0, 191, 255, 0.2));
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.2);
        position: relative;
        overflow: hidden;
        z-index: 10;
        transition: all 0.4s ease;
    }
    
    /* Animated background elements */
    .main-sidebar::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: 
            radial-gradient(circle at 10% 20%, rgba(255, 255, 255, 0.03) 0%, transparent 20%),
            radial-gradient(circle at 90% 30%, rgba(255, 255, 255, 0.03) 0%, transparent 20%),
            radial-gradient(circle at 30% 70%, rgba(255, 255, 255, 0.03) 0%, transparent 20%),
            radial-gradient(circle at 70% 60%, rgba(255, 255, 255, 0.03) 0%, transparent 20%);
        z-index: -1;
        opacity: 0.8;
        animation: backgroundShift 15s ease-in-out infinite alternate;
    }
    
    .main-sidebar::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        right: -50%;
        bottom: -50%;
        background: linear-gradient(45deg, 
            rgba(0, 191, 255, 0.1) 0%, 
            rgba(255, 193, 7, 0.1) 30%, 
            rgba(0, 191, 255, 0.1) 60%, 
            rgba(255, 193, 7, 0.1) 100%);
        z-index: -2;
        filter: blur(30px);
        animation: rotateGradient 20s linear infinite;
        opacity: 0.5;
    }
    
    /* Subtle floating particles */
    .sidebar::before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background-image: 
            radial-gradient(circle at 20% 35%, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 0.1%, transparent 0.2%),
            radial-gradient(circle at 75% 44%, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 0.1%, transparent 0.2%),
            radial-gradient(circle at 46% 52%, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 0.1%, transparent 0.2%),
            radial-gradient(circle at 60% 80%, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 0.1%, transparent 0.2%),
            radial-gradient(circle at 30% 75%, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 0.1%, transparent 0.2%),
            radial-gradient(circle at 80% 15%, rgba(255, 255, 255, 0.3) 0%, rgba(255, 255, 255, 0.3) 0.1%, transparent 0.2%);
        background-size: 120% 120%;
        z-index: -1;
        opacity: 0.6;
        pointer-events: none;
        animation: floatingParticles 10s ease infinite;
    }
    
    /* Enhanced hover effects */
    .nav-link:hover {
        background: rgba(0, 191, 255, 0.15);
        box-shadow: 0 4px 15px rgba(0, 191, 255, 0.2);
        transform: translateX(5px);
    }
    
    .nav-link.active {
        background: rgba(0, 191, 255, 0.25);
        box-shadow: 0 4px 20px rgba(0, 191, 255, 0.25);
        border-left: 3px solid #00bfff;
    }
    
    /* Animated nav items */
    .nav-link {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        position: relative;
        overflow: hidden;
    }
    
    .nav-link::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: translateX(-100%);
    }
    
    .nav-link:hover::after {
        animation: shimmer 1.5s ease-out;
    }
    
    /* User panel glow effect */
    .user-panel {
        position: relative;
        box-shadow: 0 5px 15px rgba(0, 191, 255, 0.2);
        background: rgba(0, 191, 255, 0.1);
        animation: subtlePulse 3s ease-in-out infinite alternate;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    
    .user-panel .img-circle {
        border: 2px solid #00bfff;
        box-shadow: 0 0 10px rgba(0, 191, 255, 0.6);
        transition: all 0.3s ease;
    }
    
    .user-panel:hover .img-circle {
        transform: scale(1.05);
        box-shadow: 0 0 15px rgba(0, 191, 255, 0.8);
    }
    
    /* Logo animation */
    .aside-logo img {
        transition: all 0.5s ease;
        animation: subtleFloat 4s ease-in-out infinite;
    }
    
    .aside-logo:hover img {
        filter: drop-shadow(0 5px 15px rgba(0, 191, 255, 0.8)) brightness(1.1);
        transform: scale(1.05);
    }
    
    /* Animations */
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }
    
    @keyframes subtlePulse {
        0% { box-shadow: 0 5px 15px rgba(0, 191, 255, 0.2); }
        50% { box-shadow: 0 5px 20px rgba(0, 191, 255, 0.4); }
        100% { box-shadow: 0 5px 15px rgba(0, 191, 255, 0.2); }
    }
    
    @keyframes subtleFloat {
        0% { transform: translateY(0); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0); }
    }
    
    @keyframes backgroundShift {
        0% { background-position: 0% 0%; }
        100% { background-position: 100% 100%; }
    }
    
    @keyframes rotateGradient {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    @keyframes floatingParticles {
        0% { background-position: 0% 0%; }
        50% { background-position: 100% 100%; }
        100% { background-position: 0% 0%; }
    }
    
    /* Bottom glow effect */
    .main-sidebar > div:last-child {
        background: linear-gradient(to top, rgba(0, 191, 255, 0.4), transparent);
        height: 80px;
        opacity: 0.7;
        animation: glowPulse 4s ease-in-out infinite alternate;
    }
    
    @keyframes glowPulse {
        0% { opacity: 0.5; height: 70px; }
        100% { opacity: 0.8; height: 90px; }
    }

.aside-logo {
    border-bottom: none !important; /* Remove border */
}

/* Streamlined Menu Items */
.nav-link {
    padding: 0.7rem 1rem;
    margin: 0.3rem 1rem;
    border-radius: 12px;
    color: #343a40 !important;
    font-weight: 500;
    transition: background-color 0.3s ease, transform 0.2s ease;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center; /* Vertical alignment */
}

.nav-link i.nav-icon {
    margin-right: 0.75rem;
    font-size: 1rem;
    width: 20px; /* Fixed width for icons */
    text-align: center;
}

.nav-link:hover {
    background-color: rgba(0, 191, 255, 0.2) !important;
    transform: translateX(3px);
}

.nav-link.active {
    background-color: rgba(0, 191, 255, 0.3) !important;
    font-weight: 600;
}

/* No borders on active or hover */
.nav-link.active::before,
.nav-link:hover::before {
    display: none;
}

/* Streamlined Submenu */
.nav-treeview {
    background: rgba(0, 191, 255, 0.07);
    border-radius: 10px;
    margin: 0.5rem 0;
    max-height: 0; /* Ensure it starts collapsed */
    overflow: hidden;
    transition: max-height 0.3s ease-out;
}

.nav-treeview .nav-link {
    margin: 0.2rem 1.5rem;
    padding: 0.6rem 1rem;
    font-size: 0.85rem;
}

/* Dashboard Shortcut Styling */
.dashboard-shortcut {
    background: rgba(0, 191, 255, 0.1) !important;
    border-radius: 15px;
    margin: 0.5rem 1rem;
    padding: 0.75rem 1rem;
    text-align: left;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    color: #343a40 !important;
    font-weight: 500;
}

.dashboard-shortcut:hover {
    background: rgba(0, 191, 255, 0.3) !important;
    transform: scale(1.03);
}

.dashboard-shortcut i {
    margin-right: 0.75rem;
    font-size: 1.1rem;
}

/* Clean Scrollbar */
.sidebar::-webkit-scrollbar {
    width: 6px;
}

.sidebar::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb {
    background: rgba(0, 191, 255, 0.2);
    border-radius: 10px;
}

.sidebar::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 191, 255, 0.4);
}

/* Subtle Menu Expansion */
.menu-is-opening > .nav-treeview,
.menu-open > .nav-treeview {
    max-height: 800px; /* Adjusted for smoother animation */
    transition: max-height 0.35s ease-in;
}
/* General adjustments for a modern look */
p {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    line-height: 1.4;
}

/* Animation Keyframes */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.fa-bell {
    animation: pulse 2s infinite;
}

/* Remove bullets from lists */
.nav-sidebar .nav-treeview > .nav-item > .nav-link > p {
    margin: 0; /* override default margin */
    display: inline-block; /* prevent <p> from taking full width */
}

.nav-sidebar .nav-treeview > .nav-item > .nav-link {
    padding: .5rem 1rem;
}
</style>
