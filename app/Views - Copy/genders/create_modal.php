<!--begin::Create Gender Modal-->
<div class="modal fade" id="createGenderModal" tabindex="-1" aria-labelledby="createGenderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="modal-title" id="createGenderModalLabel">
                    <i class="ki-duotone ki-plus-square fs-2hx text-primary me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Create New Gender
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body">
                <!--begin::Form-->
                <form id="createGenderForm" action="/genders/store" method="POST">
                    <!--begin::Scroll-->
                    <div class="scroll-y" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" 
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies=".modal-header, .modal-footer"
                         data-kt-scroll-wrappers=".modal-body" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2 required">Gender Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" 
                                   name="name" id="gender_name" placeholder="Enter gender name" required />
                            <!--end::Input-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="gender_name_error"></div>
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
                                      id="gender_description" rows="4" 
                                      placeholder="Enter gender description (optional)"></textarea>
                            <!--end::Input-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="gender_description_error"></div>
                            <!--end::Error message container-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2 required">Status</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="status_id" id="gender_status_id" required>
                                <option value="">Select status...</option>
                                <?php if (!empty($statuses)): ?>
                                <?php foreach ($statuses as $status): ?>
                                <option value="<?= esc($status['id']) ?>" <?= $status['id'] == 1 ? 'selected' : '' ?>>
                                    <?= esc($status['name']) ?>
                                </option>
                                <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="gender_status_id_error"></div>
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
                <button type="submit" form="createGenderForm" class="btn btn-primary" id="createGenderBtn">
                    <i class="ki-duotone ki-check fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span class="indicator-label">Create Gender</span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Create Gender Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createGenderForm');
    const createBtn = document.getElementById('createGenderBtn');
    const createModal = document.getElementById('createGenderModal');

    if (createForm && createBtn) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous errors
            clearFormErrors();
            
            // Show loading state
            createBtn.setAttribute('data-kt-indicator', 'on');
            createBtn.disabled = true;
            
            // Get form data
            const formData = new FormData(createForm);
            
            // Submit via fetch
            secureFetch('/genders/store', {
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
                        // Reload page to show new gender
                        window.location.reload();
                    });
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        displayFormErrors(data.errors);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message || 'Failed to create gender'
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
                createBtn.removeAttribute('data-kt-indicator');
                createBtn.disabled = false;
            });
        });
    }

    // Reset form when modal is closed
    if (createModal) {
        createModal.addEventListener('hidden.bs.modal', function() {
            createForm.reset();
            clearFormErrors();
        });
    }

    function clearFormErrors() {
        // Clear all error messages
        const errorElements = createForm.querySelectorAll('.text-danger');
        errorElements.forEach(element => {
            element.classList.add('d-none');
            element.textContent = '';
        });
        
        // Remove error classes from inputs
        const inputs = createForm.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
        });
    }

    function displayFormErrors(errors) {
        Object.keys(errors).forEach(field => {
            const errorElement = document.getElementById(field + '_error');
            const inputElement = document.querySelector(`[name="${field}"]`);
            
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