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
        --status-bar-bg: #ffffff;
        /* Default white background */
    }

    /* Mobile app body adjustments - always apply padding for mobile screens */
    @media (max-width: 768px) {
        body {
            padding-top: var(--status-bar-height) !important;
        }

        /* Very minimal space - main content very close to header */
        #kt_app_page {
            padding-top: calc(30px + var(--status-bar-height));
        }

        /* Fix header positioning with solid white background */
        #kt_app_header {
            top: var(--status-bar-height) !important;
            position: fixed !important;
            z-index: 1000 !important;
            width: 100% !important;
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        /* Minimal header container padding and remove margin */
        #kt_app_header_container {
            margin-top: 0 !important;
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        /* Force remove any Bootstrap margin classes */
        #kt_app_header_container.mt-7 {
            margin-top: 0 !important;
        }

        /* Ensure wrapper doesn't overlap and remove any default spacing */
        #kt_app_wrapper {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* Remove any default spacing from main content area */
        .app-main {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        /* Target common CodeIgniter/Bootstrap spacing classes */
        .container,
        .container-fluid {
            padding-top: 0 !important;
        }

        /* Remove any toolbar or breadcrumb spacing */
        .app-toolbar,
        .toolbar {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* Target any content wrapper */
        .content,
        .main-content {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
    }

    /* Status bar background overlay */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: var(--status-bar-height);
        background-color: var(--status-bar-bg);
        z-index: 10001;
        display: none;
    }

    /* Show status bar background on mobile */
    @media (max-width: 768px) {
        body::before {
            display: block;
        }
    }

    /* Mobile app specific adjustments */
    .mobile-app,
    .capacitor-app {
        /* Additional mobile app styles if needed */
    }

    /* Handle landscape orientation */
    @media (orientation: landscape) and (max-height: 500px) {
        body::before {
            height: calc(var(--status-bar-height) * 0.8);
        }

        body {
            padding-top: calc(var(--status-bar-height) * 0.8) !important;
        }

        #kt_app_header {
            top: calc(var(--status-bar-height) * 0.8) !important;
        }

        /* Extra tight content padding in landscape */
        #kt_app_page {
            padding-top: calc(25px + var(--status-bar-height) * 0.8);
        }

        /* Extra small header container padding in landscape */
        #kt_app_header_container {
            padding-top: 0.15rem;
            padding-bottom: 0.15rem;
        }
    }

    /* Theme support - solid white backgrounds for different themes */
    [data-bs-theme="dark"] {
        --status-bar-bg: #1e1e2d;
    }

    [data-bs-theme="light"] {
        --status-bar-bg: #ffffff;
    }

    /* Solid white header background for all themes on mobile */
    @media (max-width: 768px) {
        [data-bs-theme="dark"] #kt_app_header {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }

        [data-bs-theme="light"] #kt_app_header {
            background: #ffffff !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
    }

    /* Status bar background should still be solid */
    body::before {
        background-color: var(--status-bar-bg) !important;
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

        // Always add mobile class for small screens (this ensures CSS works on all mobile devices)
        if (window.innerWidth <= 768) {
            document.body.classList.add('mobile-screen');
            console.log('Mobile screen size detected');
        }

        // Debug: Log safe area values
        const safeAreaTop = getComputedStyle(document.documentElement).getPropertyValue('--status-bar-height');
        console.log('Safe area top:', safeAreaTop);
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
                    <div class="app-navbar flex-lg-grow-1" id="kt_app_header_navbar">
                        <div class="app-navbar-item d-flex align-items-center flex-lg-grow-1">

                            <!--begin::Search-->
                            <span class="text-gray-900 fw-bolder fs-2x lh-1 d-none d-lg-block">
                                <?= esc($title) ?>
                            </span>
                            <!--end::Search-->
                        </div>

                        <!--begin::User menu-->
                        <div class="app-navbar-item ms-5" id="kt_header_user_menu_toggle">
                            <!--begin::Menu wrapper-->
                            <div class="cursor-pointer symbol symbol-30px symbol-md-35px"
                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                data-kt-menu-placement="bottom-end">
                                <!-- <img class="symbol symbol-30px symbol-md-35px" src="/assets/media/avatars/300-3.jpg" alt="user" /> -->
                                <?php if (!empty(user()->image)): ?>
                                <?php
                // Display the user's avatar image, name, and islander number
                echo '<img src="' . base_url('assets/media/users/' . user()->image) . '" class="me-2 rounded align-self-start" width="100" height="100" style="max-width: 100px; max-height: 100px; object-fit: cover;">';
                ?>
                                <?php else: ?>
                                <?php
                // Display the user's initials, name, and islander number
                echo '<img src="' . 'https://ui-avatars.com/api/?name=' . user()->full_name .  '&background=d9dbe1&color=f4f4f4&font-size=.5">';
                ?>
                                <?php endif; ?>
                            </div>

                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px me-5">
                                            <!-- <img alt="Logo" src="/assets/media/avatars/300-3.jpg" /> -->
                                            <?php if (!empty(user()->image)): ?>
                                            <?php
                            // Display the user's avatar image, name, and islander number
                            echo '<img src="' . base_url('assets/media/users/' . user()->image) . '" class="me-2 rounded align-self-start" width="100" height="100" style="max-width: 100px; max-height: 100px; object-fit: cover;">';
                            ?>
                                            <?php else: ?>
                                            <?php
                            // Display the user's initials, name, and islander number
                            echo '<img src="' . 'https://ui-avatars.com/api/?name=' . user()->full_name .  '&background=f4f4f4&color=9ba1b6&font-size=.5">';
                            ?>
                                            <?php endif; ?>
                                        </div>
                                        <!--end::Avatar-->

                                        <!--begin::Username-->
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">
                                                <?= user()->full_name ?>
                                            </div>

                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                                <?= user()->email ?> </a>
                                        </div>
                                        <!--end::Username-->
                                    </div>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="/Profile" class="menu-link px-5">
                                        Profile
                                    </a>
                                </div>
                                <!--end::Menu item-->



                                <!--begin::Menu separator-->
                                <div class="separator my-2"></div>
                                <!--end::Menu separator-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">
                                            Mode

                                            <span class="ms-5 position-absolute translate-middle-y top-50 end-0">
                                                <i class="ki-duotone ki-night-day theme-light-show fs-2"><span
                                                        class="path1"></span><span class="path2"></span><span
                                                        class="path3"></span><span class="path4"></span><span
                                                        class="path5"></span><span class="path6"></span><span
                                                        class="path7"></span><span class="path8"></span><span
                                                        class="path9"></span><span class="path10"></span></i> <i
                                                    class="ki-duotone ki-moon theme-dark-show fs-2"><span
                                                        class="path1"></span><span class="path2"></span></i> </span>
                                        </span>
                                    </a>

                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px"
                                        data-kt-menu="true" data-kt-element="theme-mode-menu">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="light">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-duotone ki-night-day fs-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span><span class="path6"></span><span
                                                            class="path7"></span><span class="path8"></span><span
                                                            class="path9"></span><span class="path10"></span></i>
                                                </span>
                                                <span class="menu-title">
                                                    Light
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="dark">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span
                                                            class="path2"></span></i> </span>
                                                <span class="menu-title">
                                                    Dark
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3 my-0">
                                            <a href="#" class="menu-link px-3 py-2" data-kt-element="mode"
                                                data-kt-value="system">
                                                <span class="menu-icon" data-kt-element="icon">
                                                    <i class="ki-duotone ki-screen fs-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span></i>
                                                </span>
                                                <span class="menu-title">
                                                    System
                                                </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu-->

                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title position-relative">
                                            Language

                                            <span
                                                class="fs-8 rounded bg-light px-3 py-2 position-absolute translate-middle-y top-50 end-0">
                                                English <img class="w-15px h-15px rounded-1 ms-2"
                                                    src="/assets/media/flags/united-states.svg" alt="" />
                                            </span>
                                        </span>
                                    </a>

                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/bold-html-pro/account/settings.html"
                                                class="menu-link d-flex px-5 active">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="/assets/media/flags/united-states.svg"
                                                        alt="" />
                                                </span>
                                                English
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/bold-html-pro/account/settings.html"
                                                class="menu-link d-flex px-5">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="/assets/media/flags/spain.svg" alt="" />
                                                </span>
                                                Spanish
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/bold-html-pro/account/settings.html"
                                                class="menu-link d-flex px-5">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="/assets/media/flags/germany.svg"
                                                        alt="" />
                                                </span>
                                                German
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/bold-html-pro/account/settings.html"
                                                class="menu-link d-flex px-5">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="/assets/media/flags/japan.svg" alt="" />
                                                </span>
                                                Japanese
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/bold-html-pro/account/settings.html"
                                                class="menu-link d-flex px-5">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="/assets/media/flags/france.svg"
                                                        alt="" />
                                                </span>
                                                French
                                            </a>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="/logout" class="menu-link px-5">
                                        Sign Out
                                    </a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::User account menu-->

                            <!--end::Menu wrapper-->
                        </div>
                        <!--end::User menu-->

                        <!--begin::Header menu toggle-->
                        <!--end::Header menu toggle-->
                    </div>
                    <!--end::Navbar-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">






                <!--begin::Sidebar-->
                <div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true"
                    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">


                    <div class="app-sidebar-header d-flex flex-stack d-none d-lg-flex pt-8 pb-2 px-8"
                        id="kt_app_sidebar_header">
                        <!--begin::Logo-->
                        <a href="/" class="app-sidebar-logo">
                            <img alt="Logo" src="/assets/media/logos/default.svg"
                                class="h-20px d-none d-sm-inline app-sidebar-logo-default theme-light-show" />
                            <img alt="Logo" src="/assets/media/logos/default-dark.svg" class="h-20px theme-dark-show" />
                        </a>
                        <!--end::Logo-->

                        <!--begin::Sidebar toggle-->
                        <!-- <div id="kt_app_sidebar_toggle"
            class="app-sidebar-toggle btn btn-sm btn-icon btn-color-gray-600 btn-active-color-primary d-none d-lg-flex rotate "
            data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
            data-kt-toggle-name="app-sidebar-minimize">

            <i class="ki-duotone ki-exit-left fs-1 rotate-180 me-n4"><span class="path1"></span><span
                    class="path2"></span></i>
        </div> -->
                        <!--end::Sidebar toggle-->
                    </div>

                    <!--begin::Navs-->
                    <div class="app-sidebar-navs flex-column-fluid py-6" id="kt_app_sidebar_navs">
                        <div id="kt_app_sidebar_navs_wrappers" class="app-sidebar-wrapper">
                            <div id="kt_app_sidebar_navs_scroll" class="hover-scroll-y mx-3 my-2" data-kt-scroll="true"
                                data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                                data-kt-scroll-dependencies="#kt_app_sidebar_header"
                                data-kt-scroll-wrappers="#kt_app_sidebar_navs" data-kt-scroll-offset="5px">


                                <!--begin::Sidebar menu-->
                                <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                                    class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary ps-6 pe-0">

                                    <?php
                    // Helper function to check if menu item is active
                    function isMenuActive($routes) {
                        $currentUrl = current_url();
                        $baseUrl = base_url();
                        $uriString = uri_string();
                        $requestUri = $_SERVER['REQUEST_URI'] ?? '';
                        
                        foreach ($routes as $route) {
                            if ($route === '/' || $route === 'dashboard') {
                                // Special handling for dashboard/home
                                if ($currentUrl == $baseUrl || 
                                    $currentUrl == $baseUrl . '/' ||
                                    $currentUrl == $baseUrl . 'dashboard' ||
                                    $uriString == '' ||
                                    $uriString == '/' ||
                                    $uriString == 'dashboard' ||
                                    $requestUri == '/' ||
                                    $requestUri == '/dashboard') {
                                    return true;
                                }
                            } else {
                                // For other routes
                                if (strpos($currentUrl, $route) !== false || 
                                    strpos($requestUri, $route) !== false) {
                                    return true;
                                }
                            }
                        }
                        return false;
                    }
                    ?>

                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/', 'dashboard']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <a href="/" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-setting-3 fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Dashboard</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/feed']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <a href="/feed" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-element-12 fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Feed</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/requests/add_request', '/requests', '/authorizations']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-some-files fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i></span>
                                            <span class="menu-title">Requests</span>
                                            <span class="menu-arrow"></span></span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive1 = isMenuActive(['/requests/add_request']); ?>
                                                <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                    href="/requests/add_request" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="right"
                                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Add Requests</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive2 = isMenuActive(['/requests']) && !isMenuActive(['/requests/add_request']); ?>
                                                <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>"
                                                    href="/requests" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-dismiss="click" data-bs-placement="right"
                                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">All Requests</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive3 = isMenuActive(['/authorizations']); ?>
                                                <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>"
                                                    href="/authorizations" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="right"
                                                    <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Authorizations</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/users']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <a href="/users" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-profile-user fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Islanders</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/events']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <a href="/events" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-calendar fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                    <span class="path5"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Events</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/policies']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <a href="/policies" class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-document fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Policies</span>
                                        </a>
                                        <!--end:Menu link-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/tickets']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-save-2 fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i></span>
                                            <span class="menu-title">Tickets</span>
                                            <span class="menu-arrow"></span></span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive1 = isMenuActive(['/tickets']); ?>
                                                <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                    href="/tickets" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-dismiss="click" data-bs-placement="right"
                                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">All Tickets</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->
                                    <!--begin:Menu item-->
                                    <?php $isActive = isMenuActive(['/todays_arrival', '/todays_departure', '/exit_request']); ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-security-user fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i></span>
                                            <span class="menu-title">Security</span>
                                            <span class="menu-arrow"></span></span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive1 = isMenuActive(['/todays_departure']); ?>
                                                <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                    href="/todays_departure" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="right"
                                                    <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Todays Departure</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive2 = isMenuActive(['/todays_arrival']) && !isMenuActive(['/todays_departure']); ?>
                                                <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>"
                                                    href="/todays_arrival" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="right"
                                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Todays Arrival</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                            <!--begin:Menu item-->
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive3 = isMenuActive(['/exit_request']); ?>
                                                <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>"
                                                    href="/exit_request" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="right"
                                                    <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">All Exit Requests</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <!--end:Menu item-->
                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <!--end:Menu item-->







                                    <!--begin:Menu item-->
                                    <?php 
                    // Check permissions for system settings
                    $hasStatusAccess = has_permission('status.view');
                    $hasRequestsAccess = has_permission('requests.view');
                    $hasModulesAccess = has_permission('modules.view');
                    $hasLogsAccess = has_permission('logs.view');
                    $hasSystemAccess = $hasStatusAccess || $hasRequestsAccess || $hasModulesAccess || $hasLogsAccess;
                    
                    // For Islander Settings, we'll assume admin/manager access for now
                    // You can add specific permissions for these later if needed
                    $hasIslanderAccess = has_permission('system.admin') || in_groups(['admin', 'manager']);
                    
                    // Check permissions for user management items
                    $hasUserManagementAccess = has_permission('users.view') || has_permission('sessions.view') || 
                                             has_permission('groups.view') || has_permission('permissions.view') || 
                                             in_groups(['admin', 'manager']);
                    
                    // Check if user has access to any settings
                    $hasAnySettingsAccess = $hasSystemAccess || $hasIslanderAccess || $hasUserManagementAccess;
                    
                    $isActive = isMenuActive(['/modules', '/status', '/logs', '/leave', '/divisions', '/departments', '/sections', '/positions', '/genders', '/nationalities', '/houses', '/policy', '/islanders', '/visitors', '/sessions', '/requesting-rules', '/authorization-rules', '/roles', '/group-permissions', '/user-permissions']) && $hasAnySettingsAccess;
                    ?>
                                    <?php if ($hasAnySettingsAccess): ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion ms-n5 <?= $isActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <span class="menu-link <?= $isActive ? 'active bg-dark' : '' ?>"
                                            <?= $isActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                            <span class="menu-icon">
                                                <i class="ki-duotone ki-setting-2 fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <span class="menu-title">Settings</span>
                                            <span class="menu-arrow"></span>
                                        </span>
                                        <!--end:Menu link-->
                                        <!--begin:Menu sub-->
                                        <div class="menu-sub menu-sub-accordion">
                                            <!--begin:Menu item User Management-->
                                            <?php 
                            // Check permissions for user management items
                            $hasUserManagementAccess = has_permission('users.view') || has_permission('sessions.view') || 
                                                     has_permission('groups.view') || has_permission('permissions.view') || 
                                                     in_groups(['admin', 'manager']);
                            $userMgmtActive = isMenuActive(['/islanders', '/visitors', '/sessions', '/requesting-rules', '/authorization-rules', '/roles', '/group-permissions', '/user-permissions']) && $hasUserManagementAccess;
                            ?>
                                            <?php if ($hasUserManagementAccess): ?>
                                            <div data-kt-menu-trigger="click"
                                                class="menu-item menu-accordion <?= $userMgmtActive ? 'here show' : '' ?>">
                                                <!--begin:Menu link-->
                                                <span class="menu-link <?= $userMgmtActive ? 'active bg-dark' : '' ?>"
                                                    <?= $userMgmtActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">User Management</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('users.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive1 = isMenuActive(['/islanders']); ?>
                                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                            href="/islanders"
                                                            <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Islanders</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('visitors.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive2 = isMenuActive(['/visitors']); ?>
                                                        <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>"
                                                            href="/visitors"
                                                            <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Visitors</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('sessions.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive3 = isMenuActive(['/sessions']); ?>
                                                        <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>"
                                                            href="/sessions"
                                                            <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Sessions</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('sequence.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive4 = isMenuActive(['/requesting-rules']); ?>
                                                        <a class="menu-link <?= $subActive4 ? 'active bg-dark' : '' ?>"
                                                            href="/requesting-rules"
                                                            <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Requesting Sequence</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('authorization_rules.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive5 = isMenuActive(['/authorization-rules']); ?>
                                                        <a class="menu-link <?= $subActive5 ? 'active bg-dark' : '' ?>"
                                                            href="/authorization-rules"
                                                            <?= $subActive5 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Authorizations Sequence</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('groups.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive6 = isMenuActive(['/roles']); ?>
                                                        <a class="menu-link <?= $subActive6 ? 'active bg-dark' : '' ?>"
                                                            href="/roles"
                                                            <?= $subActive6 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Roles</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('permissions.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive7 = isMenuActive(['/group-permissions']); ?>
                                                        <a class="menu-link <?= $subActive7 ? 'active bg-dark' : '' ?>"
                                                            href="/group-permissions"
                                                            <?= $subActive7 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Group Permissions</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('permissions.view') || $hasUserManagementAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive8 = isMenuActive(['/user-permissions']); ?>
                                                        <a class="menu-link <?= $subActive8 ? 'active bg-dark' : '' ?>"
                                                            href="/user-permissions"
                                                            <?= $subActive8 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">User Permissions</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <?php endif; ?>
                                            <!--end:Menu item-->

                                            <!--begin:Menu item-->
                                            <?php 
                            $islanderActive = isMenuActive(['/divisions', '/departments', '/sections', '/positions', '/genders', '/nationalities', '/houses', '/policy']) && $hasIslanderAccess;
                            ?>
                                            <?php if ($hasIslanderAccess): ?>
                                            <div data-kt-menu-trigger="click"
                                                class="menu-item menu-accordion <?= $islanderActive ? 'here show' : '' ?>">
                                                <!--begin:Menu link-->
                                                <span class="menu-link <?= $islanderActive ? 'active bg-dark' : '' ?>"
                                                    <?= $islanderActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Islander Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('divisions.view') || $hasIslanderAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive1 = isMenuActive(['/divisions']); ?>
                                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                            href="/divisions"
                                                            <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Division</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('departments.view') || $hasIslanderAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive2 = isMenuActive(['/departments']); ?>
                                                        <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>"
                                                            href="/departments"
                                                            <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Department</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('sections.view') || $hasIslanderAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive3 = isMenuActive(['/sections']); ?>
                                                        <a class="menu-link <?= $subActive3 ? 'active bg-dark' : '' ?>"
                                                            href="/sections"
                                                            <?= $subActive3 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Section</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive4 = isMenuActive(['/positions']); ?>
                                                        <a class="menu-link <?= $subActive4 ? 'active bg-dark' : '' ?>"
                                                            href="/positions"
                                                            <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Position</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive5 = isMenuActive(['/genders']); ?>
                                                        <a class="menu-link <?= $subActive5 ? 'active bg-dark' : '' ?>"
                                                            href="/genders"
                                                            <?= $subActive5 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Gender</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive6 = isMenuActive(['/nationalities']); ?>
                                                        <a class="menu-link <?= $subActive6 ? 'active bg-dark' : '' ?>"
                                                            href="/nationalities"
                                                            <?= $subActive6 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Nationality</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('houses.view') || $hasIslanderAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive7 = isMenuActive(['/houses']); ?>
                                                        <a class="menu-link <?= $subActive7 ? 'active bg-dark' : '' ?>"
                                                            href="/houses"
                                                            <?= $subActive7 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Houses</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--begin:Menu item-->

                                                    <!--begin:Menu item-->
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive8 = isMenuActive(['/policy']); ?>
                                                        <a class="menu-link <?= $subActive8 ? 'active bg-dark' : '' ?>"
                                                            href="/policy"
                                                            <?= $subActive8 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Policy</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <?php endif; ?>
                                            <!--end:Menu item-->

                                            <!--begin:Menu item-->
                                            <?php 
                            $islanderActive = isMenuActive(['/leave']) && $hasIslanderAccess;
                            ?>
                                            <?php if ($hasIslanderAccess): ?>
                                            <div data-kt-menu-trigger="click"
                                                class="menu-item menu-accordion <?= $islanderActive ? 'here show' : '' ?>">
                                                <!--begin:Menu link-->
                                                <span class="menu-link <?= $islanderActive ? 'active bg-dark' : '' ?>"
                                                    <?= $islanderActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Request Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <?php if (has_permission('leave.view') || $hasIslanderAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive1 = isMenuActive(['/leave']); ?>
                                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                            href="/leave"
                                                            <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Leave Reasons</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <?php endif; ?>
                                            <!--end:Menu item-->

                                            <!--begin:Menu item-->
                                            <?php 
                            // Check permissions for system settings items
                            $hasStatusAccess = has_permission('status.view');
                            $hasRequestsAccess = has_permission('requests.view');
                            $hasModulesAccess = has_permission('modules.view');
                            $hasLogsAccess = has_permission('logs.view');
                            $systemActive = isMenuActive(['/modules', '/status', '/logs']) && ($hasStatusAccess || $hasRequestsAccess || $hasModulesAccess || $hasLogsAccess);
                            ?>
                                            <?php if ($hasStatusAccess || $hasRequestsAccess || $hasModulesAccess || $hasLogsAccess): ?>
                                            <div data-kt-menu-trigger="click"
                                                class="menu-item menu-accordion <?= $systemActive ? 'here show' : '' ?>">
                                                <!--begin:Menu link-->
                                                <span class="menu-link <?= $systemActive ? 'active bg-dark' : '' ?>"
                                                    <?= $systemActive ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">System Settings</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div class="menu-sub menu-sub-accordion">
                                                    <!--begin:Menu item-->
                                                    <?php if ($hasStatusAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive1 = isMenuActive(['/status']); ?>
                                                        <a class="menu-link <?= $subActive1 ? 'active bg-dark' : '' ?>"
                                                            href="/status"
                                                            <?= $subActive1 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Status</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if ($hasModulesAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive2 = isMenuActive(['/modules']) && !isMenuActive(['/status']) ?>
                                                        <a class="menu-link <?= $subActive2 ? 'active bg-dark' : '' ?>"
                                                            href="/modules"
                                                            <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Module</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    <?php if ($hasLogsAccess): ?>
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <?php $subActive4 = isMenuActive(['/logs']); ?>
                                                        <a class="menu-link <?= $subActive4 ? 'active bg-dark' : '' ?>"
                                                            href="/logs"
                                                            <?= $subActive4 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                            <span class="menu-bullet">
                                                                <span class="bullet bullet-dot"></span>
                                                            </span>
                                                            <span class="menu-title">Logs</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <?php endif; ?>
                                                    <!--end:Menu item-->
                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <?php endif; ?>
                                            <!--end:Menu item-->

                                        </div>
                                        <!--end:Menu sub-->
                                    </div>
                                    <?php endif; ?>
                                    <!--end:Menu item-->





                                </div>
                                <!--end::Sidebar menu-->
                            </div>
                        </div>
                    </div>
                    <!--end::Navs-->


                </div>
                <!--end::Sidebar-->

                <style>
                /* Fixed mobile search bar */
                .mobile-search-bar {
                    backdrop-filter: blur(20px);
                    -webkit-backdrop-filter: blur(20px);
                    z-index: 100 !important;
                    transition: all 0.3s ease;
                    border-bottom: 1px solid var(--bs-border-color);
                    background: var(--bs-app-header-base-bg-color, var(--bs-gray-100));
                }

                /* Mobile search bar positioning override for this page */
                @media (max-width: 768px) {
                    .mobile-search-bar {
                        position: fixed !important;
                        top: calc(var(--status-bar-height) + 30px) !important;
                        left: 0 !important;
                        right: 0 !important;
                        z-index: 999 !important;
                        background: #ffffff !important;
                        border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
                        backdrop-filter: blur(10px) !important;
                        -webkit-backdrop-filter: blur(10px) !important;
                        margin: 0 !important;
                        padding-top: 1rem !important;
                        border-top: none !important;
                        min-height: 120px !important;
                    }
                    
                    /* Override any inline styles on mobile search bar */
                    .d-lg-none .mobile-search-bar,
                    .mobile-search-bar[style*="top"],
                    div.mobile-search-bar {
                        top: calc(var(--status-bar-height) + 30px) !important;
                    }
                    
                    /* Ensure h1 title is visible - stronger selectors */
                    .mobile-search-bar h1,
                    .mobile-search-bar .text-dark,
                    .mobile-search-bar .fw-bold,
                    .d-lg-none .mobile-search-bar h1 {
                        color: #1e1e2d !important;
                        font-size: 1.5rem !important;
                        font-weight: 700 !important;
                        margin-bottom: 0.5rem !important;
                        margin-top: 0 !important;
                        padding: 8px 0 !important;
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                        height: auto !important;
                        line-height: 1.2 !important;
                        text-align: left !important;
                        background: rgba(255, 255, 0, 0.1) !important; /* Temporary debug background */
                        border: 1px solid red !important; /* Temporary debug border */
                    }
                    
                    /* Ensure h1 container is visible */
                    .mobile-search-bar .mb-2 {
                        display: block !important;
                        visibility: visible !important;
                        opacity: 1 !important;
                        background: rgba(0, 255, 0, 0.1) !important; /* Temporary debug background */
                        min-height: 40px !important;
                    }
                    
                    /* Ensure container is properly sized for h1 */
                    .mobile-search-bar .container-fluid,
                    .mobile-search-bar .mb-2 {
                        overflow: visible !important;
                        height: auto !important;
                        min-height: auto !important;
                    }
                    
                    /* Adjust main content to account for search bar height */
                    #kt_app_page {
                        padding-top: calc(140px + var(--status-bar-height)) !important;
                    }
                }

                /* Hide mobile search bar when sidebar drawer is active */
                [data-kt-drawer-name="app-sidebar"][data-kt-drawer="on"]~* .mobile-search-bar,
                body[data-kt-drawer-app-sidebar="on"] .mobile-search-bar {
                    z-index: 100 !important;
                }

                .mobile-search-bar::before {
                    content: '';
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: var(--bs-app-header-base-bg-color, rgba(255, 255, 255, 0.95));
                    z-index: -1;
                }

                /* Dark mode support */
                [data-bs-theme="dark"] .mobile-search-bar {
                    background: var(--bs-app-header-base-bg-color-dark, var(--bs-gray-800));
                }

                [data-bs-theme="dark"] .mobile-search-bar::before {
                    background: var(--bs-app-header-base-bg-color-dark, rgba(30, 30, 30, 0.95));
                }

                /* Skeleton loading styles */
                .skeleton-text {
                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                    background-size: 200% 100%;
                    animation: skeleton-loading 1.5s infinite;
                    border-radius: 4px;
                    height: 16px;
                }

                .skeleton-small {
                    width: 60px;
                    height: 12px;
                }

                .skeleton-medium {
                    width: 120px;
                    height: 16px;
                }

                .skeleton-badge {
                    width: 60px;
                    height: 20px;
                    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                    background-size: 200% 100%;
                    animation: skeleton-loading 1.5s infinite;
                    border-radius: 12px;
                }

                @keyframes skeleton-loading {
                    0% {
                        background-position: 200% 0;
                    }

                    100% {
                        background-position: -200% 0;
                    }
                }

                .skeleton-card {
                    opacity: 0.7;
                }

                /* Enhanced mobile card hover effects */
                .mobile-islander-card {
                    transition: all 0.3s ease;
                    cursor: pointer;
                }

                .mobile-islander-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }

                .mobile-islander-card:active {
                    transform: translateY(0);
                }

                .mobile-islander-card.expanded {
                    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
                    border-color: #007bff;
                }

                .mobile-actions {
                    transition: all 0.4s ease;
                }

                .mobile-actions.show {
                    display: block !important;
                    animation: slideDown 0.4s ease;
                }

                @keyframes slideDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                /* Smooth loading indicator */
                #loading-indicator {
                    transition: opacity 0.3s ease;
                }

                /* Enhanced AOS animations for mobile */
                @media (max-width: 991.98px) {
                    [data-aos="fade-up"] {
                        transform: translate3d(0, 30px, 0);
                        opacity: 0;
                    }

                    [data-aos="fade-up"].aos-animate {
                        transform: translate3d(0, 0, 0);
                        opacity: 1;
                    }
                }

                /* Full screen modals on mobile */
                @media (max-width: 767.98px) {
                    .modal-dialog {
                        margin: 0 !important;
                        max-width: 100% !important;
                        width: 100% !important;
                        height: 100% !important;
                        max-height: 100% !important;
                    }

                    .modal-content {
                        height: 100vh !important;
                        border: none !important;
                        border-radius: 0 !important;
                        display: flex !important;
                        flex-direction: column !important;
                    }

                    .modal-body {
                        flex: 1 !important;
                        overflow-y: auto !important;
                        padding: 1rem !important;
                    }

                    .modal-header {
                        padding: 1rem !important;
                        border-bottom: 1px solid var(--bs-border-color) !important;
                        flex-shrink: 0 !important;
                    }

                    .modal-footer {
                        padding: 1rem !important;
                        border-top: 1px solid var(--bs-border-color) !important;
                        flex-shrink: 0 !important;
                    }

                    /* Ensure modal backdrop doesn't interfere */
                    .modal-backdrop {
                        background-color: rgba(0, 0, 0, 0) !important;
                    }
                }
                </style>

                <!--begin::Mobile UI (visible on mobile only)-->
                <div class="d-lg-none">
                    <!-- Fixed Search Bar -->
                    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2">
                        <div class="container-fluid">
                            <div class="mb-2">
                                <h1 class="text-dark fw-bold ms-2">Islanders</h1>
                            </div>
                            <div class="row align-items-stretch">
                                <div class="col-10">
                                    <div class="position-relative h-100">
                                        <i
                                            class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" id="mobile_search"
                                            class="form-control form-control-solid ps-10 h-100"
                                            placeholder="Search islanders..." value="<?= esc($search) ?>" />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <?php if ($permissions['canCreate']): ?>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#createIslanderModal"
                                        class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="min-height: 48px;">
                                        <i class="ki-duotone ki-plus-square fs-3x">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </button>
                                    <?php else: ?>
                                    <div class="btn btn-light-secondary w-100 h-100 d-flex align-items-center justify-content-center disabled"
                                        style="min-height: 48px;" title="No permission to create islanders">
                                        <i class="ki-duotone ki-lock fs-3x">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Container with top padding to account for fixed search -->
                    <div class="container-fluid" style="padding-top: 5px;">

                        <!-- Flash Messages for Mobile -->
                        <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success d-flex align-items-center p-3 mb-4">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-success me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div>
                                <h6 class="mb-1 text-success">Success</h6>
                                <span class="fs-7"><?= session()->getFlashdata('success') ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger d-flex align-items-center p-3 mb-4">
                            <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <div>
                                <h6 class="mb-1 text-danger">Error</h6>
                                <span class="fs-7"><?= session()->getFlashdata('error') ?></span>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Scrollable Card List -->
                        <div class="row mt-2" id="mobile-cards-container">
                            <?php if (!empty($islanders)): ?>
                            <?php foreach ($islanders as $index => $islander): ?>
                            <?php try { ?>
                            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>"
                                data-aos-duration="600">
                                <div class="card mobile-islander-card" data-islander-id="<?= esc($islander['id']) ?>"
                                    onclick="toggleMobileActions(this)">
                                    <div class="card-body p-4">
                                        <!-- Header with ID and Status -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div>
                                                <small style="color: #a0a0a0; font-size: 12px; font-weight: 500;">
                                                    <?= esc($islander['islander_no']) ?>
                                                </small>
                                            </div>
                                            <div>
                                                <?php if (!empty($islander['status_name'])): ?>
                                                <?php if (!empty($islander['status_color'])): ?>
                                                <?php 
                                        $hex = ltrim($islander['status_color'], '#');
                                        $r = hexdec(substr($hex, 0, 2));
                                        $g = hexdec(substr($hex, 2, 2));
                                        $b = hexdec(substr($hex, 4, 2));
                                        $lightBg = "rgba($r, $g, $b, 0.15)";
                                        ?>
                                                <span
                                                    style="background: <?= $lightBg ?>; color: <?= esc($islander['status_color']) ?>; font-weight: 600; padding: 4px 12px; border-radius: 5px; font-size: 11px;">
                                                    <?= strtoupper(esc($islander['status_name'])) ?>
                                                </span>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <!-- Name Section -->
                                        <div class="row mb-4">
                                            <div class="col-3 mt-2 text-start">
                                                <?php if (!empty($islander['image'])): ?>
                                                <img src="<?= base_url() ?>/assets/media/users/<?= esc($islander['image']) ?>"
                                                    class="ms-2 rounded" width="80" height="80"
                                                    style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                                <?php else: ?>
                                                <img src="https://ui-avatars.com/api/?name=<?= urlencode($islander['full_name']) ?>&background=f4f4f4&color=9ba1b6&font-size=.5"
                                                    class="ms-2 rounded" width="80" height="80"
                                                    style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-9 mt-2 text-start">
                                                <strong class="text-black text-uppercase text-truncate">
                                                    <?= esc($islander['full_name']) ?>
                                                </strong>
                                                <br><small class=""><i class="ki-duotone ki-badge"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span></i>&nbsp;<?= esc($islander['islander_no']) ?></small>
                                                <br><small class=""><i class="ki-duotone ki-setting-3"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span class="path4"></span><span
                                                            class="path5"></span></i>&nbsp;<?= esc($islander['department_name'] ?? 'N/A') ?></small>
                                                <br><small class=""><i class="ki-duotone ki-more-2"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span><span
                                                            class="path4"></span></i>&nbsp;<?= esc($islander['position_name'] ?? 'N/A') ?></small>
                                                <br><small class=""><i class="ki-duotone ki-shield"><span
                                                            class="path1"></span><span
                                                            class="path2"></span></i>&nbsp;Islander / Islander</small>
                                            </div>
                                        </div>


                                        <!-- Footer -->
                                        <div class="d-flex justify-content-between align-items-center"
                                            style="border-top: 1px solid #f0f0f0; padding-top: 15px;">
                                            <small style="color: #999; font-size: 12px; font-weight: 500;">
                                                <?= !empty($islander['created_by_name']) ? esc($islander['created_by_name']) : 'System Administrator' ?>
                                            </small>
                                            <small style="color: #999; font-size: 12px; font-weight: 500;">
                                                <?php if (!empty($islander['created_at'])): ?>
                                                <?= date('M d, Y', strtotime($islander['created_at'])) ?>
                                                <?php endif; ?>
                                            </small>
                                        </div>

                                        <!-- Action Buttons (Hidden by default) -->
                                        <div class="mobile-actions mt-3 pt-3 border-top d-none">
                                            <div class="row g-1">
                                                <?php if (isset($permissions) && $permissions['canView']): ?>
                                                <div class="col-3">
                                                    <button type="button"
                                                        class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-islander-btn"
                                                        data-islander-id="<?= esc($islander['id']) ?>">
                                                        <i class="ki-duotone ki-eye fs-1 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                        </i>
                                                        <span class="d-none d-sm-inline">View</span>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (isset($permissions) && $permissions['canEdit']): ?>
                                                <div class="col-3">
                                                    <button type="button"
                                                        class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-islander-btn"
                                                        data-islander-id="<?= esc($islander['id']) ?>">
                                                        <i class="ki-duotone ki-pencil fs-1 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <span class="d-none d-sm-inline">Edit</span>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (isset($permissions) && $permissions['canEdit']): ?>
                                                <div class="col-3">
                                                    <button type="button"
                                                        class="btn btn-light-info btn-sm w-100 d-flex align-items-center justify-content-center reset-password-btn"
                                                        data-islander-id="<?= esc($islander['id']) ?>"
                                                        title="Reset Password to 1234">
                                                        <i class="ki-duotone ki-key fs-1 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                        <span class="d-none d-sm-inline">Reset</span>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                                <?php if (isset($permissions) && $permissions['canDelete']): ?>
                                                <div class="col-3">
                                                    <button
                                                        class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-islander-btn"
                                                        data-islander-id="<?= esc($islander['id']) ?>">
                                                        <i class="ki-duotone ki-trash fs-1 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span>
                                                            <span class="path4"></span>
                                                            <span class="path5"></span>
                                                        </i>
                                                        <span class="d-none d-sm-inline">Delete</span>
                                                    </button>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } catch (Exception $e) { ?>
                            <div class="col-12 mb-3">
                                <div class="alert alert-danger">
                                    <strong>Error rendering card <?= $index + 1 ?>:</strong><br>
                                    <?= $e->getMessage() ?><br>
                                    Islander ID: <?= $islander['id'] ?? 'unknown' ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center py-10">
                                    <i class="ki-duotone ki-profile-user fs-5x text-gray-500 mb-3 ">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                    <?php if (!empty($search)): ?>
                                    <h6 class="fw-bold text-gray-700 mb-2">No results found for "<?= esc($search) ?>"
                                    </h6>
                                    <p class="fs-7 text-gray-500 mb-4">Try adjusting your search terms or browse all
                                        islanders</p>
                                    <a href="<?= base_url('islanders') ?>" class="btn btn-primary btn-sm">
                                        <i class="ki-duotone ki-cross fs-6 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Clear Search
                                    </a>
                                    <?php else: ?>
                                    <h6 class="fw-bold text-gray-700 mb-2">No islanders found</h6>
                                    <p class="fs-7 text-gray-500 mb-4">Start by creating your first islander entry</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Loading indicator for infinite scroll -->
                        <div id="loading-indicator" class="text-center py-4 d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading more islanders...</p>
                        </div>

                        <!-- No more data indicator -->
                        <div id="no-more-data" class="text-center py-4 d-none">
                            <p class="text-muted">No more islanders to load</p>
                        </div>
                    </div>
                </div>
                <!--end::Mobile UI-->

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid d-none d-lg-flex" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <?php if (session()->getFlashdata('success')): ?>
                                <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                                    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-success">Success</h4>
                                        <span><?= session()->getFlashdata('success') ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                                    <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div class="d-flex flex-column">
                                        <h4 class="mb-1 text-danger">Error</h4>
                                        <span><?= session()->getFlashdata('error') ?></span>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 pt-6">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <input type="text" id="kt_filter_search"
                                                    class="form-control form-control-solid w-250px ps-13"
                                                    placeholder="Search islanders..." value="<?= esc($search) ?>" />
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Toolbar-->
                                            <div class="d-flex justify-content-end"
                                                data-kt-islander-table-toolbar="base">
                                                <!--begin::Add islander-->
                                                <?php if ($permissions['canCreate']): ?>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#createIslanderModal">
                                                    <i class="ki-duotone ki-plus fs-2"></i>Add Islander
                                                </button>
                                                <?php endif; ?>
                                                <!--end::Add islander-->
                                            </div>
                                            <!--end::Toolbar-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->

                                    <!--begin::Card body-->
                                    <div class="card-body py-4">
                                        <!--begin::Table-->
                                        <div class="table-responsive">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5"
                                                id="kt_islander_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="w-10px pe-2">
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    data-kt-check="true"
                                                                    data-kt-check-target="#kt_islander_table .form-check-input"
                                                                    value="1" />
                                                            </div>
                                                        </th>
                                                        <th class="min-w-20px">#</th>
                                                        <th class="min-w-100px">Status</th>
                                                        <th class="min-w-250px">Full Name</th>
                                                        <th class="min-w-100px">Created By</th>
                                                        <th class="min-w-100px">Updated By</th>
                                                        <th class="text-end min-w-100px">Actions</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <?php if (!empty($islanders)): ?>
                                                    <?php foreach ($islanders as $islander): ?>
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Checkbox-->
                                                        <td>
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="<?= esc($islander['id']) ?>" />
                                                            </div>
                                                        </td>
                                                        <!--end::Checkbox-->

                                                        <!--begin::ID-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <small
                                                                    class="text-muted">#<?= esc($islander['id']) ?></small>
                                                            </div>
                                                        </td>
                                                        <!--end::ID-->


                                                        <!--begin::Status-->
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <?php if (!empty($islander['status_name'])): ?>
                                                                <?php 
                                                    // Use custom color if available, otherwise fallback to status-based colors
                                                    if (!empty($islander['status_color'])) {
                                                        // Convert hex color to RGB for light background
                                                        $hex = ltrim($islander['status_color'], '#');
                                                        $r = hexdec(substr($hex, 0, 2));
                                                        $g = hexdec(substr($hex, 2, 2));
                                                        $b = hexdec(substr($hex, 4, 2));
                                                        $lightBg = "rgba($r, $g, $b, 0.1)";
                                                        $textColor = $islander['status_color'];
                                                        $badgeStyle = "background-color: $lightBg; color: $textColor; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                    } else {
                                                        // Fallback to default styling
                                                        $badgeStyle = "padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                    }
                                                    ?>
                                                                <?php if (!empty($islander['status_color'])): ?>
                                                                <span class="badge fw-bold" style="<?= $badgeStyle ?>">
                                                                    <?= strtoupper(esc($islander['status_name'])) ?>
                                                                </span>
                                                                <?php else: ?>
                                                                <span class="badge badge-light-success fw-bold"
                                                                    style="<?= $badgeStyle ?>">
                                                                    <?= strtoupper(esc($islander['status_name'])) ?>
                                                                </span>
                                                                <?php endif; ?>
                                                                <?php else: ?>
                                                                <span class="badge badge-light-secondary fw-bold"
                                                                    style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">N/A</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <!--end::Status-->

                                                        <!--begin::Full Name-->
                                                        <td>
                                                            <!-- <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold"><?= esc($islander['full_name']) ?></span>
                                                <?php if (!empty($islander['email'])): ?>
                                                <small class="text-muted"><?= esc($islander['email']) ?></small>
                                                <?php endif; ?>
                                            </div> -->
                                                            <div class="d-flex align-items-center">
                                                                <?php 
                                                $imageUrl = !empty($islander['image']) ? 
                                                    base_url() . '/assets/media/users/' . $islander['image'] : 
                                                    'https://ui-avatars.com/api/?name=' . urlencode($islander['full_name']) . '&background=f4f4f4&color=9ba1b6&font-size=0.5';
                                                ?>
                                                                <img src="<?= esc($imageUrl) ?>"
                                                                    class="me-2 rounded align-self-start" width="80"
                                                                    height="80"
                                                                    style="max-width: 80px; max-height: 80px; object-fit: cover;"
                                                                    alt="<?= esc($islander['full_name']) ?>">
                                                                <div>
                                                                    <div class="fw-bold text-gray-800">
                                                                        <?= esc($islander['full_name']) ?></div>
                                                                    <small class="text-muted">
                                                                        <i class="ki-duotone ki-badge"><span
                                                                                class="path1"></span><span
                                                                                class="path2"></span><span
                                                                                class="path3"></span><span
                                                                                class="path4"></span><span
                                                                                class="path5"></span></i>&nbsp;<?= esc($islander['islander_no']) ?>
                                                                    </small><br>
                                                                    <small class="text-muted">
                                                                        <i class="ki-duotone ki-setting-3"><span
                                                                                class="path1"></span><span
                                                                                class="path2"></span><span
                                                                                class="path3"></span><span
                                                                                class="path4"></span><span
                                                                                class="path5"></span></i>&nbsp;<?= esc($islander['department_name'] ?? '-') ?>
                                                                    </small><br>
                                                                    <small class="text-muted">
                                                                        <i class="ki-duotone ki-more-2"><span
                                                                                class="path1"></span><span
                                                                                class="path2"></span><span
                                                                                class="path3"></span><span
                                                                                class="path4"></span></i>&nbsp;<?= esc($islander['position_name'] ?? '-') ?>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <!--end::Full Name-->


                                                        <!--begin::Created By-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <?php if (!empty($islander['created_by_name'])): ?>
                                                                <span
                                                                    class="text-muted"><?= esc($islander['created_by_name']) ?></span>
                                                                <?php if (!empty($islander['created_at'])): ?>
                                                                <small
                                                                    class="text-muted"><?= date('d M Y \a\t H:i', strtotime($islander['created_at'])) ?></small>
                                                                <?php endif; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <!--end::Created By-->

                                                        <!--begin::Updated By-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <?php if (!empty($islander['updated_by_name'])): ?>
                                                                <span
                                                                    class="text-muted"><?= esc($islander['updated_by_name']) ?></span>
                                                                <?php if (!empty($islander['updated_at'])): ?>
                                                                <small
                                                                    class="text-muted"><?= date('d M Y \a\t H:i', strtotime($islander['updated_at'])) ?></small>
                                                                <?php endif; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <!--end::Updated By-->

                                                        <!--begin::Action-->
                                                        <td class="text-end">
                                                            <a href="#"
                                                                class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                                data-kt-menu-trigger="click"
                                                                data-kt-menu-placement="bottom-end">
                                                                Actions
                                                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                                            </a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                                data-kt-menu="true">
                                                                <!--begin::Menu item-->
                                                                <?php if ($permissions['canView']): ?>
                                                                <div class="menu-item px-3">
                                                                    <a class="menu-link px-3 view-islander-btn"
                                                                        data-islander-id="<?= esc($islander['id']) ?>">View</a>
                                                                </div>
                                                                <?php endif; ?>
                                                                <!--end::Menu item-->
                                                                <!--begin::Menu item-->
                                                                <?php if ($permissions['canEdit']): ?>
                                                                <div class="menu-item px-3">
                                                                    <a class="menu-link px-3 edit-islander-btn"
                                                                        data-islander-id="<?= esc($islander['id']) ?>">Edit</a>
                                                                </div>
                                                                <?php endif; ?>
                                                                <!--end::Menu item-->
                                                                <!--begin::Menu item-->
                                                                <?php if ($permissions['canEdit']): ?>
                                                                <div class="menu-item px-3">
                                                                    <a class="menu-link px-3 reset-password-btn"
                                                                        data-islander-id="<?= esc($islander['id']) ?>"
                                                                        title="Reset Password to 1234">Reset Pass</a>
                                                                </div>
                                                                <?php endif; ?>
                                                                <!--end::Menu item-->
                                                                <!--begin::Menu item-->
                                                                <?php if ($permissions['canDelete']): ?>
                                                                <div class="menu-item px-3">
                                                                    <a class="menu-link px-3 delete-islander-btn"
                                                                        data-islander-id="<?= esc($islander['id']) ?>">Delete</a>
                                                                </div>
                                                                <?php endif; ?>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu-->
                                                        </td>
                                                        <!--end::Action-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <!--begin::No results-->
                                                    <tr>
                                                        <td colspan="10" class="text-center py-10">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i
                                                                    class="ki-duotone ki-profile-user fs-5x text-gray-500 mb-3">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                    <span class="path4"></span>
                                                                </i>
                                                                <div class="fw-bold text-gray-700 mb-2">No islanders
                                                                    found</div>
                                                                <div class="text-gray-500">Start by creating your first
                                                                    islander entry
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!--end::No results-->
                                                    <?php endif; ?>
                                                </tbody>
                                                <!--end::Table body-->
                                            </table>
                                        </div>
                                        <!--end::Table-->

                                        <!--begin::Table Footer-->
                                        <div class="row align-items-center py-3 border-top border-gray-200">
                                            <div class="col-sm-12 col-md-6">
                                                <div class="d-flex align-items-center">
                                                    <label
                                                        class="form-label fs-6 fw-semibold mb-0 me-2 text-gray-700">Show</label>
                                                    <select class="form-select form-select-sm w-auto me-2"
                                                        id="kt_islander_table_length"
                                                        onchange="changeTableLimit(this.value)"
                                                        style="min-width: 65px;">
                                                        <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10
                                                        </option>
                                                        <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25
                                                        </option>
                                                        <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50
                                                        </option>
                                                        <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100
                                                        </option>
                                                    </select>
                                                    <label
                                                        class="form-label fs-6 fw-semibold mb-0 text-gray-700">entries</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-6">
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <div class="dataTables_info me-4" role="status" aria-live="polite">
                                                        <span class="text-gray-700 fw-semibold fs-6">
                                                            Showing <?= (($currentPage - 1) * $limit) + 1 ?> to
                                                            <?= min($currentPage * $limit, $totalIslanders) ?> of
                                                            <?= $totalIslanders ?>
                                                            entries
                                                        </span>
                                                    </div>
                                                    <div class="dataTables_paginate">
                                                        <ul class="pagination pagination-sm">
                                                            <?php if ($currentPage > 1): ?>
                                                            <li class="page-item">
                                                                <a href="<?= base_url('islanders?page=' . ($currentPage - 1) . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>"
                                                                    class="page-link"
                                                                    data-page="<?= $currentPage - 1 ?>"
                                                                    title="Previous">
                                                                    <i class="ki-duotone ki-left fs-3"></i>
                                                                </a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li class="page-item disabled">
                                                                <span class="page-link">
                                                                    <i class="ki-duotone ki-left fs-3"></i>
                                                                </span>
                                                            </li>
                                                            <?php endif; ?>

                                                            <?php
                                            // Calculate page range for display
                                            $startPage = max(1, $currentPage - 1);
                                            $endPage = min($totalPages, $currentPage + 1);
                                            
                                            // Adjust if we're at the beginning or end
                                            if ($currentPage <= 2) {
                                                $endPage = min($totalPages, 4);
                                            }
                                            if ($currentPage >= $totalPages - 1) {
                                                $startPage = max(1, $totalPages - 3);
                                            }
                                            
                                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                                            <li
                                                                class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                                <a href="<?= base_url('islanders?page=' . $i . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>"
                                                                    class="page-link"
                                                                    data-page="<?= $i ?>"><?= $i ?></a>
                                                            </li>
                                                            <?php endfor; ?>

                                                            <?php if ($currentPage < $totalPages): ?>
                                                            <li class="page-item">
                                                                <a href="<?= base_url('islanders?page=' . ($currentPage + 1) . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>"
                                                                    class="page-link"
                                                                    data-page="<?= $currentPage + 1 ?>" title="Next">
                                                                    <i class="ki-duotone ki-right fs-3"></i>
                                                                </a>
                                                            </li>
                                                            <?php else: ?>
                                                            <li class="page-item disabled">
                                                                <span class="page-link">
                                                                    <i class="ki-duotone ki-right fs-3"></i>
                                                                </span>
                                                            </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Table Footer-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                </div>
                <!--end::Main-->

                <!-- Include Modals -->
              <!--begin::Modal - Create Islander-->
<div class="modal fade" id="createIslanderModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="createIslanderModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add New Islander</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-islanders-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="createIslanderModal_form" class="form" action="#">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="createIslanderModal_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#createIslanderModal_header"
                        data-kt-scroll-wrappers="#createIslanderModal_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Input group-->
                            <div class="fv-col col-md-6 mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2 mt-4">Profile Image</label>
                                <!--end::Label-->
                                <!--begin::Image preview-->
                                <div class="image-input image-input-outline image-input-placeholder mb-4 mt-5"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing image-->
                                    <div class="image-input-wrapper w-125px h-125px mb-4" id="profile_image_preview"
                                        style="background-image: url('<?= base_url('assets/media/svg/files/blank-image.svg') ?>')">
                                    </div>
                                    <!--end::Preview existing image-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change image">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="profile_image" accept=".png,.jpg,.jpeg,.gif" />
                                        <input type="hidden" name="profile_image_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel image">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove image">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image preview-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg, gif. Max size: 2MB.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-col col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">Islander #</label>
                                    <small>(This will be the username.)</small>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="islander_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter islander number" value="" />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="islander_no"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">NID/PP/WP #</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="id_pp_wp_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter NID/PP/WP number" value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="id_pp_wp_no"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row ">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="status_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select status"
                                        data-dropdown-parent="#createIslanderModal">
                                        <option value="">Select Status</option>
                                        <?php if (!empty($statuses)): ?>
                                        <?php foreach ($statuses as $status): ?>
                                        <option value="<?= esc($status['id']) ?>"><?= esc($status['name']) ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="status_id"></div>
                                    </div>
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Personal Informations</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

        <!--begin::Input group-->
        <div class="mb-7">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="full_name" class="form-control form-control-solid"
                placeholder="Enter full name" value="" required />
            <div class="fv-plugins-message-container invalid-feedback">
                <div class="fv-help-block" data-field="full_name"></div>
            </div>
            <!--end::Input-->
        </div>
        <!--end::Input group-->                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Enter email address" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="email"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone" class="form-control form-control-solid"
                                    placeholder="Enter phone number" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="phone"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="gender_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select gender" data-dropdown-parent="#createIslanderModal" required>
                                    <option value="">Select Gender</option>
                                    <?php if (!empty($genders)): ?>
                                    <?php foreach ($genders as $gender): ?>
                                    <option value="<?= esc($gender['id']) ?>"><?= esc($gender['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="gender_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nationality</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="nationality_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select nationality"
                                    data-dropdown-parent="#createIslanderModal" required>
                                    <option value="">Select Nationality</option>
                                    <?php if (!empty($nationalities)): ?>
                                    <?php foreach ($nationalities as $nationality): ?>
                                    <option value="<?= esc($nationality['id']) ?>"><?= esc($nationality['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="nationality_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Date of Birth</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="date_of_birth"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Select date of birth" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="date_of_birth"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Address</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="address" class="form-control form-control-solid" rows="3"
                                    placeholder="Enter address"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Work Informations</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Division</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="division_id" id="division_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select division"
                                    data-dropdown-parent="#createIslanderModal" required>
                                    <option value="">Select Division</option>
                                    <?php if (!empty($divisions)): ?>
                                    <?php foreach ($divisions as $division): ?>
                                    <option value="<?= esc($division['id']) ?>"><?= esc($division['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="division_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Department</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="department_id" id="department_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select department"
                                    data-dropdown-parent="#createIslanderModal" disabled required>
                                    <option value="">Select Division First</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="department_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Section</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="section_id" id="section_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select section"
                                    data-dropdown-parent="#createIslanderModal" disabled required>
                                    <option value="">Select Department First</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="section_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Position</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="position_id" id="position_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select position"
                                    data-dropdown-parent="#createIslanderModal" disabled required>
                                    <option value="">Select Section First</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="position_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">House</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="house_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select house" data-dropdown-parent="#createIslanderModal" required>
                                    <option value="">Select House</option>
                                    <?php if (!empty($houses)): ?>
                                    <?php foreach ($houses as $house): ?>
                                    <option value="<?= esc($house['id']) ?>"><?= esc($house['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="house_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Join Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="join_date" class="form-control form-control-solid"
                                    placeholder="Select join date" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="join_date"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Notes</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="notes" class="form-control form-control-solid" rows="3"
                                    placeholder="Enter any additional notes"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">User Account</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Role</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="role_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select role" data-dropdown-parent="#createIslanderModal" required>
                                    <option value="">Select Role</option>
                                    <?php if (!empty($auth_groups)): ?>
                                    <?php foreach ($auth_groups as $group): ?>
                                    <option value="<?= esc($group->id) ?>"><?= esc($group->name) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="role_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Password</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="password" name="password" class="form-control form-control-solid"
                                    placeholder="Enter password" value="1234" required autocomplete="new-password" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="password"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="reset" id="createIslanderModal_cancel" class="btn btn-light me-3">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="createIslanderModal_submit" class="btn btn-primary">
                    <span class="indicator-label">Submit</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Create Islander-->

<script>
"use strict";

// Class definition
var CreateIslanderModal = function() {
    var modal;
    var form;
    var submitButton;
    var cancelButton;
    var validator;

    // Initialize modal
    var initModal = function() {
        modal = new bootstrap.Modal(document.querySelector('#createIslanderModal'));
    };

    // Initialize form
    var initForm = function() {
        form = document.querySelector('#createIslanderModal_form');
        submitButton = document.querySelector('#createIslanderModal_submit');
        cancelButton = document.querySelector('#createIslanderModal_cancel');

        // Check if required elements exist
        if (!form || !submitButton || !cancelButton) {
            return;
        }

        // Check if FormValidation is available
        if (typeof FormValidation === 'undefined') {
            return;
        }

        // Initialize form validation
        try {
            validator = FormValidation.formValidation(form, {
                fields: {
                    'islander_no': {
                        validators: {
                            notEmpty: {
                                message: 'Islander number is required'
                            }
                        }
                    },
                    'id_pp_wp_no': {
                        validators: {
                            notEmpty: {
                                message: 'NID/PP/WP number is required'
                            }
                        }
                    },
                    'status_id': {
                        validators: {
                            notEmpty: {
                                message: 'Status is required'
                            }
                        }
                    },
                    'full_name': {
                        validators: {
                            notEmpty: {
                                message: 'Full name is required'
                            }
                        }
                    },
                    'email': {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'Please enter a valid email address'
                            }
                        }
                    },
                    'phone': {
                        validators: {
                            notEmpty: {
                                message: 'Phone number is required'
                            }
                        }
                    },
                    'gender_id': {
                        validators: {
                            notEmpty: {
                                message: 'Gender is required'
                            }
                        }
                    },
                    'nationality_id': {
                        validators: {
                            notEmpty: {
                                message: 'Nationality is required'
                            }
                        }
                    },
                    'date_of_birth': {
                        validators: {
                            notEmpty: {
                                message: 'Date of birth is required'
                            }
                        }
                    },
                    'division_id': {
                        validators: {
                            notEmpty: {
                                message: 'Division is required'
                            }
                        }
                    },
                    'department_id': {
                        validators: {
                            notEmpty: {
                                message: 'Department is required'
                            }
                        }
                    },
                    'section_id': {
                        validators: {
                            notEmpty: {
                                message: 'Section is required'
                            }
                        }
                    },
                    'position_id': {
                        validators: {
                            notEmpty: {
                                message: 'Position is required'
                            }
                        }
                    },
                    'house_id': {
                        validators: {
                            notEmpty: {
                                message: 'House is required'
                            }
                        }
                    },
                    'join_date': {
                        validators: {
                            notEmpty: {
                                message: 'Join date is required'
                            }
                        }
                    },
                    'role_id': {
                        validators: {
                            notEmpty: {
                                message: 'Role is required'
                            }
                        }
                    },
                    'password': {
                        validators: {
                            notEmpty: {
                                message: 'Password is required'
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger()
                }
            });
        } catch (error) {
            validator = null;
        }

        // Handle form submission
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function(status) {
                    if (status == 'Valid') {
                        submitForm();
                    } else {
                        // For now, let's bypass FormValidation and use our manual validation
                        performManualValidation();
                    }
                });
            } else {
                performManualValidation();
            }
        });

        // Manual validation function
        function performManualValidation() {
                // Clear all previous errors
                clearAllErrors();

                // If validation is not available, perform basic checks
                const islanderNo = form.querySelector('input[name="islander_no"]');
                const idPpWpNo = form.querySelector('input[name="id_pp_wp_no"]');
                const statusId = form.querySelector('select[name="status_id"]');
                const fullName = form.querySelector('input[name="full_name"]');
                const email = form.querySelector('input[name="email"]');
                const phone = form.querySelector('input[name="phone"]');
                const genderId = form.querySelector('select[name="gender_id"]');
                const nationalityId = form.querySelector('select[name="nationality_id"]');
                const dateOfBirth = form.querySelector('input[name="date_of_birth"]');
                const divisionId = form.querySelector('select[name="division_id"]');
                const departmentId = form.querySelector('select[name="department_id"]');
                const sectionId = form.querySelector('select[name="section_id"]');
                const positionId = form.querySelector('select[name="position_id"]');
                const houseId = form.querySelector('select[name="house_id"]');
                const joinDate = form.querySelector('input[name="join_date"]');
                const roleId = form.querySelector('select[name="role_id"]');
                const password = form.querySelector('input[name="password"]');

                let hasErrors = false;

                // Check all required fields and show errors
                if (!islanderNo || !islanderNo.value.trim()) {
                    showFieldError('islander_no', 'Islander number is required');
                    hasErrors = true;
                }
                if (!idPpWpNo || !idPpWpNo.value.trim()) {
                    showFieldError('id_pp_wp_no', 'NID/PP/WP number is required');
                    hasErrors = true;
                }
                if (!statusId || !statusId.value) {
                    showFieldError('status_id', 'Status is required');
                    hasErrors = true;
                }
                if (!fullName || !fullName.value.trim()) {
                    showFieldError('full_name', 'Full name is required');
                    hasErrors = true;
                }
                if (!email || !email.value.trim()) {
                    showFieldError('email', 'Email is required');
                    hasErrors = true;
                } else if (email.value.trim() && !isValidEmail(email.value.trim())) {
                    showFieldError('email', 'Please enter a valid email address');
                    hasErrors = true;
                }
                if (!phone || !phone.value.trim()) {
                    showFieldError('phone', 'Phone number is required');
                    hasErrors = true;
                }
                if (!genderId || !genderId.value) {
                    showFieldError('gender_id', 'Gender is required');
                    hasErrors = true;
                }
                if (!nationalityId || !nationalityId.value) {
                    showFieldError('nationality_id', 'Nationality is required');
                    hasErrors = true;
                }
                if (!dateOfBirth || !dateOfBirth.value) {
                    showFieldError('date_of_birth', 'Date of birth is required');
                    hasErrors = true;
                }
                if (!divisionId || !divisionId.value) {
                    showFieldError('division_id', 'Division is required');
                    hasErrors = true;
                }
                if (!departmentId || !departmentId.value) {
                    showFieldError('department_id', 'Department is required');
                    hasErrors = true;
                }
                if (!sectionId || !sectionId.value) {
                    showFieldError('section_id', 'Section is required');
                    hasErrors = true;
                }
                if (!positionId || !positionId.value) {
                    showFieldError('position_id', 'Position is required');
                    hasErrors = true;
                }
                if (!houseId || !houseId.value) {
                    showFieldError('house_id', 'House is required');
                    hasErrors = true;
                }
                if (!joinDate || !joinDate.value) {
                    showFieldError('join_date', 'Join date is required');
                    hasErrors = true;
                }
                if (!roleId || !roleId.value) {
                    showFieldError('role_id', 'Role is required');
                    hasErrors = true;
                }
                if (!password || !password.value.trim()) {
                    showFieldError('password', 'Password is required');
                    hasErrors = true;
                }

                if (hasErrors) {
                    return;
                }

                submitForm();
        }

        // Helper function to show field error
        function showFieldError(fieldName, message) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const errorContainer = form.querySelector(`[data-field="${fieldName}"]`);
            
            if (field && errorContainer) {
                // Add error class to field
                field.classList.add('is-invalid');
                
                // Show error message
                errorContainer.textContent = message;
                errorContainer.parentElement.style.display = 'block';
            }
        }

        // Helper function to clear all errors
        function clearAllErrors() {
            // Remove error classes from all fields
            const fields = form.querySelectorAll('.is-invalid');
            fields.forEach(field => {
                field.classList.remove('is-invalid');
            });
            
            // Hide all error messages
            const errorContainers = form.querySelectorAll('.fv-plugins-message-container');
            errorContainers.forEach(container => {
                container.style.display = 'none';
            });
        }

        // Helper function to validate email
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Handle cancel button
        cancelButton.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you want to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    form.reset();
                    modal.hide();
                }
            });
        });

        // Handle modal close
        document.querySelector('[data-kt-islanders-modal-action="close"]').addEventListener('click', function(
            e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you want to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    form.reset();
                    modal.hide();
                }
            });
        });
    };

    // Submit form
    var submitForm = function() {
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;

        const formData = new FormData(form);

        $.ajax({
            url: '<?= base_url('islanders') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                // Request started
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message || "Islander has been successfully created!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            modal.hide();
                            form.reset();
                            window.location.reload();
                        }
                    });
                } else {
                    let errorMessage = response.message ||
                        'An error occurred while creating the islander.';

                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('<br>');
                    }

                    Swal.fire({
                        html: errorMessage,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error creating islander:', error);

                let errorMessage = 'An error occurred while creating the islander.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            },
            complete: function() {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            }
        });
    };

    // Initialize select2 dropdowns
    var initSelect2 = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping Select2 initialization');
            return;
        }

        $('#createIslanderModal').on('shown.bs.modal', function() {
            // Initialize Select2 for all select elements in the modal
            $(this).find('select[data-control="select2"]').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2({
                        dropdownParent: $('#createIslanderModal')
                    });
                }
            });
        });

        // Destroy Select2 when modal is hidden
        $('#createIslanderModal').on('hidden.bs.modal', function() {
            $(this).find('select[data-control="select2"]').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });
        });
    };

    // Initialize cascading dropdowns
    var initCascadingDropdowns = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping cascading dropdown initialization');
            return;
        }

        // Division change handler
        $(document).on('change', '#division_id', function() {
            const divisionId = $(this).val();
            const $departmentSelect = $('#department_id');
            const $sectionSelect = $('#section_id');
            const $positionSelect = $('#position_id');

            // Reset dependent dropdowns
            resetDropdown($departmentSelect, 'Select Division First', true);
            resetDropdown($sectionSelect, 'Select Department First', true);
            resetDropdown($positionSelect, 'Select Section First', true);

            if (divisionId) {
                // Enable and load departments
                $departmentSelect.prop('disabled', false);
                loadDepartments(divisionId);
            }
        });

        // Department change handler
        $(document).on('change', '#department_id', function() {
            const departmentId = $(this).val();
            const $sectionSelect = $('#section_id');
            const $positionSelect = $('#position_id');

            // Reset dependent dropdowns
            resetDropdown($sectionSelect, 'Select Department First', true);
            resetDropdown($positionSelect, 'Select Section First', true);

            if (departmentId) {
                // Enable and load sections
                $sectionSelect.prop('disabled', false);
                loadSections(departmentId);
            }
        });

        // Section change handler
        $(document).on('change', '#section_id', function() {
            const sectionId = $(this).val();
            const $positionSelect = $('#position_id');

            // Reset dependent dropdown
            resetDropdown($positionSelect, 'Select Section First', true);

            if (sectionId) {
                // Enable and load positions
                $positionSelect.prop('disabled', false);
                loadPositions(sectionId);
            }
        });
    };

    // Helper function to reset dropdown
    var resetDropdown = function($select, placeholder, disable = false) {
        if ($select.hasClass('select2-hidden-accessible')) {
            $select.val('').trigger('change');
            $select.empty().append('<option value="">' + placeholder + '</option>');
            $select.prop('disabled', disable);
        } else {
            $select.empty().append('<option value="">' + placeholder + '</option>');
            $select.prop('disabled', disable);
        }
    };

    // Load departments by division
    var loadDepartments = function(divisionId) {
        const $departmentSelect = $('#department_id');

        // Show loading state
        $departmentSelect.empty().append('<option value="">Loading departments...</option>');

        $.ajax({
            url: '<?= base_url('islanders/departments-by-division') ?>',
            type: 'GET',
            data: {
                division_id: divisionId
            },
            dataType: 'json',
            success: function(departments) {
                $departmentSelect.empty().append('<option value="">Select Department</option>');

                if (departments && departments.length > 0) {
                    $.each(departments, function(index, department) {
                        $departmentSelect.append('<option value="' + department.id + '">' +
                            department.name + '</option>');
                    });
                } else {
                    $departmentSelect.append('<option value="">No departments available</option>');
                }

                // Trigger change for Select2
                if ($departmentSelect.hasClass('select2-hidden-accessible')) {
                    $departmentSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading departments:', error);
                $departmentSelect.empty().append(
                    '<option value="">Error loading departments</option>');
            }
        });
    };

    // Load sections by department
    var loadSections = function(departmentId) {
        const $sectionSelect = $('#section_id');

        // Show loading state
        $sectionSelect.empty().append('<option value="">Loading sections...</option>');

        $.ajax({
            url: '<?= base_url('islanders/sections-by-department') ?>',
            type: 'GET',
            data: {
                department_id: departmentId
            },
            dataType: 'json',
            success: function(sections) {
                $sectionSelect.empty().append('<option value="">Select Section</option>');

                if (sections && sections.length > 0) {
                    $.each(sections, function(index, section) {
                        $sectionSelect.append('<option value="' + section.id + '">' +
                            section.name + '</option>');
                    });
                } else {
                    $sectionSelect.append('<option value="">No sections available</option>');
                }

                // Trigger change for Select2
                if ($sectionSelect.hasClass('select2-hidden-accessible')) {
                    $sectionSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading sections:', error);
                $sectionSelect.empty().append('<option value="">Error loading sections</option>');
            }
        });
    };

    // Load positions by section
    var loadPositions = function(sectionId) {
        const $positionSelect = $('#position_id');

        // Show loading state
        $positionSelect.empty().append('<option value="">Loading positions...</option>');

        $.ajax({
            url: '<?= base_url('islanders/positions-by-section') ?>',
            type: 'GET',
            data: {
                section_id: sectionId
            },
            dataType: 'json',
            success: function(positions) {
                $positionSelect.empty().append('<option value="">Select Position</option>');

                if (positions && positions.length > 0) {
                    $.each(positions, function(index, position) {
                        $positionSelect.append('<option value="' + position.id + '">' +
                            position.name + '</option>');
                    });
                } else {
                    $positionSelect.append('<option value="">No positions available</option>');
                }

                // Trigger change for Select2
                if ($positionSelect.hasClass('select2-hidden-accessible')) {
                    $positionSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading positions:', error);
                $positionSelect.empty().append('<option value="">Error loading positions</option>');
            }
        });
    };

    // Initialize image inputs
    var initImageInputs = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping image input validation');
            return;
        }

        // Initialize KTImageInput for profile image
        if (typeof KTImageInput !== 'undefined') {
            try {
                // Initialize all image inputs in the modal using selector
                KTImageInput.createInstances('#createIslanderModal [data-kt-image-input="true"]');
            } catch (e) {
                console.log('KTImageInput not available:', e);
            }
        }

        // File validation for image uploads
        $('#createIslanderModal input[name="profile_image"]')
            .on('change', function() {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

                if (file) {
                    // Check file size
                    if (file.size > maxSize) {
                        Swal.fire({
                            text: "File size must be less than 2MB",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        this.value = '';
                        return;
                    }

                    // Check file type
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            text: "Only PNG, JPG, JPEG and GIF files are allowed",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        this.value = '';
                        return;
                    }
                }
            });
    };

    // Public methods
    return {
        init: function() {
            initModal();
            initForm();
            initSelect2();
            initCascadingDropdowns();
            initImageInputs();
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        CreateIslanderModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            CreateIslanderModal.init();
        } else {
            // Initialize anyway
            CreateIslanderModal.init();
        }
    });
}
</script>
                <!--begin::Modal - Edit Islander-->
