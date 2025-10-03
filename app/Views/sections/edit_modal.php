<!--begin::Edit Section Modal-->
<div class="modal fade" id="editSectionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Section</h2>
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
                <form id="editSectionForm" class="form">
                    <input type="hidden" id="edit_section_id" name="section_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Section Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" id="edit_Section_name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter Section name" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">department</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_department_id" name="department_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a department..." data-dropdown-parent="#editSectionModal">
                                <option></option>
                                <?php if (!empty($departments)): ?>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?= esc($department['id']) ?>"><?= esc($department['name'] ?? 'Unknown') ?></option>
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
                            <textarea id="edit_description" name="description" class="form-control form-control-solid" rows="4" placeholder="Enter Section description (optional)"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Status</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_status_id" name="status_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a status..." data-dropdown-parent="#editSectionModal">
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
                <button type="button" class="btn btn-primary" id="editSectionSubmitBtn">
                    <span class="indicator-label">Update Section</span>
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
<!--end::Edit Section Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editSectionForm');
    const editModal = document.getElementById('editSectionModal');
    const submitBtn = document.getElementById('editSectionSubmitBtn');
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const sectionId = document.getElementById('edit_section_id')?.value;
            if (!sectionId) {
                Swal.fire('Error', 'Section ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(editForm);
            
            secureFetch(`/sections/update/${sectionId}`, {
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
                Swal.fire('Error', 'Failed to update Section', 'error');
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
function populateEditModal(Section) {
    document.getElementById('edit_Section_id').value = Section.id;
    document.getElementById('edit_Section_name').value = Section.name;
    document.getElementById('edit_department_id').value = Section.department_id;
    document.getElementById('edit_description').value = Section.description || '';
    
    // Trigger Select2 update
    $('#edit_department_id').trigger('change');
}
</script>
