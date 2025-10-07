<!--begin::Edit Request Modal-->
<div class="modal fade" id="editRequestModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Request</h2>
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
                <!--begin::Form-->
                <form id="editRequestForm" class="form">
                    <input type="hidden" id="edit_request_id" name="request_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!-- Basic Information Section -->
                        <div class="mb-8">
                            <h4 class="text-gray-800 fw-bold mb-6">Basic Information</h4>
                            
                            <!--begin::Row-->
                            <div class="row g-6">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">User</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select id="edit_user_id" name="user_id" class="form-select form-select-solid" data-control="select2" 
                                                data-placeholder="Select a user..." data-dropdown-parent="#editRequestModal">
                                            <option></option>
                                            <?php if (!empty($users)): ?>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?= esc($user['id']) ?>"><?= esc($user['full_name'] ?? 'Unknown') ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Status</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select id="edit_status_id" name="status_id" class="form-select form-select-solid" data-control="select2" 
                                                data-placeholder="Select a status..." data-dropdown-parent="#editRequestModal">
                                            <option></option>
                                            <?php if (!empty($statuses)): ?>
                                                <?php foreach ($statuses as $status): ?>
                                                    <option value="<?= esc($status['id']) ?>"><?= esc($status['name'] ?? 'Unknown') ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            
                            <!--begin::Row-->
                            <div class="row g-6 mt-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Type</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="edit_type" name="type" class="form-control form-control-solid" placeholder="Request type" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Type Color</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="color" id="edit_type_color" name="type_color" class="form-control form-control-solid" value="#000000" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            
                            <!--begin::Input group-->
                            <div class="fv-row mt-6">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Type Description</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea id="edit_type_description" name="type_description" class="form-control form-control-solid" rows="3" 
                                          placeholder="Description of the request type"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>

                        <!-- Transfer Information Section -->
                        <div class="mb-8">
                            <h4 class="text-gray-800 fw-bold mb-6">Transfer Information</h4>
                            
                            <!--begin::Row-->
                            <div class="row g-6">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Transfer Type</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select id="edit_transfer_type" name="transfer_type" class="form-select form-select-solid">
                                            <option value="">Select transfer type</option>
                                            <option value="arrival">Arrival</option>
                                            <option value="departure">Departure</option>
                                            <option value="both">Both</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Transfer Route Type</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select id="edit_transfer_route_type" name="transfer_route_type" class="form-select form-select-solid">
                                            <option value="">Select route type</option>
                                            <option value="direct">Direct</option>
                                            <option value="connecting">Connecting</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            
                            <!--begin::Row-->
                            <div class="row g-6 mt-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Departure Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" id="edit_transfer_departure_date" name="transfer_departure_date" class="form-control form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Arrival Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" id="edit_transfer_arrival_date" name="transfer_arrival_date" class="form-control form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            
                            <!--begin::Row-->
                            <div class="row g-6 mt-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Expected Departure Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" id="edit_expected_departure_date" name="expected_departure_date" class="form-control form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Expected Arrival Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" id="edit_expected_arrival_date" name="expected_arrival_date" class="form-control form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>

                        <!-- Flight Details Section -->
                        <div class="mb-8">
                            <h4 class="text-gray-800 fw-bold mb-6">Flight Details</h4>
                            
                            <!--begin::Row-->
                            <div class="row g-6">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Departure Carrier</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="edit_transfer_departure_carrier" name="transfer_departure_carrier" 
                                               class="form-control form-control-solid" placeholder="Airline name" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Departure Flight</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="edit_transfer_departure_flight" name="transfer_departure_flight" 
                                               class="form-control form-control-solid" placeholder="Flight number" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            
                            <!--begin::Row-->
                            <div class="row g-6 mt-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Departure PNR</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="text" id="edit_transfer_departure_pnr" name="transfer_departure_pnr" 
                                               class="form-control form-control-solid" placeholder="PNR/Booking reference" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Mode of Transport</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select id="edit_mode_of_transport" name="mode_of_transport" class="form-select form-select-solid">
                                            <option value="">Select transport mode</option>
                                            <option value="seaplane">Seaplane</option>
                                            <option value="speedboat">Speedboat</option>
                                            <option value="domestic_flight">Domestic Flight</option>
                                            <option value="other">Other</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>

                        <!-- Additional Options Section -->
                        <div class="mb-8">
                            <h4 class="text-gray-800 fw-bold mb-6">Additional Options</h4>
                            
                            <!--begin::Row-->
                            <div class="row g-6">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Approval Level</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select id="edit_approval_level" name="approval_level" class="form-select form-select-solid">
                                            <option value="0">No Approval Required</option>
                                            <option value="1">Level 1 Approval</option>
                                            <option value="2">Level 2 Approval</option>
                                            <option value="3">Level 3 Approval</option>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Checkbox group-->
                                    <div class="d-flex flex-column">
                                        <label class="fw-semibold fs-6 mb-4">Additional Services</label>
                                        
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="edit_second_transfer" name="second_transfer" value="1" />
                                            <label class="form-check-label" for="edit_second_transfer">
                                                Second Transfer Required
                                            </label>
                                        </div>
                                        
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" id="edit_luggage_assistance" name="luggage_assistance" value="1" />
                                            <label class="form-check-label" for="edit_luggage_assistance">
                                                Luggage Assistance
                                            </label>
                                        </div>
                                        
                                        <div class="form-check form-check-custom form-check-solid">
                                            <input class="form-check-input" type="checkbox" id="edit_is_assistant_manager" name="is_assistant_manager" value="1" />
                                            <label class="form-check-label" for="edit_is_assistant_manager">
                                                Assistant Manager Request
                                            </label>
                                        </div>
                                    </div>
                                    <!--end::Checkbox group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>

                        <!-- Remarks Section -->
                        <div class="mb-4">
                            <h4 class="text-gray-800 fw-bold mb-6">Remarks</h4>
                            
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Additional Remarks</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea id="edit_remarks" name="remarks" class="form-control form-control-solid" rows="4" 
                                          placeholder="Any additional remarks or special instructions"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>
                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="button" class="btn btn-primary" id="editRequestSubmitBtn">
                    <span class="indicator-label">Update Request</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Edit Request Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editRequestForm');
    const editModal = document.getElementById('editRequestModal');
    const submitBtn = document.getElementById('editRequestSubmitBtn');
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const requestId = document.getElementById('edit_request_id')?.value;
            if (!requestId) {
                Swal.fire('Error', 'Request ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(editForm);
            
            secureFetch(`/requests/update/${requestId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
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
                    const modal = bootstrap.Modal.getInstance(editModal);
                    modal.hide();
                    
                    // Reset form
                    editForm.reset();
                    
                    // Show success message
                    Swal.fire('Success!', data.message, 'success');
                    
                    // Reload page
                    window.location.reload();
                } else {
                    // Show validation errors
                    if (data.errors) {
                        let errorMessage = '';
                        for (const field in data.errors) {
                            errorMessage += data.errors[field] + '\n';
                        }
                        Swal.fire('Validation Error', errorMessage, 'error');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to update request', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
            });
        });
    }
    
    // Reset form when modal is hidden
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function () {
            editForm.reset();
            
            // Clear any validation states
            const inputs = editForm.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            
            // Reset Select2 elements
            const select2Elements = editForm.querySelectorAll('[data-control="select2"]');
            select2Elements.forEach(element => {
                if ($(element).hasClass('select2-hidden-accessible')) {
                    $(element).val('').trigger('change');
                }
            });
            
            // Reset checkboxes
            const checkboxes = editForm.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });
        });
    }
});

// Function to populate edit modal (called from index.php)
function populateEditModal(request) {
    // Basic information
    document.getElementById('edit_request_id').value = request.id;
    document.getElementById('edit_user_id').value = request.user_id || '';
    document.getElementById('edit_status_id').value = request.status_id || '';
    document.getElementById('edit_type').value = request.type || '';
    document.getElementById('edit_type_color').value = request.type_color || '#000000';
    document.getElementById('edit_type_description').value = request.type_description || '';
    
    // Transfer information
    document.getElementById('edit_transfer_type').value = request.transfer_type || '';
    document.getElementById('edit_transfer_route_type').value = request.transfer_route_type || '';
    document.getElementById('edit_transfer_departure_date').value = request.transfer_departure_date || '';
    document.getElementById('edit_transfer_arrival_date').value = request.transfer_arrival_date || '';
    document.getElementById('edit_expected_departure_date').value = request.expected_departure_date || '';
    document.getElementById('edit_expected_arrival_date').value = request.expected_arrival_date || '';
    
    // Flight details
    document.getElementById('edit_transfer_departure_carrier').value = request.transfer_departure_carrier || '';
    document.getElementById('edit_transfer_departure_flight').value = request.transfer_departure_flight || '';
    document.getElementById('edit_transfer_departure_pnr').value = request.transfer_departure_pnr || '';
    document.getElementById('edit_mode_of_transport').value = request.mode_of_transport || '';
    
    // Additional options
    document.getElementById('edit_approval_level').value = request.approval_level || '0';
    document.getElementById('edit_second_transfer').checked = request.second_transfer == 1;
    document.getElementById('edit_luggage_assistance').checked = request.luggage_assistance == 1;
    document.getElementById('edit_is_assistant_manager').checked = request.is_assistant_manager == 1;
    
    // Remarks
    document.getElementById('edit_remarks').value = request.remarks || '';
    
    // Trigger Select2 updates
    $('#edit_user_id').trigger('change');
    $('#edit_status_id').trigger('change');
}
</script>