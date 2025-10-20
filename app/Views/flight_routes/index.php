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
.mobile-FlightRoute-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-FlightRoute-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-FlightRoute-card:active {
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

/* Fix modal z-index to ensure they appear above everything */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1050 !important;
}

/* Ensure modals are properly positioned */
.modal.fade .modal-dialog {
    transition: transform 0.3s ease-out;
    transform: translate(0, -50px);
}

.modal.show .modal-dialog {
    transform: none;
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2" style="top: 60px !important;">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">Flight Routes</h1>
            </div>
            <div class="row align-items-stretch">
                <div class="col-10">
                    <div class="position-relative h-100">
                        <i
                            class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="mobile_search" class="form-control form-control-solid ps-10 h-100"
                            placeholder="Search Flight Routes..." value="<?= esc($search) ?>" />
                    </div>
                </div>
                <div class="col-2">
                    <?php if ($permissions['canCreate']): ?>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#createFlightRouteModal"
                        class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center"
                        style="min-height: 48px;">
                        <i class="ki-duotone ki-plus-square fs-3x">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </button>
                    <?php else: ?>
                    <div class="btn btn-light-secondary w-100 h-100 d-flex align-items-center justify-content-center disabled"
                        style="min-height: 48px;" title="No permission to create Flight Routes">
                        <i class="ki-duotone ki-lock fs-3x">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                    <?php endif; ?>
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
            <?php if (!empty($FlightRoutes)): ?>
            <?php foreach ($FlightRoutes as $index => $FlightRoute): ?>
            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                <div class="card mobile-FlightRoute-card" data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">
                    <div class="card-body p-4">
                        <!-- Flight Route Header -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <small class="text-muted text-uppercase">#<?= esc($FlightRoute['id']) ?></small>
                            </div>
                            <div class="ms-3 d-flex gap-2">
                                <?php if (!empty($FlightRoute['status_name'])): ?>
                                    <?php 
                                    // Use custom color if available for mobile cards
                                    if (!empty($FlightRoute['status_color'])) {
                                        // Convert hex color to RGB for light background
                                        $hex = ltrim($FlightRoute['status_color'], '#');
                                        $r = hexdec(substr($hex, 0, 2));
                                        $g = hexdec(substr($hex, 2, 2));
                                        $b = hexdec(substr($hex, 4, 2));
                                        $lightBg = "rgba($r, $g, $b, 0.1)";
                                        $textColor = $FlightRoute['status_color'];
                                        $mobileBadgeStyle = "background-color: $lightBg; color: $textColor;";
                                    } else {
                                        $mobileBadgeStyle = "";
                                    }
                                    ?>
                                    <?php if (!empty($FlightRoute['status_color'])): ?>
                                    <span class="badge fw-bold fs-8" style="<?= $mobileBadgeStyle ?>">
                                        <?= strtoupper(esc($FlightRoute['status_name'])) ?>
                                    </span>
                                    <?php else: ?>
                                    <span class="badge badge-light-success fw-bold fs-8">
                                        <?= strtoupper(esc($FlightRoute['status_name'])) ?>
                                    </span>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <span class="badge badge-light-primary fw-bold">Flight Route</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-start mb-2 mt-4">
                            <div class="flex-grow-1">
                                <strong class="me-5 text-uppercase text-truncate"><?= esc($FlightRoute['name']) ?></strong>
                            </div>
                        </div>

                        <!-- Flight Route Details -->
                        <?php if (!empty($FlightRoute['description'])): ?>
                        <p class="text-muted mb-2 mt-2"><?= esc($FlightRoute['description']) ?></p>
                        <?php endif; ?>
                        <?php if (!empty($FlightRoute['type'])): ?>
                        <div class="mb-2">
                            <span class="badge badge-light-info">Type: <?= esc($FlightRoute['type']) ?></span>
                        </div>
                        <?php endif; ?>

                        <!-- Flight Route Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="d-flex flex-column">
                                <small class="text-muted">
                                    <?= !empty($FlightRoute['created_by_name']) ? esc($FlightRoute['created_by_name']) : 'System' ?>
                                </small>
                            </div>
                            <small class="text-muted"><?= date('M d, Y', strtotime($FlightRoute['created_at'])) ?></small>
                        </div>

                        <!-- Expandable Actions (initially hidden) -->
                        <div class="mobile-actions mt-3 pt-3 border-top d-none">
                            <div class="row g-2">
                                <?php if ($permissions['canView']): ?>
                                <div class="col-4">
                                    <button type="button"
                                        class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-FlightRoute-btn"
                                        data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">
                                        <i class="ki-duotone ki-eye fs-1 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        View
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if ($permissions['canEdit']): ?>
                                <div class="col-4">
                                    <button type="button"
                                        class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-FlightRoute-btn"
                                        data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">
                                        <i class="ki-duotone ki-pencil fs-1 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Edit
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if ($permissions['canDelete']): ?>
                                <div class="col-4">
                                    <button
                                        class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-FlightRoute-btn"
                                        data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">
                                        <i class="ki-duotone ki-trash fs-1 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        Delete
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="d-flex flex-column align-items-center justify-content-center py-10">
                    <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3 ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <h6 class="fw-bold text-gray-700 mb-2">No Flight Routes found</h6>
                    <p class="fs-7 text-gray-500 mb-4">Start by creating your first Flight Route entry</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Loading indicator for infinite scroll -->
        <div id="loading-indicator" class="text-center py-4 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading more Flight Routes...</p>
        </div>

        <!-- No more data indicator -->
        <div id="no-more-data" class="text-center py-4 d-none">
            <p class="text-muted">No more Flight Routes to load</p>
        </div>
    </div>
</div>
<!--end::Mobile UI-->

<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid d-none d-lg-flex" id="kt_app_main">
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
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Search Flight Routes..."
                                    value="<?= esc($search) ?>" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-FlightRoute-table-toolbar="base">
                                <!--begin::Add Flight Route-->
                                <?php if ($permissions['canCreate']): ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createFlightRouteModal">
                                    <i class="ki-duotone ki-plus fs-2"></i>Add Flight Route
                                </button>
                                <?php endif; ?>
                                <!--end::Add Flight Route-->
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_FlightRoute_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div
                                                class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#kt_FlightRoute_table .form-check-input"
                                                    value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-20px">#</th>
                                        <th class="min-w-150px">Flight Route Name</th>
                                        <th class="min-w-200px">Description</th>
                                        <th class="min-w-100px">Type</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-120px">Created By</th>
                                        <th class="min-w-120px">Updated By</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <?php if (!empty($FlightRoutes)): ?>
                                    <?php foreach ($FlightRoutes as $FlightRoute): ?>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?= esc($FlightRoute['id']) ?>" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->

                                        <!--begin::ID-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">#<?= esc($FlightRoute['id']) ?></small>
                                            </div>
                                        </td>
                                        <!--end::ID-->
                                     
                                        <!--begin::Flight Route Name-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="badge badge-light-primary fw-bold"
                                                    style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                                    <?= strtoupper(esc($FlightRoute['name'])) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <!--end::Flight Route Name-->

                                        <!--begin::Description-->
                                        <td>
                                            <div class="text-gray-600">
                                                <?= esc($FlightRoute['description']) ?>
                                            </div>
                                        </td>
                                        <!--end::Description-->

                                        <!--begin::Type-->
                                        <td>
                                            <div class="text-gray-600">
                                                <?= !empty($FlightRoute['type']) ? esc($FlightRoute['type']) : '-' ?>
                                            </div>
                                        </td>
                                        <!--end::Type-->

                                        <!--begin::Status-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($FlightRoute['status_name'])): ?>
                                                    <?php 
                                                    // Use custom color if available, otherwise fallback to status-based colors
                                                    if (!empty($FlightRoute['status_color'])) {
                                                        // Convert hex color to RGB for light background
                                                        $hex = ltrim($FlightRoute['status_color'], '#');
                                                        $r = hexdec(substr($hex, 0, 2));
                                                        $g = hexdec(substr($hex, 2, 2));
                                                        $b = hexdec(substr($hex, 4, 2));
                                                        $lightBg = "rgba($r, $g, $b, 0.1)";
                                                        $textColor = $FlightRoute['status_color'];
                                                        $badgeStyle = "background-color: $lightBg; color: $textColor; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                    } else {
                                                        // Fallback to default styling
                                                        $badgeStyle = "padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                    }
                                                    ?>
                                                    <?php if (!empty($FlightRoute['status_color'])): ?>
                                                    <span class="badge fw-bold" style="<?= $badgeStyle ?>">
                                                        <?= strtoupper(esc($FlightRoute['status_name'])) ?>
                                                    </span>
                                                    <?php else: ?>
                                                    <span class="badge badge-light-success fw-bold" style="<?= $badgeStyle ?>">
                                                        <?= strtoupper(esc($FlightRoute['status_name'])) ?>
                                                    </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                <span class="badge badge-light-secondary fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">N/A</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Status-->

                                        <!--begin::Created By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($FlightRoute['created_by_name'])): ?>
                                                <span class="text-muted"><?= esc($FlightRoute['created_by_name']) ?></span>
                                                <small
                                                    class="text-muted"><?= date('d M Y \a\t H:i', strtotime($FlightRoute['created_at'])) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Created By-->
                                        <!--begin::Updated By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($FlightRoute['updated_by_name']) && !empty($FlightRoute['updated_at'])): ?>
                                                <span class="text-muted"><?= esc($FlightRoute['updated_by_name']) ?></span>
                                                <small
                                                    class="text-muted"><?= date('d M Y \a\t H:i', strtotime($FlightRoute['updated_at'])) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Updated By-->

                                        <!--begin::Action-->
                                        <td class="text-end">
                                            <a href="#"
                                                class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                Actions
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                            </a>
                                            <!--begin::Menu-->
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canView']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 view-FlightRoute-btn"
                                                        data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">View</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canEdit']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 edit-FlightRoute-btn"
                                                        data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">Edit</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canDelete']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 delete-FlightRoute-btn"
                                                        data-FlightRoute-id="<?= esc($FlightRoute['id']) ?>">Delete</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                            </div>
                                            <!--end::Menu-->
                                        </td>
                                        <!--end::Action-->
                                    </tr>
                                    <!--end::Table row-->
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <!--begin::No results-->
                                    <tr>
                                        <td colspan="7" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fw-bold text-gray-700 mb-2">No Flight Routes found</div>
                                                <div class="text-gray-500">Start by creating your first Flight Route entry
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
</div>
<!--end::Main-->

