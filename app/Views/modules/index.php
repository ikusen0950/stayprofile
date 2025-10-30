<!--begin::Header-->
<?= $this->include('layout/header.php') ?>
<!--end::Header-->


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
.mobile-module-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-module-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-module-card:active {
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
        background-color: rgba(0, 0, 0, 0.5) !important;
    }

    /* Ensure modals are above everything else */
    .modal {
        z-index: 1055 !important;
    }

    .modal-backdrop {
        z-index: 1054 !important;
    }
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<?= $this->include('modules/mobile_view.php') ?>
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
                            Modules
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
                                Modules </li>
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
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="kt_filter_search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search modules..."
                                value="<?= esc($search) ?>" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="col-6">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-module-table-toolbar="base">
                            <!--begin::Add module-->
                            <?php if (isset($permissions) && $permissions['canCreate']): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createModuleModal">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Module
                            </button>
                            <?php else: ?>
                            <button type="button" class="btn btn-light-secondary disabled"
                                title="No permission to create modules">
                                <i class="ki-duotone ki-lock fs-2"></i>Add Module
                            </button>
                            <?php endif; ?>
                            <!--end::Add module-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>


                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_module_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_module_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-20px">#</th>
                                <th class="min-w-100px">Status</th>

                                <th class="min-w-80px">Module</th>
                                <th class="min-w-200px">Description</th>
                                <th class="min-w-120px">Created By</th>
                                <th class="min-w-120px">Updated By</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                            <?php if (!empty($modules)): ?>
                            <?php foreach ($modules as $module): ?>
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox"
                                            value="<?= esc($module['id']) ?>" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->

                                <!--begin::ID-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">#<?= esc($module['id']) ?></small>
                                    </div>
                                </td>
                                <!--end::ID-->


                                <!--begin::Status-->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                                // Use custom color if available, otherwise fallback to status-based colors
                                                if (!empty($module['status_color'])) {
                                                    // Convert hex color to RGB for light background
                                                    $hex = ltrim($module['status_color'], '#');
                                                    $r = hexdec(substr($hex, 0, 2));
                                                    $g = hexdec(substr($hex, 2, 2));
                                                    $b = hexdec(substr($hex, 4, 2));
                                                    $lightBg = "rgba($r, $g, $b, 0.1)";
                                                    $textColor = $module['status_color'];
                                                    $badgeStyle = "background-color: $lightBg; color: $textColor; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                
                                                }
                                                ?>
                                        <?php if (!empty($module['status_color'])): ?>
                                        <span class="badge fw-bold" style="<?= $badgeStyle ?>">
                                            <?= strtoupper(esc($module['status_name'])) ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="badge <?= $badgeClass ?> fw-bold"
                                            style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                            <?= strtoupper(esc($status['status_name'])) ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Status-->


                                <!--begin::Module-->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-dark"><?= esc($module['name']) ?></span>
                                    </div>
                                </td>
                                <!--end::Module-->


                                <!--begin::Description-->
                                <td>
                                    <div class="text-gray-600">
                                        <?= esc($module['description']) ?>
                                    </div>
                                </td>
                                <!--end::Description-->

                                <!--begin::Created By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($module['created_by_name'])): ?>
                                        <span class="text-muted"><?= esc($module['created_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($module['created_at'])) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Created By-->
                                <!--begin::Updated By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($module['updated_by_name']) && !empty($module['updated_at'])): ?>
                                        <span class="text-muted"><?= esc($module['updated_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($module['updated_at'])) ?></small>
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
                                        <?php if (isset($permissions) && $permissions['canView']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 view-module-btn"
                                                data-module-id="<?= esc($module['id']) ?>">View</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if (isset($permissions) && $permissions['canEdit']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 edit-module-btn"
                                                data-module-id="<?= esc($module['id']) ?>">Edit</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if (isset($permissions) && $permissions['canDelete']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 delete-module-btn"
                                                data-module-id="<?= esc($module['id']) ?>">Delete</a>
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
                                        <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="fw-bold text-gray-700 mb-2">No modules found</div>
                                        <div class="text-gray-500">Start by creating your first module entry
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
                            'baseUrl' => 'modules',
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'limit' => $limit,
                            'totalRecords' => $totalModules,
                            'search' => $search,
                            'tableId' => 'kt_module_table_length',
                            'jsFunction' => 'changeModuleTableLimit'
                        ];
                        echo view('partials/table_footer', $footerData);
                        ?>


            </div>
            <!--end::Content container-->
        </div>
        <!--end::Content-->

    </div>
    <!--end::Content wrapper-->

</div>
</div>
<!--end::Main-->

<script>
// Global variables
let currentPage = 1;
let isLoading = false;
let hasMoreData = true;
let searchTimeout;

// Check if there are server-rendered cards and adjust currentPage
document.addEventListener('DOMContentLoaded', function() {
    const existingCards = document.querySelectorAll('#mobile-cards-container .mobile-module-card');
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
                loadModules(true, query);
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

    // Load initial modules for mobile
    const mobileContainer = document.getElementById('mobile-cards-container');
    if (mobileContainer) {
        // Only load initial data if container is empty (no server-rendered content)
        const existingCards = mobileContainer.querySelectorAll('.mobile-module-card');
        if (existingCards.length === 0) {
            loadModules(false);
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
                        loadModules(false, mobileSearch?.value || '');
                    }
                }
            }, 100);
        });
    }

    // Handle view module
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-module-btn')) {
            e.preventDefault();
            const moduleId = e.target.closest('.view-module-btn').getAttribute('data-module-id');
            viewModule(moduleId);
        }
    });

    // Handle edit module
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-module-btn')) {
            e.preventDefault();
            const moduleId = e.target.closest('.edit-module-btn').getAttribute('data-module-id');
            editModule(moduleId);
        }
    });

    // Handle delete module
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-module-btn')) {
            e.preventDefault();
            const moduleId = e.target.closest('.delete-module-btn').getAttribute('data-module-id');
            deleteModule(moduleId);
        }
    });

});

