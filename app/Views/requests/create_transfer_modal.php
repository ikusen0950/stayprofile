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
                            <h4 class="fw-bold text-gray-800">User Information</h4>
                            <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--begin::Input group - User Type Selection-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">User Type</label>
                                    <select name="user_type" id="transfer_user_type_select"
                                        class="form-select form-select-solid" data-placeholder="Select User Type">
                                        <option value="1">Islander</option>
                                        <option value="2">Visitor</option>
                                    </select>
                                    <div class="fv-help-block" data-field="user_type"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Transfer Type</label>
                                    <select name="transfer_type" class="form-select form-select-solid"
                                        data-placeholder="Select transfer type">
                                        <option value="return">Return</option>
                                        <option value="one_way">One Way</option>
                                    </select>
                                    <div class="fv-help-block" data-field="transfer_type"></div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Islander Selection-->
                            <div class="mb-7" id="transfer_islander_dropdown_section" style="display: none;">
                                <label class="required fs-6 fw-semibold mb-2">Select Islander</label>
                                <select name="islander_id" id="transfer_islander_select"
                                    class="form-select form-select-solid" data-placeholder="Choose Islander">
                                    <option value="">Select Islander</option>
                                    <?php if (isset($islanders) && !empty($islanders)): ?>
                                    <?php foreach ($islanders as $islander): ?>
                                    <option value="<?= esc($islander['id'] ?? '') ?>">
                                        <?= esc($islander['islander_no'] ?? '') ?> - <?= esc($islander['name'] ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-help-block" data-field="user_selection"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Visitor Selection-->
                            <div class="mb-7" id="transfer_visitor_dropdown_section" style="display: none;">
                                <label class="required fs-6 fw-semibold mb-2">Select Visitor</label>
                                <select name="visitor_id" id="transfer_visitor_select"
                                    class="form-select form-select-solid" data-placeholder="Choose Visitor">
                                    <option value="">Select Visitor</option>
                                    <?php if (isset($visitors) && !empty($visitors)): ?>
                                    <?php foreach ($visitors as $visitor): ?>
                                    <option value="<?= esc($visitor['id'] ?? '') ?>">
                                        <?= esc($visitor['display_name'] ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-help-block" data-field="user_selection"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Leave Reason-->
                            <div class="mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Leave Reason</label>
                                <select name="leave_reason" class="form-select form-select-solid"
                                    data-placeholder="Select leave reason">
                                    <option value="">Select leave reason</option>
                                    <?php if (isset($leaves) && !empty($leaves)): ?>
                                    <?php foreach ($leaves as $leave): ?>
                                    <option value="<?= esc($leave['id'] ?? '') ?>"><?= esc($leave['name'] ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php elseif (isset($leave_reasons) && !empty($leave_reasons)): ?>
                                    <?php foreach ($leave_reasons as $leave): ?>
                                    <option value="<?= esc($leave['id'] ?? '') ?>"><?= esc($leave['name'] ?? '') ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-help-block" data-field="leave_reason"></div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group - Mode of Transport-->
                            <div class="mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Mode of Transport</label>
                                <select name="mode_of_transport" class="form-select form-select-solid"
                                    data-placeholder="Select mode of transport">
                                    <option value="">Select mode of transport</option>
                                    <option value="Speedboat">Speedboat</option>
                                    <option value="Seaplane">Seaplane</option>
                                </select>
                                <div class="fv-help-block" data-field="mode_of_transport"></div>

                                <!--begin::Transport Mode Information-->
                                <div id="transport_info_container" class="mt-4" style="display: none;">
                                    <!-- Speedboat Information -->
                                    <div id="speedboat_info" class="transport-info" style="display: none;">
                                        <div class="alert alert-info border-0 bg-light-info">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-ship fs-2 text-success me-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                <div class="d-flex flex-column">
                                                    <h5 class="mb-1 text-dark">Speedboat Information</h5>
                                                    <div class="fs-6 text-muted">
                                                        <div class="mb-2">
                                                            <i class="ki-duotone ki-check fs-7 text-success me-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                            </i>
                                                            Higher possibility of securing a seat.
                                                        </div>
                                                        <div>
                                                            <i class="ki-duotone ki-information fs-7 text-primary me-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                            Minimum of 2 islanders must book for the same date for the
                                                            resort to arrange the transfer. Otherwise, the islander must
                                                            bear the cost of the transfer up to Hithaadhoo.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Seaplane Information -->
                                    <div id="seaplane_info" class="transport-info" style="display: none;">
                                        <div class="alert alert-warning border-0 bg-light-warning">
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-airplane fs-2 text-warning me-4">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="d-flex flex-column">
                                                    <h5 class="mb-1 text-dark">Seaplane Information</h5>
                                                    <div class="fs-6 text-muted">
                                                        <div>
                                                            <i class="ki-duotone ki-information fs-7 text-primary me-2">
                                                                <span class="path1"></span>
                                                                <span class="path2"></span>
                                                                <span class="path3"></span>
                                                            </i>
                                                            Subject to flight availability.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Transport Mode Information-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Section - Departure (For Return Transfer)-->
                            <div id="departure_arrival_section" style="display: none;">
                                <!--begin::Section-->
                                <h4 class="fw-bold text-gray-800">Departure Informations</h4>
                                <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--end::Date Information Alert-->
                            <!--begin::Input group - Departure Route & Date-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Departure Route</label>
                                    <select name="transfer_departure_route_id" class="form-select form-select-solid"
                                        data-placeholder="Select departure route">
                                        <option value="">Select departure route</option>

                                        <?php
                                        try {
                                            // Try to use passed variables first, then load directly if needed
                                            $routesToDisplay = [];
                                            
                                            if (isset($departure_routes) && !empty($departure_routes)) {
                                                $routesToDisplay = $departure_routes;
                                            } else {
                                                // Load routes directly from database as fallback
                                                $flightRouteModel = new \App\Models\FlightRouteModel();
                                                $routesToDisplay = $flightRouteModel->getActiveRoutesByType('Departure');
                                            }
                                            
                                            if (!empty($routesToDisplay)) {
                                                foreach ($routesToDisplay as $route) {
                                                    $routeName = esc($route['name'] ?? '');
                                                    $routeType = esc($route['type'] ?? '');
                                                    
                                                    // Build display text with proper formatting
                                                    $displayText = $routeName;
                                                    if (!empty($routeType)) {
                                                        $displayText .= ' ('  . $routeType .  ')';
                                                    }
                                                    
                                                    echo '<option value="' . esc($route['id'] ?? '') . '">';
                                                    echo $displayText;
                                                    echo '</option>';
                                                }
                                            }
                                        } catch (Exception $e) {
                                            // Silent fallback - don't show error to users
                                            log_message('error', 'Failed to load departure routes in modal: ' . $e->getMessage());
                                        }
                                        ?>
                                    </select>
                                    <div class="fv-help-block" data-field="transfer_departure_route_id"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Departure Date</label>
                                    <input type="date" name="transfer_departure_date"
                                        class="form-control form-control-solid" />
                                    <div class="fv-help-block" data-field="transfer_departure_date"></div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Section-->
                            <h4 class="fw-bold text-gray-800">Arrival Informations</h4>
                            <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--begin::Input group - Arrival Route & Date-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Arrival Route</label>
                                    <select name="transfer_arrival_route_id" class="form-select form-select-solid"
                                        data-placeholder="Select arrival route">
                                        <option value="">Select arrival route</option>

                                        <?php
                                        try {
                                            // Try to use passed variables first, then load directly if needed
                                            $routesToDisplay = [];
                                            
                                            if (isset($arrival_routes) && !empty($arrival_routes)) {
                                                $routesToDisplay = $arrival_routes;
                                            } else {
                                                // Load routes directly from database as fallback
                                                $flightRouteModel = new \App\Models\FlightRouteModel();
                                                $routesToDisplay = $flightRouteModel->getActiveRoutesByType('Arrival');
                                            }
                                            
                                            if (!empty($routesToDisplay)) {
                                                foreach ($routesToDisplay as $route) {
                                                    $routeName = esc($route['name'] ?? '');
                                                    $routeType = esc($route['type'] ?? '');
                                                    
                                                    // Build display text with proper formatting
                                                    $displayText = $routeName;
                                                    if (!empty($routeType)) {
                                                        $displayText .= ' (' . $routeType . ')';
                                                    }
                                                    
                                                    echo '<option value="' . esc($route['id'] ?? '') . '">';
                                                    echo $displayText;
                                                    echo '</option>';
                                                }
                                            }
                                        } catch (Exception $e) {
                                            // Silent fallback - don't show error to users
                                            log_message('error', 'Failed to load arrival routes in modal: ' . $e->getMessage());
                                        }
                                        ?>
                                    </select>
                                    <div class="fv-help-block" data-field="transfer_arrival_route_id"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Arrival Date</label>
                                    <input type="date" name="transfer_arrival_date"
                                        class="form-control form-control-solid" />
                                    <div class="fv-help-block" data-field="transfer_arrival_date"></div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            </div>
                            <!--end::Section - Departure/Arrival-->

                            <!--begin::Section - Transfer (For One Way Transfer)-->
                            <div id="transfer_information_section" style="display: none;">
                                <!--begin::Section-->
                                <h4 class="fw-bold text-gray-800">Transfer Informations</h4>
                                <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--end::Date Information Alert-->
                            <!--begin::Input group - Route & Date-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Route</label>
                                    <select name="transfer_route_id" class="form-select form-select-solid"
                                        data-placeholder="Select route">
                                        <option value="">Select route</option>

                                        <?php
                                        try {
                                            // Load all flight routes without type filtering
                                            $flightRouteModel = new \App\Models\FlightRouteModel();
                                            $routesToDisplay = $flightRouteModel->findAll(); // Get all routes
                                            
                                            if (!empty($routesToDisplay)) {
                                                foreach ($routesToDisplay as $route) {
                                                    $routeName = esc($route['name'] ?? '');
                                                    $routeType = esc($route['type'] ?? '');
                                                    
                                                    // Build display text with proper formatting
                                                    $displayText = $routeName;
                                                    if (!empty($routeType)) {
                                                        $displayText .= ' ('  . $routeType .  ')';
                                                    }
                                                    
                                                    echo '<option value="' . esc($route['id'] ?? '') . '">';
                                                    echo $displayText;
                                                    echo '</option>';
                                                }
                                            }
                                        } catch (Exception $e) {
                                            // Silent fallback - don't show error to users
                                            log_message('error', 'Failed to load routes in modal: ' . $e->getMessage());
                                        }
                                        ?>
                                    </select>
                                    <div class="fv-help-block" data-field="transfer_route_id"></div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fs-6 fw-semibold mb-2">Date</label>
                                    <input type="date" name="transfer_date"
                                        class="form-control form-control-solid" />
                                    <div class="fv-help-block" data-field="transfer_date"></div>
                                </div>
                            </div>
                            <!--end::Input group-->
                            </div>
                            <!--end::Section - Transfer Information-->

                            <!--begin::Input group - Remarks-->
                            <div class="mb-7">
                                <label class="fs-6 fw-semibold mb-2">Remarks</label>
                                <textarea name="remarks" class="form-control form-control-solid" rows="3"
                                    placeholder="Additional notes or remarks (optional)"></textarea>
                                <div class="fv-help-block" data-field="remarks"></div>
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
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
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
    min-height: 20px; /* For debugging - ensure element has height */
    border: 1px solid transparent; /* For debugging - add border */
}

.fv-help-block:not(:empty) {
    display: block !important;
    border: 1px solid #f1416c; /* For debugging - visible border when content exists */
}

/* Override FormValidation plugin hiding */
.fv-plugins-message-container.invalid-feedback {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    height: auto !important;
    overflow: visible !important;
}

/* Ensure FormValidation containers don't hide our messages */
.fv-plugins-message-container .fv-help-block[data-field="user_selection"] {
    display: block !important;
    visibility: visible !important;
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

/* Transport Information Styling */
.transport-info {
    transition: all 0.3s ease-in-out;
}

.transport-info .alert {
    border-radius: 0.75rem !important;
    padding: 1.25rem !important;
    margin-bottom: 0 !important;
    box-shadow: 0 0.1rem 0.75rem rgba(0, 0, 0, 0.05) !important;
}

.transport-info .alert-info {
    background-color: rgba(54, 147, 255, 0.1) !important;
    /* border-left: 4px solid #3693ff !important; */
}

.transport-info .alert-warning {
    background-color: rgba(255, 184, 34, 0.1) !important;
    /* border-left: 4px solid #ffb822 !important; */
}

.transport-info h5 {
    font-weight: 600 !important;
    margin-bottom: 0.5rem !important;
}

.transport-info .fs-6 {
    font-size: 0.95rem !important;
    line-height: 1.6 !important;
}

.transport-info .mb-2:last-child {
    margin-bottom: 0 !important;
}

/* Fade in animation */
#transport_info_container {
    animation: fadeInUp 0.3s ease-in-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
// Transfer Modal Dynamic dropdown switching for Islander/Visitor
document.addEventListener('DOMContentLoaded', function() {
    // Set date restrictions based on user permissions
    const canCreatePastDate = <?= json_encode($canCreatePastDate ?? false) ?>;
    const canCreateTransferOnCurrentDate = <?= json_encode($canCreateTransferOnCurrentDate ?? false) ?>;

    // Determine departure date minimum based on permissions
    let departureDateMin;
    if (canCreatePastDate) {
        // Can create requests for any date (including past dates)
        departureDateMin = null; // No minimum restriction
    } else if (canCreateTransferOnCurrentDate) {
        // Can create transfers starting from current date (bypasses 3-day advance requirement)
        const today = new Date();
        departureDateMin = today.toISOString().split('T')[0];
    } else {
        // Regular users must select 3 days in advance
        const today = new Date();
        const threeDaysFromNow = new Date(today);
        threeDaysFromNow.setDate(today.getDate() + 3);
        departureDateMin = threeDaysFromNow.toISOString().split('T')[0];
    }

    // Set date input restrictions
    const departureDateInput = document.querySelector('[name="transfer_departure_date"]');
    const arrivalDateInput = document.querySelector('[name="transfer_arrival_date"]');
    const transferDateInput = document.querySelector('[name="transfer_date"]');

    if (departureDateInput && departureDateMin) {
        departureDateInput.setAttribute('min', departureDateMin);
    }

    // For one-way transfers, apply the same date restrictions as departure date
    if (transferDateInput && departureDateMin) {
        transferDateInput.setAttribute('min', departureDateMin);
    }

    // Arrival date is always at least today (unless user has past date permission)
    if (arrivalDateInput) {
        if (canCreatePastDate) {
            // No minimum restriction for arrival date
        } else {
            const today = new Date().toISOString().split('T')[0];
            arrivalDateInput.setAttribute('min', today);
        }
    }

    var userTypeSelect = document.getElementById('transfer_user_type_select');
    var islanderSection = document.getElementById('transfer_islander_dropdown_section');
    var visitorSection = document.getElementById('transfer_visitor_dropdown_section');
    var islanderSelect = document.getElementById('transfer_islander_select');
    var visitorSelect = document.getElementById('transfer_visitor_select');

    // Debounce function to prevent excessive calls
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function updateTransferDropdownVisibility() {
        var selectedType = userTypeSelect.value;
        console.log('=== UPDATING DROPDOWN VISIBILITY ===');
        console.log('Selected user type:', selectedType);

        // Batch DOM operations to reduce reflow
        requestAnimationFrame(function() {
            if (selectedType === '1') {
                console.log('*** SHOWING ISLANDER SECTION ***');
                // Show Islander dropdown, hide Visitor dropdown
                islanderSection.style.display = 'block';
                visitorSection.style.display = 'none';

                // Set required attribute for Islander, remove for Visitor
                islanderSelect.setAttribute('required', 'required');
                visitorSelect.removeAttribute('required');
                console.log('Islander section: visible, required=true');
                console.log('Visitor section: hidden, required=false');

                // Clear visitor selection
                if (window.jQuery && $(visitorSelect).data('select2')) {
                    $(visitorSelect).val(null).trigger('change');
                } else {
                    visitorSelect.value = '';
                }

                // Auto-select islander if only one option available
                var islanderOptions = Array.from(islanderSelect.querySelectorAll('option')).filter(
                    option => option.value && option.value !== "");
                if (islanderOptions.length === 1) {
                    var autoSelectValue = islanderOptions[0].value;
                    console.log('Auto-selecting single Islander option:', autoSelectValue);
                    if (window.jQuery && $(islanderSelect).data('select2')) {
                        $(islanderSelect).val(autoSelectValue).trigger('change');
                    } else {
                        islanderSelect.value = autoSelectValue;
                    }
                }

            } else if (selectedType === '2') {
                console.log('*** SHOWING VISITOR SECTION ***');
                // Show Visitor dropdown, hide Islander dropdown
                islanderSection.style.display = 'none';
                visitorSection.style.display = 'block';

                // Set required attribute for Visitor, remove for Islander
                visitorSelect.setAttribute('required', 'required');
                islanderSelect.removeAttribute('required');
                console.log('Visitor section: visible, required=true');
                console.log('Islander section: hidden, required=false');

                // Clear islander selection
                if (window.jQuery && $(islanderSelect).data('select2')) {
                    $(islanderSelect).val(null).trigger('change');
                } else {
                    islanderSelect.value = '';
                }

            } else {
                console.log('*** DEFAULT TO ISLANDER SECTION ***');
                // Default to Islander (no selection)
                islanderSection.style.display = 'block';
                visitorSection.style.display = 'none';

                // Default: Islander required, Visitor not required
                islanderSelect.setAttribute('required', 'required');
                visitorSelect.removeAttribute('required');
                console.log('Default: Islander section visible, required=true');
                console.log('Default: Visitor section hidden, required=false');
            }
        });
    }

    // Create debounced version for event handlers
    const debouncedUpdateTransferDropdownVisibility = debounce(updateTransferDropdownVisibility, 150);

    if (userTypeSelect && islanderSection && visitorSection) {
        // Initialize Select2 for all dropdowns
        if (window.jQuery) {
            // Initialize User Type Select2 with change event
            $(userTypeSelect).select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select User Type',
                allowClear: false,
                minimumResultsForSearch: Infinity // Disable search for user type
            });

            // Use Select2 change event specifically
            $(userTypeSelect).on('select2:select', function(e) {
                debouncedUpdateTransferDropdownVisibility();
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
            $('select[name="leave_reason"]').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select leave reason',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Initialize Transfer Type Select2
            $('select[name="transfer_type"]').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select transfer type',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Add transfer type change handler to show/hide sections
            $('select[name="transfer_type"]').on('change', function() {
                const transferType = $(this).val();
                const departureArrivalSection = document.getElementById('departure_arrival_section');
                const transferInformationSection = document.getElementById('transfer_information_section');

                if (transferType === 'return') {
                    // Show Departure/Arrival sections, hide Transfer Information section
                    departureArrivalSection.style.display = 'block';
                    transferInformationSection.style.display = 'none';
                    
                    // Set required attributes for departure/arrival fields
                    document.querySelector('[name="transfer_departure_route_id"]').setAttribute('required', 'required');
                    document.querySelector('[name="transfer_departure_date"]').setAttribute('required', 'required');
                    document.querySelector('[name="transfer_arrival_route_id"]').setAttribute('required', 'required');
                    document.querySelector('[name="transfer_arrival_date"]').setAttribute('required', 'required');
                    
                    // Remove required attributes from transfer information fields
                    document.querySelector('[name="transfer_route_id"]').removeAttribute('required');
                    document.querySelector('[name="transfer_date"]').removeAttribute('required');
                    
                } else if (transferType === 'one_way') {
                    // Show Transfer Information section, hide Departure/Arrival sections
                    departureArrivalSection.style.display = 'none';
                    transferInformationSection.style.display = 'block';
                    
                    // Set required attributes for transfer information fields
                    document.querySelector('[name="transfer_route_id"]').setAttribute('required', 'required');
                    document.querySelector('[name="transfer_date"]').setAttribute('required', 'required');
                    
                    // Remove required attributes from departure/arrival fields
                    document.querySelector('[name="transfer_departure_route_id"]').removeAttribute('required');
                    document.querySelector('[name="transfer_departure_date"]').removeAttribute('required');
                    document.querySelector('[name="transfer_arrival_route_id"]').removeAttribute('required');
                    document.querySelector('[name="transfer_arrival_date"]').removeAttribute('required');
                    
                } else {
                    // No transfer type selected, hide both sections
                    departureArrivalSection.style.display = 'none';
                    transferInformationSection.style.display = 'none';
                    
                    // Remove all required attributes
                    document.querySelector('[name="transfer_departure_route_id"]').removeAttribute('required');
                    document.querySelector('[name="transfer_departure_date"]').removeAttribute('required');
                    document.querySelector('[name="transfer_arrival_route_id"]').removeAttribute('required');
                    document.querySelector('[name="transfer_arrival_date"]').removeAttribute('required');
                    document.querySelector('[name="transfer_route_id"]').removeAttribute('required');
                    document.querySelector('[name="transfer_date"]').removeAttribute('required');
                }
                
                console.log('Transfer type changed to:', transferType);
            });

            // Initialize Mode of Transport Select2
            $('select[name="mode_of_transport"]').select2({
                dropdownParent: $('#transferModal'),
                placeholder: 'Select mode of transport',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Initialize Route Select2 dropdowns - will be initialized when modal is shown

            // Add transport mode information functionality
            $('select[name="mode_of_transport"]').on('change', function() {
                const selectedTransport = $(this).val();
                const infoContainer = document.getElementById('transport_info_container');
                const speedboatInfo = document.getElementById('speedboat_info');
                const seaplaneInfo = document.getElementById('seaplane_info');

                console.log('Transport mode changed to:', selectedTransport);

                // Hide all transport info first
                if (speedboatInfo) speedboatInfo.style.display = 'none';
                if (seaplaneInfo) seaplaneInfo.style.display = 'none';

                if (selectedTransport && infoContainer) {
                    // Show the appropriate info based on selection
                    if (selectedTransport === 'Speedboat' && speedboatInfo) {
                        speedboatInfo.style.display = 'block';
                        infoContainer.style.display = 'block';
                    } else if (selectedTransport === 'Seaplane' && seaplaneInfo) {
                        seaplaneInfo.style.display = 'block';
                        infoContainer.style.display = 'block';
                    } else {
                        infoContainer.style.display = 'none';
                    }
                } else if (infoContainer) {
                    // Hide container if no transport selected
                    infoContainer.style.display = 'none';
                }
            });

            // Global event handler to prevent auto-focus on Select2 search inputs
            $('#transferModal').on('select2:open', function() {
                setTimeout(function() {
                    // Remove focus from any search input that gets auto-focused
                    $('.select2-search__field').blur();
                }, 1);
            });
        }

        // Also add native change event as backup
        userTypeSelect.addEventListener('change', function() {
            debouncedUpdateTransferDropdownVisibility();
        });

        // Initial setup - default to Islander
        setTimeout(function() {
            updateTransferDropdownVisibility();
        }, 300);

        // Also update when modal is shown
        $('#transferModal').on('shown.bs.modal', function() {
            setTimeout(function() {
                updateTransferDropdownVisibility();

                // Initialize Route Select2 dropdowns when modal is shown
                const departureSelect = $('select[name="transfer_departure_route_id"]');
                const arrivalSelect = $('select[name="transfer_arrival_route_id"]');
                const transferRouteSelect = $('select[name="transfer_route_id"]');

                // Destroy existing Select2 if it exists
                if (departureSelect.data('select2')) {
                    departureSelect.select2('destroy');
                }

                departureSelect.select2({
                    dropdownParent: $('#transferModal'),
                    placeholder: 'Select departure route',
                    allowClear: true,
                    dropdownAutoWidth: true,
                    selectOnClose: false
                });

                // Destroy existing Select2 if it exists
                if (arrivalSelect.data('select2')) {
                    arrivalSelect.select2('destroy');
                }

                arrivalSelect.select2({
                    dropdownParent: $('#transferModal'),
                    placeholder: 'Select arrival route',
                    allowClear: true,
                    dropdownAutoWidth: true,
                    selectOnClose: false
                });

                // Destroy existing Select2 if it exists
                if (transferRouteSelect.data('select2')) {
                    transferRouteSelect.select2('destroy');
                }

                transferRouteSelect.select2({
                    dropdownParent: $('#transferModal'),
                    placeholder: 'Select route',
                    allowClear: true,
                    dropdownAutoWidth: true,
                    selectOnClose: false
                });
                
                // Trigger transfer type change to set initial section visibility
                const initialTransferType = $('select[name="transfer_type"]').val();
                if (initialTransferType) {
                    $('select[name="transfer_type"]').trigger('change');
                }
            }, 600);
        });

        // Clear form when modal is hidden
        $('#transferModal').on('hidden.bs.modal', function() {
            // Reset form
            const form = document.getElementById('transferModal_form');
            if (form) {
                form.reset();
            }
            
            // Reset all Select2 dropdowns
            $('#transferModal select').each(function() {
                if ($(this).data('select2')) {
                    $(this).val(null).trigger('change');
                }
            });
        });
    }

    // Transfer Form Submission
    const transferForm = document.getElementById('transferModal_form');
    const transferSubmitBtn = document.getElementById('transferModal_submit');
    const transferModal = document.getElementById('transferModal');

    // Function to check for existing transfer requests
    function checkExistingTransferRequest(userId, userType) {
        if (!userId) return;

        console.log(`Checking existing transfer for ${userType} user ID: ${userId}`);

        secureFetch('/requests/check-existing-transfer', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    user_id: userId
                })
            })
            .then(response => {
                if (response.status === 401 || response.status === 403) {
                    handleSessionExpired();
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data.success && data.has_existing) {
                    const existingRequest = data.existing_request;
                    const createdDate = new Date(existingRequest.created_at).toLocaleDateString();

                    // Show warning popup immediately
                    Swal.fire({
                        title: 'Existing Transfer Request Found',
                        html: `
                        <div class="text-start">
                            <div class="alert alert-warning d-flex align-items-center gap-3 mb-3">
                                <i class="ki-duotone ki-information fs-2x text-warning">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div class="flex-column">
                                    <strong>This user already has a pending transfer request</strong>
                                    <div>Request ID: #${existingRequest.id}</div>
                                </div>
                            </div>
                            <div class="separator separator-dashed mb-3"></div>
                            <div><strong>Status:</strong> <span class="badge badge-warning">${existingRequest.status_name || 'Pending'}</span></div>
                            <div class="mt-2"><strong>Transfer Type:</strong> ${existingRequest.transfer_type || 'N/A'}</div>
                            <div class="mt-2"><strong>Mode of Transport:</strong> ${existingRequest.mode_of_transport || 'N/A'}</div>
                            <div class="mt-2"><strong>Created:</strong> ${createdDate}</div>
                            <div class="separator separator-dashed mt-3 mb-3"></div>
                            <div class="text-muted fs-7">Please wait for the existing request to be processed or contact your manager.</div>
                        </div>
                    `,
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#f1c40f',
                        customClass: {
                            popup: 'swal2-popup-large'
                        }
                    }).then(() => {
                        // Clear the selection after user acknowledges
                        if (userType === 'islander' && islanderSelect) {
                            $(islanderSelect).val(null).trigger('change');
                        } else if (userType === 'visitor' && visitorSelect) {
                            $(visitorSelect).val(null).trigger('change');
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error checking existing transfer request:', error);
            });
    }

        // Islander selection change event for existing request check
        if (window.jQuery && $('#transfer_islander_select').length) {
            $('#transfer_islander_select').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue && selectedValue !== '' && !isNaN(selectedValue)) {
                    checkExistingTransferRequest(selectedValue, 'islander');
                }
            });
        }
        
        // Visitor selection change event for existing request check
        if (window.jQuery && $('#transfer_visitor_select').length) {
            $('#transfer_visitor_select').on('change', function() {
                const selectedValue = $(this).val();
                if (selectedValue && selectedValue !== '' && !isNaN(selectedValue)) {
                    checkExistingTransferRequest(selectedValue, 'visitor');
                }
            });
        }

    if (transferSubmitBtn && transferForm) {
        transferSubmitBtn.addEventListener('click', function(e) {
            e.preventDefault();

            // Add small delay to ensure Select2 values are properly available
            setTimeout(function() {
                // DON'T force Select2 sync - it clears the selection
                // Just proceed with validation
                
                console.log('Starting form validation without forced sync...');
                
                // Clear previous validation errors and validate form
                if (!validateTransferForm()) {
                    console.log('Form validation failed - showing errors');
                    // Scroll to first error
                    const firstError = document.querySelector('[data-field]:not(:empty)');
                    if (firstError) {
                        firstError.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });
                    }
                    return;
                }
                
                console.log('Form validation passed - proceeding with submission');
                
                // Show loading state
                transferSubmitBtn.querySelector('.indicator-label').style.display = 'none';
                transferSubmitBtn.querySelector('.indicator-progress').style.display = 'inline-block';
                transferSubmitBtn.disabled = true;

            // Get form data
            const formData = new FormData(transferForm);

            // Determine which user was selected (islander or visitor)
            var selectedUserId = '';
            var userType = formData.get('user_type');

            if (userType === '1') {
                // Islander selected
                selectedUserId = formData.get('islander_id');
            } else if (userType === '2') {
                // Visitor selected  
                selectedUserId = formData.get('visitor_id');
            }

            // This validation should not be needed anymore since we validate in validateTransferForm()
            if (!selectedUserId) {
                // Reset loading state
                transferSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                transferSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                transferSubmitBtn.disabled = false;

                showTransferValidationError('user_selection',
                    'Please select a user (Islander or Visitor)');
                return;
            }

            // Map form fields to request structure
            formData.set('user_id', selectedUserId); // Use selected islander/visitor as user_id
            formData.set('leave_id', formData.get('leave_reason')); // Use leave reason as leave_id
            formData.set('type', '2'); // Transfer type
            formData.set('type_description', 'Transfer Request');
            formData.set('type_color', '#3d8bfd');
            formData.set('user_type', userType); // Pass user type for status determination

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
                        // Check if it's an existing request error
                        if (data.existing_request) {
                            const existingRequest = data.existing_request;
                            const createdDate = new Date(existingRequest.created_at)
                                .toLocaleDateString();

                            Swal.fire({
                                title: 'Existing Transfer Request Found',
                                html: `
                                <div class="text-start">
                                    <div class="alert alert-warning d-flex align-items-center gap-3 mb-3">
                                        <i class="ki-duotone ki-information fs-2x text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div class="flex-column">
                                            <strong>This user already has a pending transfer request</strong>
                                            <div>Request ID: #${existingRequest.id}</div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed mb-3"></div>
                                    <div><strong>Status:</strong> <span class="badge badge-warning">${existingRequest.status_name || 'Pending'}</span></div>
                                    <div class="mt-2"><strong>Transfer Type:</strong> ${existingRequest.transfer_type || 'N/A'}</div>
                                    <div class="mt-2"><strong>Mode of Transport:</strong> ${existingRequest.mode_of_transport || 'N/A'}</div>
                                    <div class="mt-2"><strong>Created:</strong> ${createdDate}</div>
                                    <div class="separator separator-dashed mt-3 mb-3"></div>
                                    <div class="text-muted fs-7">Please wait for the existing request to be processed or contact your manager.</div>
                                </div>
                            `,
                                icon: 'warning',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#f1c40f',
                                customClass: {
                                    popup: 'swal2-popup-large'
                                }
                            });
                        } else if (data.errors) {
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
            }, 200); // Increased delay to allow Select2 to settle properly
        });
    }
});
</script>