<!-- Include Modals -->
<?= $this->include('flight_routes/create_modal') ?>
<?= $this->include('flight_routes/edit_modal') ?>
<?= $this->include('flight_routes/view_modal') ?>

<script>
// Global variables
let currentPage = 1;
let isLoading = false;
let hasMoreData = true;
let searchTimeout;

// Check if there are server-rendered cards and adjust currentPage
document.addEventListener('DOMContentLoaded', function() {
    const existingCards = document.querySelectorAll('#mobile-cards-container .mobile-FlightRoute-card');
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
                if (mutation.type === 'attributes' && mutation.attributeName ===
                    'data-kt-drawer') {
                    const isDrawerOn = sidebar.getAttribute('data-kt-drawer') === 'on';
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
                    const isDrawerOn = sidebar.getAttribute('data-kt-drawer') === 'on';
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
                loadFlightRoutes(true, query);
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

    // Load initial FlightRoutes for mobile
    const mobileContainer = document.getElementById('mobile-cards-container');
    if (mobileContainer) {
        // Only load initial data if container is empty (no server-rendered content)
        const existingCards = mobileContainer.querySelectorAll('.mobile-FlightRoute-card');
        if (existingCards.length === 0) {
            loadFlightRoutes(false);
        }

        // Infinite scroll for mobile
        let scrollTimeout;
        window.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(() => {
                if (!isLoading && hasMoreData) {
                    const scrollPosition = window.innerHeight + window.scrollY;
                    const documentHeight = document.documentElement.offsetHeight;

                    if (scrollPosition >= documentHeight - 1000) {
                        loadFlightRoutes(false, mobileSearch?.value || '');
                    }
                }
            }, 100);
        });
    }

    // Handle view FlightRoute
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-FlightRoute-btn')) {
            e.preventDefault();
            const FlightRouteId = e.target.closest('.view-FlightRoute-btn').getAttribute('data-FlightRoute-id');
            viewFlightRoute(FlightRouteId);
        }
    });

    // Handle edit FlightRoute
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-FlightRoute-btn')) {
            e.preventDefault();
            const FlightRouteId = e.target.closest('.edit-FlightRoute-btn').getAttribute('data-FlightRoute-id');
            editFlightRoute(FlightRouteId);
        }
    });

    // Handle delete FlightRoute
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-FlightRoute-btn')) {
            e.preventDefault();
            const FlightRouteId = e.target.closest('.delete-FlightRoute-btn').getAttribute('data-FlightRoute-id');
            deleteFlightRoute(FlightRouteId);
        }
    });

});

