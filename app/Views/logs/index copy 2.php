<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Islanders App" />
    <meta name="keywords" content="Islanders, Islanders App" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
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
    <!--end::Vendor Stylesheets-->


    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!--begin::iOS Safe Area CSS for Capacitor-->
    <style>
    /* iOS safe area handling for Capacitor apps */

    /* Base styles */
    body {
        padding-top: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    /* Create a pseudo-element to fill the safe area with header background */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        height: env(safe-area-inset-top, 0px);
        background-color: var(--bs-app-header-bg, #ffffff);
        z-index: 999;
        display: block;
    }

    /* Fallback for older browsers */
    @supports (padding-top: constant(safe-area-inset-top)) {
        body::before {
            height: constant(safe-area-inset-top, 0px);
        }
    }

    /* Default header positioning for all devices */
    #kt_app_header {
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        z-index: 1000 !important;
        margin-top: 0 !important;
    }

    /* Default wrapper padding */
    #kt_app_wrapper {
        padding-top: 70px !important;
        margin-top: 0 !important;
    }

    /* Reduce space in other elements */
    #kt_app_toolbar {
        margin-top: 0 !important;
    }

    /* Mobile specific toolbar adjustments */
    @media screen and (max-width: 768px) {
        #kt_app_toolbar {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }

        /* Hide breadcrumb on mobile */
        .breadcrumb {
            display: none !important;
        }

        /* Add mt-8 to page heading on mobile */
        .page-heading {
            margin-top: 2rem !important;
            /* mt-8 = 2rem */
        }
    }

    /* Safe area support for newer browsers */
    @supports (padding-top: env(safe-area-inset-top)) {
        #kt_app_header {
            top: env(safe-area-inset-top) !important;
        }

        #kt_app_wrapper {
            padding-top: calc(70px + env(safe-area-inset-top)) !important;
        }
    }

    /* Fallback for older browsers */
    @supports (padding-top: constant(safe-area-inset-top)) {
        #kt_app_header {
            top: constant(safe-area-inset-top) !important;
        }

        #kt_app_wrapper {
            padding-top: calc(70px + constant(safe-area-inset-top)) !important;
        }
    }

    /* Ensure proper height calculation */
    .app-page {
        min-height: 100vh;
        padding-top: 0 !important;
    }

    /* Mobile specific adjustments */
    @media screen and (max-width: 768px) {
        body {
            -webkit-overflow-scrolling: touch;
        }

        .app-header {
            position: fixed !important;
            z-index: 1000 !important;
            width: 100% !important;
            left: 0 !important;
            right: 0 !important;
        }

        /* Make sidebar appear above header on mobile with proper clickability */
        .app-sidebar {
            z-index: 1002 !important;
            pointer-events: auto !important;
        }

        /* Ensure sidebar content is clickable */
        .app-sidebar * {
            pointer-events: auto !important;
        }

        /* Sidebar overlay with lower z-index but still above header */
        .drawer-overlay {
            z-index: 1001 !important;
            pointer-events: auto !important;
        }

        /* Ensure menu items are clickable */
        .menu-item,
        .menu-link {
            pointer-events: auto !important;
            position: relative !important;
            z-index: 1003 !important;
        }

        .app-wrapper {
            margin-top: 0 !important;
        }

        .app-toolbar {
            padding-top: 0 !important;
            margin-top: 0 !important;
        }
    }

    /* Additional iOS Safari specific fix */
    @media screen and (-webkit-min-device-pixel-ratio: 2) {
        body {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
        }
    }

    /* Force styles for Capacitor environment */
    .capacitor-app #kt_app_header {
        top: var(--ion-safe-area-top, 44px) !important;
    }

    .capacitor-app #kt_app_wrapper {
        padding-top: calc(70px + var(--ion-safe-area-top, 44px)) !important;
    }

    /* Ensure the safe area background matches the header */
    .capacitor-app body::before {
        height: var(--ion-safe-area-top, 44px);
    }

    /* Hide logo on desktop, show on mobile */
    @media (min-width: 992px) {
        .app-sidebar-logo-new {
            display: none !important;
        }
    }
    </style>
    <!--end::iOS Safe Area CSS for Capacitor-->



</head>
<!--end::Head-->


