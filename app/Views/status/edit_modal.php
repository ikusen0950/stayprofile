<!--begin::Edit Status Modal-->
<div class="modal fade" id="editStatusModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Status</h2>
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
                <form id="editStatusForm" class="form">
                    <input type="hidden" id="edit_status_id" name="status_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Status Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" id="edit_status_name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter status name" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Module</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_module_id" name="module_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a module..." data-dropdown-parent="#editStatusModal">
                                <option></option>
                                <?php if (!empty($modules)): ?>
                                    <?php foreach ($modules as $module): ?>
                                        <option value="<?= esc($module['id']) ?>"><?= esc($module['name'] ?? 'Unknown') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Color</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="color" id="edit_color" name="color" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="#000000" />
                            <div class="form-text">Choose a color for this status (optional)</div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea id="edit_description" name="description" class="form-control form-control-solid" rows="4" placeholder="Enter status description (optional)"></textarea>
                            <!--end::Input-->
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
                <button type="button" class="btn btn-primary" id="editStatusSubmitBtn">
                    <span class="indicator-label">Update Status</span>
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
<!--end::Edit Status Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editStatusForm');
    const editModal = document.getElementById('editStatusModal');
    const submitBtn = document.getElementById('editStatusSubmitBtn');
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const statusId = document.getElementById('edit_status_id')?.value;
            if (!statusId) {
                Swal.fire('Error', 'Status ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(editForm);
            
            secureFetch(`/status/update/${statusId}`, {
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
                Swal.fire('Error', 'Failed to update status', 'error');
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
        });
    }
});

// Function to populate edit modal (called from index.php)
function populateEditModal(status) {
    document.getElementById('edit_status_id').value = status.id;
    document.getElementById('edit_status_name').value = status.name;
    document.getElementById('edit_module_id').value = status.module_id;
    document.getElementById('edit_color').value = status.color || '#000000';
    document.getElementById('edit_description').value = status.description || '';
    
    // Trigger Select2 update
    $('#edit_module_id').trigger('change');
}
</script>