function loadFlightRoutes(reset = false, search = '') {
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

    const url = `/flight-routes/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

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
                    renderFlightRoutes(data.data);
                    currentPage++;
                    hasMoreData = data.hasMore;

                    // Reinitialize AOS for new elements
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                } else {
                    hasMoreData = false;
                    if (currentPage === 1) {
                        showNoFlightRoutesMessage();
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

function renderFlightRoutes(FlightRoutes) {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    FlightRoutes.forEach((FlightRoute, index) => {
        const FlightRouteCard = createFlightRouteCard(FlightRoute, (currentPage - 1) * 10 + index);
        container.appendChild(FlightRouteCard);
    });

    // Reinitialize mobile cards after adding new ones
    initMobileCards();
}

function createFlightRouteCard(FlightRoute, index) {
    const col = document.createElement('div');
    col.className = 'col-12 mb-3';
    col.setAttribute('data-aos', 'fade-up');
    col.setAttribute('data-aos-delay', (index * 100).toString());
    col.setAttribute('data-aos-duration', '600');

    const description = FlightRoute.description ?
        `<p class="text-muted mb-0 mt-3">${FlightRoute.description}</p>` : '';

    const createdByName = FlightRoute.created_by_name || 'System';

    const createdAt = new Date(FlightRoute.created_at).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    });

    // Create action buttons based on permissions
    let actionButtons = '';
    <?php if ($permissions['canView']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-FlightRoute-btn" data-FlightRoute-id="${FlightRoute.id}">
                <i class="ki-duotone ki-eye fs-1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                </i>
                View
            </button>
        </div>
    `;
    <?php endif; ?>
    <?php if ($permissions['canEdit']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-FlightRoute-btn" data-FlightRoute-id="${FlightRoute.id}">
                <i class="ki-duotone ki-pencil fs-1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                Edit
            </button>
        </div>
    `;
    <?php endif; ?>
    <?php if ($permissions['canDelete']): ?>
    actionButtons += `
        <div class="col-4">
            <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-FlightRoute-btn" data-FlightRoute-id="${FlightRoute.id}">
                <i class="ki-duotone ki-trash fs-1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
                Delete
            </button>
        </div>
    `;
    <?php endif; ?>

    // Only show actions section if user has any permissions
    const actionsSection = actionButtons ? `
        <!-- Expandable Actions (initially hidden) -->
        <div class="mobile-actions mt-3 pt-3 border-top d-none">
            <div class="row g-2">
                ${actionButtons}
            </div>
        </div>
    ` : '';

    col.innerHTML = `
        <div class="card mobile-FlightRoute-card" data-FlightRoute-id="${FlightRoute.id}">
            <div class="card-body p-4">
                <!-- FlightRoute Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${FlightRoute.id}</small>
                    </div>
                    <div class="ms-3 d-flex gap-2">
                        ${FlightRoute.status_name ? `
                            ${FlightRoute.status_color ? 
                                `<span class="badge fw-bold fs-8" style="background-color: ${FlightRoute.status_color}1a; color: ${FlightRoute.status_color};">${FlightRoute.status_name.toUpperCase()}</span>` :
                                `<span class="badge badge-light-success fw-bold fs-8">${FlightRoute.status_name.toUpperCase()}</span>`
                            }
                        ` : ''}
                        <span class="badge badge-light-primary fw-bold">Flight Route</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-start mb-2 mt-4">
                    <div class="flex-grow-1">
                        <strong class="me-5 text-uppercase text-truncate">${FlightRoute.name}</strong>
                    </div>
                </div>

                <!-- Flight Route Details -->
                ${FlightRoute.description ? `<p class="text-muted mb-2 mt-2">${FlightRoute.description}</p>` : ''}
                ${FlightRoute.type ? `<div class="mb-2"><span class="badge badge-light-info">Type: ${FlightRoute.type}</span></div>` : ''}

                <!-- FlightRoute Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-flex flex-column">
                        <small class="text-muted">${createdByName}</small>
                    </div>
                    <small class="text-muted">${createdAt}</small>
                </div>

                ${actionsSection}
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

function showNoFlightRoutesMessage() {
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
            <h6 class="fw-bold text-gray-700 mb-2">No Flight Routes found</h6>
            <p class="fs-7 text-gray-500 mb-4">Start by creating your first Flight Route entry</p>
        </div>
    `;
    container.appendChild(noDataDiv);
}

// FlightRoute CRUD functions
function viewFlightRoute(FlightRouteId) {
    secureFetch(`/flight-routes/show/${FlightRouteId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate view modal
                populateViewModal(data.data);
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewFlightRouteModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load Flight Route details', 'error');
        });
}

function editFlightRoute(FlightRouteId) {
    secureFetch(`/flight-routes/show/${FlightRouteId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate edit modal
                populateEditModal(data.data);
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editFlightRouteModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load Flight Route details', 'error');
        });
}

function deleteFlightRoute(FlightRouteId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            secureFetch(`/flight-routes/delete/${FlightRouteId}`, {
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
                        Swal.fire('Deleted!', data.message, 'success');
                        // Reload the page
                        window.location.reload();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to delete Flight Route', 'error');
                });
        }
    });
}

// Mobile card click functionality
function initMobileCards() {
    // Remove existing listeners to prevent duplicates
    document.querySelectorAll('.mobile-FlightRoute-card').forEach(function(card) {
        card.replaceWith(card.cloneNode(true));
    });

    document.querySelectorAll('.mobile-FlightRoute-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.mobile-actions') || e.target.closest('button') || e.target.closest(
                    'a')) {
                return;
            }

            const actions = this.querySelector('.mobile-actions');
            const isExpanded = !actions.classList.contains('d-none');

            document.querySelectorAll('.mobile-actions').forEach(function(action) {
                action.classList.add('d-none');
            });

            if (!isExpanded) {
                actions.classList.remove('d-none');
            }
        });
    });
}

// Initialize mobile cards on page load
document.addEventListener('DOMContentLoaded', function() {
    initMobileCards();
});

// Modal population functions
function populateViewModal(FlightRoute) {
    // Basic FlightRoute info
    document.getElementById('view_flight_route_name').textContent = FlightRoute.name;
    
    // Description
    const description = document.getElementById('view_description');
    const descriptionSection = document.getElementById('view_description_section');
    
    if (FlightRoute.description && FlightRoute.description.trim() !== '') {
        description.textContent = FlightRoute.description;
        descriptionSection.style.display = 'block';
    } else {
        description.textContent = 'No description provided';
        descriptionSection.style.display = 'block';
    }
    
    // Type
    const type = document.getElementById('view_type');
    const typeSection = document.getElementById('view_type_section');
    
    if (FlightRoute.type && FlightRoute.type.trim() !== '') {
        type.textContent = FlightRoute.type;
        typeSection.style.display = 'block';
    } else {
        type.textContent = 'No type specified';
        typeSection.style.display = 'block';
    }
    
    // Audit info
    document.getElementById('view_created_by').textContent = FlightRoute.created_by_name || 'System';
    document.getElementById('view_created_at').textContent = FlightRoute.created_at ? 
        new Date(FlightRoute.created_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) : '-';
    
    // Updated info (show/hide based on availability)
    const updatedBySection = document.getElementById('view_updated_by_section');
    const updatedAtSection = document.getElementById('view_updated_at_section');
    
    if (FlightRoute.updated_by_name) {
        document.getElementById('view_updated_by').textContent = FlightRoute.updated_by_name;
        updatedBySection.style.display = 'block';
    } else {
        updatedBySection.style.display = 'none';
    }
    
    if (FlightRoute.updated_at) {
        document.getElementById('view_updated_at').textContent = new Date(FlightRoute.updated_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        updatedAtSection.style.display = 'block';
    } else {
        updatedAtSection.style.display = 'none';
    }
    
    // Set FlightRoute ID for edit button if it exists
    const editBtn = document.getElementById('view_edit_btn');
    if (editBtn) {
        editBtn.setAttribute('data-flight-route-id', FlightRoute.id);
    }
}

function populateEditModal(FlightRoute) {
    document.getElementById('edit_flight_route_id').value = FlightRoute.id;
    document.querySelector('#editFlightRouteForm input[name="name"]').value = FlightRoute.name;
    document.querySelector('#editFlightRouteForm textarea[name="description"]').value = FlightRoute.description || '';
    
    // Set type dropdown
    const typeSelect = document.querySelector('#editFlightRouteForm select[name="type"]');
    if (typeSelect && FlightRoute.type) {
        typeSelect.value = FlightRoute.type;
    }
    
    // Set status dropdown
    const statusSelect = document.querySelector('#editFlightRouteForm select[name="status_id"]');
    if (statusSelect && FlightRoute.status_id) {
        statusSelect.value = FlightRoute.status_id;
    }
}
</script>

<!-- Global functions needed by modals -->
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
</script>

<?= $this->include('layout/footer.php') ?>