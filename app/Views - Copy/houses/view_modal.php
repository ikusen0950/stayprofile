<!--begin::View House Modal-->
<div class="modal fade" id="viewHouseModal" tabindex="-1" aria-labelledby="viewHouseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <h2 class="modal-title" id="viewHouseModalLabel">
                    <i class="ki-duotone ki-eye fs-2hx text-info me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    House Details
                </h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!--end::Modal header-->

            <!--begin::Modal body-->
            <div class="modal-body">
                <!--begin::Scroll-->
                <div class="scroll-y" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" 
                     data-kt-scroll-max-height="auto" data-kt-scroll-dependencies=".modal-header, .modal-footer"
                     data-kt-scroll-wrappers=".modal-body" data-kt-scroll-offset="300px">

                    <!--begin::House Information-->
                    <div class="card mb-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold">House Information</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!--begin::House Name-->
                            <div class="row mb-4">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Name:</label>
                                </div>
                                <div class="col-8">
                                    <span class="fw-bold text-gray-800" id="view_house_name">-</span>
                                </div>
                            </div>
                            <!--end::House Name-->

                            <!--begin::House Color-->
                            <div class="row mb-4">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Color:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_house_color">-</span>
                                </div>
                            </div>
                            <!--end::House Color-->

                            <!--begin::Description-->
                            <div class="row mb-4" id="view_house_description_section">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600" for="view_house_description">Description:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_house_description">-</span>
                                </div>
                            </div>
                            <!--end::Description-->

                            <!--begin::Status-->
                            <div class="row mb-4">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Status:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_house_status">-</span>
                                </div>
                            </div>
                            <!--end::Status-->
                        </div>
                    </div>
                    <!--end::House Information-->

                    <!--begin::Audit Information-->
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="fw-bold">Audit Information</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!--begin::Created By-->
                            <div class="row mb-4">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Created By:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_created_by">-</span>
                                </div>
                            </div>
                            <!--end::Created By-->

                            <!--begin::Created At-->
                            <div class="row mb-4">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Created At:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_created_at">-</span>
                                </div>
                            </div>
                            <!--end::Created At-->

                            <!--begin::Updated By-->
                            <div class="row mb-4" id="view_update_section" style="display: none;">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Updated By:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_updated_by">-</span>
                                </div>
                            </div>
                            <!--end::Updated By-->

                            <!--begin::Updated At-->
                            <div class="row mb-4" id="view_update_section_date" style="display: none;">
                                <div class="col-4">
                                    <label class="fw-semibold text-gray-600">Updated At:</label>
                                </div>
                                <div class="col-8">
                                    <span class="text-gray-800" id="view_updated_at">-</span>
                                </div>
                            </div>
                            <!--end::Updated At-->
                        </div>
                    </div>
                    <!--end::Audit Information-->

                </div>
                <!--end::Scroll-->
            </div>
            <!--end::Modal body-->

            <!--begin::Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Close
                </button>
                <?php if ($permissions['canEdit']): ?>
                <button type="button" class="btn btn-warning" id="view_edit_btn" data-house-id="">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Edit House
                </button>
                <?php endif; ?>
            </div>
            <!--end::Modal footer-->
        </div>
    </div>
</div>
<!--end::View House Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button in view modal
    const viewEditBtn = document.getElementById('view_edit_btn');
    const viewModal = document.getElementById('viewHouseModal');
    
    if (viewEditBtn) {
        viewEditBtn.addEventListener('click', function() {
            const houseId = this.getAttribute('data-house-id');
            if (houseId) {
                // Hide view modal
                const viewModalInstance = bootstrap.Modal.getInstance(viewModal);
                viewModalInstance.hide();
                
                // Load and show edit modal
                editHouse(houseId);
            }
        });
    }
});
</script>