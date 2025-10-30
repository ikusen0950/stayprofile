<!--begin::Header-->
<?= $this->include('layout/header.php') ?>
<!--begin::Header-->

<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid " id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar  pt-10 ">

            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">

                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column gap-1 me-3 mb-2">

                        <!--begin::Title-->
                        <h1
                            class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 lh-0  mb-6 mt-4">
                            Sitemap
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
                                Home </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                            </li>
                            <!--end::Item-->


                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700">
                                Dashboard </li>
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
                <!--begin::Sitemap-->
                <div class="card">
                    <!--begin::Body-->
                    <div class="card-body p-5 px-lg-19 py-lg-16">
                        <!--begin::Heading-->
                        <div class="mb-15">

                            <!-- Register Token Button -->
                            <div class="d-flex justify-content-end mb-5">
                                <button type="button" class="btn btn-success d-flex align-items-center"
                                    id="registerTokenBtn" onclick="registerFCMToken()">
                                    <i class="ki-duotone ki-notification-bing fs-2 text-white me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <span>Register Token</span>
                                </button>
                            </div>

                            <!--begin::Title-->
                            <h1 class="fs-2x text-gray-900 mb-6">Dashboard</h1>
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

                        <!--begin::Card-->
                        <div class="card mb-4 bg-light text-center mb-4">
                            <!--begin::Body-->
                            <div class="card-body py-12">
                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2"
                                        alt="" />
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2"
                                        alt="" />
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="" />
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="" />
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2"
                                        alt="" />
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="" />
                                </a>
                                <!--end::Icon-->

                                <!--begin::Icon-->
                                <a href="#" class="mx-4">
                                    <img src="/assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2"
                                        alt="" />
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
    <?= $this->include('layout/footer.php') ?>
    <!--end::Footer-->

    <!-- Agreement Modal (if needed) -->
    <?php if ($show_agreement_modal ?? false): ?>
    <div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable modal-fullscreen-md-down">
            <div class="modal-content" style="min-height: 90vh;">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title text-white d-flex align-items-center" id="agreementModalLabel">
                        <i class="ki-duotone ki-security-user fs-4x me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <span>Software License Agreement</span>
                    </h5>
                </div>
                <div class="modal-body" style="flex: 1; overflow-y: auto;">
                    <div class="agreement-content">
                        <h6 class="fw-bold">Islanders Finolhu Software License Agreement</h6>
                        <p class="text-muted">Last updated: <?= date('F j, Y') ?></p>

                        <div class="agreement-text"
                            style="max-height: 75vh; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                            <h6 class="fw-bold text-primary">1. ACCEPTANCE OF TERMS</h6>
                            <p>By accessing and using the Islanders Finolhu software system, you acknowledge that you
                                have
                                read, understood, and agree to be bound by the terms and conditions of this Software
                                License
                                Agreement.</p>

                            <h6 class="fw-bold text-primary">2. PERMITTED USE</h6>
                            <p>This software is provided for the exclusive use of authorized Islanders Finolhu employees
                                and
                                contractors. You may use this system solely for legitimate business purposes related to
                                your
                                employment or contract with Islanders Finolhu.</p>

                            <h6 class="fw-bold text-primary">3. RESTRICTIONS</h6>
                            <p>You agree NOT to:</p>
                            <ul class="list-styled">
                                <li>Share your login credentials with unauthorized persons</li>
                                <li>Attempt to reverse engineer, decompile, or disassemble the software</li>
                                <li>Use the system for any illegal or unauthorized purpose</li>
                                <li>Access data or functionality beyond your authorized scope</li>
                                <li>Download, copy, or distribute confidential company information without authorization
                                </li>
                            </ul>

                            <h6 class="fw-bold text-primary">4. DATA PROTECTION & PRIVACY</h6>
                            <p>You acknowledge that this system may contain sensitive and confidential information. You
                                agree to maintain the confidentiality of all data accessed through this system and
                                comply
                                with all applicable data protection regulations.</p>

                            <h6 class="fw-bold text-primary">5. MONITORING & COMPLIANCE</h6>
                            <p>Your use of this system may be monitored for security, compliance, and operational
                                purposes.
                                By using this system, you consent to such monitoring activities.</p>

                            <h6 class="fw-bold text-primary">6. TERMINATION</h6>
                            <p>This license is effective until terminated. Your access may be terminated immediately
                                without
                                notice if you violate any terms of this agreement or upon termination of your
                                employment/contract with Islanders Finolhu.</p>

                            <h6 class="fw-bold text-primary">7. LIMITATION OF LIABILITY</h6>
                            <p>Islanders Finolhu shall not be liable for any damages arising from the use or inability
                                to
                                use this software, except as required by applicable law.</p>

                            <div class="alert alert-warning d-flex align-items-center mt-4">
                                <i class="ki-duotone ki-information-5 fs-2x text-warning me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div>
                                    <strong>Important:</strong> You must accept this agreement to continue using the
                                    system.
                                    If you do not agree to these terms, please contact your system administrator.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-end">
                    <button type="button" class="btn btn-primary" id="acceptAgreementBtn">
                        <i class="ki-duotone ki-check fs-2 me-1">
                            <span class="path1"></span>
                        </i>
                        I Accept the Agreement
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <script>
    console.log('Show agreement modal:', <?= json_encode($show_agreement_modal ?? false) ?>);
    <?php if ($show_agreement_modal ?? false): ?>
    console.log('Agreement modal should show - initializing...');
    // Show the agreement modal on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, showing modal...');
        var modalElement = document.getElementById('agreementModal');
        console.log('Modal element found:', modalElement);

        if (modalElement) {
            // Try multiple ways to show the modal
            try {
                var agreementModal = new bootstrap.Modal(modalElement);
                agreementModal.show();
                console.log('Modal shown using Bootstrap 5 method');
            } catch (e) {
                console.error('Bootstrap Modal error:', e);
                // Fallback to jQuery if available
                if (typeof $ !== 'undefined') {
                    $('#agreementModal').modal('show');
                    console.log('Modal shown using jQuery fallback');
                } else {
                    // Manual show
                    modalElement.style.display = 'block';
                    modalElement.classList.add('show');
                    console.log('Modal shown manually');
                }
            }
        } else {
            console.error('Agreement modal element not found');
        }
    });

    // Handle agreement acceptance
    document.getElementById('acceptAgreementBtn').addEventListener('click', function() {
        this.disabled = true;
        this.innerHTML =
            '<span class="spinner-border spinner-border-sm me-2" role="status"></span>Processing...';

        fetch('<?= base_url('accept-agreement') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                body: JSON.stringify({
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal
                    var agreementModal = bootstrap.Modal.getInstance(document.getElementById(
                        'agreementModal'));
                    agreementModal.hide();

                    // Show success toast notification
                    Swal.fire({
                        icon: 'success',
                        title: 'Agreement Accepted!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });

                    // Show notification modal after agreement is accepted
                    <?php if ($show_notification_prompt ?? false): ?>
                    console.log('Agreement accepted, scheduling notification modal...');
                    setTimeout(() => {
                        showNotificationModal();
                    }, 1000); // Show notification modal 1 second after agreement acceptance
                    <?php endif; ?>
                } else {
                    // Show error
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message
                    });
                    this.disabled = false;
                    this.innerHTML =
                        '<i class="ki-duotone ki-check fs-2 me-1"><span class="path1"></span></i>I Accept the Agreement';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred. Please try again.'
                });
                this.disabled = false;
                this.innerHTML =
                    '<i class="ki-duotone ki-check fs-2 me-1"><span class="path1"></span></i>I Accept the Agreement';
            });
    });
    <?php endif; ?>
    </script>

    <style>
    /* Ensure proper fullscreen modal on mobile */
    @media (max-width: 767.98px) {
        #agreementModal .modal-fullscreen-md-down {
            width: 100vw;
            max-width: none;
            height: 100vh;
            margin: 0;
        }

        #agreementModal .modal-fullscreen-md-down .modal-content {
            height: 100vh;
            min-height: 100vh;
            border: 0;
            border-radius: 0;
        }

        #agreementModal .modal-body {
            flex: 1;
            overflow-y: auto;
            -webkit-overflow-scrolling: touch;
        }
    }

    /* Desktop height optimization */
    @media (min-width: 768px) {
        #agreementModal .modal-content {
            height: 85vh;
            min-height: 85vh;
        }
    }
    </style>

    <!-- Notification Permission Modal -->
    <div class="modal fade" id="notificationPermissionModal" tabindex="-1" aria-labelledby="notificationPermissionLabel"
        aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title text-white d-flex align-items-center" id="notificationPermissionLabel">
                        <i class="ki-duotone ki-notification-bing fs-2x me-3">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <span>Enable Push Notifications</span>
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="text-center py-5">
                        <i class="ki-duotone ki-notification-on fs-5x text-primary mb-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <h4 class="fw-bold mb-3">Stay Updated!</h4>
                        <p class="text-gray-700 mb-4">
                            Enable push notifications to receive instant updates about:
                        </p>
                        <ul class="list-unstyled text-start mb-4">
                            <li class="mb-2">
                                <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                New requests and assignments
                            </li>
                            <li class="mb-2">
                                <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Status updates and approvals
                            </li>
                            <li class="mb-2">
                                <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Important system announcements
                            </li>
                            <li class="mb-2">
                                <i class="ki-duotone ki-check-circle fs-2 text-success me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Team messages and reminders
                            </li>
                        </ul>
                        <div class="alert alert-info d-flex align-items-center">
                            <i class="ki-duotone ki-information-5 fs-2x text-info me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            <div class="text-start">
                                <small>You can change this setting anytime in your browser or profile settings.</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-light" id="skipNotificationBtn">
                        <i class="ki-duotone ki-cross fs-2 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Later
                    </button>
                    <!-- id="enableNotificationBtn"  -->
                    <button type="button" class="btn btn-primary" onclick="registerFCMToken()">
                        <i class="ki-duotone ki-notification-on fs-2 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        Enable Notifications
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Debug Dashboard Modal Flags  
    console.log('=== DASHBOARD DEBUG ===');
    console.log('show_agreement_modal:', <?= json_encode($show_agreement_modal ?? false) ?>);
    console.log('show_notification_prompt:', <?= json_encode($show_notification_prompt ?? false) ?>);
    console.log('User device_token:', <?= json_encode($user->device_token ?? 'undefined') ?>);
    console.log('User has_accepted_agreement:', <?= json_encode($user->has_accepted_agreement ?? 'undefined') ?>);
    console.log('======================');

    // Test button functionality on load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🔧 Dashboard loaded - checking button functionality...');

        const registerBtn = document.getElementById('registerTokenBtn');
        if (registerBtn) {
            console.log('✅ Register Token button found');

            // Test click handler
            registerBtn.addEventListener('click', function(e) {
                console.log('🖱️ Register Token button clicked!');
            });

        } else {
            console.error('❌ Register Token button NOT found!');
        }

        // Environment check
        const isCapacitor = typeof window.Capacitor !== 'undefined';
        console.log('📱 Environment:');
        console.log('- Capacitor available:', isCapacitor);
        console.log('- Platform:', isCapacitor ? window.Capacitor.getPlatform() : 'web');
        console.log('- PushNotifications available:', !!(isCapacitor && window.Capacitor.Plugins && window
            .Capacitor.Plugins.PushNotifications));
        console.log('- SweetAlert available:', typeof Swal !== 'undefined');
    });

    // Simple notification system - FCM logic is now in header.php like working app
    console.log('Show notification prompt flag:', <?= json_encode($show_notification_prompt ?? false) ?>);

    // Detect if running in Capacitor mobile app
    const isCapacitor = window.Capacitor !== undefined;
    const platform = isCapacitor ? window.Capacitor.getPlatform() : 'web';
    console.log('Platform detected:', platform);
    console.log('Is Capacitor:', isCapacitor);
    console.log('FCM registration handled automatically in header.php (like working CI4 app)');

    // Register FCM Token Button Function - iOS Compatible with Global Token Access
    async function registerFCMToken() {
        console.log('=== registerFCMToken called ===');

        const btn = document.getElementById('registerTokenBtn');
        if (!btn) {
            console.error('Register token button not found!');
            return;
        }

        const originalHTML = btn.innerHTML;

        // Check environment first
        const isCapacitor = typeof window.Capacitor !== 'undefined';
        const hasPlugins = isCapacitor && window.Capacitor.Plugins;
        const hasPushNotifications = hasPlugins && window.Capacitor.Plugins.PushNotifications;

        console.log('Environment check:');
        console.log('- isCapacitor:', isCapacitor);
        console.log('- hasPlugins:', hasPlugins);
        console.log('- hasPushNotifications:', hasPushNotifications);
        console.log('- Platform:', isCapacitor ? window.Capacitor.getPlatform() : 'web');

        try {
            // Show loading state
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Registering...';

            let fcmToken = null;

            if (isCapacitor && hasPushNotifications) {
                console.log('Capacitor app detected - checking for existing token...');

                // First, check if we already have a token from the global scope (set by header.php)
                if (window.currentFCMToken) {
                    fcmToken = window.currentFCMToken;
                    console.log('✅ Found token in global scope:', fcmToken);
                } else if (localStorage.getItem('fcm_token')) {
                    fcmToken = localStorage.getItem('fcm_token');
                    console.log('✅ Found token in localStorage:', fcmToken);
                } else if (localStorage.getItem('pending_fcm_token')) {
                    fcmToken = localStorage.getItem('pending_fcm_token');
                    console.log('✅ Found pending token (auth failed earlier):', fcmToken);
                } else {
                    console.log('No existing token found, triggering new registration...');

                    const PushNotifications = window.Capacitor.Plugins.PushNotifications;

                    // Request permissions first
                    console.log('Requesting push notification permissions...');
                    const permission = await PushNotifications.requestPermissions();
                    console.log('Permission result:', permission);

                    if (permission.receive === 'granted' || permission.receive === 'prompt') {
                        // Set up token listener with shorter timeout
                        console.log('Setting up registration listener...');

                        const tokenPromise = new Promise((resolve, reject) => {
                            const timeout = setTimeout(() => {
                                reject(new Error('Token registration timeout (5s)'));
                            }, 5000); // Shorter timeout

                            const listener = PushNotifications.addListener('registration', async (
                            token) => {
                                console.log('✅ Received new FCM token:', token.value);
                                clearTimeout(timeout);
                                listener.remove();
                                resolve(token.value);
                            });
                        });

                        // Register for notifications
                        console.log('Calling PushNotifications.register()...');
                        await PushNotifications.register();

                        try {
                            fcmToken = await tokenPromise;
                            console.log('Got token from new registration:', fcmToken);
                        } catch (timeoutError) {
                            console.log(
                                'Registration timeout, but that\'s okay - header.php handles automatic registration'
                                );

                            // Wait a moment and check again for token
                            await new Promise(resolve => setTimeout(resolve, 1000));

                            if (window.currentFCMToken) {
                                fcmToken = window.currentFCMToken;
                                console.log('✅ Found token after delay:', fcmToken);
                            } else if (localStorage.getItem('fcm_token')) {
                                fcmToken = localStorage.getItem('fcm_token');
                                console.log('✅ Found token in localStorage after delay:', fcmToken);
                            }
                        }
                    } else {
                        throw new Error(
                            'Push notification permission denied. Please enable in Settings > Notifications.');
                    }
                }

                if (!fcmToken) {
                    // Show informative message about automatic registration
                    const message =
                        'FCM token registration is handled automatically. Your device will receive notifications once the token is processed.';
                    console.log('ℹ️', message);

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'info',
                            title: 'Automatic Registration',
                            text: message,
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert(message);
                    }
                    return;
                }

                // Save token to backend
                console.log('Saving token to backend:', fcmToken);
                const response = await fetch('<?= base_url('api/save-token') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        token: fcmToken,
                        device_type: 'ios'
                    })
                });

                const result = await response.json();
                console.log('Token save result:', result);

                if (response.ok && result.status === 'success') {
                    const message = 'FCM token registered successfully!';
                    console.log('✅ Success:', message);

                    // Clear any pending tokens
                    localStorage.removeItem('pending_fcm_token');

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: message + (result.verified === 'yes' ? ' ✓ Verified in database.' : ''),
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert(message);
                    }

                    // Update button to show success
                    btn.innerHTML =
                        '<i class="ki-duotone ki-check fs-2 text-white"><span class="path1"></span><span class="path2"></span></i><span class="ms-2">Token Registered</span>';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-light-success');

                    // Refresh page after delay
                    setTimeout(() => {
                        location.reload();
                    }, 2000);

                } else {
                    throw new Error(result.message || 'Failed to save token to server');
                }
            } else if (isCapacitor) {
                // Capacitor but no PushNotifications plugin
                const message = 'PushNotifications plugin not available. Please check Capacitor configuration.';
                console.error('❌', message);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Plugin Missing',
                        html: message +
                            '<br><br>Check capacitor.config.ts and ensure @capacitor/push-notifications is installed.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert(message);
                }

            } else {
                // Web browser
                const message = 'This feature is for mobile apps. For web notifications, use browser settings.';
                console.log('ℹ️', message);

                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'info',
                        title: 'Web Browser',
                        text: message,
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert(message);
                }
            }

        } catch (error) {
            console.error('❌ Token registration error:', error);

            const errorMessage = error.message || 'Failed to register FCM token. Please try again.';

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    html: errorMessage + '<br><br>Check console for details.',
                    confirmButtonText: 'OK'
                });
            } else {
                alert('Error: ' + errorMessage);
            }

        } finally {
            // Restore button state
            btn.disabled = false;
            btn.innerHTML = originalHTML;
            console.log('=== registerFCMToken completed ===');
        }
    }

    // Simple notification modal function (FCM logic is in header.php)
    function showNotificationModal() {
        console.log('=== showNotificationModal called ===');
        var modalElement = document.getElementById('notificationPermissionModal');

        if (modalElement) {
            try {
                var notificationModal = new bootstrap.Modal(modalElement);
                notificationModal.show();
                console.log('Notification permission modal shown successfully');
            } catch (error) {
                console.error('Error showing notification modal:', error);
            }
        } else {
            console.error('Modal element notificationPermissionModal not found!');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        console.log('=== DOMContentLoaded fired ===');

        // Check if notification prompt should be shown
        const showNotificationPrompt = <?= json_encode($show_notification_prompt ?? false) ?>;
        console.log('showNotificationPrompt flag:', showNotificationPrompt);

        // Check if agreement modal is also being shown
        const showAgreementModal = <?= json_encode($show_agreement_modal ?? false) ?>;
        console.log('showAgreementModal flag:', showAgreementModal);

        // Only proceed if notification prompt should be shown
        if (showNotificationPrompt) {
            if (!showAgreementModal) {
                console.log('No agreement modal, scheduling notification modal...');
                // No agreement modal, show notification modal after delay as usual
                setTimeout(() => {
                    console.log('Timeout fired, calling showNotificationModal...');
                    showNotificationModal();
                }, 1000); // 1 second delay
            } else {
                console.log('Agreement modal is showing, notification modal will wait...');
            }
        } else {
            console.log('Notification prompt not needed (user has device token)');
        }
        // If agreement modal is shown, the notification modal will be triggered after agreement acceptance
        // (handled in the agreement acceptance success callback above)

        // Handle "Enable Notifications" button - Simple version (FCM logic is in header.php)
        // document.getElementById('enableNotificationBtn').addEventListener('click', async function() {
        //     const btn = this;
        //     btn.disabled = true;
        //     btn.innerHTML =
        //     '<span class="spinner-border spinner-border-sm me-2"></span>Enabling...';

        //     try {
        //         if (isCapacitor) {
        //             console.log(
        //                 'Capacitor app: FCM registration handled automatically in header.php');

        //             // Just trigger the deviceready event manually to activate the header's FCM system
        //             const event = new Event('deviceready');
        //             document.dispatchEvent(event);

        //             // Show success message
        //             closeNotificationModal();
        //             Swal.fire({
        //                 icon: 'success',
        //                 title: 'Enabled!',
        //                 text: 'Push notifications are being set up automatically.',
        //                 toast: true,
        //                 position: 'top-end',
        //                 showConfirmButton: false,
        //                 timer: 3000,
        //                 timerProgressBar: true
        //             });

        //             // Reload page after delay
        //             setTimeout(() => location.reload(), 2000);
        //         } else {
        //             // Web browser - simple notification request
        //             const permission = await Notification.requestPermission();
        //             if (permission === 'granted') {
        //                 closeNotificationModal();
        //                 Swal.fire({
        //                     icon: 'success',
        //                     title: 'Enabled!',
        //                     text: 'Browser notifications have been enabled.',
        //                     toast: true,
        //                     position: 'top-end',
        //                     showConfirmButton: false,
        //                     timer: 3000,
        //                     timerProgressBar: true
        //                 });
        //                 setTimeout(() => location.reload(), 2000);
        //             } else {
        //                 throw new Error('Browser notification permission denied');
        //             }
        //         }
        //     } catch (error) {
        //         console.error('Error enabling notifications:', error);

        //         Swal.fire({
        //             icon: 'error',
        //             title: 'Error',
        //             text: error.message ||
        //                 'Failed to enable notifications. Please try again.',
        //             confirmButtonText: 'OK'
        //         });

        //         btn.disabled = false;
        //         btn.innerHTML =
        //             '<i class="ki-duotone ki-notification-on fs-2 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Enable Notifications';
        //     }
        // });

        // Handle "Maybe Later" button
        document.getElementById('skipNotificationBtn').addEventListener('click', function() {
            closeNotificationModal();
            Swal.fire({
                icon: 'info',
                title: 'Skipped',
                text: 'You can enable notifications anytime from your profile settings.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });

        // Simple close modal function (complex FCM logic moved to header.php)

        function closeNotificationModal() {
            var modalElement = document.getElementById('notificationPermissionModal');
            if (modalElement) {
                var modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                }
            }
        }
    });
    </script>