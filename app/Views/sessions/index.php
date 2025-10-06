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

/* Enhanced mobile card hover effects */
.mobile-session-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-session-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-session-card:active {
    transform: translateY(0);
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
}

.session-status {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.session-active {
    background-color: #50cd89;
}

.session-expired {
    background-color: #f1416c;
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Search Bar -->
    <div class="mobile-search-bar position-sticky top-0 py-3 mb-2" style="top: 60px !important;">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">Sessions</h1>
            </div>
            <div class="row align-items-stretch">
                <div class="col-10">
                    <div class="position-relative h-100">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3 mt-3 text-gray-500 d-flex align-items-center justify-content-center">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input type="text" id="mobile_search" class="form-control form-control-solid ps-10 h-100"
                            placeholder="Search sessions..." value="<?= esc($search) ?>" />
                    </div>
                </div>
                <div class="col-2">
                    <button type="button" onclick="cleanupExpiredSessions()"
                        class="btn btn-warning w-100 h-100 d-flex align-items-center justify-content-center"
                        style="min-height: 48px;" title="Cleanup Expired Sessions">
                        <i class="ki-duotone ki-broom fs-3x">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
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
            <?php if (!empty($sessions)): ?>
            <?php foreach ($sessions as $index => $session): ?>
            <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                <div class="card mobile-session-card" data-session-id="<?= esc($session['id']) ?>">
                    <div class="card-body p-4">
                        <!-- Session Header -->
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="flex-grow-1">
                                <small class="text-muted text-uppercase"><?= esc(substr($session['id'], 0, 8)) ?>...</small>
                            </div>
                            <div class="ms-3">
                                <?php 
                                $isActive = (time() - strtotime($session['timestamp'])) < 3600; // Active if less than 1 hour old
                                ?>
                                <span class="badge <?= $isActive ? 'badge-light-success' : 'badge-light-danger' ?> fw-bold">
                                    <span class="session-status <?= $isActive ? 'session-active' : 'session-expired' ?>"></span>
                                    <?= $isActive ? 'ACTIVE' : 'EXPIRED' ?>
                                </span>
                            </div>
                        </div>

                        <!-- User Info -->
                        <div class="d-flex align-items-center mb-3">
                            <?php if (!empty($session['user_image'])): ?>
                                <img src="<?= base_url() ?>/assets/media/users/<?= esc($session['user_image']) ?>" class="me-2 rounded" width="40" height="40"
                                    style="max-width: 40px; max-height: 40px; object-fit: cover;">
                            <?php else: ?>
                                <div class="symbol symbol-40px me-2">
                                    <div class="symbol-label fs-6 fw-semibold bg-light-primary text-primary rounded-circle">
                                        <?= !empty($session['user_name']) ? strtoupper(substr($session['user_name'], 0, 1)) : 'U' ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <div class="flex-grow-1">
                                <strong class="text-dark"><?= esc($session['user_name'] ?? $session['full_name'] ?? 'Unknown User') ?></strong><br>
                                <?php if (!empty($session['islander_no'])): ?>
                                <small class="text-muted">
                                    <i class="ki-duotone ki-badge fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    <?= esc($session['islander_no']) ?>
                                </small><br>
                                <?php endif; ?>
                                <?php if (!empty($session['department_name'])): ?>
                                <small class="text-muted">
                                    <i class="ki-duotone ki-setting-3 fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                    <?= esc($session['department_name']) ?>
                                </small><br>
                                <?php endif; ?>
                                <?php if (!empty($session['position_name'])): ?>
                                <small class="text-muted">
                                    <i class="ki-duotone ki-more-2 fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                    <?= esc($session['position_name']) ?>
                                </small>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="row mb-3">
                            <div class="col-6">
                                <small class="text-muted d-block">IP Address</small>
                                <span class="fw-bold"><?= esc($session['ip_address']) ?></span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Last Activity</small>
                                <span class="fw-bold"><?= esc($session['time_ago'] ?? date('M d, H:i', strtotime($session['timestamp']))) ?></span>
                            </div>
                        </div>

                        <!-- Session Footer -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <small class="text-muted"><?= esc($session['formatted_timestamp'] ?? date('M d, Y H:i:s', strtotime($session['timestamp']))) ?></small>
                        </div>

                        <!-- Expandable Actions (initially hidden) -->
                        <div class="mobile-actions mt-3 pt-3 border-top d-none">
                            <div class="row g-1">
                                <?php if ($permissions['canView']): ?>
                                <div class="col-6">
                                    <button type="button"
                                        class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center view-session-btn"
                                        data-session-id="<?= esc($session['id']) ?>">
                                        <i class="ki-duotone ki-eye fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">View</span>
                                    </button>
                                </div>
                                <?php endif; ?>
                                <?php if ($permissions['canDelete']): ?>
                                <div class="col-6">
                                    <button type="button"
                                        class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center logout-session-btn"
                                        data-session-id="<?= esc($session['id']) ?>">
                                        <i class="ki-duotone ki-exit-right fs-1 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <span class="d-none d-sm-inline">Logout</span>
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
                    <i class="ki-duotone ki-profile-circle fs-5x text-gray-500 mb-3">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    <?php if (!empty($search)): ?>
                        <h6 class="fw-bold text-gray-700 mb-2">No sessions found for "<?= esc($search) ?>"</h6>
                        <p class="fs-7 text-gray-500 mb-4">Try adjusting your search terms</p>
                        <a href="<?= base_url('sessions') ?>" class="btn btn-primary btn-sm">
                            <i class="ki-duotone ki-cross fs-6 me-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Clear Search
                        </a>
                    <?php else: ?>
                        <h6 class="fw-bold text-gray-700 mb-2">No active sessions found</h6>
                        <p class="fs-7 text-gray-500 mb-4">Sessions will appear here when users log in</p>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
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
                                    placeholder="Search sessions..." value="<?= esc($search) ?>" />
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--begin::Card title-->

                        <!--begin::Card toolbar-->
                        <div class="card-toolbar">
                            <!--begin::Toolbar-->
                            <div class="d-flex justify-content-end" data-kt-session-table-toolbar="base">
                                <!--begin::Cleanup expired sessions-->
                                <?php if ($permissions['canDelete']): ?>
                                <button type="button" class="btn btn-warning me-3" onclick="cleanupExpiredSessions()">
                                    <i class="ki-duotone ki-broom fs-2"></i>Cleanup Expired
                                </button>
                                <?php endif; ?>
                                <!--end::Cleanup expired sessions-->
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
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_session_table">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="w-10px pe-2">
                                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                <input class="form-check-input" type="checkbox" data-kt-check="true"
                                                    data-kt-check-target="#kt_session_table .form-check-input"
                                                    value="1" />
                                            </div>
                                        </th>
                                        <th class="min-w-300px">User</th>
                                        <th class="min-w-100px">IP Address</th>
                                        <th class="min-w-150px">Last Activity</th>
                                        <th class="text-end min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->

                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    <?php if (!empty($sessions)): ?>
                                    <?php foreach ($sessions as $session): ?>
                                    <!--begin::Table row-->
                                    <tr>
                                        <!--begin::Checkbox-->
                                        <td>
                                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                                <input class="form-check-input" type="checkbox"
                                                    value="<?= esc($session['id']) ?>" />
                                            </div>
                                        </td>
                                        <!--end::Checkbox-->


                                        <!--begin::User-->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <?php if (!empty($session['user_image'])): ?>
                                                    <img src="<?= base_url() ?>/assets/media/users/<?= esc($session['user_image']) ?>" class="me-2 rounded" width="50" height="50"
                                                        style="max-width: 50px; max-height: 50px; object-fit: cover;">
                                                <?php else: ?>
                                                    <?php 
                                                    $imageUrl = !empty($session['full_name']) ? 
                                                        'https://ui-avatars.com/api/?name=' . urlencode($session['full_name']) . '&background=f4f4f4&color=9ba1b6&font-size=0.5' :
                                                        'https://ui-avatars.com/api/?name=U&background=f4f4f4&color=9ba1b6&font-size=0.5';
                                                    ?>
                                                    <img src="<?= esc($imageUrl) ?>" class="me-2 rounded" width="50" height="50"
                                                        style="max-width: 50px; max-height: 50px; object-fit: cover;"
                                                        alt="<?= esc($session['full_name'] ?? 'User') ?>">
                                                <?php endif; ?>
                                                <div>
                                                    <div class="fw-bold text-gray-800"><?= esc($session['full_name'] ?? $session['user_name'] ?? 'Unknown User') ?></div>
                                                    <?php if (!empty($session['islander_no'])): ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-badge"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<?= esc($session['islander_no']) ?>
                                                    </small><br>
                                                    <?php endif; ?>
                                                    <?php if (!empty($session['department_name'])): ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-setting-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>&nbsp;<?= esc($session['department_name']) ?>
                                                    </small><br>
                                                    <?php endif; ?>
                                                    <?php if (!empty($session['position_name'])): ?>
                                                    <small class="text-muted">
                                                        <i class="ki-duotone ki-more-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>&nbsp;<?= esc($session['position_name']) ?>
                                                    </small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <!--end::User-->

                                        <!--begin::IP Address-->
                                        <td>
                                            <span class="badge badge-light-info fw-bold"><?= esc($session['ip_address']) ?></span>
                                        </td>
                                        <!--end::IP Address-->

                                        
                                        <!--end::Status-->

                                        <!--begin::Last Activity-->
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-gray-800"><?= esc($session['time_ago'] ?? date('M d, H:i', strtotime($session['timestamp']))) ?></span>
                                                <small class="text-muted"><?= esc($session['formatted_timestamp'] ?? date('M d, Y H:i:s', strtotime($session['timestamp']))) ?></small>
                                            </div>
                                        </td>
                                        <!--end::Last Activity-->

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
                                                    <a class="menu-link px-3 view-session-btn"
                                                        data-session-id="<?= esc($session['id']) ?>">View</a>
                                                </div>
                                                <?php endif; ?>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <?php if ($permissions['canDelete']): ?>
                                                <div class="menu-item px-3">
                                                    <a class="menu-link px-3 logout-session-btn"
                                                        data-session-id="<?= esc($session['id']) ?>">Force Logout</a>
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
                                                <i class="ki-duotone ki-profile-circle fs-5x text-gray-500 mb-3">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                <div class="fw-bold text-gray-700 mb-2">No sessions found</div>
                                                <div class="text-gray-500">Active sessions will appear here</div>
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
                            'totalRecords' => $totalSessions,
                            'limit' => $limit,
                            'search' => $search,
                            'baseUrl' => 'sessions',
                            'tableId' => 'kt_session_table'
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
<?= $this->include('sessions/view_modal') ?>

<?= $this->include('layout/footer.php') ?>

<script>
"use strict";

// Class definition
var SessionsIndex = function() {
    var table;
    var datatable;

    // Initialize components
    var initTable = function() {
        table = document.querySelector('#kt_session_table');
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

    // Initialize search functionality
    var initSearch = function() {
        const searchInput = document.querySelector('#kt_filter_search');
        const mobileSearchInput = document.getElementById('mobile_search');
        
        if (searchInput) {
            let searchTimeout;
            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    handleSearch(this.value);
                }, 500);
            });
        }

        if (mobileSearchInput) {
            let searchTimeout;
            mobileSearchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    handleSearch(this.value);
                }, 500);
            });
        }
    };

    // Handle search
    var handleSearch = function(searchTerm) {
        window.location.href = `<?= base_url('sessions') ?>?search=${encodeURIComponent(searchTerm)}`;
    };

    // Initialize action buttons
    var initActionButtons = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, skipping action buttons initialization');
            return;
        }

        // View session
        $(document).on('click', '.view-session-btn', function() {
            const sessionId = $(this).data('session-id');
            loadSessionModal(sessionId);
        });

        // Force logout session
        $(document).on('click', '.logout-session-btn', function() {
            const sessionId = $(this).data('session-id');
            forceLogoutSession(sessionId);
        });

        // Mobile card click to expand actions
        $(document).on('click', '.mobile-session-card', function(e) {
            // Don't toggle if clicking on buttons
            if ($(e.target).closest('button').length > 0) {
                return;
            }
            
            const actionsDiv = $(this).find('.mobile-actions');
            const allActions = $('.mobile-actions');
            
            // Hide all other action divs
            allActions.not(actionsDiv).addClass('d-none');
            
            // Toggle current action div
            actionsDiv.toggleClass('d-none');
        });
    };

    // Load session modal
    var loadSessionModal = function(sessionId) {
        if (typeof $ === 'undefined') {
            console.log('jQuery not available, cannot load modal');
            return;
        }

        $.ajax({
            url: `<?= base_url('sessions') ?>/${sessionId}`,
            type: 'GET',
            data: { ajax: 1 },
            success: function(response) {
                if (response.success && response.session) {
                    populateSessionModal(response.session);
                    $('#viewSessionModal').modal('show');
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load session details');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error loading session:', error);
                if (typeof toastr !== 'undefined') {
                    toastr.error('Failed to load session details');
                }
            }
        });
    };

    // Populate session modal
    var populateSessionModal = function(session) {
        // This function will be implemented in the view modal
        if (typeof ViewSessionModal !== 'undefined') {
            ViewSessionModal.populateModal(session);
        }
    };

    // Force logout session
    var forceLogoutSession = function(sessionId) {
        if (typeof Swal === 'undefined' || typeof $ === 'undefined') {
            console.log('SweetAlert or jQuery not available, cannot force logout');
            return;
        }

        Swal.fire({
            title: 'Force Logout Session?',
            text: "This will immediately end the user's session!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, logout session!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `<?= base_url('sessions') ?>/${sessionId}/force-logout`,
                    type: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    success: function(response) {
                        if (response.success) {
                            if (typeof toastr !== 'undefined') {
                                toastr.success(response.message || 'Session logged out successfully');
                            }
                            // Reload page to refresh the session list
                            window.location.reload();
                        } else {
                            if (typeof toastr !== 'undefined') {
                                toastr.error(response.message || 'Failed to logout session');
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error logging out session:', error);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to logout session');
                        }
                    }
                });
            }
        });
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

