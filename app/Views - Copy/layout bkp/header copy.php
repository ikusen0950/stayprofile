<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Islanders App" />
    <meta name="keywords" content="Islanders, App" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
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

    <!--begin::Mobile Status Bar Fix-->
    <style>
        /* Mobile status bar background fill */
        .mobile-status-bar-bg {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px; /* Match the header margin */
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            z-index: 9999;
            display: none;
        }
        
        /* Dark theme support */
        [data-bs-theme="dark"] .mobile-status-bar-bg {
            background: rgba(30, 30, 46, 0.85);
        }
        
        /* Mobile status bar spacing */
        @media (max-width: 768px) {
            .mobile-status-bar-bg {
                display: block;
            }
            
            #kt_app_header {
                margin-top: 50px; /* Increased space for mobile status bar */
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(20px);
                -webkit-backdrop-filter: blur(20px);
                border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            }
            
            /* For devices with larger status bars (iPhone X and newer) */
            @supports (padding-top: constant(safe-area-inset-top)) {
                .mobile-status-bar-bg {
                    height: calc(constant(safe-area-inset-top) + 20px);
                }
                #kt_app_header {
                    margin-top: calc(constant(safe-area-inset-top) + 20px);
                }
            }
            
            @supports (padding-top: env(safe-area-inset-top)) {
                .mobile-status-bar-bg {
                    height: calc(env(safe-area-inset-top) + 20px);
                }
                #kt_app_header {
                    margin-top: calc(env(safe-area-inset-top) + 20px);
                }
            }
            
            /* Dark theme header background */
            [data-bs-theme="dark"] #kt_app_header {
                background: rgba(30, 30, 46, 0.85);
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            }
        }
        
        /* Ensure the app takes full height */
        #kt_app_root {
            min-height: 100vh;
        }
    </style>
    <!--end::Mobile Status Bar Fix-->



    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
    if (window.top != window.self) {
        window.top.location.replace(window.self.location.href);
    }
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

    <!--begin::Mobile Status Bar Background-->
    <div class="mobile-status-bar-bg"></div>
    <!--end::Mobile Status Bar Background-->

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