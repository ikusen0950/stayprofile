<!--begin::Modal - Edit Guest-->
<style>
.is-invalid {
    border-color: #f1416c !important;
}

.field-error {
    font-size: 0.875rem;
    color: #f1416c !important;
    margin-top: 0.25rem;
}

/* Select2 error styling */
.select2-container.is-invalid .select2-selection,
.select2-container.is-invalid .select2-selection--single {
    border-color: #f1416c !important;
}

.select2-container.is-invalid .select2-selection--single:focus,
.select2-container.is-invalid .select2-selection--single:hover {
    border-color: #f1416c !important;
}
</style>

<div class="modal fade" id="editGuestModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="editGuestModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Guest</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-guests-edit-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Form-->
                <form id="editGuestModal_form" class="form" action="#">
                    <input type="hidden" name="guest_id" id="edit_guest_id" />
                    
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="editGuestModal_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#editGuestModal_header"
                        data-kt-scroll-wrappers="#editGuestModal_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Row 1: Reservation Code | Status-->
                        <div class="fv-row row mb-7">
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Reservation Code</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="reservation_code" id="edit_reservation_code" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter reservation code" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select name="status" id="edit_status" class="form-select form-select-solid" data-control="select2" data-placeholder="Select status" data-dropdown-parent="#editGuestModal" required>
                                    <option></option>
                                    <?php if (!empty($guestStatuses)): ?>
                                    <?php foreach ($guestStatuses as $status): ?>
                                    <option value="<?= esc($status['value']) ?>"><?= esc($status['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row 1-->

                        <!--begin::Row 2: Full Name (full width)-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="full_name" id="edit_full_name" class="form-control form-control-solid" placeholder="Enter guest full name" required />
                            <!--end::Input-->
                        </div>
                        <!--end::Row 2-->

                        <!--begin::Row 3: Email | Phone-->
                        <div class="fv-row row mb-7">
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" id="edit_email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter email address" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone" id="edit_phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter phone number" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row 3-->

                        <!--begin::Row 4: Villa | Guest Type-->
                        <div class="fv-row row mb-7">
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Villa</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select name="villa_id" id="edit_villa_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select villa" data-dropdown-parent="#editGuestModal" required>
                                    <option></option>
                                    <?php if (!empty($villas)): ?>
                                    <?php foreach ($villas as $villa): ?>
                                    <option value="<?= esc($villa['id']) ?>"><?= esc($villa['villa_name']) ?> (<?= esc($villa['villa_code'] ?? '') ?>)</option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Guest Type</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select name="guest_type" id="edit_guest_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Select guest type" data-dropdown-parent="#editGuestModal" required>
                                    <option></option>
                                    <?php if (!empty($guestTypes)): ?>
                                    <?php foreach ($guestTypes as $type): ?>
                                    <option value="<?= esc($type['value']) ?>"><?= esc($type['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <!--end::Select2-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row 4-->

                        <!--begin::Row 5: Arrival Date | Departure Date-->
                        <div class="fv-row row mb-7">
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Arrival Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="arrival_date" id="edit_arrival_date" class="form-control form-control-solid mb-3 mb-lg-0" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Departure Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="departure_date" id="edit_departure_date" class="form-control form-control-solid mb-3 mb-lg-0" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row 5-->

                        <!--begin::Row 6: Arrival to Here | Departure from Here-->
                        <div class="fv-row row mb-7">
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Arrival to Here</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="arrival_time" id="edit_arrival_time" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter arrival time to here" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Departure from Here</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="departure_time" id="edit_departure_time" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter departure time from here" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row 6-->

                        <!--begin::Row 7: Guest Token (full width)-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Guest Token</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" name="guest_token" id="edit_guest_token" class="form-control form-control-solid" placeholder="Guest token" readonly />
                            <!--end::Input-->
                        </div>
                        <!--end::Row 7-->

                        <!--begin::Row 8: Inclusive (full width)-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Inclusive</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="inclusive" id="edit_inclusive" class="form-control form-control-solid" rows="3" placeholder="Enter inclusive details"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Row 8-->

                        <!--begin::Row 9: Notes (full width)-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Notes</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="notes" id="edit_notes" class="form-control form-control-solid" rows="3" placeholder="Enter any additional notes"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Row 9-->

                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-kt-guests-edit-modal-action="cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary" data-kt-guests-edit-modal-action="submit">
                            <span class="indicator-label">Update</span>
                            <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                    </div>
                    <!--end::Actions-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - Edit Guest-->

<script>
"use strict";

// Global flag to prevent duplicate submission
window.editGuestModalSubmitting = false;

// Single simplified edit modal handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('editGuestModal_form');
    const submitBtn = document.querySelector('[data-kt-guests-edit-modal-action="submit"]');
    const cancelBtn = document.querySelector('[data-kt-guests-edit-modal-action="cancel"]');
    const closeBtn = document.querySelector('[data-kt-guests-edit-modal-action="close"]');
    const modal = document.getElementById('editGuestModal');
    
    if (!form || !submitBtn) {
        console.log('Edit guest modal form or submit button not found');
        return;
    }

    // Initialize Select2 dropdowns
    if (typeof $ !== 'undefined' && $.fn.select2) {
        $(modal).find('[data-control="select2"]').select2({
            dropdownParent: $(modal)
        });
    }

    // Prevent all form submissions
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    });

    form.onsubmit = function(e) {
        e.preventDefault();
        e.stopPropagation();
        return false;
    };

    // Single submit handler
    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        // Prevent duplicate submissions
        if (window.editGuestModalSubmitting) {
            console.log('Edit submission already in progress, ignoring');
            return false;
        }

        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.error('jQuery not available, cannot submit form');
            alert('Required libraries not loaded. Please refresh the page.');
            return false;
        }

        // Clear previous validation errors
        clearEditValidationErrors();
        
        // Client-side validation with inline error display
        let hasErrors = false;
        
        const reservationCode = form.querySelector('[name="reservation_code"]').value.trim();
        const status = form.querySelector('[name="status"]').value;
        const fullName = form.querySelector('[name="full_name"]').value.trim();
        const email = form.querySelector('[name="email"]').value.trim();
        const phone = form.querySelector('[name="phone"]').value.trim();
        const villaId = form.querySelector('[name="villa_id"]').value;
        const guestType = form.querySelector('[name="guest_type"]').value;
        const arrivalDate = form.querySelector('[name="arrival_date"]').value;
        const departureDate = form.querySelector('[name="departure_date"]').value;
        const arrivalTime = form.querySelector('[name="arrival_time"]').value;
        const departureTime = form.querySelector('[name="departure_time"]').value;
        const guestId = form.querySelector('[name="guest_id"]').value;
        
        if (!reservationCode) {
            showEditFieldError('reservation_code', 'Please enter a reservation code');
            hasErrors = true;
        }
        
        if (!status) {
            showEditFieldError('status', 'Please select a status');
            hasErrors = true;
        }
        
        if (!fullName) {
            showEditFieldError('full_name', 'Please enter a full name');
            hasErrors = true;
        }
        
        if (!email) {
            showEditFieldError('email', 'Please enter an email address');
            hasErrors = true;
        } else if (!isValidEditEmail(email)) {
            showEditFieldError('email', 'Please enter a valid email address');
            hasErrors = true;
        }
        
        if (!phone) {
            showEditFieldError('phone', 'Please enter a phone number');
            hasErrors = true;
        }
        
        if (!villaId) {
            showEditFieldError('villa_id', 'Please select a villa');
            hasErrors = true;
        }
        
        if (!guestType) {
            showEditFieldError('guest_type', 'Please select a guest type');
            hasErrors = true;
        }
        
        if (!arrivalDate) {
            showEditFieldError('arrival_date', 'Please select an arrival date');
            hasErrors = true;
        }
        
        if (!departureDate) {
            showEditFieldError('departure_date', 'Please select a departure date');
            hasErrors = true;
        }
        
        if (!arrivalTime) {
            showEditFieldError('arrival_time', 'Please enter arrival time to here');
            hasErrors = true;
        }
        
        if (!departureTime) {
            showEditFieldError('departure_time', 'Please enter departure time from here');
            hasErrors = true;
        }
        
        // Date validation - departure should be after arrival
        if (arrivalDate && departureDate && arrivalDate > departureDate) {
            showEditFieldError('departure_date', 'Departure date must be after arrival date');
            hasErrors = true;
        }
        
        if (!guestId) {
            showEditFieldError('guest_id', 'Guest ID is missing');
            hasErrors = true;
        }
        
        if (hasErrors) {
            return false;
        }

        // Set submission flag and disable button
        window.editGuestModalSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.setAttribute('data-kt-indicator', 'on');
        
        // Get form data
        const formData = new FormData(form);
        
        console.log('Submitting edit guest form with data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // Submit via AJAX
        $.ajax({
            url: '<?= base_url('guests') ?>/' + guestId + '/update',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log('Edit guest response:', response);
                if (response.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Guest updated successfully!');
                    } else {
                        alert(response.message || 'Guest updated successfully!');
                    }
                    
                    // Close modal
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    
                    clearEditValidationErrors();
                    
                    // Reload page
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    console.error('Server error:', response);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to update guest');
                    } else {
                        alert(response.message || 'Failed to update guest');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr, status, error);
                console.error('Response text:', xhr.responseText);
                if (typeof toastr !== 'undefined') {
                    toastr.error('An error occurred while updating the guest');
                } else {
                    alert('An error occurred while updating the guest');
                }
            },
            complete: function() {
                // Reset submission flag and re-enable button
                window.editGuestModalSubmitting = false;
                submitBtn.disabled = false;
                submitBtn.removeAttribute('data-kt-indicator');
            }
        });
    });

    // Cancel button handler
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearEditValidationErrors();
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }

    // Close button handler
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            clearEditValidationErrors();
            const modalInstance = bootstrap.Modal.getInstance(modal);
            if (modalInstance) {
                modalInstance.hide();
            }
        });
    }

    // Reset submission flag when modal is closed
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            window.editGuestModalSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.removeAttribute('data-kt-indicator');
            clearEditValidationErrors();
        });
        
        // Clear validation errors when modal is shown
        modal.addEventListener('shown.bs.modal', function() {
            clearEditValidationErrors();
        });
    }
});

