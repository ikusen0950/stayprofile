<!--begin::Modal - Edit Visitor-->
<div class="modal fade" id="editVisitorModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="editVisitorModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Visitor</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-visitors-modal-action="close">
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
                <form id="editVisitorModal_form" class="form" action="#">
                    <input type="hidden" name="id" id="edit_visitor_id" value="">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="editVisitorModal_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#editVisitorModal_header"
                        data-kt-scroll-wrappers="#editVisitorModal_scroll" data-kt-scroll-offset="300px">

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Input group-->
                            <div class="fv-col col-md-6 mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2 mt-4">Profile Image</label>
                                <!--end::Label-->
                                <!--begin::Image preview-->
                                <div class="image-input image-input-outline image-input-placeholder mb-4 mt-5"
                                    data-kt-image-input="true">
                                    <!--begin::Preview existing image-->
                                    <div class="image-input-wrapper w-125px h-125px mb-4" id="edit_profile_image_preview"
                                        style="background-image: url('<?= base_url('assets/media/svg/files/blank-image.svg') ?>')">
                                    </div>
                                    <!--end::Preview existing image-->
                                    <!--begin::Label-->
                                    <label
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                        title="Change image">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" name="profile_image" accept=".png,.jpg,.jpeg,.gif" />
                                        <input type="hidden" name="profile_image_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="cancel" data-bs-toggle="tooltip"
                                        title="Cancel image">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span
                                        class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                        data-kt-image-input-action="remove" data-bs-toggle="tooltip"
                                        title="Remove image">
                                        <i class="ki-duotone ki-cross fs-2">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image preview-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg, gif. Max size: 2MB.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-col col-md-6">
                                <!--begin::Input group-->
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">Visitor #</label>
                                    <small>(This will be the username.)</small>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="visitor_no" id="edit_visitor_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter visitor number" value="" />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="visitor_no"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-4">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">NID/PP/WP #</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="id_pp_wp_no" id="edit_id_pp_wp_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter NID/PP/WP number" value="" required />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="id_pp_wp_no"></div>
                                    </div>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row ">
                                    <!--begin::Label-->
                                    <label class="fs-6 fw-semibold mb-2 required">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="status_id" id="edit_status_id" class="form-select form-select-solid"
                                        data-control="select2" data-placeholder="Select status"
                                        data-dropdown-parent="#editVisitorModal">
                                        <option value="">Select Status</option>
                                        <?php if (!empty($statuses)): ?>
                                        <?php foreach ($statuses as $status): ?>
                                        <option value="<?= esc($status['id']) ?>"><?= esc($status['name']) ?></option>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="status_id"></div>
                                    </div>
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Personal Informations</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

        <!--begin::Input group-->
        <div class="mb-7">
            <!--begin::Label-->
            <label class="required fw-semibold fs-6 mb-2">Full Name</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" name="full_name" id="edit_full_name" class="form-control form-control-solid"
                placeholder="Enter full name" value="" required />
            <div class="fv-plugins-message-container invalid-feedback">
                <div class="fv-help-block" data-field="full_name"></div>
            </div>
            <!--end::Input-->
        </div>
        <!--end::Input group-->
        
        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" id="edit_email" class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Enter email address" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="email"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="phone" id="edit_phone" class="form-control form-control-solid"
                                    placeholder="Enter phone number" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="phone"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="gender_id" id="edit_gender_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select gender" data-dropdown-parent="#editVisitorModal" required>
                                    <option value="">Select Gender</option>
                                    <?php if (!empty($genders)): ?>
                                    <?php foreach ($genders as $gender): ?>
                                    <option value="<?= esc($gender['id']) ?>"><?= esc($gender['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="gender_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Nationality</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="nationality_id" id="edit_nationality_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select nationality"
                                    data-dropdown-parent="#editVisitorModal" required>
                                    <option value="">Select Nationality</option>
                                    <?php if (!empty($nationalities)): ?>
                                    <?php foreach ($nationalities as $nationality): ?>
                                    <option value="<?= esc($nationality['id']) ?>"><?= esc($nationality['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="nationality_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Date of Birth</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="date_of_birth" id="edit_date_of_birth"
                                    class="form-control form-control-solid mb-3 mb-lg-0"
                                    placeholder="Select date of birth" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="date_of_birth"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">

                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Address</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="address" id="edit_address" class="form-control form-control-solid" rows="3"
                                    placeholder="Enter address"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Visit Information</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Visit Purpose</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="visit_purpose" id="edit_visit_purpose" class="form-control form-control-solid"
                                    placeholder="Enter purpose of visit" value="" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="visit_purpose"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Check-in Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="checkin_date" id="edit_checkin_date" class="form-control form-control-solid"
                                    placeholder="Select check-in date" value="" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="checkin_date"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Check-out Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="checkout_date" id="edit_checkout_date" class="form-control form-control-solid"
                                    placeholder="Select check-out date" value="" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="checkout_date"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Accommodation</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="accommodation" id="edit_accommodation" class="form-control form-control-solid"
                                    placeholder="Enter accommodation details" value="" />
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Notes</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="notes" id="edit_notes" class="form-control form-control-solid" rows="3"
                                    placeholder="Enter any additional notes"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">User Account</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Role</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="role_id" id="edit_role_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select role" data-dropdown-parent="#editVisitorModal" required>
                                    <option value="">Select Role</option>
                                    <?php if (!empty($auth_groups)): ?>
                                    <?php foreach ($auth_groups as $group): ?>
                                    <option value="<?= esc($group->id) ?>"><?= esc($group->name) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="role_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Password</label>
                                <small>(Leave blank to keep current password)</small>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="password" name="password" id="edit_password" class="form-control form-control-solid"
                                    placeholder="Enter new password (optional)" value="" autocomplete="new-password" />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="password"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="reset" id="kt_visitors_edit_cancel" class="btn btn-light me-3">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_visitors_edit_submit" class="btn btn-primary">
                    <span class="indicator-label">Update</span>
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
<!--end::Modal - Edit Visitor-->

<script>
"use strict";

// Class definition
var EditVisitorModal = function() {
    var modal;
    var form;
    var submitButton;
    var cancelButton;
    var validator;

    // Initialize modal
    var initModal = function() {
        modal = new bootstrap.Modal(document.querySelector('#editVisitorModal'));
    };

    // Initialize form
    var initForm = function() {
        form = document.querySelector('#editVisitorModal_form');
        submitButton = document.querySelector('#kt_visitors_edit_submit');
        cancelButton = document.querySelector('#kt_visitors_edit_cancel');

        // Check if required elements exist
        if (!form || !submitButton || !cancelButton) {
            return;
        }

        // Handle form submission
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();
            performManualValidation();
        });

        // Manual validation function
        function performManualValidation() {
            // Clear all previous errors
            clearAllErrors();

            const visitorNo = form.querySelector('input[name="visitor_no"]');
            const idPpWpNo = form.querySelector('input[name="id_pp_wp_no"]');
            const statusId = form.querySelector('select[name="status_id"]');
            const fullName = form.querySelector('input[name="full_name"]');
            const email = form.querySelector('input[name="email"]');
            const phone = form.querySelector('input[name="phone"]');
            const genderId = form.querySelector('select[name="gender_id"]');
            const nationalityId = form.querySelector('select[name="nationality_id"]');
            const dateOfBirth = form.querySelector('input[name="date_of_birth"]');
            const roleId = form.querySelector('select[name="role_id"]');

            let hasErrors = false;

            // Check all required fields and show errors
            if (!visitorNo || !visitorNo.value.trim()) {
                showFieldError('visitor_no', 'Visitor number is required');
                hasErrors = true;
            }
            if (!idPpWpNo || !idPpWpNo.value.trim()) {
                showFieldError('id_pp_wp_no', 'NID/PP/WP number is required');
                hasErrors = true;
            }
            if (!statusId || !statusId.value) {
                showFieldError('status_id', 'Status is required');
                hasErrors = true;
            }
            if (!fullName || !fullName.value.trim()) {
                showFieldError('full_name', 'Full name is required');
                hasErrors = true;
            }
            if (!email || !email.value.trim()) {
                showFieldError('email', 'Email is required');
                hasErrors = true;
            } else if (email.value.trim() && !isValidEmail(email.value.trim())) {
                showFieldError('email', 'Please enter a valid email address');
                hasErrors = true;
            }
            if (!phone || !phone.value.trim()) {
                showFieldError('phone', 'Phone number is required');
                hasErrors = true;
            }
            if (!genderId || !genderId.value) {
                showFieldError('gender_id', 'Gender is required');
                hasErrors = true;
            }
            if (!nationalityId || !nationalityId.value) {
                showFieldError('nationality_id', 'Nationality is required');
                hasErrors = true;
            }
            if (!dateOfBirth || !dateOfBirth.value) {
                showFieldError('date_of_birth', 'Date of birth is required');
                hasErrors = true;
            }
            if (!roleId || !roleId.value) {
                showFieldError('role_id', 'Role is required');
                hasErrors = true;
            }

            if (hasErrors) {
                return;
            }

            submitForm();
        }

        // Helper function to show field error
        function showFieldError(fieldName, message) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const errorContainer = form.querySelector(`[data-field="${fieldName}"]`);
            
            if (field && errorContainer) {
                field.classList.add('is-invalid');
                errorContainer.textContent = message;
                errorContainer.parentElement.style.display = 'block';
            }
        }

        // Helper function to clear all errors
        function clearAllErrors() {
            const fields = form.querySelectorAll('.is-invalid');
            fields.forEach(field => {
                field.classList.remove('is-invalid');
            });
            
            const errorContainers = form.querySelectorAll('.fv-plugins-message-container');
            errorContainers.forEach(container => {
                container.style.display = 'none';
            });
        }

        // Helper function to validate email
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Handle cancel button
        cancelButton.addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you want to cancel?",
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
                    modal.hide();
                }
            });
        });

        // Handle modal close
        document.querySelector('[data-kt-visitors-modal-action="close"]').addEventListener('click', function(e) {
            e.preventDefault();
            Swal.fire({
                text: "Are you sure you want to cancel?",
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
                    modal.hide();
                }
            });
        });
    };

    // Submit form
    var submitForm = function() {
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;

        const formData = new FormData(form);

        $.ajax({
            url: '<?= base_url('visitors/update/') ?>' + formData.get('id'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message || "Visitor has been successfully updated!",
                        icon: "success",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    }).then(function(result) {
                        if (result.isConfirmed) {
                            modal.hide();
                            form.reset();
                            window.location.reload();
                        }
                    });
                } else {
                    let errorMessage = response.message || 'An error occurred while updating the visitor.';

                    if (response.errors) {
                        errorMessage = Object.values(response.errors).flat().join('<br>');
                    }

                    Swal.fire({
                        html: errorMessage,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error updating visitor:', error);

                let errorMessage = 'An error occurred while updating the visitor.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    text: errorMessage,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "Ok, got it!",
                    customClass: {
                        confirmButton: "btn btn-primary"
                    }
                });
            },
            complete: function() {
                submitButton.removeAttribute('data-kt-indicator');
                submitButton.disabled = false;
            }
        });
    };

    // Initialize select2 dropdowns
    var initSelect2 = function() {
        if (typeof $ === 'undefined') {
            return;
        }

        $('#editVisitorModal').on('shown.bs.modal', function() {
            $(this).find('select[data-control="select2"]').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2({
                        dropdownParent: $('#editVisitorModal')
                    });
                }
            });
        });

        $('#editVisitorModal').on('hidden.bs.modal', function() {
            $(this).find('select[data-control="select2"]').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });
        });
    };

    // Initialize image inputs
    var initImageInputs = function() {
        if (typeof $ === 'undefined') {
            return;
        }

        if (typeof KTImageInput !== 'undefined') {
            try {
                KTImageInput.createInstances('#editVisitorModal [data-kt-image-input="true"]');
            } catch (e) {
                console.log('KTImageInput not available:', e);
            }
        }

        $('#editVisitorModal input[name="profile_image"]').on('change', function() {
            const file = this.files[0];
            const maxSize = 2 * 1024 * 1024; // 2MB in bytes
            const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

            if (file) {
                if (file.size > maxSize) {
                    Swal.fire({
                        text: "File size must be less than 2MB",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    this.value = '';
                    return;
                }

                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        text: "Only PNG, JPG, JPEG and GIF files are allowed",
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                    this.value = '';
                    return;
                }
            }
        });
    };

    // Public methods
    return {
        init: function() {
            initModal();
            initForm();
            initSelect2();
            initImageInputs();
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        EditVisitorModal.init();
    });
} else {
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            EditVisitorModal.init();
        } else {
            EditVisitorModal.init();
        }
    });
}
</script>