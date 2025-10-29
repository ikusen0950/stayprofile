<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title>Islanders App</title>
    <meta charset="utf-8" />
    <meta name="description" content="Islanders App" />
    <meta name="keywords" content="Islanders, App" />
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

        /* Fix header positioning with exact matching prototype background */
        #kt_app_header {
            top: var(--status-bar-height) !important;
            position: fixed !important;
            z-index: 1000 !important;
            width: 100% !important;
            background: #f4f4f4 !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
        }
        
        /* Ensure header container also has matching background */
        #kt_app_header_container {
            background: transparent !important;
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
    document.addEventListener('deviceready', async () => {
        const {
            PushNotifications
        } = Capacitor.Plugins;

        if (!PushNotifications) {
            console.warn('PushNotifications plugin not available');
            return;
        }

        const permission = await PushNotifications.requestPermissions();
        if (permission.receive !== 'granted') {
            console.warn('Push permission not granted');
            return;
        }

        await PushNotifications.register();

        // ✅ Save device token
        PushNotifications.addListener('registration', async (token) => {
            console.log('[Token] →', token.value);
            
            // Store token globally for button access
            window.currentFCMToken = token.value;
            localStorage.setItem('fcm_token', token.value);
            console.log('[Token Stored Globally] →', token.value);
            
            // Wait a moment to ensure user session is ready
            await new Promise(resolve => setTimeout(resolve, 1000));
            
            try {
                console.log('[Token Save] → Attempting to save token to server...');
                const res = await fetch('<?= base_url('api/save-token') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        token: token.value,
                        device_type: 'ios'
                    })
                });
                
                console.log('[Token Save] → Response status:', res.status, res.statusText);
                
                if (res.status === 401) {
                    console.log('[Token Save] → User not authenticated, will retry later...');
                    // Store token for manual registration via button
                    localStorage.setItem('pending_fcm_token', token.value);
                    return;
                }
                
                const result = await res.json();
                console.log('[Token Save Response] →', result);
                
                if (result.status === 'success') {
                    console.log('[Token Save] ✅ Token saved successfully!');
                    localStorage.removeItem('pending_fcm_token'); // Clear pending token
                } else {
                    console.log('[Token Save] ❌ Failed:', result.message);
                    // Store for later retry
                    localStorage.setItem('pending_fcm_token', token.value);
                }
                
            } catch (error) {
                console.error('[Token Save Error] →', error);
                // Store for later retry
                localStorage.setItem('pending_fcm_token', token.value);
            }
        });

        // ✅ Foreground push notification
        PushNotifications.addListener('pushNotificationReceived', (notification) => {
            console.log('[Foreground Push Received] →', notification);
        });

        // ✅ Handle background/killed notification tap
        PushNotifications.addListener('pushNotificationActionPerformed', (notification) => {
            const data = notification.notification.data;
            console.log('[Notification Tap] →', data);

            // ✅ Handle deep link or internal routing
            if (data && data.url) {
                // Optional: Use Capacitor App plugin for better navigation control
                if (Capacitor.Plugins.App) {
                    Capacitor.Plugins.App.getLaunchUrl().then((launchUrl) => {
                        console.log('[Launch URL] →', launchUrl);
                    });
                }

                // Navigate to URL inside app (external or internal)
                window.location.href = data.url;
            }
        });

        // ✅ Handle registration errors
        PushNotifications.addListener('registrationError', (error) => {
            console.error('[Registration Error] →', error);
        });
    });
    </script>
    
    <!-- Performance Optimization: Passive Event Listeners -->
    <script>
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
                options = { passive: true };
            }
            return originalAddEventListener.call(this, type, listener, options);
        };
    }
    </script>

    <!-- Deep Link Handler -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        if (window.Capacitor && window.Capacitor.Plugins?.App) {
            window.Capacitor.Plugins.App.addListener('appUrlOpen', function(event) {
                try {
                    const url = new URL(event.url);
                    const path = url.pathname;
                    console.log('App opened with URL path:', path);

                    if (path) {
                        // Navigate to that path within the app
                        window.location.href = path;
                    }
                } catch (e) {
                    console.error('Deep link handling failed:', e);
                }
            });
        } else {
            // This is expected when running in web browser (not mobile app)
            console.debug('Capacitor App plugin not available - running in web mode.');
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