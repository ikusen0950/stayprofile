<!--begin::Mobile Questions View (visible on mobile only)-->
<div class="d-lg-none" id="mobile-questions-view">
    <!--begin::Mobile Header-->
    <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
                <!--begin::Toolbar container-->
                <div class="app-container container-fluid d-flex align-items-stretch">
                    <!--begin::Toolbar wrapper-->
                    <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                        <!--begin::Page title-->
                        <div class="page-title d-flex flex-column gap-1 me-3 mb-2">
                            <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-2 mb-0">
                                Questions
                            </h1>
                        </div>
                        <!--end::Page title-->

                        <!--begin::Actions-->
                        <?php if ($permissions['canCreate']): ?>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createQuestionModal">
                                <i class="ki-duotone ki-plus fs-4"></i>
                                Add
                            </button>
                        </div>
                        <?php endif; ?>
                        <!--end::Actions-->
                    </div>
                    <!--end::Toolbar wrapper-->
                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Content-->
            <div class="app-content flex-column-fluid" id="kt_app_content">
                <!--begin::Content container-->
                <div class="app-container container-fluid" id="kt_app_content_container">

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

                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-3">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="mobile_search" class="form-control form-control-solid ps-13" placeholder="Search questions..." value="<?= esc($search) ?>" />
                    </div>
                    <!--end::Search-->

                    <!--begin::Mobile Cards Container-->
                    <div class="row g-3" id="mobile-cards-container">
                        <?php if (!empty($questions)): ?>
                            <?php foreach ($questions as $index => $question): ?>
                                <!--begin::Question Card-->
                                <div class="col-12" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                                    <div class="card mobile-question-card" data-question-id="<?= esc($question['id']) ?>">
                                        <div class="card-body p-4">
                                            <!--begin::Question Header-->
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="flex-grow-1">
                                                    <small class="text-muted text-uppercase">#<?= esc($question['id']) ?></small>
                                                    <h6 class="fw-bold text-dark mt-1 mb-0"><?= esc($question['label']) ?></h6>
                                                    <?php if (!empty($question['description'])): ?>
                                                        <p class="text-muted fs-7 mb-0 mt-1"><?= esc(substr($question['description'], 0, 100)) ?><?= strlen($question['description']) > 100 ? '...' : '' ?></p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!--begin::Question Info-->
                                            <div class="row g-2 mb-3">
                                                <div class="col-6">
                                                    <?php
                                                    $typeColors = [
                                                        'text' => 'bg-light-primary',
                                                        'textarea' => 'bg-light-info',
                                                        'single_mcq' => 'bg-light-warning',
                                                        'multi_mcq' => 'bg-light-success',
                                                        'text_block' => 'bg-light-secondary'
                                                    ];
                                                    $typeNames = [
                                                        'text' => 'Text',
                                                        'textarea' => 'Textarea',
                                                        'single_mcq' => 'Single MCQ',
                                                        'multi_mcq' => 'Multi MCQ',
                                                        'text_block' => 'Text Block'
                                                    ];
                                                    $badgeClass = $typeColors[$question['type']] ?? 'bg-light-secondary';
                                                    $typeName = $typeNames[$question['type']] ?? ucfirst($question['type']);
                                                    ?>
                                                    <span class="badge <?= $badgeClass ?> type-badge"><?= $typeName ?></span>
                                                </div>
                                                <div class="col-6 text-end">
                                                    <?php if ($question['is_required']): ?>
                                                        <span class="badge bg-light-danger question-required fs-8">Required</span>
                                                    <?php endif; ?>
                                                    <?php if ($question['is_active']): ?>
                                                        <span class="badge bg-light-success fs-8">Active</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-light-danger fs-8">Inactive</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <!--begin::Question Footer-->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="d-flex flex-column">
                                                    <small class="text-muted">Page: <?= esc($question['page']) ?: 'N/A' ?></small>
                                                    <small class="text-muted">Sort: <?= esc($question['sort_order']) ?></small>
                                                </div>
                                                <small class="text-muted"><?= date('M d, Y', strtotime($question['created_at'])) ?></small>
                                            </div>

                                            <!--begin::Expandable Actions (initially hidden)-->
                                            <div class="mobile-actions mt-3 pt-3 border-top d-none">
                                                <div class="row g-2">
                                                    <?php if ($permissions['canView']): ?>
                                                    <div class="col-4">
                                                        <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-question-btn" data-question-id="<?= esc($question['id']) ?>">
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
                                                        <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-question-btn" data-question-id="<?= esc($question['id']) ?>">
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
                                                        <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-question-btn" data-question-id="<?= esc($question['id']) ?>">
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
                                            <!--end::Expandable Actions-->
                                        </div>
                                    </div>
                                </div>
                                <!--end::Question Card-->
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <!--end::Mobile Cards Container-->

                    <!--begin::Loading Indicator-->
                    <div class="text-center py-5 d-none" id="loading-indicator">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="mt-2 text-muted">Loading more questions...</div>
                    </div>
                    <!--end::Loading Indicator-->

                    <!--begin::No More Data Indicator-->
                    <div class="text-center py-4 d-none" id="no-more-data">
                        <div class="text-muted">No more questions to load</div>
                    </div>
                    <!--end::No More Data Indicator-->

                </div>
                <!--end::Content container-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Content wrapper-->
    </div>
</div>
<!--end::Mobile Questions View-->