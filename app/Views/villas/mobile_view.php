<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!--begin::Header-->
    <div class="app-header-mobile d-flex align-items-center px-4 py-3 border-bottom">
        <!--begin::Logo-->
        <div class="flex-grow-1">
            <h2 class="mb-0 fw-bold">Villas</h2>
        </div>
        <!--end::Logo-->

        <!--begin::Search button-->
        <button type="button" class="btn btn-icon btn-sm btn-light-primary me-2" data-bs-toggle="collapse" 
                data-bs-target="#mobile-search-bar" aria-expanded="false">
            <i class="ki-duotone ki-magnifier fs-3">
                <span class="path1"></span>
                <span class="path2"></span>
            </i>
        </button>
        <!--end::Search button-->

        <!--begin::Add button-->
        <?php if ($permissions['canCreate']): ?>
        <button type="button" class="btn btn-icon btn-sm btn-primary" data-bs-toggle="modal" 
                data-bs-target="#createVillaModal">
            <i class="ki-duotone ki-plus fs-3"></i>
        </button>
        <?php endif; ?>
        <!--end::Add button-->
    </div>
    <!--end::Header-->

    <!--begin::Collapsible Search Bar-->
    <div class="collapse" id="mobile-search-bar">
        <div class="p-4 border-bottom">
            <div class="position-relative">
                <i class="ki-duotone ki-magnifier fs-3 position-absolute top-50 start-0 translate-middle-y ms-3">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <input type="text" id="mobile_search" class="form-control ps-10" 
                       placeholder="Search villas..." value="<?= esc($search) ?>">
            </div>
        </div>
    </div>
    <!--end::Collapsible Search Bar-->

    <!--begin::Content-->
    <div class="container-fluid px-4 py-3">
        <!--begin::Cards Container-->
        <div class="row" id="mobile-cards-container">
            <!-- Villa cards will be loaded here via AJAX for mobile -->
            <?php if (!empty($villas)): ?>
                <?php foreach ($villas as $index => $villa): ?>
                <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                    <div class="card mobile-villa-card" data-villa-id="<?= esc($villa['id']) ?>">
                        <div class="card-body p-4">
                            <!-- Villa Header -->
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <small class="text-muted text-uppercase">#<?= esc($villa['id']) ?></small>
                                </div>
                                <div class="ms-3">
                                    <span class="badge badge-light-primary fw-bold"><?= esc($villa['villa_code']) ?></span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-start mb-4 mt-4">
                                <div class="flex-grow-1">
                                    <strong class="me-5 text-uppercase text-truncate"><?= esc($villa['villa_name']) ?></strong>
                                    <div class="mt-2">
                                        <span class="badge badge-light-success fw-bold"><?= esc($villa['capacity']) ?> guests</span>
                                    </div>
                                </div>
                            </div>

                            <?php if (!empty($villa['description'])): ?>
                            <p class="text-muted mb-0 mt-3"><?= esc($villa['description']) ?></p>
                            <?php endif; ?>

                            <!-- Villa Footer -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <div class="d-flex flex-column">
                                    <small class="text-muted"><?= esc($villa['created_by_name'] ?? 'System') ?></small>
                                </div>
                                <small class="text-muted">
                                    <?= date('M d, Y', strtotime($villa['created_at'])) ?>
                                </small>
                            </div>

                            <!-- Expandable Actions (initially hidden) -->
                            <?php 
                            $hasActions = $permissions['canView'] || $permissions['canEdit'] || $permissions['canDelete'];
                            if ($hasActions): 
                            ?>
                            <div class="mobile-actions mt-3 pt-3 border-top d-none">
                                <div class="row g-2">
                                    <?php if ($permissions['canView']): ?>
                                    <div class="col-4">
                                        <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-villa-btn" 
                                                data-villa-id="<?= esc($villa['id']) ?>">
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
                                        <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-villa-btn" 
                                                data-villa-id="<?= esc($villa['id']) ?>">
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
                                        <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-villa-btn" 
                                                data-villa-id="<?= esc($villa['id']) ?>">
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
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <!--end::Cards Container-->

        <!--begin::Loading Indicator-->
        <div id="loading-indicator" class="text-center py-4 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <div class="mt-2 text-muted">Loading villas...</div>
        </div>
        <!--end::Loading Indicator-->

        <!--begin::No More Data Indicator-->
        <div id="no-more-data" class="text-center py-4 d-none">
            <div class="text-muted">
                <i class="ki-duotone ki-check-circle fs-1 text-success mb-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div>All villas loaded</div>
            </div>
        </div>
        <!--end::No More Data Indicator-->
    </div>
    <!--end::Content-->
</div>
<!--end::Mobile UI-->