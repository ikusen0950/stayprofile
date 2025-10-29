<?php
// Date restrictions for transfer requests
$today = date('Y-m-d');
$minAdvanceDays = 3; // Must be at least 3 days in advance
$minAllowedDate = date('Y-m-d', strtotime("+{$minAdvanceDays} days"));
$minDate = isset($canCreatePastDate) && $canCreatePastDate ? '1900-01-01' : $minAllowedDate;
?>

<div class="modal fade" id="transferModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true"
    data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content d-flex flex-column" style="height: 100%; min-height: 500px;">
            <!--begin::Modal dialog-->
            <div class="modal-content d-flex flex-column" style="height: 100%; min-height: 500px;">
                <!--begin::Modal header-->
                <div class="modal-header" id="transferModal_header">
                    <h2 class="fw-bold">Create Transfer Request</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body px-5 my-7 flex-grow-1 overflow-auto" style="padding-bottom: 0 !important;">
                    <form id="transferModal_form" class="form" action="#">
                        <div class="px-5 px-lg-10">
                            <!--begin::Section-->
                            <h4 class="fw-bold text-gray-800">User Informations</h4>
                            <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">User Type</label>
                                    <select name="transfer_user_type" id="transfer_user_type_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select user type" data-dropdown-parent="#transferModal" data-allow-clear="false" required>
                                        <option value="">Select User Type</option>
                                        <option value="1" selected>Islander</option>
                                        <option value="2">Visitor</option>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="transfer_user_type" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Transfer Type</label>
                                    <select name="transfer_type" id="transfer_transfer_type_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select transfer type" data-dropdown-parent="#transferModal" data-allow-clear="false" required>
                                        <option value="return">Return</option>
                                        <option value="one_way">One Way</option>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="transfer_type" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-7">
                                <!-- Islander Dropdown - Show when user type = 1 -->
                                <div id="transfer_islander_dropdown_section" style="display: block;">
                                    <label class="required fw-semibold fs-6 mb-2">Islander</label>
                                    <select name="transfer_islander_id" id="transfer_islander_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Islander" data-dropdown-parent="#transferModal" required>
                                        <option value="">Select Islander</option>
                                        <?php if (!empty($islanders)): ?>
                                        <?php foreach ($islanders as $islander): ?>
                                        <option value="<?= esc($islander['id']) ?>">
                                           <?= esc($islander['islander_no']) ?> - <?= esc($islander['name']) ?></option>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <option value="" disabled>No islanders found</option>
                                        <?php endif; ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="islander_selection" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                    
                                   
                                </div>
                                
                                <!-- Visitor Dropdown - Show when user type = 2 -->
                                <div id="transfer_visitor_dropdown_section" style="display: none;">
                                    <label class="required fw-semibold fs-6 mb-2">Visitor</label>
                                    <select name="transfer_visitor_id" id="transfer_visitor_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Visitor" data-dropdown-parent="#transferModal">
                                        <option value="">Select Visitor</option>
                                        <?php if (!empty($visitors)): ?>
                                        <?php foreach ($visitors as $visitor): ?>
                                        <option value="<?= esc($visitor['id']) ?>">
                                            <?= esc($visitor['display_name']) ?></option>
                                        <?php endforeach; ?>
                                        <?php else: ?>
                                        <option value="" disabled>No visitors found</option>
                                        <?php endif; ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="visitor_selection" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>


                            </div>
                            <!--end::Input group-->

                             <!-- Leave Reason Dropdown - Show below Islander -->
                                    <div class="mb-7">
                                        <label class="required fw-semibold fs-6 mb-2">Leave Reason</label>
                                        <select name="transfer_leave_reason_id" id="transfer_leave_reason_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Leave Reason" data-dropdown-parent="#transferModal" required>
                                            <option value="">Select Leave Reason</option>
                                            <?php if (!empty($transfer_leave_reasons)): ?>
                                            <?php foreach ($transfer_leave_reasons as $leave_reason): ?>
                                            <option value="<?= esc($leave_reason['id']) ?>">
                                                <?= esc($leave_reason['name']) ?></option>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <option value="" disabled>No leave reasons found</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_leave_reason_id" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>

                            <!--begin::Departure Section-->
                            <div id="transfer_departure_section">
                                <h4 class="fw-bold text-gray-800">Departure Informations</h4>
                                <div class="separator separator-dashed mt-2 mb-7"></div>

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="required fw-semibold fs-6 mb-2">Route</label>
                                        <select name="transfer_departure_route" id="transfer_departure_route" class="form-select form-select-solid" data-control="select2"
                                            data-placeholder="Select departure route"
                                            data-dropdown-parent="#transferModal" required>
                                            <option value="">Select Departure Route</option>
                                            <?php if (!empty($departure_routes)): ?>
                                            <?php foreach ($departure_routes as $route): ?>
                                            <option value="<?= esc($route['id']) ?>">
                                                <?= esc($route['name']) ?></option>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <option value="" disabled>No departure routes found</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_departure_route" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="required fw-semibold fs-6 mb-2">Date</label>
                                        <input type="date" name="transfer_departure_date" id="transfer_departure_date"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter departure date"
                                            value="" required 
                                            min="<?= $minDate ?>"
                                            data-min-advance-date="<?= $minAllowedDate ?>"
                                            data-can-create-past="<?= isset($canCreatePastDate) && $canCreatePastDate ? 'true' : 'false' ?>" />
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_departure_date" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Departure Section-->

                            <!--begin::Arrival Section-->
                            <div id="transfer_arrival_section">
                                <h4 class="fw-bold text-gray-800">Arrival Informations</h4>
                                <div class="separator separator-dashed mt-2 mb-7"></div>

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="required fw-semibold fs-6 mb-2">Route</label>
                                        <select name="transfer_arrival_route" id="transfer_arrival_route" class="form-select form-select-solid" data-control="select2"
                                            data-placeholder="Select arrival route"
                                            data-dropdown-parent="#transferModal" required>
                                            <option value="">Select Arrival Route</option>
                                            <?php if (!empty($arrival_routes)): ?>
                                            <?php foreach ($arrival_routes as $route): ?>
                                            <option value="<?= esc($route['id']) ?>">
                                                <?= esc($route['name']) ?></option>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <option value="" disabled>No arrival routes found</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_arrival_route" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="required fw-semibold fs-6 mb-2">Date</label>
                                        <input type="date" name="transfer_arrival_date" id="transfer_arrival_date"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter arrival date"
                                            value="" required />
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_arrival_date" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Arrival Section-->

                            <!--begin::Transfer Information Section-->
                            <div id="transfer_information_section">
                                <h4 class="fw-bold text-gray-800">Transfer Information</h4>
                                <div class="separator separator-dashed mt-2 mb-7"></div>

                                <!--begin::Input group-->
                                <div class="row mb-7">
                                    <div class="col-md-6">
                                        <label class="required fw-semibold fs-6 mb-2">Route</label>
                                        <select name="transfer_route" id="transfer_route" class="form-select form-select-solid" data-control="select2"
                                            data-placeholder="Select transfer route"
                                            data-dropdown-parent="#transferModal" required>
                                            <option value="">Select Transfer Route</option>
                                            <?php if (!empty($transfer_routes)): ?>
                                            <?php foreach ($transfer_routes as $route): ?>
                                            <option value="<?= esc($route['id']) ?>">
                                                <?= esc($route['name']) ?> (<?= esc($route['type']) ?>)</option>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <option value="" disabled>No transfer routes found</option>
                                            <?php endif; ?>
                                        </select>
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_route" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="required fw-semibold fs-6 mb-2">Date</label>
                                        <input type="date" name="transfer_date" id="transfer_date"
                                            class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter transfer date"
                                            value="" required 
                                            min="<?= $minDate ?>"
                                            data-min-advance-date="<?= $minAllowedDate ?>"
                                            data-can-create-past="<?= isset($canCreatePastDate) && $canCreatePastDate ? 'true' : 'false' ?>" />
                                        <div class="fv-plugins-message-container invalid-feedback">
                                            <div class="fv-help-block" data-field="transfer_date" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Transfer Information Section-->

                            <!--begin::Luggage Assistance Section-->
                            <div class="mb-7">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="transfer_luggage_assistance" id="transfer_luggage_assistance" value="1" />
                                    <label class="form-check-label fw-semibold fs-6" for="transfer_luggage_assistance">
                                        Request luggage assistance!
                                    </label>
                                </div>
                                
                                <!-- Luggage assistance message (hidden by default) -->
                                <div id="transfer_luggage_message" class="alert alert-info mt-3" style="display: none;">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-information-5 fs-2x text-info me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div>
                                            <div class="fw-bold text-dark mb-1">HR team will assist in collecting your luggage from your accommodation block and deliver it to the arrival jetty.</div>
                                            <div class="text-muted"><strong>Collection times:</strong> 10:00 – 12:00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Luggage Assistance Section-->

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fw-semibold fs-6 mb-2">Remarks</label>
                                    <textarea name="transfer_remarks" id="transfer_remarks" class="form-control form-control-solid" rows="3"
                                        placeholder="Enter remarks or additional notes"></textarea>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                    </form>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center" style="background: #fff; z-index: 2;">
                    <button type="reset" id="transferModal_cancel" class="btn btn-light me-3"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="transferModal_submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                </div>
                <!--end::Modal footer-->
            </div>
        </div>
    </div>
