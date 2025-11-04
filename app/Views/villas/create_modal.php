<!--begin::Modal - Create Villa-->
<div class="modal fade" id="createVillaModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="createVillaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="fw-bold" id="createVillaModalLabel">Add New Villa</h2>
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <!--begin::Form-->
                <form id="createVillaForm" class="form" enctype="multipart/form-data">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y me-n7 pe-7">
                        
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Villa Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="villa_name" class="form-control form-control-solid mb-3 mb-lg-0" 
                                   placeholder="Enter villa name" required />
                            <!--end::Input-->
                            <div class="invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Villa Code</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="villa_code" class="form-control form-control-solid mb-3 mb-lg-0" 
                                   placeholder="Enter villa code (optional)" />
                            <!--end::Input-->
                            <div class="invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Capacity</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="number" name="capacity" class="form-control form-control-solid mb-3 mb-lg-0" 
                                   placeholder="Number of guests" min="0" />
                            <!--end::Input-->
                            <div class="invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Textarea-->
                            <textarea name="description" class="form-control form-control-solid mb-3 mb-lg-0" 
                                      rows="4" placeholder="Enter villa description (optional)"></textarea>
                            <!--end::Textarea-->
                            <div class="invalid-feedback"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group - Images-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Villa Images</label>
                            <!--end::Label-->
                            <!--begin::File input-->
                            <input type="file" name="villa_images[]" class="form-control form-control-solid mb-3" 
                                   multiple accept="image/*" id="villaImages" />
                            <!--end::File input-->
                            <div class="form-text">You can select multiple images. Supported formats: JPEG, PNG, GIF, WebP. Max size per image: 5MB.</div>
                            <div class="invalid-feedback"></div>
                            
                            <!--begin::Image preview container-->
                            <div id="imagePreviewContainer" class="mt-4" style="display: none;">
                                <h6 class="fw-semibold fs-7 mb-3">Selected Images:</h6>
                                <div id="imagePreviewGrid" class="row g-3"></div>
                            </div>
                            <!--end::Image preview container-->
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
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary" form="createVillaForm">
                    <span class="indicator-label">Create Villa</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Modal - Create Villa-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createVillaForm');
    const createModal = document.getElementById('createVillaModal');
    const submitBtn = createForm.querySelector('button[type="submit"], button[form="createVillaForm"]');
    const imageInput = document.getElementById('villaImages');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewGrid = document.getElementById('imagePreviewGrid');

    // Handle image preview
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 0) {
                showImagePreviews(files);
            } else {
                hideImagePreviews();
            }
        });
    }

    function showImagePreviews(files) {
        previewGrid.innerHTML = '';
        previewContainer.style.display = 'block';

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = createPreviewItem(e.target.result, file.name, index);
                    previewGrid.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function createPreviewItem(src, fileName, index) {
        const col = document.createElement('div');
        col.className = 'col-md-3 col-sm-4 col-6';
        
        col.innerHTML = `
            <div class="card border">
                <div class="card-body p-2">
                    <img src="${src}" class="img-fluid rounded mb-2" style="height: 80px; width: 100%; object-fit: cover;" alt="Preview">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted text-truncate">${fileName}</small>
                        <button type="button" class="btn btn-sm btn-light-danger remove-image" data-index="${index}">
                            <i class="ki-duotone ki-trash fs-7">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </button>
                    </div>
                    ${index === 0 ? '<small class="badge badge-primary">Primary</small>' : ''}
                </div>
            </div>
        `;

        // Add remove functionality
        const removeBtn = col.querySelector('.remove-image');
        removeBtn.addEventListener('click', function() {
            removeImageFromInput(parseInt(this.getAttribute('data-index')));
        });

        return col;
    }

    function removeImageFromInput(indexToRemove) {
        const dt = new DataTransfer();
        const files = imageInput.files;

        for (let i = 0; i < files.length; i++) {
            if (i !== indexToRemove) {
                dt.items.add(files[i]);
            }
        }

        imageInput.files = dt.files;
        
        if (dt.files.length > 0) {
            showImagePreviews(dt.files);
        } else {
            hideImagePreviews();
        }
    }

    function hideImagePreviews() {
        previewContainer.style.display = 'none';
        previewGrid.innerHTML = '';
    }

    if (createForm) {
        createForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Clear previous validation states
            clearValidationStates(createForm);
            
            // Show loading state
            if (submitBtn) {
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.disabled = true;
            }

            const formData = new FormData(createForm);
            
            secureFetch('/villas/store', {
                method: 'POST',
                body: formData
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
                    bootstrap.Modal.getInstance(createModal).hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reload page to show new villa
                        window.location.reload();
                    });
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        displayValidationErrors(createForm, data.errors);
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to create villa'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Network error occurred'
                });
            })
            .finally(() => {
                // Hide loading state
                if (submitBtn) {
                    submitBtn.removeAttribute('data-kt-indicator');
                    submitBtn.disabled = false;
                }
            });
        });
    }

    // Reset form when modal is hidden
    if (createModal) {
        createModal.addEventListener('hidden.bs.modal', function() {
            createForm.reset();
            clearValidationStates(createForm);
            hideImagePreviews();
        });
    }

    function clearValidationStates(form) {
        // Remove validation classes
        const inputs = form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-invalid', 'is-valid');
            const feedback = input.parentNode.querySelector('.invalid-feedback');
            if (feedback) {
                feedback.textContent = '';
            }
        });
    }

    function displayValidationErrors(form, errors) {
        Object.keys(errors).forEach(fieldName => {
            const input = form.querySelector(`[name="${fieldName}"]`);
            if (input) {
                input.classList.add('is-invalid');
                const feedback = input.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = errors[fieldName];
                }
            }
        });
    }
});

// CreateVillaModal class for external access
class CreateVillaModal {
    constructor() {
        this.modal = document.getElementById('createVillaModal');
        this.form = document.getElementById('createVillaForm');
    }

    show() {
        if (this.modal) {
            const modal = new bootstrap.Modal(this.modal);
            modal.show();
        }
    }

    hide() {
        if (this.modal) {
            const modalInstance = bootstrap.Modal.getInstance(this.modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        }
    }

    reset() {
        if (this.form) {
            this.form.reset();
            this.clearValidation();
            // Clear image previews
            const previewContainer = document.getElementById('imagePreviewContainer');
            const previewGrid = document.getElementById('imagePreviewGrid');
            if (previewContainer) previewContainer.style.display = 'none';
            if (previewGrid) previewGrid.innerHTML = '';
        }
    }

    clearValidation() {
        if (this.form) {
            const inputs = this.form.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
                const feedback = input.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = '';
                }
            });
        }
    }
}

// Make globally available
window.CreateVillaModal = CreateVillaModal;
</script>