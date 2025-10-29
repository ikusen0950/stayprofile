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

/* Permission cards styling */
.permission-card {
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
}

.permission-card:hover {
    border-color: var(--bs-primary);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.permission-card.selected {
    border-color: var(--bs-success);
    background-color: var(--bs-success-bg-subtle);
}

.permission-checkbox {
    transform: scale(1.3);
    margin-right: 0.75rem;
}

.module-header {
    background: linear-gradient(135deg, var(--bs-primary), var(--bs-primary-dark));
    color: white;
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
    position: sticky;
    top: 0;
    z-index: 10;
}

.permission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.group-selector {
    background: var(--bs-light);
    border-radius: 0.75rem;
    padding: 1.5rem;
    margin-bottom: 2rem;
    border: 2px solid var(--bs-border-color);
}

.stats-card {
    background: linear-gradient(135deg, var(--bs-info), var(--bs-info-dark));
    color: white;
    border-radius: 0.75rem;
    padding: 1rem;
    text-align: center;
}

.mobile-group-card {
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
}

.mobile-group-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    border-color: var(--bs-primary);
}

.mobile-group-card.active {
    border-color: var(--bs-success);
    background-color: var(--bs-success-bg-subtle);
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
    .permission-grid {
        grid-template-columns: 1fr;
    }
    
    .mobile-search-bar {
        position: sticky;
        top: 60px !important;
    }
    
    .mobile-permission-grid {
        display: block;
    }
    
    .mobile-permission-grid .permission-card {
        margin-bottom: 0.5rem;
        border: 1px solid var(--bs-border-color);
        transition: all 0.3s ease;
    }
    
    .mobile-permission-grid .permission-card:hover {
        border-color: var(--bs-primary);
        transform: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .mobile-permission-grid .permission-card.selected {
        border-color: var(--bs-success);
        background-color: var(--bs-success-bg-subtle);
    }
}

/* Select all/none buttons */
.selection-controls {
    display: flex;
    gap: 0.5rem;
    margin-bottom: 1rem;
    flex-wrap: wrap;
}

.selection-controls .btn {
    font-size: 0.875rem;
}

/* Permission search functionality */
.permission-search-container {
    background: var(--bs-light);
    border-radius: 0.75rem;
    padding: 1rem;
    margin-bottom: 1.5rem;
    border: 2px solid var(--bs-border-color);
}

.search-input-group {
    position: relative;
}

.search-input-group .form-control {
    padding-left: 3rem;
    border-radius: 0.5rem;
    border: 2px solid var(--bs-border-color);
    transition: all 0.3s ease;
}

.search-input-group .form-control:focus {
    border-color: var(--bs-primary);
    box-shadow: 0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.25);
}

.search-input-group .search-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: var(--bs-gray-500);
    z-index: 10;
}

.search-results-info {
    font-size: 0.875rem;
    color: var(--bs-gray-600);
    margin-top: 0.5rem;
}

.permission-card.search-hidden {
    display: none !important;
}

.module-section.search-hidden {
    display: none !important;
}

.search-highlight {
    background-color: yellow;
    padding: 0.1rem 0.2rem;
    border-radius: 0.2rem;
    font-weight: bold;
}

/* Progress indicator */
.permission-progress {
    height: 6px;
    background: var(--bs-gray-200);
    border-radius: 3px;
    overflow: hidden;
    margin-bottom: 1rem;
}

.permission-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, var(--bs-success), var(--bs-info));
    transition: width 0.3s ease;
    border-radius: 3px;
}
</style>