</div>
<!--end::Scroll-->

<style>
/* Validation error styling */
.is-invalid {
    border-color: #f1416c !important;
    box-shadow: 0 0 0 0.1rem rgba(241, 65, 108, 0.25) !important;
}

.fv-help-block {
    display: none;
    color: #f1416c;
    font-size: 0.875rem;
    margin-top: 0.25rem;
    font-weight: 500;
}

.fv-help-block:not(:empty) {
    display: block;
}

/* Select2 error styling */
.select2-container--default .select2-selection--single.is-invalid {
    border-color: #f1416c !important;
}

.select2-container--default .select2-selection--single.is-invalid:focus {
    border-color: #f1416c !important;
    box-shadow: 0 0 0 0.1rem rgba(241, 65, 108, 0.25) !important;
}

/* Custom SweetAlert2 styling for existing request popup */
.swal2-popup-large {
    width: 650px !important;
    max-width: 90vw !important;
}

.swal2-popup-large .swal2-html-container {
    text-align: left !important;
    font-size: 14px !important;
}

.swal2-popup-large .badge {
    font-size: 12px !important;
    padding: 4px 8px !important;
}

.swal2-popup-large .alert {
    border-radius: 0.475rem !important;
    border: 0 !important;
}

.swal2-popup-large .separator {
    border-bottom: 1px solid #e4e6ea !important;
}

