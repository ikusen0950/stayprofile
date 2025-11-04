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
.mobile-question-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.mobile-question-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.mobile-question-card:active {
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

/* Type badge styles */
.type-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.375rem;
}

.question-required {
    color: #dc3545;
    font-weight: bold;
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<?= $this->include('questions/mobile_view.php') ?>
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
                            Questions
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
                                Questions </li>
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
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search questions..."
                                value="<?= esc($search) ?>" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="col-6">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-questions-table-toolbar="base">
                            <!--begin::Add question-->
                            <?php if ($permissions['canCreate']): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createQuestionModal">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Question
                            </button>
                            <?php endif; ?>
                            <!--end::Add question-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>


                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_questions_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_questions_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-20px">#</th>
                                <th class="min-w-150px">Label</th>
                                <th class="min-w-80px">Type</th>
                                <th class="min-w-80px">Page</th>
                                <th class="min-w-60px">Required</th>
                                <th class="min-w-60px">Active</th>
                                <th class="min-w-60px">Sort</th>
                                <th class="min-w-120px">Created By</th>
                                <th class="text-end min-w-100px">Actions</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->

                        <!--begin::Table body-->
                        <tbody class="text-gray-600 fw-semibold">
                            <?php if (!empty($questions)): ?>
                            <?php foreach ($questions as $question): ?>
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox"
                                            value="<?= esc($question['id']) ?>" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->

                                <!--begin::ID-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">#<?= esc($question['id']) ?></small>
                                    </div>
                                </td>
                                <!--end::ID-->

                                <!--begin::Label-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold text-dark"><?= esc($question['label']) ?></div>
                                        <?php if (!empty($question['description'])): ?>
                                        <small class="text-muted"><?= esc(substr($question['description'], 0, 100)) ?><?= strlen($question['description']) > 100 ? '...' : '' ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Label-->

                                <!--begin::Type-->
                                <td>
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
                                </td>
                                <!--end::Type-->

                                <!--begin::Page-->
                                <td>
                                    <span class="text-gray-600"><?= esc($question['page']) ?: '-' ?></span>
                                </td>
                                <!--end::Page-->

                                <!--begin::Required-->
                                <td>
                                    <?php if ($question['is_required']): ?>
                                    <span class="badge bg-light-danger question-required">Yes</span>
                                    <?php else: ?>
                                    <span class="badge bg-light-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <!--end::Required-->

                                <!--begin::Active-->
                                <td>
                                    <?php if ($question['is_active']): ?>
                                    <span class="badge bg-light-success">Active</span>
                                    <?php else: ?>
                                    <span class="badge bg-light-danger">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <!--end::Active-->

                                <!--begin::Sort Order-->
                                <td>
                                    <span class="text-gray-600"><?= esc($question['sort_order']) ?></span>
                                </td>
                                <!--end::Sort Order-->

                                <!--begin::Created By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($question['created_by_name'])): ?>
                                        <span class="text-muted"><?= esc($question['created_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($question['created_at'])) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Created By-->

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
                                            <a class="menu-link px-3 view-question-btn"
                                                data-question-id="<?= esc($question['id']) ?>">View</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if ($permissions['canEdit']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 edit-question-btn"
                                                data-question-id="<?= esc($question['id']) ?>">Edit</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if ($permissions['canDelete']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 delete-question-btn"
                                                data-question-id="<?= esc($question['id']) ?>">Delete</a>
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
                                <td colspan="10" class="text-center py-10">
                                    <div class="d-flex flex-column align-items-center">
                                        <i class="ki-duotone ki-folder fs-5x text-gray-500 mb-3">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <div class="fw-bold text-gray-700 mb-2">No questions found</div>
                                        <div class="text-gray-500">Start by creating your first question
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
                            'baseUrl' => 'questions',
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'limit' => $limit,
                            'totalRecords' => $totalQuestions,
                            'search' => $search,
                            'tableId' => 'kt_questions_table_length',
                            'jsFunction' => 'changeQuestionsTableLimit'
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
    const existingCards = document.querySelectorAll('#mobile-cards-container .mobile-question-card');
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
                loadQuestions(true, query);
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

    // Load initial questions for mobile
    const mobileContainer = document.getElementById('mobile-cards-container');
    if (mobileContainer) {
        // Only load initial data if container is empty (no server-rendered content)
        const existingCards = mobileContainer.querySelectorAll('.mobile-question-card');
        if (existingCards.length === 0) {
            loadQuestions(false);
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
                        loadQuestions(false, mobileSearch?.value || '');
                    }
                }
            }, 100);
        });
    }

    // Handle view question
    document.addEventListener('click', function(e) {
        if (e.target.closest('.view-question-btn')) {
            e.preventDefault();
            const questionId = e.target.closest('.view-question-btn').getAttribute('data-question-id');
            viewQuestion(questionId);
        }
    });

    // Handle edit question
    document.addEventListener('click', function(e) {
        if (e.target.closest('.edit-question-btn')) {
            e.preventDefault();
            const questionId = e.target.closest('.edit-question-btn').getAttribute('data-question-id');
            editQuestion(questionId);
        }
    });

    // Handle delete question
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-question-btn')) {
            e.preventDefault();
            const questionId = e.target.closest('.delete-question-btn').getAttribute('data-question-id');
            deleteQuestion(questionId);
        }
    });

});

