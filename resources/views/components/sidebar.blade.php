<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="/home" class="logo logo-dark">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/s-logo.png" height="50">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="/home" class="logo logo-light">
            <span class="logo-sm">
                <img src="/assets/images/logo-sm.png" height="22">
            </span>
            <span class="logo-lg">
                <img src="/assets/images/s-logo.png" height="50">
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
                <li class="menu-title"><span data-key="t-menu">Pages
                        {{ Request::is(['user', 'role', 'permission']) }}</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link {{ Request::segment(1) === 'home' ? ' active' : '' }}" href="/home">
                        <i class="ri-dashboard-2-line ani-breath"></i> <span
                            data-key="t-dashboard">{{ trans('dashboard.dashboard') }}</span>
                    </a>
                </li>
                @can(['user.show', 'role.show', 'permission.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                            aria-expanded="{{ request()->routeIs(['user', 'role', 'permission*']) ? 'true' : 'false' }}"
                            aria-controls="sidebarDashboards">
                            <i class="ri-account-circle-line ani-breath"></i><span
                                data-key="t-dashboards">{{ trans('user.user') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ request()->routeIs(['user', 'role', 'permission']) ? 'show' : '' }}"
                            id="sidebarDashboards">
                            <ul class="nav nav-sm flex-column">
                                @can('user.show')
                                    <li class="nav-item">
                                        <a href="{{ route('user') }}" class="nav-link {{ Request::is('user') ? 'active' : '' }}"
                                            data-key="t-analytics">{{ trans('user.users') }}</a>
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
                @endcan
                @can('chat.show')
                    <li class="nav-item">
                        <a class="nav-link menu-link {{ request()->routeIs('chat.index') ? ' active' : '' }}" href="{{ route('chat.index') }}">
                            <i class="ri-wechat-line ani-breath"></i> <span
                                data-key="t-dashboard">{{ trans('chat.chat') }}</span>
                        </a>
                    </li>
                @endcan
                <li class="menu-title"><i class="ri-more-fill"></i> <span data-key="t-pages">Other</span></li>
                @can(['translations.show', 'schedule.show'])
                    <li class="nav-item">
                        <a class="nav-link menu-link" href="#sidebarSetting" data-bs-toggle="collapse" role="button"
                            aria-expanded="{{ request()->routeIs(['schedule.index', 'translations.index', 'translations.language']) ? true : false }}" aria-controls="sidebarSetting">
                            <i class="ri-settings-5-line"></i> <span
                                data-key="t-layouts">{{ trans('setting.setting') }}</span>
                        </a>
                        <div class="collapse menu-dropdown {{ request()->routeIs(['schedule.index', 'translations.index', 'translations.language']) ? 'show' : '' }}" id="sidebarSetting">
                            <ul class="nav nav-sm flex-column">
                                @can('schedule.show')
                                    <li class="nav-item">
                                        <a href="{{ route('schedule.index') }}"
                                            class="nav-link {{ request()->routeIs('schedule.index') ? 'active' : '' }} "
                                            data-key="t-horizontal">{{ trans('schedule.schedule') }}</a>
                                    </li>
                                @endcan
                                @can('translations.show')
                                    <li class="nav-item">
                                        <a href="{{ route('translations.index') }}"
                                            class="nav-link {{ request()->routeIs(['translations.index', 'translations.language']) ? 'active' : '' }} "
                                            data-key="t-horizontal">{{ trans('translation.translation') }}</a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <div class="sidebar-background"></div>
</div>
