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
    
    <!-- Mobile app specific meta tags -->
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="default" />
    <meta name="mobile-web-app-capable" content="yes" />
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
    <link href="/assets/css/mobile-fix.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Mobile Status Bar Handling -->
    <style>
        /* Mobile status bar handling for all devices */
        @media screen and (max-width: 768px) {
            /* Base mobile padding for status bar */
            #kt_app_header {
                padding-top: 54px !important; /* Increased back to push below status bar */
                min-height: 70px !important; /* Reduced from 80px */
                z-index: 1000 !important; /* Ensure header is below sidebar */
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                right: 0 !important;
                display: flex !important;
                align-items: flex-end !important; /* Align content to bottom */
            }
            
            /* Header container specific adjustments */
            #kt_app_header_container {
                padding-top: 0px !important; /* Remove top padding */
                padding-bottom: 8px !important; /* Reduced bottom padding */
                min-height: 50px !important; /* Reduced from 60px */
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                width: 100% !important;
                margin-bottom: 0 !important;
            }
            
            /* Fix logo and button alignment */
            #kt_app_header_container .d-flex {
                align-items: center !important;
                height: auto !important;
            }
            
            /* Ensure sidebar appears above header */
            #kt_app_sidebar {
                z-index: 1050 !important; /* Higher than header */
            }
            
            /* Adjust page content to account for fixed header */
            #kt_app_page {
                padding-top: 90px !important; /* Reduced from 114px */
            }
            
            /* Fix sidebar overlay */
            .app-sidebar-overlay {
                z-index: 1040 !important;
            }
            
            /* iOS devices with safe area support */
            @supports (padding-top: env(safe-area-inset-top)) {
                #kt_app_header {
                    padding-top: calc(env(safe-area-inset-top) + 20px) !important;
                }
                
                #kt_app_page {
                    padding-top: calc(env(safe-area-inset-top) + 65px) !important;
                }
            }
            
            /* Capacitor app specific handling */
            .capacitor-mobile #kt_app_header {
                padding-top: 54px !important;
                min-height: 70px !important;
            }
            
            .capacitor-mobile #kt_app_header_container {
                padding-top: 0px !important;
                padding-bottom: 10px !important;
                min-height: 52px !important;
            }
            
            .capacitor-mobile #kt_app_page {
                padding-top: 90px !important;
            }
            
            /* For iOS in Capacitor */
            .capacitor-mobile.ios #kt_app_header {
                padding-top: 64px !important; /* Increased for iOS status bar */
                min-height: 75px !important; /* Reduced from 90px */
            }
            
            .capacitor-mobile.ios #kt_app_header_container {
                padding-top: 0px !important;
                padding-bottom: 12px !important;
                min-height: 55px !important;
            }
            
            .capacitor-mobile.ios #kt_app_page {
                padding-top: 105px !important;
            }
            
            /* For Android in Capacitor */
            .capacitor-mobile.android #kt_app_header {
                padding-top: 48px !important; /* Increased for Android status bar */
                min-height: 68px !important; /* Reduced from 75px */
            }
            
            .capacitor-mobile.android #kt_app_header_container {
                padding-top: 0px !important;
                padding-bottom: 8px !important;
                min-height: 50px !important;
            }
            
            .capacitor-mobile.android #kt_app_page {
                padding-top: 85px !important;
            }
            
            /* Ensure the header container doesn't add extra margin */
            #kt_app_header .app-container {
                margin-top: 0 !important;
            }
            
            /* Fix potential body padding conflicts */
            body {
                padding-top: 0 !important;
            }
            
            /* Fix logo and button positioning */
            #kt_app_header_container .btn {
                margin: 0 !important;
            }
            
            #kt_app_header_container img {
                vertical-align: middle !important;
            }
        }
        
        /* Fallback for very small screens */
        @media screen and (max-height: 667px) {
            #kt_app_header {
                padding-top: 40px !important;
                min-height: 60px !important;
            }
            
            #kt_app_header_container {
                padding-top: 0px !important;
                padding-bottom: 6px !important;
                min-height: 45px !important;
            }
            
            #kt_app_page {
                padding-top: 75px !important;
            }
        }
    </style>

    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
    if (window.top != window.self) {
        window.top.location.replace(window.self.location.href);
    }

    // Enhanced Capacitor mobile app detection and setup
    document.addEventListener('DOMContentLoaded', function() {
        // Check if running in Capacitor
        if (window.Capacitor) {
            document.body.classList.add('capacitor-mobile');
            
            // Detect platform
            if (window.Capacitor.platform === 'ios') {
                document.body.classList.add('ios');
            } else if (window.Capacitor.platform === 'android') {
                document.body.classList.add('android');
            }
            
            // Import StatusBar plugin if available
            if (window.Capacitor.Plugins && window.Capacitor.Plugins.StatusBar) {
                const { StatusBar } = window.Capacitor.Plugins;
                
                // Set status bar style to light content (white text on dark background)
                StatusBar.setStyle({
                    style: 'LIGHT'
                });
                
                // Set status bar background color to match your header
                StatusBar.setBackgroundColor({
                    color: '#1e293b' // Dark slate color to match header
                });
                
                // Make sure status bar is visible
                StatusBar.show();
                
                // Set overlay to false so content doesn't go behind status bar
                StatusBar.setOverlaysWebView({
                    overlay: false
                });
            }
        }
        
        // Alternative detection for mobile apps (PWA)
        if (window.navigator.standalone || window.matchMedia('(display-mode: standalone)').matches) {
            document.body.classList.add('mobile-app');
        }
        
        // Additional mobile detection
        const isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
        if (isMobile) {
            document.body.classList.add('mobile-device');
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
                <div class="app-container container-fluid d-flex align-items-stretch flex-stack"
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