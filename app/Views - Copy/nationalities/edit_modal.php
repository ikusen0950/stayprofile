<!--begin::Edit Nationality Modal-->
<div class="modal fade" id="editNationalityModal" tabindex="-1" aria-labelledby="editNationalityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="modal-title" id="editNationalityModalLabel">
                    <i class="ki-duotone ki-pencil fs-2hx text-warning me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Edit Nationality
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body">
                <!--begin::Form-->
                <form id="editNationalityForm" method="POST">
                    <input type="hidden" name="id" id="edit_nationality_id">
                    
                    <!--begin::Scroll-->
                    <div class="scroll-y" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" 
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies=".modal-header, .modal-footer"
                         data-kt-scroll-wrappers=".modal-body" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2 required">Nationality Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" 
                                   name="name" id="edit_nationality_name" placeholder="Enter nationality name" required />
                            <!--end::Input-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="edit_name_error"></div>
                            <!--end::Error message container-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea class="form-control form-control-solid" name="description" 
                                      id="edit_nationality_description" rows="4" 
                                      placeholder="Enter nationality description (optional)"></textarea>
                            <!--end::Input-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="edit_description_error"></div>
                            <!--end::Error message container-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2 required">Status</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="status_id" id="edit_nationality_status_id" required>
                                <option value="">Select status...</option>
                                <?php if (!empty($statuses)): ?>
                                <?php foreach ($statuses as $status): ?>
                                <option value="<?= esc($status['id']) ?>">
                                    <?= esc($status['name']) ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="edit_status_id_error"></div>
                            <!--end::Error message container-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->

            <!--begin::Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Cancel
                </button>
                <button type="submit" form="editNationalityForm" class="btn btn-warning" id="editNationalityBtn">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span class="indicator-label">Update Nationality</span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Edit Nationality Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editNationalityForm');
    const editBtn = document.getElementById('editNationalityBtn');
    const editModal = document.getElementById('editNationalityModal');

    if (editForm && editBtn) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearEditFormErrors();
            
            // Show loading state
            editBtn.setAttribute('data-kt-indicator', 'on');
            editBtn.disabled = true;
            
            // Get form data
            const formData = new FormData(editForm);
            const nationalityId = document.getElementById('edit_nationality_id').value;
            
            // Submit via fetch
            secureFetch(`/nationalities/update/${nationalityId}`, {
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
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        // Reload page to show updated nationality
                        window.location.reload();
                    });
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        displayEditFormErrors(data.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to update nationality'
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Network error occurred. Please try again.'
                });
            })
            .finally(() => {
                // Hide loading state
                editBtn.removeAttribute('data-kt-indicator');
                editBtn.disabled = false;
            });
        });
    }

    // Reset form when modal is closed
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function() {
            editForm.reset();
            clearEditFormErrors();
        });
    }

    function clearEditFormErrors() {
        // Clear all error messages
        const errorElements = editForm.querySelectorAll('.text-danger');
        errorElements.forEach(element => {
            element.classList.add('d-none');
            element.textContent = '';
        });
        
        // Remove error classes from inputs
        const inputs = editForm.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
    }

    function displayEditFormErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById('edit_' + field + '_error');
            const inputElement = editForm.querySelector(`[name="${field}"]`);
            
            if (errorElement) {
                errorElement.textContent = errors[field];
                errorElement.classList.remove('d-none');
            }
            
            if (inputElement) {
                inputElement.classList.add('is-invalid');
            }
        });
    }
});
</script>