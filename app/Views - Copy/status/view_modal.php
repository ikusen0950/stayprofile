<!--begin::View Status Modal-->
<div class="modal fade" id="viewStatusModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Status Details</h2>
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
                    <!--begin::Status Info-->
                    <div class="card card-flush mb-6">
                        <div class="card-body pt-4">
                            <div class="d-flex flex-column">
                                <!--begin::Status Name with Color-->
                                <div class="d-flex align-items-center mb-4">
                                    <div id="view_color_preview" class="color-preview me-3" style="background-color: #000000; width: 30px; height: 30px;"></div>
                                    <h3 id="view_status_name" class="fw-bold mb-0">Status Name</h3>
                                </div>
                                <!--end::Status Name with Color-->
                                
                                <!--begin::Module Info-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Module:</label>
                                    <span id="view_module_name" class="badge badge-light-info fs-6">Module Name</span>
                                </div>
                                <!--end::Module Info-->
                                
                                <!--begin::Color Info-->
                                <div class="mb-4" id="view_color_section">
                                    <label class="fw-semibold fs-6 mb-2">Color Code:</label>
                                    <span id="view_color_code" class="text-muted">#000000</span>
                                </div>
                                <!--end::Color Info-->
                                
                                <!--begin::Description-->
                                <div class="mb-4" id="view_description_section">
                                    <label class="fw-semibold fs-6 mb-2">Description:</label>
                                    <div id="view_description" class="text-gray-700">No description provided</div>
                                </div>
                                <!--end::Description-->
                            </div>
                        </div>
                    </div>
                    <!--end::Status Info-->
                    
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
                <?php if ($permissions['canEdit']): ?>
                <button type="button" class="btn btn-light-primary me-3" id="view_edit_btn">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit Status
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
<!--end::View Status Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewModal = document.getElementById('viewStatusModal');
    const editBtn = document.getElementById('view_edit_btn');
    
    // Handle edit button click
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const statusId = this.getAttribute('data-status-id');
            if (statusId) {
                // Hide view modal
                const viewModalInstance = bootstrap.Modal.getInstance(viewModal);
                viewModalInstance.hide();
                
                // Open edit modal
                editStatus(statusId);
            }
        });
    }
});
</script>