<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Islanders App" />
    <meta name="keywords" content="Islanders, App" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="theme-color" content="#1e1e2d" />
    <meta name="csrf-token" content="<?= csrf_hash() ?>" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Islanders App" />
    <meta property="og:url" content="https://islanders.finolhu.net" />
    <meta property="og:site_name" content="Islanders App" />
    <link rel="canonical" href="https://islanders.finolhu.net" />
    <link rel="shortcut icon" href="/assets/media/logos/favicon.ico" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->

    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/plugins/custom/vis-timeline/vis-timeline.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->


    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!-- Mobile Status Bar Handling for Capacitor Apps -->
    <style>
        /* Mobile status bar safe area handling */
        :root {
            --status-bar-height: env(safe-area-inset-top, 0px);
            --status-bar-bg: #1e1e2d; /* Match header background - adjust if needed */
        }

        /* Status bar background for mobile apps */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--status-bar-height);
            background-color: var(--status-bar-bg);
            z-index: 10001; /* Higher than header */
            display: none; /* Hidden by default, shown only in mobile app */
        }

        /* Show status bar background in mobile app environment */
        .mobile-app body::before,
        .capacitor-app body::before {
            display: block;
        }

        /* Adjust body padding for mobile apps */
        .mobile-app body,
        .capacitor-app body {
            padding-top: var(--status-bar-height);
        }

        /* Ensure header doesn't overlap with status bar */
        .mobile-app #kt_app_header,
        .capacitor-app #kt_app_header {
            top: var(--status-bar-height);
            position: fixed;
        }

        /* Additional mobile app adjustments */
        @media (max-width: 768px) {
            .mobile-app #kt_app_header,
            .capacitor-app #kt_app_header {
                padding-top: 0;
            }
            
            .mobile-app .app-header,
            .capacitor-app .app-header {
                min-height: calc(80px + var(--status-bar-height));
            }
        }

        /* Handle landscape orientation */
        @media (orientation: landscape) and (max-height: 500px) {
            .mobile-app body::before,
            .capacitor-app body::before {
                height: calc(var(--status-bar-height) * 0.8); /* Slightly reduce for landscape */
            }
        }

        /* Dark theme support */
        [data-bs-theme="dark"] {
            --status-bar-bg: #1c1c1c; /* Darker background for dark theme */
        }

        /* Light theme support */
        [data-bs-theme="light"] {
            --status-bar-bg: #f8f9fa; /* Light background for light theme */
        }
    </style>

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
    if (window.top != window.self) {
        window.top.location.replace(window.self.location.href);
    }

    // Mobile app environment detection
    document.addEventListener('DOMContentLoaded', function() {
        // Check if running in Capacitor
        if (window.Capacitor) {
            document.body.classList.add('capacitor-app');
            console.log('Capacitor environment detected');
        }
        // Check for other mobile app indicators
        else if (window.cordova || window.PhoneGap || window.phonegap) {
            document.body.classList.add('mobile-app');
            console.log('Mobile app environment detected');
        }
        // Check for mobile browsers with standalone mode (PWA)
        else if (window.navigator.standalone || window.matchMedia('(display-mode: standalone)').matches) {
            document.body.classList.add('mobile-app');
            console.log('PWA standalone mode detected');
        }
        // Check for mobile user agent as fallback
        else if (/Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent)) {
            // Only add mobile-app class if it seems to be in an app context
            if (window.location.protocol === 'file:' || window.location.hostname === 'localhost') {
                document.body.classList.add('mobile-app');
                console.log('Mobile app context detected via user agent');
            }
        }
    });
    </script>
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true"
    data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
    var defaultThemeMode = "light";
    var themeMode;

    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }

        if (themeMode === "system") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }

        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
    </script>
    <!--end::Theme mode setup on page load-->


    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">




            <!--begin::Header-->
            <div id="kt_app_header" class="app-header " data-kt-sticky="true"
                data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize"
                data-kt-sticky-offset="{default: '200px', lg: '300px'}" data-kt-sticky-animation="false">

                <!--begin::Header container-->
                <div class="app-container  container-fluid d-flex align-items-stretch flex-stack mt-7 "
                    id="kt_app_header_container">
                    <!--begin::Sidebar toggle-->
                    <?php 
                    $request = \Config\Services::request();
                    $currentUri = $request->getUri();
                    $currentPath = $currentUri->getPath();
                    $isDashboard = ($currentPath === '/' || $currentPath === '/dashboard');
                    ?>
                    <div class="d-flex align-items-center d-block d-lg-none ms-n3" 
                         title="<?= $isDashboard ? 'Show sidebar menu' : 'Go back' ?>">
                        <?php if ($isDashboard): ?>
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-2"
                            id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <?php else: ?>
                        <div class="btn btn-icon btn-active-color-dark w-35px h-35px me-2"
                            onclick="window.history.back()">
                            <i class="ki-duotone ki-left-square fs-3x"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <?php endif; ?>

                        <!--begin::Logo image-->
                        <a href="/">
                            <img alt="Logo" src="/assets/media/logos/default.svg" class="h-20px theme-light-show" />
                            <img alt="Logo" src="/assets/media/logos/default-dark.svg" class="h-20px theme-dark-show" />
                        </a>
                        <!--end::Logo image-->
                    </div>
                    <!--end::Sidebar toggle-->


                    <!--begin::Navbar-->
                    <?= $this->include('layout/navbar.php') ?>
                    <!--end::Navbar-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">






                <!--begin::Sidebar-->
                <?= $this->include('layout/sidebar.php') ?>
                <!--end::Sidebar-->