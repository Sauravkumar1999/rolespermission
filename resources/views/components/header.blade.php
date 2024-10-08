<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>
            </div>
            <div id="timerhead">
                <span class="badge badge-label bg-success">
                    <i class="ri-map-pin-time-line"></i>
                    <span>1:28:45 PM</span>
                </span>
            </div>
            <div class="d-flex align-items-center">
                @can('translations.change')
                    @php($local = App::getLocale())
                    <div class="dropdown ms-1 topbar-head-dropdown header-item">
                        <button type="button" class="btn" id="page-header-flag" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <span class="d-flex align-items-center">
                                @php($lang = getLanguage())
                                <img class="rounded"
                                    src="@if ($lang) {{ $lang->getSvg() }} @else /assets/images/flags/ind.svg @endif"
                                    alt="Header Avatar" height="20">
                            </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end" id="page-header-flag-dropdown">
                            @foreach (App\Models\TranslationLanguage::all() as $list)
                                <a href="{{ route('translations.change', $list->slug) }}"
                                    class="dropdown-item notify-item language py-2 @if ($local === $list->slug) active @endif"
                                    data-lang="{{ $list->slug }}" title="{{ $list->lang_name }}">
                                    <img src="{{ asset($list->svg) }}" alt="user-image" class="me-2 rounded" height="18">
                                    <span class="align-middle">{{ $list->lang_name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                            data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

                @endcan
                <div class="ms-1 header-item d-none d-sm-flex">
                    <div class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle" data-bs-toggle="offcanvas"
                        data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">
                        <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>
                    </div>
                </div>
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button"
                        class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">
                        <i class='bx bx-moon fs-22'></i>
                    </button>
                </div>
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ auth()->user()->profile }}"
                                alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span
                                    class="d-none d-xl-block ms-1 fs-12 user-name-sub-text">{{ auth()->user()->roles->first()->name }}</span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">{{ trans('dashboard.welcome') }} {{ auth()->user()->name }} !</h6>
                        <a class="dropdown-item" href="pages-profile.html">
                            <i class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">{{ trans('dashboard.profile') }}</span>
                        </a>
                        <a class="dropdown-item" href="apps-chat.html">
                            <i class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">{{ trans('dashboard.messages') }}</span>
                        </a>
                        <a class="dropdown-item" href="apps-tasks-kanban.html">
                            <i class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">{{ trans('dashboard.taskboard') }}</span>
                        </a>
                        <a class="dropdown-item" href="pages-faqs.html">
                            <i class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">{{ trans('dashboard.help') }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="pages-profile-settings.html">
                            <span class="badge bg-success-subtle text-success mt-1 float-end">New</span>
                            <i class="mdi mdi-cog-outline text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">{{ trans('dashboard.settings') }}</span>
                        </a>
                        <a class="dropdown-item" href="auth-lockscreen-basic.html">
                            <i class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle">{{ trans('dashboard.lock-screen') }} </span>
                        </a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i>
                            <span class="align-middle" data-key="t-logout">{{ trans('dashboard.logout') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
