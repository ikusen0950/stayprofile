<!--begin::Modal - Edit Villa-->
<div class="modal fade" id="editVillaModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="editVillaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="fw-bold" id="editVillaModalLabel">Edit Villa</h2>
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
                <form id="editVillaForm" class="form" enctype="multipart/form-data">
                    <input type="hidden" id="edit_villa_id" name="villa_id" value="">
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

                        <!--begin::Input group - Existing Images-->
                        <div class="fv-row mb-7" id="existingImagesSection">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Current Images</label>
                            <!--end::Label-->
                            <div id="existingImagesContainer" class="row g-3 mb-3"></div>
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group - Add New Images-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Add New Images</label>
                            <!--end::Label-->
                            <!--begin::File input-->
                            <input type="file" name="villa_images[]" class="form-control form-control-solid mb-3" 
                                   multiple accept="image/*" id="editVillaImages" />
                            <!--end::File input-->
                            <div class="form-text">You can select multiple images. Supported formats: JPEG, PNG, GIF, WebP. Max size per image: 5MB.</div>
                            <div class="invalid-feedback"></div>
                            
                            <!--begin::New image preview container-->
                            <div id="editImagePreviewContainer" class="mt-4" style="display: none;">
                                <h6 class="fw-semibold fs-7 mb-3">New Images:</h6>
                                <div id="editImagePreviewGrid" class="row g-3"></div>
                            </div>
                            <!--end::New image preview container-->
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
                <button type="submit" class="btn btn-primary" form="editVillaForm">
                    <span class="indicator-label">Update Villa</span>
                    <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Modal - Edit Villa-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editVillaForm');
    const editModal = document.getElementById('editVillaModal');
    const submitBtn = editForm.querySelector('button[type="submit"], button[form="editVillaForm"]');
    const imageInput = document.getElementById('editVillaImages');
    const previewContainer = document.getElementById('editImagePreviewContainer');
    const previewGrid = document.getElementById('editImagePreviewGrid');

    // Handle new image preview
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const files = e.target.files;
            if (files.length > 0) {
                showNewImagePreviews(files);
            } else {
                hideNewImagePreviews();
            }
        });
    }

    function showNewImagePreviews(files) {
        previewGrid.innerHTML = '';
        previewContainer.style.display = 'block';

        Array.from(files).forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewItem = createNewImagePreviewItem(e.target.result, file.name, index);
                    previewGrid.appendChild(previewItem);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    function createNewImagePreviewItem(src, fileName, index) {
        const col = document.createElement('div');
        col.className = 'col-md-3 col-sm-4 col-6';
        
        col.innerHTML = `
            <div class="card border border-primary">
                <div class="card-body p-2">
                    <img src="${src}" class="img-fluid rounded mb-2" style="height: 80px; width: 100%; object-fit: cover;" alt="Preview">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted text-truncate">${fileName}</small>
                        <button type="button" class="btn btn-sm btn-light-danger remove-new-image" data-index="${index}">
                            <i class="ki-duotone ki-trash fs-7">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                                <span class="path5"></span>
                            </i>
                        </button>
                    </div>
                    <small class="badge badge-success">New</small>
                </div>
            </div>
        `;

        // Add remove functionality
        const removeBtn = col.querySelector('.remove-new-image');
        removeBtn.addEventListener('click', function() {
            removeNewImageFromInput(parseInt(this.getAttribute('data-index')));
        });

        return col;
    }

    function removeNewImageFromInput(indexToRemove) {
        const dt = new DataTransfer();
        const files = imageInput.files;

        for (let i = 0; i < files.length; i++) {
            if (i !== indexToRemove) {
                dt.items.add(files[i]);
            }
        }

        imageInput.files = dt.files;
        
        if (dt.files.length > 0) {
            showNewImagePreviews(dt.files);
        } else {
            hideNewImagePreviews();
        }
    }

    function hideNewImagePreviews() {
        previewContainer.style.display = 'none';
        previewGrid.innerHTML = '';
    }

    if (editForm) {
        editForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const villaId = document.getElementById('edit_villa_id').value;
            if (!villaId) {
                Swal.fire('Error', 'Villa ID is missing', 'error');
                return;
            }
            
            // Clear previous validation states
            clearValidationStates(editForm);
            
            // Show loading state
            if (submitBtn) {
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.disabled = true;
            }

            const formData = new FormData(editForm);
            
            secureFetch(`/villas/update/${villaId}`, {
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
                    bootstrap.Modal.getInstance(editModal).hide();
                    
                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reload page to show updated villa
                        window.location.reload();
                    });
                } else {
                    // Handle validation errors
                    if (data.errors) {
                        displayValidationErrors(editForm, data.errors);
                    }
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.message || 'Failed to update villa'
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
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function() {
            editForm.reset();
            clearValidationStates(editForm);
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

// EditVillaModal class for external access
class EditVillaModal {
    constructor() {
        this.modal = document.getElementById('editVillaModal');
        this.form = document.getElementById('editVillaForm');
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

    populateForm(villaData) {
        if (this.form && villaData) {
            document.getElementById('edit_villa_id').value = villaData.id || '';
            this.form.querySelector('[name="villa_name"]').value = villaData.villa_name || '';
            this.form.querySelector('[name="villa_code"]').value = villaData.villa_code || '';
            this.form.querySelector('[name="capacity"]').value = villaData.capacity || '';
            this.form.querySelector('[name="description"]').value = villaData.description || '';
        }
    }

    reset() {
        if (this.form) {
            this.form.reset();
            this.clearValidation();
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
window.EditVillaModal = EditVillaModal;

// Function to populate existing images (called from index.php)
window.populateExistingImages = function(images) {
    const container = document.getElementById('existingImagesContainer');
    const section = document.getElementById('existingImagesSection');
    
    if (!container) {
        console.log('existingImagesContainer not found');
        return;
    }
    
    console.log('Populating existing images:', images);
    
    container.innerHTML = '';
    
    if (!images || images.length === 0) {
        section.style.display = 'none';
        console.log('No images to display');
        return;
    }
    
    section.style.display = 'block';
    
    images.forEach((image, index) => {
        console.log(`Processing image ${index}:`, image);
        
        const col = document.createElement('div');
        col.className = 'col-md-3 col-sm-4 col-6';
        
        const imageUrl = `/assets/media/villas/${image.image_path}`;
        
        col.innerHTML = `
            <div class="card border ${image.is_primary == 1 ? 'border-success' : ''}">
                <div class="card-body p-2">
                    <img src="${imageUrl}" class="img-fluid rounded mb-2" style="height: 80px; width: 100%; object-fit: cover;" alt="${image.alt_text || 'Villa image'}" onerror="console.error('Failed to load image:', this.src)">
                    <div class="d-flex justify-content-between align-items-center">
                        <small class="text-muted text-truncate">${image.image_name || 'Villa image'}</small>
                        <div class="btn-group">
                            ${image.is_primary != 1 ? `
                                <button type="button" class="btn btn-sm btn-light-primary set-primary" data-image-id="${image.id}" title="Set as Primary">
                                    <i class="ki-duotone ki-star fs-7">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </button>
                            ` : ''}
                            <button type="button" class="btn btn-sm btn-light-danger delete-existing-image" data-image-id="${image.id}" title="Delete Image">
                                <i class="ki-duotone ki-trash fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                    <span class="path4"></span>
                                    <span class="path5"></span>
                                </i>
                            </button>
                        </div>
                    </div>
                    ${image.is_primary == 1 ? '<small class="badge badge-success">Primary</small>' : ''}
                </div>
            </div>
        `;
        
        container.appendChild(col);
    });
    
    // Remove any existing event listeners to prevent duplicates
    const existingListener = container.getAttribute('data-listener-added');
    if (!existingListener) {
        // Add event listeners for existing image actions
        container.addEventListener('click', function(e) {
            if (e.target.closest('.delete-existing-image')) {
                const imageId = e.target.closest('.delete-existing-image').getAttribute('data-image-id');
                deleteExistingImage(imageId, e.target.closest('.col-md-3'));
            } else if (e.target.closest('.set-primary')) {
                const imageId = e.target.closest('.set-primary').getAttribute('data-image-id');
                const villaId = document.getElementById('edit_villa_id').value;
                setPrimaryImage(villaId, imageId);
            }
        });
        container.setAttribute('data-listener-added', 'true');
    }
    
    console.log(`Successfully populated ${images.length} images`);
};

// Delete existing image
function deleteExistingImage(imageId, element) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This image will be permanently deleted!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            secureFetch(`/villas/delete-image/${imageId}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    element.remove();
                    Swal.fire('Deleted!', data.message, 'success');
                    
                    // Check if no images left
                    const container = document.getElementById('existingImagesContainer');
                    if (container.children.length === 0) {
                        document.getElementById('existingImagesSection').style.display = 'none';
                    }
                } else {
                    Swal.fire('Error!', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error!', 'Failed to delete image', 'error');
            });
        }
    });
}

// Set primary image
function setPrimaryImage(villaId, imageId) {
    secureFetch('/villas/set-primary-image', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            villa_id: villaId,
            image_id: imageId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Refresh the existing images display
            const villaId = document.getElementById('edit_villa_id').value;
            // Reload villa data to refresh image states
            secureFetch(`/villas/${villaId}`)
                .then(response => response.json())
                .then(villaData => {
                    if (villaData.success) {
                        populateExistingImages(villaData.data.images || []);
                    }
                });
            
            Swal.fire('Success!', data.message, 'success');
        } else {
            Swal.fire('Error!', data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error!', 'Failed to set primary image', 'error');
    });
}
</script>