<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true"
    data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true"
    data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true"
    class="app-default">
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

    // iOS Safe Area handling for Capacitor
    function handleSafeArea() {
        const header = document.getElementById('kt_app_header');
        const wrapper = document.getElementById('kt_app_wrapper');

        if (header && wrapper) {
            // Try to get safe area inset from CSS
            const testDiv = document.createElement('div');
            testDiv.style.position = 'fixed';
            testDiv.style.top = '0';
            testDiv.style.left = '0';
            testDiv.style.visibility = 'hidden';
            testDiv.style.paddingTop = 'env(safe-area-inset-top)';
            document.body.appendChild(testDiv);

            const computedPadding = window.getComputedStyle(testDiv).paddingTop;
            const safeAreaTop = parseFloat(computedPadding) || 0;

            document.body.removeChild(testDiv);

            // If we didn't get a safe area value, try alternative methods
            let finalSafeAreaTop = safeAreaTop;

            // Check if we're in a Capacitor app or iOS device
            if (safeAreaTop === 0 && (window.Capacitor || /iPad|iPhone|iPod/.test(navigator.userAgent))) {
                // Default iOS status bar height
                finalSafeAreaTop = window.screen.height >= 812 ? 44 : 20; // iPhone X and newer vs older
            }

            // Apply the safe area positioning
            if (finalSafeAreaTop > 0) {
                header.style.top = finalSafeAreaTop + 'px';
                wrapper.style.paddingTop = (70 + finalSafeAreaTop) + 'px';

                // Get the header's background color and apply it to the safe area
                const headerStyles = window.getComputedStyle(header);
                const headerBgColor = headerStyles.backgroundColor || '#ffffff';

                // Create or update the safe area background element
                let safeAreaBg = document.getElementById('safe-area-bg');
                if (!safeAreaBg) {
                    safeAreaBg = document.createElement('div');
                    safeAreaBg.id = 'safe-area-bg';
                    document.body.appendChild(safeAreaBg);
                }

                // Style the safe area background
                safeAreaBg.style.position = 'fixed';
                safeAreaBg.style.top = '0';
                safeAreaBg.style.left = '0';
                safeAreaBg.style.right = '0';
                safeAreaBg.style.height = finalSafeAreaTop + 'px';
                safeAreaBg.style.backgroundColor = headerBgColor;
                safeAreaBg.style.zIndex = '999';
                safeAreaBg.style.pointerEvents = 'none';

                // Add class to body to indicate safe area is applied
                document.body.classList.add('safe-area-applied');
            }
        }
    }

    // Run safe area handling when DOM is loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', handleSafeArea);
    } else {
        handleSafeArea();
    }

    // Also run when window loads (in case elements aren't ready)
    window.addEventListener('load', handleSafeArea);
    </script>
    <!--end::Theme mode setup on page load-->


    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page  flex-column flex-column-fluid " id="kt_app_page">




            <!--begin::Header-->
            <div id="kt_app_header" class="app-header  d-flex flex-column flex-stack ">

                <!--begin::Header main-->
                <div class="d-flex align-items-center flex-stack flex-grow-1">

                    <div class="app-header-logo d-flex align-items-center flex-stack px-lg-10 mb-2"
                        id="kt_app_header_logo">
                        <!--begin::Sidebar mobile toggle-->
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none"
                            id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2qx"><span class="path1"></span><span
                                    class="path2"></span></i>
                        </div>
                        <!--end::Sidebar mobile toggle-->

                        <!--begin::Logo-->
                        <a href="/" class="app-sidebar-logo">
                            <img alt="Logo" src="/assets/media/logos/default.png"
                                class="h-30px h-lg-40px  theme-light-show" />
                            <img alt="Logo" src="/assets/media/logos/default-dark.svg"
                                class="h-30px h-lg-40px  theme-dark-show" />
                        </a>
                        <!--end::Logo-->
                    </div>

                    <!--begin::Navbar-->
                    <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">




                        <!--begin::User menu-->
                        <div class="app-navbar-item ms-3 ms-lg-4 me-lg-6 me-4" id="kt_header_user_menu_toggle">
                            <!--begin::Menu wrapper-->
                            <div class="cursor-pointer symbol symbol-30px symbol-lg-40px"
                                data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                                data-kt-menu-placement="bottom-end">
                                <!-- <img src="/assets/media/avatars/300-2.jpg" alt="user" /> -->
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
                                            <!-- <img alt="Logo" src="/assets/media/avatars/300-2.jpg" /> -->
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
                                    <a href="/saul-html-pro/account/overview.html" class="menu-link px-5">
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
                                                            class="path3"></span><span class="path4"></span></i> </span>
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
                                <!-- <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
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

                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <div class="menu-item px-3">
                                            <a href="/saul-html-pro/account/settings.html"
                                                class="menu-link d-flex px-5 active">
                                                <span class="symbol symbol-20px me-4">
                                                    <img class="rounded-1" src="/assets/media/flags/united-states.svg"
                                                        alt="" />
                                                </span>
                                                English
                                            </a>
                                        </div>
                                    </div>
                                </div> -->
                                <!--end::Menu item-->


                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="/saul-html-pro/authentication/layouts/corporate/sign-in.html"
                                        class="menu-link px-5">
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
                <!--end::Header main-->

                <!--begin::Separator-->
                <div class="app-header-separator"></div>
                <!--end::Separator-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">






                <!--begin::Sidebar-->
                <div id="kt_app_sidebar" class="app-sidebar  flex-column " data-kt-drawer="true"
                    data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}"
                    data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start"
                    data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">

                    <!--begin::Main-->
                    <div class="d-flex flex-column justify-content-between h-100 hover-scroll-overlay-y my-2 mx-5 d-flex flex-column"
                        id="kt_app_sidebar_main" data-kt-scroll="true" data-kt-scroll-activate="true"
                        data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header"
                        data-kt-scroll-wrappers="#kt_app_main" data-kt-scroll-offset="5px">
                        <!--begin::Sidebar menu-->
                        <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false"
                            class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7 mt-15works per mt-lg-2 mt-md-2">

                            <!--begin::Logo-->
                            <a href="/" class="app-sidebar-logo-new mt-4 mb-4">
                                <img alt="Logo" src="/assets/media/logos/default.png"
                                    class="h-40px h-lg-40px  theme-light-show" />
                                <img alt="Logo" src="/assets/media/logos/default-dark.svg"
                                    class="h-40px h-lg-40px  theme-dark-show" />
                            </a>
                            <!--end::Logo-->

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
                            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <a href="/" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <a href="/feed" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                                        <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>"
                                            href="/requests/add_request" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right"
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
                                        <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>"
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
                                        <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>"
                                            href="/authorizations" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-dismiss="click" data-bs-placement="right"
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
                            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <a href="/users" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <a href="/events" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                            <div data-kt-menu-trigger="click" class="menu-item <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <a href="/policies" class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                                        <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>" href="/tickets"
                                            data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                            data-bs-placement="right"
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
                                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                                        <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>"
                                            href="/todays_departure" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-dismiss="click" data-bs-placement="right"
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
                                        <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>"
                                            href="/todays_arrival" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-dismiss="click" data-bs-placement="right"
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
                                        <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>"
                                            href="/exit_request" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-dismiss="click" data-bs-placement="right"
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
                            
                            $isActive = isMenuActive(['/modules', '/status', '/logs', '/flight-routes', '/leave', '/divisions', '/departments', '/sections', '/positions', '/genders', '/nationalities', '/houses', '/policy', '/islanders', '/visitors', '/sessions', '/requesting-rules', '/authorization-rules', '/roles', '/group-permissions', '/user-permissions']) && $hasAnySettingsAccess;
                            ?>
                            <?php if ($hasAnySettingsAccess): ?>
                            <div data-kt-menu-trigger="click"
                                class="menu-item menu-accordion <?= $isActive ? 'here show' : '' ?>">
                                <!--begin:Menu link-->
                                <span class="menu-link <?= $isActive ? 'active bg-white' : '' ?>"
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
                                        <span class="menu-link <?= $userMgmtActive ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive4 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive5 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive6 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive7 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive8 ? 'active bg-white' : '' ?>"
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
                                        <span class="menu-link <?= $islanderActive ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive3 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive4 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive5 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive6 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive7 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive8 ? 'active bg-white' : '' ?>"
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
                            $islanderActive = isMenuActive(['/leave', '/flight-routes']) && $hasIslanderAccess;
                            ?>
                                    <?php if ($hasIslanderAccess): ?>
                                    <div data-kt-menu-trigger="click"
                                        class="menu-item menu-accordion <?= $islanderActive ? 'here show' : '' ?>">
                                        <!--begin:Menu link-->
                                        <span class="menu-link <?= $islanderActive ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>"
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
                                            <!--begin:Menu item-->
                                            <?php if (has_permission('flight-routes.view') || $hasIslanderAccess): ?>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <?php $subActive2 = isMenuActive(['/flight-routes']); ?>
                                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>"
                                                    href="/flight-routes"
                                                    <?= $subActive2 ? 'style="border-radius: 0.5rem;"' : '' ?>>
                                                    <span class="menu-bullet">
                                                        <span class="bullet bullet-dot"></span>
                                                    </span>
                                                    <span class="menu-title">Flight Routes</span>
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
                                        <span class="menu-link <?= $systemActive ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive1 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive2 ? 'active bg-white' : '' ?>"
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
                                                <a class="menu-link <?= $subActive4 ? 'active bg-white' : '' ?>"
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
                        <!--begin::Footer-->
                        <div class="app-sidebar-project-default app-sidebar-project-minimize text-center min-h-lg-400px flex-column-auto d-flex flex-column justify-content-end"
                            id="kt_app_sidebar_footer">
                            <!--begin::Title-->
                            <h2 class="fw-bold text-gray-800">Welcome to Saul</h2>
                            <!--end::Title-->

                            <!--begin::Description-->
                            <div class="fw-semibold text-gray-700 fs-7 lh-2 px-7 mb-1">Join the movement make a
                                difference.</div>
                            <!--end::Description-->

                            <!--begin::Illustration-->
                            <img class="mx-auto h-150px h-lg-175px mb-4" src="/assets/media/misc/saul-welcome.png"
                                alt="" />
                            <!--end::Illustration-->

                            <div class="text-center mb-lg-5 pb-lg-3">
                                <a href="#" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                                    data-bs-target="#kt_modal_create_account">Get Started</a>
                            </div>
                        </div>
                        <!--end::Footer-->
                    </div>
                    <!--end::Main-->
                </div>
                <!--end::Sidebar-->


                <!--begin::Format action text to make labels bold-->
                <?php
                    /**
                     * Format action text to make labels bold
                     */
                    function formatActionText($actionText) {
                        if (empty($actionText)) {
                            return $actionText;
                        }
                        
                        // Pattern to match labels followed by colon - expanded to include all Islander fields
                        $pattern = '/^(#:|Module:|Name:|Description:|Islander No:|Username:|Email:|Phone:|Position:|Section:|Department:|Division:|Status:|Gender:|Nationality:|Date of Birth:|Date of Joining:|Company:|House:|ID\/PP\/WP No:|Address:|Notes:)(.*)$/m';
                        
                        $formatted = preg_replace_callback($pattern, function($matches) {
                            $label = trim($matches[1]);
                            $value = trim($matches[2]);
                            
                            if (($label === 'Description:' || $label === 'Notes:' || $label === 'Address:') && empty($value)) {
                                // For description/notes/address, show the label in bold and prepare for next line content
                                return '<strong>' . esc($label) . '</strong>';
                            } else {
                                // For other labels with values on the same line
                                return '<strong>' . esc($label) . '</strong> ' . esc($value);
                            }
                        }, $actionText);
                        
                        return $formatted;
                    }
                ?>

                <style>
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
                .mobile-log-card {
                    transition: all 0.3s ease;
                    cursor: pointer;
                }

                .mobile-log-card:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                }

                .mobile-log-card:active {
                    transform: translateY(0);
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

                /* Log status colors */
                .log-status-badge {
                    padding: 4px 8px;
                    font-size: 11px;
                    line-height: 1.2;
                    border-radius: 4px;
                }

                /* Multi-line action display */
                .log-action-text {
                    white-space: pre-line;
                    line-height: 1.4;
                    max-width: 300px;
                    word-wrap: break-word;
                    font-size: 0.9rem;
                    font-weight: normal;
                }

                .log-action-text-mobile {
                    white-space: pre-line;
                    line-height: 1.4;
                    word-wrap: break-word;
                    font-size: 0.95rem;
                    font-weight: normal;
                }

                /* Style for bold labels in action text */
                .log-action-formatted {
                    white-space: pre-line;
                    line-height: 1.4;
                    max-width: 300px;
                    word-wrap: break-word;
                    font-size: 1rem;
                    font-weight: normal;
                }

                .log-action-formatted-mobile {
                    white-space: pre-line;
                    line-height: 1.4;
                    word-wrap: break-word;
                    font-size: 0.95rem;
                    font-weight: normal;
                }

                /* Highlight structured log parts */
                .log-action-text .log-line:first-line {
                    font-weight: 600;
                    color: #1f2129;
                }
                </style>

                <!--begin::Mobile UI (visible on mobile only)-->
                <div class="d-lg-none">
                    <!-- Fixed Search Bar -->
                    <div class="top-0 py-3 mb-2">
                        <div class="container-fluid">
                            <div class="mb-2">
                                <h1 class="text-dark fw-bold ms-2">System Logs</h1>
                            </div>
                            <div class="row align-items-stretch">
                                <div class="col-8">
                                    <div class="position-relative h-100">
                                        <i
                                            class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" id="mobile_search"
                                            class="form-control form-control-solid ps-10 h-100"
                                            placeholder="Search logs..." value="<?= esc($search) ?>" />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <button type="button" id="mobile_export_btn"
                                        class="btn btn-success w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="min-height: 48px;">
                                        <i class="ki-duotone ki-document fs-3x">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                                <div class="col-2">
                                    <button type="button" id="mobile_clear_btn"
                                        class="btn btn-danger w-100 h-100 d-flex align-items-center justify-content-center"
                                        style="min-height: 48px;">
                                        <i class="ki-duotone ki-trash fs-3x">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                    </button>
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
                            <?php if (!empty($logs)): ?>
                            <?php foreach ($logs as $index => $log): ?>
                            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>"
                                data-aos-duration="600">
                                <div class="card mobile-log-card" data-log-id="<?= esc($log['id']) ?>">
                                    <div class="card-body p-4">
                                        <!-- Log Header -->
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <div class="flex-grow-1">
                                                <small class="text-muted text-uppercase">#<?= esc($log['id']) ?></small>
                                                <div class="text-gray-800 log-action-formatted-mobile">
                                                    <?= formatActionText($log['action']) ?></div>
                                            </div>
                                            <div class="ms-3">
                                                <?php 
                                $statusColor = $log['status_color'] ?? '#6c757d';
                                $statusName = $log['status_name'] ?? 'Unknown';
                                // Convert hex color to RGB for light background
                                $hex = ltrim($statusColor, '#');
                                $r = hexdec(substr($hex, 0, 2));
                                $g = hexdec(substr($hex, 2, 2));
                                $b = hexdec(substr($hex, 4, 2));
                                $lightBg = "rgba($r, $g, $b, 0.1)";
                                ?>
                                                <span class="badge log-status-badge fw-bold"
                                                    style="background-color: <?= $lightBg ?>; color: <?= $statusColor ?>;">
                                                    <?= strtoupper(esc($statusName)) ?>
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Module -->
                                        <div class="mb-3">
                                            <?php if (!empty($log['module'])): ?>
                                            <div class="text-primary fw-semibold mb-1"><?= esc($log['module']) ?></div>
                                            <?php endif; ?>
                                        </div>

                                        <!-- Log Footer -->
                                        <div class="d-flex justify-content-between align-items-center mt-4">
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">
                                                    <?= !empty($log['user_name']) ? esc($log['user_name']) : 'System' ?>
                                                </small>
                                            </div>
                                            <small
                                                class="text-muted"><?= date('M d, Y H:i', strtotime($log['logged_at'])) ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center py-10">
                                    <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <h6 class="fw-bold text-gray-700 mb-2">No logs found</h6>
                                    <p class="fs-7 text-gray-500 mb-4">System logs will appear here</p>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>

                        <!-- Loading indicator for infinite scroll -->
                        <div id="loading-indicator" class="text-center py-4 d-none">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 text-muted">Loading more logs...</p>
                        </div>

                        <!-- No more data indicator -->
                        <div id="no-more-data" class="text-center py-4 d-none">
                            <p class="text-muted">No more logs to load</p>
                        </div>
                    </div>
                </div>
                <!--end::Mobile UI-->


                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid d-none d-lg-flex" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">

                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar  pt-10 ">

                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container"
                                class="app-container  container-fluid d-flex align-items-stretch ">
                                <!--begin::Toolbar wrapper-->
                                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">

                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column gap-1 me-3 mb-2">

                                        <!--begin::Title-->
                                        <h1
                                            class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 lh-0  mb-6 mt-4">
                                            System Logs
                                        </h1>
                                        <!--end::Title-->
                                        <!--begin::Breadcrumb-->
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-2">

                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                                <a href="/" class="text-gray-500 text-hover-primary">
                                                    <i class="ki-duotone ki-home fs-3 text-gray-500 me-n1"></i>
                                                </a>
                                            </li>
                                            <!--end::Item-->

                                            <!--begin::Item-->
                                            <li class="breadcrumb-item">
                                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                                            </li>
                                            <!--end::Item-->


                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                                Settings </li>
                                            <!--end::Item-->


                                            <!--begin::Item-->
                                            <li class="breadcrumb-item">
                                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                                            </li>
                                            <!--end::Item-->


                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-gray-700">
                                                System Logs </li>
                                            <!--end::Item-->


                                        </ul>
                                        <!--end::Breadcrumb-->


                                    </div>
                                    <!--end::Page title-->

                                    <!--begin::Actions-->
                                    <!-- <a href="#" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_app">
                                        Create Project</span>
                                    </a> -->
                                    <!--end::Actions-->
                                </div>
                                <!--end::Toolbar wrapper-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content  flex-column-fluid ">


                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container  container-fluid ">

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
                                                    placeholder="Search logs..." value="<?= esc($search) ?>" />
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--begin::Card title-->

                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Toolbar-->
                                            <div class="d-flex justify-content-end" data-kt-log-table-toolbar="base">
                                                <!--begin::Export-->
                                                <button type="button" class="btn btn-light-primary me-3"
                                                    id="export_logs_btn">
                                                    <i class="ki-duotone ki-exit-down fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>Export Logs
                                                </button>
                                                <!--end::Export-->
                                                <!--begin::Clear logs-->
                                                <button type="button" class="btn btn-danger" id="clear_logs_btn">
                                                    <i class="ki-duotone ki-trash fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>Clear All Logs
                                                </button>
                                                <!--end::Clear logs-->
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
                                                id="kt_logs_table">
                                                <!--begin::Table head-->
                                                <thead>
                                                    <!--begin::Table row-->
                                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                                        <th class="w-10px pe-2">
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                <input class="form-check-input" type="checkbox"
                                                                    data-kt-check="true"
                                                                    data-kt-check-target="#kt_logs_table .form-check-input"
                                                                    value="1" />
                                                            </div>
                                                        </th>
                                                        <th class="min-w-20px">#</th>
                                                        <th class="min-w-80px">Status</th>
                                                        <th class="min-w-100px">Module</th>
                                                        <th class="min-w-300px">Action</th>
                                                        <th class="min-w-120px">User</th>
                                                        <th class="min-w-120px">Logged At</th>
                                                    </tr>
                                                    <!--end::Table row-->
                                                </thead>
                                                <!--end::Table head-->

                                                <!--begin::Table body-->
                                                <tbody class="text-gray-600 fw-semibold">
                                                    <?php if (!empty($logs)): ?>
                                                    <?php foreach ($logs as $log): ?>
                                                    <!--begin::Table row-->
                                                    <tr>
                                                        <!--begin::Checkbox-->
                                                        <td>
                                                            <div
                                                                class="form-check form-check-sm form-check-custom form-check-solid">
                                                                <input class="form-check-input" type="checkbox"
                                                                    value="<?= esc($log['id']) ?>" />
                                                            </div>
                                                        </td>
                                                        <!--end::Checkbox-->

                                                        <!--begin::ID-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <small
                                                                    class="text-muted">#<?= esc($log['id']) ?></small>
                                                            </div>
                                                        </td>
                                                        <!--end::ID-->

                                                        <!--begin::Status-->
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <?php 
                                                $statusColor = $log['status_color'] ?? '#6c757d';
                                                $statusName = $log['status_name'] ?? 'Unknown';
                                                // Convert hex color to RGB for light background
                                                $hex = ltrim($statusColor, '#');
                                                $r = hexdec(substr($hex, 0, 2));
                                                $g = hexdec(substr($hex, 2, 2));
                                                $b = hexdec(substr($hex, 4, 2));
                                                $lightBg = "rgba($r, $g, $b, 0.1)";
                                                ?>
                                                                <span class="badge fw-bold log-status-badge"
                                                                    style="background-color: <?= $lightBg ?>; color: <?= $statusColor ?>;">
                                                                    <?= strtoupper(esc($statusName)) ?>
                                                                </span>
                                                            </div>
                                                        </td>
                                                        <!--end::Status-->

                                                        <!--begin::Module-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <?php if (!empty($log['module_name'])): ?>
                                                                <span class="text-dark">
                                                                    <i class="ki-duotone ki-abstract-26 fs-6 me-1">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                    </i>
                                                                    <?= esc($log['module_name']) ?>
                                                                </span>
                                                                <?php else: ?>
                                                                <span class="text-muted">-</span>
                                                                <?php endif; ?>
                                                            </div>
                                                        </td>
                                                        <!--end::Module-->

                                                        <!--begin::Action-->
                                                        <td>
                                                            <div class="text-gray-600 log-action-formatted">
                                                                <?= formatActionText($log['action']) ?>
                                                            </div>
                                                        </td>
                                                        <!--end::Action-->

                                                        <!--begin::User-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="text-muted"><?= esc($log['user_name'] ?? 'System') ?></span>
                                                            </div>
                                                        </td>
                                                        <!--end::User-->

                                                        <!--begin::Logged At-->
                                                        <td>
                                                            <div class="d-flex flex-column">
                                                                <span
                                                                    class="text-muted"><?= date('d M Y', strtotime($log['logged_at'])) ?></span>
                                                                <small
                                                                    class="text-muted"><?= date('H:i:s', strtotime($log['logged_at'])) ?></small>
                                                            </div>
                                                        </td>
                                                        <!--end::Logged At-->
                                                    </tr>
                                                    <!--end::Table row-->
                                                    <?php endforeach; ?>
                                                    <?php else: ?>
                                                    <!--begin::No results-->
                                                    <tr>
                                                        <td colspan="7" class="text-center py-10">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <i
                                                                    class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                </i>
                                                                <div class="fw-bold text-gray-700 mb-2">No logs found
                                                                </div>
                                                                <div class="text-gray-500">System logs will appear here
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

                                        <?php
                                        // Include table footer with pagination
                                        $footerData = [
                                            'baseUrl' => 'logs',
                                            'currentPage' => $currentPage,
                                            'totalPages' => $totalPages,
                                            'limit' => $limit,
                                            'totalRecords' => $totalLogs,
                                            'search' => $search,
                                            'tableId' => 'kt_log_table_length',
                                            'jsFunction' => 'changeLogTableLimit'
                                        ];
                                        echo view('partials/table_footer', $footerData);
                                        ?>
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

                    <!-- Scripts -->

                    <script>
                    // Global variables
                    let currentPage = 1;
                    let isLoading = false;
                    let hasMoreData = true;
                    let searchTimeout;

                    /**
                     * Format action text to make labels bold in JavaScript
                     */
                    function formatActionText(actionText) {
                        if (!actionText) return actionText;

                        // Replace labels with bold versions - expanded to include all Islander fields
                        return actionText
                            .replace(/^(#:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Module:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Name:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Description:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Islander No:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Username:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Email:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Phone:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Position:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Section:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Department:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Division:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Status:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Gender:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Nationality:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Date of Birth:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Date of Joining:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Company:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(House:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(ID\/PP\/WP No:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Address:)(.*)$/gm, '<strong>$1</strong>$2')
                            .replace(/^(Notes:)(.*)$/gm, '<strong>$1</strong>$2');
                    }

                    // Check if there are server-rendered cards and adjust currentPage
                    document.addEventListener('DOMContentLoaded', function() {
                        const existingCards = document.querySelectorAll(
                            '#mobile-cards-container .mobile-log-card');
                        if (existingCards.length > 0) {
                            // Server already rendered the first page, so start from page 2
                            currentPage = Math.ceil(existingCards.length / 10) + 1;
                        }
                    });

                    // Document ready
                    document.addEventListener('DOMContentLoaded', function() {
                        // Initialize AOS (Animate On Scroll) for mobile cards
                        if (typeof AOS !== 'undefined') {
                            AOS.init({
                                duration: 600,
                                easing: 'ease-in-out',
                                once: false,
                                mirror: false
                            });
                        }

                        // Handle sidebar state for mobile search bar
                        const sidebar = document.getElementById('kt_app_sidebar');
                        const mobileSearchBar = document.querySelector('.mobile-search-bar');

                        if (sidebar && mobileSearchBar) {
                            // Create observer to watch for sidebar state changes
                            const observer = new MutationObserver(function(mutations) {
                                mutations.forEach(function(mutation) {
                                    if (mutation.type === 'attributes' && mutation
                                        .attributeName === 'data-kt-drawer') {
                                        const isDrawerOn = sidebar.getAttribute(
                                            'data-kt-drawer') === 'on';
                                        if (isDrawerOn) {
                                            mobileSearchBar.style.zIndex = '100';
                                        } else {
                                            mobileSearchBar.style.zIndex = '999';
                                        }
                                    }
                                });
                            });

                            observer.observe(sidebar, {
                                attributes: true,
                                attributeFilter: ['data-kt-drawer']
                            });

                            // Also listen for drawer events
                            document.addEventListener('click', function(e) {
                                if (e.target.id === 'kt_app_sidebar_mobile_toggle' || e.target.closest(
                                        '#kt_app_sidebar_mobile_toggle')) {
                                    setTimeout(() => {
                                        const isDrawerOn = sidebar.getAttribute(
                                            'data-kt-drawer') === 'on';
                                        if (isDrawerOn) {
                                            mobileSearchBar.style.zIndex = '100';
                                        } else {
                                            mobileSearchBar.style.zIndex = '999';
                                        }
                                    }, 100);
                                }
                            });
                        }

                        // Mobile search functionality
                        const mobileSearch = document.getElementById('mobile_search');
                        const desktopSearch = document.getElementById('kt_filter_search');

                        function performSearch(query) {
                            clearTimeout(searchTimeout);
                            searchTimeout = setTimeout(() => {
                                // Reset pagination
                                currentPage = 1;
                                hasMoreData = true;

                                // Clear existing cards for mobile
                                const container = document.getElementById('mobile-cards-container');
                                if (container && window.innerWidth < 992) {
                                    // Mobile view - use AJAX
                                    container.innerHTML = '';
                                    loadLogs(true, query);
                                } else {
                                    // Desktop view - reload page with search
                                    const url = new URL(window.location);
                                    if (query.trim()) {
                                        url.searchParams.set('search', query);
                                    } else {
                                        url.searchParams.delete('search');
                                    }
                                    window.location.href = url.toString();
                                }
                            }, 500);
                        }

                        if (mobileSearch) {
                            mobileSearch.addEventListener('input', (e) => {
                                performSearch(e.target.value);
                            });
                        }

                        if (desktopSearch) {
                            desktopSearch.addEventListener('input', (e) => {
                                performSearch(e.target.value);
                            });
                        }

                        // Load initial logs for mobile
                        const mobileContainer = document.getElementById('mobile-cards-container');
                        if (mobileContainer) {
                            // Only load initial data if container is empty (no server-rendered content)
                            const existingCards = mobileContainer.querySelectorAll('.mobile-log-card');
                            if (existingCards.length === 0) {
                                loadLogs(false);
                            }

                            // Infinite scroll for mobile
                            let scrollTimeout;
                            window.addEventListener('scroll', () => {
                                clearTimeout(scrollTimeout);
                                scrollTimeout = setTimeout(() => {
                                    if (!isLoading && hasMoreData) {
                                        const scrollPosition = window.innerHeight + window
                                            .scrollY;
                                        const documentHeight = document.documentElement
                                            .offsetHeight;

                                        if (scrollPosition >= documentHeight - 1000) {
                                            loadLogs(false, mobileSearch?.value || '');
                                        }
                                    }
                                }, 100);
                            });
                        }

                        // Handle view log
                        // Handle export logs
                        document.addEventListener('click', function(e) {
                            if (e.target.closest('#export_logs_btn') || e.target.closest(
                                    '#mobile_export_btn')) {
                                e.preventDefault();
                                exportLogs();
                            }
                        });

                        // Handle clear all logs
                        document.addEventListener('click', function(e) {
                            if (e.target.closest('#clear_logs_btn') || e.target.closest(
                                    '#mobile_clear_btn')) {
                                e.preventDefault();
                                clearAllLogs();
                            }
                        });

                        // Mobile cards initialized (no actions needed)
                    });

                    function loadLogs(reset = false, search = '') {
                        if (isLoading) return;

                        if (reset) {
                            currentPage = 1;
                            hasMoreData = true;
                            const container = document.getElementById('mobile-cards-container');
                            if (container) {
                                container.innerHTML = '';
                            }
                        }

                        if (!hasMoreData) return;

                        isLoading = true;
                        const loadingIndicator = document.getElementById('loading-indicator');
                        const noMoreDataIndicator = document.getElementById('no-more-data');

                        if (loadingIndicator) loadingIndicator.classList.remove('d-none');
                        if (noMoreDataIndicator) noMoreDataIndicator.classList.add('d-none');

                        // Show skeleton loading for first page
                        if (currentPage === 1) {
                            showSkeletonLoading();
                        }

                        const url = `/logs/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

                        secureFetch(url)
                            .then(response => {
                                if (response.status === 401 || response.status === 403) {
                                    handleSessionExpired();
                                    return;
                                }

                                if (!response.ok) {
                                    console.error('HTTP error:', response.status);
                                    throw new Error(`HTTP error! status: ${response.status}`);
                                }

                                return response.json();
                            })
                            .then(data => {
                                if (data.success) {
                                    // Remove skeleton loading
                                    removeSkeletonLoading();

                                    if (data.data && data.data.length > 0) {
                                        renderLogs(data.data);
                                        currentPage++;
                                        hasMoreData = data.hasMore;

                                        // Reinitialize AOS for new elements
                                        if (typeof AOS !== 'undefined') {
                                            AOS.refresh();
                                        }
                                    } else {
                                        hasMoreData = false;
                                        if (currentPage === 1) {
                                            showNoLogsMessage();
                                        }
                                    }

                                    // Update indicators
                                    if (loadingIndicator) loadingIndicator.classList.add('d-none');
                                    if (!hasMoreData && noMoreDataIndicator && currentPage > 1) {
                                        noMoreDataIndicator.classList.remove('d-none');
                                    }
                                } else {
                                    console.error('API Error:', data.message);
                                    if (loadingIndicator) loadingIndicator.classList.add('d-none');
                                }
                            })
                            .catch(error => {
                                console.error('Network Error:', error);
                                removeSkeletonLoading();
                                if (loadingIndicator) loadingIndicator.classList.add('d-none');
                            })
                            .finally(() => {
                                isLoading = false;
                            });
                    }

                    function renderLogs(logs) {
                        const container = document.getElementById('mobile-cards-container');
                        if (!container) return;

                        logs.forEach((log, index) => {
                            const logCard = createLogCard(log, (currentPage - 1) * 10 + index);
                            container.appendChild(logCard);
                        });

                        // Reinitialize after adding new cards (no actions needed)
                    }

                    function createLogCard(log, index) {
                        const col = document.createElement('div');
                        col.className = 'col-12 mb-3';
                        col.setAttribute('data-aos', 'fade-up');
                        col.setAttribute('data-aos-delay', (index * 100).toString());
                        col.setAttribute('data-aos-duration', '600');

                        const statusColor = log.status_color || '#6c757d';
                        const statusName = log.status_name || 'Unknown';
                        const userName = log.user_name || 'System';
                        const loggedAt = new Date(log.logged_at).toLocaleDateString('en-US', {
                            month: 'short',
                            day: '2-digit',
                            year: 'numeric'
                        });
                        const loggedTime = new Date(log.logged_at).toLocaleTimeString('en-US', {
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        // Convert hex color to RGB for light background
                        const hex = statusColor.replace('#', '');
                        const r = parseInt(hex.substr(0, 2), 16);
                        const g = parseInt(hex.substr(2, 2), 16);
                        const b = parseInt(hex.substr(4, 2), 16);
                        const lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;

                        col.innerHTML = `
        <div class="card mobile-log-card" data-log-id="${log.id}">
            <div class="card-body p-4">
                <!-- Log Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${log.id}</small>
                        <div class="text-gray-800 log-action-text-mobile">${formatActionText(log.action)}</div>
                    </div>
                    <div class="ms-3">
                        <span class="badge log-status-badge fw-bold" 
                              style="background-color: ${lightBg}; color: ${statusColor};">
                            ${statusName.toUpperCase()}
                        </span>
                    </div>
                </div>

                <!-- Module -->
                <div class="mb-3">
                    ${log.module_name ? `<div class="text-primary fw-semibold mb-1"><i class="ki-duotone ki-abstract-26 fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>${log.module_name}</div>` : ''}
                </div>

                <!-- Log Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-flex flex-column">
                        <small class="text-muted">${userName}</small>
                    </div>
                    <small class="text-muted">${loggedAt} ${loggedTime}</small>
                </div>
            </div>
        </div>
    `;

                        return col;
                    }

                    function showSkeletonLoading() {
                        const container = document.getElementById('mobile-cards-container');
                        if (!container) return;

                        // Create skeleton cards
                        for (let i = 0; i < 3; i++) {
                            const skeletonCard = document.createElement('div');
                            skeletonCard.className = 'col-12 mb-3 skeleton-card';
                            skeletonCard.innerHTML = `
            <div class="card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="skeleton-text skeleton-small"></div>
                        <div class="skeleton-badge"></div>
                    </div>
                    <div class="mb-4 mt-4">
                        <div class="skeleton-text skeleton-medium mb-2"></div>
                        <div class="skeleton-text" style="width: 80%;"></div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="skeleton-text skeleton-medium"></div>
                        <div class="skeleton-text skeleton-small"></div>
                    </div>
                </div>
            </div>
        `;
                            container.appendChild(skeletonCard);
                        }
                    }

                    function removeSkeletonLoading() {
                        const skeletonCards = document.querySelectorAll('.skeleton-card');
                        skeletonCards.forEach(card => card.remove());
                    }

                    function showNoLogsMessage() {
                        const container = document.getElementById('mobile-cards-container');
                        if (!container) return;

                        const noDataDiv = document.createElement('div');
                        noDataDiv.className = 'col-12';
                        noDataDiv.innerHTML = `
        <div class="d-flex flex-column align-items-center justify-content-center py-10">
            <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <h6 class="fw-bold text-gray-700 mb-2">No logs found</h6>
            <p class="fs-7 text-gray-500 mb-4">System logs will appear here</p>
        </div>
    `;
                        container.appendChild(noDataDiv);
                    }

                    // Log CRUD functions
                    function exportLogs() {
                        const search = document.getElementById('mobile_search')?.value || document.getElementById(
                            'kt_filter_search')?.value || '';
                        const url = `/logs/export?search=${encodeURIComponent(search)}`;
                        window.open(url, '_blank');
                    }

                    function clearAllLogs() {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This will permanently delete ALL log entries!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, clear all logs!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                secureFetch('/logs/clear', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                        }
                                    })
                                    .then(response => {
                                        if (response.status === 401 || response.status === 403) {
                                            handleSessionExpired();
                                            return;
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire('Cleared!', data.message, 'success');
                                            // Reload the page
                                            window.location.reload();
                                        } else {
                                            Swal.fire('Error', data.message, 'error');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        Swal.fire('Error', 'Failed to clear logs', 'error');
                                    });
                            }
                        });
                    }

                    // Mobile card click functionality
                    // Modal population function
                    // Global functions accessible from modals
                    function secureFetch(url, options = {}) {
                        const defaultOptions = {
                            credentials: 'same-origin',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                ...options.headers
                            }
                        };

                        return fetch(url, {
                            ...defaultOptions,
                            ...options
                        });
                    }

                    function handleSessionExpired() {
                        // Clear any stored session data
                        localStorage.removeItem('user');
                        sessionStorage.clear();

                        // Show alert and redirect
                        Swal.fire({
                            icon: 'warning',
                            title: 'Session Expired',
                            text: 'Your session has expired. Please log in again.',
                            confirmButtonText: 'Login',
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(() => {
                            window.location.href = '/login';
                        });
                    }

                    // Change table limit (records per page)
                    function changeLogTableLimit(newLimit) {
                        const currentUrl = new URL(window.location.href);
                        currentUrl.searchParams.set('limit', newLimit);
                        currentUrl.searchParams.set('page', '1'); // Reset to first page
                        window.location.href = currentUrl.toString();
                    }
                    </script>



                    <!--begin::Footer-->
                    <div id="kt_app_footer"
                        class="app-footer  align-items-center justify-content-center justify-content-md-between flex-column flex-md-row py-3 ">



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

                            <li class="menu-item"><a class="menu-link px-2">Build: 25.11.2025.301</a></li>

                        </ul>
                        <!--end::Menu-->
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