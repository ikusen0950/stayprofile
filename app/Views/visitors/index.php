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
.mobile-visitor-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-visitor-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-visitor-card:active {
    transform: translateY(0);
}

.mobile-visitor-card.expanded {
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    border-color: #007bff;
}

.mobile-actions {
    transition: all 0.4s ease;
}

.mobile-actions.show {
    display: block !important;
    animation: slideDown 0.4s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
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
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2" style="top: 60px !important;">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">Visitors</h1>
            </div>
            <div class="row align-items-stretch">
                <div class="col-10">
                    <div class="position-relative h-100">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="mobile_search" class="form-control form-control-solid ps-10 h-100"
                            placeholder="Search visitors..." value="<?= esc($search) ?>" />
                    </div>
                </div>
                <div class="col-2">
                    <?php if ($permissions['canCreate']): ?>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#createVisitorModal"
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
                        style="min-height: 48px;" title="No permission to create visitors">
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
            <?php if (!empty($visitors)): ?>
            <?php foreach ($visitors as $index => $visitor): ?>
            <?php try { ?>
            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                <div class="card mobile-visitor-card" data-visitor-id="<?= esc($visitor['id']) ?>"
                    onclick="toggleMobileActions(this)">
                    <div class="card-body p-4">
                        <!-- Header with ID and Status -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <small style="color: #a0a0a0; font-size: 12px; font-weight: 500;">
                                    <?= esc($visitor['islander_no']) ?>
                                </small>
                            </div>
                            <div>
                                <?php if (!empty($visitor['status_name'])): ?>
                                <?php if (!empty($visitor['status_color'])): ?>
                                <?php 
                                        $hex = ltrim($visitor['status_color'], '#');
                                        $r = hexdec(substr($hex, 0, 2));
                                        $g = hexdec(substr($hex, 2, 2));
                                        $b = hexdec(substr($hex, 4, 2));
                                        $lightBg = "rgba($r, $g, $b, 0.15)";
                                        ?>
                                <span
                                    style="background: <?= $lightBg ?>; color: <?= esc($visitor['status_color']) ?>; font-weight: 600; padding: 4px 12px; border-radius: 5px; font-size: 11px;">
                                    <?= strtoupper(esc($visitor['status_name'])) ?>
                                </span>
                                <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Name Section -->
                        <div class="row mb-4">
                            <div class="col-3 mt-2 text-start">
                                <?php if (!empty($visitor['image'])): ?>
                                    <img src="<?= base_url() ?>/assets/media/users/<?= esc($visitor['image']) ?>" class="ms-2 rounded" width="80" height="80"
                                        style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                <?php else: ?>
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($visitor['full_name']) ?>&background=f4f4f4&color=9ba1b6&font-size=.5"
                                        class="ms-2 rounded" width="80" height="80"
                                        style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                <?php endif; ?>
                            </div>
                            <div class="col-9 mt-2 text-start">
                                <strong class="text-black text-uppercase text-truncate">
                                    <?= esc($visitor['full_name']) ?>
                                </strong>
                                <br><small class=""><i class="ki-duotone ki-badge"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<?= esc($visitor['islander_no']) ?></small>
                                <br><small class=""><i class="ki-duotone ki-setting-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<?= esc($visitor['department_name'] ?? 'N/A') ?></small>
                                <br><small class=""><i class="ki-duotone ki-more-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>&nbsp;<?= esc($visitor['position_name'] ?? 'N/A') ?></small>
                                <br><small class=""><i class="ki-duotone ki-shield"><span class="path1"></span><span class="path2"></span></i>&nbsp;Visitor / <?= esc($visitor['type_description']) ?></small>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center"
                            style="border-top: 1px solid #f0f0f0; padding-top: 15px;">
                            <small style="color: #999; font-size: 12px; font-weight: 500;">
                                <?= !empty($visitor['created_by_name']) ? esc($visitor['created_by_name']) : 'System Administrator' ?>
                            </small>
                            <small style="color: #999; font-size: 12px; font-weight: 500;">
                                <?php if (!empty($visitor['created_at'])): ?>
                                <?= date('M d, Y', strtotime($visitor['created_at'])) ?>
                                <?php endif; ?>
                            </small>
                        </div>
                        
                        <!-- Action Buttons (Hidden by default) -->
                        <div class="mobile-actions mt-3 pt-3 border-top d-none">
                            <div class="row g-1">
                                <?php if (isset($permissions) && $permissions['canView']): ?>
                                <div class="col-3">
                                    <button type="button"
                                        class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-visitor-btn"
                                        data-visitor-id="<?= esc($visitor['id']) ?>">
                                        <i class="ki-duotone ki-eye fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">View</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($permissions) && $permissions['canEdit']): ?>
                                <div class="col-3">
                                    <button type="button"
                                        class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-visitor-btn"
                                        data-visitor-id="<?= esc($visitor['id']) ?>">
                                        <i class="ki-duotone ki-pencil fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">Edit</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($permissions) && $permissions['canEdit'] && has_permission('visitors.enrol')): ?>
                                <div class="col-3">
                                    <button type="button"
                                        class="btn btn-light-success btn-sm w-100 d-flex align-items-center justify-content-center enrol-islander-btn"
                                        data-visitor-id="<?= esc($visitor['id']) ?>"
                                        title="Enrol as Islander">
                                        <i class="ki-duotone ki-user-tick fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">Enrol</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if (isset($permissions) && $permissions['canDelete']): ?>
                                <div class="col-3">
                                    <button
                                        class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-visitor-btn"
                                        data-visitor-id="<?= esc($visitor['id']) ?>">
                                        <i class="ki-duotone ki-trash fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                            <span class="path5"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">Delete</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } catch (Exception $e) { ?>
            <div class="col-12 mb-3">
                <div class="alert alert-danger">
                    <strong>Error rendering card <?= $index + 1 ?>:</strong><br>
                    <?= $e->getMessage() ?><br>
                    Visitor ID: <?= $visitor['id'] ?? 'unknown' ?>
                </div>
            </div>
            <?php } ?>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="d-flex flex-column align-items-center justify-content-center py-10">
                    <i class="ki-duotone ki-profile-user fs-5x text-gray-500 mb-3 ">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                    </i>
                    <?php if (!empty($search)): ?>
                        <h6 class="fw-bold text-gray-700 mb-2">No results found for "<?= esc($search) ?>"</h6>
                        <p class="fs-7 text-gray-500 mb-4">Try adjusting your search terms or browse all visitors</p>
                        <a href="<?= base_url('visitors') ?>" class="btn btn-primary btn-sm">
                            <i class="ki-duotone ki-cross fs-6 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Clear Search
                        </a>
                    <?php else: ?>
                        <h6 class="fw-bold text-gray-700 mb-2">No visitors found</h6>
                        <p class="fs-7 text-gray-500 mb-4">Start by creating your first visitor entry</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Loading indicator for infinite scroll -->
        <div id="loading-indicator" class="text-center py-4 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading more visitors...</p>
        </div>

        <!-- No more data indicator -->
        <div id="no-more-data" class="text-center py-4 d-none">
            <p class="text-muted">No more visitors to load</p>
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
                                    placeholder="Search visitors..." value="<?= esc($search) ?>" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-visitor-table-toolbar="base">
                                <!--begin::Add visitor-->
                                <?php if ($permissions['canCreate']): ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createVisitorModal">
                                    <i class="ki-duotone ki-plus fs-2"></i>Add Visitor
                                </button>
                                <?php endif; ?>
                                <!--end::Add visitor-->
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_visitor_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#kt_visitor_table .form-check-input"
                                                    value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-20px">#</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-250px">Full Name</th>
                                        <th class="min-w-100px">Created By</th>
                                        <th class="min-w-100px">Updated By</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <?php if (!empty($visitors)): ?>
                                    <?php foreach ($visitors as $visitor): ?>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?= esc($visitor['id']) ?>" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->

                                        <!--begin::ID-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">#<?= esc($visitor['id']) ?></small>
                                            </div>
                                        </td>
                                        <!--end::ID-->

                                        <!--begin::Status-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($visitor['status_name'])): ?>
                                                <?php 
                                                    // Use custom color if available, otherwise fallback to status-based colors
                                                    if (!empty($visitor['status_color'])) {
                                                        // Convert hex color to RGB for light background
                                                        $hex = ltrim($visitor['status_color'], '#');
                                                        $r = hexdec(substr($hex, 0, 2));
                                                        $g = hexdec(substr($hex, 2, 2));
                                                        $b = hexdec(substr($hex, 4, 2));
                                                        $lightBg = "rgba($r, $g, $b, 0.1)";
                                                        $textColor = $visitor['status_color'];
                                                        $badgeStyle = "background-color: $lightBg; color: $textColor; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                    } else {
                                                        // Fallback to default styling
                                                        $badgeStyle = "padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                    }
                                                    ?>
                                                <?php if (!empty($visitor['status_color'])): ?>
                                                <span class="badge fw-bold" style="<?= $badgeStyle ?>">
                                                    <?= strtoupper(esc($visitor['status_name'])) ?>
                                                </span>
                                                <?php else: ?>
                                                <span class="badge badge-light-success fw-bold"
                                                    style="<?= $badgeStyle ?>">
                                                    <?= strtoupper(esc($visitor['status_name'])) ?>
                                                </span>
                                                <?php endif; ?>
                                                <?php else: ?>
                                                <span class="badge badge-light-secondary fw-bold"
                                                    style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">N/A</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Status-->

                                        <!--begin::Full Name-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                $imageUrl = !empty($visitor['image']) ? 
                                                    base_url() . '/assets/media/users/' . $visitor['image'] : 
                                                    'https://ui-avatars.com/api/?name=' . urlencode($visitor['full_name']) . '&background=f4f4f4&color=9ba1b6&font-size=0.5';
                                                ?>
                                                <img src="<?= esc($imageUrl) ?>" class="me-2 rounded align-self-start"
                                                    width="80" height="80"
                                                    style="max-width: 80px; max-height: 80px; object-fit: cover;"
                                                    alt="<?= esc($visitor['full_name']) ?>">
                                                <div>
                                                    <div class="fw-bold text-gray-800">
                                                        <?= esc($visitor['full_name']) ?></div>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-badge"><span class="path1"></span><span
                                                                class="path2"></span><span class="path3"></span><span
                                                                class="path4"></span><span
                                                                class="path5"></span></i>&nbsp;<?= esc($visitor['islander_no']) ?>
                                                    </small><br>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-setting-3"><span
                                                                class="path1"></span><span class="path2"></span><span
                                                                class="path3"></span><span class="path4"></span><span
                                                                class="path5"></span></i>&nbsp;<?= esc($visitor['department_name'] ?? '-') ?>
                                                    </small><br>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-more-2"><span class="path1"></span><span
                                                                class="path2"></span><span class="path3"></span><span
                                                                class="path4"></span></i>&nbsp;<?= esc($visitor['position_name'] ?? '-') ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <!--end::Full Name-->

                                        <!--begin::Created By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($visitor['created_by_name'])): ?>
                                                <span class="text-muted"><?= esc($visitor['created_by_name']) ?></span>
                                                <?php if (!empty($visitor['created_at'])): ?>
                                                <small
                                                    class="text-muted"><?= date('d M Y \a\t H:i', strtotime($visitor['created_at'])) ?></small>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Created By-->

                                        <!--begin::Updated By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($visitor['updated_by_name'])): ?>
                                                <span class="text-muted"><?= esc($visitor['updated_by_name']) ?></span>
                                                <?php if (!empty($visitor['updated_at'])): ?>
                                                <small
                                                    class="text-muted"><?= date('d M Y \a\t H:i', strtotime($visitor['updated_at'])) ?></small>
                                                <?php endif; ?>
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
                                                    <a class="menu-link px-3 view-visitor-btn"
                                                        data-visitor-id="<?= esc($visitor['id']) ?>">View</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canEdit']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 edit-visitor-btn"
                                                        data-visitor-id="<?= esc($visitor['id']) ?>">Edit</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canEdit'] && has_permission('visitors.enrol')): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 enrol-islander-btn"
                                                        data-visitor-id="<?= esc($visitor['id']) ?>"
                                                        title="Enrol as Islander">Enrol Islander</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canDelete']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 delete-visitor-btn"
                                                        data-visitor-id="<?= esc($visitor['id']) ?>">Delete</a>
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
                                        <td colspan="10" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-profile-user fs-5x text-gray-500 mb-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                                <div class="fw-bold text-gray-700 mb-2">No visitors found</div>
                                                <div class="text-gray-500">Start by creating your first visitor entry
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
                        
                        <!--begin::Table Footer-->
                        <?= $this->include('partials/table_footer', [
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'totalRecords' => $totalVisitors,
                            'limit' => $limit,
                            'search' => $search,
                            'baseUrl' => 'visitors',
                            'tableId' => 'kt_visitor_table'
                        ]) ?>
                        <!--end::Table Footer-->
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
<?= $this->include('visitors/create_modal') ?>
<?= $this->include('visitors/edit_modal') ?>
<?= $this->include('visitors/view_modal') ?>

