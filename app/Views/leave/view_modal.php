<!--begin::View Leave Modal-->
<style>
@media (max-width: 576px) {
    #viewLeaveModal .modal-dialog {
        max-width: 100vw;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    #viewLeaveModal .modal-content {
        height: 100vh;
        border-radius: 0;
    }
    #viewLeaveModal .modal-body {
        height: calc(100vh - 56px - 56px);
        overflow-y: auto;
    }
    #viewLeaveModal .modal-header,
    #viewLeaveModal .modal-footer {
        border-radius: 0;
    }
}
</style>
<div class="modal fade" id="viewLeaveModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Leave Details</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y p-4">
                <div class="d-flex flex-column">
                    <div class="card card-flush mb-6">
                        <div class="card-body pt-4">
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-4">
                                    <h3 id="view_leave_name" class="fw-bold mb-0">Leave Name</h3>
                                </div>
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Module:</label>
                                    <span id="view_module_id" class="badge badge-light-info fs-6">Module ID</span>
                                </div>
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Status:</label>
                                    <span id="view_status_id" class="badge badge-light-success fs-6">Status ID</span>
                                </div>
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Description:</label>
                                    <span id="view_description" class="fs-6">Description</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
