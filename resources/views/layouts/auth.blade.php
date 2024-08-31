<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none" data-preloader="disable">

<head>
    <meta charset="utf-8" />
    <link rel="shortcut icon" href="/assets/images/favicon.ico">
    @stack('head')
    <script src="/assets/js/layout.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>
    <div class="auth-page-wrapper pt-5">
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>
            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
                    viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 text-white-50">
                            <div>
                                <a href="/" class="d-inline-block auth-logo">
                                    <img src="https://jamtechtechnologies.com//assets/images/index-images/dark-mode-img/light-mode-log.png"
                                        alt="" height="60">
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium">Admin & Dashboard</p>
                        </div>
                    </div>
                </div>
                @yield('main-section')
            </div>
        </div>
        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Crafted with <i class="mdi mdi-heart text-danger"></i>
                                by Saurav
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <!-- JAVASCRIPT -->
    <script src="/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/libs/feather-icons/feather.min.js"></script>
    <script src="/assets/js/pages/plugins/lord-icon-2.1.0.js"></script>
    <script src="/assets/libs/particles.js/particles.js"></script>
    <script src="/assets/js/pages/particles.app.js"></script>
    <script src="/assets/js/custom/auth.js"></script>
    @stack('footer')
</body>

</html>
