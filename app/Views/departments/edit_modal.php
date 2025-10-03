<!--begin::Edit Department Modal-->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Department</h2>
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
                <form id="editDepartmentForm" class="form">
                    <input type="hidden" id="edit_department_id" name="department_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Department Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" id="edit_department_name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter department name" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Division</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_division_id" name="division_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a division..." data-dropdown-parent="#editDepartmentModal">
                                <option></option>
                                <?php if (!empty($divisions)): ?>
                                    <?php foreach ($divisions as $division): ?>
                                        <option value="<?= esc($division['id']) ?>"><?= esc($division['name'] ?? 'Unknown') ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea id="edit_description" name="description" class="form-control form-control-solid" rows="4" placeholder="Enter department description (optional)"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Status</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_status_id" name="status_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a status..." data-dropdown-parent="#editDepartmentModal">
                                <option></option>
                                <?php if (!empty($statuses)): ?>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= esc($status['id']) ?>"><?= esc($status['name'] ?? 'Unknown') ?></option>
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
                <button type="button" class="btn btn-primary" id="editDepartmentSubmitBtn">
                    <span class="indicator-label">Update Department</span>
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
<!--end::Edit Department Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editDepartmentForm');
    const editModal = document.getElementById('editDepartmentModal');
    const submitBtn = document.getElementById('editDepartmentSubmitBtn');
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const departmentId = document.getElementById('edit_department_id')?.value;
            if (!departmentId) {
                Swal.fire('Error', 'Department ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(editForm);
            
            secureFetch(`/departments/update/${departmentId}`, {
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
                Swal.fire('Error', 'Failed to update department', 'error');
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
function populateEditModal(department) {
    document.getElementById('edit_department_id').value = department.id;
    document.getElementById('edit_department_name').value = department.name;
    document.getElementById('edit_division_id').value = department.division_id;
    document.getElementById('edit_description').value = department.description || '';
    
    // Trigger Select2 update
    $('#edit_division_id').trigger('change');
}
</script>