<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editRoleModalLabel">
                    <i class="ki-duotone ki-pencil fs-2 text-primary me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Edit Role
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editRoleForm" method="POST">
                <input type="hidden" id="edit_role_id" name="role_id">
                
                <div class="modal-body">
                    <!-- Role Name -->
                    <div class="mb-4">
                        <label for="edit_role_name" class="form-label required">Role Name</label>
                        <input type="text" class="form-control form-control-solid" id="edit_role_name" name="name" 
                               placeholder="Enter role name" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="edit_description" class="form-label">Description</label>
                        <textarea class="form-control form-control-solid" id="edit_description" name="description" 
                                  rows="4" placeholder="Enter role description (optional)"></textarea>
                        <div class="form-text">Provide a brief description of this role's purpose and responsibilities.</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            <i class="ki-duotone ki-check fs-2"></i>
                            Update Role
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editRoleForm');
    const editModal = document.getElementById('editRoleModal');
    const submitBtn = editForm.querySelector('button[type="submit"]');

    // Reset form when modal is hidden
    editModal.addEventListener('hidden.bs.modal', function() {
        editForm.reset();
        clearValidationErrors(editForm);
        resetSubmitButton(submitBtn);
    });

    // Handle form submission
    editForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const roleId = document.getElementById('edit_role_id').value;
        if (!roleId) {
            Swal.fire('Error', 'Role ID is missing', 'error');
            return;
        }
        
        // Clear previous errors
        clearValidationErrors(editForm);
        
        // Show loading state
        setSubmitButtonLoading(submitBtn, true);
        
        const formData = new FormData(editForm);
        
        fetch(`/roles/update/${roleId}`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Close modal and reload page
                    bootstrap.Modal.getInstance(editModal).hide();
                    window.location.reload();
                });
            } else {
                // Handle validation errors
                if (data.errors) {
                    displayValidationErrors(editForm, data.errors);
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'An unexpected error occurred. Please try again.', 'error');
        })
        .finally(() => {
            setSubmitButtonLoading(submitBtn, false);
        });
    });
});
</script>