<?= $this->include('layout/header.php') ?>

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
.mobile-villa-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-villa-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-villa-card:active {
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

/* Better Select2 dropdown positioning in modals */
.select2-container--bootstrap5 .select2-dropdown {
    z-index: 1060;
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<?= $this->include('villas/mobile_view.php') ?>
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
                            Villas
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
                                Villas </li>
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
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search villas..."
                                value="<?= esc($search) ?>" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="col-6">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-villa-table-toolbar="base">
                            <!--begin::Add villa-->
                            <?php if ($permissions['canCreate']): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createVillaModal">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Villa
                            </button>
                            <?php endif; ?>
                            <!--end::Add villa-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>


                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_villa_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_villa_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-20px">#</th>
                                <th class="min-w-150px">Villa Name</th>
                                <th class="min-w-100px">Villa Code</th>
                                <th class="min-w-80px">Capacity</th>
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
                            <?php if (!empty($villas)): ?>
                            <?php foreach ($villas as $villa): ?>
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox"
                                            value="<?= esc($villa['id']) ?>" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->

                                <!--begin::ID-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">#<?= esc($villa['id']) ?></small>
                                    </div>
                                </td>
                                <!--end::ID-->

                                <!--begin::Villa Name-->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="fw-bold text-dark"><?= esc($villa['villa_name']) ?></span>
                                    </div>
                                </td>
                                <!--end::Villa Name-->

                                <!--begin::Villa Code-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="badge badge-light-primary fw-bold"><?= esc($villa['villa_code']) ?></span>
                                    </div>
                                </td>
                                <!--end::Villa Code-->

                                <!--begin::Capacity-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold text-primary"><?= esc($villa['capacity']) ?> guests</span>
                                    </div>
                                </td>
                                <!--end::Capacity-->

                                <!--begin::Description-->
                                <td>
                                    <div class="text-gray-600">
                                        <?= esc($villa['description']) ?>
                                    </div>
                                </td>
                                <!--end::Description-->

                                <!--begin::Created By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($villa['created_by_name'])): ?>
                                        <span class="text-muted"><?= esc($villa['created_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($villa['created_at'])) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Created By-->
                                <!--begin::Updated By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($villa['updated_by_name']) && !empty($villa['updated_at'])): ?>
                                        <span class="text-muted"><?= esc($villa['updated_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($villa['updated_at'])) ?></small>
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
                                            <a class="menu-link px-3 view-villa-btn"
                                                data-villa-id="<?= esc($villa['id']) ?>">View</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if ($permissions['canEdit']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 edit-villa-btn"
                                                data-villa-id="<?= esc($villa['id']) ?>">Edit</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if ($permissions['canDelete']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 delete-villa-btn"
                                                data-villa-id="<?= esc($villa['id']) ?>">Delete</a>
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
                                <td colspan="9" class="text-center py-10">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="fw-bold text-gray-700 mb-2">No villas found</div>
                                        <div class="text-gray-500">Start by creating your first villa entry
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
                            'baseUrl' => 'villas',
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'limit' => $limit,
                            'totalRecords' => $totalVillas,
                            'search' => $search,
                            'tableId' => 'kt_villa_table_length',
                            'jsFunction' => 'changeVillaTableLimit'
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
    const existingCards = document.querySelectorAll('#mobile-cards-container .mobile-villa-card');
    if (existingCards.length > 0) {
        // Server already rendered the first page, so start from page 2
        currentPage = Math.ceil(existingCards.length / 10) + 1;
    }
});

// Global functions are now defined above for modal access

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
                loadVillas(true, query);
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

    // Load initial villas for mobile
    const mobileContainer = document.getElementById('mobile-cards-container');
    if (mobileContainer) {
        // Only load initial data if container is empty (no server-rendered content)
        const existingCards = mobileContainer.querySelectorAll('.mobile-villa-card');
        if (existingCards.length === 0) {
            loadVillas(false);
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
                        loadVillas(false, mobileSearch?.value || '');
                    }
                }
            }, 100);
        });
    }

    // Handle view villa
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-villa-btn')) {
            e.preventDefault();
            const villaId = e.target.closest('.view-villa-btn').getAttribute('data-villa-id');
            viewVilla(villaId);
        }
    });

    // Handle edit villa
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-villa-btn')) {
            e.preventDefault();
            const villaId = e.target.closest('.edit-villa-btn').getAttribute('data-villa-id');
            editVilla(villaId);
        }
    });

    // Handle delete villa
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-villa-btn')) {
            e.preventDefault();
            const villaId = e.target.closest('.delete-villa-btn').getAttribute('data-villa-id');
            deleteVilla(villaId);
        }
    });

});