<div class="modal fade" id="editIslanderModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="editIslanderModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Islander</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-islanders-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="editIslanderModal_form" class="form" action="#">
                    <input type="hidden" name="id" id="edit_islander_id" value="">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="editIslanderModal_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#editIslanderModal_header"
                        data-kt-scroll-wrappers="#editIslanderModal_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Input group-->
                            <div class="fv-col col-md-6 mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2 mt-4">Profile Image</label>
                                <!--end::Label-->
                                <!--begin::Image preview-->
                                <div class="image-input image-input-outline image-input-placeholder mb-4 mt-5"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing image-->
                                    <div class="image-input-wrapper w-125px h-125px mb-4" id="edit_profile_image_preview"
                                        style="background-image: url('<?= base_url('assets/media/svg/files/blank-image.svg') ?>')">
                                    </div>
                                    <!--end::Preview existing image-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change image">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="profile_image" accept=".png,.jpg,.jpeg,.gif" />
                                        <input type="hidden" name="profile_image_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel image">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove image">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image preview-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg, gif. Max size: 2MB.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-col col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">Islander #</label>
                                    <small>(This will be the username.)</small>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="islander_no" id="edit_islander_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter islander number" value="" />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="islander_no"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">NID/PP/WP #</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="id_pp_wp_no" id="edit_id_pp_wp_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter NID/PP/WP number" value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="id_pp_wp_no"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row ">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="status_id" id="edit_status_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select status"
                                        data-dropdown-parent="#editIslanderModal">
                                        <option value="">Select Status</option>
                                        <?php if (!empty($statuses)): ?>
                                        <?php foreach ($statuses as $status): ?>
                                        <option value="<?= esc($status['id']) ?>"><?= esc($status['name']) ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="status_id"></div>
                                    </div>
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Personal Informations</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

        <!--begin::Input group-->
        <div class="mb-7">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="full_name" id="edit_full_name" class="form-control form-control-solid"
                placeholder="Enter full name" value="" required />
            <div class="fv-plugins-message-container invalid-feedback">
                <div class="fv-help-block" data-field="full_name"></div>
            </div>
            <!--end::Input-->
        </div>
        <!--end::Input group-->                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" id="edit_email" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Enter email address" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="email"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone" id="edit_phone" class="form-control form-control-solid"
                                    placeholder="Enter phone number" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="phone"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="gender_id" id="edit_gender_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select gender" data-dropdown-parent="#editIslanderModal" required>
                                    <option value="">Select Gender</option>
                                    <?php if (!empty($genders)): ?>
                                    <?php foreach ($genders as $gender): ?>
                                    <option value="<?= esc($gender['id']) ?>"><?= esc($gender['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="gender_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nationality</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="nationality_id" id="edit_nationality_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select nationality"
                                    data-dropdown-parent="#editIslanderModal" required>
                                    <option value="">Select Nationality</option>
                                    <?php if (!empty($nationalities)): ?>
                                    <?php foreach ($nationalities as $nationality): ?>
                                    <option value="<?= esc($nationality['id']) ?>"><?= esc($nationality['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="nationality_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Date of Birth</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="date_of_birth" id="edit_date_of_birth"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Select date of birth" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="date_of_birth"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Address</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="address" id="edit_address" class="form-control form-control-solid" rows="3"
                                    placeholder="Enter address"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Work Informations</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Division</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="division_id" id="edit_division_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select division"
                                    data-dropdown-parent="#editIslanderModal" required>
                                    <option value="">Select Division</option>
                                    <?php if (!empty($divisions)): ?>
                                    <?php foreach ($divisions as $division): ?>
                                    <option value="<?= esc($division['id']) ?>"><?= esc($division['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="division_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Department</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="department_id" id="edit_department_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select department"
                                    data-dropdown-parent="#editIslanderModal" disabled required>
                                    <option value="">Select Division First</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="department_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Section</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="section_id" id="edit_section_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select section"
                                    data-dropdown-parent="#editIslanderModal" disabled required>
                                    <option value="">Select Department First</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="section_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Position</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="position_id" id="edit_position_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select position"
                                    data-dropdown-parent="#editIslanderModal" disabled required>
                                    <option value="">Select Section First</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="position_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">House</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="house_id" id="edit_house_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select house" data-dropdown-parent="#editIslanderModal" required>
                                    <option value="">Select House</option>
                                    <?php if (!empty($houses)): ?>
                                    <?php foreach ($houses as $house): ?>
                                    <option value="<?= esc($house['id']) ?>"><?= esc($house['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="house_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Join Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="join_date" id="edit_join_date" class="form-control form-control-solid"
                                    placeholder="Select join date" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="join_date"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Notes</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="notes" id="edit_notes" class="form-control form-control-solid" rows="3"
                                    placeholder="Enter any additional notes"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">User Account</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Role</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="role_id" id="edit_role_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select role" data-dropdown-parent="#editIslanderModal" required>
                                    <option value="">Select Role</option>
                                    <?php if (!empty($auth_groups)): ?>
                                    <?php foreach ($auth_groups as $group): ?>
                                    <option value="<?= esc($group->id) ?>"><?= esc($group->name) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="role_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Password</label>
                                <small>(Leave blank to keep current password)</small>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="password" name="password" id="edit_password" class="form-control form-control-solid"
                                    placeholder="Enter new password (optional)" value="" autocomplete="new-password" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="password"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="reset" id="kt_islanders_edit_cancel" class="btn btn-light me-3">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_islanders_edit_submit" class="btn btn-primary">
                    <span class="indicator-label">Update</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Edit Islander-->

<script>
"use strict";

// Class definition
var EditIslanderModal = function() {
    var modal;
    var form;
    var submitButton;
    var cancelButton;
    var validator;

    // Initialize modal
    var initModal = function() {
        modal = new bootstrap.Modal(document.querySelector('#editIslanderModal'));
    };

    // Initialize form
    var initForm = function() {
        form = document.querySelector('#editIslanderModal_form');
        submitButton = document.querySelector('#kt_islanders_edit_submit');
        cancelButton = document.querySelector('#kt_islanders_edit_cancel');

        // Check if required elements exist
        if (!form || !submitButton || !cancelButton) {
            return;
        }

        // Try to initialize FormValidation if available
        try {
            if (typeof FormValidation !== 'undefined') {
                validator = FormValidation.formValidation(form, {
                    fields: {
                        'islander_no': {
                            validators: {
                                notEmpty: {
                                    message: 'Islander number is required'
                                }
                            }
                        },
                        'id_pp_wp_no': {
                            validators: {
                                notEmpty: {
                                    message: 'NID/PP/WP number is required'
                                }
                            }
                        },
                        'status_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Status is required'
                                }
                            }
                        },
                        'full_name': {
                            validators: {
                                notEmpty: {
                                    message: 'Full name is required'
                                }
                            }
                        },
                        'email': {
                            validators: {
                                notEmpty: {
                                    message: 'Email is required'
                                },
                                emailAddress: {
                                    message: 'Please enter a valid email address'
                                }
                            }
                        },
                        'phone': {
                            validators: {
                                notEmpty: {
                                    message: 'Phone number is required'
                                }
                            }
                        },
                        'gender_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Gender is required'
                                }
                            }
                        },
                        'nationality_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Nationality is required'
                                }
                            }
                        },
                        'date_of_birth': {
                            validators: {
                                notEmpty: {
                                    message: 'Date of birth is required'
                                }
                            }
                        },
                        'division_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Division is required'
                                }
                            }
                        },
                        'department_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Department is required'
                                }
                            }
                        },
                        'section_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Section is required'
                                }
                            }
                        },
                        'position_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Position is required'
                                }
                            }
                        },
                        'house_id': {
                            validators: {
                                notEmpty: {
                                    message: 'House is required'
                                }
                            }
                        },
                        'join_date': {
                            validators: {
                                notEmpty: {
                                    message: 'Join date is required'
                                }
                            }
                        },
                        'role_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Role is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                });
            }
        } catch (error) {
            validator = null;
        }

        // Handle form submission
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function(status) {
                    if (status == 'Valid') {
                        submitForm();
                    } else {
                        if (validateForm()) {
                            submitForm();
                        }
                    }
                });
            } else {
                if (validateForm()) {
                    submitForm();
                }
            }
        });

        // Manual validation function
        function validateForm() {
            clearAllErrors();

            // Get form elements
            const islanderNo = form.querySelector('input[name="islander_no"]');
            const idPpWpNo = form.querySelector('input[name="id_pp_wp_no"]');
            const statusId = form.querySelector('select[name="status_id"]');
            const fullName = form.querySelector('input[name="full_name"]');
            const email = form.querySelector('input[name="email"]');
            const phone = form.querySelector('input[name="phone"]');
            const genderId = form.querySelector('select[name="gender_id"]');
            const nationalityId = form.querySelector('select[name="nationality_id"]');
            const dateOfBirth = form.querySelector('input[name="date_of_birth"]');
            const divisionId = form.querySelector('select[name="division_id"]');
            const departmentId = form.querySelector('select[name="department_id"]');
            const sectionId = form.querySelector('select[name="section_id"]');
            const positionId = form.querySelector('select[name="position_id"]');
            const houseId = form.querySelector('select[name="house_id"]');
            const joinDate = form.querySelector('input[name="join_date"]');
            const roleId = form.querySelector('select[name="role_id"]');

            let hasErrors = false;

            // Check all required fields and show errors
            if (!islanderNo || !islanderNo.value.trim()) {
                showFieldError('islander_no', 'Islander number is required');
                hasErrors = true;
            }
            if (!idPpWpNo || !idPpWpNo.value.trim()) {
                showFieldError('id_pp_wp_no', 'NID/PP/WP number is required');
                hasErrors = true;
            }
            if (!statusId || !statusId.value) {
                showFieldError('status_id', 'Status is required');
                hasErrors = true;
            }
            if (!fullName || !fullName.value.trim()) {
                showFieldError('full_name', 'Full name is required');
                hasErrors = true;
            }
            if (!email || !email.value.trim()) {
                showFieldError('email', 'Email is required');
                hasErrors = true;
            } else if (email.value.trim() && !isValidEmail(email.value.trim())) {
                showFieldError('email', 'Please enter a valid email address');
                hasErrors = true;
            }
            if (!phone || !phone.value.trim()) {
                showFieldError('phone', 'Phone number is required');
                hasErrors = true;
            }
            if (!genderId || !genderId.value) {
                showFieldError('gender_id', 'Gender is required');
                hasErrors = true;
            }
            if (!nationalityId || !nationalityId.value) {
                showFieldError('nationality_id', 'Nationality is required');
                hasErrors = true;
            }
            if (!dateOfBirth || !dateOfBirth.value.trim()) {
                showFieldError('date_of_birth', 'Date of birth is required');
                hasErrors = true;
            }
            if (!divisionId || !divisionId.value) {
                showFieldError('division_id', 'Division is required');
                hasErrors = true;
            }
            if (!departmentId || !departmentId.value) {
                showFieldError('department_id', 'Department is required');
                hasErrors = true;
            }
            if (!sectionId || !sectionId.value) {
                showFieldError('section_id', 'Section is required');
                hasErrors = true;
            }
            if (!positionId || !positionId.value) {
                showFieldError('position_id', 'Position is required');
                hasErrors = true;
            }
            if (!houseId || !houseId.value) {
                showFieldError('house_id', 'House is required');
                hasErrors = true;
            }
            if (!joinDate || !joinDate.value.trim()) {
                showFieldError('join_date', 'Join date is required');
                hasErrors = true;
            }
            if (!roleId || !roleId.value) {
                showFieldError('role_id', 'Role is required');
                hasErrors = true;
            }

            if (hasErrors) {
                return false;
            }

            return true;
        }

        // Helper function to show field error
        function showFieldError(fieldName, message) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const errorContainer = form.querySelector(`[data-field="${fieldName}"]`);
            
            if (field && errorContainer) {
                // Add error class to field
                field.classList.add('is-invalid');
                
                // Show error message
                errorContainer.textContent = message;
                errorContainer.style.display = 'block';
            }
        }

        // Helper function to clear all errors
        function clearAllErrors() {
            // Remove error classes from all fields
            const fields = form.querySelectorAll('.is-invalid');
            fields.forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Clear all error messages
            const errorContainers = form.querySelectorAll('[data-field]');
            errorContainers.forEach(container => {
                container.textContent = '';
                container.style.display = 'none';
            });
        }

        // Email validation helper
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Handle cancel button
        cancelButton.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you want to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    form.reset();
                    clearAllErrors();
                    modal.hide();
                }
            });
        });

        // Handle modal close
        document.querySelector('#editIslanderModal [data-kt-islanders-modal-action="close"]').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you want to cancel?",
                icon: "warning",
                showCancelButton: true,
                buttonsStyling: false,
                confirmButtonText: "Yes, cancel it!",
                cancelButtonText: "No, return",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-active-light"
                }
            }).then(function(result) {
                if (result.value) {
                    form.reset();
                    clearAllErrors();
                    modal.hide();
                }
            });
        });
    };

    // Submit form with AJAX
    var submitForm = function() {
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;

        const formData = new FormData(form);
        const islanderId = document.getElementById('edit_islander_id').value;

        $.ajax({
            url: `<?= base_url('islanders') ?>/${islanderId}/update`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                // Request started
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message || "Islander has been successfully updated!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            modal.hide();
                            form.reset();
                            window.location.reload();
                        }
                    });
                } else {
                    let errorMessage = response.message ||
                        'An error occurred while updating the islander.';

                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('<br>');
                    }

                    Swal.fire({
                        html: errorMessage,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred while updating the islander.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            },
            complete: function() {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            }
        });
    };

    // Initialize select2 dropdowns
    var initSelect2 = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            // jQuery not available, skipping Select2 initialization
            return;
        }

        $('#editIslanderModal').on('shown.bs.modal', function() {
            // Initialize Select2 for all select elements in the modal
            $(this).find('select[data-control="select2"]').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2({
                        dropdownParent: $('#editIslanderModal')
                    });
                }
            });
        });

        // Destroy Select2 when modal is hidden
        $('#editIslanderModal').on('hidden.bs.modal', function() {
            $(this).find('select[data-control="select2"]').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });
        });
    };

    // Initialize cascading dropdowns for edit modal
    var initCascadingDropdowns = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            // jQuery not available, skipping cascading dropdown initialization
            return;
        }

        // Division change handler
        $(document).on('change', '#edit_division_id', function() {
            const divisionId = $(this).val();
            const $departmentSelect = $('#edit_department_id');
            const $sectionSelect = $('#edit_section_id');
            const $positionSelect = $('#edit_position_id');

            // Reset dependent dropdowns
            resetDropdown($departmentSelect, 'Select Division First', !divisionId);
            resetDropdown($sectionSelect, 'Select Department First', true);
            resetDropdown($positionSelect, 'Select Section First', true);

            if (divisionId) {
                // Enable and load departments
                loadDepartments(divisionId);
            }
        });

        // Department change handler
        $(document).on('change', '#edit_department_id', function() {
            const departmentId = $(this).val();
            const $sectionSelect = $('#edit_section_id');
            const $positionSelect = $('#edit_position_id');

            // Reset dependent dropdowns
            resetDropdown($sectionSelect, 'Select Department First', !departmentId);
            resetDropdown($positionSelect, 'Select Section First', true);

            if (departmentId) {
                // Enable and load sections
                loadSections(departmentId);
            }
        });

        // Section change handler
        $(document).on('change', '#edit_section_id', function() {
            const sectionId = $(this).val();
            const $positionSelect = $('#edit_position_id');

            // Reset dependent dropdown
            resetDropdown($positionSelect, 'Select Section First', !sectionId);

            if (sectionId) {
                // Enable and load positions
                loadPositions(sectionId);
            }
        });
    };

    // Helper function to reset dropdown
    var resetDropdown = function($select, placeholder, disable = false) {
        if ($select.hasClass('select2-hidden-accessible')) {
            $select.val('').trigger('change');
            $select.empty().append('<option value="">' + placeholder + '</option>');
            $select.prop('disabled', disable);
        } else {
            $select.empty().append('<option value="">' + placeholder + '</option>');
            $select.prop('disabled', disable);
        }
    };

    // Load departments by division
    var loadDepartments = function(divisionId) {
        const $departmentSelect = $('#edit_department_id');

        // Show loading state
        $departmentSelect.empty().append('<option value="">Loading departments...</option>');
        $departmentSelect.prop('disabled', false);

        $.ajax({
            url: '<?= base_url('islanders/departments-by-division') ?>',
            type: 'GET',
            data: {
                division_id: divisionId
            },
            dataType: 'json',
            success: function(departments) {
                $departmentSelect.empty().append('<option value="">Select Department</option>');

                if (departments && departments.length > 0) {
                    $.each(departments, function(index, department) {
                        $departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                } else {
                    $departmentSelect.append('<option value="">No departments available</option>');
                }

                // Trigger change for Select2
                if ($departmentSelect.hasClass('select2-hidden-accessible')) {
                    $departmentSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                $departmentSelect.empty().append('<option value="">Error loading departments</option>');
            }
        });
    };

    // Load sections by department
    var loadSections = function(departmentId) {
        const $sectionSelect = $('#edit_section_id');

        // Show loading state
        $sectionSelect.empty().append('<option value="">Loading sections...</option>');
        $sectionSelect.prop('disabled', false);

        $.ajax({
            url: '<?= base_url('islanders/sections-by-department') ?>',
            type: 'GET',
            data: {
                department_id: departmentId
            },
            dataType: 'json',
            success: function(sections) {
                $sectionSelect.empty().append('<option value="">Select Section</option>');

                if (sections && sections.length > 0) {
                    $.each(sections, function(index, section) {
                        $sectionSelect.append('<option value="' + section.id + '">' + section.name + '</option>');
                    });
                } else {
                    $sectionSelect.append('<option value="">No sections available</option>');
                }

                // Trigger change for Select2
                if ($sectionSelect.hasClass('select2-hidden-accessible')) {
                    $sectionSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                $sectionSelect.empty().append('<option value="">Error loading sections</option>');
            }
        });
    };

    // Load positions by section
    var loadPositions = function(sectionId) {
        const $positionSelect = $('#edit_position_id');

        // Show loading state
        $positionSelect.empty().append('<option value="">Loading positions...</option>');
        $positionSelect.prop('disabled', false);

        $.ajax({
            url: '<?= base_url('islanders/positions-by-section') ?>',
            type: 'GET',
            data: {
                section_id: sectionId
            },
            dataType: 'json',
            success: function(positions) {
                $positionSelect.empty().append('<option value="">Select Position</option>');

                if (positions && positions.length > 0) {
                    $.each(positions, function(index, position) {
                        $positionSelect.append('<option value="' + position.id + '">' + position.name + '</option>');
                    });
                } else {
                    $positionSelect.append('<option value="">No positions available</option>');
                }

                // Trigger change for Select2
                if ($positionSelect.hasClass('select2-hidden-accessible')) {
                    $positionSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                $positionSelect.empty().append('<option value="">Error loading positions</option>');
            }
        });
    };

    // Initialize image inputs
    var initImageInputs = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            // jQuery not available, skipping image input validation
            return;
        }

        // Initialize KTImageInput for image uploads
        if (typeof KTImageInput !== 'undefined') {
            try {
                KTImageInput.createInstances('#editIslanderModal [data-kt-image-input="true"]');
            } catch (e) {
                // KTImageInput not available
            }
        }

        // File validation for image uploads
        $('#editIslanderModal input[name="profile_image"]')
            .on('change', function() {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

                if (file) {
                    // Check file size
                    if (file.size > maxSize) {
                        Swal.fire({
                            text: "File size must be less than 2MB",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        this.value = '';
                        return;
                    }

                    // Check file type
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            text: "Only PNG, JPG, JPEG and GIF files are allowed",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        this.value = '';
                        return;
                    }
                }
            });
    };

    // Populate form with islander data
    var populateForm = function(islander) {
        // Basic field population
        document.getElementById('edit_islander_id').value = islander.id || '';
        document.getElementById('edit_islander_no').value = islander.islander_no || '';
        document.getElementById('edit_id_pp_wp_no').value = islander.id_pp_wp_no || '';
        document.getElementById('edit_full_name').value = islander.full_name || '';
        document.getElementById('edit_email').value = islander.email || '';
        document.getElementById('edit_phone').value = islander.phone || '';
        document.getElementById('edit_address').value = islander.address || '';
        document.getElementById('edit_notes').value = islander.notes || '';

        // Handle password field (leave empty for security - user can change if needed)
        document.getElementById('edit_password').value = '';

        // Handle date fields
        if (islander.date_of_birth) {
            document.getElementById('edit_date_of_birth').value = islander.date_of_birth;
        }
        if (islander.date_of_joining) {
            document.getElementById('edit_join_date').value = islander.date_of_joining;
        }

        // Wait for Select2 to be fully initialized before setting values
        setTimeout(function() {
            // Handle non-cascading selects first
            if (islander.gender_id) {
                $('#edit_gender_id').val(islander.gender_id).trigger('change');
            }
            if (islander.house_id) {
                $('#edit_house_id').val(islander.house_id).trigger('change');
            }
            // Handle nationality with fallback field names
            if (islander.nationality_id) {
                $('#edit_nationality_id').val(islander.nationality_id).trigger('change');
            } else if (islander.nationality) {
                $('#edit_nationality_id').val(islander.nationality).trigger('change');
            }
            if (islander.status_id) {
                $('#edit_status_id').val(islander.status_id).trigger('change');
            }
            if (islander.role_id) {
                $('#edit_role_id').val(islander.role_id).trigger('change');
            }
        }, 200);

        // Handle cascading dropdowns with proper sequencing
        setTimeout(function() {
            // Set division first
            if (islander.division_id) {
                $('#edit_division_id').val(islander.division_id).trigger('change');

                // Wait for departments to load, then set department
                if (islander.department_id) {
                    setTimeout(function() {
                        $('#edit_department_id').val(islander.department_id).trigger('change');

                        // Wait for sections to load, then set section
                        if (islander.section_id) {
                            setTimeout(function() {
                                $('#edit_section_id').val(islander.section_id).trigger('change');

                                // Wait for positions to load, then set position
                                if (islander.position_id) {
                                    setTimeout(function() {
                                        $('#edit_position_id').val(islander.position_id).trigger('change');
                                    }, 300);
                                }
                            }, 300);
                        }
                    }, 300);
                }
            }
        }, 300);

        // Handle existing images
        if (islander.image) {
            // Check if the image path already includes the base path
            let profileImageUrl;
            if (islander.image.startsWith('assets/media/users/') || islander.image.startsWith('uploads/islanders/')) {
                profileImageUrl = '<?= base_url() ?>/' + islander.image;
            } else {
                // Fallback for legacy images
                profileImageUrl = '<?= base_url('assets/media/users/') ?>' + islander.image;
            }
            document.getElementById('edit_profile_image_preview').style.backgroundImage = `url('${profileImageUrl}')`;
        }
    };

    // Public methods
    return {
        init: function() {
            initModal();
            initForm();
            initSelect2();
            initCascadingDropdowns();
            initImageInputs();
        },
        populateForm: function(islander) {
            populateForm(islander);
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        EditIslanderModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            EditIslanderModal.init();
        } else {
            // Initialize anyway
            EditIslanderModal.init();
        }
    });
}
</script>
                <!--begin::Modal - View Islander-->
<div class="modal fade" id="viewIslanderModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="viewIslanderModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Islander Details</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-islanders-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Content-->
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="viewIslanderModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#viewIslanderModal_header" data-kt-scroll-wrappers="#viewIslanderModal_scroll" data-kt-scroll-offset="300px">
                    
                    <!--begin::Islander Header-->
                    <div class="d-flex align-items-center mb-8">
                        <div class="symbol symbol-60px me-5" id="view_profile_image_container">
                            <div class="symbol-label fs-2 fw-semibold bg-light-primary text-primary rounded-circle" id="view_islander_avatar">
                                I
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="text-gray-900 fw-bold mb-1" id="view_islander_name">Islander Name</h3>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light-info fw-bold me-3" id="view_islander_number">ISL-001</span>
                                <span class="badge badge-light-success fw-bold" id="view_islander_status">Active</span>
                            </div>
                        </div>
                    </div>
                    <!--end::Islander Header-->

                    <!--begin::Cover Image Section (if available)-->
                    <div class="row mb-7" id="view_cover_image_section" style="display: none;">
                        <div class="col-12">
                            <label class="fw-semibold text-muted mb-3">Cover Image</label>
                            <div class="d-flex justify-content-center">
                                <div class="image-input image-input-outline" style="background-color: transparent;">
                                    <div class="image-input-wrapper w-200px h-125px" id="view_cover_image_preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Cover Image Section-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_full_name">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Islander Number</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_islander_no">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Email</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_email">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Phone</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_phone">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Division</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_division">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Department</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_department">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Section</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_section">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Position</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_position">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Gender</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_gender">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">House</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_house">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Nationality</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_nationality">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Status</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_status">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Date of Birth</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_date_of_birth">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Join Date</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_join_date">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Address</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_address">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Notes</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_notes">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Separator-->
                    <div class="separator my-10"></div>
                    <!--end::Separator-->

                    <!--begin::Created info-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Created By</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_created_by">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Created At</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_created_at">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Last Updated By</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_updated_by">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Last Updated At</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_updated_at">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                </div>
                <!--end::Content-->
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="button" id="viewIslanderModal_close" class="btn btn-light">Close</button>
                <!--end::Button-->
                <!--begin::Edit Button-->
                <?php if ($permissions['canEdit']): ?>
                <button type="button" id="viewIslanderModal_edit" class="btn btn-primary ms-3">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit Islander
                </button>
                <?php endif; ?>
                <!--end::Edit Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - View Islander-->

<script>
"use strict";

// Class definition
var ViewIslanderModal = function () {
    var modal;
    var closeButton;
    var editButton;

    // Initialize modal
    var initModal = function () {
        modal = new bootstrap.Modal(document.querySelector('#viewIslanderModal'));
    };

    // Initialize buttons
    var initButtons = function () {
        closeButton = document.querySelector('#viewIslanderModal_close');
        editButton = document.querySelector('#viewIslanderModal_edit');

        // Handle close button
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle modal close button
        document.querySelector('#viewIslanderModal [data-kt-islanders-modal-action="close"]').addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle edit button
        if (editButton) {
            editButton.addEventListener('click', function (e) {
                e.preventDefault();
                const islanderId = this.getAttribute('data-islander-id');
                if (islanderId) {
                    modal.hide();
                    // Load and show edit modal
                    loadEditModal(islanderId);
                }
            });
        }
    };

    // Load edit modal
    var loadEditModal = function (islanderId) {
        $.ajax({
            url: `<?= base_url('islanders') ?>/${islanderId}`,
            type: 'GET',
            data: { ajax: 1 },
            success: function (response) {
                if (response.success) {
                    // Populate edit modal and show it
                    if (typeof EditIslanderModal !== 'undefined' && typeof $ !== 'undefined') {
                        EditIslanderModal.populateForm(response.islander);
                        $('#editIslanderModal').modal('show');
                    }
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load islander details');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading islander for edit:', error);
                toastr.error('Failed to load islander details');
            }
        });
    };

    // Populate modal with islander data
    var populateModal = function (islander) {
        // Check if islander data exists
        if (!islander) {
            console.error('Islanders data is undefined or null');
            return;
        }
        
        // Header information
        const avatarElement = document.getElementById('view_islander_avatar');
        const nameElement = document.getElementById('view_islander_name');
        const numberElement = document.getElementById('view_islander_number');
        const statusElement = document.getElementById('view_islander_status');

        if (avatarElement && islander.full_name) {
            avatarElement.textContent = islander.full_name.charAt(0).toUpperCase();
        }
        if (nameElement) {
            nameElement.textContent = islander.full_name || 'N/A';
        }
        if (numberElement) {
            numberElement.textContent = islander.islander_no ? islander.islander_no.toUpperCase() : 'N/A';
        }
        if (statusElement) {
            statusElement.textContent = islander.status_name ? islander.status_name.toUpperCase() : 'N/A';
            // Apply status color if available
            if (islander.status_color) {
                statusElement.style.backgroundColor = islander.status_color + '1a';
                statusElement.style.color = islander.status_color;
                statusElement.className = 'badge fw-bold';
            }
        }

        // Basic information
        document.getElementById('view_full_name').textContent = islander.full_name || '-';
        document.getElementById('view_islander_no').textContent = islander.islander_no || '-';
        document.getElementById('view_email').textContent = islander.email || '-';
        document.getElementById('view_phone').textContent = islander.phone || '-';

        // Organizational information
        document.getElementById('view_division').textContent = islander.division_name || '-';
        document.getElementById('view_department').textContent = islander.department_name || '-';
        document.getElementById('view_section').textContent = islander.section_name || '-';
        document.getElementById('view_position').textContent = islander.position_name || '-';

        // Personal information
        document.getElementById('view_gender').textContent = islander.gender_name || '-';
        document.getElementById('view_nationality').textContent = islander.nationality_name || '-';

        // House information with color
        const houseElement = document.getElementById('view_house');
        if (islander.house_name) {
            houseElement.textContent = islander.house_name;
            if (islander.house_color) {
                houseElement.style.backgroundColor = islander.house_color + '1a';
                houseElement.style.color = islander.house_color;
                houseElement.className = 'badge fw-bold';
                houseElement.style.padding = '4px 8px';
                houseElement.style.fontSize = '11px';
                houseElement.style.lineHeight = '1.2';
            }
        } else {
            houseElement.textContent = '-';
        }

        // Status information
        const statusDetailElement = document.getElementById('view_status');
        if (islander.status_name) {
            statusDetailElement.textContent = islander.status_name;
            if (islander.status_color) {
                statusDetailElement.style.backgroundColor = islander.status_color + '1a';
                statusDetailElement.style.color = islander.status_color;
                statusDetailElement.className = 'badge fw-bold';
                statusDetailElement.style.padding = '4px 8px';
                statusDetailElement.style.fontSize = '11px';
                statusDetailElement.style.lineHeight = '1.2';
            }
        } else {
            statusDetailElement.textContent = '-';
        }

        // Dates
        document.getElementById('view_date_of_birth').textContent = islander.date_of_birth ? 
            new Date(islander.date_of_birth).toLocaleDateString() : '-';
        document.getElementById('view_join_date').textContent = islander.join_date ? 
            new Date(islander.join_date).toLocaleDateString() : '-';

        // Additional information
        document.getElementById('view_address').textContent = islander.address || '-';
        document.getElementById('view_notes').textContent = islander.notes || '-';

        // Audit information
        document.getElementById('view_created_by').textContent = islander.created_by_name || '-';
        document.getElementById('view_created_at').textContent = islander.created_at ? 
            new Date(islander.created_at).toLocaleString() : '-';
        document.getElementById('view_updated_by').textContent = islander.updated_by_name || '-';
        document.getElementById('view_updated_at').textContent = islander.updated_at ? 
            new Date(islander.updated_at).toLocaleString() : '-';

        // Handle profile image
        const profileImageContainer = document.getElementById('view_profile_image_container');
        
        if (islander.image && profileImageContainer) {
            // Check if the image path already includes the base path
            let profileImageUrl;
            if (islander.image.startsWith('assets/media/users/') || islander.image.startsWith('uploads/islanders/')) {
                profileImageUrl = '<?= base_url() ?>/' + islander.image;
            } else {
                // Fallback for legacy images
                profileImageUrl = '<?= base_url('assets/media/users/') ?>' + islander.image;
            }
            // Replace avatar with actual image
            profileImageContainer.innerHTML = `<img src="${profileImageUrl}" alt="Profile Image" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" />`;
        } else if (avatarElement && islander.full_name) {
            // Keep the avatar letter if no image
            avatarElement.textContent = islander.full_name.charAt(0).toUpperCase();
        }

        // Handle cover image
        const coverImageSection = document.getElementById('view_cover_image_section');
        const coverImagePreview = document.getElementById('view_cover_image_preview');
        
        if (islander.cover_image && coverImageSection && coverImagePreview) {
            // Check if the cover image path already includes the base path
            let coverImageUrl;
            if (islander.cover_image.startsWith('assets/media/cover_image/') || islander.cover_image.startsWith('uploads/islanders/')) {
                coverImageUrl = '<?= base_url() ?>/' + islander.cover_image;
            } else {
                // Fallback for legacy images
                coverImageUrl = '<?= base_url('assets/media/cover_image/') ?>' + islander.cover_image;
            }
            coverImagePreview.style.backgroundImage = `url('${coverImageUrl}')`;
            coverImagePreview.style.backgroundSize = 'cover';
            coverImagePreview.style.backgroundPosition = 'center';
            coverImageSection.style.display = 'block';
        } else if (coverImageSection) {
            coverImageSection.style.display = 'none';
        }

        // Set islander ID for edit button
        if (editButton) {
            editButton.setAttribute('data-islander-id', islander.id);
        }
    };

    // Public methods
    return {
        init: function () {
            initModal();
            initButtons();
        },
        populateModal: function (islander) {
            populateModal(islander);
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function () {
        ViewIslanderModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            ViewIslanderModal.init();
        } else {
            console.log('jQuery not available for ViewIslanderModal');
        }
    });
}
</script>

                <div id="kt_app_footer" class="app-footer ">



                    <!--begin::Footer container-->
                    <div
                        class="app-container container-fluid d-flex flex-column flex-md-row flex-center flex-md-stack py-3 d-none d-lg-flex">
                        <!--begin::Copyright-->
                        <div class="text-gray-900 order-2 order-md-1">
                            <span class="text-muted fw-semibold me-1"><?= date('Y') ?>&copy;</span>
                            <span class="me-1">Crafted with ❤️ by</span>
                            <i class="ki-duotone ki-square-brackets fs-3 text-danger me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            <a href="/" target="_blank" class="text-danger text-hover-danger">Short Script</a>
                        </div>
                        <!--end::Copyright-->

                        <!--begin::Menu-->
                        <ul class="menu menu-gray-600 menu-hover-primary fw-semibold order-1">
                            <li class="menu-item"><a class="menu-link px-2">Version: 3.0.1</a></li>

                            <li class="menu-item"><a class="menu-link px-2">Build: 01.04.2025.301</a></li>

                        </ul>
                        <!--end::Menu-->
                    </div>
                    <!--end::Footer container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end:::Main-->


        </div>
        <!--end::Wrapper-->


    </div>
    <!--end::Page-->
    </div>
    <!--end::App-->







    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
    </div>
    <!--end::Scrolltop-->



    <!--begin::Javascript-->
    <script>
    var hostUrl = "/assets/";
    </script>

    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="/assets/plugins/global/plugins.bundle.js"></script>
    <script src="/assets/js/scripts.bundle.js"></script>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->

    <!--begin::AOS Initialization-->
    <script>
    // Initialize AOS (Animate On Scroll) globally
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true,
                mirror: false,
                offset: 50,
                delay: 0
            });
        }
    });
    </script>
    <!--end::AOS Initialization-->

    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>

