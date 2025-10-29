<!--begin::View Log Modal-->
<div class="modal fade" id="viewLogModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Log Details</h2>
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
                    <!--begin::Log Info-->
                    <div class="card card-flush mb-6">
                        <div class="card-body pt-4">
                            <div class="d-flex flex-column">
                                <!--begin::Log ID and Status-->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h3 id="view_log_id" class="fw-bold mb-0">Log ID</h3>
                                    <span id="view_log_status" class="badge fw-bold log-status-badge">Status</span>
                                </div>
                                <!--end::Log ID and Status-->
                                
                                <!--begin::Action-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Action:</label>
                                    <div id="view_log_action" class="text-gray-700 fw-bold fs-5">Action Name</div>
                                </div>
                                <!--end::Action-->
                                
                                <!--begin::Module Info-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Module:</label>
                                    <span id="view_log_module" class="badge badge-light-info fs-6">Module Name</span>
                                </div>
                                <!--end::Module Info-->
                                
                                <!--begin::Message-->
                                <div class="mb-4" id="view_message_section">
                                    <label class="fw-semibold fs-6 mb-2">Message:</label>
                                    <div id="view_log_message" class="text-gray-700 p-3 bg-light-info rounded">No message provided</div>
                                </div>
                                <!--end::Message-->
                            </div>
                        </div>
                    </div>
                    <!--end::Log Info-->
                    
                    <!--begin::User and Timestamp Info-->
                    <div class="card card-flush">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Log Information</h4>
                            <div class="row">
                                <!--begin::User Info-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Logged By:</label>
                                        <div id="view_log_user" class="text-gray-700 d-flex align-items-center">
                                            <i class="ki-duotone ki-user fs-2 text-primary me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            System
                                        </div>
                                    </div>
                                </div>
                                <!--end::User Info-->
                                
                                <!--begin::Timestamp Info-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Logged At:</label>
                                        <div id="view_log_logged_at" class="text-gray-700 d-flex align-items-center">
                                            <i class="ki-duotone ki-calendar fs-2 text-primary me-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            -
                                        </div>
                                    </div>
                                </div>
                                <!--end::Timestamp Info-->
                            </div>
                        </div>
                    </div>
                    <!--end::User and Timestamp Info-->
                </div>
                <!--end::Details-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
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
<!--end::View Log Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewModal = document.getElementById('viewLogModal');
    
    // Handle modal cleanup
    if (viewModal) {
        viewModal.addEventListener('hidden.bs.modal', function () {
            // Reset modal content if needed
        });
    }
});
</script>