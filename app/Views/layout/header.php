<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Your Island Buddy." />
    <meta name="keywords" content="Islander, Islanders, Islanders App, Islander App" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Islanders App" />
    <meta property="og:url" content="" />
    <meta property="og:site_name" content="Islanders App" />
    <link rel="canonical" href="" />
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

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <!-- Page CSS -->

    <!-- Alpine Js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Apex Charts -->
    <script src="../../assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
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
            <div id="kt_app_header" class="app-header "
                data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '300px'}" data-kt-sticky-animation="false">

                <!--begin::Header container-->
                <div class="app-container  container-fluid d-flex align-items-stretch flex-stack mt-7 " id="kt_app_header_container">
                    <!--begin::Sidebar toggle-->
                    <div class="d-flex align-items-center d-block d-lg-none ms-n3" title="Show sidebar menu">
                        <div class="btn btn-icon btn-active-color-primary w-35px h-35px me-2" id="kt_app_sidebar_mobile_toggle">
                            <i class="ki-duotone ki-abstract-14 fs-2"><span class="path1"></span><span class="path2"></span></i>
                        </div>

                        <!--begin::Logo image-->
                        <a href="/">
                            <img alt="Logo" src="/assets/media/logos/default.svg" class="h-20px theme-light-show" />
                            <img alt="Logo" src="/assets/media/logos/default-dark.svg" class="h-20px theme-dark-show" />
                        </a>
                        <!--end::Logo image-->
                    </div>
                    <!--end::Sidebar toggle-->


                    <!--begin::Navbar-->
                    <?= $this->include('layouts/navbar.php') ?>
                    <!--end::Navbar-->
                </div>
                <!--end::Header container-->
            </div>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper  flex-column flex-row-fluid " id="kt_app_wrapper">


                <!--begin::Sidebar-->
                <?= $this->include('layouts/sidebar.php') ?>
                <!--end::Sidebar-->