<!--begin::Edit Notification Modal-->
<div class="modal fade" id="editNotificationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Notification</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            
            <!--begin::Modal body-->
            <div class="modal-body scroll-y p-4">
                <!--begin::Form-->
                <form id="editNotificationForm" class="form">
                    <input type="hidden" id="edit_notification_id" name="notification_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">User</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_user_id" name="user_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a user..." data-dropdown-parent="#editNotificationModal">
                                <option></option>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <?php 
                                        $displayName = '';
                                        if (!empty($user['full_name'])) {
                                            $displayName = $user['full_name'];
                                        } elseif (!empty($user['islander_no'])) {
                                            $displayName = $user['islander_no'];
                                        } else {
                                            $displayName = 'Unknown User';
                                        }
                                        ?>
                                        <option value="<?= esc($user['id']) ?>"><?= esc($displayName) ?> (<?= esc($user['email']) ?>)</option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Title</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" id="edit_notification_title" name="title" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter notification title" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Body</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea id="edit_notification_body" name="body" class="form-control form-control-solid" rows="5" placeholder="Enter notification body/message"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">URL</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="url" id="edit_notification_url" name="url" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter notification URL (optional)" />
                            <div class="form-text">Optional URL to redirect when notification is clicked</div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Status</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_status_id" name="status_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a status..." data-dropdown-parent="#editNotificationModal">
                                <option></option>
                                <?php if (!empty($statuses)): ?>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= esc($status['id']) ?>"><?= esc($status['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->
                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="button" class="btn btn-primary" id="editNotificationSubmitBtn">
                    <span class="indicator-label">Update Notification</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Edit Notification Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editNotificationForm');
    const editModal = document.getElementById('editNotificationModal');
    const submitBtn = document.getElementById('editNotificationSubmitBtn');
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const notificationId = document.getElementById('edit_notification_id')?.value;
            if (!notificationId) {
                Swal.fire('Error', 'Notification ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(editForm);
            
            secureFetch(`/notifications/update/${notificationId}`, {
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
                if (data.success) {
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(editModal);
                    modal.hide();
                    
                    // Reset form
                    editForm.reset();
                    
                    // Show success message
                    Swal.fire('Success!', data.message, 'success');
                    
                    // Reload page
                    window.location.reload();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        let errorMessage = '';
                        for (const field in data.errors) {
                            errorMessage += data.errors[field] + '\n';
                        }
                        Swal.fire('Validation Error', errorMessage, 'error');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update notification', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
            });
        });
    }
    
    // Reset form when modal is hidden
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function () {
            editForm.reset();
            
            // Clear any validation states
            const inputs = editForm.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            
            // Reset Select2 dropdowns
            const selects = editForm.querySelectorAll('select[data-control="select2"]');
            selects.forEach(select => {
                if (typeof $(select).select2 === 'function') {
                    $(select).val(null).trigger('change');
                }
            });
        });
    }
});

// Function to populate edit modal (called from index.php)
function populateEditModal(notification) {
    document.getElementById('edit_notification_id').value = notification.id;
    document.getElementById('edit_user_id').value = notification.user_id;
    document.getElementById('edit_notification_title').value = notification.title;
    document.getElementById('edit_notification_body').value = notification.body || '';
    document.getElementById('edit_notification_url').value = notification.url || '';
    document.getElementById('edit_status_id').value = notification.status_id;
    
    // Trigger Select2 updates
    $('#edit_user_id').trigger('change');
    $('#edit_status_id').trigger('change');
}
</script>