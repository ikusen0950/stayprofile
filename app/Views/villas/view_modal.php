<!--begin::Modal - View Villa-->
<div class="modal fade" id="viewVillaModal" tabindex="-1" aria-labelledby="viewVillaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="fw-bold" id="viewVillaModalLabel">Villa Details</h2>
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
                <!--begin::Villa Details-->
                <div class="d-flex flex-column">

                    <!--begin::Basic Info-->
                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold text-gray-800">Basic Information</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Villa Name:</label>
                                        <span class="fs-5 fw-bold text-gray-800" id="view_villa_name">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Villa Code:</label>
                                        <span class="fs-5 fw-bold text-primary" id="view_villa_code">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Capacity:</label>
                                        <span class="fs-5 fw-bold text-success" id="view_capacity">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Basic Info-->

                    <!--begin::Description-->
                    <div class="card mb-5" id="view_description_section">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold text-gray-800">Description</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="fs-6 text-gray-700 mb-0" id="view_description">-</p>
                        </div>
                    </div>
                    <!--end::Description-->

                    <!--begin::Villa Images-->
                    <div class="card" id="view_images_section" style="display: none;">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold text-gray-800">Villa Images</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="view_images_container" class="row g-3"></div>
                        </div>
                    </div>
                    <!--end::Villa Images-->

                    <!--begin::Audit Information-->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold text-gray-800">Audit Information</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Created By:</label>
                                        <span class="fs-6 text-gray-800" id="view_created_by">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Created At:</label>
                                        <span class="fs-6 text-gray-800" id="view_created_at">-</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="view_updated_section">
                                <div class="col-md-6" id="view_updated_by_section">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Updated By:</label>
                                        <span class="fs-6 text-gray-800" id="view_updated_by">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6" id="view_updated_at_section">
                                    <div class="d-flex flex-column">
                                        <label class="fs-6 fw-semibold text-gray-600">Updated At:</label>
                                        <span class="fs-6 text-gray-800" id="view_updated_at">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Audit Information-->

                </div>
                <!--end::Villa Details-->
            </div>
            <!--end::Modal body-->

            <!--begin::Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <?php if ($permissions['canEdit']): ?>
                <button type="button" class="btn btn-primary" id="view_edit_btn" data-villa-id="">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Edit Villa
                </button>
                <?php endif; ?>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::Modal - View Villa-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewModal = document.getElementById('viewVillaModal');
    
    // Handle edit button click from view modal
    const editBtn = document.getElementById('view_edit_btn');
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const villaId = this.getAttribute('data-villa-id');
            if (villaId) {
                // Hide view modal
                bootstrap.Modal.getInstance(viewModal).hide();
                
                // Load and show edit modal
                editVilla(villaId);
            }
        });
    }
});

// ViewVillaModal class for external access
class ViewVillaModal {
    constructor() {
        this.modal = document.getElementById('viewVillaModal');
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

    populateModal(villaData) {
        if (!villaData) return;

        // Basic villa info
        document.getElementById('view_villa_name').textContent = villaData.villa_name || 'N/A';
        document.getElementById('view_villa_code').textContent = villaData.villa_code || 'N/A';
        document.getElementById('view_capacity').textContent = villaData.capacity ? `${villaData.capacity} guests` : 'Not specified';
        
        // Description
        const description = document.getElementById('view_description');
        const descriptionSection = document.getElementById('view_description_section');
        
        if (villaData.description && villaData.description.trim() !== '') {
            description.textContent = villaData.description;
            descriptionSection.style.display = 'block';
        } else {
            description.textContent = 'No description provided';
            descriptionSection.style.display = 'block';
        }
        
        // Audit info
        document.getElementById('view_created_by').textContent = villaData.created_by_name || 'System';
        document.getElementById('view_created_at').textContent = villaData.created_at ? 
            new Date(villaData.created_at).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }) : '-';
        
        // Updated info (show/hide based on availability)
        const updatedBySection = document.getElementById('view_updated_by_section');
        const updatedAtSection = document.getElementById('view_updated_at_section');
        
        if (villaData.updated_by_name) {
            document.getElementById('view_updated_by').textContent = villaData.updated_by_name;
            updatedBySection.style.display = 'block';
        } else {
            updatedBySection.style.display = 'none';
        }
        
        if (villaData.updated_at) {
            document.getElementById('view_updated_at').textContent = new Date(villaData.updated_at).toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            updatedAtSection.style.display = 'block';
        } else {
            updatedAtSection.style.display = 'none';
        }
        
        // Set villa ID for edit button
        const editBtn = document.getElementById('view_edit_btn');
        if (editBtn) {
            editBtn.setAttribute('data-villa-id', villaData.id);
        }
        
        // Populate images
        this.populateImages(villaData.images || []);
    }

    populateImages(images) {
        const imagesSection = document.getElementById('view_images_section');
        const imagesContainer = document.getElementById('view_images_container');
        
        if (!images || images.length === 0) {
            imagesSection.style.display = 'none';
            return;
        }
        
        imagesSection.style.display = 'block';
        imagesContainer.innerHTML = '';
        
        images.forEach((image, index) => {
            const col = document.createElement('div');
            col.className = 'col-md-4 col-sm-6 col-12';
            
            const imageUrl = `/assets/media/villas/${image.image_path}`;
            
            col.innerHTML = `
                <div class="card border ${image.is_primary == 1 ? 'border-success' : ''}">
                    <div class="card-body p-2">
                        <img src="${imageUrl}" 
                             class="img-fluid rounded mb-2 villa-image-preview" 
                             style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;" 
                             alt="${image.alt_text || 'Villa image'}"
                             data-bs-toggle="modal"
                             data-bs-target="#imagePreviewModal"
                             data-image-url="${imageUrl}"
                             data-image-name="${image.image_name || 'Villa image'}">
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted text-truncate">${image.image_name || 'Villa image'}</small>
                            ${image.is_primary == 1 ? '<small class="badge badge-success">Primary</small>' : ''}
                        </div>
                    </div>
                </div>
            `;
            
            imagesContainer.appendChild(col);
        });
        
        // Add click event for image preview
        imagesContainer.addEventListener('click', function(e) {
            if (e.target.classList.contains('villa-image-preview')) {
                const imageUrl = e.target.getAttribute('data-image-url');
                const imageName = e.target.getAttribute('data-image-name');
                showImagePreview(imageUrl, imageName);
            }
        });
    }
}

// Make globally available
window.ViewVillaModal = ViewVillaModal;

// Function to show image preview in a modal
function showImagePreview(imageUrl, imageName) {
    // Remove existing modal if any
    const existingModal = document.getElementById('imagePreviewModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Create new modal
    const modalHTML = `
        <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-labelledby="imagePreviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imagePreviewModalLabel">${imageName}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="${imageUrl}" class="img-fluid rounded" alt="${imageName}" style="max-height: 70vh;">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="${imageUrl}" class="btn btn-primary" target="_blank">View Full Size</a>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Add modal to body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
    
    // Remove modal from DOM when hidden
    document.getElementById('imagePreviewModal').addEventListener('hidden.bs.modal', function() {
        this.remove();
    });
}
</script>