<?= $this->include('layout/header.php') ?>

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    <?= esc($title ?? 'Authorization Rules') ?>
                </h1>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            
            <!-- Search and Create Section -->
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <!-- Search -->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" data-kt-filter="search" class="form-control form-control-solid w-250px ps-12" placeholder="Search authorization rules" value="<?= esc($search ?? '') ?>" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <?php if (isset($permissions['canCreate']) && $permissions['canCreate']): ?>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAuthorizationRuleModal">
                            <i class="ki-duotone ki-plus fs-2"></i>
                            Add Authorization Rule
                        </button>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <!-- Authorization Rules Table -->
                    <div class="table-responsive">
                        <table class="table table-row-dashed fs-6 gy-5" id="authorization_rules_table">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-125px">User</th>
                                    <th class="min-w-100px">Rule Type</th>
                                    <th class="min-w-100px">Target Type</th>
                                    <th class="min-w-100px">Approval Level</th>
                                    <th class="min-w-100px">Status</th>
                                    <th class="min-w-200px">Description</th>
                                    <th class="min-w-70px">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                <?php if (!empty($authorizationRules)): ?>
                                    <?php foreach ($authorizationRules as $rule): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="d-flex flex-column">
                                                    <span class="text-gray-800 fw-bold"><?= esc($rule['user_display_name'] ?? $rule['user_name']) ?></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if ($rule['rule_type'] === 'multiple'): ?>
                                                <span class="badge badge-light-success">Multiple Rules</span>
                                                <small class="d-block text-muted mt-1">
                                                    <?php 
                                                    $rulesConfig = json_decode($rule['rules_config'] ?? '[]', true);
                                                    echo count($rulesConfig) . ' configurations';
                                                    ?>
                                                </small>
                                            <?php else: ?>
                                                <span class="badge badge-light-primary"><?= esc(ucfirst($rule['rule_type'])) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($rule['target_type'] === 'multiple'): ?>
                                                <span class="badge badge-light-success">Multiple Targets</span>
                                                <?php 
                                                $rulesConfig = json_decode($rule['rules_config'] ?? '[]', true);
                                                if (!empty($rulesConfig)): 
                                                    $targets = array_unique(array_column($rulesConfig, 'target_type'));
                                                ?>
                                                    <small class="d-block text-muted mt-1">
                                                        <?= implode(', ', array_map('ucfirst', $targets)) ?>
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <span class="badge badge-light-info"><?= esc(ucfirst($rule['target_type'])) ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($rule['approval_level'] === 'multiple'): ?>
                                                <span class="badge badge-light-success">Multiple Levels</span>
                                                <?php 
                                                $rulesConfig = json_decode($rule['rules_config'] ?? '[]', true);
                                                if (!empty($rulesConfig)): 
                                                    $approvals = array_unique(array_column($rulesConfig, 'approval_level'));
                                                    $approvalLabels = [];
                                                    foreach ($approvals as $approval) {
                                                        switch ($approval) {
                                                            case 'level_1': $approvalLabels[] = 'L1'; break;
                                                            case 'level_2': $approvalLabels[] = 'L2'; break;
                                                            case 'level_3': $approvalLabels[] = 'L3'; break;
                                                            case 'no_approval': $approvalLabels[] = 'None'; break;
                                                        }
                                                    }
                                                ?>
                                                    <small class="d-block text-muted mt-1">
                                                        <?= implode(', ', $approvalLabels) ?>
                                                    </small>
                                                <?php endif; ?>
                                            <?php else: ?>
                                                <?php 
                                                $approvalLevelClass = [
                                                    'level_1' => 'badge-light-primary',
                                                    'level_2' => 'badge-light-warning', 
                                                    'level_3' => 'badge-light-danger',
                                                    'no_approval' => 'badge-light-secondary'
                                                ];
                                                $approvalLevelText = [
                                                    'level_1' => 'Level 1',
                                                    'level_2' => 'Level 2',
                                                    'level_3' => 'Level 3',
                                                    'no_approval' => 'No Approval'
                                                ];
                                                $class = $approvalLevelClass[$rule['approval_level']] ?? 'badge-light-secondary';
                                                $text = $approvalLevelText[$rule['approval_level']] ?? 'Unknown';
                                                ?>
                                                <span class="badge <?= $class ?>"><?= $text ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($rule['is_active']): ?>
                                                <span class="badge badge-light-success">Active</span>
                                            <?php else: ?>
                                                <span class="badge badge-light-danger">Inactive</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="text-gray-600"><?= esc($rule['description']) ?></span>
                                        </td>
                                        <td class="text-end">
                                            <div class="d-flex justify-content-end flex-shrink-0">
                                                <?php if (isset($permissions['canView']) && $permissions['canView']): ?>
                                                <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                                                        onclick="viewAuthorizationRule(<?= $rule['id'] ?>)" 
                                                        title="View">
                                                    <i class="ki-duotone ki-eye fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                </button>
                                                <?php endif; ?>
                                                
                                                <?php if (isset($permissions['canEdit']) && $permissions['canEdit']): ?>
                                                <button class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" 
                                                        onclick="editAuthorizationRule(<?= $rule['id'] ?>)" 
                                                        title="Edit">
                                                    <i class="ki-duotone ki-pencil fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                    </i>
                                                </button>
                                                <?php endif; ?>
                                                
                                                <?php if (isset($permissions['canDelete']) && $permissions['canDelete']): ?>
                                                <button class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm" 
                                                        onclick="deleteAuthorizationRule(<?= $rule['id'] ?>)" 
                                                        title="Delete">
                                                    <i class="ki-duotone ki-trash fs-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                        <span class="path4"></span>
                                                        <span class="path5"></span>
                                                    </i>
                                                </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-5">
                                            No authorization rules found
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <?php if (isset($totalPages) && $totalPages > 1): ?>
                    <div class="d-flex flex-stack flex-wrap pt-10">
                        <div class="fs-6 fw-semibold text-gray-700">
                            Showing <?= count($authorizationRules ?? []) ?> of <?= $totalAuthorizationRules ?? 0 ?> authorization rules
                        </div>
                        <ul class="pagination">
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i == ($currentPage ?? 1)) ? 'active' : '' ?>">
                                    <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search ?? '') ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Modals -->
