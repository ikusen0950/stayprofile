<!--begin::Header-->
<?= $this->include('layout/header.php') ?>
<!--end::Header-->

<!--begin::Format action text to make labels bold-->
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
<?= $this->include('logs/mobile_view.php') ?>
<!--end::Mobile UI-->


<!--begin::Main-->
<div class="app-main flex-column flex-row-fluid d-none d-lg-flex" id="kt_app_main">
    <!--begin::Content wrapper-->
    <div class="d-flex flex-column flex-column-fluid">

        <!--begin::Toolbar-->
        <div id="kt_app_toolbar" class="app-toolbar  pt-10 ">

            <!--begin::Toolbar container-->
            <div id="kt_app_toolbar_container" class="app-container  container-fluid d-flex align-items-stretch ">
                <!--begin::Toolbar wrapper-->
                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">

                    <!--begin::Page title-->
                    <div class="page-title d-flex flex-column gap-1 me-3 mb-2">

                        <!--begin::Title-->
                        <h1
                            class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bolder fs-1 lh-0  mb-6 mt-4">
                            System Logs
                        </h1>
                        <!--end::Title-->
                        <!--begin::Breadcrumb-->
                        <ul class="breadcrumb breadcrumb-separatorless fw-semibold mb-2">

                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                <a href="/" class="text-gray-500 text-hover-primary">
                                    <i class="ki-duotone ki-home fs-3 text-gray-500 me-n1"></i>
                                </a>
                            </li>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                            </li>
                            <!--end::Item-->


                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700 fw-bold lh-1">
                                Settings </li>
                            <!--end::Item-->


                            <!--begin::Item-->
                            <li class="breadcrumb-item">
                                <i class="ki-duotone ki-right fs-4 text-gray-700 mx-n1"></i>
                            </li>
                            <!--end::Item-->


                            <!--begin::Item-->
                            <li class="breadcrumb-item text-gray-700">
                                System Logs </li>
                            <!--end::Item-->


                        </ul>
                        <!--end::Breadcrumb-->


                    </div>
                    <!--end::Page title-->

                    <!--begin::Actions-->
                    <!-- <a href="#" class="btn btn-sm btn-success ms-3 px-4 py-3" data-bs-toggle="modal"
                                        data-bs-target="#kt_modal_create_app">
                                        Create Project</span>
                                    </a> -->
                    <!--end::Actions-->
                </div>
                <!--end::Toolbar wrapper-->
            </div>
            <!--end::Toolbar container-->
        </div>
        <!--end::Toolbar-->

        <!--begin::Content-->
        <div id="kt_app_content" class="app-content  flex-column-fluid ">


            <!--begin::Content container-->
            <div id="kt_app_content_container" class="app-container  container-fluid ">

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

                <div class="row">
                    <div class="col-6">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="kt_filter_search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search logs..."
                                value="<?= esc($search) ?>" />
                        </div>
                    </div>
                    <div class="col-6">
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
                    </div>
                </div>



                <!--begin::Table-->
                <div class="table-responsive mt">
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
                                        <span
                                            class="text-muted"><?= date('d M Y', strtotime($log['logged_at'])) ?></span>
                                        <small
                                            class="text-muted"><?= date('H:i:s', strtotime($log['logged_at'])) ?></small>
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
                                        <div class="fw-bold text-gray-700 mb-2">No logs found
                                        </div>
                                        <div class="text-gray-500">System logs will appear here
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
            <!--end::Content container-->
        </div>
        <!--end::Content-->

    </div>
    <!--end::Content wrapper-->


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
        const existingCards = document.querySelectorAll(
            '#mobile-cards-container .mobile-log-card');
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
                        const scrollPosition = window.innerHeight + window
                            .scrollY;
                        const documentHeight = document.documentElement
                            .offsetHeight;

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
            if (e.target.closest('#export_logs_btn') || e.target.closest(
                    '#mobile_export_btn')) {
                e.preventDefault();
                exportLogs();
            }
        });

        // Handle clear all logs
        document.addEventListener('click', function(e) {
            if (e.target.closest('#clear_logs_btn') || e.target.closest(
                    '#mobile_clear_btn')) {
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
        const search = document.getElementById('mobile_search')?.value || document.getElementById(
            'kt_filter_search')?.value || '';
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



    <!--begin::Footer-->
    <?= $this->include('layout/footer.php') ?>
    <!--end::Footer-->