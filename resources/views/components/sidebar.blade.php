<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/home" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-dark.png" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/home" class="logo logo-light">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/logo-light.png" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="nav-item">
                </li>
                <li class="menu-title"><span data-key="t-menu">Pages</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::segment(1) === 'home' ? ' active' : '' }}" href="/home">
                        <i class="ri-dashboard-2-line ani-breath"></i> <span data-key="t-dashboard">{{ trans('home.dashboard') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarDashboards">
                        <i class="ri-account-circle-line ani-breath"></i><span data-key="t-dashboards">{{ trans('user.user') }}</span>
                    </a>
                    <div class="collapse menu-dropdown {{ Request::segment(1) === 'user' ? 'show' : '' }}"
                        id="sidebarDashboards">
                        <ul class="nav nav-sm flex-column">
                            @can('user.show')
                                <li class="nav-item">
                                    <a href="{{ route('user') }}" class="nav-link {{ Request::is('user') ? 'active' : '' }}"
                                        data-key="t-analytics">{{ trans('user.userall') }}</a>
                                </li>
                            @endcan
                            @can('role.show')
                                <li class="nav-item">
                                    <a href="{{ route('role') }}"
                                        class="nav-link {{ Request::segment(2) === 'role' ? 'active' : '' }}"
                                        data-key="t-crm"> {{ trans('role.role') }} </a>
                                </li>
                            @endcan
                            @can('permission.show')
                                <li class="nav-item">
                                    <a href="{{ route('permission') }}"
                                        class="nav-link {{ Request::segment(2) === 'permission' ? 'active' : '' }}"
                                        data-key="t-crm"> {{ trans('permission.permission') }} </a>
                                </li>
                            @endcan
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::segment(1) === 'chat' ? ' active' : '' }}" href="/chat">
                        <i class="ri-wechat-line ani-breath"></i> <span data-key="t-dashboard">{{ trans('chat.chat') }}</span>
                    </a>
                </li>
                {{-- <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Support</span></li> --}}
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Other</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarSetting" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarSetting">
                        <i class="ri-settings-5-line"></i> <span data-key="t-layouts">{{ trans('setting.setting') }}</span>
                    </a>
                    @php($isActive = in_array(Route::currentRouteName(), ['schedule.index', 'translations.index', 'translations.language']))
                    <div class="collapse menu-dropdown {{ $isActive ? 'show' : '' }}" id="sidebarSetting">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('schedule.index') }}"
                                    class="nav-link {{ Route::currentRouteNamed('schedule.index') ? 'active' : '' }} "
                                    data-key="t-horizontal">{{ trans('schedule.schedule') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('translations.index') }}"
                                    class="nav-link {{ in_array(Route::currentRouteName(), ['translations.index', 'translations.language'])? 'active' : '' }} "
                                    data-key="t-horizontal">{{ trans('translation.translation') }}</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