.swal2-popup-large .d-flex {
    display: flex !important;
}

.swal2-popup-large .align-items-center {
    align-items: center !important;
}

.swal2-popup-large .gap-3 {
    gap: 1rem !important;
}

.swal2-popup-large .flex-column {
    flex-direction: column !important;
}
</style>

<script>
// Make transfer route data available to JavaScript
const transferRouteData = <?= json_encode($transfer_routes ?? []) ?>;

// Dynamic dropdown switching for Islander/Visitor in Transfer Modal
document.addEventListener('DOMContentLoaded', function() {
    var userTypeSelect = document.getElementById('transfer_user_type_select');
    var transferTypeSelect = document.getElementById('transfer_transfer_type_select');
    var islanderSection = document.getElementById('transfer_islander_dropdown_section');
    var visitorSection = document.getElementById('transfer_visitor_dropdown_section');
    var islanderSelect = document.getElementById('transfer_islander_select');
    var visitorSelect = document.getElementById('transfer_visitor_select');
    var leaveReasonSelect = document.getElementById('transfer_leave_reason_select');
    
    // Get section elements for transfer type switching
    var departureInfoSection = document.getElementById('transfer_departure_section');
    var arrivalInfoSection = document.getElementById('transfer_arrival_section');
    var transferInformationSection = document.getElementById('transfer_information_section');
    
    // Get the route and date inputs for validation
    var departureRoute = document.getElementById('transfer_departure_route');
    var departureDate = document.getElementById('transfer_departure_date');
    var arrivalRoute = document.getElementById('transfer_arrival_route');
    var arrivalDate = document.getElementById('transfer_arrival_date');
    var transferRoute = document.getElementById('transfer_route');
    var transferDate = document.getElementById('transfer_date');
    
    function updateDropdownVisibility() {
        var selectedType = userTypeSelect.value;
        console.log('Transfer Modal - Switching to user type:', selectedType);
        console.log('Transfer Modal - Current sections before change:', {
            islanderDisplay: islanderSection.style.display,
            visitorDisplay: visitorSection.style.display
        });
        
        if (selectedType === '1') {
            // Show Islander dropdown, hide Visitor dropdown
            islanderSection.style.display = 'block';
            visitorSection.style.display = 'none';
            
            // Set required attribute
            islanderSelect.setAttribute('required', 'required');
            visitorSelect.removeAttribute('required');
            // Leave Reason is now always required since it's outside the Islander section
            
            // Clear visitor selection
            if (window.jQuery && $(visitorSelect).data('select2')) {
                $(visitorSelect).val(null).trigger('change');
            } else {
                visitorSelect.value = '';
            }
            
            // Auto-select islander if only one option available
            var islanderOptions = Array.from(islanderSelect.querySelectorAll('option')).filter(option => option.value && option.value !== "");
            if (islanderOptions.length === 1) {
                var autoSelectValue = islanderOptions[0].value;
                if (window.jQuery && $(islanderSelect).data('select2')) {
                    $(islanderSelect).val(autoSelectValue).trigger('change');
                } else {
                    islanderSelect.value = autoSelectValue;
                }
                console.log('Transfer Modal - Auto-selected islander:', autoSelectValue);
            }
            
        } else if (selectedType === '2') {
            // Show Visitor dropdown, hide Islander dropdown
            islanderSection.style.display = 'none';
            visitorSection.style.display = 'block';
            
            // Set required attribute
            visitorSelect.setAttribute('required', 'required');
            islanderSelect.removeAttribute('required');
            // Leave Reason is now always required since it's outside the user type sections
            
            // Clear islander selection
            if (window.jQuery && $(islanderSelect).data('select2')) {
                $(islanderSelect).val(null).trigger('change');
            } else {
                islanderSelect.value = '';
            }
            
            // Don't clear leave reason selection when switching to visitor since it's now separate
            
        } else {
            // Default to Islander (no selection)
            islanderSection.style.display = 'block';
            visitorSection.style.display = 'none';
            
            islanderSelect.setAttribute('required', 'required');
            visitorSelect.removeAttribute('required');
            // Leave Reason is now always required since it's outside the Islander section
        }
        
        console.log('Transfer Modal - Updated sections:', {
            islanderDisplay: islanderSection.style.display,
            visitorDisplay: visitorSection.style.display
        });
    }
    
    function updateTransferTypeSections() {
        var selectedTransferType = transferTypeSelect.value;
        console.log('Transfer Modal - Switching to transfer type:', selectedTransferType);
        
        if (selectedTransferType === 'return') {
            // Show Departure and Arrival sections, hide Transfer Information
            if (departureInfoSection) {
                departureInfoSection.style.display = 'block';
                // Enable required validation for departure fields
                if (departureRoute) departureRoute.setAttribute('required', 'required');
                if (departureDate) departureDate.setAttribute('required', 'required');
            }
            
            if (arrivalInfoSection) {
                arrivalInfoSection.style.display = 'block';
                // Enable required validation for arrival fields
                if (arrivalRoute) arrivalRoute.setAttribute('required', 'required');
                if (arrivalDate) arrivalDate.setAttribute('required', 'required');
            }
            
            if (transferInformationSection) {
                transferInformationSection.style.display = 'none';
                // Remove required validation for transfer fields
                if (transferRoute) {
                    transferRoute.removeAttribute('required');
                    // Clear transfer route selection
                    if (window.jQuery && $(transferRoute).data('select2')) {
                        $(transferRoute).val(null).trigger('change');
                    } else {
                        transferRoute.value = '';
                    }
                }
                if (transferDate) {
                    transferDate.removeAttribute('required');
                    transferDate.value = '';
                }
            }
            
            console.log('Transfer Modal - Return mode: Showing Departure & Arrival, hiding Transfer Information');
            
        } else if (selectedTransferType === 'one_way') {
            // Show Transfer Information, hide Departure and Arrival sections
            if (departureInfoSection) {
                departureInfoSection.style.display = 'none';
                // Remove required validation for departure fields
                if (departureRoute) {
                    departureRoute.removeAttribute('required');
                    // Clear departure route selection
                    if (window.jQuery && $(departureRoute).data('select2')) {
                        $(departureRoute).val(null).trigger('change');
                    } else {
                        departureRoute.value = '';
                    }
                }
                if (departureDate) {
                    departureDate.removeAttribute('required');
                    departureDate.value = '';
                }
            }
            
            if (arrivalInfoSection) {
                arrivalInfoSection.style.display = 'none';
                // Remove required validation for arrival fields
                if (arrivalRoute) {
                    arrivalRoute.removeAttribute('required');
                    // Clear arrival route selection
                    if (window.jQuery && $(arrivalRoute).data('select2')) {
                        $(arrivalRoute).val(null).trigger('change');
                    } else {
                        arrivalRoute.value = '';
                    }
                }
                if (arrivalDate) {
                    arrivalDate.removeAttribute('required');
                    arrivalDate.value = '';
                }
            }
            
            if (transferInformationSection) {
                transferInformationSection.style.display = 'block';
                // Enable required validation for transfer fields
                if (transferRoute) transferRoute.setAttribute('required', 'required');
                if (transferDate) transferDate.setAttribute('required', 'required');
            }
            
            console.log('Transfer Modal - One Way mode: Showing Transfer Information, hiding Departure & Arrival');
            
        } else {
            // Default case - show all sections
            if (departureInfoSection) departureInfoSection.style.display = 'block';
            if (arrivalInfoSection) arrivalInfoSection.style.display = 'block';
            if (transferInformationSection) transferInformationSection.style.display = 'block';
            
            // Set all fields as required by default
            if (departureRoute) departureRoute.setAttribute('required', 'required');
            if (departureDate) departureDate.setAttribute('required', 'required');
            if (arrivalRoute) arrivalRoute.setAttribute('required', 'required');
            if (arrivalDate) arrivalDate.setAttribute('required', 'required');
            if (transferRoute) transferRoute.setAttribute('required', 'required');
            if (transferDate) transferDate.setAttribute('required', 'required');
        }
    }
    
    if (userTypeSelect && islanderSection && visitorSection) {
        // Initialize Select2 for all dropdowns
        if (window.jQuery) {
            // Global Select2 configuration to prevent auto-focus on search
            $.fn.select2.defaults.set('dropdownAutoWidth', true);
            $.fn.select2.defaults.set('selectOnClose', false);
            
            // Initialize User Type Select2 with change event
            $(userTypeSelect).select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select User Type',
                allowClear: false,
                minimumResultsForSearch: Infinity // Disable search for user type
            });
            
            // Use Select2 change event specifically
            $(userTypeSelect).on('select2:select', function(e) {
                console.log('Transfer Modal - Select2 change event triggered');
                setTimeout(updateDropdownVisibility, 50);
            });
            
            // Initialize Transfer Type Select2
            $('#transfer_transfer_type_select').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select Transfer Type',
                allowClear: false,
                minimumResultsForSearch: Infinity // Disable search for transfer type
            });
            
            // Add Transfer Type change event
            $('#transfer_transfer_type_select').on('select2:select', function(e) {
                console.log('Transfer Modal - Transfer Type Select2 change event triggered');
                setTimeout(updateTransferTypeSections, 50);
            });
            
            $(islanderSelect).select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select Islander',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });
            
            $(visitorSelect).select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select Visitor',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Initialize Leave Reason Select2
            if (leaveReasonSelect) {
                $(leaveReasonSelect).select2({
                    dropdownParent: $('#transferModal'),
                    placeholder: 'Select Leave Reason',
                    allowClear: true,
                    dropdownAutoWidth: true,
                    selectOnClose: false
                });
            }

            // Initialize Route Select2 dropdowns
            $('#transfer_departure_route').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select departure route',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            $('#transfer_arrival_route').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select arrival route',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            $('#transfer_route').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select transfer route',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Global event handler to prevent auto-focus on Select2 search inputs
            $('#transferModal').on('select2:open', function() {
                setTimeout(function() {
                    // Remove focus from any search input that gets auto-focused
                    $('.select2-search__field').blur();
                }, 1);
            });
        }
        
        // Also add native change events as backup
        userTypeSelect.addEventListener('change', function() {
            console.log('Transfer Modal - Native change event triggered');
            updateDropdownVisibility();
        });
        
        transferTypeSelect.addEventListener('change', function() {
            console.log('Transfer Modal - Native transfer type change event triggered');
            updateTransferTypeSections();
        });
        
        // Initial setup - default to Islander
        setTimeout(function() {
            updateDropdownVisibility();
            updateTransferTypeSections();
        }, 300);
        
        // Also update when modal is shown
        $('#transferModal').on('shown.bs.modal', function () {
            setTimeout(function() {
                updateDropdownVisibility();
                updateTransferTypeSections();
            }, 500);
        });
    }

    // Transfer Modal Form Validation
    const transferForm = document.getElementById('transferModal_form');
    const transferSubmitBtn = document.getElementById('transferModal_submit');
    const transferModal = document.getElementById('transferModal');

    // Validation functions
    function showTransferValidationError(fieldName, message) {
        const errorElement = document.querySelector(`[data-field="${fieldName}"]`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        // Add error styling to the input
        let inputElement = document.querySelector(`[name="${fieldName}"]`);
        if (!inputElement && fieldName === 'transfer_user_type') {
            inputElement = document.querySelector('#transfer_user_type_select');
        }
        if (!inputElement && fieldName === 'transfer_type') {
            inputElement = document.querySelector('#transfer_transfer_type_select');
        }
        if (!inputElement && fieldName === 'islander_selection') {
            inputElement = document.querySelector('#transfer_islander_select');
        }
        if (!inputElement && fieldName === 'visitor_selection') {
            inputElement = document.querySelector('#transfer_visitor_select');
        }
        
        if (inputElement) {
            inputElement.classList.add('is-invalid');
            // For Select2 elements, also add class to the rendered element
            const select2Element = inputElement.nextElementSibling;
            if (select2Element && select2Element.classList.contains('select2-container')) {
                select2Element.querySelector('.select2-selection').classList.add('is-invalid');
            }
        }
    }

    function hideTransferValidationError(fieldName) {
        const errorElement = document.querySelector(`[data-field="${fieldName}"]`);
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
        
        // Remove error styling from the input
        let inputElement = document.querySelector(`[name="${fieldName}"]`);
        if (!inputElement && fieldName === 'transfer_user_type') {
            inputElement = document.querySelector('#transfer_user_type_select');
        }
        if (!inputElement && fieldName === 'transfer_type') {
            inputElement = document.querySelector('#transfer_transfer_type_select');
        }
        if (!inputElement && fieldName === 'islander_selection') {
            inputElement = document.querySelector('#transfer_islander_select');
        }
        if (!inputElement && fieldName === 'visitor_selection') {
            inputElement = document.querySelector('#transfer_visitor_select');
        }
        
        if (inputElement) {
            inputElement.classList.remove('is-invalid');
            // For Select2 elements, also remove class from the rendered element
            const select2Element = inputElement.nextElementSibling;
            if (select2Element && select2Element.classList.contains('select2-container')) {
                select2Element.querySelector('.select2-selection').classList.remove('is-invalid');
            }
        }
    }

    function clearAllTransferValidationErrors() {
        const errorElements = document.querySelectorAll('[data-field]');
        errorElements.forEach(element => {
            element.textContent = '';
            element.style.display = 'none';
        });
        
        // Remove error styling from all inputs
        const inputElements = document.querySelectorAll('.is-invalid');
        inputElements.forEach(element => {
            element.classList.remove('is-invalid');
        });
    }

    function validateTransferForm() {
        let isValid = true;
        clearAllTransferValidationErrors();

        // 1. Validate User Type (required)
        const userType = document.querySelector('[name="transfer_user_type"]').value;
        if (!userType) {
            showTransferValidationError('transfer_user_type', 'Please select a user type');
            isValid = false;
        } else {
            hideTransferValidationError('transfer_user_type');
        }

        // 2. Validate Transfer Type (required)
        const transferType = document.querySelector('[name="transfer_type"]').value;
        if (!transferType) {
            showTransferValidationError('transfer_type', 'Please select a transfer type');
            isValid = false;
        } else {
            hideTransferValidationError('transfer_type');
        }

        // 3. Validate Islander/Visitor Selection based on User Type
        let selectedUserId = '';
        if (userType === '1') {
            // Islander selected - Islander required, Visitor not required
            selectedUserId = document.querySelector('[name="transfer_islander_id"]').value;
            if (!selectedUserId) {
                showTransferValidationError('islander_selection', 'Please select an Islander');
                isValid = false;
            } else {
                hideTransferValidationError('islander_selection');
            }
            // Clear any visitor validation errors
            hideTransferValidationError('visitor_selection');
        } else if (userType === '2') {
            // Visitor selected - Visitor required, Islander not required
            selectedUserId = document.querySelector('[name="transfer_visitor_id"]').value;
            if (!selectedUserId) {
                showTransferValidationError('visitor_selection', 'Please select a Visitor');
                isValid = false;
            } else {
                hideTransferValidationError('visitor_selection');
            }
            // Clear any islander validation errors
            hideTransferValidationError('islander_selection');
        }

        // 4. Validate Leave Reason (always required now that it's outside Islander section)
        const leaveReason = document.querySelector('[name="transfer_leave_reason_id"]').value;
        if (!leaveReason) {
            showTransferValidationError('transfer_leave_reason_id', 'Please select a leave reason');
            isValid = false;
        } else {
            hideTransferValidationError('transfer_leave_reason_id');
        }

        // 5. Validate sections based on Transfer Type
        if (transferType === 'return') {
            // Return: Departure and Arrival required, Transfer Information not required
            
            // Validate Departure Route
            const departureRoute = document.querySelector('[name="transfer_departure_route"]').value;
            if (!departureRoute) {
                showTransferValidationError('transfer_departure_route', 'Please select departure route');
                isValid = false;
            } else {
                hideTransferValidationError('transfer_departure_route');
            }

            // Validate Departure Date
            const departureDate = document.querySelector('[name="transfer_departure_date"]').value;
            const departureDateInput = document.querySelector('[name="transfer_departure_date"]');
            if (!departureDate) {
                showTransferValidationError('transfer_departure_date', 'Please select departure date');
                isValid = false;
            } else if (!validateTransferDate(departureDateInput, 'transfer_departure_date')) {
                isValid = false; // Date validation error already shown by validateTransferDate
            } else {
                hideTransferValidationError('transfer_departure_date');
            }

            // Validate Arrival Route
            const arrivalRoute = document.querySelector('[name="transfer_arrival_route"]').value;
            if (!arrivalRoute) {
                showTransferValidationError('transfer_arrival_route', 'Please select arrival route');
                isValid = false;
            } else {
                hideTransferValidationError('transfer_arrival_route');
            }

            // Validate Arrival Date
            const arrivalDate = document.querySelector('[name="transfer_arrival_date"]').value;
            if (!arrivalDate) {
                showTransferValidationError('transfer_arrival_date', 'Please select arrival date');
                isValid = false;
            } else {
                // Check if arrival date is not before departure date
                if (departureDate && arrivalDate < departureDate) {
                    showTransferValidationError('transfer_arrival_date', 'Arrival date cannot be before departure date');
                    isValid = false;
                } else {
                    hideTransferValidationError('transfer_arrival_date');
                }
            }

            // Clear Transfer Information validation errors (not required for return)
            hideTransferValidationError('transfer_route');
            hideTransferValidationError('transfer_date');

        } else if (transferType === 'one_way') {
            // One Way: Transfer Information required, Departure and Arrival not required
            
            // Validate Transfer Route
            const transferRoute = document.querySelector('[name="transfer_route"]').value;
            if (!transferRoute) {
                showTransferValidationError('transfer_route', 'Please select transfer route');
                isValid = false;
            } else {
                hideTransferValidationError('transfer_route');
            }

            // Validate Transfer Date
            const transferDate = document.querySelector('[name="transfer_date"]').value;
            const transferDateInput = document.querySelector('[name="transfer_date"]');
            if (!transferDate) {
                showTransferValidationError('transfer_date', 'Please select transfer date');
                isValid = false;
            } else if (!validateTransferDate(transferDateInput, 'transfer_date')) {
                isValid = false; // Date validation error already shown by validateTransferDate
            } else {
                hideTransferValidationError('transfer_date');
            }

            // Clear Departure and Arrival validation errors (not required for one way)
            hideTransferValidationError('transfer_departure_route');
            hideTransferValidationError('transfer_departure_date');
            hideTransferValidationError('transfer_arrival_route');
            hideTransferValidationError('transfer_arrival_date');
        }

        return isValid;
    }

    // Date validation function for transfer dates
    function validateTransferDate(dateInput, fieldName) {
        const selectedDate = dateInput.value;
        const today = new Date().toISOString().split('T')[0]; // Today's date in YYYY-MM-DD format
        const canCreatePast = dateInput.getAttribute('data-can-create-past') === 'true';
        const minAdvanceDate = dateInput.getAttribute('data-min-advance-date');
        
        if (!selectedDate) {
            return true; // Let required validation handle empty dates
        }
        
        // Check if user has permission to create past dates
        if (canCreatePast) {
            // User can create any date (past, present, future)
            hideTransferValidationError(fieldName);
            return true;
        }
        
        // Check if selected date is before the minimum advance date (3 days from today)
        if (selectedDate < minAdvanceDate) {
            const minDate = new Date(minAdvanceDate);
            const formattedMinDate = minDate.toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'short', 
                day: 'numeric' 
            });
            showTransferValidationError(fieldName, `Please select ${formattedMinDate} or later (minimum 3 days in advance).`);
            return false;
        }
        
        // Clear any existing validation errors for this field
        hideTransferValidationError(fieldName);
        return true;
    }

    // Setup date validation listeners
    function setupTransferDateValidation() {
        const departureDate = document.getElementById('transfer_departure_date');
        const transferDate = document.getElementById('transfer_date');
        
        if (departureDate) {
            departureDate.addEventListener('change', function() {
                validateTransferDate(this, 'transfer_departure_date');
            });
            
            // Also validate on input for immediate feedback
            departureDate.addEventListener('input', function() {
                validateTransferDate(this, 'transfer_departure_date');
            });
        }
        
        if (transferDate) {
            transferDate.addEventListener('change', function() {
                validateTransferDate(this, 'transfer_date');
            });
            
            // Also validate on input for immediate feedback
            transferDate.addEventListener('input', function() {
                validateTransferDate(this, 'transfer_date');
            });
        }
    }

    // Add real-time validation clearing for Transfer Modal
    function addTransferRealtimeValidation() {
        // User type validation clearing
        const userTypeSelect = document.querySelector('[name="transfer_user_type"]');
        if (userTypeSelect) {
            userTypeSelect.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_user_type');
                }
            });
        }

        // Transfer type validation clearing
        const transferTypeSelect = document.querySelector('[name="transfer_type"]');
        if (transferTypeSelect) {
            transferTypeSelect.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_type');
                }
            });
        }

        // Islander/Visitor selection validation clearing
        const islanderSelect = document.querySelector('[name="transfer_islander_id"]');
        const visitorSelect = document.querySelector('[name="transfer_visitor_id"]');
        
        if (islanderSelect) {
            islanderSelect.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('islander_selection');
                }
            });
        }
        
        if (visitorSelect) {
            visitorSelect.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('visitor_selection');
                }
            });
        }

        // Leave reason validation clearing
        const leaveReasonSelect = document.querySelector('[name="transfer_leave_reason_id"]');
        if (leaveReasonSelect) {
            leaveReasonSelect.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_leave_reason_id');
                }
            });
        }

        // Route and date validation clearing
        const departureRoute = document.querySelector('[name="transfer_departure_route"]');
        const departureDate = document.querySelector('[name="transfer_departure_date"]');
        const arrivalRoute = document.querySelector('[name="transfer_arrival_route"]');
        const arrivalDate = document.querySelector('[name="transfer_arrival_date"]');
        const transferRoute = document.querySelector('[name="transfer_route"]');
        const transferDate = document.querySelector('[name="transfer_date"]');

        if (departureRoute) {
            departureRoute.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_departure_route');
                }
            });
        }

        if (departureDate) {
            departureDate.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_departure_date');
                }
            });
        }

        if (arrivalRoute) {
            arrivalRoute.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_arrival_route');
                }
            });
        }

        if (arrivalDate) {
            arrivalDate.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_arrival_date');
                }
            });
        }

        if (transferRoute) {
            transferRoute.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_route');
                }
            });
        }

        if (transferDate) {
            transferDate.addEventListener('change', function() {
                if (this.value) {
                    hideTransferValidationError('transfer_date');
                }
            });
        }

        // Dynamic arrival date minimum based on departure date
        if (departureDate && arrivalDate) {
            departureDate.addEventListener('change', function() {
                const departureValue = this.value;
                if (departureValue) {
                    // Set arrival date minimum to departure date (can't arrive before departure)
                    arrivalDate.setAttribute('min', departureValue);
                    
                    // Clear arrival date if it's now before departure date
                    if (arrivalDate.value && arrivalDate.value < departureValue) {
                        arrivalDate.value = '';
                        hideTransferValidationError('transfer_arrival_date');
                    }
                }
            });
        }
    }

    // Initialize real-time validation
    addTransferRealtimeValidation();
    
    // Initialize date validation
    setupTransferDateValidation();

    // Setup luggage assistance functionality
    function setupLuggageAssistance() {
        const luggageCheckbox = document.getElementById('transfer_luggage_assistance');
        const luggageMessage = document.getElementById('transfer_luggage_message');
        
        if (luggageCheckbox && luggageMessage) {
            luggageCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    luggageMessage.style.display = 'block';
                } else {
                    luggageMessage.style.display = 'none';
                }
            });
        }
    }
    
    // Initialize luggage assistance
    setupLuggageAssistance();

    // Form submission handler
    if (transferSubmitBtn && transferForm) {
        transferSubmitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear previous validation errors and validate form
            if (!validateTransferForm()) {
                // Scroll to first error
                const firstError = document.querySelector('[data-field]:not(:empty)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Get form data for validation
            const formData = new FormData(transferForm);
            
            // Determine which user was selected (islander or visitor)
            var selectedUserId = '';
            var userType = formData.get('transfer_user_type');
            
            if (userType === '1') {
                // Islander selected
                selectedUserId = formData.get('transfer_islander_id');
                
                // Check monthly transfer quota for islanders only
                checkTransferQuota(selectedUserId, function(quotaExceeded, quotaInfo) {
                    if (quotaExceeded) {
                        // Show quota warning popup
                        showQuotaWarning(quotaInfo, function() {
                            // User confirmed, proceed with submission (quota exceeded)
                            proceedWithTransferSubmission(true);
                        });
                    } else {
                        // No quota issues, proceed with submission (within quota)
                        proceedWithTransferSubmission(false);
                    }
                });
                
            } else if (userType === '2') {
                // Visitor selected - no quota check needed (not applicable)
                proceedWithTransferSubmission(false);
            } else {
                // Invalid user type
                transferSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                transferSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                transferSubmitBtn.disabled = false;
                return;
            }
        });
        
        // Function to check transfer quota via AJAX
        function checkTransferQuota(userId, callback) {
            if (!userId) {
                console.log('Transfer Quota Check: No user ID provided');
                callback(false, null);
                return;
            }
            
            console.log('Transfer Quota Check: Checking quota for user ID:', userId);
            
            fetch('/requests/checkTransferQuota', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: 'user_id=' + encodeURIComponent(userId)
            })
            .then(response => {
                console.log('Transfer Quota Check: Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Transfer Quota Check: Response data:', data);
                if (data.success) {
                    console.log('Transfer Quota Check: Quota exceeded?', data.quota_exceeded);
                    console.log('Transfer Quota Check: Quota info:', data.quota_info);
                    callback(data.quota_exceeded, data.quota_info);
                } else {
                    console.error('Quota check failed:', data.message);
                    callback(false, null);
                }
            })
            .catch(error => {
                console.error('Quota check error:', error);
                callback(false, null);
            });
        }
        
        // Function to show quota warning popup
        function showQuotaWarning(quotaInfo, onConfirm) {
            const quotaMessage = quotaInfo.message || 'You have already used your free transfer quota for this month.';
            
            Swal.fire({
                title: 'Transfer Quota Warning',
                html: `
                    <div class="alert alert-warning" style="text-align: left; margin: 0;">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        <strong>Monthly Transfer Quota Exceeded</strong><br><br>
                        ${quotaMessage}
                        <br><br>
                       
                        <strong>Do you want to proceed with this chargeable transfer?</strong>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Create Chargeable Transfer',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ee385d',
                cancelButtonColor: '#6c757d',
                customClass: {
                    popup: 'swal2-popup-large'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    onConfirm();
                } else {
                    // User cancelled, reset loading state
                    transferSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                    transferSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                    transferSubmitBtn.disabled = false;
                }
            });
        }
        
        // Function to proceed with transfer submission
        function proceedWithTransferSubmission(isQuotaExceeded = false) {
            // Show loading state
            transferSubmitBtn.querySelector('.indicator-label').style.display = 'none';
            transferSubmitBtn.querySelector('.indicator-progress').style.display = 'inline-block';
            transferSubmitBtn.disabled = true;

            // Get form data
            const formData = new FormData(transferForm);
            
            // Add quota exceeded flag for server-side processing
            formData.set('quota_exceeded_confirmed', isQuotaExceeded ? '1' : '0');
            
            console.log('Transfer Submission: Quota exceeded confirmed?', isQuotaExceeded);
            
            // Determine which user was selected (islander or visitor)
            var selectedUserId = '';
            var userType = formData.get('transfer_user_type');
            
            if (userType === '1') {
                // Islander selected
                selectedUserId = formData.get('transfer_islander_id');
            } else if (userType === '2') {
                // Visitor selected  
                selectedUserId = formData.get('transfer_visitor_id');
            }
            
            // Handle one-way transfer route type logic
            var transferType = formData.get('transfer_type');
            if (transferType === 'one_way') {
                var transferRouteId = formData.get('transfer_route');
                var transferDate = formData.get('transfer_date');
                
                if (transferRouteId && transferRouteData) {
                    // Find the route data for the selected route ID
                    var selectedRoute = transferRouteData.find(route => route.id == transferRouteId);
                    
                    if (selectedRoute) {
                        var routeType = selectedRoute.type;
                        
                        // Check if it's a departure or arrival route based on the actual type field
                        if (routeType === 'Departure') {
                            // It's a departure route - save to departure fields
                            formData.set('transfer_departure_route_id', transferRouteId);
                            formData.set('transfer_departure_date', transferDate);
                            formData.set('transfer_route_type', 'Departure');
                            
                            // Clear transfer route and arrival fields
                            formData.delete('transfer_route');
                            formData.delete('transfer_date');
                            formData.delete('transfer_arrival_route');
                            formData.delete('transfer_arrival_date');
                            
                        } else if (routeType === 'Arrival') {
                            // It's an arrival route - save to arrival fields
                            formData.set('transfer_arrival_route_id', transferRouteId);
                            formData.set('transfer_arrival_date', transferDate);
                            formData.set('transfer_route_type', 'Arrival');
                            
                            // Clear transfer route and departure fields
                            formData.delete('transfer_route');
                            formData.delete('transfer_date');
                            formData.delete('transfer_departure_route');
                            formData.delete('transfer_departure_date');
                        }
                    }
                }
            } else if (transferType === 'return') {
                // For return transfers, handle departure and arrival route fields properly
                var departureRouteId = formData.get('transfer_departure_route');
                var departureDate = formData.get('transfer_departure_date');
                var arrivalRouteId = formData.get('transfer_arrival_route');
                var arrivalDate = formData.get('transfer_arrival_date');
                
                // Map the route fields to the correct database fields
                if (departureRouteId) {
                    formData.set('transfer_departure_route_id', departureRouteId);
                }
                if (arrivalRouteId) {
                    formData.set('transfer_arrival_route_id', arrivalRouteId);
                }
                
                // Set the route type as 'Return'
                formData.set('transfer_route_type', 'Return');
                
                // Clear transfer route fields (not used for return)
                formData.delete('transfer_route');
                formData.delete('transfer_date');
            }
            
            // Map form fields to request structure
            formData.set('user_id', selectedUserId); // Use selected islander/visitor as user_id
            formData.set('leave_id', formData.get('transfer_leave_reason_id')); // Use leave reason as leave_id
            formData.set('type', '2'); // Transfer type (1 = Exit Pass, 2 = Transfer)
            formData.set('type_description', 'Transfer');
            formData.set('type_color', '#ee385d');
            formData.set('user_type', userType); // Pass user type for status determination
            
            // Handle luggage assistance
            var luggageAssistance = formData.get('transfer_luggage_assistance');
            formData.set('luggage_assistance', luggageAssistance ? '1' : '0');

            // Submit the form
            secureFetch('/requests/store', {
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
                // Reset loading state
                transferSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                transferSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                transferSubmitBtn.disabled = false;

                if (data.success) {
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(transferModal);
                    modal.hide();
                    
                    // Show success message
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        // Redirect to requests list
                        window.location.href = '/requests';
                    });
                    
                    // Reset form
                    transferForm.reset();
                } else {
                    if (data.errors) {
                        // Show validation errors
                        let errorMessage = '';
                        Object.values(data.errors).forEach(function(msg) {
                            errorMessage += msg + '<br>';
                        });
                        Swal.fire('Validation Error', errorMessage, 'error');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                // Reset loading state
                transferSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                transferSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                transferSubmitBtn.disabled = false;
                
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to submit transfer request', 'error');
            });
        }
    }
});
</script>