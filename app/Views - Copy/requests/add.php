<?= $this->include('layout/header.php') ?>

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
.mobile-request-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-request-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-request-card:active {
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

/* Better Select2 dropdown positioning in modals */
.select2-container--bootstrap5 .select2-dropdown {
    z-index: 1060;
}

/* Color preview styles */
.color-preview {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid var(--bs-border-color);
    display: inline-block;
    margin-right: 8px;
}
   
    .coming-soon-ribbon {
    position: absolute;
    top: 5px;
    right: -20px;
    background: #78829D;
    color: white;
    padding: 8px 30px; /* Adjusted padding */
    font-size: 9px; /* Smaller text */
    font-weight: bold;
    text-transform: uppercase;
    transform: rotate(40deg);
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.2);

    display: flex;
    align-items: center;
    justify-content: center;
    width: 100px; /* Control width */
    height: 30px; /* Control height */
}

</style>



<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
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

                
                <!--begin::Row-->
                <div class="row gy-5 g-xl-10 mt-2 mt-xl-0">
                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" id="add_exit_pass_button" class="card hover-elevate-up shadow-sm parent-hover" data-bs-toggle="modal" data-bs-target="#exitPassModal">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center">
                                    <i class="ki-duotone ki-badge text-gray-600 fs-3x parent-hover-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    Exit Pass
                                </span>
                            </div>
                        </a>
                    </div>
                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" id="add_transfer_button" class="card hover-elevate-up shadow-sm parent-hover" data-bs-toggle="modal" data-bs-target="#transferModal">
                            <div class="card-body d-flex align-items-center">
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-note-2 fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    Transfer
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" class="card hover-elevate-up shadow-sm position-relative overflow-hidden disabled" tabindex="-1" aria-disabled="true">
                            <div class="card-body d-flex align-items-center">
                                 <!-- Ribbon -->
                                <div class="coming-soon-ribbon">Coming Soon</div>
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-wrench fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    Repair
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" class="card hover-elevate-up shadow-sm position-relative overflow-hidden disabled" tabindex="-1" aria-disabled="true">
                            <div class="card-body d-flex align-items-center">
                                 <!-- Ribbon -->
                                <div class="coming-soon-ribbon">Coming Soon</div>
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-wifi-square fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    IT Request
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" class="card hover-elevate-up shadow-sm position-relative overflow-hidden disabled" tabindex="-1" aria-disabled="true">
                            <div class="card-body d-flex align-items-center">
                                 <!-- Ribbon -->
                                <div class="coming-soon-ribbon">Coming Soon</div>
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-profile-user fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    FNF Form
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" class="card hover-elevate-up shadow-sm position-relative overflow-hidden disabled" tabindex="-1" aria-disabled="true">
                            <div class="card-body d-flex align-items-center">
                                 <!-- Ribbon -->
                                <div class="coming-soon-ribbon">Coming Soon</div>
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-purchase fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    Micros Form
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" class="card hover-elevate-up shadow-sm position-relative overflow-hidden disabled" tabindex="-1" aria-disabled="true">
                            <div class="card-body d-flex align-items-center">
                                 <!-- Ribbon -->
                                <div class="coming-soon-ribbon">Coming Soon</div>
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-badge fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    Uniform Request
                                </span>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 col-sm-6 col-xl-2 mb-xl-10">
                        <a href="#" class="card hover-elevate-up shadow-sm position-relative overflow-hidden disabled" tabindex="-1" aria-disabled="true">
                            <div class="card-body d-flex align-items-center">
                                 <!-- Ribbon -->
                                <div class="coming-soon-ribbon">Coming Soon</div>
                                <!-- Icon -->
                                <span class="svg-icon d-flex align-items-center ">
                                    <i class="ki-duotone ki-chart-pie-3 fs-3x text-gray-600 parent-hover-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                </span>
                                <!-- Text -->
                                <span class="ms-3 text-gray-700 parent-hover-primary fs-4  fw-bold">
                                    Cake Form
                                </span>
                            </div>
                        </a>
                    </div>

                </div>
                <!--end::Row-->
                
            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->
    </div>
    <!--end::Content wrapper-->
</div>
<!--end::Main-->


<!-- Modals for requests -->
<?= $this->include('requests/create_exit_pass_modal') ?>
<?= $this->include('requests/create_transfer_modal') ?>

<script>
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
    localStorage.removeItem('user');
    sessionStorage.clear();
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
</script>

<?= $this->include('layout/footer.php') ?>