function loadModules(reset = false, search = '') {
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

    const url = `/modules/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

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
                    renderModules(data.data);
                    currentPage++;
                    hasMoreData = data.hasMore;

                    // Reinitialize AOS for new elements
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                } else {
                    hasMoreData = false;
                    if (currentPage === 1) {
                        showNoModulesMessage();
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

function renderModules(modules) {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    modules.forEach((module, index) => {
        const moduleCard = createModuleCard(module, (currentPage - 1) * 10 + index);
        container.appendChild(moduleCard);
    });

    // Reinitialize mobile cards after adding new ones
    initMobileCards();
}

function createModuleCard(module, index) {
    const col = document.createElement('div');
    col.className = 'col-12 mb-3';
    col.setAttribute('data-aos', 'fade-up');
    col.setAttribute('data-aos-delay', (index * 100).toString());
    col.setAttribute('data-aos-duration', '600');

    const createdByName = module.created_by_name || 'System';
    const createdAt = new Date(module.created_at).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    });

    // Determine badge style based on status color or fallback to default classes
    let badgeStyle = '';
    if (module.status_color) {
        // Use custom color from status
        const hex = module.status_color.replace('#', '');
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        const lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;
        badgeStyle =
            `background-color: ${lightBg}; color: ${module.status_color}; padding: 4px 8px; font-size: 11px; line-height: 1.2;`;
    } else {
        badgeStyle =
            "background-color: rgba(108, 117, 125, 0.1); color: #6c757d; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
    }

    // Create action buttons based on permissions
    let actionButtons = '';
    <?php if (isset($permissions) && $permissions['canView']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-module-btn" data-module-id="${module.id}">
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
    <?php if (isset($permissions) && $permissions['canEdit']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-module-btn" data-module-id="${module.id}">
                <i class="ki-duotone ki-pencil fs-1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                Edit
            </button>
        </div>
    `;
    <?php endif; ?>
    <?php if (isset($permissions) && $permissions['canDelete']): ?>
    actionButtons += `
        <div class="col-4">
            <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-module-btn" data-module-id="${module.id}">
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
        <div class="card mobile-module-card" data-module-id="${module.id}">
            <div class="card-body p-4">
                <!-- Module Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${module.id}</small>
                    </div>
                    <div class="ms-3">
                        <span class="badge fw-bold" style="${badgeStyle}">
                            ${(module.status_name || 'Unknown').toUpperCase()}
                        </span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-start mb-4 mt-4">
                    <div class="flex-grow-1">
                        <strong class="me-5 text-uppercase text-truncate">${module.name}</strong>
                    </div>
                </div>

                <!-- Module Footer -->
                <div class="d-flex justify-content-between align-items-center mt-4">
                    <div class="d-flex flex-column">
                        <small class="text-muted">${createdByName}</small>
                    </div>
                    <small class="text-muted">${createdAt}</small>
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

function showNoModulesMessage() {
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
            <h6 class="fw-bold text-gray-700 mb-2">No modules found</h6>
            <p class="fs-7 text-gray-500 mb-4">Start by creating your first module entry</p>
        </div>
    `;
    container.appendChild(noDataDiv);
}