function loadVillas(reset = false, search = '') {
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

    const url = `/villas/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

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
                    renderVillas(data.data);
                    currentPage++;
                    hasMoreData = data.hasMore;

                    // Reinitialize AOS for new elements
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                } else {
                    hasMoreData = false;
                    if (currentPage === 1) {
                        showNoVillasMessage();
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

function renderVillas(villas) {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    villas.forEach((villa, index) => {
        const villaCard = createVillaCard(villa, (currentPage - 1) * 10 + index);
        container.appendChild(villaCard);
    });

    // Reinitialize mobile cards after adding new ones
    initMobileCards();
}

function createVillaCard(villa, index) {
    const col = document.createElement('div');
    col.className = 'col-12 mb-3';
    col.setAttribute('data-aos', 'fade-up');
    col.setAttribute('data-aos-delay', (index * 100).toString());
    col.setAttribute('data-aos-duration', '600');

    const description = villa.description ?
        `<p class="text-muted mb-0 mt-3">${villa.description}</p>` : '';

    const createdByName = villa.created_by_name || 'System';
    const updatedInfo = villa.updated_by_name ?
        `<small class="text-success">Updated: ${villa.updated_by_name}</small>` : '';

    const createdAt = new Date(villa.created_at).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    });
    const updatedAt = villa.updated_at ?
        new Date(villa.updated_at).toLocaleDateString('en-US', {
            month: 'short',
            day: '2-digit',
            year: 'numeric'
        }) : '';

    // Create action buttons based on permissions
    let actionButtons = '';
    <?php if ($permissions['canView']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-villa-btn" data-villa-id="${villa.id}">
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
    <?php if ($permissions['canEdit']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-villa-btn" data-villa-id="${villa.id}">
                <i class="ki-duotone ki-pencil fs-1 me-2">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                Edit
            </button>
        </div>
    `;
    <?php endif; ?>
    <?php if ($permissions['canDelete']): ?>
    actionButtons += `
        <div class="col-4">
            <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-villa-btn" data-villa-id="${villa.id}">
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
        <div class="card mobile-villa-card" data-villa-id="${villa.id}">
            <div class="card-body p-4">
                <!-- Villa Header -->
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${villa.id}</small>
                    </div>
                    <div class="ms-3">
                        <span class="badge badge-light-primary fw-bold">${villa.villa_code}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-start mb-4 mt-4">
                    <div class="flex-grow-1">
                        <strong class="me-5 text-uppercase text-truncate">${villa.villa_name}</strong>
                        <div class="mt-2">
                            <span class="badge badge-light-success fw-bold">${villa.capacity} guests</span>
                        </div>
                    </div>
                </div>

                ${description}

                <!-- Villa Footer -->
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

function showNoVillasMessage() {
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
            <h6 class="fw-bold text-gray-700 mb-2">No villas found</h6>
            <p class="fs-7 text-gray-500 mb-4">Start by creating your first villa entry</p>
        </div>
    `;
    container.appendChild(noDataDiv);
}

// Villa CRUD functions
function viewVilla(villaId) {
    secureFetch(`/villas/show/${villaId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate view modal
                populateViewModal(data.data);
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewVillaModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load villa details', 'error');
        });
}

function editVilla(villaId) {
    secureFetch(`/villas/show/${villaId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate edit modal
                populateEditModal(data.data);
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editVillaModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load villa details', 'error');
        });
}

function deleteVilla(villaId) {
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
            secureFetch(`/villas/delete/${villaId}`, {
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
                    Swal.fire('Error', 'Failed to delete villa', 'error');
                });
        }
    });
}

// Mobile card click functionality (matching modules UI)
function initMobileCards() {
    // Remove existing listeners to prevent duplicates
    document.querySelectorAll('.mobile-villa-card').forEach(function(card) {
        card.replaceWith(card.cloneNode(true));
    });

    document.querySelectorAll('.mobile-villa-card').forEach(function(card) {
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

// Modal population functions
function populateViewModal(villa) {
    // Basic villa info
    document.getElementById('view_villa_name').textContent = villa.villa_name;
    document.getElementById('view_villa_code').textContent = villa.villa_code || 'N/A';
    document.getElementById('view_capacity').textContent = villa.capacity || 'Not specified';
    
    // Description
    const description = document.getElementById('view_description');
    const descriptionSection = document.getElementById('view_description_section');
    
    if (villa.description && villa.description.trim() !== '') {
        description.textContent = villa.description;
        descriptionSection.style.display = 'block';
    } else {
        description.textContent = 'No description provided';
        descriptionSection.style.display = 'block';
    }
    
    // Audit info
    document.getElementById('view_created_by').textContent = villa.created_by_name || 'System';
    document.getElementById('view_created_at').textContent = villa.created_at ? 
        new Date(villa.created_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) : '-';
    
    // Updated info (show/hide based on availability)
    const updatedBySection = document.getElementById('view_updated_by_section');
    const updatedAtSection = document.getElementById('view_updated_at_section');
    
    if (villa.updated_by_name) {
        document.getElementById('view_updated_by').textContent = villa.updated_by_name;
        updatedBySection.style.display = 'block';
    } else {
        updatedBySection.style.display = 'none';
    }
    
    if (villa.updated_at) {
        document.getElementById('view_updated_at').textContent = new Date(villa.updated_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        updatedAtSection.style.display = 'block';
    } else {
        updatedAtSection.style.display = 'none';
    }
    
    // Set villa ID for edit button if it exists
    const editBtn = document.getElementById('view_edit_btn');
    if (editBtn) {
        editBtn.setAttribute('data-villa-id', villa.id);
    }
}

function populateEditModal(villa) {
    console.log('Populating edit modal with villa data:', villa);
    
    document.getElementById('edit_villa_id').value = villa.id;
    document.querySelector('#editVillaForm input[name="villa_name"]').value = villa.villa_name;
    document.querySelector('#editVillaForm input[name="villa_code"]').value = villa.villa_code || '';
    document.querySelector('#editVillaForm input[name="capacity"]').value = villa.capacity || '';
    document.querySelector('#editVillaForm textarea[name="description"]').value = villa.description || '';
    
    // Populate existing images
    console.log('Villa images:', villa.images);
    if (typeof populateExistingImages === 'function') {
        populateExistingImages(villa.images || []);
    } else {
        console.error('populateExistingImages function not found');
    }
}

// Change table limit (records per page)
function changeVillaTableLimit(newLimit) {
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
<?= $this->include('villas/create_modal') ?>
<?= $this->include('villas/edit_modal') ?>
<?= $this->include('villas/view_modal') ?>

<?= $this->include('layout/footer.php') ?>