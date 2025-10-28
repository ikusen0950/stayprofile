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
                    <?= $this->include('layout/navbar.php') ?>
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
                <?= $this->include('layout/sidebar.php') ?>
                <!--end::Sidebar-->