<!--begin::Mobile UI (visible on mobile only)-->
<div class="d-lg-none">
    <!-- Fixed Header -->
    <div class="mobile-search-bar position-sticky py-3 mb-2" style="top: 60px !important;">
        <div class="container-fluid">
            <div class="mb-2">
                <h1 class="text-dark fw-bold ms-2">Group Permissions</h1>
            </div>
            
            <!-- Group Selector for Mobile -->
            <div class="row">
                <div class="col-12">
                    <select class="form-select form-select-solid" id="mobile_group_selector">
                        <option value="">Select a role to manage permissions...</option>
                        <?php foreach ($groups as $group): ?>
                        <option value="<?= esc($group['id']) ?>" <?= $selectedGroupId == $group['id'] ? 'selected' : '' ?>>
                            <?= esc($group['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Container -->
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

        <!-- Mobile Groups List (when no group selected) -->
        <div id="mobile-groups-list" class="<?= $selectedGroupId ? 'd-none' : '' ?>">
            <div class="row" id="mobile-cards-container">
                <?php foreach ($groupsWithCounts as $index => $group): ?>
                <div class="col-12 mb-3" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>" data-aos-duration="600">
                    <div class="card mobile-group-card" data-group-id="<?= esc($group['id']) ?>">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h5 class="mb-1 fw-bold"><?= esc($group['name']) ?></h5>
                                    <?php if (!empty($group['description'])): ?>
                                    <p class="text-muted mb-0 small"><?= esc($group['description']) ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="ms-3">
                                    <span class="badge badge-light-primary">
                                        <?= $group['permission_count'] ?> permissions
                                    </span>
                                </div>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <small class="text-muted">Click to manage permissions</small>
                                <i class="ki-duotone ki-arrow-right fs-3 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Mobile Permission Management (when group selected) -->
        <div id="mobile-permissions-form" class="<?= !$selectedGroupId ? 'd-none' : '' ?>">
            <?php if ($selectedGroup): ?>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1 fw-bold"><?= esc($selectedGroup['name']) ?></h6>
                            <small class="text-muted"><?= esc($selectedGroup['description']) ?></small>
                        </div>
                        <button type="button" class="btn btn-light btn-sm" onclick="clearGroupSelection()">
                            <i class="ki-duotone ki-arrow-left fs-4"></i>
                            Back
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Permission Search -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-7">Search Permissions</label>
                        <div class="search-input-group">
                            <i class="ki-duotone ki-magnifier fs-4 search-icon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" 
                                   class="form-control form-control-solid" 
                                   id="mobile-permission-search" 
                                   placeholder="Search permissions...">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="search-results-info fs-8" id="mobile-search-results-info">
                            Showing all permissions
                        </div>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-light-primary btn-sm" onclick="clearSearch()">
                                <i class="ki-duotone ki-cross fs-5"></i>
                            </button>
                            <button type="button" class="btn btn-light-warning btn-sm" onclick="selectVisiblePermissions()">
                                <i class="ki-duotone ki-check fs-5"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Permission Management Form will be loaded here -->
            <div id="permissions-content">
                <?php if ($selectedGroupId && $selectedGroup): ?>
                <!-- Mobile Permission Form -->
                <form id="mobilePermissionsForm" method="POST" action="/group-permissions/update">
                    <input type="hidden" name="group_id" value="<?= esc($selectedGroupId) ?>">
                    
                    <!-- Mobile Selection Controls -->
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0 fw-bold">Quick Actions</h6>
                                <span class="badge badge-info" id="mobile-selected-count">
                                    <?= count($assignedPermissionIds) ?> selected
                                </span>
                            </div>
                            <div class="d-flex gap-2 flex-wrap">
                                <button type="button" class="btn btn-light-success btn-sm" onclick="selectAllPermissions()">
                                    <i class="ki-duotone ki-check-square fs-5 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    All
                                </button>
                                <button type="button" class="btn btn-light-danger btn-sm" onclick="selectNonePermissions()">
                                    <i class="ki-duotone ki-close-square fs-5 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    None
                                </button>
                                <button type="button" class="btn btn-light-warning btn-sm" onclick="selectVisiblePermissions()">
                                    <i class="ki-duotone ki-check fs-5 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Visible
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Progress Bar -->
                    <div class="card mb-3">
                        <div class="card-body py-2">
                            <div class="permission-progress">
                                <div class="permission-progress-bar" id="mobile-progress-bar" style="width: <?= round((count($assignedPermissionIds) / array_sum(array_map('count', $permissionsGrouped))) * 100, 1) ?>%"></div>
                            </div>
                            <div class="text-center fs-8 text-muted mt-1">
                                <?= count($assignedPermissionIds) ?> of <?= array_sum(array_map('count', $permissionsGrouped)) ?> permissions assigned
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Permissions by Module -->
                    <?php foreach ($permissionsGrouped as $module => $permissions): ?>
                    <div class="module-section mb-4" data-module="<?= esc($module) ?>">
                        <!-- Mobile Module Header -->
                        <div class="card mb-2">
                            <div class="card-body py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1 fw-bold text-primary"><?= esc($module) ?> Module</h6>
                                        <small class="text-muted"><?= count($permissions) ?> permissions</small>
                                    </div>
                                    <button type="button" class="btn btn-light-primary btn-sm" onclick="toggleModulePermissions('<?= esc($module) ?>')">
                                        <i class="ki-duotone ki-toggle-on fs-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Permission Cards -->
                        <div class="permission-grid mobile-permission-grid" data-module="<?= esc($module) ?>">
                            <?php foreach ($permissions as $permission): ?>
                            <div class="permission-card card mb-2" data-permission-id="<?= esc($permission['id']) ?>">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-start">
                                        <input type="checkbox" 
                                               class="form-check-input permission-checkbox me-3 mt-1" 
                                               name="permissions[]" 
                                               value="<?= esc($permission['id']) ?>"
                                               id="mobile_perm_<?= esc($permission['id']) ?>"
                                               <?= in_array($permission['id'], $assignedPermissionIds) ? 'checked' : '' ?>>
                                        <div class="flex-grow-1">
                                            <label for="mobile_perm_<?= esc($permission['id']) ?>" class="form-label fw-bold mb-1 cursor-pointer fs-7">
                                                <?= esc($permission['action']) ?>
                                            </label>
                                            <div class="text-muted fs-8 mb-1"><?= esc($permission['description']) ?></div>
                                            <div class="text-primary fs-9">
                                                <code><?= esc($permission['name']) ?></code>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>

                    <!-- Mobile Submit Button -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg" id="mobile-save-permissions-btn">
                            <span class="indicator-label">
                                <i class="ki-duotone ki-check fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Save Permissions
                            </span>
                            <span class="indicator-progress">
                                Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--end::Mobile UI-->

<!--begin::Main Desktop UI-->
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
                        <div class="card-title">
                            <h1 class="fw-bold text-dark">
                                <i class="ki-duotone ki-security-user fs-1 me-3 text-primary">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Group Permissions Management
                            </h1>
                        </div>
                    </div>
                    <!--end::Card header-->

                    <!--begin::Card body-->
                    <div class="card-body py-4">
                        
                        <!-- Group Selector -->
                        <div class="group-selector">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <label class="form-label fw-bold fs-6 mb-2">Select Role to Manage Permissions:</label>
                                    <select class="form-select form-select-solid" id="group_selector" name="group_id">
                                        <option value="">Choose a role...</option>
                                        <?php foreach ($groups as $group): ?>
                                        <option value="<?= esc($group['id']) ?>" <?= $selectedGroupId == $group['id'] ? 'selected' : '' ?>>
                                            <?= esc($group['name']) ?> - <?= esc($group['description']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <?php if ($selectedGroupId): ?>
                                    <div class="stats-card">
                                        <div class="fs-4 fw-bold" id="assigned-count"><?= count($assignedPermissionIds) ?></div>
                                        <div class="fs-7">Permissions Assigned</div>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Permission Management Form -->
                        <?php if ($selectedGroupId && $selectedGroup): ?>
                        <form id="permissionsForm" method="POST" action="/group-permissions/update">
                            <input type="hidden" name="group_id" value="<?= esc($selectedGroupId) ?>">
                            
                            <!-- Selection Controls -->
                            <div class="selection-controls">
                                <button type="button" class="btn btn-light-success btn-sm" onclick="selectAllPermissions()">
                                    <i class="ki-duotone ki-check-square fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Select All
                                </button>
                                <button type="button" class="btn btn-light-danger btn-sm" onclick="selectNonePermissions()">
                                    <i class="ki-duotone ki-close-square fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Select None
                                </button>
                                <div class="ms-auto">
                                    <span class="badge badge-info fs-7" id="selected-count">
                                        <?= count($assignedPermissionIds) ?> selected
                                    </span>
                                </div>
                            </div>

                            <!-- Permission Search -->
                            <div class="permission-search-container">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold fs-6 mb-2">Search Permissions:</label>
                                        <div class="search-input-group">
                                            <i class="ki-duotone ki-magnifier fs-3 search-icon">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="text" 
                                                   class="form-control form-control-solid" 
                                                   id="permission-search" 
                                                   placeholder="Search permissions by name, description, or module...">
                                        </div>
                                        <div class="search-results-info" id="search-results-info">
                                            Showing all <?= array_sum(array_map('count', $permissionsGrouped)) ?> permissions
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex gap-2">
                                            <button type="button" class="btn btn-light-primary btn-sm" onclick="clearSearch()">
                                                <i class="ki-duotone ki-cross fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Clear
                                            </button>
                                            <button type="button" class="btn btn-light-warning btn-sm" onclick="selectVisiblePermissions()">
                                                <i class="ki-duotone ki-check fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Select Visible
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Bar -->
                            <div class="permission-progress">
                                <div class="permission-progress-bar" id="progress-bar" style="width: <?= round((count($assignedPermissionIds) / array_sum(array_map('count', $permissionsGrouped))) * 100, 1) ?>%"></div>
                            </div>

                            <!-- Permissions by Module -->
                            <?php foreach ($permissionsGrouped as $module => $permissions): ?>
                            <div class="module-section mb-6">
                                <div class="module-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h4 class="mb-1 text-dark"><?= esc($module) ?> Module</h4>
                                            <small class="text-dark-50"><?= count($permissions) ?> permissions available</small>
                                        </div>
                                        <div>
                                            <button type="button" class="btn btn-light btn-sm" onclick="toggleModulePermissions('<?= esc($module) ?>')">
                                                <i class="ki-duotone ki-toggle-on fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                Toggle All
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <div class="permission-grid" data-module="<?= esc($module) ?>">
                                    <?php foreach ($permissions as $permission): ?>
                                    <div class="permission-card card h-100" data-permission-id="<?= esc($permission['id']) ?>">
                                        <div class="card-body d-flex align-items-center p-4">
                                            <input type="checkbox" 
                                                   class="form-check-input permission-checkbox" 
                                                   name="permissions[]" 
                                                   value="<?= esc($permission['id']) ?>"
                                                   id="perm_<?= esc($permission['id']) ?>"
                                                   <?= in_array($permission['id'], $assignedPermissionIds) ? 'checked' : '' ?>>
                                            <div class="flex-grow-1">
                                                <label for="perm_<?= esc($permission['id']) ?>" class="form-label fw-bold mb-1 cursor-pointer">
                                                    <?= esc($permission['action']) ?>
                                                </label>
                                                <div class="text-muted fs-7"><?= esc($permission['description']) ?></div>
                                                <div class="text-primary fs-8 mt-1">
                                                    <code><?= esc($permission['name']) ?></code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end mt-6">
                                <button type="submit" class="btn btn-primary btn-lg" id="save-permissions-btn">
                                    <span class="indicator-label">
                                        <i class="ki-duotone ki-check fs-2 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        Save Permissions
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </form>
                        <?php else: ?>
                        <!-- No Group Selected -->
                        <div class="text-center py-10">
                            <i class="ki-duotone ki-security-user fs-5x text-gray-500 mb-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <h5 class="text-gray-700 mb-3">Select a Role to Manage Permissions</h5>
                            <p class="text-gray-500 mb-0">Choose a role from the dropdown above to view and manage its permissions.</p>
                        </div>
                        <?php endif; ?>

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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS for mobile
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600,
            easing: 'ease-in-out',
            once: false,
            mirror: false
        });
    }

    // Group selector change handlers
    const groupSelector = document.getElementById('group_selector');
    const mobileGroupSelector = document.getElementById('mobile_group_selector');

    if (groupSelector) {
        groupSelector.addEventListener('change', function() {
            if (this.value) {
                window.location.href = `/group-permissions?group=${this.value}`;
            } else {
                window.location.href = `/group-permissions`;
            }
        });
    }

    if (mobileGroupSelector) {
        mobileGroupSelector.addEventListener('change', function() {
            if (this.value) {
                window.location.href = `/group-permissions?group=${this.value}`;
            } else {
                clearGroupSelection();
            }
        });
    }

    // Mobile group card clicks
    document.querySelectorAll('.mobile-group-card').forEach(card => {
        card.addEventListener('click', function() {
            const groupId = this.getAttribute('data-group-id');
            window.location.href = `/group-permissions?group=${groupId}`;
        });
    });

    // Permission checkbox change handler
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', updatePermissionCount);
    });

    // Permission card click handler
    document.querySelectorAll('.permission-card').forEach(card => {
        card.addEventListener('click', function(e) {
            if (e.target.type !== 'checkbox') {
                const checkbox = this.querySelector('.permission-checkbox');
                checkbox.checked = !checkbox.checked;
                checkbox.dispatchEvent(new Event('change'));
                updateCardAppearance(this);
            }
        });
    });

    // Form submission
    const form = document.getElementById('permissionsForm');
    const mobileForm = document.getElementById('mobilePermissionsForm');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            savePermissions();
        });
    }
    
    if (mobileForm) {
        mobileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            savePermissions('mobile');
        });
    }

    // Permission search functionality
    const searchInput = document.getElementById('permission-search');
    const mobileSearchInput = document.getElementById('mobile-permission-search');

    function initializeSearch() {
        [searchInput, mobileSearchInput].forEach(input => {
            if (input) {
                input.addEventListener('input', function() {
                    performSearch(this.value);
                });
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        clearSearch();
                    }
                });
            }
        });
    }

    // Initialize search functionality
    initializeSearch();

    // Initialize card appearances
    updateAllCardAppearances();
    updatePermissionCount();
});

function selectAllPermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = true;
    });
    updateAllCardAppearances();
    updatePermissionCount();
}

function selectNonePermissions() {
    document.querySelectorAll('.permission-checkbox').forEach(checkbox => {
        checkbox.checked = false;
    });
    updateAllCardAppearances();
    updatePermissionCount();
}

function toggleModulePermissions(module) {
    const moduleContainer = document.querySelector(`[data-module="${module}"]`);
    const checkboxes = moduleContainer.querySelectorAll('.permission-checkbox');
    
    // Check if all are selected
    const allSelected = Array.from(checkboxes).every(cb => cb.checked);
    
    // Toggle based on current state
    checkboxes.forEach(checkbox => {
        checkbox.checked = !allSelected;
    });
    
    updateAllCardAppearances();
    updatePermissionCount();
}

function updatePermissionCount() {
    const selectedCheckboxes = document.querySelectorAll('.permission-checkbox:checked');
    const totalCheckboxes = document.querySelectorAll('.permission-checkbox');
    const count = selectedCheckboxes.length;
    const total = totalCheckboxes.length;
    
    // Update desktop counters
    const selectedCountElement = document.getElementById('selected-count');
    const assignedCountElement = document.getElementById('assigned-count');
    
    if (selectedCountElement) {
        selectedCountElement.textContent = `${count} selected`;
    }
    
    if (assignedCountElement) {
        assignedCountElement.textContent = count;
    }
    
    // Update mobile counters
    const mobileSelectedCountElement = document.getElementById('mobile-selected-count');
    if (mobileSelectedCountElement) {
        mobileSelectedCountElement.textContent = `${count} selected`;
    }
    
    // Update progress bars
    const progressBar = document.getElementById('progress-bar');
    const mobileProgressBar = document.getElementById('mobile-progress-bar');
    
    if (total > 0) {
        const percentage = (count / total) * 100;
        if (progressBar) {
            progressBar.style.width = `${percentage}%`;
        }
        if (mobileProgressBar) {
            mobileProgressBar.style.width = `${percentage}%`;
        }
    }
}

