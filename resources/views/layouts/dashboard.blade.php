<!doctype html>
@php
    $setting = auth()?->user()?->setting ?? []; // Default to an empty array if not found

    $dataLayout = 'vertical';
    $dataTopbar = $setting['data_topbar'] ?? 'light';
    $dataSidebar = $setting['data_sidebar'] ?? 'dark';
    $dataSidebarSize = 'lg';
    $dataSidebarSize = 'lg';
    $dataSidebarImage = $setting['data_sidebar_image'] ?? 'none';
    $dataPreloader = $setting['data_preloader'] ?? 'disable';
    $dataBsTheme = $setting['data_bs_theme'] ?? 'light';
    $dataLayoutWidth = $setting['data_layout_width'] ?? 'fluid';
    $dataLayoutPosition = $setting['data_layout_position'] ?? 'fixed';
    $dataLayoutStyle = $setting['data_layout_style'] ?? 'default';
    $dataSidebarVisibility = $setting['data_sidebar_visibility'] ?? 'show';
    $humburger = $setting['humburger'] ?? 'show|simplebar-scrollable-y';
@endphp

<html lang="en" data-layout="{{ $dataLayout }}" data-topbar="{{ $dataTopbar }}" data-sidebar="{{ $dataSidebar }}"
    data-sidebar-size="{{ $dataSidebarSize }}" data-sidebar-image="{{ $dataSidebarImage }}"
    data-preloader="{{ $dataPreloader }}" data-bs-theme="{{ $dataBsTheme }}" data-layout-width="{{ $dataLayoutWidth }}"
    data-layout-position="{{ $dataLayoutPosition }}" data-layout-style="{{ $dataLayoutStyle }}"
    data-sidebar-visibility="{{ $dataSidebarVisibility }}">

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    <script src="/assets/js/layout.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" />
    @stack('header')
</head>

<body class="two-column-menu">
    <div id="layout-wrapper">
        <x-header></x-header>
        <x-sidebar></x-sidebar>
        <div class="vertical-overlay"></div>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col">
                            <div class="h-100">
                                @if (isset($pageTitle))
                                    <div class="row mb-3 pb-1">
                                        <div class="col-12">
                                            <div class="d-flex align-items-lg-center flex-lg-row flex-column">
                                                <div class="flex-grow-1">
                                                    <h4 class="fs-16 mb-1">{{ $pageTitle }}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @yield('main-section')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <x-footer />
        </div>
    </div>
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>

    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    <!-- Theme Settings -->
    <x-setting />
    <!-- JAVASCRIPT -->
    <script src="/assets/js/jquery-3.6.0.min.js"></script>
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="/assets/libs/node-waves/waves.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/libs/toastify/toastify-js.js"></script>
    {{-- ----------end --}}
    <script src="/assets/js/app.min.js"></script>
    <script src="/assets/js/custom/dashboard.js"></script>
    @stack('footer')
</body>

</html>