function loadQuestions(reset = false, search = '') {
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

    const url = `/questions/api?page=${currentPage}&limit=10&search=${encodeURIComponent(search)}`;

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
                    renderQuestions(data.data);
                    currentPage++;
                    hasMoreData = data.hasMore;

                    // Reinitialize AOS for new elements
                    if (typeof AOS !== 'undefined') {
                        AOS.refresh();
                    }
                } else {
                    hasMoreData = false;
                    if (currentPage === 1) {
                        showNoQuestionsMessage();
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

function renderQuestions(questions) {
    const container = document.getElementById('mobile-cards-container');
    if (!container) return;

    questions.forEach((question, index) => {
        const questionCard = createQuestionCard(question, (currentPage - 1) * 10 + index);
        container.appendChild(questionCard);
    });

    // Reinitialize mobile cards after adding new ones
    initMobileCards();
}

function createQuestionCard(question, index) {
    const col = document.createElement('div');
    col.className = 'col-12 mb-3';
    col.setAttribute('data-aos', 'fade-up');
    col.setAttribute('data-aos-delay', (index * 100).toString());
    col.setAttribute('data-aos-duration', '600');

    const description = question.description ?
        `<p class="text-muted fs-7 mb-0 mt-1">${question.description.substring(0, 100)}${question.description.length > 100 ? '...' : ''}</p>` : '';

    const createdByName = question.created_by_name || 'System';
    const createdAt = new Date(question.created_at).toLocaleDateString('en-US', {
        month: 'short',
        day: '2-digit',
        year: 'numeric'
    });

    // Determine type badge styling
    const typeColors = {
        'text': 'bg-light-primary',
        'textarea': 'bg-light-info',
        'single_mcq': 'bg-light-warning',
        'multi_mcq': 'bg-light-success',
        'text_block': 'bg-light-secondary'
    };
    const typeNames = {
        'text': 'Text',
        'textarea': 'Textarea',
        'single_mcq': 'Single MCQ',
        'multi_mcq': 'Multi MCQ',
        'text_block': 'Text Block'
    };
    const typeBadgeClass = typeColors[question.type] || 'bg-light-secondary';
    const typeName = typeNames[question.type] || question.type;

    // Create action buttons based on permissions
    let actionButtons = '';
    <?php if ($permissions['canView']): ?>
    actionButtons += `
        <div class="col-4">
            <button type="button" class="btn btn-light-warning btn-sm w-100 d-flex align-items-center justify-content-center view-question-btn" data-question-id="${question.id}">
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
            <button type="button" class="btn btn-light-primary btn-sm w-100 d-flex align-items-center justify-content-center edit-question-btn" data-question-id="${question.id}">
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
            <button class="btn btn-light-danger btn-sm w-100 d-flex align-items-center justify-content-center delete-question-btn" data-question-id="${question.id}">
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
        <div class="card mobile-question-card" data-question-id="${question.id}">
            <div class="card-body p-4">
                <!-- Question Header -->
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="flex-grow-1">
                        <small class="text-muted text-uppercase">#${question.id}</small>
                        <h6 class="fw-bold text-dark mt-1 mb-0">${question.label}</h6>
                        ${description}
                    </div>
                </div>

                <!-- Question Info -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <span class="badge ${typeBadgeClass} type-badge">${typeName}</span>
                    </div>
                    <div class="col-6 text-end">
                        ${question.is_required ? '<span class="badge bg-light-danger question-required fs-8">Required</span>' : ''}
                        ${question.is_active ? '<span class="badge bg-light-success fs-8">Active</span>' : '<span class="badge bg-light-danger fs-8">Inactive</span>'}
                    </div>
                </div>

                <!-- Question Footer -->
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex flex-column">
                        <small class="text-muted">Page: ${question.page || 'N/A'}</small>
                        <small class="text-muted">Sort: ${question.sort_order || 0}</small>
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

function showNoQuestionsMessage() {
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
            <h6 class="fw-bold text-gray-700 mb-2">No questions found</h6>
            <p class="fs-7 text-gray-500 mb-4">Start by creating your first question</p>
        </div>
    `;
    container.appendChild(noDataDiv);
}

// Mobile card click functionality (matching modules UI)
function initMobileCards() {
    // Remove existing listeners to prevent duplicates
    document.querySelectorAll('.mobile-question-card').forEach(function(card) {
        card.replaceWith(card.cloneNode(true));
    });

    document.querySelectorAll('.mobile-question-card').forEach(function(card) {
        card.addEventListener('click', function(e) {
            if (e.target.closest('.mobile-actions') || e.target.closest('button') || e.target.closest('a')) {
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
function viewQuestion(questionId) {
    secureFetch(`/questions/show/${questionId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate view modal with question and options data
                populateViewModal(data);
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('viewQuestionModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load question details', 'error');
        });
}

function editQuestion(questionId) {
    secureFetch(`/questions/show/${questionId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Populate edit modal with question and options data
                populateEditModal(data);
                // Show modal
                const modal = new bootstrap.Modal(document.getElementById('editQuestionModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load question details', 'error');
        });
}

function deleteQuestion(questionId) {
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
            secureFetch(`/questions/delete/${questionId}`, {
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
                    Swal.fire('Error', 'Failed to delete question', 'error');
                });
        }
    });
}

// Change table limit (records per page)
function changeQuestionsTableLimit(newLimit) {
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
<?= $this->include('questions/create_modal') ?>
<?= $this->include('questions/edit_modal') ?>
<?= $this->include('questions/view_modal') ?>

<?= $this->include('layout/footer.php') ?>