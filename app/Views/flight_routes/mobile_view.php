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
