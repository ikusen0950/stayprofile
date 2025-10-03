<!--begin::View Module Modal-->
<div class="modal fade" id="viewModuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Module Details</h2>
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
                <!--begin::Details-->
                <div class="d-flex flex-column">
                    <!--begin::Module Info-->
                    <div class="card card-flush mb-6">
                        <div class="card-body pt-4">
                            <div class="d-flex flex-column">
                                <!--begin::Module Name-->
                                <div class="d-flex align-items-center mb-4">
                                    <h3 id="view_module_name" class="fw-bold mb-0">Module Name</h3>
                                </div>
                                <!--end::Module Name-->
                                
                                <!--begin::Status Info-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Status:</label>
                                    <span id="view_status_badge" class="badge badge-light-info fs-6">Status Name</span>
                                </div>
                                <!--end::Status Info-->
                                
                                <!--begin::Description-->
                                <div class="mb-4" id="view_description_section">
                                    <label class="fw-semibold fs-6 mb-2">Description:</label>
                                    <div id="view_module_description" class="text-gray-700">No description provided</div>
                                </div>
                                <!--end::Description-->
                            </div>
                        </div>
                    </div>
                    <!--end::Module Info-->
                    
                    <!--begin::Audit Info-->
                    <div class="card card-flush">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Audit Information</h4>
                            <div class="row">
                                <!--begin::Created Info-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Created By:</label>
                                        <div id="view_created_by" class="text-gray-700">System</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Created At:</label>
                                        <div id="view_created_at" class="text-gray-700">-</div>
                                    </div>
                                </div>
                                <!--end::Created Info-->
                                
                                <!--begin::Updated Info-->
                                <div class="col-md-6">
                                    <div class="mb-4" id="view_updated_by_section">
                                        <label class="fw-semibold fs-6 mb-2">Updated By:</label>
                                        <div id="view_updated_by" class="text-gray-700">-</div>
                                    </div>
                                    <div class="mb-4" id="view_updated_at_section">
                                        <label class="fw-semibold fs-6 mb-2">Updated At:</label>
                                        <div id="view_updated_at" class="text-gray-700">-</div>
                                    </div>
                                </div>
                                <!--end::Updated Info-->
                            </div>
                        </div>
                    </div>
                    <!--end::Audit Info-->
                </div>
                <!--end::Details-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <?php if (isset($permissions) && $permissions['canEdit']): ?>
                <button type="button" class="btn btn-light-primary me-3" id="view_edit_btn">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit Module
                </button>
                <?php endif; ?>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <!--end::Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::View Module Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewModal = document.getElementById('viewModuleModal');
    const editBtn = document.getElementById('view_edit_btn');
    
    // Handle edit button click
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const moduleId = this.getAttribute('data-module-id');
            if (moduleId) {
                // Hide view modal
                const viewModalInstance = bootstrap.Modal.getInstance(viewModal);
                viewModalInstance.hide();
                
                // Open edit modal
                editModule(moduleId);
            }
        });
    }
});

// Function to populate view modal (called from index.php)
function openViewModal(module) {
    // Populate module info
    document.getElementById('view_module_name').textContent = module.name;
    
    // Handle status display with color
    const statusBadge = document.getElementById('view_status_badge');
    if (module.status_color) {
        const hex = module.status_color.replace('#', '');
        const r = parseInt(hex.substr(0, 2), 16);
        const g = parseInt(hex.substr(2, 2), 16);
        const b = parseInt(hex.substr(4, 2), 16);
        const lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;
        statusBadge.style.backgroundColor = lightBg;
        statusBadge.style.color = module.status_color;
    } else {
        statusBadge.style.backgroundColor = 'rgba(108, 117, 125, 0.1)';
        statusBadge.style.color = '#6c757d';
    }
    statusBadge.textContent = (module.status_name || 'Unknown').toUpperCase();
    
    // Handle description
    const descriptionSection = document.getElementById('view_description_section');
    const descriptionDiv = document.getElementById('view_module_description');
    if (module.description && module.description.trim() !== '') {
        descriptionDiv.textContent = module.description;
        descriptionSection.style.display = 'block';
    } else {
        descriptionDiv.textContent = 'No description provided';
        descriptionSection.style.display = 'block';
    }
    
    // Populate audit info
    document.getElementById('view_created_by').textContent = module.created_by_name || 'System';
    document.getElementById('view_created_at').textContent = module.created_at ? 
        new Date(module.created_at).toLocaleString() : '-';
    
    // Handle updated info
    const updatedBySection = document.getElementById('view_updated_by_section');
    const updatedAtSection = document.getElementById('view_updated_at_section');
    const updatedByDiv = document.getElementById('view_updated_by');
    const updatedAtDiv = document.getElementById('view_updated_at');
    
    if (module.updated_by_name && module.updated_at) {
        updatedByDiv.textContent = module.updated_by_name;
        updatedAtDiv.textContent = new Date(module.updated_at).toLocaleString();
        updatedBySection.style.display = 'block';
        updatedAtSection.style.display = 'block';
    } else {
        updatedByDiv.textContent = '-';
        updatedAtDiv.textContent = '-';
        updatedBySection.style.display = 'block';
        updatedAtSection.style.display = 'block';
    }
    
    // Set edit button data if it exists
    const editBtn = document.getElementById('view_edit_btn');
    if (editBtn) {
        editBtn.setAttribute('data-module-id', module.id);
    }
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('viewModuleModal'));
    modal.show();
}
</script>