<script>
"use strict";

// Class definition
var IslandersIndex = function() {
    var table;
    var datatable;
    var islanderList = <?= json_encode($islanders ?? []) ?>;
    var currentPage = <?= $currentPage ?? 1 ?>;
    var totalPages = <?= $totalPages ?? 1 ?>;
    var search = '<?= esc($search) ?>';
    var currentFilter = '';
    var isLoading = false;
    var isMobile = window.innerWidth <= 768;

    // Initialize components
    var initTable = function() {
        // Check if we're on mobile or desktop
        if (isMobile) {
            initMobileView();
        } else {
            initDesktopTable();
        }
    };

    // Desktop table initialization
    var initDesktopTable = function() {
        table = document.querySelector('#kt_islander_table');
        if (!table) return;

        // Check if table has data before initializing DataTables
        const tbody = table.querySelector('tbody');
        const rows = tbody ? tbody.querySelectorAll('tr') : [];

        // Only initialize DataTables if there are data rows (not just "no results" row)
        if (rows.length > 0) {
            const firstRow = rows[0];
            const cells = firstRow.querySelectorAll('td');

            // Only initialize if the first row has actual data (not the "no results" message)
            if (cells.length > 1 && typeof $ !== 'undefined') {
                // Initialize datatable
                datatable = $(table).DataTable({
                    "searching": false,
                    "ordering": true,
                    "paging": false,
                    "info": false,
                    "columnDefs": [{
                            "orderable": false,
                            "targets": [0, -1]
                        }, // Disable ordering on checkbox and actions columns
                    ]
                });
            }
        }
    };

    // Mobile view initialization
    var initMobileView = function() {
        initInfiniteScroll();
        initMobileSearch();
    };

    // Initialize infinite scroll for mobile
    var initInfiniteScroll = function() {
        const container = document.getElementById('mobile-cards-container');
        if (!container) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading && currentPage < totalPages) {
                    loadMoreIslanders();
                }
            });
        });

        // Create sentinel element for infinite scroll
        const sentinel = document.createElement('div');
        sentinel.id = 'scroll-sentinel';
        sentinel.style.height = '10px';
        container.appendChild(sentinel);
        observer.observe(sentinel);
    };

    // Initialize mobile search
    var initMobileSearch = function() {
        const mobileSearchInput = document.getElementById('mobile_search');
        if (!mobileSearchInput) return;

        let searchTimeout;
        mobileSearchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleSearch(this.value);
            }, 500);
        });
    };

    // Load more islanders (for infinite scroll)
    var loadMoreIslanders = function() {
        if (isLoading || currentPage >= totalPages || typeof $ === 'undefined') return;

        isLoading = true;
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }

        // Make AJAX request
        $.ajax({
            url: '<?= base_url('islanders') ?>',
            type: 'GET',
            data: {
                page: currentPage + 1,
                search: search,
                ajax: 1
            },
            success: function(response) {
                if (response.islanders && response.islanders.length > 0) {
                    appendIslanders(response.islanders);
                    currentPage = response.currentPage;
                    totalPages = response.totalPages;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading more islanders:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load more islanders');
                }
            },
            complete: function() {
                isLoading = false;
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
            }
        });
    };

    // Append islanders to mobile list
    var appendIslanders = function(islanders) {
        const container = document.getElementById('mobile-cards-container');
        const sentinel = document.getElementById('scroll-sentinel');

        islanders.forEach(islander => {
            const card = createIslanderCard(islander);
            container.insertBefore(card, sentinel);
        });

        // Refresh AOS animations
        if (typeof AOS !== 'undefined') {
            AOS.refresh();
        }
    };

    // Create islander card for mobile view
    var createIslanderCard = function(islander) {
        const card = document.createElement('div');
        card.className = 'col-12';
        card.setAttribute('data-aos', 'fade-up');
        card.setAttribute('data-aos-delay', '100');

        // Determine house color styling
        let houseBadge = '';
        if (islander.house_name) {
            if (islander.house_color) {
                houseBadge =
                    `<span class="badge fw-bold" style="background-color: ${islander.house_color}1a; color: ${islander.house_color}; padding: 4px 8px; font-size: 11px; line-height: 1.2;">${islander.house_name.toUpperCase()}</span>`;
            } else {
                houseBadge =
                    `<span class="badge badge-light-secondary fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">${islander.house_name.toUpperCase()}</span>`;
            }
        } else {
            houseBadge = '<span class="text-muted">-</span>';
        }

        // Determine status color styling
        let statusBadge = '';
        if (islander.status_name) {
            if (islander.status_color) {
                // Convert hex to light background
                const hex = islander.status_color.replace('#', '');
                const r = parseInt(hex.substr(0, 2), 16);
                const g = parseInt(hex.substr(2, 2), 16);
                const b = parseInt(hex.substr(4, 2), 16);
                const lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;
                statusBadge =
                    `<span class="badge fw-bold" style="background-color: ${lightBg}; color: ${islander.status_color}; padding: 4px 8px; font-size: 11px; line-height: 1.2;">${islander.status_name.toUpperCase()}</span>`;
            } else {
                statusBadge =
                    `<span class="badge badge-light-success fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">${islander.status_name.toUpperCase()}</span>`;
            }
        } else {
            statusBadge =
                '<span class="badge badge-light-secondary fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">N/A</span>';
        }

        // Determine image URL (match desktop logic)
        let imageUrl = '';
        if (islander.image) {
            imageUrl = `${window.location.origin}/assets/media/users/${islander.image}`;
        } else {
            imageUrl =
                `https://ui-avatars.com/api/?name=${encodeURIComponent(islander.full_name || '')}&background=f4f4f4&color=9ba1b6&font-size=0.5`;
        }

        card.innerHTML = `
            <div class="card card-flush h-xl-100 mobile-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.3); transition: all 0.3s ease;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-35px me-3">
                                <img src="${imageUrl}" alt="${islander.full_name || 'Avatar'}" class="rounded-circle" style="width: 35px; height: 35px; object-fit: cover; background: #f4f4f4;" />
                            </div>
                            <div>
                                <h6 class="mb-0 text-white fw-bold">${islander.full_name || 'N/A'}</h6>
                                <small class="text-white-75">${islander.position_name || 'No Position'}</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <span class="badge badge-light-info fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                ${islander.islander_no ? islander.islander_no.toUpperCase() : 'N/A'}
                            </span>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <small class="text-white-75 mb-1">Division</small>
                                <span class="text-white fw-semibold">${islander.division_name || '-'}</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <small class="text-white-75 mb-1">House</small>
                                ${houseBadge}
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <small class="text-white-75 mb-1">Status</small>
                                ${statusBadge}
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="d-flex flex-column">
                                <small class="text-white-75 mb-1">ID</small>
                                <span class="text-white fw-semibold">#${islander.id}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Expandable Actions -->
                    <div class="actions-container">
                        <button class="btn btn-sm btn-light-primary w-100 toggle-actions" type="button" data-islander-id="${islander.id}">
                            <i class="fas fa-chevron-down me-2"></i>Actions
                        </button>
                        <div class="actions-content mt-2" style="display: none;">
                            <div class="d-flex gap-2">
                                <?php if ($permissions['canView']): ?>
                                <button class="btn btn-sm btn-light flex-fill view-islander-btn" data-islander-id="${islander.id}">
                                    <i class="fas fa-eye me-1"></i>View
                                </button>
                                <?php endif; ?>
                                <?php if ($permissions['canEdit']): ?>
                                <button class="btn btn-sm btn-light flex-fill edit-islander-btn" data-islander-id="${islander.id}">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </button>
                                <?php endif; ?>
                                <?php if ($permissions['canEdit']): ?>
                                <button class="btn btn-sm btn-light-info flex-fill reset-password-btn" data-islander-id="${islander.id}" title="Reset Password to 1234">
                                    <i class="fas fa-key me-1"></i>Reset
                                </button>
                                <?php endif; ?>
                                <?php if ($permissions['canDelete']): ?>
                                <button class="btn btn-sm btn-light-danger flex-fill delete-islander-btn" data-islander-id="${islander.id}">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        return card;
    };

    // Handle search
    var handleSearch = function(searchTerm) {
        search = searchTerm;

        // For both mobile and desktop, redirect with search parameter
        window.location.href = `<?= base_url('islanders') ?>?search=${encodeURIComponent(searchTerm)}`;
    };

    // Reload mobile list
    var reloadMobileList = function() {
        const container = document.getElementById('mobile-cards-container');
        if (!container) return;

        // Clear current list except sentinel
        const cards = container.querySelectorAll('.col-12:not(#scroll-sentinel)');
        cards.forEach(card => card.remove());

        // Reset pagination
        currentPage = 1;
        isLoading = false;

        // Load first page
        loadMoreIslanders();
    };

    // Initialize pagination for table
    var initTablePagination = function() {
        const paginationLinks = document.querySelectorAll('.page-link[data-page]');

        paginationLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();

                const page = parseInt(this.getAttribute('data-page'));
                if (page && page !== currentPage && !isLoading) {
                    loadTablePage(page);
                }
            });
        });
    };

    // Load specific page for table
    var loadTablePage = function(page) {
        if (isLoading) return;

        isLoading = true;
        const tableBody = document.querySelector('#kt_islander_table tbody');
        const loadingRow =
            '<tr><td colspan="8" class="text-center py-4"><div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div></td></tr>';

        if (tableBody) {
            tableBody.innerHTML = loadingRow;
        }

        // Make AJAX request
        $.ajax({
            url: '<?= base_url('islanders') ?>',
            type: 'GET',
            data: {
                page: page,
                search: search,
                limit: <?= $limit ?>,
                ajax: 1
            },
            success: function(response) {
                if (response.success && response.islanders) {
                    currentPage = response.currentPage;
                    totalPages = response.totalPages;

                    // Reload the entire page to update table and pagination
                    const searchParam = search ? '&search=' + encodeURIComponent(search) : '';
                    const limitParam = '&limit=' + <?= $limit ?>;
                    window.location.href = '<?= base_url('islanders') ?>?page=' + page +
                        searchParam + limitParam;
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Failed to load page');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading page:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load page');
                }
            },
            complete: function() {
                isLoading = false;
            }
        });
    };

    // Change table limit (records per page)
    window.changeTableLimit = function(newLimit) {
        if (isLoading) return;

        const searchParam = search ? '&search=' + encodeURIComponent(search) : '';
        window.location.href = '<?= base_url('islanders') ?>?page=1&limit=' + newLimit + searchParam;
    };

    // Initialize search functionality
    var initSearch = function() {
        const searchInput = document.querySelector('#kt_filter_search');
        if (!searchInput) return;

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleSearch(this.value);
            }, 500);
        });
    };

    // Initialize action buttons
    var initActionButtons = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping action buttons initialization');
            return;
        }

        // Mobile action toggles
        $(document).on('click', '.toggle-actions', function() {
            const actionsContent = $(this).siblings('.actions-content');
            const icon = $(this).find('i');

            if (actionsContent.is(':visible')) {
                actionsContent.slideUp(200);
                icon.removeClass('fa-chevron-up').addClass('fa-chevron-down');
            } else {
                actionsContent.slideDown(200);
                icon.removeClass('fa-chevron-down').addClass('fa-chevron-up');
            }
        });

        // View islander
        $(document).on('click', '.view-islander-btn', function() {
            const islanderId = $(this).data('islander-id');
            loadIslanderModal('view', islanderId);
        });

        // Edit islander
        $(document).on('click', '.edit-islander-btn', function() {
            const islanderId = $(this).data('islander-id');
            loadIslanderModal('edit', islanderId);
        });

        // Delete islander
        $(document).on('click', '.delete-islander-btn', function() {
            const islanderId = $(this).data('islander-id');
            deleteIslander(islanderId);
        });

        // Reset islander password
        $(document).on('click', '.reset-password-btn', function() {
            const islanderId = $(this).data('islander-id');
            resetIslanderPassword(islanderId);
        });
    };

    // Load islander modal
    var loadIslanderModal = function(action, islanderId) {
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, cannot load modal');
            return;
        }

        const modalId = action === 'view' ? '#viewIslanderModal' : '#editIslanderModal';

        $.ajax({
            url: `<?= base_url('islanders') ?>/${islanderId}`,
            type: 'GET',
            data: {
                ajax: 1
            },
            success: function(response) {
                if (response.success && response.islander) {
                    populateModal(action, response.islander);
                    $(modalId).modal('show');
                } else {
                    console.error('Invalid response or missing islander data:', response);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load islander details');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading islander:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load islander details');
                }
            }
        });
    };

    // Populate modal with islander data
    var populateModal = function(action, islander) {
        // Check if islander data exists
        if (!islander) {
            console.error('Islander data is undefined or null');
            return;
        }

        if (action === 'view' && typeof ViewIslanderModal !== 'undefined') {
            ViewIslanderModal.populateModal(islander);
        } else if (action === 'edit' && typeof EditIslanderModal !== 'undefined') {
            EditIslanderModal.populateForm(islander);
        }
    };

    // Delete islander
    var deleteIslander = function(islanderId) {
        if (typeof Swal === 'undefined' || typeof $ === 'undefined') {
            console.log('SweetAlert or jQuery not available, cannot delete');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('islanders') ?>/${islanderId}`,
                    type: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message ||
                                    'Islander deleted successfully');
                            }
                            // Reload page or remove item from list
                            window.location.reload();
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message ||
                                    'Failed to delete islander');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting islander:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to delete islander');
                        }
                    }
                });
            }
        });
    };

    // Reset islander password to 1234
    var resetIslanderPassword = function(islanderId) {
        if (typeof Swal === 'undefined' || typeof $ === 'undefined') {
            console.log('SweetAlert or jQuery not available, cannot reset password');
            return;
        }

        Swal.fire({
            title: 'Reset Password?',
            text: "This will reset the islander's password to '1234'",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('islanders') ?>/${islanderId}/reset-password`,
                    type: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/json'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message ||
                                    'Password reset successfully to 1234');
                            }
                            Swal.fire({
                                title: 'Password Reset!',
                                text: 'The password has been reset to "1234"',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message ||
                                    'Failed to reset password');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error resetting password:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to reset password');
                        }
                    }
                });
            }
        });
    };

    // Handle window resize with passive listener
    var handleResize = function() {
        window.addEventListener('resize', function() {
            const wasMobile = isMobile;
            isMobile = window.innerWidth <= 768;

            if (wasMobile !== isMobile) {
                // Screen size changed between mobile and desktop
                window.location.reload();
            }
        }, {
            passive: true
        });
    };

    // Public methods
    return {
        init: function() {
            initTable();
            initTablePagination();
            initSearch();
            initActionButtons();
            handleResize();
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        IslandersIndex.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            IslandersIndex.init();
        } else {
            console.log('jQuery not available for IslandersIndex');
        }
    });
}

// Toggle mobile action buttons
function toggleMobileActions(cardElement) {
    const actionsDiv = cardElement.querySelector('.mobile-actions');
    const allCards = document.querySelectorAll('.mobile-islander-card');

    // Close all other expanded cards
    allCards.forEach(card => {
        if (card !== cardElement) {
            const otherActions = card.querySelector('.mobile-actions');
            if (otherActions && !otherActions.classList.contains('d-none')) {
                otherActions.classList.add('d-none');
                otherActions.classList.remove('show');
                card.classList.remove('expanded');
            }
        }
    });

    // Toggle current card
    if (actionsDiv.classList.contains('d-none')) {
        actionsDiv.classList.remove('d-none');
        actionsDiv.classList.add('show');
        cardElement.classList.add('expanded');
    } else {
        actionsDiv.classList.add('d-none');
        actionsDiv.classList.remove('show');
        cardElement.classList.remove('expanded');
    }
}

// Close action buttons when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.mobile-islander-card')) {
        const allCards = document.querySelectorAll('.mobile-islander-card');
        allCards.forEach(card => {
            const actionsDiv = card.querySelector('.mobile-actions');
            if (actionsDiv && !actionsDiv.classList.contains('d-none')) {
                actionsDiv.classList.add('d-none');
                actionsDiv.classList.remove('show');
                card.classList.remove('expanded');
            }
        });
    }
});

// Initialize AOS (Animate On Scroll) if available
document.addEventListener('DOMContentLoaded', function() {
    // Check if AOS is available and initialize it
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: true, // Animation happens only once
            offset: 50 // Trigger animation 50px before element comes into view
        });
        console.log('AOS initialized successfully');
    } else {
        console.log('AOS library not found, animations disabled');
        // Remove any AOS attributes if library is not available
        const elementsWithAOS = document.querySelectorAll('[data-aos]');
        elementsWithAOS.forEach(element => {
            element.removeAttribute('data-aos');
            element.removeAttribute('data-aos-delay');
            element.removeAttribute('data-aos-duration');
        });
    }
});

// Passive event listener optimization
(function() {
    'use strict';

    // Override addEventListener to use passive listeners for scroll-blocking events
    const supportsPassive = (() => {
        let supports = false;
        try {
            window.addEventListener('test', null, {
                get passive() {
                    supports = true;
                    return false;
                }
            });
        } catch (e) {}
        return supports;
    })();

    if (supportsPassive) {
        // List of events that should use passive listeners by default
        const passiveEvents = ['touchstart', 'touchmove', 'wheel', 'mousewheel'];

        const originalAddEventListener = EventTarget.prototype.addEventListener;
        EventTarget.prototype.addEventListener = function(type, listener, options) {
            if (passiveEvents.includes(type) && typeof options !== 'object') {
                options = {
                    passive: true
                };
            } else if (passiveEvents.includes(type) && typeof options === 'object' && options.passive ===
                undefined) {
                options.passive = true;
            }
            return originalAddEventListener.call(this, type, listener, options);
        };
    }
})();
</script>