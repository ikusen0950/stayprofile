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
.mobile-position-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-position-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-position-card:active {
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
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2" style="top: 55px !important;">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">Requests</h1>
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
                            placeholder="Search requests..." value="<?= esc($search) ?>" />
                    </div>
                </div>
                <div class="col-2">
                    <?php if ($permissions['canCreate']): ?>
                    <a href="/requests/add" class="btn btn-primary w-100 h-100 d-flex align-items-center justify-content-center" style="min-height: 48px;">
                        <i class="ki-duotone ki-plus-square fs-3x">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                    </a>
                    <?php else: ?>
                    <div class="btn btn-light-secondary w-100 h-100 d-flex align-items-center justify-content-center disabled"
                        style="min-height: 48px;" title="No permission to create requests">
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

        <!-- Mobile Request Cards -->
        <div class="row mt-2" id="mobile-cards-container">
            <?php if (!empty($requests)): ?>
            <?php foreach ($requests as $index => $request): ?>
            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                <div class="card mobile-request-card" data-request-id="<?= esc($request['id']) ?>">
                    <div class="card-body p-4">
                        <!-- Request Header -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <small class="text-muted text-uppercase">#<?= esc($request['id']) ?></small>
                            </div>
                            <div class="ms-3 d-flex gap-2">
                                <?php if (!empty($request['status_name'])): ?>
                                <?php 
                                    // Use custom color if available for mobile cards
                                    if (!empty($request['status_color'])) {
                                        // Convert hex color to RGB for light background
                                        $hex = ltrim($request['status_color'], '#');
                                        $r = hexdec(substr($hex, 0, 2));
                                        $g = hexdec(substr($hex, 2, 2));
                                        $b = hexdec(substr($hex, 4, 2));
                                        $lightBg = "rgba($r, $g, $b, 0.1)";
                                        $textColor = $request['status_color'];
                                        $mobileBadgeStyle = "background-color: $lightBg; color: $textColor;";
                                    } else {
                                        $mobileBadgeStyle = "";
                                    }
                                ?>
                                <?php if (!empty($request['status_color'])): ?>
                                <span class="badge fw-bold fs-8" style="<?= $mobileBadgeStyle ?>">
                                    <?= strtoupper(esc($request['status_name'])) ?>
                                </span>
                                <?php else: ?>
                                <span class="badge badge-light-success fw-bold fs-8">
                                    <?= strtoupper(esc($request['status_name'])) ?>
                                </span>
                                <?php endif; ?>
                                <?php endif; ?>
                                <span class="badge badge-light-info fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                    <?php 
                                    $type = $request['type'] ?? '1';
                                    switch($type) {
                                        case '1':
                                            echo 'EXIT PASS';
                                            break;
                                        case '2':
                                            echo 'TRANSFER';
                                            break;
                                        case '3':
                                            echo 'LEAVE';
                                            break;
                                        default:
                                            echo 'UNKNOWN';
                                    }
                                    ?>
                                </span>
                            </div>
                        </div>

                        <!-- Islander Info -->
                        <div class="d-flex align-items-center mb-4 mt-4">
                            <?php 
                            $userName = $request['user_full_name'] ?? 'Unknown User';
                            $userIslanderNo = $request['user_islander_no'] ?? '';
                            $userDepartment = $request['user_department_name'] ?? 'Service';
                            $userPosition = $request['user_position_name'] ?? 'Captain';
                            $userImage = $request['user_image'] ?? '';
                            
                            // Generate image URL
                            $imageUrl = !empty($userImage) ? 
                                base_url() . '/assets/media/users/' . $userImage : 
                                'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=f4f4f4&color=9ba1b6&font-size=0.5';
                            ?>
                            <img src="<?= esc($imageUrl) ?>" class="me-3 rounded" width="60" height="60" 
                                 style="max-width: 60px; max-height: 60px; object-fit: cover;" alt="<?= esc($userName) ?>">
                            <div class="flex-grow-1">
                                <strong class="text-gray-800 d-block"><?= esc($userName) ?></strong>
                                <?php if (!empty($userIslanderNo)): ?>
                                <small class="text-muted d-block"># <?= esc($userIslanderNo) ?></small>
                                <?php endif; ?>
                                <small class="text-primary"><?= esc($userDepartment) ?> • <?= esc($userPosition) ?></small>
                            </div>
                        </div>

                        <!-- Request Info -->
                        <?php if (!empty($request['type_description'])): ?>
                        <div class="mb-3">
                            <small class="text-muted fw-bold">Description:</small>
                            <p class="text-gray-700 mb-0 mt-1" style="font-size: 13px;">
                                <?= esc(substr($request['type_description'], 0, 100)) ?>
                                <?= strlen($request['type_description']) > 100 ? '...' : '' ?>
                            </p>
                        </div>
                        <?php endif; ?>

                        <!-- Request Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="d-flex flex-column">
                                <small class="text-muted">
                                    Created: <?= date('M d, Y', strtotime($request['created_at'])) ?>
                                </small>
                                <?php if (!empty($request['created_by_name'])): ?>
                                <small class="text-muted">
                                    By: <?= esc($request['created_by_name']) ?>
                                </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Expandable Actions (initially hidden) -->
                        <div class="mobile-actions mt-3 pt-3 border-top d-none">
                            <div class="row g-2">
                                <?php if ($permissions['canView']): ?>
                                <div class="col-4">
                                    <button type="button"
                                        class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-request-btn"
                                        data-request-id="<?= esc($request['id']) ?>">
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
                                        class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-request-btn"
                                        data-request-id="<?= esc($request['id']) ?>">
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
                                        class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-request-btn"
                                        data-request-id="<?= esc($request['id']) ?>">
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
                    <i class="ki-duotone ki-document fs-5x text-gray-500 mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <h6 class="fw-bold text-gray-700 mb-2">No requests found</h6>
                    <p class="fs-7 text-gray-500 mb-4">Start by creating your first request</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

    <!-- Loading indicator for infinite scroll -->
    <div id="loading-indicator" class="text-center py-4 d-none">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 text-muted">Loading more requests...</p>
    </div>

    <!-- No more data indicator -->
    <div id="no-more-data" class="text-center py-4 d-none">
        <p class="text-muted">No more requests to load</p>
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
                                    class="form-control form-control-solid w-250px ps-13"
                                    placeholder="Search requests..." value="<?= esc($search) ?>" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-position-table-toolbar="base">
                                <!--begin::Add position-->
                                <!--end::Add position-->
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_position_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div
                                                class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#kt_request_table .form-check-input"
                                                    value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-20px">#</th>
                                        <th class="min-w-120px">Type/Status</th>
                                        <th class="min-w-150px">Islander</th>
                                        <th class="min-w-120px">Created By</th>
                                        <th class="min-w-120px">Updated By</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <?php if (!empty($requests)): ?>
                                    <?php foreach ($requests as $request): ?>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?= esc($request['id']) ?>" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->

                                        <!--begin::ID-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold">#<?= esc($request['id']) ?></span>
                                            </div>
                                        </td>
                                        <!--end::ID-->

                                        <!--begin::Type/Status-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="badge badge-light-info fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                                    <?php 
                                                    $type = $request['type'] ?? '1';
                                                    switch($type) {
                                                        case '1':
                                                            echo 'Exit Pass';
                                                            break;
                                                        case '2':
                                                            echo 'Transfer';
                                                            break;
                                                        case '3':
                                                            echo 'Leave';
                                                            break;
                                                        default:
                                                            echo 'Unknown';
                                                    }
                                                    ?>
                                                </span>
                                                <div>
                                                    <?php if (!empty($request['status_name'])): ?>
                                                    <?php 
                                                        // Use custom color if available, otherwise fallback to status-based colors
                                                        if (!empty($request['status_color'])) {
                                                            // Convert hex color to RGB for light background
                                                            $hex = ltrim($request['status_color'], '#');
                                                            $r = hexdec(substr($hex, 0, 2));
                                                            $g = hexdec(substr($hex, 2, 2));
                                                            $b = hexdec(substr($hex, 4, 2));
                                                            $lightBg = "rgba($r, $g, $b, 0.1)";
                                                            $textColor = $request['status_color'];
                                                            $badgeStyle = "background-color: $lightBg; color: $textColor; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                        } else {
                                                            // Fallback to default styling
                                                            $badgeStyle = "padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                        }
                                                        ?>
                                                    <?php if (!empty($request['status_color'])): ?>
                                                    <span class="badge fw-bold" style="<?= $badgeStyle ?>">
                                                        <?= esc($request['status_name']) ?>
                                                    </span>
                                                    <?php else: ?>
                                                    <span class="badge badge-light-success fw-bold"
                                                        style="<?= $badgeStyle ?>">
                                                        <?= esc($request['status_name']) ?>
                                                    </span>
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                    <span class="badge badge-light-secondary fw-bold"
                                                        style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">N/A</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <!--end::Type/Status-->

                                        <!--begin::Islander-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                $userName = $request['user_full_name'] ?? 'Unknown User';
                                                $userIslanderNo = $request['user_islander_no'] ?? '';
                                                $userDepartment = $request['user_department_name'] ?? 'Service';
                                                $userPosition = $request['user_position_name'] ?? 'Captain';
                                                $userImage = $request['user_image'] ?? '';
                                                
                                                // Generate image URL
                                                $imageUrl = !empty($userImage) ? 
                                                    base_url() . '/assets/media/users/' . $userImage : 
                                                    'https://ui-avatars.com/api/?name=' . urlencode($userName) . '&background=f4f4f4&color=9ba1b6&font-size=0.5';
                                                ?>
                                                <img src="<?= esc($imageUrl) ?>" class="me-2 rounded align-self-start"
                                                    width="80" height="80"
                                                    style="max-width: 80px; max-height: 80px; object-fit: cover;"
                                                    alt="<?= esc($userName) ?>">
                                                <div>
                                                    <div class="fw-bold text-gray-800">
                                                        <?= esc($userName) ?>
                                                    </div>
                                                    <?php if (!empty($userIslanderNo)): ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-badge"><span class="path1"></span><span
                                                                class="path2"></span><span class="path3"></span><span
                                                                class="path4"></span><span
                                                                class="path5"></span></i>&nbsp;<?= esc($userIslanderNo) ?>
                                                    </small><br>
                                                    <?php endif; ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-setting-3"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span><span
                                                                class="path5"></span></i>&nbsp;<?= esc($userDepartment) ?>
                                                    </small><br>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-more-2"><span class="path1"></span><span
                                                                class="path2"></span><span class="path3"></span><span
                                                                class="path4"></span></i>&nbsp;<?= esc($userPosition) ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <!--end::Islander-->

                                        <!--begin::Created By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 mb-1">
                                                    <?= esc($request['created_by_name'] ?? 'System') ?>
                                                </span>
                                                <small class="text-muted">
                                                    <?= date('M d, Y H:i', strtotime($request['created_at'])) ?>
                                                </small>
                                            </div>
                                        </td>
                                        <!--end::Created By-->

                                        <!--begin::Updated By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($request['updated_by_name']) && !empty($request['updated_at'])): ?>
                                                <span class="text-gray-800 mb-1">
                                                    <?= esc($request['updated_by_name']) ?>
                                                </span>
                                                <small class="text-muted">
                                                    <?= date('M d, Y H:i', strtotime($request['updated_at'])) ?>
                                                </small>
                                                <?php else: ?>
                                                <span class="text-muted">-</span>
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
                                                    <a class="menu-link px-3 view-request-btn"
                                                        data-request-id="<?= esc($request['id']) ?>">View</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canEdit']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 edit-request-btn"
                                                        data-request-id="<?= esc($request['id']) ?>">Edit</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canDelete']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 delete-request-btn"
                                                        data-request-id="<?= esc($request['id']) ?>">Delete</a>
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
                                        <td colspan="9" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-document fs-5x text-gray-500 mb-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fw-bold text-gray-700 mb-2">No requests found</div>
                                                <div class="text-gray-500">Start by creating your first request
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

                        <?php
                        // Include table footer with pagination
                        $footerData = [
                            'baseUrl' => 'positions',
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'limit' => $limit,
                            'totalRecords' => $totalRequests,
                            'search' => $search,
                            'tableId' => 'kt_position_table_length',
                            'jsFunction' => 'changePositionTableLimit'
                        ];
                        echo view('partials/table_footer', $footerData);
                        ?>
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

<!-- No modals needed for requests - using dedicated pages -->

<script>
// Global variables
let currentPage = 1;
let isLoading = false;
let hasMoreData = true;
let searchTimeout;

// Check if there are server-rendered cards and adjust currentPage
document.addEventListener('DOMContentLoaded', function() {
    const existingCards = document.querySelectorAll('#mobile-cards-container .mobile-position-card');
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
                loadRequests(true, query);
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

    // Load initial requests for mobile
    const mobileContainer = document.getElementById('mobile-cards-container');
    if (mobileContainer) {
        // Only load initial data if container is empty (no server-rendered content)
        const existingCards = mobileContainer.querySelectorAll('.mobile-request-card');
        if (existingCards.length === 0) {
            loadRequests(false);
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
                        loadRequests(false, mobileSearch?.value || '');
                    }
                }
            }, 100);
        });
    }

    // Handle view request
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-request-btn')) {
            e.preventDefault();
            const requestId = e.target.closest('.view-request-btn').getAttribute('data-request-id');
            viewRequest(requestId);
        }
    });

    // Handle edit request
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-request-btn')) {
            e.preventDefault();
            const requestId = e.target.closest('.edit-request-btn').getAttribute('data-request-id');
            editRequest(requestId);
        }
    });

    // Handle delete request
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-request-btn')) {
            e.preventDefault();
            const requestId = e.target.closest('.delete-request-btn').getAttribute(
            'data-request-id');
            deleteRequest(requestId);
        }
    });

});

