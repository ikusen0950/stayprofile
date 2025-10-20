<div class="modal fade" id="exitPassModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true"
    data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content d-flex flex-column" style="height: 100%; min-height: 500px;">
            <!--begin::Modal dialog-->
            <div class="modal-content d-flex flex-column" style="height: 100%; min-height: 500px;">
                <!--begin::Modal header-->
                <div class="modal-header" id="exitPassModal_header">
                    <h2 class="fw-bold">Create Exit Pass</h2>
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
                    <form id="exitPassModal_form" class="form" action="#">
                        <div class="px-5 px-lg-10">
                            <!--begin::Section-->
                            <h4 class="fw-bold text-gray-800">User Informations</h4>
                            <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Request #</label>
                                    <input type="text" name="id" class="form-control form-control-solid mb-3 mb-lg-0" value="<?= isset($nextRequestId) ? 'RID#' . str_pad(esc($nextRequestId), 6, '0', STR_PAD_LEFT) : '' ?>" readonly required />
                                    <?php if (!isset($nextRequestId)): ?>
                                    <small class="text-danger">Request # not available. Please check backend code.</small>
                                    <?php endif; ?>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="email"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">User Type</label>
                                    <select name="user_type" id="user_type_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select user type" data-dropdown-parent="#exitPassModal" data-allow-clear="false" required>
                                        <option value="">Select User Type</option>
                                        <option value="1" selected>Islander</option>
                                        <option value="2">Visitor</option>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="user_type" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-7">
                                <!-- Islander Dropdown - Show when user type = 1 -->
                                <div id="islander_dropdown_section" style="display: block;">
                                    <label class="required fw-semibold fs-6 mb-2">Islander</label>
                                    <select name="islander_id" id="islander_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Islander" data-dropdown-parent="#exitPassModal" required>
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
                                </div>
                                
                                <!-- Visitor Dropdown - Show when user type = 2 -->
                                <div id="visitor_dropdown_section" style="display: none;">
                                    <label class="required fw-semibold fs-6 mb-2">Visitor</label>
                                    <select name="visitor_id" id="visitor_select" class="form-select form-select-solid" data-control="select2" data-placeholder="Select Visitor" data-dropdown-parent="#exitPassModal">
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
                                </div>
                                
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="user_selection" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Leave Reason</label>
                                <select name="leave_reason" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select leave reason"
                                    data-dropdown-parent="#exitPassModal" required>
                                    <option value="">Select Leave Reason</option>
                                    <?php if (!empty($leave_reasons)): ?>
                                    <?php foreach ($leave_reasons as $leave_reason): ?>
                                    <option value="<?= esc($leave_reason['id']) ?>">
                                        <?= esc($leave_reason['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                    <option value="" disabled>No leave reasons found</option>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="leave_reason" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Section-->
                            <h4 class="fw-bold text-gray-800">Departure Informations</h4>
                            <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Date</label>
                                    <input type="date" name="departure_date"
                                        class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter date"
                                        value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="departure_date" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Time</label>
                                    <input type="time" name="departure_time" class="form-control form-control-solid"
                                        placeholder="Enter time" value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="departure_time" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Section-->
                            <h4 class="fw-bold text-gray-800">Arrival Informations</h4>
                            <div class="separator separator-dashed mt-2 mb-7"></div>

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Date</label>
                                    <input type="date" name="arrival_date"
                                        class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter date"
                                        value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="arrival_date" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Time</label>
                                    <input type="time" name="arrival_time" class="form-control form-control-solid"
                                        placeholder="Enter time" value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="arrival_time" style="color: #f1416c; font-size: 0.875rem; margin-top: 0.25rem;"></div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-12">
                                    <label class="fw-semibold fs-6 mb-2">Remarks</label>
                                    <textarea name="remarks" class="form-control form-control-solid" rows="3"
                                        placeholder="Enter remarks"></textarea>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                    </form>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center" style="background: #fff; z-index: 2;">
                    <button type="reset" id="exitPassModal_cancel" class="btn btn-light me-3"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="exitPassModal_submit" class="btn btn-primary">
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

// Dynamic dropdown switching for Islander/Visitor
document.addEventListener('DOMContentLoaded', function() {
    // Set date restrictions based on user permissions
    const canCreatePastDate = <?= json_encode($canCreatePastDate ?? false) ?>;
    
    if (!canCreatePastDate) {
        // Restrict to today and future dates only
        const today = new Date().toISOString().split('T')[0];
        
        const departureDateInput = document.querySelector('[name="departure_date"]');
        const arrivalDateInput = document.querySelector('[name="arrival_date"]');
        
        if (departureDateInput) {
            departureDateInput.setAttribute('min', today);
        }
        
        if (arrivalDateInput) {
            arrivalDateInput.setAttribute('min', today);
        }
    }
    
    var userTypeSelect = document.getElementById('user_type_select');
    var islanderSection = document.getElementById('islander_dropdown_section');
    var visitorSection = document.getElementById('visitor_dropdown_section');
    var islanderSelect = document.getElementById('islander_select');
    var visitorSelect = document.getElementById('visitor_select');
    
    function updateDropdownVisibility() {
        var selectedType = userTypeSelect.value;
        console.log('Switching to user type:', selectedType);
        console.log('Current sections before change:', {
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
                console.log('Auto-selected islander:', autoSelectValue);
            }
            
        } else if (selectedType === '2') {
            // Show Visitor dropdown, hide Islander dropdown
            islanderSection.style.display = 'none';
            visitorSection.style.display = 'block';
            
            // Set required attribute
            visitorSelect.setAttribute('required', 'required');
            islanderSelect.removeAttribute('required');
            
            // Clear islander selection
            if (window.jQuery && $(islanderSelect).data('select2')) {
                $(islanderSelect).val(null).trigger('change');
            } else {
                islanderSelect.value = '';
            }
            
        } else {
            // Default to Islander (no selection)
            islanderSection.style.display = 'block';
            visitorSection.style.display = 'none';
            
            islanderSelect.setAttribute('required', 'required');
            visitorSelect.removeAttribute('required');
        }
        
        console.log('Updated sections:', {
            islanderDisplay: islanderSection.style.display,
            visitorDisplay: visitorSection.style.display
        });
    }
    
    if (userTypeSelect && islanderSection && visitorSection) {
        // Initialize Select2 for all dropdowns
        if (window.jQuery) {
            // Global Select2 configuration to prevent auto-focus on search
            $.fn.select2.defaults.set('dropdownAutoWidth', true);
            $.fn.select2.defaults.set('selectOnClose', false);
            
            // Initialize User Type Select2 with change event
            $(userTypeSelect).select2({
                dropdownParent: $('#exitPassModal'),
                placeholder: 'Select User Type',
                allowClear: false,
                minimumResultsForSearch: Infinity // Disable search for user type
            });
            
            // Use Select2 change event specifically
            $(userTypeSelect).on('select2:select', function(e) {
                console.log('Select2 change event triggered');
                setTimeout(updateDropdownVisibility, 50);
            });
            
            $(islanderSelect).select2({
                dropdownParent: $('#exitPassModal'),
                placeholder: 'Select Islander',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });
            
            $(visitorSelect).select2({
                dropdownParent: $('#exitPassModal'),
                placeholder: 'Select Visitor',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Initialize Leave Reason Select2
            $('select[name="leave_reason"]').select2({
                dropdownParent: $('#exitPassModal'),
                placeholder: 'Select leave reason',
                allowClear: true,
                dropdownAutoWidth: true,
                selectOnClose: false
            });

            // Global event handler to prevent auto-focus on Select2 search inputs
            $('#exitPassModal').on('select2:open', function() {
                setTimeout(function() {
                    // Remove focus from any search input that gets auto-focused
                    $('.select2-search__field').blur();
                }, 1);
            });
        }
        
        // Also add native change event as backup
        userTypeSelect.addEventListener('change', function() {
            console.log('Native change event triggered');
            updateDropdownVisibility();
        });
        
        // Initial setup - default to Islander
        setTimeout(function() {
            updateDropdownVisibility();
        }, 300);
        
        // Also update when modal is shown
        $('#exitPassModal').on('shown.bs.modal', function () {
            setTimeout(function() {
                updateDropdownVisibility();
            }, 500);
        });
    }

    // Exit Pass Form Submission
    const exitPassForm = document.getElementById('exitPassModal_form');
    const exitPassSubmitBtn = document.getElementById('exitPassModal_submit');
    const exitPassModal = document.getElementById('exitPassModal');

    // Validation functions
    function showValidationError(fieldName, message) {
        const errorElement = document.querySelector(`[data-field="${fieldName}"]`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }
        
        // Add error styling to the input
        let inputElement = document.querySelector(`[name="${fieldName}"]`);
        if (!inputElement && fieldName === 'user_type') {
            inputElement = document.querySelector('#user_type_select');
        }
        if (!inputElement && fieldName === 'user_selection') {
            const userType = document.querySelector('[name="user_type"]').value;
            if (userType === '1') {
                inputElement = document.querySelector('#islander_select');
            } else if (userType === '2') {
                inputElement = document.querySelector('#visitor_select');
            }
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

    function hideValidationError(fieldName) {
        const errorElement = document.querySelector(`[data-field="${fieldName}"]`);
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
        
        // Remove error styling from the input
        let inputElement = document.querySelector(`[name="${fieldName}"]`);
        if (!inputElement && fieldName === 'user_type') {
            inputElement = document.querySelector('#user_type_select');
        }
        if (!inputElement && fieldName === 'user_selection') {
            const userType = document.querySelector('[name="user_type"]').value;
            if (userType === '1') {
                inputElement = document.querySelector('#islander_select');
            } else if (userType === '2') {
                inputElement = document.querySelector('#visitor_select');
            }
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

    function clearAllValidationErrors() {
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

    function validateExitPassForm() {
        let isValid = true;
        clearAllValidationErrors();

        // Get user's permission to create past date requests
        const canCreatePastDate = <?= json_encode($canCreatePastDate ?? false) ?>;

        // 1. Validate User Type
        const userType = document.querySelector('[name="user_type"]').value;
        if (!userType) {
            showValidationError('user_type', 'Please select a user type');
            isValid = false;
        } else {
            hideValidationError('user_type');
        }

        // 2. Validate Islander/Visitor Selection
        let selectedUserId = '';
        if (userType === '1') {
            // Islander selected
            selectedUserId = document.querySelector('[name="islander_id"]').value;
            if (!selectedUserId) {
                showValidationError('user_selection', 'Please select an Islander');
                isValid = false;
            } else {
                hideValidationError('user_selection');
            }
        } else if (userType === '2') {
            // Visitor selected
            selectedUserId = document.querySelector('[name="visitor_id"]').value;
            if (!selectedUserId) {
                showValidationError('user_selection', 'Please select a Visitor');
                isValid = false;
            } else {
                hideValidationError('user_selection');
            }
        }

        // 3. Validate Leave Reason
        const leaveReason = document.querySelector('[name="leave_reason"]').value;
        if (!leaveReason) {
            showValidationError('leave_reason', 'Please select a leave reason');
            isValid = false;
        } else {
            hideValidationError('leave_reason');
        }

        // 4. Validate Departure Date
        const departureDate = document.querySelector('[name="departure_date"]').value;
        if (!departureDate) {
            showValidationError('departure_date', 'Please select departure date');
            isValid = false;
        } else {
            // Check if departure date is not in the past (unless user has permission)
            if (!canCreatePastDate) {
                const today = new Date();
                const selectedDate = new Date(departureDate);
                today.setHours(0, 0, 0, 0);
                selectedDate.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    showValidationError('departure_date', 'Departure date cannot be in the past');
                    isValid = false;
                } else {
                    hideValidationError('departure_date');
                }
            } else {
                hideValidationError('departure_date');
            }
        }

        // 5. Validate Departure Time
        const departureTime = document.querySelector('[name="departure_time"]').value;
        if (!departureTime) {
            showValidationError('departure_time', 'Please select departure time');
            isValid = false;
        } else {
            hideValidationError('departure_time');
        }

        // 6. Validate Arrival Date
        const arrivalDate = document.querySelector('[name="arrival_date"]').value;
        if (!arrivalDate) {
            showValidationError('arrival_date', 'Please select arrival date');
            isValid = false;
        } else {
            // Check if arrival date is not in the past (unless user has permission)
            if (!canCreatePastDate) {
                const today = new Date();
                const selectedDate = new Date(arrivalDate);
                today.setHours(0, 0, 0, 0);
                selectedDate.setHours(0, 0, 0, 0);
                
                if (selectedDate < today) {
                    showValidationError('arrival_date', 'Arrival date cannot be in the past');
                    isValid = false;
                } else if (departureDate && arrivalDate < departureDate) {
                    showValidationError('arrival_date', 'Arrival date cannot be before departure date');
                    isValid = false;
                } else {
                    hideValidationError('arrival_date');
                }
            } else {
                // Even with permission, arrival cannot be before departure
                if (departureDate && arrivalDate < departureDate) {
                    showValidationError('arrival_date', 'Arrival date cannot be before departure date');
                    isValid = false;
                } else {
                    hideValidationError('arrival_date');
                }
            }
        }

        // 7. Validate Arrival Time
        const arrivalTime = document.querySelector('[name="arrival_time"]').value;
        if (!arrivalTime) {
            showValidationError('arrival_time', 'Please select arrival time');
            isValid = false;
        } else {
            // If departure and arrival are on the same date, check times
            if (departureDate && arrivalDate && departureDate === arrivalDate && departureTime && arrivalTime <= departureTime) {
                showValidationError('arrival_time', 'Arrival time must be after departure time on the same date');
                isValid = false;
            } else {
                hideValidationError('arrival_time');
            }
        }

        return isValid;
    }

    // Add real-time validation clearing
    function addRealtimeValidation() {
        // User type validation clearing
        const userTypeSelect = document.querySelector('[name="user_type"]');
        if (userTypeSelect) {
            userTypeSelect.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('user_type');
                }
            });
        }

        // Islander/Visitor selection validation clearing
        const islanderSelect = document.querySelector('[name="islander_id"]');
        const visitorSelect = document.querySelector('[name="visitor_id"]');
        
        if (islanderSelect) {
            islanderSelect.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('user_selection');
                    // Check for existing exit pass request
                    checkExistingExitPassRequest(this.value, 'islander');
                }
            });
        }
        
        if (visitorSelect) {
            visitorSelect.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('user_selection');
                    // Check for existing exit pass request
                    checkExistingExitPassRequest(this.value, 'visitor');
                }
            });
        }

        // Leave reason validation clearing
        const leaveReasonSelect = document.querySelector('[name="leave_reason"]');
        if (leaveReasonSelect) {
            leaveReasonSelect.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('leave_reason');
                }
            });
        }

        // Date and time validation clearing
        const departureDate = document.querySelector('[name="departure_date"]');
        const departureTime = document.querySelector('[name="departure_time"]');
        const arrivalDate = document.querySelector('[name="arrival_date"]');
        const arrivalTime = document.querySelector('[name="arrival_time"]');

        if (departureDate) {
            departureDate.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('departure_date');
                }
            });
        }

        if (departureTime) {
            departureTime.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('departure_time');
                }
            });
        }

        if (arrivalDate) {
            arrivalDate.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('arrival_date');
                }
            });
        }

        if (arrivalTime) {
            arrivalTime.addEventListener('change', function() {
                if (this.value) {
                    hideValidationError('arrival_time');
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
                        hideValidationError('arrival_date');
                    }
                }
            });
        }
    }

    // Function to check for existing exit pass requests
    function checkExistingExitPassRequest(userId, userType) {
        if (!userId) return;
        
        // Show loading indicator (optional)
        console.log(`Checking existing exit pass for ${userType} user ID: ${userId}`);
        
        secureFetch('/requests/check-existing-exit-pass', {
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
                    title: 'Existing Exit Pass Request Found',
                    html: `
                        <div class="text-start">
                            <div class="alert alert-warning d-flex align-items-center p-4 mb-4">
                                <i class="ki-duotone ki-warning-2 fs-2hx text-warning me-3">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                <div>
                                    <h5 class="mb-1">Cannot Create New Request</h5>
                                    <div>The selected user already has an active exit pass request.</div>
                                </div>
                            </div>
                            <div class="separator my-4"></div>
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-information fs-2 text-primary me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    <div>
                                        <strong>Request ID:</strong> #${existingRequest.id}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-calendar fs-2 text-info me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div>
                                        <strong>Created:</strong> ${createdDate}
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="ki-duotone ki-status fs-2 text-warning me-3">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <div>
                                        <strong>Status:</strong> 
                                        <span class="badge badge-light-primary ms-2">${existingRequest.status_name}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="separator my-4"></div>
                            <div class="text-muted">
                                <i class="ki-duotone ki-information-5 fs-3 text-muted me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                The user cannot create a new exit pass while having an active request (Pending, Approved, Departed, or No Show status).
                            </div>
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
            console.error('Error checking existing exit pass request:', error);
        });
    }

    // Initialize real-time validation
    addRealtimeValidation();

    if (exitPassSubmitBtn && exitPassForm) {
        exitPassSubmitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Clear previous validation errors and validate form
            if (!validateExitPassForm()) {
                // Scroll to first error
                const firstError = document.querySelector('[data-field]:not(:empty)');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }
            
            // Show loading state
            exitPassSubmitBtn.querySelector('.indicator-label').style.display = 'none';
            exitPassSubmitBtn.querySelector('.indicator-progress').style.display = 'inline-block';
            exitPassSubmitBtn.disabled = true;

            // Get form data
            const formData = new FormData(exitPassForm);
            
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
            
            // This validation should not be needed anymore since we validate in validateExitPassForm()
            // But keeping as double-check
            if (!selectedUserId) {
                // Reset loading state
                exitPassSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                exitPassSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                exitPassSubmitBtn.disabled = false;
                
                showValidationError('user_selection', 'Please select a user (Islander or Visitor)');
                return;
            }
            
            // Map form fields to request structure
            formData.set('user_id', selectedUserId); // Use selected islander/visitor as user_id
            formData.set('leave_id', formData.get('leave_reason')); // Use leave reason as leave_id
            formData.set('type', '1');
            formData.set('type_description', 'Exit Pass');
            formData.set('type_color', '#7a3be9');
            formData.set('user_type', userType); // Pass user type for status determination
            
            // Combine departure date and time
            const departureDate = formData.get('departure_date');
            const departureTime = formData.get('departure_time');
            if (departureDate && departureTime) {
                formData.set('expected_departure_date', departureDate);
                formData.set('expected_departure_time', departureTime);
            }
            
            // Combine arrival date and time
            const arrivalDate = formData.get('arrival_date');
            const arrivalTime = formData.get('arrival_time');
            if (arrivalDate && arrivalTime) {
                formData.set('expected_arrival_date', arrivalDate);
                formData.set('expected_arrival_time', arrivalTime);
            }

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
                exitPassSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                exitPassSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                exitPassSubmitBtn.disabled = false;

                if (data.success) {
                    // Hide modal
                    const modal = bootstrap.Modal.getInstance(exitPassModal);
                    modal.hide();
                    
                    // Show success message
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        // Redirect to requests list
                        window.location.href = '/requests';
                    });
                    
                    // Reset form
                    exitPassForm.reset();
                } else {
                    // Check if it's an existing request error
                    if (data.existing_request) {
                        const existingRequest = data.existing_request;
                        const createdDate = new Date(existingRequest.created_at).toLocaleDateString();
                        
                        Swal.fire({
                            title: 'Existing Exit Pass Request',
                            html: `
                                <div class="text-start">
                                    <p><strong>The selected user already has an active exit pass request:</strong></p>
                                    <hr>
                                    <p><i class="ki-duotone ki-information fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i><strong>Request ID:</strong> #${existingRequest.id}</p>
                                    <p><i class="ki-duotone ki-calendar fs-2 text-info me-2"><span class="path1"></span><span class="path2"></span></i><strong>Created:</strong> ${createdDate}</p>
                                    <p><i class="ki-duotone ki-status fs-2 text-warning me-2"><span class="path1"></span><span class="path2"></span></i><strong>Status:</strong> <span class="badge badge-light-primary">${existingRequest.status_name}</span></p>
                                    <hr>
                                    <p class="text-muted">Please wait for the existing request to be completed before creating a new one.</p>
                                </div>
                            `,
                            icon: 'warning',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
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
                exitPassSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                exitPassSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                exitPassSubmitBtn.disabled = false;
                
                console.error('Error:', error);
                Swal.fire('Error', 'Failed to submit exit pass request', 'error');
            });
        });
    }
});

</script>