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
                                    <label class="fs-6 fw-semibold mb-2 required">NID/PP/WP #</label>
                                    <small>(This will be the username.)</small>
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

                        <!--begin::Section-->
                        <h4 class="fw-bold text-gray-800">Work Information</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Division</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="division_id" id="edit_division_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select division" data-dropdown-parent="#editVisitorModal" required>
                                    <option value="">Select Division</option>
                                    <?php if (!empty($divisions)): ?>
                                    <?php foreach ($divisions as $division): ?>
                                    <option value="<?= esc($division['id']) ?>"><?= esc($division['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="division_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Department</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="department_id" id="edit_department_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select department"
                                    data-dropdown-parent="#editVisitorModal" required disabled>
                                    <option value="">Select Department</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="department_id"></div>
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
                                <label class="required fw-semibold fs-6 mb-2">Section</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="section_id" id="edit_section_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select section" data-dropdown-parent="#editVisitorModal" required disabled>
                                    <option value="">Select Section</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="section_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Position</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="position_id" id="edit_position_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select position"
                                    data-dropdown-parent="#editVisitorModal" required disabled>
                                    <option value="">Select Position</option>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="position_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-12">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Company</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="company" id="edit_company" class="form-control form-control-solid"
                                    placeholder="Enter company name" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="company"></div>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group-->

                        <!-- Hidden fields for default values -->
                        <input type="hidden" name="password" value="123" />
                        <input type="hidden" name="role_id" value="8" />

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

            const idPpWpNo = form.querySelector('input[name="id_pp_wp_no"]');
            const statusId = form.querySelector('select[name="status_id"]');
            const fullName = form.querySelector('input[name="full_name"]');
            const email = form.querySelector('input[name="email"]');
            const phone = form.querySelector('input[name="phone"]');
            const genderId = form.querySelector('select[name="gender_id"]');
            const nationalityId = form.querySelector('select[name="nationality_id"]');
            const divisionId = form.querySelector('select[name="division_id"]');
            const departmentId = form.querySelector('select[name="department_id"]');
            const sectionId = form.querySelector('select[name="section_id"]');
            const positionId = form.querySelector('select[name="position_id"]');
            const company = form.querySelector('input[name="company"]');

            let hasErrors = false;

            // Check all required fields and show errors
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
            if (!divisionId || !divisionId.value) {
                showFieldError('division_id', 'Division is required');
                hasErrors = true;
            }
            if (!departmentId || !departmentId.value) {
                showFieldError('department_id', 'Department is required');
                hasErrors = true;
            }
            if (!sectionId || !sectionId.value) {
                showFieldError('section_id', 'Section is required');
                hasErrors = true;
            }
            if (!positionId || !positionId.value) {
                showFieldError('position_id', 'Position is required');
                hasErrors = true;
            }
            if (!company || !company.value.trim()) {
                showFieldError('company', 'Company name is required');
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
                // KTImageInput not available, continue without it
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

    // Initialize cascading dropdowns
    var initCascadingDropdowns = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            return;
        }

        // Division change handler - attach immediately, not just on modal shown
        $(document).off('change', '#editVisitorModal select[name="division_id"]').on('change', '#editVisitorModal select[name="division_id"]', function() {
            const divisionId = $(this).val();
            const departmentSelect = $('#editVisitorModal select[name="department_id"]');
            const sectionSelect = $('#editVisitorModal select[name="section_id"]');
            const positionSelect = $('#editVisitorModal select[name="position_id"]');
            
            // Reset and disable department, section, and position
            departmentSelect.val('').trigger('change');
            sectionSelect.val('').trigger('change');
            positionSelect.val('').trigger('change');
            
            departmentSelect.prop('disabled', true);
            sectionSelect.prop('disabled', true);
            positionSelect.prop('disabled', true);
            
            if (divisionId) {
                // Load departments for selected division
                $.ajax({
                    url: '<?= base_url("api/departments-by-division") ?>',
                    type: 'GET',
                    data: { division_id: divisionId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.data) {
                            // Clear existing options except the default
                            departmentSelect.find('option:not(:first)').remove();
                            
                            // Add new options
                            $.each(response.data, function(index, department) {
                                departmentSelect.append(
                                    $('<option>', {
                                        value: department.id,
                                        text: department.name
                                    })
                                );
                            });
                            
                            // Enable department select
                            departmentSelect.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading departments:', error, xhr.responseText);
                        // Show user-friendly error message
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to load departments. Please try again.');
                        }
                    }
                });
            }
        });
        
        // Department change handler
        $(document).off('change', '#editVisitorModal select[name="department_id"]').on('change', '#editVisitorModal select[name="department_id"]', function() {
            const departmentId = $(this).val();
            const sectionSelect = $('#editVisitorModal select[name="section_id"]');
            const positionSelect = $('#editVisitorModal select[name="position_id"]');
            
            // Reset and disable section and position
            sectionSelect.val('').trigger('change');
            positionSelect.val('').trigger('change');
            
            sectionSelect.prop('disabled', true);
            positionSelect.prop('disabled', true);
            
            if (departmentId) {
                // Load sections for selected department
                $.ajax({
                    url: '<?= base_url("api/sections-by-department") ?>',
                    type: 'GET',
                    data: { department_id: departmentId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.data) {
                            // Clear existing options except the default
                            sectionSelect.find('option:not(:first)').remove();
                            
                            // Add new options
                            $.each(response.data, function(index, section) {
                                sectionSelect.append(
                                    $('<option>', {
                                        value: section.id,
                                        text: section.name
                                    })
                                );
                            });
                            
                            // Enable section select
                            sectionSelect.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading sections:', error, xhr.responseText);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to load sections. Please try again.');
                        }
                    }
                });
                
                // Load positions with status_id = 3
                $.ajax({
                    url: '<?= base_url("api/positions-by-status") ?>',
                    type: 'GET',
                    data: { status_id: 3 },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.data) {
                            // Clear existing options except the default
                            positionSelect.find('option:not(:first)').remove();
                            
                            // Add new options
                            $.each(response.data, function(index, position) {
                                positionSelect.append(
                                    $('<option>', {
                                        value: position.id,
                                        text: position.name
                                    })
                                );
                            });
                            
                            // Enable position select
                            positionSelect.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading positions:', error, xhr.responseText);
                        if (typeof toastr !== 'undefined') {
                            toastr.error('Failed to load positions. Please try again.');
                        }
                    }
                });
            }
        });
        
        // Reset form when modal is hidden
        $('#editVisitorModal').on('hidden.bs.modal', function() {
            const departmentSelect = $('#editVisitorModal select[name="department_id"]');
            const sectionSelect = $('#editVisitorModal select[name="section_id"]');
            const positionSelect = $('#editVisitorModal select[name="position_id"]');
            
            // Reset and disable dependent dropdowns
            departmentSelect.find('option:not(:first)').remove();
            sectionSelect.find('option:not(:first)').remove();
            positionSelect.find('option:not(:first)').remove();
            
            departmentSelect.prop('disabled', true);
            sectionSelect.prop('disabled', true);
            positionSelect.prop('disabled', true);
        });
    };

    // Populate form with visitor data
    var populateForm = function(visitor) {
        if (!visitor) {
            console.error('Visitor data is required');
            return;
        }

        // Helper function to clear all errors
        function clearAllErrors() {
            if (!form) return;
            
            const fields = form.querySelectorAll('.is-invalid');
            fields.forEach(field => {
                field.classList.remove('is-invalid');
            });
            
            const errorContainers = form.querySelectorAll('.fv-plugins-message-container');
            errorContainers.forEach(container => {
                container.style.display = 'none';
            });
        }

        try {
            // Clear form first
            form.reset();

            // Clear all error states
            clearAllErrors();

            // Populate basic fields that exist in the form
            const fieldMappings = {
                'id': visitor.id,
                'id_pp_wp_no': visitor.id_pp_wp_no || visitor.islander_no || visitor.id_number || visitor.visitor_no,
                'status_id': visitor.status_id,
                'full_name': visitor.full_name || visitor.name,
                'email': visitor.email,
                'phone': visitor.phone,
                'gender_id': visitor.gender_id,
                'nationality_id': visitor.nationality || visitor.nationality_id, // nationality field in DB, nationality_id in form
                'division_id': visitor.division_id,
                'department_id': visitor.department_id,
                'section_id': visitor.section_id,
                'position_id': visitor.position_id,
                'company': visitor.company,
                'role_id': visitor.role_id
            };

            // Populate form fields
            Object.keys(fieldMappings).forEach(fieldName => {
                const field = form.querySelector(`[name="${fieldName}"]`);
                const value = fieldMappings[fieldName];
                
                if (field && value !== undefined && value !== null && value !== '') {
                    try {
                        if (field.type === 'date' && value) {
                            // Handle date fields - ensure proper format
                            const date = new Date(value);
                            if (!isNaN(date.getTime())) {
                                field.value = date.toISOString().split('T')[0];
                            }
                        } else {
                            field.value = value;
                        }
                    } catch (fieldError) {
                        console.error(`Error setting field ${fieldName}:`, fieldError);
                    }
                }
            });

            // Handle profile image if it exists
            const imageField = visitor.image || visitor.profile_image;
            if (imageField && imageField.trim() !== '') {
                try {
                    const profileImagePreview = document.getElementById('edit_profile_image_preview');
                    if (profileImagePreview) {
                        let imageUrl;
                        if (imageField.startsWith('http')) {
                            imageUrl = imageField;
                        } else if (imageField.startsWith('/')) {
                            imageUrl = '<?= base_url() ?>' + imageField;
                        } else {
                            imageUrl = '<?= base_url('assets/media/users/') ?>' + imageField;
                        }
                        profileImagePreview.style.backgroundImage = `url('${imageUrl}')`;
                    }
                } catch (imageError) {
                    console.warn('Error setting profile image:', imageError);
                }
            }

            // Trigger change events for select2 dropdowns after a small delay
            setTimeout(function() {
                try {
                    if (typeof $ !== 'undefined') {
                        // First, set values for non-cascading dropdowns
                        $('#editVisitorModal select[data-control="select2"]').each(function() {
                            const fieldName = $(this).attr('name');
                            const value = fieldMappings[fieldName];
                            
                            // Skip cascading dropdowns for now
                            if (!['division_id', 'department_id', 'section_id', 'position_id'].includes(fieldName)) {
                                if (value) {
                                    $(this).val(value).trigger('change');
                                }
                            }
                        });
                        
                        // Handle cascading dropdown population for edit
                        if (visitor.division_id) {
                            // First populate division, then trigger cascade
                            const divisionSelect = $('#editVisitorModal select[name="division_id"]');
                            if (divisionSelect.length) {
                                divisionSelect.val(visitor.division_id).trigger('change');
                                
                                // Wait for division change to complete and load departments
                                if (visitor.department_id) {
                                    // Use a longer timeout and check for options availability
                                    const checkAndSetDepartment = function(attempts = 0) {
                                        const maxAttempts = 10; // Max 5 seconds wait
                                        const departmentSelect = $('#editVisitorModal select[name="department_id"]');
                                        
                                        if (departmentSelect.find(`option[value="${visitor.department_id}"]`).length > 0) {
                                            // Department option is available, set it
                                            departmentSelect.val(visitor.department_id).trigger('change');
                                            
                                            // Now wait for section/position options to load
                                            if (visitor.section_id || visitor.position_id) {
                                                const checkAndSetSectionPosition = function(attempts = 0) {
                                                    const maxAttempts = 10;
                                                    
                                                    setTimeout(function() {
                                                        if (visitor.section_id) {
                                                            const sectionSelect = $('#editVisitorModal select[name="section_id"]');
                                                            if (sectionSelect.find(`option[value="${visitor.section_id}"]`).length > 0) {
                                                                sectionSelect.val(visitor.section_id).trigger('change');
                                                            } else if (attempts < maxAttempts) {
                                                                checkAndSetSectionPosition(attempts + 1);
                                                                return;
                                                            } else {
                                                                console.warn('Section option not found after waiting:', visitor.section_id);
                                                            }
                                                        }
                                                        
                                                        if (visitor.position_id) {
                                                            const positionSelect = $('#editVisitorModal select[name="position_id"]');
                                                            if (positionSelect.find(`option[value="${visitor.position_id}"]`).length > 0) {
                                                                positionSelect.val(visitor.position_id).trigger('change');
                                                            } else if (attempts < maxAttempts) {
                                                                checkAndSetSectionPosition(attempts + 1);
                                                                return;
                                                            } else {
                                                                console.warn('Position option not found after waiting:', visitor.position_id);
                                                            }
                                                        }
                                                    }, 500);
                                                };
                                                
                                                checkAndSetSectionPosition();
                                            }
                                        } else if (attempts < maxAttempts) {
                                            setTimeout(function() {
                                                checkAndSetDepartment(attempts + 1);
                                            }, 500);
                                        } else {
                                            console.warn('Department option not found after waiting:', visitor.department_id);
                                        }
                                    };
                                    
                                    // Start checking for department options
                                    setTimeout(function() {
                                        checkAndSetDepartment();
                                    }, 1000);
                                }
                            } else {
                                console.warn('Division select not found');
                            }
                        }
                    }
                } catch (select2Error) {
                    console.warn('Error triggering select2 change events:', select2Error);
                }
            }, 200);

        } catch (error) {
            console.error('Error populating visitor form:', error);
        }
    };

    // Helper function to check if all dropdowns are properly populated
    var validateDropdownsPopulated = function() {
        const requiredDropdowns = ['division_id', 'department_id', 'section_id', 'position_id'];
        const missingOptions = [];
        
        requiredDropdowns.forEach(fieldName => {
            const field = form.querySelector(`select[name="${fieldName}"]`);
            if (field) {
                const selectedValue = field.value;
                const hasOptions = field.options.length > 1; // More than just the default option
                
                if (selectedValue && !hasOptions) {
                    missingOptions.push(fieldName);
                }
            }
        });
        
        if (missingOptions.length > 0) {
            console.warn('Some dropdowns are missing options:', missingOptions);
            return false;
        }
        
        return true;
    };

    // Public methods
    return {
        init: function() {
            initModal();
            initForm();
            initSelect2();
            initImageInputs();
            initCascadingDropdowns();
        },
        populateForm: populateForm,
        validateDropdowns: validateDropdownsPopulated,
        show: function() {
            if (modal) {
                modal.show();
            }
        },
        hide: function() {
            if (modal) {
                modal.hide();
            }
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