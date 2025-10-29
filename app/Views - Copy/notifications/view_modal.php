<!--begin::View Notification Modal-->
<div class="modal fade" id="viewNotificationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Notification Details</h2>
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
                    <!--begin::Notification Info-->
                    <div class="card card-flush mb-6">
                        <div class="card-body pt-4">
                            <div class="d-flex flex-column">
                                <!--begin::Notification Title-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Title:</label>
                                    <h3 id="view_notification_title" class="fw-bold text-dark mb-0">Notification Title</h3>
                                </div>
                                <!--end::Notification Title-->
                                
                                <!--begin::User Info-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">For User:</label>
                                    <span id="view_user_name" class="badge badge-light-primary fs-6">User Name</span>
                                </div>
                                <!--end::User Info-->
                                
                                <!--begin::Status Info-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Status:</label>
                                    <span id="view_status_name" class="badge badge-light-info fs-6">Status Name</span>
                                </div>
                                <!--end::Status Info-->
                                
                                <!--begin::Body-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2">Body/Message:</label>
                                    <div id="view_notification_body" class="text-gray-700 p-3 bg-light rounded">
                                        Notification body content
                                    </div>
                                </div>
                                <!--end::Body-->
                                
                                <!--begin::URL-->
                                <div class="mb-4" id="view_url_section">
                                    <label class="fw-semibold fs-6 mb-2">URL:</label>
                                    <div class="url-preview">
                                        <i class="ki-duotone ki-abstract-25 fs-7 me-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <a id="view_url_link" href="#" target="_blank" class="text-primary">URL will appear here</a>
                                    </div>
                                </div>
                                <!--end::URL-->
                            </div>
                        </div>
                    </div>
                    <!--end::Notification Info-->
                    
                    <!--begin::Audit Info-->
                    <div class="card card-flush">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Audit Information</h4>
                            <div class="row">
                                <!--begin::Created Info-->
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Created At:</label>
                                        <div id="view_created_at" class="text-gray-700">-</div>
                                    </div>
                                </div>
                                <!--end::Created Info-->
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
                    </i>Edit Notification
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
<!--end::View Notification Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewModal = document.getElementById('viewNotificationModal');
    const editBtn = document.getElementById('view_edit_btn');
    
    // Handle edit button click
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-notification-id');
            if (notificationId) {
                // Hide view modal
                const viewModalInstance = bootstrap.Modal.getInstance(viewModal);
                viewModalInstance.hide();
                
                // Open edit modal
                editNotification(notificationId);
            }
        });
    }
});
</script>