<?= $this->include('layout/header.php') ?>

<?php
/**
 * Format action text to make labels bold
 */
function formatActionText($actionText) {
    if (empty($actionText)) {
        return $actionText;
    }
    
    // Pattern to match labels followed by colon - expanded to include all Islander fields
    $pattern = '/^(#:|Module:|Name:|Description:|Islander No:|Username:|Email:|Phone:|Position:|Section:|Department:|Division:|Status:|Gender:|Nationality:|Date of Birth:|Date of Joining:|Company:|House:|ID\/PP\/WP No:|Address:|Notes:)(.*)$/m';
    
    $formatted = preg_replace_callback($pattern, function($matches) {
        $label = trim($matches[1]);
        $value = trim($matches[2]);
        
        if (($label === 'Description:' || $label === 'Notes:' || $label === 'Address:') && empty($value)) {
            // For description/notes/address, show the label in bold and prepare for next line content
            return '<strong>' . esc($label) . '</strong>';
        } else {
            // For other labels with values on the same line
            return '<strong>' . esc($label) . '</strong> ' . esc($value);
        }
    }, $actionText);
    
    return $formatted;
}
?>

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
.mobile-log-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-log-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-log-card:active {
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

/* Log status colors */
.log-status-badge {
    padding: 4px 8px;
    font-size: 11px;
    line-height: 1.2;
    border-radius: 4px;
}

/* Multi-line action display */
.log-action-text {
    white-space: pre-line;
    line-height: 1.4;
    max-width: 300px;
    word-wrap: break-word;
    font-size: 0.9rem;
    font-weight: normal;
}

.log-action-text-mobile {
    white-space: pre-line;
    line-height: 1.4;
    word-wrap: break-word;
    font-size: 0.95rem;
    font-weight: normal;
}

/* Style for bold labels in action text */
.log-action-formatted {
    white-space: pre-line;
    line-height: 1.4;
    max-width: 300px;
    word-wrap: break-word;
    font-size: 1rem;
    font-weight: normal;
}

.log-action-formatted-mobile {
    white-space: pre-line;
    line-height: 1.4;
    word-wrap: break-word;
    font-size: 0.95rem;
    font-weight: normal;
}

/* Highlight structured log parts */
.log-action-text .log-line:first-line {
    font-weight: 600;
    color: #1f2129;
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2" style="top: 60px !important;">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">System Logs</h1>
            </div>
            <div class="row align-items-stretch">
                <div class="col-8">
                    <div class="position-relative h-100">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
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
                                <div class="text-gray-800 log-action-formatted-mobile"><?= formatActionText($log['action']) ?></div>
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
                                    class="form-control form-control-solid w-250px ps-13" placeholder="Search logs..."
                                    value="<?= esc($search) ?>" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-log-table-toolbar="base">
                                <!--begin::Export-->
                                <button type="button" class="btn btn-light-primary me-3" id="export_logs_btn">
                                    <i class="ki-duotone ki-exit-down fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Export Logs
                                </button>
                                <!--end::Export-->
                                <!--begin::Clear logs-->
                                <button type="button" class="btn btn-danger" id="clear_logs_btn">
                                    <i class="ki-duotone ki-trash fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                    </i>Clear All Logs
                                </button>
                                <!--end::Clear logs-->
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_logs_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#kt_logs_table .form-check-input" value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-20px">#</th>
                                        <th class="min-w-80px">Status</th>
                                        <th class="min-w-100px">Module</th>
                                        <th class="min-w-300px">Action</th>
                                        <th class="min-w-120px">User</th>
                                        <th class="min-w-120px">Logged At</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <?php if (!empty($logs)): ?>
                                    <?php foreach ($logs as $log): ?>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?= esc($log['id']) ?>" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->

                                        <!--begin::ID-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <small class="text-muted">#<?= esc($log['id']) ?></small>
                                            </div>
                                        </td>
                                        <!--end::ID-->
                                     
                                        <!--begin::Status-->
                                        <td>
                                            <div class="d-flex align-items-center">
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
                                                <span class="badge fw-bold log-status-badge" 
                                                      style="background-color: <?= $lightBg ?>; color: <?= $statusColor ?>;">
                                                    <?= strtoupper(esc($statusName)) ?>
                                                </span>
                                            </div>
                                        </td>
                                        <!--end::Status-->

                                        <!--begin::Module-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <?php if (!empty($log['module_name'])): ?>
                                                <span class="text-dark">
                                                    <i class="ki-duotone ki-abstract-26 fs-6 me-1">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                    <?= esc($log['module_name']) ?>
                                                </span>
                                                <?php else: ?>
                                                <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <!--end::Module-->

                                        <!--begin::Action-->
                                        <td>
                                            <div class="text-gray-600 log-action-formatted">
                                                <?= formatActionText($log['action']) ?>
                                            </div>
                                        </td>
                                        <!--end::Action-->

                                        <!--begin::User-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-muted"><?= esc($log['user_name'] ?? 'System') ?></span>
                                            </div>
                                        </td>
                                        <!--end::User-->

                                        <!--begin::Logged At-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-muted"><?= date('d M Y', strtotime($log['logged_at'])) ?></span>
                                                <small class="text-muted"><?= date('H:i:s', strtotime($log['logged_at'])) ?></small>
                                            </div>
                                        </td>
                                        <!--end::Logged At-->
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
                                                <div class="fw-bold text-gray-700 mb-2">No logs found</div>
                                                <div class="text-gray-500">System logs will appear here</div>
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
                            'baseUrl' => 'logs',
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'limit' => $limit,
                            'totalRecords' => $totalLogs,
                            'search' => $search,
                            'tableId' => 'kt_log_table_length',
                            'jsFunction' => 'changeLogTableLimit'
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

<!-- Scripts -->

<script>
// Global variables
let currentPage = 1;
let isLoading = false;
let hasMoreData = true;
let searchTimeout;

/**
 * Format action text to make labels bold in JavaScript
 */
function formatActionText(actionText) {
    if (!actionText) return actionText;
    
    // Replace labels with bold versions - expanded to include all Islander fields
    return actionText
        .replace(/^(#:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Module:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Name:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Description:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Islander No:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Username:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Email:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Phone:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Position:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Section:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Department:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Division:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Status:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Gender:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Nationality:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Date of Birth:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Date of Joining:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Company:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(House:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(ID\/PP\/WP No:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Address:)(.*)$/gm, '<strong>$1</strong>$2')
        .replace(/^(Notes:)(.*)$/gm, '<strong>$1</strong>$2');
}

// Check if there are server-rendered cards and adjust currentPage
document.addEventListener('DOMContentLoaded', function() {
    const existingCards = document.querySelectorAll('#mobile-cards-container .mobile-log-card');
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
                if (mutation.type === 'attributes' && mutation.attributeName === 'data-kt-drawer') {
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
            if (e.target.id === 'kt_app_sidebar_mobile_toggle' || e.target.closest('#kt_app_sidebar_mobile_toggle')) {
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
                loadLogs(true, query);
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

    // Load initial logs for mobile
    const mobileContainer = document.getElementById('mobile-cards-container');
    if (mobileContainer) {
        // Only load initial data if container is empty (no server-rendered content)
        const existingCards = mobileContainer.querySelectorAll('.mobile-log-card');
        if (existingCards.length === 0) {
            loadLogs(false);
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
                        loadLogs(false, mobileSearch?.value || '');
                    }
                }
            }, 100);
        });
    }

    // Handle view log
    // Handle export logs
    document.addEventListener('click', function(e) {
        if (e.target.closest('#export_logs_btn') || e.target.closest('#mobile_export_btn')) {
            e.preventDefault();
            exportLogs();
        }
    });

    // Handle clear all logs
    document.addEventListener('click', function(e) {
        if (e.target.closest('#clear_logs_btn') || e.target.closest('#mobile_clear_btn')) {
            e.preventDefault();
            clearAllLogs();
        }
    });

    // Mobile cards initialized (no actions needed)
});

function loadLogs(reset = false, search = '') {
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

    const url = `/logs/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

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
                    renderLogs(data.data);
                    currentPage++;
                    hasMoreData = data.hasMore;

                    // Reinitialize AOS for new elements
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                } else {
                    hasMoreData = false;
                    if (currentPage === 1) {
                        showNoLogsMessage();
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

function renderLogs(logs) {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    logs.forEach((log, index) => {
        const logCard = createLogCard(log, (currentPage - 1) * 10 + index);
        container.appendChild(logCard);
    });

    // Reinitialize after adding new cards (no actions needed)
}

function createLogCard(log, index) {
    const col = document.createElement('div');
    col.className = 'col-12 mb-3';
    col.setAttribute('data-aos', 'fade-up');
    col.setAttribute('data-aos-delay', (index * 100).toString());
    col.setAttribute('data-aos-duration', '600');

    const statusColor = log.status_color || '#6c757d';
    const statusName = log.status_name || 'Unknown';
    const userName = log.user_name || 'System';
    const loggedAt = new Date(log.logged_at).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    });
    const loggedTime = new Date(log.logged_at).toLocaleTimeString('en-US', {
        hour: '2-digit',
        minute: '2-digit'
    });

    // Convert hex color to RGB for light background
    const hex = statusColor.replace('#', '');
    const r = parseInt(hex.substr(0, 2), 16);
    const g = parseInt(hex.substr(2, 2), 16);
    const b = parseInt(hex.substr(4, 2), 16);
    const lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;

    col.innerHTML = `
        <div class="card mobile-log-card" data-log-id="${log.id}">
            <div class="card-body p-4">
                <!-- Log Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${log.id}</small>
                        <div class="text-gray-800 log-action-text-mobile">${formatActionText(log.action)}</div>
                    </div>
                    <div class="ms-3">
                        <span class="badge log-status-badge fw-bold" 
                              style="background-color: ${lightBg}; color: ${statusColor};">
                            ${statusName.toUpperCase()}
                        </span>
                    </div>
                </div>

                <!-- Module -->
                <div class="mb-3">
                    ${log.module_name ? `<div class="text-primary fw-semibold mb-1"><i class="ki-duotone ki-abstract-26 fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>${log.module_name}</div>` : ''}
                </div>

                <!-- Log Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-flex flex-column">
                        <small class="text-muted">${userName}</small>
                    </div>
                    <small class="text-muted">${loggedAt} ${loggedTime}</small>
                </div>
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

function showNoLogsMessage() {
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
            <h6 class="fw-bold text-gray-700 mb-2">No logs found</h6>
            <p class="fs-7 text-gray-500 mb-4">System logs will appear here</p>
        </div>
    `;
    container.appendChild(noDataDiv);
}

// Log CRUD functions
function exportLogs() {
    const search = document.getElementById('mobile_search')?.value || document.getElementById('kt_filter_search')?.value || '';
    const url = `/logs/export?search=${encodeURIComponent(search)}`;
    window.open(url, '_blank');
}

function clearAllLogs() {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete ALL log entries!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, clear all logs!'
    }).then((result) => {
        if (result.isConfirmed) {
            secureFetch('/logs/clear', {
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
                        Swal.fire('Cleared!', data.message, 'success');
                        // Reload the page
                        window.location.reload();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to clear logs', 'error');
                });
        }
    });
}

// Mobile card click functionality
// Modal population function
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

// Change table limit (records per page)
function changeLogTableLimit(newLimit) {
    const currentUrl = new URL(window.location.href);
    currentUrl.searchParams.set('limit', newLimit);
    currentUrl.searchParams.set('page', '1'); // Reset to first page
    window.location.href = currentUrl.toString();
}
</script>

<?= $this->include('layout/footer.php') ?>