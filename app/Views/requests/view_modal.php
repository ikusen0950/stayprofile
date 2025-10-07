<!--begin::View Request Modal-->
<div class="modal fade" id="viewRequestModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Request Details</h2>
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
                    <!--begin::Request Basic Info-->
                    <div class="card card-flush mb-6">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Basic Information</h4>
                            <div class="row">
                                <!--begin::Request ID and Type-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Request ID:</label>
                                        <span id="view_request_id" class="badge badge-light-primary fs-6">#000</span>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Type:</label>
                                        <div class="d-flex align-items-center">
                                            <div id="view_type_color_preview" class="color-preview me-3" style="background-color: #000000; width: 20px; height: 20px;"></div>
                                            <span id="view_type" class="fw-bold">General</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Request ID and Type-->
                                
                                <!--begin::User and Status-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">User:</label>
                                        <div id="view_user_name" class="text-gray-700">Unknown User</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Status:</label>
                                        <span id="view_status_name" class="badge badge-light-info fs-6">Unknown</span>
                                    </div>
                                </div>
                                <!--end::User and Status-->
                            </div>
                            
                            <!--begin::Type Description-->
                            <div class="mb-4" id="view_type_description_section">
                                <label class="fw-semibold fs-6 mb-2">Description:</label>
                                <div id="view_type_description" class="text-gray-700">No description provided</div>
                            </div>
                            <!--end::Type Description-->
                        </div>
                    </div>
                    <!--end::Request Basic Info-->
                    
                    <!--begin::Transfer Information-->
                    <div class="card card-flush mb-6" id="view_transfer_section">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Transfer Information</h4>
                            <div class="row">
                                <!--begin::Transfer Details-->
                                <div class="col-md-6">
                                    <div class="mb-4" id="view_transfer_type_section">
                                        <label class="fw-semibold fs-6 mb-2">Transfer Type:</label>
                                        <div id="view_transfer_type" class="text-gray-700">-</div>
                                    </div>
                                    <div class="mb-4" id="view_transfer_route_type_section">
                                        <label class="fw-semibold fs-6 mb-2">Route Type:</label>
                                        <div id="view_transfer_route_type" class="text-gray-700">-</div>
                                    </div>
                                    <div class="mb-4" id="view_mode_of_transport_section">
                                        <label class="fw-semibold fs-6 mb-2">Mode of Transport:</label>
                                        <div id="view_mode_of_transport" class="text-gray-700">-</div>
                                    </div>
                                </div>
                                <!--end::Transfer Details-->
                                
                                <!--begin::Transfer Dates-->
                                <div class="col-md-6">
                                    <div class="mb-4" id="view_departure_date_section">
                                        <label class="fw-semibold fs-6 mb-2">Departure Date:</label>
                                        <div id="view_transfer_departure_date" class="text-gray-700">-</div>
                                    </div>
                                    <div class="mb-4" id="view_arrival_date_section">
                                        <label class="fw-semibold fs-6 mb-2">Arrival Date:</label>
                                        <div id="view_transfer_arrival_date" class="text-gray-700">-</div>
                                    </div>
                                    <div class="mb-4" id="view_expected_dates_section">
                                        <label class="fw-semibold fs-6 mb-2">Expected Dates:</label>
                                        <div class="text-gray-700">
                                            <small class="d-block">Departure: <span id="view_expected_departure_date">-</span></small>
                                            <small class="d-block">Arrival: <span id="view_expected_arrival_date">-</span></small>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Transfer Dates-->
                            </div>
                        </div>
                    </div>
                    <!--end::Transfer Information-->
                    
                    <!--begin::Flight Details-->
                    <div class="card card-flush mb-6" id="view_flight_section">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Flight Details</h4>
                            <div class="row">
                                <!--begin::Departure Flight-->
                                <div class="col-md-6">
                                    <div class="mb-4" id="view_departure_carrier_section">
                                        <label class="fw-semibold fs-6 mb-2">Departure Carrier:</label>
                                        <div id="view_transfer_departure_carrier" class="text-gray-700">-</div>
                                    </div>
                                    <div class="mb-4" id="view_departure_flight_section">
                                        <label class="fw-semibold fs-6 mb-2">Flight Number:</label>
                                        <div id="view_transfer_departure_flight" class="text-gray-700">-</div>
                                    </div>
                                </div>
                                <!--end::Departure Flight-->
                                
                                <!--begin::Booking Details-->
                                <div class="col-md-6">
                                    <div class="mb-4" id="view_departure_pnr_section">
                                        <label class="fw-semibold fs-6 mb-2">PNR/Booking Reference:</label>
                                        <div id="view_transfer_departure_pnr" class="text-gray-700">-</div>
                                    </div>
                                </div>
                                <!--end::Booking Details-->
                            </div>
                        </div>
                    </div>
                    <!--end::Flight Details-->
                    
                    <!--begin::Additional Options-->
                    <div class="card card-flush mb-6" id="view_options_section">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Additional Options</h4>
                            <div class="row">
                                <!--begin::Approval Level-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Approval Level:</label>
                                        <span id="view_approval_level" class="badge badge-light-warning fs-6">Level 0</span>
                                    </div>
                                </div>
                                <!--end::Approval Level-->
                                
                                <!--begin::Services-->
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2">Additional Services:</label>
                                        <div class="d-flex flex-column">
                                            <span id="view_second_transfer" class="badge badge-light-success me-2 mb-2 d-none">Second Transfer</span>
                                            <span id="view_luggage_assistance" class="badge badge-light-info me-2 mb-2 d-none">Luggage Assistance</span>
                                            <span id="view_is_assistant_manager" class="badge badge-light-primary me-2 mb-2 d-none">Assistant Manager</span>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Services-->
                            </div>
                        </div>
                    </div>
                    <!--end::Additional Options-->
                    
                    <!--begin::Remarks-->
                    <div class="card card-flush mb-6" id="view_remarks_section">
                        <div class="card-body pt-4">
                            <h4 class="fw-bold mb-4">Remarks</h4>
                            <div id="view_remarks" class="text-gray-700">No additional remarks</div>
                        </div>
                    </div>
                    <!--end::Remarks-->
                    
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
                    </i>Edit Request
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
<!--end::View Request Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewModal = document.getElementById('viewRequestModal');
    const editBtn = document.getElementById('view_edit_btn');
    
    // Handle edit button click
    if (editBtn) {
        editBtn.addEventListener('click', function() {
            const requestId = this.getAttribute('data-request-id');
            if (requestId) {
                // Hide view modal
                const viewModalInstance = bootstrap.Modal.getInstance(viewModal);
                viewModalInstance.hide();
                
                // Open edit modal
                editRequest(requestId);
            }
        });
    }
});