function updateCardAppearance(card) {
    const checkbox = card.querySelector('.permission-checkbox');
    if (checkbox.checked) {
        card.classList.add('selected');
    } else {
        card.classList.remove('selected');
    }
}

function updateAllCardAppearances() {
    document.querySelectorAll('.permission-card').forEach(updateCardAppearance);
}

function savePermissions(formType = 'desktop') {
    const form = formType === 'mobile' ? document.getElementById('mobilePermissionsForm') : document.getElementById('permissionsForm');
    const submitBtn = formType === 'mobile' ? document.getElementById('mobile-save-permissions-btn') : document.getElementById('save-permissions-btn');
    
    if (!form || !submitBtn) return;
    
    // Show loading state
    submitBtn.disabled = true;
    submitBtn.querySelector('.indicator-label').style.display = 'none';
    submitBtn.querySelector('.indicator-progress').style.display = 'inline-block';
    
    const formData = new FormData(form);
    
    fetch('/group-permissions/update', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            });
            
            // Update counter if provided
            if (data.assigned_count !== undefined) {
                const assignedCountElement = document.getElementById('assigned-count');
                const mobileSelectedCountElement = document.getElementById('mobile-selected-count');
                
                if (assignedCountElement) {
                    assignedCountElement.textContent = data.assigned_count;
                }
                if (mobileSelectedCountElement) {
                    mobileSelectedCountElement.textContent = `${data.assigned_count} selected`;
                }
            }
        } else {
            Swal.fire('Error', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button state
        submitBtn.disabled = false;
        submitBtn.querySelector('.indicator-label').style.display = 'inline-block';
        submitBtn.querySelector('.indicator-progress').style.display = 'none';
    });
}

