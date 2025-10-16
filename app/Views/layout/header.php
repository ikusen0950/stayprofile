<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Islanders App" />
    <meta name="keywords" content="Islanders, App" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
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

    <!--begin::Mobile Safe Area Styles for Capacitor-->
    <style>
        /* Safe area handling for mobile devices in Capacitor */
        :root {
            --safe-area-inset-top: env(safe-area-inset-top);
            --safe-area-inset-bottom: env(safe-area-inset-bottom);
            --safe-area-inset-left: env(safe-area-inset-left);
            --safe-area-inset-right: env(safe-area-inset-right);
        }

        /* Apply safe area padding to the main app container */
        .app-root {
            padding-top: var(--safe-area-inset-top);
            padding-bottom: var(--safe-area-inset-bottom);
            padding-left: var(--safe-area-inset-left);
            padding-right: var(--safe-area-inset-right);
        }

        /* Ensure the header doesn't overlap with status bar */
        .app-header {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        /* Mobile specific adjustments */
        @media (max-width: 768px) {
            .app-header .app-container {
                margin-top: 0.5rem !important;
            }
        }

        /* Capacitor specific adjustments */
        @supports (padding-top: env(safe-area-inset-top)) {
            .app-root {
                padding-top: calc(env(safe-area-inset-top) + 0px);
            }
        }

        /* Status bar background for mobile */
        .status-bar-background {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--safe-area-inset-top);
            background-color: #ffffff; /* Match your app's primary color */
            z-index: 10000;
            display: none;
        }

        /* Show status bar background only in Capacitor */
        body.capacitor-app .status-bar-background {
            display: block;
        }

        /* Additional styles when running in Capacitor */
        body.capacitor-app {
            /* Ensure full viewport usage */
            height: 100vh;
            height: calc(100vh - env(safe-area-inset-bottom));
        }

        body.capacitor-app .app-root {
            min-height: 100vh;
            min-height: calc(100vh - env(safe-area-inset-bottom));
        }

        /* Dark theme support for status bar */
        [data-bs-theme="dark"] .status-bar-background {
            background-color: #1e1e2e; /* Dark theme color */
        }

        /* Fix for iPhone notch and Android status bars */
        @media screen and (device-width: 375px) and (device-height: 812px) and (-webkit-device-pixel-ratio: 3) {
            /* iPhone X/XS */
            .app-root {
                padding-top: 44px;
            }
        }

        @media screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 2) {
            /* iPhone XR */
            .app-root {
                padding-top: 44px;
            }
        }

        @media screen and (device-width: 414px) and (device-height: 896px) and (-webkit-device-pixel-ratio: 3) {
            /* iPhone XS Max */
            .app-root {
                padding-top: 44px;
            }
        }
    </style>
    <!--end::Mobile Safe Area Styles-->

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
    if (window.top != window.self) {
        window.top.location.replace(window.self.location.href);
    }

    // Capacitor/Mobile app detection and safe area handling
    document.addEventListener('DOMContentLoaded', function() {
        // Check if running in Capacitor
        const isCapacitor = window.Capacitor && window.Capacitor.isNativePlatform();
        
        if (isCapacitor) {
            document.body.classList.add('capacitor-app');
            
            // Additional safe area handling for Capacitor
            const appRoot = document.getElementById('kt_app_root');
            if (appRoot) {
                appRoot.style.paddingTop = 'env(safe-area-inset-top)';
            }

            // Configure status bar if plugin is available
            // Note: Make sure to install @capacitor/status-bar plugin
            // and configure it in your Capacitor app's main.ts or index.ts
            if (window.Capacitor && window.Capacitor.Plugins && window.Capacitor.Plugins.StatusBar) {
                const { StatusBar } = window.Capacitor.Plugins;
                
                // Set status bar style
                StatusBar.setStyle({ style: 'Light' }); // or 'Dark' based on your theme
                StatusBar.setBackgroundColor({ color: '#ffffff' }); // Match your app's color
                StatusBar.show();
            }
        }

        // Handle orientation changes
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                // Force a small layout recalculation after orientation change
                const appRoot = document.getElementById('kt_app_root');
                if (appRoot && isCapacitor) {
                    appRoot.style.paddingTop = 'env(safe-area-inset-top)';
                }
            }, 100);
        });
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


    <!--begin::Status bar background for mobile-->
    <div class="status-bar-background"></div>
    <!--end::Status bar background-->

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