// Function to populate view modal (called from index.php)
function populateViewModal(request) {
    // Basic information
    document.getElementById('view_request_id').textContent = '#' + request.id;
    document.getElementById('view_user_name').textContent = request.user_name || 'Unknown User';
    document.getElementById('view_status_name').textContent = request.status_name || 'Unknown';
    document.getElementById('view_type').textContent = request.type || 'General';
    
    // Type color
    const typeColorPreview = document.getElementById('view_type_color_preview');
    if (request.type_color) {
        typeColorPreview.style.backgroundColor = request.type_color;
        typeColorPreview.style.display = 'block';
    } else {
        typeColorPreview.style.display = 'none';
    }
    
    // Type description
    const typeDescription = document.getElementById('view_type_description');
    const typeDescriptionSection = document.getElementById('view_type_description_section');
    if (request.type_description && request.type_description.trim() !== '') {
        typeDescription.textContent = request.type_description;
        typeDescriptionSection.style.display = 'block';
    } else {
        typeDescription.textContent = 'No description provided';
        typeDescriptionSection.style.display = 'block';
    }
    
    // Transfer information
    document.getElementById('view_transfer_type').textContent = request.transfer_type || '-';
    document.getElementById('view_transfer_route_type').textContent = request.transfer_route_type || '-';
    document.getElementById('view_mode_of_transport').textContent = request.mode_of_transport || '-';
    
    // Dates
    document.getElementById('view_transfer_departure_date').textContent = request.transfer_departure_date ? 
        new Date(request.transfer_departure_date).toLocaleDateString() : '-';
    document.getElementById('view_transfer_arrival_date').textContent = request.transfer_arrival_date ? 
        new Date(request.transfer_arrival_date).toLocaleDateString() : '-';
    document.getElementById('view_expected_departure_date').textContent = request.expected_departure_date ? 
        new Date(request.expected_departure_date).toLocaleDateString() : '-';
    document.getElementById('view_expected_arrival_date').textContent = request.expected_arrival_date ? 
        new Date(request.expected_arrival_date).toLocaleDateString() : '-';
    
    // Flight details
    document.getElementById('view_transfer_departure_carrier').textContent = request.transfer_departure_carrier || '-';
    document.getElementById('view_transfer_departure_flight').textContent = request.transfer_departure_flight || '-';
    document.getElementById('view_transfer_departure_pnr').textContent = request.transfer_departure_pnr || '-';
    
    // Approval level
    const approvalLevels = {
        '0': 'No Approval Required',
        '1': 'Level 1 Approval',
        '2': 'Level 2 Approval',
        '3': 'Level 3 Approval'
    };
    document.getElementById('view_approval_level').textContent = approvalLevels[request.approval_level] || 'Level 0';
    
    // Additional services
    const secondTransferBadge = document.getElementById('view_second_transfer');
    const luggageAssistanceBadge = document.getElementById('view_luggage_assistance');
    const assistantManagerBadge = document.getElementById('view_is_assistant_manager');
    
    secondTransferBadge.classList.toggle('d-none', !request.second_transfer || request.second_transfer != 1);
    luggageAssistanceBadge.classList.toggle('d-none', !request.luggage_assistance || request.luggage_assistance != 1);
    assistantManagerBadge.classList.toggle('d-none', !request.is_assistant_manager || request.is_assistant_manager != 1);
    
    // Remarks
    const remarks = document.getElementById('view_remarks');
    const remarksSection = document.getElementById('view_remarks_section');
    if (request.remarks && request.remarks.trim() !== '') {
        remarks.textContent = request.remarks;
        remarksSection.style.display = 'block';
    } else {
        remarks.textContent = 'No additional remarks';
        remarksSection.style.display = 'block';
    }
    
    // Audit info
    document.getElementById('view_created_by').textContent = request.created_by_name || 'System';
    document.getElementById('view_created_at').textContent = request.created_at ? 
        new Date(request.created_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) : '-';
    
    // Updated info (show/hide based on availability)
    const updatedBySection = document.getElementById('view_updated_by_section');
    const updatedAtSection = document.getElementById('view_updated_at_section');
    
    if (request.updated_by_name) {
        document.getElementById('view_updated_by').textContent = request.updated_by_name;
        updatedBySection.style.display = 'block';
    } else {
        updatedBySection.style.display = 'none';
    }
    
    if (request.updated_at) {
        document.getElementById('view_updated_at').textContent = new Date(request.updated_at).toLocaleDateString('en-US', { 
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
    
    // Set request ID for edit button if it exists
    const editBtn = document.getElementById('view_edit_btn');
    if (editBtn) {
        editBtn.setAttribute('data-request-id', request.id);
    }
}
</script>