// Permission search functions
function performSearch(query) {
    const searchTerm = query.toLowerCase().trim();
    let visibleCount = 0;
    let totalCount = 0;
    
    // Get all permission cards and modules
    const permissionCards = document.querySelectorAll('.permission-card');
    const moduleSections = document.querySelectorAll('.module-section');
    
    // Clear previous highlights
    clearSearchHighlights();
    
    if (searchTerm === '') {
        // Show all permissions
        permissionCards.forEach(card => {
            card.classList.remove('search-hidden');
            totalCount++;
            visibleCount++;
        });
        
        moduleSections.forEach(section => {
            section.classList.remove('search-hidden');
        });
    } else {
        // Search through permissions
        moduleSections.forEach(section => {
            let moduleHasVisibleCards = false;
            const moduleCards = section.querySelectorAll('.permission-card');
            
            moduleCards.forEach(card => {
                totalCount++;
                
                // Get permission details - handle both desktop and mobile structures
                const permissionNameElement = card.querySelector('label');
                const permissionDescriptionElement = card.querySelector('.text-muted');
                const permissionCodeElement = card.querySelector('code');
                
                // Get module name - handle different structures
                let moduleNameElement = section.querySelector('.module-header h4');
                if (!moduleNameElement) {
                    moduleNameElement = section.querySelector('h6'); // Mobile structure
                }
                
                // Safely get text content
                const permissionName = permissionNameElement ? permissionNameElement.textContent.toLowerCase() : '';
                const permissionDescription = permissionDescriptionElement ? permissionDescriptionElement.textContent.toLowerCase() : '';
                const permissionCode = permissionCodeElement ? permissionCodeElement.textContent.toLowerCase() : '';
                const moduleName = moduleNameElement ? moduleNameElement.textContent.toLowerCase() : '';
                
                const searchContent = `${permissionName} ${permissionDescription} ${permissionCode} ${moduleName}`;
                
                if (searchContent.includes(searchTerm)) {
                    card.classList.remove('search-hidden');
                    moduleHasVisibleCards = true;
                    visibleCount++;
                    
                    // Highlight matching text
                    highlightSearchTerm(card, searchTerm);
                } else {
                    card.classList.add('search-hidden');
                }
            });
            
            // Hide module if no cards are visible
            if (moduleHasVisibleCards) {
                section.classList.remove('search-hidden');
            } else {
                section.classList.add('search-hidden');
            }
        });
    }
    
    // Update search results info
    updateSearchResultsInfo(visibleCount, totalCount, searchTerm);
}

