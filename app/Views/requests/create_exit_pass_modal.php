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
                                        <div class="fv-help-block" data-field="arrival_date"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="required fw-semibold fs-6 mb-2">Time</label>
                                    <input type="time" name="arrival_time" class="form-control form-control-solid"
                                        placeholder="Enter time" value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="arrival_time"></div>
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

<script>

// Dynamic dropdown switching for Islander/Visitor
document.addEventListener('DOMContentLoaded', function() {
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

    if (exitPassSubmitBtn && exitPassForm) {
        exitPassSubmitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
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
            
            // Validate that a user was selected
            if (!selectedUserId) {
                // Reset loading state
                exitPassSubmitBtn.querySelector('.indicator-label').style.display = 'inline';
                exitPassSubmitBtn.querySelector('.indicator-progress').style.display = 'none';
                exitPassSubmitBtn.disabled = false;
                
                Swal.fire('Validation Error', 'Please select a user (Islander or Visitor)', 'error');
                return;
            }
            
            // Map form fields to request structure
            formData.set('user_id', selectedUserId); // Use selected islander/visitor as user_id
            formData.set('leave_id', formData.get('leave_reason')); // Use leave reason as leave_id
            formData.set('type', 'Exit Pass');
            formData.set('type_description', 'Exit pass request');
            
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
                    // Show validation errors
                    if (data.errors) {
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