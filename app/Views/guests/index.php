<?= $this->include('layout/header.php') ?>

<script>
// Prevent FormValidation auto-initialization by overriding it early
(function() {
    var originalFormValidation;
    
    // Store and override FormValidation when it becomes available
    Object.defineProperty(window, 'FormValidation', {
        get: function() {
            return this._formValidation;
        },
        set: function(value) {
            console.log('FormValidation library detected, applying safety wrapper');
            this._formValidation = value;
            
            if (value && value.formValidation) {
                originalFormValidation = value.formValidation;
                
                // Override with error-safe version
                value.formValidation = function(form, options) {
                    try {
                        if (!form || !form.querySelector) {
                            console.log('FormValidation: Invalid form, skipping');
                            return { validate: function() { return Promise.resolve('Valid'); } };
                        }
                        
                        // Check for required DOM elements
                        if (options && options.fields) {
                            for (let fieldName in options.fields) {
                                const field = form.querySelector('[name="' + fieldName + '"]');
                                if (!field) {
                                    console.log('FormValidation: Missing field ' + fieldName + ', returning mock validator');
                                    return { validate: function() { return Promise.resolve('Valid'); } };
                                }
                            }
                        }
                        
                        return originalFormValidation.call(this, form, options);
                    } catch (error) {
                        console.error('FormValidation error prevented:', error);
                        return { validate: function() { return Promise.resolve('Valid'); } };
                    }
                };
            }
        }
    });
})();
</script>

<style>
/* Fixed mobile search bar */
.mobile-search-bar {
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    z-index: 100 !important;
    transition: all 0.3s ease;
    border-bottom: none;
    background: #ffffff;
}

/* Mobile search bar positioning override for this page */
@media (max-width: 768px) {
    /* Header background - white with no border */
    #kt_app_header,
    div#kt_app_header,
    .app-header#kt_app_header {
        background: #ffffff !important;
        background-color: #ffffff !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        border-bottom: none !important;
    }

    /* Ensure header container elements also match */
    #kt_app_header * {
        background: transparent !important;
    }

    .mobile-search-bar {
        position: fixed !important;
        top: calc(var(--status-bar-height) + 60px) !important;
        left: 0 !important;
        right: 0 !important;
        z-index: 999 !important;
        background: #ffffff !important;
        border-bottom: none !important;
        backdrop-filter: blur(10px) !important;
        -webkit-backdrop-filter: blur(10px) !important;
        margin: 0 !important;
        padding-top: 1rem !important;
        border-top: none !important;
        min-height: 120px !important;
    }

    /* Override any inline styles on mobile search bar */
    .d-lg-none .mobile-search-bar,
    .mobile-search-bar[style*="top"],
    div.mobile-search-bar {
        top: calc(var(--status-bar-height) + 60px) !important;
    }

    /* Ensure h1 title is visible - stronger selectors */
    .mobile-search-bar h1,
    .mobile-search-bar .text-dark,
    .mobile-search-bar .fw-bold,
    .d-lg-none .mobile-search-bar h1 {
        color: #1e1e2d !important;
        font-size: 1.5rem !important;
        font-weight: 700 !important;
        margin-bottom: 0.5rem !important;
        margin-top: 0 !important;
        padding: 8px 0 !important;
        display: block !important;
        visibility: visible !important;
        opacity: 1 !important;
        height: auto !important;
        line-height: 1.2 !important;
        text-align: left !important;
    }

    /* Adjust main content to account for search bar height */
    #kt_app_page {
        padding-top: calc(170px + var(--status-bar-height)) !important;
    }
}

/* Enhanced mobile card hover effects */
.mobile-guest-card {
    transition: all 0.3s ease;
    cursor: pointer;
    background: #ffffff !important;
    border-radius: 15px !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1) !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
}

.mobile-guest-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15) !important;
}

.mobile-guest-card:active {
    transform: translateY(0);
}