// Module CRUD functions
function viewModule(moduleId) {
    secureFetch(`/modules/show/${moduleId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate view modal and show it
                if (typeof openViewModal === 'function') {
                    openViewModal(data.data);
                } else {
                    // Fallback: directly populate and show modal
                    populateViewModal(data.data);
                    const viewModal = new bootstrap.Modal(document.getElementById('viewModuleModal'));
                    viewModal.show();
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load module details', 'error');
        });
}

function editModule(moduleId) {
    secureFetch(`/modules/show/${moduleId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate edit modal and show it
                if (typeof openEditModal === 'function') {
                    openEditModal(data.data);
                } else {
                    // Fallback: directly populate and show modal
                    populateEditModal(data.data);
                    const editModal = new bootstrap.Modal(document.getElementById('editModuleModal'));
                    editModal.show();
                }
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load module details', 'error');
        });
}

// Fallback modal population functions
function populateViewModal(module) {
    // Populate view modal fields if the modal include doesn't have the function
    const nameEl = document.getElementById('view_module_name');
    const statusEl = document.getElementById('view_status_badge');
    const descEl = document.getElementById('view_module_description');
    
    if (nameEl) nameEl.textContent = module.name || 'N/A';
    if (statusEl) {
        statusEl.textContent = (module.status_name || 'Unknown').toUpperCase();
        if (module.status_color) {
            const hex = module.status_color.replace('#', '');
            const r = parseInt(hex.substr(0, 2), 16);
            const g = parseInt(hex.substr(2, 2), 16);
            const b = parseInt(hex.substr(4, 2), 16);
            const lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;
            statusEl.style.backgroundColor = lightBg;
            statusEl.style.color = module.status_color;
        }
    }
    if (descEl) descEl.textContent = module.description || 'No description provided';
}

function populateEditModal(module) {
    // Populate edit modal fields if the modal include doesn't have the function
    const nameEl = document.getElementById('edit_module_name');
    const statusEl = document.getElementById('edit_status_id');
    const descEl = document.getElementById('edit_module_description');
    const idEl = document.getElementById('edit_module_id');
    
    if (nameEl) nameEl.value = module.name || '';
    if (statusEl) statusEl.value = module.status_id || '';
    if (descEl) descEl.value = module.description || '';
    if (idEl) idEl.value = module.id || '';
}

function deleteModule(moduleId) {
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
            secureFetch(`/modules/delete/${moduleId}`, {
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
                    Swal.fire('Error', 'Failed to delete module', 'error');
                });
        }
    });
}

// Mobile card click functionality (matching status UI)
function initMobileCards() {
    // Remove existing listeners to prevent duplicates
    document.querySelectorAll('.mobile-module-card').forEach(function(card) {
        card.replaceWith(card.cloneNode(true));
    });

    document.querySelectorAll('.mobile-module-card').forEach(function(card) {
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

// Show view modal function (will be implemented in view_modal.php)
function showViewModal(module) {
    // This will be implemented in the view modal include
    if (typeof openViewModal === 'function') {
        openViewModal(module);
    }
}

// Show edit modal function (will be implemented in edit_modal.php)
function showEditModal(module) {
    // This will be implemented in the edit modal include
    if (typeof openEditModal === 'function') {
        openEditModal(module);
    }
}

// Change table limit (records per page)
function changeModuleTableLimit(newLimit) {
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

<!-- Include Modals (placed at end for mobile compatibility) -->
<?= $this->include('modules/create_modal') ?>
<?= $this->include('modules/edit_modal') ?>
<?= $this->include('modules/view_modal') ?>

<?= $this->include('layout/footer.php') ?>