<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createRoleModalLabel">
                    <i class="ki-duotone ki-plus-square fs-2 text-primary me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Add New Role
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="createRoleForm" method="POST" action="/roles/store">
                <div class="modal-body">
                    <!-- Role Name -->
                    <div class="mb-4">
                        <label for="create_role_name" class="form-label required">Role Name</label>
                        <input type="text" class="form-control form-control-solid" id="create_role_name" name="name" 
                               placeholder="Enter role name" required>
                        <div class="invalid-feedback"></div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="create_description" class="form-label">Description</label>
                        <textarea class="form-control form-control-solid" id="create_description" name="description" 
                                  rows="4" placeholder="Enter role description (optional)"></textarea>
                        <div class="form-text">Provide a brief description of this role's purpose and responsibilities.</div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">
                            <i class="ki-duotone ki-plus fs-2"></i>
                            Create Role
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
    const createForm = document.getElementById('createRoleForm');
    const createModal = document.getElementById('createRoleModal');
    const submitBtn = createForm.querySelector('button[type="submit"]');

    // Reset form when modal is hidden
    createModal.addEventListener('hidden.bs.modal', function() {
        createForm.reset();
        clearValidationErrors(createForm);
        resetSubmitButton(submitBtn);
    });

    // Handle form submission
    createForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Clear previous errors
        clearValidationErrors(createForm);
        
        // Show loading state
        setSubmitButtonLoading(submitBtn, true);
        
        const formData = new FormData(createForm);
        
        fetch('/roles/store', {
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
                    bootstrap.Modal.getInstance(createModal).hide();
                    window.location.reload();
                });
            } else {
                // Handle validation errors
                if (data.errors) {
                    displayValidationErrors(createForm, data.errors);
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

// Utility functions
function clearValidationErrors(form) {
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    form.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
}

function displayValidationErrors(form, errors) {
    Object.keys(errors).forEach(field => {
        const input = form.querySelector(`[name="${field}"]`);
        if (input) {
            input.classList.add('is-invalid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = errors[field];
            }
        }
    });
}

function setSubmitButtonLoading(button, loading) {
    const label = button.querySelector('.indicator-label');
    const progress = button.querySelector('.indicator-progress');
    
    if (loading) {
        button.disabled = true;
        label.style.display = 'none';
        progress.style.display = 'inline-block';
    } else {
        button.disabled = false;
        label.style.display = 'inline-block';
        progress.style.display = 'none';
    }
}

function resetSubmitButton(button) {
    setSubmitButtonLoading(button, false);
}
</script>