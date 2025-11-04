<!--begin::Modal - Create Guest-->
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

<div class="modal fade" id="createGuestModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="createGuestModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Add New Guest</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-guests-modal-action="close">
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
                <form id="createGuestModal_form" class="form" method="post" action="<?= base_url('guests') ?>"  novalidate>
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="createGuestModal_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#createGuestModal_header"
                        data-kt-scroll-wrappers="#createGuestModal_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Row 1: Reservation Code | Status-->
                        <div class="fv-row row mb-7">
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Reservation Code</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="reservation_code" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter reservation code" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Status</label>
                                <!--end::Label-->
                                <!--begin::Select2-->
                                <select name="status" class="form-select form-select-solid" data-control="select2" data-placeholder="Select status" data-dropdown-parent="#createGuestModal" required>
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
                            <input type="text" name="full_name" class="form-control form-control-solid" placeholder="Enter guest full name" required />
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
                                <input type="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter email address" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter phone number" required />
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
                                <select name="villa_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select villa" data-dropdown-parent="#createGuestModal" required>
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
                                <select name="guest_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Select guest type" data-dropdown-parent="#createGuestModal" required>
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
                                <input type="date" name="arrival_date" class="form-control form-control-solid mb-3 mb-lg-0" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Departure Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="departure_date" class="form-control form-control-solid mb-3 mb-lg-0" required />
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
                                <input type="text" name="arrival_time" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter arrival time to here" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="fv-col col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Departure from Here</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="departure_time" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter departure time from here" required />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row 6-->

        <!--begin::Row 7: Inclusive (full width)-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fw-semibold fs-6 mb-2">Inclusive</label>
            <!--end::Label-->
            <!--begin::Input-->
            <textarea name="inclusive" class="form-control form-control-solid" rows="3" placeholder="Enter inclusive details"></textarea>
            <!--end::Input-->
        </div>
        <!--end::Row 7-->                        <!--begin::Row 8: Notes (full width)-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Notes</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea name="notes" class="form-control form-control-solid" rows="3" placeholder="Enter any additional notes"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Row 8-->

                    </div>
                    <!--end::Scroll-->

                    <!--begin::Actions-->
                    <div class="text-center pt-10">
                        <button type="reset" class="btn btn-light me-3" data-kt-guests-modal-action="cancel">Discard</button>
                        <button type="button" class="btn btn-primary" data-kt-guests-modal-action="submit">
                            <span class="indicator-label">Submit</span>
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
<!--end::Modal - Create Guest-->

<script>
"use strict";

// Global flag to prevent duplicate submission
window.guestModalSubmitting = false;

