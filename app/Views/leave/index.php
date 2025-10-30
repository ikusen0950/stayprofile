<?= $this->include('layout/header.php') ?>



<!--begin::Mobile UI (visible on mobile only)-->
<?= $this->include('leave/mobile_view.php') ?>
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
                            Leave Reasons
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
                                Leave </li>
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
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search leave..."
                                value="<?= esc($search) ?>" />
                        </div>
                        <!--end::Search-->
                    </div>
                    <div class="col-6">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end" data-kt-leave-table-toolbar="base">
                            <!--begin::Add leave-->
                            <?php if ($permissions['canCreate']): ?>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                data-bs-target="#createLeaveModal">
                                <i class="ki-duotone ki-plus fs-2"></i>Add Leave
                            </button>
                            <?php endif; ?>
                            <!--end::Add leave-->
                        </div>
                        <!--end::Toolbar-->
                    </div>
                </div>


                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_leave_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                <th class="w-10px pe-2">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                        <input class="form-check-input" type="checkbox" data-kt-check="true"
                                            data-kt-check-target="#kt_leave_table .form-check-input" value="1" />
                                    </div>
                                </th>
                                <th class="min-w-20px">#</th>
                                <th class="min-w-80px">Status</th>
                                <th class="min-w-200px">Leave</th>
                                <th class="min-w-100px">Module</th>
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
                            <?php if (!empty($leaves)): ?>
                            <?php foreach ($leaves as $leave): ?>
                            <!--begin::Table row-->
                            <tr>
                                <!--begin::Checkbox-->
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox"
                                            value="<?= esc($leave['id']) ?>" />
                                    </div>
                                </td>
                                <!--end::Checkbox-->

                                <!--begin::ID-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="text-muted">#<?= esc($leave['id']) ?></small>
                                    </div>
                                </td>
                                <!--end::ID-->

                                <!--begin::Leave-->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <?php 
                                                if (!empty($leave['status_color'])) {
                                                    $hex = ltrim($leave['status_color'], '#');
                                                    $r = hexdec(substr($hex, 0, 2));
                                                    $g = hexdec(substr($hex, 2, 2));
                                                    $b = hexdec(substr($hex, 4, 2));
                                                    $lightBg = "rgba($r, $g, $b, 0.1)";
                                                    $textColor = $leave['status_color'];
                                                    $badgeStyle = "background-color: $lightBg; color: $textColor; padding: 4px 8px; font-size: 11px; line-height: 1.2;";
                                                }
                                                ?>
                                        <?php if (!empty($leave['status_color'])): ?>
                                        <span class="badge fw-bold" style="<?= $badgeStyle ?>">
                                            <?= strtoupper(esc($leave['status_name'])) ?>
                                        </span>
                                        <?php else: ?>
                                        <span class="badge <?= $badgeClass ?> fw-bold"
                                            style="padding: 4px 8px; font-size: 11px; line-height: 1.2;">
                                            <?= strtoupper(esc($leave['status_name'])) ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Leave-->

                                <!--begin::Module-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="fw-bold text-dark"><?= esc($leave['name']) ?></small>
                                    </div>
                                </td>
                                <!--end::Module-->

                                <!--begin::Module-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <small class="fw-bold "><?= esc($leave['module_name']) ?></small>
                                    </div>
                                </td>
                                <!--end::Module-->

                                <!--begin::Description-->
                                <td>
                                    <div class="text-gray-600">
                                        <?= esc($leave['description']) ?>
                                    </div>
                                </td>
                                <!--end::Description-->

                                <!--begin::Created By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($leave['created_by_name'])): ?>
                                        <span class="text-muted"><?= esc($leave['created_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($leave['created_at'])) ?></small>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <!--end::Created By-->
                                <!--begin::Updated By-->
                                <td>
                                    <div class="d-flex flex-column">
                                        <?php if (!empty($leave['updated_by_name']) && !empty($leave['updated_at'])): ?>
                                        <span class="text-muted"><?= esc($leave['updated_by_name']) ?></span>
                                        <small
                                            class="text-muted"><?= date('d M Y \a\t H:i', strtotime($leave['updated_at'])) ?></small>
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
                                            <a class="menu-link px-3 view-leave-btn"
                                                data-leave-id="<?= esc($leave['id']) ?>">View</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if ($permissions['canEdit']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 edit-leave-btn"
                                                data-leave-id="<?= esc($leave['id']) ?>">Edit</a>
                                        </div>
                                        <?php endif; ?>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <?php if ($permissions['canDelete']): ?>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3 delete-leave-btn"
                                                data-leave-id="<?= esc($leave['id']) ?>">Delete</a>
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
                                        <div class="fw-bold text-gray-700 mb-2">No leave found</div>
                                        <div class="text-gray-500">Start by creating your first leave entry
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
                        $footerData = [
                            'baseUrl' => 'leave',
                            'currentPage' => $currentPage,
                            'totalPages' => $totalPages,
                            'limit' => $limit,
                            'totalRecords' => $totalLeaves,
                            'search' => $search,
                            'tableId' => 'kt_leave_table_length',
                            'jsFunction' => 'changeLeaveTableLimit'
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
// --- Leave Edit Modal Logic ---
function populateEditLeaveModal(leave) {
    document.getElementById('edit_leave_id').value = leave.id;
    document.getElementById('edit_leave_name').value = leave.name || '';
    document.getElementById('edit_module_id').value = leave.module_id || '';
    document.getElementById('edit_status_id').value = leave.status_id || '';
    document.getElementById('edit_description').value = leave.description || '';
}

function showEditLeaveModal(leaveId) {
    secureFetch(`/leave/show/${leaveId}`)
        .then(response => {
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                populateEditLeaveModal(data.data);
                const modal = new bootstrap.Modal(document.getElementById('editLeaveModal'));
                modal.show();
            } else {
                Swal.fire('Error', data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to load leave details', 'error');
        });
}

document.addEventListener('DOMContentLoaded', function() {
    // Edit button handler
    document.querySelectorAll('.edit-leave-btn').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const leaveId = this.getAttribute('data-leave-id');
            if (leaveId) {
                showEditLeaveModal(leaveId);
            }
        });
    });

    // Save button handler for edit modal
    const saveBtn = document.getElementById('editLeaveSaveBtn');
    const editForm = document.getElementById('editLeaveForm');
    const editModal = document.getElementById('editLeaveModal');
    if (saveBtn && editForm) {
        saveBtn.addEventListener('click', function(e) {
            e.preventDefault();
            saveBtn.querySelector('.indicator-label').style.display = 'none';
            saveBtn.querySelector('.indicator-progress').style.display = 'inline-block';
            saveBtn.disabled = true;

            const leaveId = document.getElementById('edit_leave_id').value;
            const formData = new FormData(editForm);

            secureFetch(`/leave/update/${leaveId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
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
                saveBtn.querySelector('.indicator-label').style.display = 'inline';
                saveBtn.querySelector('.indicator-progress').style.display = 'none';
                saveBtn.disabled = false;
                if (data.success) {
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(editModal);
                    modal.hide();
                    // Show success message
                    Swal.fire('Success!', data.message, 'success');
                    // Reload page
                    window.location.reload();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        let errorMessage = '';
                        Object.values(data.errors).forEach(function(msg) {
                            errorMessage += msg + '<br>';
                        });
                        Swal.fire('Validation Error', errorMessage, 'error');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                saveBtn.querySelector('.indicator-label').style.display = 'inline';
                saveBtn.querySelector('.indicator-progress').style.display = 'none';
                saveBtn.disabled = false;
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update leave', 'error');
            });
        });
    }

    // Global event delegation for mobile and desktop actions
    document.addEventListener('click', function(e) {
        if (e.target.closest('.delete-leave-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.delete-leave-btn');
            const leaveId = btn.getAttribute('data-leave-id');
            if (!leaveId) return;
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
                    secureFetch(`/leave/delete/${leaveId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
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
                            window.location.reload();
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Failed to delete leave', 'error');
                    });
                }
            });
        }
        if (e.target.closest('.view-leave-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.view-leave-btn');
            const leaveId = btn.getAttribute('data-leave-id');
            if (!leaveId) return;
            secureFetch(`/leave/show/${leaveId}`)
                .then(response => {
                    if (response.status === 401 || response.status === 403) {
                        handleSessionExpired();
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        populateViewLeaveModal(data.data);
                        const modal = new bootstrap.Modal(document.getElementById('viewLeaveModal'));
                        modal.show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to load leave details', 'error');
                });
        }
        if (e.target.closest('.edit-leave-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.edit-leave-btn');
            const leaveId = btn.getAttribute('data-leave-id');
            if (!leaveId) return;
            showEditLeaveModal(leaveId);
        }
    });

    // Event delegation for desktop table actions
    document.getElementById('kt_leave_table').addEventListener('click', function(e) {
        if (e.target.closest('.delete-leave-btn')) {
            e.preventDefault();
            e.stopPropagation();
            const btn = e.target.closest('.delete-leave-btn');
            const leaveId = btn.getAttribute('data-leave-id');
            if (!leaveId) return;
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
                    secureFetch(`/leave/delete/${leaveId}`, {
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
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
                            window.location.reload();
                        } else {
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Failed to delete leave', 'error');
                    });
                }
            });
        }
        if (e.target.closest('.view-leave-btn')) {
            e.preventDefault();
            e.stopPropagation();
            const btn = e.target.closest('.view-leave-btn');
            const leaveId = btn.getAttribute('data-leave-id');
            if (!leaveId) return;
            secureFetch(`/leave/show/${leaveId}`)
                .then(response => {
                    if (response.status === 401 || response.status === 403) {
                        handleSessionExpired();
                        return;
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        populateViewLeaveModal(data.data);
                        const modal = new bootstrap.Modal(document.getElementById('viewLeaveModal'));
                        modal.show();
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to load leave details', 'error');
                });
        }
    });

  // Delete button handler

    // Mobile card click functionality (show/hide actions)
    function initMobileLeaveCards() {
        // Removed card.replaceWith(card.cloneNode(true)); to preserve event delegation
        document.querySelectorAll('.mobile-leave-card').forEach(function(card) {
            card.addEventListener('click', function(e) {
                // Only toggle actions if not clicking a button or link inside mobile-actions
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
    // Mobile search functionality
    const mobileSearch = document.getElementById('mobile_search');
    if (mobileSearch) {
        mobileSearch.addEventListener('input', function(e) {
            const query = e.target.value;
            // For demo: just reload page with search param
            // For AJAX: implement AJAX reload here
            const url = new URL(window.location);
            if (query.trim()) {
                url.searchParams.set('search', query);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        });
    }
    }

    // Initialize mobile leave cards on page load
    initMobileLeaveCards();

        // Helper to populate view modal
        function populateViewLeaveModal(leave) {
            document.getElementById('view_leave_name').textContent = leave.name || '';
            document.getElementById('view_module_id').textContent = leave.module_name || leave.module_id || 'N/A';
            document.getElementById('view_status_id').textContent = leave.status_name || leave.status_id || 'N/A';
            document.getElementById('view_description').textContent = leave.description || 'No description provided';
            // If you have created_by/created_at fields in the modal, add them here
        }
    // Ensure all script blocks and functions are properly closed
});
</script>

<!-- Include Modals (placed at end for mobile compatibility) -->
<?= $this->include('leave/create_modal') ?>
<?= $this->include('leave/edit_modal') ?>
<?= $this->include('leave/view_modal') ?>

<?= $this->include('layout/footer.php') ?>