// Helper functions for inline validation
function isValidEditEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showEditFieldError(fieldName, message) {
    const field = document.querySelector(`#editGuestModal [name="${fieldName}"]`);
    if (!field) return;
    
    // Remove existing error
    const existingError = field.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    // Handle Select2 dropdowns differently
    if (field.hasAttribute('data-control') && field.getAttribute('data-control') === 'select2') {
        // For Select2, find the container and apply error styling
        const select2Container = field.parentNode.querySelector('.select2-container');
        if (select2Container) {
            select2Container.classList.add('is-invalid');
            const select2Selection = select2Container.querySelector('.select2-selection');
            if (select2Selection) {
                select2Selection.style.borderColor = '#f1416c';
            }
        }
        // Also add class to original select for clearing later
        field.classList.add('is-invalid');
    } else {
        // For regular inputs
        field.classList.add('is-invalid');
    }
    
    // Create error message element
    const errorElement = document.createElement('div');
    errorElement.className = 'field-error text-danger mt-1 fs-7';
    errorElement.textContent = message;
    
    // Insert error message after the field (or after Select2 container)
    if (field.hasAttribute('data-control') && field.getAttribute('data-control') === 'select2') {
        const select2Container = field.parentNode.querySelector('.select2-container');
        if (select2Container && select2Container.nextSibling) {
            field.parentNode.insertBefore(errorElement, select2Container.nextSibling);
        } else {
            field.parentNode.appendChild(errorElement);
        }
    } else {
        field.parentNode.appendChild(errorElement);
    }
}

