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
    <!--end::Vendor Stylesheets-->


    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->


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
                        <a href="/saul-html-pro/index.html" class="app-sidebar-logo">
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
                                <img src="/assets/media/avatars/300-2.jpg" alt="user" />
                            </div>

                            <!--begin::User account menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <div class="menu-content d-flex align-items-center px-3">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-50px me-5">
                                            <img alt="Logo" src="/assets/media/avatars/300-2.jpg" />
                                        </div>
                                        <!--end::Avatar-->

                                        <!--begin::Username-->
                                        <div class="d-flex flex-column">
                                            <div class="fw-bold d-flex align-items-center fs-5">
                                                Jane Cooper <span
                                                    class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">Pro</span>
                                            </div>

                                            <a href="#" class="fw-semibold text-muted text-hover-primary fs-7">
                                                jane@kt.com </a>
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
                                        My Profile
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="/saul-html-pro/apps/projects/list.html" class="menu-link px-5">
                                        <span class="menu-text">My Projects</span>
                                        <span class="menu-badge">
                                            <span class="badge badge-light-danger badge-circle fw-bold fs-7">3</span>
                                        </span>
                                    </a>
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}"
                                    data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
                                    <a href="#" class="menu-link px-5">
                                        <span class="menu-title">My Subscription</span>
                                        <span class="menu-arrow"></span>
                                    </a>

                                    <!--begin::Menu sub-->
                                    <div class="menu-sub menu-sub-dropdown w-175px py-4">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/saul-html-pro/account/referrals.html" class="menu-link px-5">
                                                Referrals
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/saul-html-pro/account/billing.html" class="menu-link px-5">
                                                Billing
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/saul-html-pro/account/statements.html" class="menu-link px-5">
                                                Payments
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <a href="/saul-html-pro/account/statements.html"
                                                class="menu-link d-flex flex-stack px-5">
                                                Statements

                                                <span class="ms-2 lh-0" data-bs-toggle="tooltip"
                                                    title="View your statements">
                                                    <i class="ki-duotone ki-information-5 fs-5"><span
                                                            class="path1"></span><span class="path2"></span><span
                                                            class="path3"></span></i> </span>
                                            </a>
                                        </div>
                                        <!--end::Menu item-->

                                        <!--begin::Menu separator-->
                                        <div class="separator my-2"></div>
                                        <!--end::Menu separator-->

                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            <div class="menu-content px-3">
                                                <label
                                                    class="form-check form-switch form-check-custom form-check-solid">
                                                    <input class="form-check-input w-30px h-20px" type="checkbox"
                                                        value="1" checked="checked" name="notifications" />
                                                    <span class="form-check-label text-muted fs-7">
                                                        Notifications
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                        <!--end::Menu item-->
                                    </div>
                                    <!--end::Menu sub-->
                                </div>
                                <!--end::Menu item-->

                                <!--begin::Menu item-->
                                <div class="menu-item px-5">
                                    <a href="/saul-html-pro/account/statements.html" class="menu-link px-5">
                                        My Statements
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
                                            <a href="/saul-html-pro/account/settings.html"
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
                                            <a href="/saul-html-pro/account/settings.html"
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
                                            <a href="/saul-html-pro/account/settings.html"
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
                                            <a href="/saul-html-pro/account/settings.html"
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
                                            <a href="/saul-html-pro/account/settings.html"
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
                                <div class="menu-item px-5 my-1">
                                    <a href="/saul-html-pro/account/settings.html" class="menu-link px-5">
                                        Account Settings
                                    </a>
                                </div>
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
                            class="flex-column-fluid menu menu-sub-indention menu-column menu-rounded menu-active-bg mb-7 mt-15 mt-lg-0 mt-md-0">

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


                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">

                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar  pt-5 ">

                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container"
                                class="app-container  container-fluid d-flex align-items-stretch ">
                                <!--begin::Toolbar wrapper-->
                                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">

                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                                        <!--begin::Breadcrumb-->
                                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-6">

                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                                <a href="/saul-html-pro/index.html"
                                                    class="text-gray-500 text-hover-primary">
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
                                                Pages </li>
                                            <!--end::Item-->

                                            <!--begin::Item-->
                                            <li class="breadcrumb-item">
                                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                                            </li>
                                            <!--end::Item-->


                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                                Corporate </li>
                                            <!--end::Item-->

                                            <!--begin::Item-->
                                            <li class="breadcrumb-item">
                                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                                            </li>
                                            <!--end::Item-->


                                            <!--begin::Item-->
                                            <li class="breadcrumb-item text-gray-700">
                                                Sitemap </li>
                                            <!--end::Item-->


                                        </ul>
                                        <!--end::Breadcrumb-->

                                        <!--begin::Title-->
                                        <h1
                                            class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 lh-0">
                                            Sitemap
                                        </h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->

                                    <!--begin::Actions-->
                                    <a href="#" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_app">
                                        Create Project</span>
                                    </a>
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
                                <!--begin::Sitemap-->
                                <div class="card">
                                    <!--begin::Body-->
                                    <div class="card-body p-5 px-lg-19 py-lg-16">
                                        <!--begin::Heading-->
                                        <div class="mb-15">
                                            <!--begin::Title-->
                                            <h1 class="fs-2x text-gray-900 mb-6">Sitemap</h1>
                                            <!--end::Title-->

                                            <!--begin::Text-->
                                            <div class="fs-5 text-muted fw-semibold">
                                                First, a disclaimer – the entire process of writing a blog post often
                                                takes more than a couple of hours, even if you can type
                                                eighty words as per minute and your writing skills are sharp.
                                            </div>
                                            <!--end::Text-->
                                        </div>
                                        <!--end::Heading-->

                                        <!--begin::Row-->
                                        <div class="row g-10 mb-15">
                                            <!--begin::Col-->
                                            <div class="col-sm-4">
                                                <!--begin::Title-->
                                                <h3 class="fw-bold text-gray-900 mb-7">Premium Product</h3>
                                                <!--end::Title-->

                                                <!--begin::Links-->
                                                <div class="d-flex flex-column fw-semibold fs-4">
                                                    <a href="#" class="link-primary mb-6">Webiste Tempaltes</a>
                                                    <a href="#" class="link-primary mb-6">Wordpress Templates</a>
                                                    <a href="#" class="link-primary mb-6">Audio Files</a>
                                                    <a href="#" class="link-primary">JS Frameworks</a>
                                                </div>
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-sm-4">
                                                <!--begin::Title-->
                                                <h3 class="fw-bold text-gray-900 mb-7">Resources</h3>
                                                <!--end::Title-->

                                                <!--begin::Links-->
                                                <div class="d-flex flex-column fw-semibold fs-4">
                                                    <a href="#" class="link-primary mb-6">Our Blog</a>
                                                    <a href="#" class="link-primary mb-6">Our Tutorials</a>
                                                    <a href="#" class="link-primary mb-6">Announcements</a>
                                                    <a href="#" class="link-primary">Our News</a>
                                                </div>
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-sm-4">
                                                <!--begin::Title-->
                                                <h3 class="fw-bold text-gray-900 mb-7">Legal Matter</h3>
                                                <!--end::Title-->

                                                <!--begin::Links-->
                                                <div class="d-flex flex-column fw-semibold fs-4">
                                                    <a href="#" class="link-primary mb-6">Terms</a>
                                                    <a href="#" class="link-primary mb-6">Support Policy</a>
                                                    <a href="#" class="link-primary mb-6">Refund Policy</a>
                                                    <a href="#" class="link-primary">Privacy</a>
                                                </div>
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->

                                        <!--begin::Row-->
                                        <div class="row g-10 mb-18">
                                            <!--begin::Col-->
                                            <div class="col-sm-4">
                                                <!--begin::Title-->
                                                <h3 class="fw-bold text-gray-900 mb-7">Free Products</h3>
                                                <!--end::Title-->

                                                <!--begin::Links-->
                                                <div class="d-flex flex-column fw-semibold fs-4">
                                                    <a href="#" class="link-primary mb-6">Webiste Tempaltes</a>
                                                    <a href="#" class="link-primary mb-6">Wordpress Templates</a>
                                                    <a href="#" class="link-primary mb-6">Audio Files</a>
                                                    <a href="#" class="link-primary">Free Solutions</a>
                                                </div>
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-sm-4">
                                                <!--begin::Title-->
                                                <h3 class="fw-bold text-gray-900 mb-7">About</h3>
                                                <!--end::Title-->

                                                <!--begin::Links-->
                                                <div class="d-flex flex-column fw-semibold fs-4">
                                                    <a href="#" class="link-primary mb-6">About Us</a>
                                                    <a href="#" class="link-primary mb-6">Our Team</a>
                                                    <a href="#" class="link-primary mb-6">Careers</a>
                                                    <a href="#" class="link-primary">Contacts</a>
                                                </div>
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Col-->

                                            <!--begin::Col-->
                                            <div class="col-sm-4">
                                                <!--begin::Title-->
                                                <h3 class="fw-bold text-gray-900 mb-7">Studio</h3>
                                                <!--end::Title-->

                                                <!--begin::Links-->
                                                <div class="d-flex flex-column fw-semibold fs-4">
                                                    <a href="#" class="link-primary mb-6">Clients</a>
                                                    <a href="#" class="link-primary mb-6">Oppurtunaties</a>
                                                    <a href="#" class="link-primary mb-6">Hire Experts</a>
                                                    <a href="#" class="link-primary">Locations</a>
                                                </div>
                                                <!--end::Links-->
                                            </div>
                                            <!--end::Col-->
                                        </div>
                                        <!--end::Row-->
                                        <!--begin::Card-->
                                        <div class="card mb-4 bg-light text-center mb-4">
                                            <!--begin::Body-->
                                            <div class="card-body py-12">
                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/facebook-4.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->

                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/instagram-2-1.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->

                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/github.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->

                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/behance.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->

                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/pinterest-p.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->

                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/twitter.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->

                                                <!--begin::Icon-->
                                                <a href="#" class="mx-4">
                                                    <img src="/assets/media/svg/brand-logos/dribbble-icon-1.svg"
                                                        class="h-30px my-2" alt="" />
                                                </a>
                                                <!--end::Icon-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Body-->
                                </div>
                                <!--end::Sitemap-->

                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->

                    </div>
                    <!--end::Content wrapper-->


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


    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>