// Cleanup expired sessions function
function cleanupExpiredSessions() {
    if (typeof Swal === 'undefined' || typeof $ === 'undefined') {
        console.log('SweetAlert or jQuery not available');
        return;
    }

    Swal.fire({
        title: 'Cleanup Expired Sessions',
        input: 'select',
        inputOptions: {
            '3600': '1 hour old',
            '7200': '2 hours old',
            '86400': '1 day old',
            '604800': '1 week old'
        },
        inputValue: '7200',
        inputPlaceholder: 'Select expiry threshold',
        showCancelButton: true,
        confirmButtonText: 'Cleanup Sessions',
        inputValidator: (value) => {
            if (!value) {
                return 'Please select an expiry threshold!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('sessions/cleanup-expired') ?>',
                type: 'POST',
                data: { expiry: result.value },
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        if (typeof toastr !== 'undefined') {
                            toastr.success(response.message);
                        }
                        window.location.reload();
                    } else {
                        if (typeof toastr !== 'undefined') {
                            toastr.error(response.message || 'Failed to cleanup sessions');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error cleaning up sessions:', error);
                    if (typeof toastr !== 'undefined') {
                        toastr.error('Failed to cleanup sessions');
                    }
                }
            });
        }
    });
}

// Change table limit (records per page)
window.changeTableLimit = function(newLimit) {
    const searchParam = new URLSearchParams(window.location.search).get('search');
    const searchQuery = searchParam ? '&search=' + encodeURIComponent(searchParam) : '';
    window.location.href = '<?= base_url('sessions') ?>?page=1&limit=' + newLimit + searchQuery;
};

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        SessionsIndex.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            SessionsIndex.init();
        } else {
            console.log('jQuery not available for SessionsIndex');
        }
    });
}
</script>