<!--begin::Create House Modal-->
<div class="modal fade" id="createHouseModal" tabindex="-1" aria-labelledby="createHouseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="modal-title" id="createHouseModalLabel">
                    <i class="ki-duotone ki-plus-square fs-2hx text-primary me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Create New House
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body">
                <!--begin::Form-->
                <form id="createHouseForm" action="/houses/store" method="POST">
                    <!--begin::Scroll-->
                    <div class="scroll-y" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" 
                         data-kt-scroll-max-height="auto" data-kt-scroll-dependencies=".modal-header, .modal-footer"
                         data-kt-scroll-wrappers=".modal-body" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2 required">House Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control form-control-solid" 
                                   name="name" id="house_name" placeholder="Enter house name" required />
                            <!--end::Input-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="name_error"></div>
                            <!--end::Error message container-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">House Color</label>
                            <!--end::Label-->
                            <!--begin::Color picker container-->
                            <div class="d-flex align-items-center">
                                <div class="color-picker-wrapper me-3">
                                    <input type="color" class="color-picker" name="color" id="house_color" value="#3b82f6" />
                                </div>
                                <input type="text" class="form-control form-control-solid" 
                                       name="color_text" id="house_color_text" placeholder="#3b82f6" 
                                       value="#3b82f6" style="max-width: 120px;" />
                                <button type="button" class="btn btn-light btn-sm ms-2" id="clearColorBtn">
                                    <i class="ki-duotone ki-cross fs-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                            </div>
                            <!--end::Color picker container-->
                            <div class="form-text">Select a color to represent this house (optional)</div>
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="color_error"></div>
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
                                      id="house_description" rows="4" 
                                      placeholder="Enter house description (optional)"></textarea>
                            <!--end::Input-->
                            <!--begin::Error message container-->
                            <div class="text-danger mt-2 d-none" id="description_error"></div>
                            <!--end::Error message container-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2 required">Status</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select class="form-select form-select-solid" name="status_id" id="house_status_id" required>
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
                            <div class="text-danger mt-2 d-none" id="status_id_error"></div>
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
                <button type="submit" form="createHouseForm" class="btn btn-primary" id="createHouseBtn">
                    <i class="ki-duotone ki-check fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <span class="indicator-label">Create House</span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Create House Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createHouseForm');
    const createBtn = document.getElementById('createHouseBtn');
    const createModal = document.getElementById('createHouseModal');
    const colorPicker = document.getElementById('house_color');
    const colorText = document.getElementById('house_color_text');
    const clearColorBtn = document.getElementById('clearColorBtn');

    // Color picker synchronization
    if (colorPicker && colorText) {
        colorPicker.addEventListener('input', function() {
            colorText.value = this.value;
        });

        colorText.addEventListener('input', function() {
            const value = this.value;
            if (/^#[0-9A-Fa-f]{6}$/.test(value)) {
                colorPicker.value = value;
            }
        });

        // Clear color button
        if (clearColorBtn) {
            clearColorBtn.addEventListener('click', function() {
                colorPicker.value = '#3b82f6';
                colorText.value = '';
            });
        }
    }

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
            
            // Use the color text value if provided, otherwise use color picker value
            const colorValue = colorText.value.trim() || colorPicker.value;
            formData.set('color', colorValue === '#3b82f6' && !colorText.value.trim() ? '' : colorValue);
            
            // Submit via fetch
            secureFetch('/houses/store', {
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
                        // Reload page to show new house
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
                            text: data.message || 'Failed to create house'
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
            colorPicker.value = '#3b82f6';
            colorText.value = '#3b82f6';
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