function clearEditValidationErrors() {
    // Remove all error messages within the edit modal
    const errorElements = document.querySelectorAll('#editGuestModal .field-error');
    errorElements.forEach(element => element.remove());
    
    // Remove error classes from regular fields in edit modal
    const invalidFields = document.querySelectorAll('#editGuestModal .is-invalid');
    invalidFields.forEach(field => {
        field.classList.remove('is-invalid');
        
        // If it's a Select2 field, also clear the container styling
        if (field.hasAttribute('data-control') && field.getAttribute('data-control') === 'select2') {
            const select2Container = field.parentNode.querySelector('.select2-container');
            if (select2Container) {
                select2Container.classList.remove('is-invalid');
                const select2Selection = select2Container.querySelector('.select2-selection');
                if (select2Selection) {
                    select2Selection.style.borderColor = '';
                }
            }
        }
    });
}

// Function to populate edit form
window.populateEditGuestForm = function(guest) {
    // Clear any existing validation errors
    clearEditValidationErrors();
    
    // Basic fields
    document.getElementById('edit_guest_id').value = guest.id || '';
    document.getElementById('edit_reservation_code').value = guest.reservation_code || '';
    document.getElementById('edit_full_name').value = guest.full_name || '';
    document.getElementById('edit_email').value = guest.email || '';
    document.getElementById('edit_phone').value = guest.phone || '';
    document.getElementById('edit_guest_token').value = guest.guest_token || '';

    // Date fields
    if (guest.arrival_date) {
        document.getElementById('edit_arrival_date').value = guest.arrival_date;
    }
    if (guest.departure_date) {
        document.getElementById('edit_departure_date').value = guest.departure_date;
    }
    
    // Time fields - handle both old and new field names
    if (guest.arrival_time) {
        document.getElementById('edit_arrival_time').value = guest.arrival_time;
    } else if (guest.arrival_to_here) {
        document.getElementById('edit_arrival_time').value = guest.arrival_to_here;
    }
    
    if (guest.departure_time) {
        document.getElementById('edit_departure_time').value = guest.departure_time;
    } else if (guest.departure_from_here) {
        document.getElementById('edit_departure_time').value = guest.departure_from_here;
    }

    // Select2 fields (if jQuery available)
    if (typeof $ !== 'undefined') {
        $('#edit_villa_id').val(guest.villa_id).trigger('change');
        $('#edit_guest_type').val(guest.guest_type).trigger('change');
        $('#edit_status').val(guest.status).trigger('change');
    }

    // Textarea fields
    document.getElementById('edit_inclusive').value = guest.inclusive || '';
    document.getElementById('edit_notes').value = guest.notes || '';
};
</script>