function loadRequests(reset = false, search = '') {
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

    const url = `/requests/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

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
                    renderRequests(data.data);
                    currentPage++;
                    hasMoreData = data.hasMore;

                    // Reinitialize AOS for new elements
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                } else {
                    hasMoreData = false;
                    if (currentPage === 1) {
                        showNoRequestsMessage();
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

function renderRequests(requests) {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    requests.forEach((request, index) => {
        const requestCard = createRequestCard(request, (currentPage - 1) * 10 + index);
        container.appendChild(requestCard);
    });

    // Reinitialize mobile cards after adding new ones
    initMobileCards();
}

function createRequestCard(request, index) {
    const col = document.createElement('div');
    col.className = 'col-12 mb-3';
    col.setAttribute('data-aos', 'fade-up');
    col.setAttribute('data-aos-delay', (index * 100).toString());
    col.setAttribute('data-aos-duration', '600');

    const userName = request.user_full_name || 'Unknown User';
    const userIslanderNo = request.user_islander_no || '';
    const userDepartment = request.user_department_name || 'Service';
    const userPosition = request.user_position_name || 'Captain';
    const userImage = request.user_image || '';
    const createdByName = request.created_by_name || 'System';

    // Generate image URL
    const imageUrl = userImage ? 
        `http://localhost:8080/assets/media/users/${userImage}` : 
        `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=f4f4f4&color=9ba1b6&font-size=0.5`;

    const createdAt = new Date(request.created_at).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    });

    // Get request type display
    let requestType = 'UNKNOWN';
    switch(request.type) {
        case '1': requestType = 'EXIT PASS'; break;
        case '2': requestType = 'TRANSFER'; break;  
        case '3': requestType = 'LEAVE'; break;
    }

    // Create action buttons based on permissions
    let actionButtons = '';
    <?php if ($permissions['canView']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-request-btn" data-request-id="${request.id}">
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
            <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-request-btn" data-request-id="${request.id}">
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
            <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-request-btn" data-request-id="${request.id}">
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
        <div class="card mobile-request-card" data-request-id="${request.id}">
            <div class="card-body p-4">
                <!-- Request Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${request.id}</small>
                    </div>
                    <div class="ms-3 d-flex gap-2">
                        ${request.status_name ? `
                            ${request.status_color ? 
                                `<span class="badge fw-bold fs-8" style="background-color: ${request.status_color}1a; color: ${request.status_color};">${request.status_name.toUpperCase()}</span>` :
                                `<span class="badge badge-light-success fw-bold fs-8">${request.status_name.toUpperCase()}</span>`
                            }
                        ` : ''}
                        <span class="badge badge-light-info fw-bold" style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">${requestType}</span>
                    </div>
                </div>

                <!-- Islander Info -->
                <div class="d-flex align-items-center mb-4 mt-4">
                    <img src="${imageUrl}" class="me-3 rounded" width="60" height="60" 
                         style="max-width: 60px; max-height: 60px; object-fit: cover;" alt="${userName}">
                    <div class="flex-grow-1">
                        <strong class="text-gray-800 d-block">${userName}</strong>
                        ${userIslanderNo ? `<small class="text-muted d-block"># ${userIslanderNo}</small>` : ''}
                        <small class="text-primary">${userDepartment} • ${userPosition}</small>
                    </div>
                </div>

                <!-- Request Info -->
                ${request.type_description ? `
                <div class="mb-3">
                    <small class="text-muted fw-bold">Description:</small>
                    <p class="text-gray-700 mb-0 mt-1" style="font-size: 13px;">
                        ${request.type_description.length > 100 ? request.type_description.substring(0, 100) + '...' : request.type_description}
                    </p>
                </div>
                ` : ''}

                <!-- Request Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-flex flex-column">
                        <small class="text-muted">Created: ${createdAt}</small>
                        <small class="text-muted">By: ${createdByName}</small>
                    </div>
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

function showNoRequestsMessage() {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    const noDataDiv = document.createElement('div');
    noDataDiv.className = 'col-12';
    noDataDiv.innerHTML = `
        <div class="d-flex flex-column align-items-center justify-content-center py-10">
            <i class="ki-duotone ki-document fs-5x text-gray-500 mb-3">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
            <h6 class="fw-bold text-gray-700 mb-2">No requests found</h6>
            <p class="fs-7 text-gray-500 mb-4">Start by creating your first request</p>
        </div>
    `;
    container.appendChild(noDataDiv);
}

// Request CRUD functions
function viewRequest(requestId) {
    window.location.href = `/requests/view/${requestId}`;
}

function editRequest(requestId) {
    window.location.href = `/requests/edit/${requestId}`;
}

function deleteRequest(requestId) {
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
            secureFetch(`/requests/delete/${requestId}`, {
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
                    Swal.fire('Error', 'Failed to delete request', 'error');
                });
        }
    });
}

// Mobile card click functionality (matching modules UI)
function initMobileCards() {
    // Remove existing listeners to prevent duplicates
    document.querySelectorAll('.mobile-request-card').forEach(function(card) {
        card.replaceWith(card.cloneNode(true));
    });

    document.querySelectorAll('.mobile-request-card').forEach(function(card) {
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

// Change table limit (records per page)
function changeRequestTableLimit(newLimit) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('limit', newLimit);
    currentUrl.searchParams.set('page', '1'); // Reset to first page
    window.location.href = currentUrl.toString();
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