<?= $this->include('layout/footer.php') ?>

<script>
"use strict";

// Class definition
var VisitorsIndex = function() {
    var table;
    var datatable;
    var visitorList = <?= json_encode($visitors ?? []) ?>;
    var currentPage = <?= $currentPage ?? 1 ?>;
    var totalPages = <?= $totalPages ?? 1 ?>;
    var search = '<?= esc($search) ?>';
    var currentFilter = '';
    var isLoading = false;
    var isMobile = window.innerWidth <= 768;

    // Initialize components
    var initTable = function() {
        // Check if we're on mobile or desktop
        if (isMobile) {
            initMobileView();
        } else {
            initDesktopTable();
        }
    };

    // Desktop table initialization
    var initDesktopTable = function() {
        table = document.querySelector('#kt_visitor_table');
        if (!table) return;

        // Check if table has data before initializing DataTables
        const tbody = table.querySelector('tbody');
        const rows = tbody ? tbody.querySelectorAll('tr') : [];

        // Only initialize DataTables if there are data rows (not just "no results" row)
        if (rows.length > 0) {
            const firstRow = rows[0];
            const cells = firstRow.querySelectorAll('td');

            // Only initialize if the first row has actual data (not the "no results" message)
            if (cells.length > 1 && typeof $ !== 'undefined') {
                // Initialize datatable
                datatable = $(table).DataTable({
                    "searching": false,
                    "ordering": true,
                    "paging": false,
                    "info": false,
                    "columnDefs": [{
                            "orderable": false,
                            "targets": [0, -1]
                        }, // Disable ordering on checkbox and actions columns
                    ]
                });
            }
        }
    };

    // Mobile view initialization
    var initMobileView = function() {
        initInfiniteScroll();
        initMobileSearch();
    };

    // Initialize infinite scroll for mobile
    var initInfiniteScroll = function() {
        const container = document.getElementById('mobile-cards-container');
        if (!container) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isLoading && currentPage < totalPages) {
                    loadMoreVisitors();
                }
            });
        });

        // Create sentinel element for infinite scroll
        const sentinel = document.createElement('div');
        sentinel.id = 'scroll-sentinel';
        sentinel.style.height = '10px';
        container.appendChild(sentinel);
        observer.observe(sentinel);
    };

    // Initialize mobile search
    var initMobileSearch = function() {
        const mobileSearchInput = document.getElementById('mobile_search');
        if (!mobileSearchInput) return;

        let searchTimeout;
        mobileSearchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleSearch(this.value);
            }, 500);
        });
    };

    // Load more visitors (for infinite scroll)
    var loadMoreVisitors = function() {
        if (isLoading || currentPage >= totalPages || typeof $ === 'undefined') return;

        isLoading = true;
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }

        // Make AJAX request
        $.ajax({
            url: '<?= base_url('visitors') ?>',
            type: 'GET',
            data: {
                page: currentPage + 1,
                search: search,
                ajax: 1
            },
            success: function(response) {
                if (response.visitors && response.visitors.length > 0) {
                    appendVisitors(response.visitors);
                    currentPage = response.currentPage;
                    totalPages = response.totalPages;
                    
                    // Refresh AOS animations for new content
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading more visitors:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load more visitors');
                }
            },
            complete: function() {
                isLoading = false;
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'none';
                }
            }
        });
    };

    // Handle search
    var handleSearch = function(searchTerm) {
        search = searchTerm;

        // For both mobile and desktop, redirect with search parameter
        window.location.href = `<?= base_url('visitors') ?>?search=${encodeURIComponent(searchTerm)}`;
    };

    // Initialize search functionality
    var initSearch = function() {
        const searchInput = document.querySelector('#kt_filter_search');
        if (!searchInput) return;

        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                handleSearch(this.value);
            }, 500);
        });
    };

    // Initialize action buttons
    var initActionButtons = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping action buttons initialization');
            return;
        }

        // View visitor
        $(document).on('click', '.view-visitor-btn', function() {
            const visitorId = $(this).data('visitor-id');
            loadVisitorModal('view', visitorId);
        });

        // Edit visitor
        $(document).on('click', '.edit-visitor-btn', function() {
            const visitorId = $(this).data('visitor-id');
            loadVisitorModal('edit', visitorId);
        });

        // Delete visitor
        $(document).on('click', '.delete-visitor-btn', function() {
            const visitorId = $(this).data('visitor-id');
            deleteVisitor(visitorId);
        });

        // Enrol visitor as islander
        $(document).on('click', '.enrol-islander-btn', function() {
            const visitorId = $(this).data('visitor-id');
            enrolAsIslander(visitorId);
        });
    };

    // Load visitor modal
    var loadVisitorModal = function(action, visitorId) {
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, cannot load modal');
            return;
        }

        const modalId = action === 'view' ? '#viewVisitorModal' : '#editVisitorModal';

        $.ajax({
            url: `<?= base_url('visitors') ?>/${visitorId}`,
            type: 'GET',
            data: {
                ajax: 1
            },
            success: function(response) {
                if (response.success && response.visitor) {
                    populateModal(action, response.visitor);
                    $(modalId).modal('show');
                } else {
                    console.error('Invalid response or missing visitor data:', response);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load visitor details');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading visitor:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load visitor details');
                }
            }
        });
    };

    // Populate modal with visitor data
    var populateModal = function(action, visitor) {
        // Check if visitor data exists
        if (!visitor) {
            console.error('Visitor data is undefined or null');
            return;
        }

        if (action === 'view' && typeof ViewVisitorModal !== 'undefined') {
            ViewVisitorModal.populateModal(visitor);
        } else if (action === 'edit' && typeof EditVisitorModal !== 'undefined') {
            EditVisitorModal.populateForm(visitor);
        }
    };

    // Delete visitor
    var deleteVisitor = function(visitorId) {
        if (typeof Swal === 'undefined' || typeof $ === 'undefined') {
            console.log('SweetAlert or jQuery not available, cannot delete');
            return;
        }

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
                $.ajax({
                    url: `<?= base_url('visitors') ?>/${visitorId}`,
                    type: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message || 'Visitor deleted successfully');
                            }
                            // Reload page or remove item from list
                            window.location.reload();
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message || 'Failed to delete visitor');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting visitor:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to delete visitor');
                        }
                    }
                });
            }
        });
    };

    // Enrol visitor as islander
    var enrolAsIslander = function(visitorId) {
        if (typeof Swal === 'undefined' || typeof $ === 'undefined') {
            console.log('SweetAlert or jQuery not available, cannot enrol as islander');
            return;
        }

        // First, prompt for islander number
        Swal.fire({
            title: 'Enrol as Islander',
            text: 'Enter the Islander Number:',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off',
                placeholder: 'e.g., ISL001'
            },
            showCancelButton: true,
            confirmButtonText: 'Verify & Enrol',
            showLoaderOnConfirm: true,
            preConfirm: (islanderNo) => {
                if (!islanderNo) {
                    Swal.showValidationMessage('Islander number is required');
                    return false;
                }
                
                // Verify islander number doesn't already exist
                return $.ajax({
                    url: '<?= base_url('api/check-islander-number') ?>',
                    type: 'POST',
                    data: { islander_no: islanderNo },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Content-Type': 'application/x-www-form-urlencoded'
                    }
                }).then(response => {
                    if (!response.success) {
                        throw new Error(response.message || 'Failed to verify islander number');
                    }
                    if (!response.available) {
                        throw new Error('This islander number is already in use');
                    }
                    return islanderNo;
                }).catch(error => {
                    Swal.showValidationMessage(`Verification failed: ${error.message}`);
                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed && result.value) {
                const islanderNo = result.value;
                
                // Show confirmation dialog
                Swal.fire({
                    title: 'Confirm Enrolment',
                    html: `Convert this visitor to an islander with number <strong>${islanderNo}</strong>?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, enrol as Islander!',
                    cancelButtonText: 'Cancel'
                }).then((confirmResult) => {
                    if (confirmResult.isConfirmed) {
                        // Perform the enrolment
                        $.ajax({
                            url: `<?= base_url('visitors') ?>/${visitorId}/enrol-as-islander`,
                            type: 'POST',
                            data: { islander_no: islanderNo },
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            success: function(response) {
                                if (response.success) {
                                    Swal.fire({
                                        title: 'Enrolment Successful!',
                                        html: `Visitor has been successfully enrolled as Islander <strong>${islanderNo}</strong>`,
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Enrolment Failed',
                                        text: response.message || 'Failed to enrol as islander',
                                        icon: 'error'
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error enrolling as islander:', error);
                                Swal.fire({
                                    title: 'Enrolment Failed',
                                    text: 'An error occurred while enrolling as islander',
                                    icon: 'error'
                                });
                            }
                        });
                    }
                });
            }
        });
    };

    // Make enrolAsIslander available globally
    window.enrolAsIslander = enrolAsIslander;

    // Change table limit (records per page)
    window.changeTableLimit = function(newLimit) {
        if (isLoading) return;
        
        const searchParam = search ? '&search=' + encodeURIComponent(search) : '';
        window.location.href = '<?= base_url('visitors') ?>?page=1&limit=' + newLimit + searchParam;
    };

    // Public methods
    return {
        init: function() {
            initTable();
            initSearch();
            initActionButtons();
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        VisitorsIndex.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            VisitorsIndex.init();
        } else {
            console.log('jQuery not available for VisitorsIndex');
        }
    });
}

// Toggle mobile action buttons
function toggleMobileActions(cardElement) {
    const actionsDiv = cardElement.querySelector('.mobile-actions');
    const allCards = document.querySelectorAll('.mobile-visitor-card');
    
    // Close all other expanded cards
    allCards.forEach(card => {
        if (card !== cardElement) {
            const otherActions = card.querySelector('.mobile-actions');
            if (otherActions && !otherActions.classList.contains('d-none')) {
                otherActions.classList.add('d-none');
                otherActions.classList.remove('show');
                card.classList.remove('expanded');
            }
        }
    });
    
    // Toggle current card
    if (actionsDiv.classList.contains('d-none')) {
        actionsDiv.classList.remove('d-none');
        actionsDiv.classList.add('show');
        cardElement.classList.add('expanded');
    } else {
        actionsDiv.classList.add('d-none');
        actionsDiv.classList.remove('show');
        cardElement.classList.remove('expanded');
    }
}

// Close action buttons when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('.mobile-visitor-card')) {
        const allCards = document.querySelectorAll('.mobile-visitor-card');
        allCards.forEach(card => {
            const actionsDiv = card.querySelector('.mobile-actions');
            if (actionsDiv && !actionsDiv.classList.contains('d-none')) {
                actionsDiv.classList.add('d-none');
                actionsDiv.classList.remove('show');
                card.classList.remove('expanded');
            }
        });
    }
});
</script>