function highlightSearchTerm(card, searchTerm) {
    const label = card.querySelector('label');
    const description = card.querySelector('.text-muted');
    const code = card.querySelector('code');
    
    [label, description, code].forEach(element => {
        if (element) {
            const text = element.textContent;
            const regex = new RegExp(`(${escapeRegex(searchTerm)})`, 'gi');
            const highlightedText = text.replace(regex, '<span class="search-highlight">$1</span>');
            
            if (highlightedText !== text) {
                element.innerHTML = highlightedText;
            }
        }
    });
}

function clearSearchHighlights() {
    document.querySelectorAll('.search-highlight').forEach(highlight => {
        const parent = highlight.parentNode;
        parent.replaceChild(document.createTextNode(highlight.textContent), highlight);
        parent.normalize();
    });
}

function escapeRegex(string) {
    return string.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
}

function updateSearchResultsInfo(visible, total, searchTerm) {
    const desktopInfo = document.getElementById('search-results-info');
    const mobileInfo = document.getElementById('mobile-search-results-info');
    
    let message;
    if (searchTerm === '') {
        message = `Showing all ${total} permissions`;
    } else {
        message = `Showing ${visible} of ${total} permissions matching "${searchTerm}"`;
    }
    
    [desktopInfo, mobileInfo].forEach(element => {
        if (element) {
            element.textContent = message;
        }
    });
}

function clearSearch() {
    const searchInput = document.getElementById('permission-search');
    const mobileSearchInput = document.getElementById('mobile-permission-search');
    
    [searchInput, mobileSearchInput].forEach(input => {
        if (input) {
            input.value = '';
        }
    });
    
    performSearch('');
}

function selectVisiblePermissions() {
    const visibleCards = document.querySelectorAll('.permission-card:not(.search-hidden)');
    
    visibleCards.forEach(card => {
        const checkbox = card.querySelector('.permission-checkbox');
        if (checkbox) {
            checkbox.checked = true;
        }
    });
    
    updateAllCardAppearances();
    updatePermissionCount();
}

function clearGroupSelection() {
    window.location.href = '/group-permissions';
}
</script>

<?= $this->include('layout/footer.php') ?>