.mobile-guest-card.expanded {
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2) !important;
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
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">Guests</h1>
            </div>
            <div class="row align-items-stretch">
                <div class="col-10">
                    <div class="position-relative h-100">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="mobile_search" class="form-control form-control-solid ps-10 h-100"
                            placeholder="Search guests..." value="<?= esc($search) ?>" />
                    </div>
                </div>
                <div class="col-2">
                    <?php if ($permissions['canCreate']): ?>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#createGuestModal"
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
                        style="min-height: 48px;" title="No permission to create guests">
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
            <?php if (!empty($guests)): ?>
            <?php foreach ($guests as $index => $guest): ?>
            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                <div class="card mobile-guest-card" data-guest-id="<?= esc($guest['id']) ?>"
                    onclick="toggleMobileActions(this)"
                    style="background: #ffffff; border-radius: 5px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border: 1px solid rgba(0,0,0,0.05);">
                    <div class="card-body p-4">
                        <!-- Header with Status -->
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <small style="color: #a0a0a0; font-size: 12px; font-weight: 500;">
                                    Guest ID: <?= esc($guest['id']) ?>
                                </small>
                            </div>
                            <div>
                                <?php 
                                $statusColors = [
                                    'invited' => '#3498db',
                                    'pending' => '#f39c12',
                                    'submitted' => '#9b59b6',
                                    'checked_in' => '#27ae60',
                                    'checked_out' => '#95a5a6',
                                    'canceled' => '#e74c3c'
                                ];
                                $statusColor = $statusColors[$guest['status']] ?? '#95a5a6';
                                $hex = ltrim($statusColor, '#');
                                $r = hexdec(substr($hex, 0, 2));
                                $g = hexdec(substr($hex, 2, 2));
                                $b = hexdec(substr($hex, 4, 2));
                                $lightBg = "rgba($r, $g, $b, 0.15)";
                                ?>
                                <span style="background: <?= $lightBg ?>; color: <?= $statusColor ?>; font-weight: 600; padding: 4px 12px; border-radius: 5px; font-size: 11px;">
                                    <?= strtoupper(esc($guest['status'])) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Name Section -->
                        <div class="row mb-4">
                            <div class="col-3 mt-2 text-center">
                                <div class="symbol symbol-80px symbol-circle">
                                    <div class="symbol-label fs-2 fw-semibold text-success" style="background-color: #e8f5e8;">
                                        <?= strtoupper(substr($guest['full_name'], 0, 1)) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9 mt-2 text-start">
                                <strong class="text-black text-uppercase text-truncate">
                                    <?= esc($guest['full_name']) ?>
                                </strong>
                                <br><small class=""><i class="ki-duotone ki-home"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= esc($guest['villa_name'] ?? 'No Villa') ?></small>
                                <br><small class=""><i class="ki-duotone ki-fat-rows"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= ucfirst(esc($guest['reservation_code'])) ?></small>
                                <?php if (!empty($guest['email'])): ?>
                                <br><small class=""><i class="ki-duotone ki-sms"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= esc($guest['email']) ?></small>
                                <?php endif; ?>
                                <?php if (!empty($guest['phone'])): ?>
                                <br><small class=""><i class="ki-duotone ki-phone"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= esc($guest['phone']) ?></small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Dates Section -->
                        <?php if (!empty($guest['arrival_date']) || !empty($guest['departure_date'])): ?>
                        <div class="d-flex justify-content-between align-items-center mb-3" style="border-top: 1px solid #f0f0f0; padding-top: 15px;">
                            <small style="color: #666; font-size: 12px;">
                                <i class="ki-duotone ki-calendar"><span class="path1"></span><span class="path2"></span></i>
                                <?= !empty($guest['arrival_date']) ? date('M d', strtotime($guest['arrival_date'])) : 'N/A' ?>
                            </small>
                            <small style="color: #666; font-size: 12px;">→</small>
                            <small style="color: #666; font-size: 12px;">
                                <i class="ki-duotone ki-calendar"><span class="path1"></span><span class="path2"></span></i>
                                <?= !empty($guest['departure_date']) ? date('M d', strtotime($guest['departure_date'])) : 'N/A' ?>
                            </small>
                        </div>
                        <?php endif; ?>

                        <!-- Footer -->
                        <div class="d-flex justify-content-between align-items-center" style="border-top: 1px solid #f0f0f0; padding-top: 15px;">
                            <small style="color: #999; font-size: 12px; font-weight: 500;">
                                <?= !empty($guest['created_by_name']) ? esc($guest['created_by_name']) : 'System Administrator' ?>
                            </small>
                            <small style="color: #999; font-size: 12px; font-weight: 500;">
                                <?php if (!empty($guest['created_at'])): ?>
                                <?= date('M d, Y', strtotime($guest['created_at'])) ?>
                                <?php endif; ?>
                            </small>
                        </div>

                        <!-- Action Buttons (Hidden by default) -->
                        <div class="mobile-actions mt-3 pt-3 border-top d-none">
                            <div class="row g-1">
                                <?php if (isset($permissions) && $permissions['canView']): ?>
                                <div class="col-3">
                                    <button type="button"
                                        class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-guest-btn"
                                        data-guest-id="<?= esc($guest['id']) ?>">
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
                                        class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-guest-btn"
                                        data-guest-id="<?= esc($guest['id']) ?>">
                                        <i class="ki-duotone ki-pencil fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">Edit</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <div class="col-3">
                                    <button type="button"
                                        class="btn btn-light-info btn-sm w-100 d-flex align-items-center justify-content-center copy-link-btn"
                                        data-guest-token="<?= esc($guest['guest_token']) ?>">
                                        <i class="ki-duotone ki-copy fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">Link</span>
                                    </button>
                                </div>
                                <?php if (isset($permissions) && $permissions['canDelete']): ?>
                                <div class="col-3">
                                    <button
                                        class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-guest-btn"
                                        data-guest-id="<?= esc($guest['id']) ?>">
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
                    <p class="fs-7 text-gray-500 mb-4">Try adjusting your search terms or browse all guests</p>
                    <a href="<?= base_url('guests') ?>" class="btn btn-primary btn-sm">
                        <i class="ki-duotone ki-cross fs-6 me-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Clear Search
                    </a>
                    <?php else: ?>
                    <h6 class="fw-bold text-gray-700 mb-2">No guests found</h6>
                    <p class="fs-7 text-gray-500 mb-4">Start by creating your first guest entry</p>
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
            <p class="mt-2 text-muted">Loading more guests...</p>
        </div>

        <!-- No more data indicator -->
        <div id="no-more-data" class="text-center py-4 d-none">
            <p class="text-muted">No more guests to load</p>
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
                                    placeholder="Search guests..." value="<?= esc($search) ?>" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-guest-table-toolbar="base">
                                <!--begin::Add guest-->
                                <?php if ($permissions['canCreate']): ?>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#createGuestModal">
                                    <i class="ki-duotone ki-plus fs-2"></i>Add Guest
                                </button>
                                <?php endif; ?>
                                <!--end::Add guest-->
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_guest_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#kt_guest_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-20px">#</th>
                                        <th class="min-w-100px">Status</th>
                                        <th class="min-w-250px">Guest Details</th>
                                        <th class="min-w-150px">Villa</th>
                                        <th class="min-w-150px">Dates</th>
                                        <th class="min-w-100px">Created By</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <?php if (!empty($guests)): ?>
                                    <?php foreach ($guests as $guest): ?>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox" value="<?= esc($guest['id']) ?>" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->

                                        <!--begin::ID-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">#<?= esc($guest['id']) ?></small>
                                            </div>
                                        </td>
                                        <!--end::ID-->

                                        <!--begin::Status-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php 
                                                $statusColors = [
                                                    'invited' => '#3498db',
                                                    'pending' => '#f39c12',
                                                    'submitted' => '#9b59b6',
                                                    'checked_in' => '#27ae60',
                                                    'checked_out' => '#95a5a6',
                                                    'canceled' => '#e74c3c'
                                                ];
                                                $statusColor = $statusColors[$guest['status']] ?? '#95a5a6';
                                                $hex = ltrim($statusColor, '#');
                                                $r = hexdec(substr($hex, 0, 2));
                                                $g = hexdec(substr($hex, 2, 2));
                                                $b = hexdec(substr($hex, 4, 2));
                                                $lightBg = "rgba($r, $g, $b, 0.1)";
                                                ?>
                                                <span class="badge fw-bold" style="background-color: <?= $lightBg ?>; color: <?= $statusColor ?>; padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                                    <?= strtoupper(esc($guest['status'])) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <!--end::Status-->

                                        <!--begin::Guest Details-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="symbol symbol-50px symbol-circle me-3">
                                                    <div class="symbol-label fs-3 fw-semibold text-success" style="background-color: #e8f5e8;">
                                                        <?= strtoupper(substr($guest['full_name'], 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-gray-800"><?= esc($guest['full_name']) ?></div>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-fat-rows"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= ucfirst(esc($guest['reservation_code'])) ?>
                                                    </small><br>
                                                    <?php if (!empty($guest['email'])): ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-sms"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= esc($guest['email']) ?>
                                                    </small><br>
                                                    <?php endif; ?>
                                                    <?php if (!empty($guest['phone'])): ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-phone"><span class="path1"></span><span class="path2"></span></i>&nbsp;<?= esc($guest['phone']) ?>
                                                    </small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <!--end::Guest Details-->

                                        <!--begin::Villa-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800 fw-bold"><?= esc($guest['villa_name'] ?? 'No Villa') ?></span>
                                                <?php if (!empty($guest['villa_code'])): ?>
                                                <small class="text-muted"><?= esc($guest['villa_code']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Villa-->

                                        <!--begin::Dates-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($guest['arrival_date'])): ?>
                                                <small class="text-muted">
                                                    <i class="ki-duotone ki-calendar-add"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    In: <?= date('M d, Y', strtotime($guest['arrival_date'])) ?>
                                                </small>
                                                <?php endif; ?>
                                                <?php if (!empty($guest['departure_date'])): ?>
                                                <small class="text-muted">
                                                    <i class="ki-duotone ki-calendar-remove"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                    Out: <?= date('M d, Y', strtotime($guest['departure_date'])) ?>
                                                </small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Dates-->

                                        <!--begin::Created By-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($guest['created_by_name'])): ?>
                                                <span class="text-muted"><?= esc($guest['created_by_name']) ?></span>
                                                <?php if (!empty($guest['created_at'])): ?>
                                                <small class="text-muted"><?= date('d M Y \a\t H:i', strtotime($guest['created_at'])) ?></small>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Created By-->

                                        <!--begin::Action-->
                                        <td class="text-end">
                                            <a href="#" class="btn btn-light btn-active-light-primary btn-flex btn-center btn-sm"
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
                                                    <a class="menu-link px-3 view-guest-btn" data-guest-id="<?= esc($guest['id']) ?>">View</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canEdit']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 edit-guest-btn" data-guest-id="<?= esc($guest['id']) ?>">Edit</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 copy-link-btn" data-guest-token="<?= esc($guest['guest_token']) ?>">
                                                        <i class="ki-duotone ki-copy fs-6 me-1">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>Copy Link
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canDelete']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 delete-guest-btn" data-guest-id="<?= esc($guest['id']) ?>">Delete</a>
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
                                        <td colspan="8" class="text-center py-10">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="ki-duotone ki-profile-user fs-5x text-gray-500 mb-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                    <span class="path4"></span>
                                                </i>
                                                <div class="fw-bold text-gray-700 mb-2">No guests found</div>
                                                <div class="text-gray-500">Start by creating your first guest entry</div>
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
                        <div class="row align-items-center py-3 border-top border-gray-200">
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex align-items-center">
                                    <label class="form-label fs-6 fw-semibold mb-0 me-2 text-gray-700">Show</label>
                                    <select class="form-select form-select-sm w-auto me-2" id="kt_guest_table_length"
                                        onchange="changeTableLimit(this.value)" style="min-width: 65px;">
                                        <option value="10" <?= $limit == 10 ? 'selected' : '' ?>>10</option>
                                        <option value="25" <?= $limit == 25 ? 'selected' : '' ?>>25</option>
                                        <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
                                        <option value="100" <?= $limit == 100 ? 'selected' : '' ?>>100</option>
                                    </select>
                                    <label class="form-label fs-6 fw-semibold mb-0 text-gray-700">entries</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="d-flex justify-content-end align-items-center">
                                    <div class="dataTables_info me-4" role="status" aria-live="polite">
                                        <span class="text-gray-700 fw-semibold fs-6">
                                            Showing <?= (($currentPage - 1) * $limit) + 1 ?> to
                                            <?= min($currentPage * $limit, $totalGuests) ?> of
                                            <?= $totalGuests ?>
                                            entries
                                        </span>
                                    </div>
                                    <div class="dataTables_paginate">
                                        <ul class="pagination pagination-sm">
                                            <?php if ($currentPage > 1): ?>
                                            <li class="page-item">
                                                <a href="<?= base_url('guests?page=' . ($currentPage - 1) . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>"
                                                    class="page-link" data-page="<?= $currentPage - 1 ?>" title="Previous">
                                                    <i class="ki-duotone ki-left fs-3"></i>
                                                </a>
                                            </li>
                                            <?php else: ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="ki-duotone ki-left fs-3"></i>
                                                </span>
                                            </li>
                                            <?php endif; ?>

                                            <?php
                                            // Calculate page range for display
                                            $startPage = max(1, $currentPage - 1);
                                            $endPage = min($totalPages, $currentPage + 1);
                                            
                                            // Adjust if we're at the beginning or end
                                            if ($currentPage <= 2) {
                                                $endPage = min($totalPages, 4);
                                            }
                                            if ($currentPage >= $totalPages - 1) {
                                                $startPage = max(1, $totalPages - 3);
                                            }
                                            
                                            for ($i = $startPage; $i <= $endPage; $i++): ?>
                                            <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                                                <a href="<?= base_url('guests?page=' . $i . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>"
                                                    class="page-link" data-page="<?= $i ?>"><?= $i ?></a>
                                            </li>
                                            <?php endfor; ?>

                                            <?php if ($currentPage < $totalPages): ?>
                                            <li class="page-item">
                                                <a href="<?= base_url('guests?page=' . ($currentPage + 1) . ($search ? '&search=' . urlencode($search) : '') . '&limit=' . $limit) ?>"
                                                    class="page-link" data-page="<?= $currentPage + 1 ?>" title="Next">
                                                    <i class="ki-duotone ki-right fs-3"></i>
                                                </a>
                                            </li>
                                            <?php else: ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">
                                                    <i class="ki-duotone ki-right fs-3"></i>
                                                </span>
                                            </li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<?= $this->include('guests/create_modal') ?>
<?= $this->include('guests/edit_modal') ?>
<?= $this->include('guests/view_modal') ?>

<?= $this->include('layout/footer.php') ?>

<script>
"use strict";

// Class definition
var GuestsIndex = function() {
    var table;
    var datatable;
    var guestList = <?= json_encode($guests ?? []) ?>;
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
        table = document.querySelector('#kt_guest_table');
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
                    }]
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
                    loadMoreGuests();
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

    // Load more guests (for infinite scroll)
    var loadMoreGuests = function() {
        if (isLoading || currentPage >= totalPages || typeof $ === 'undefined') return;

        isLoading = true;
        const loadingIndicator = document.getElementById('loading-indicator');
        if (loadingIndicator) {
            loadingIndicator.style.display = 'block';
        }

        // Make AJAX request
        $.ajax({
            url: '<?= base_url('guests') ?>',
            type: 'GET',
            data: {
                page: currentPage + 1,
                search: search,
                ajax: 1,
                limit: 10
            },
            success: function(response) {
                if (response.guests && response.guests.length > 0) {
                    appendGuests(response.guests);
                    currentPage = response.currentPage;
                    totalPages = response.totalPages;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading more guests:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load more guests');
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
        window.location.href = `<?= base_url('guests') ?>?search=${encodeURIComponent(searchTerm)}`;
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
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping action buttons initialization');
            return;
        }

        // View guest
        $(document).on('click', '.view-guest-btn', function() {
            const guestId = $(this).data('guest-id');
            loadGuestModal('view', guestId);
        });

        // Edit guest
        $(document).on('click', '.edit-guest-btn', function() {
            const guestId = $(this).data('guest-id');
            loadGuestModal('edit', guestId);
        });

        // Delete guest
        $(document).on('click', '.delete-guest-btn', function() {
            const guestId = $(this).data('guest-id');
            deleteGuest(guestId);
        });
    };

    // Load guest modal
    var loadGuestModal = function(action, guestId) {
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, cannot load modal');
            return;
        }

        const modalId = action === 'view' ? '#viewGuestModal' : '#editGuestModal';

        $.ajax({
            url: `<?= base_url('guests') ?>/${guestId}`,
            type: 'GET',
            data: {
                ajax: 1
            },
            success: function(response) {
                if (response.success && response.guest) {
                    populateModal(action, response.guest);
                    $(modalId).modal('show');
                } else {
                    console.error('Invalid response or missing guest data:', response);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load guest details');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading guest:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load guest details');
                }
            }
        });
    };

    // Populate modal with guest data
    var populateModal = function(action, guest) {
        if (!guest) {
            console.error('Guest data is undefined or null');
            return;
        }

        if (action === 'view' && typeof ViewGuestModal !== 'undefined') {
            ViewGuestModal.populateModal(guest);
        } else if (action === 'edit' && typeof populateEditGuestForm !== 'undefined') {
            populateEditGuestForm(guest);
        }
    };

    // Delete guest
    var deleteGuest = function(guestId) {
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
                    url: `<?= base_url('guests') ?>/${guestId}`,
                    type: 'DELETE',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message || 'Guest deleted successfully');
                            }
                            window.location.reload();
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message || 'Failed to delete guest');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error deleting guest:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to delete guest');
                        }
                    }
                });
            }
        });
    };

    // Change table limit (records per page)
    window.changeTableLimit = function(newLimit) {
        if (isLoading) return;
        const searchParam = search ? '&search=' + encodeURIComponent(search) : '';
        window.location.href = '<?= base_url('guests') ?>?page=1&limit=' + newLimit + searchParam;
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
        GuestsIndex.init();
    });
} else {
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            GuestsIndex.init();
        } else {
            console.log('jQuery not available for GuestsIndex');
        }
    });
}