// Single simplified modal handler
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createGuestModal_form');
    const submitBtn = document.querySelector('[data-kt-guests-modal-action="submit"]');
    const cancelBtn = document.querySelector('[data-kt-guests-modal-action="cancel"]');
    const closeBtn = document.querySelector('[data-kt-guests-modal-action="close"]');
    const modal = document.getElementById('createGuestModal');
    
    if (!form || !submitBtn) {
        console.log('Guest modal form or submit button not found');
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
        if (window.guestModalSubmitting) {
            console.log('Submission already in progress, ignoring');
            return false;
        }

        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            console.error('jQuery not available, cannot submit form');
            alert('Required libraries not loaded. Please refresh the page.');
            return false;
        }

        // Clear previous validation errors
        clearValidationErrors();
        
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
        
        if (!reservationCode) {
            showFieldError('reservation_code', 'Please enter a reservation code');
            hasErrors = true;
        }
        
        if (!status) {
            showFieldError('status', 'Please select a status');
            hasErrors = true;
        }
        
        if (!fullName) {
            showFieldError('full_name', 'Please enter a full name');
            hasErrors = true;
        }
        
        if (!email) {
            showFieldError('email', 'Please enter an email address');
            hasErrors = true;
        } else if (!isValidEmail(email)) {
            showFieldError('email', 'Please enter a valid email address');
            hasErrors = true;
        }
        
        if (!phone) {
            showFieldError('phone', 'Please enter a phone number');
            hasErrors = true;
        }
        
        if (!villaId) {
            showFieldError('villa_id', 'Please select a villa');
            hasErrors = true;
        }
        
        if (!guestType) {
            showFieldError('guest_type', 'Please select a guest type');
            hasErrors = true;
        }
        
        if (!arrivalDate) {
            showFieldError('arrival_date', 'Please select an arrival date');
            hasErrors = true;
        }
        
        if (!departureDate) {
            showFieldError('departure_date', 'Please select a departure date');
            hasErrors = true;
        }
        
        if (!arrivalTime) {
            showFieldError('arrival_time', 'Please enter arrival time to here');
            hasErrors = true;
        }
        
        if (!departureTime) {
            showFieldError('departure_time', 'Please enter departure time from here');
            hasErrors = true;
        }
        
        // Date validation - departure should be after arrival
        if (arrivalDate && departureDate && arrivalDate > departureDate) {
            showFieldError('departure_date', 'Departure date must be after arrival date');
            hasErrors = true;
        }
        
        if (hasErrors) {
            return false;
        }

        // Set submission flag and disable button
        window.guestModalSubmitting = true;
        submitBtn.disabled = true;
        submitBtn.setAttribute('data-kt-indicator', 'on');
        
        // Get form data
        const formData = new FormData(form);
        
        console.log('Submitting guest form with data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }
        
        // Submit via AJAX
        $.ajax({
            url: '<?= base_url('guests') ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                console.log('Guest creation response:', response);
                if (response.success) {
                    if (typeof toastr !== 'undefined') {
                        toastr.success(response.message || 'Guest created successfully!');
                    } else {
                        alert(response.message || 'Guest created successfully!');
                    }
                    
                    // Close modal
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                    
                    // Reset form
                    form.reset();
                    clearValidationErrors();
                    
                    // Reload page
                    setTimeout(function() {
                        window.location.reload();
                    }, 500);
                } else {
                    console.error('Server error:', response);
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to create guest');
                    } else {
                        alert(response.message || 'Failed to create guest');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', xhr, status, error);
                console.error('Response text:', xhr.responseText);
                if (typeof toastr !== 'undefined') {
                    toastr.error('An error occurred while creating the guest');
                } else {
                    alert('An error occurred while creating the guest');
                }
            },
            complete: function() {
                // Reset submission flag and re-enable button
                window.guestModalSubmitting = false;
                submitBtn.disabled = false;
                submitBtn.removeAttribute('data-kt-indicator');
            }
        });
    }, { once: false }); // Allow multiple clicks but prevent with flag

    // Cancel button handler
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.value) {
                        form.reset();
                        clearValidationErrors();
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                });
            } else {
                if (confirm('Are you sure you would like to cancel?')) {
                    form.reset();
                    clearValidationErrors();
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            }
        });
    }

    // Close button handler
    if (closeBtn) {
        closeBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    text: "Are you sure you would like to cancel?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, cancel it!",
                    cancelButtonText: "No, return",
                    customClass: {
                        confirmButton: "btn btn-primary",
                        cancelButton: "btn btn-active-light"
                    }
                }).then(function(result) {
                    if (result.value) {
                        form.reset();
                        clearValidationErrors();
                        const modalInstance = bootstrap.Modal.getInstance(modal);
                        if (modalInstance) {
                            modalInstance.hide();
                        }
                    }
                });
            } else {
                if (confirm('Are you sure you would like to cancel?')) {
                    form.reset();
                    clearValidationErrors();
                    const modalInstance = bootstrap.Modal.getInstance(modal);
                    if (modalInstance) {
                        modalInstance.hide();
                    }
                }
            }
        });
    }

    // Reset submission flag when modal is closed
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            window.guestModalSubmitting = false;
            submitBtn.disabled = false;
            submitBtn.removeAttribute('data-kt-indicator');
            clearValidationErrors();
        });
        
        // Clear validation errors when modal is shown
        modal.addEventListener('shown.bs.modal', function() {
            clearValidationErrors();
        });
    }
});

// Helper functions for inline validation
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function showFieldError(fieldName, message) {
    const field = document.querySelector(`[name="${fieldName}"]`);
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

function clearValidationErrors() {
    // Remove all error messages
    const errorElements = document.querySelectorAll('.field-error');
    errorElements.forEach(element => element.remove());
    
    // Remove error classes from regular fields
    const invalidFields = document.querySelectorAll('.is-invalid');
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
</script>