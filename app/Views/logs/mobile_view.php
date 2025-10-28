<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="top-0 py-3 mb-2">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">System Logs</h1>
            </div>
            <div class="row align-items-stretch">
                <div class="col-8">
                    <div class="position-relative h-100">
                        <i
                            class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="mobile_search" class="form-control form-control-solid ps-10 h-100"
                            placeholder="Search logs..." value="<?= esc($search) ?>" />
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" id="mobile_export_btn"
                        class="btn btn-success w-100 h-100 d-flex align-items-center justify-content-center"
                        style="min-height: 48px;">
                        <i class="ki-duotone ki-document fs-3x">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
                <div class="col-2">
                    <button type="button" id="mobile_clear_btn"
                        class="btn btn-danger w-100 h-100 d-flex align-items-center justify-content-center"
                        style="min-height: 48px;">
                        <i class="ki-duotone ki-trash fs-3x">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                        </i>
                    </button>
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
            <?php if (!empty($logs)): ?>
            <?php foreach ($logs as $index => $log): ?>
            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                <div class="card mobile-log-card" data-log-id="<?= esc($log['id']) ?>">
                    <div class="card-body p-4">
                        <!-- Log Header -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <small class="text-muted text-uppercase">#<?= esc($log['id']) ?></small>
                                <div class="text-gray-800 log-action-formatted-mobile">
                                    <?= formatActionText($log['action']) ?></div>
                            </div>
                            <div class="ms-3">
                                <?php 
                                $statusColor = $log['status_color'] ?? '#6c757d';
                                $statusName = $log['status_name'] ?? 'Unknown';
                                // Convert hex color to RGB for light background
                                $hex = ltrim($statusColor, '#');
                                $r = hexdec(substr($hex, 0, 2));
                                $g = hexdec(substr($hex, 2, 2));
                                $b = hexdec(substr($hex, 4, 2));
                                $lightBg = "rgba($r, $g, $b, 0.1)";
                                ?>
                                <span class="badge log-status-badge fw-bold"
                                    style="background-color: <?= $lightBg ?>; color: <?= $statusColor ?>;">
                                    <?= strtoupper(esc($statusName)) ?>
                                </span>
                            </div>
                        </div>

                        <!-- Module -->
                        <div class="mb-3">
                            <?php if (!empty($log['module'])): ?>
                            <div class="text-primary fw-semibold mb-1"><?= esc($log['module']) ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Log Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div class="d-flex flex-column">
                                <small class="text-muted">
                                    <?= !empty($log['user_name']) ? esc($log['user_name']) : 'System' ?>
                                </small>
                            </div>
                            <small class="text-muted"><?= date('M d, Y H:i', strtotime($log['logged_at'])) ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12">
                <div class="d-flex flex-column align-items-center justify-content-center py-10">
                    <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <h6 class="fw-bold text-gray-700 mb-2">No logs found</h6>
                    <p class="fs-7 text-gray-500 mb-4">System logs will appear here</p>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- Loading indicator for infinite scroll -->
        <div id="loading-indicator" class="text-center py-4 d-none">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
            <p class="mt-2 text-muted">Loading more logs...</p>
        </div>

        <!-- No more data indicator -->
        <div id="no-more-data" class="text-center py-4 d-none">
            <p class="text-muted">No more logs to load</p>
        </div>
    </div>
</div>