// Toggle mobile action buttons
function toggleMobileActions(cardElement) {
    const actionsDiv = cardElement.querySelector('.mobile-actions');
    const allCards = document.querySelectorAll('.mobile-guest-card');

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
    if (!event.target.closest('.mobile-guest-card')) {
        const allCards = document.querySelectorAll('.mobile-guest-card');
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

// Global FormValidation override to prevent errors
document.addEventListener('DOMContentLoaded', function() {
    // Override FormValidation to prevent initialization errors
    if (typeof FormValidation !== 'undefined') {
        console.log('Overriding FormValidation to prevent errors');
        
        // Store original formValidation function
        const originalFormValidation = FormValidation.formValidation;
        
        // Override with error-safe version
        FormValidation.formValidation = function(form, options) {
            try {
                // Check if form exists and is valid
                if (!form || !form.querySelector) {
                    console.log('FormValidation: Invalid form element, skipping');
                    return null;
                }
                
                // Check if all field elements exist
                if (options && options.fields) {
                    for (let fieldName in options.fields) {
                        const field = form.querySelector('[name="' + fieldName + '"]');
                        if (!field) {
                            console.log('FormValidation: Missing field ' + fieldName + ', skipping validation');
                            return null;
                        }
                    }
                }
                
                // Call original function with safety checks
                return originalFormValidation.call(this, form, options);
            } catch (error) {
                console.error('FormValidation initialization error prevented:', error);
                return null;
            }
        };
    }
    
    // Handle copy link functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.copy-link-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.copy-link-btn');
            const guestToken = btn.getAttribute('data-guest-token');
            
            if (!guestToken) {
                Swal.fire('Error', 'Guest token not found', 'error');
                return;
            }
            
            const guestLink = `${window.location.origin}/welcome/${guestToken}`;
            
            // Copy to clipboard
            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(guestLink).then(function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Link Copied!',
                        text: 'Guest welcome link has been copied to clipboard',
                        timer: 2000,
                        showConfirmButton: false
                    });
                }).catch(function(err) {
                    console.error('Could not copy text: ', err);
                    fallbackCopyTextToClipboard(guestLink);
                });
            } else {
                // Fallback for older browsers
                fallbackCopyTextToClipboard(guestLink);
            }
        }
    });
    
    // Fallback copy function for older browsers
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.top = '0';
        textArea.style.left = '0';
        textArea.style.width = '2em';
        textArea.style.height = '2em';
        textArea.style.padding = '0';
        textArea.style.border = 'none';
        textArea.style.outline = 'none';
        textArea.style.boxShadow = 'none';
        textArea.style.background = 'transparent';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            document.body.removeChild(textArea);
            if (successful) {
                Swal.fire({
                    icon: 'success',
                    title: 'Link Copied!',
                    text: 'Guest welcome link has been copied to clipboard',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                throw new Error('Copy command failed');
            }
        } catch (err) {
            document.body.removeChild(textArea);
            Swal.fire({
                icon: 'info',
                title: 'Copy Link',
                html: `<p>Please copy this link manually:</p><p><strong>${text}</strong></p>`,
                showConfirmButton: true
            });
        }
    }
});
</script>