<?= $this->include('authorization_rules/create_modal') ?>
<?= $this->include('authorization_rules/edit_modal') ?>
<?= $this->include('authorization_rules/view_modal') ?>

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

<script>
// Search functionality
document.querySelector('[data-kt-filter="search"]').addEventListener('keyup', function(e) {
    if (e.key === 'Enter' || this.value.length === 0 || this.value.length >= 3) {
        const searchValue = this.value;
        const url = new URL(window.location);
        url.searchParams.set('search', searchValue);
        url.searchParams.set('page', '1');
        window.location.href = url.toString();
    }
});

// View authorization rule
function viewAuthorizationRule(id) {
    fetch(`/authorization-rules/show/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const rule = data.data;
            populateViewAuthorizationRuleModal(rule);
            if (typeof $ !== 'undefined') {
                $('#viewAuthorizationRuleModal').modal('show');
            } else {
                // Fallback to vanilla JavaScript
                const modal = new bootstrap.Modal(document.getElementById('viewAuthorizationRuleModal'));
                modal.show();
            }
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred', 'error');
    });
}

// Edit authorization rule
function editAuthorizationRule(id) {
    fetch(`/authorization-rules/show/${id}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const rule = data.data;
            populateEditAuthorizationRuleModal(rule);
            if (typeof $ !== 'undefined') {
                $('#editAuthorizationRuleModal').modal('show');
            } else {
                // Fallback to vanilla JavaScript
                const modal = new bootstrap.Modal(document.getElementById('editAuthorizationRuleModal'));
                modal.show();
            }
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'An error occurred', 'error');
    });
}

// Delete authorization rule
function deleteAuthorizationRule(id) {
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
            fetch(`/authorization-rules/delete/${id}`, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Deleted!', data.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'An error occurred', 'error');
            });
        }
    });
}

// Initialize Select2 on document ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for all select elements in modals if jQuery and Select2 are available
    if (typeof $ !== 'undefined' && typeof $.fn.select2 !== 'undefined') {
        $('.form-select[data-control="select2"]').select2({
            dropdownParent: $('.modal')
        });
    }
});
</script>

<?= $this->include('layout/footer.php') ?>