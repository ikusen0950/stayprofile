<!--begin::Modal - Edit Islander-->
<div class="modal fade" id="editIslanderModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="editIslanderModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Islander</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-islanders-modal-action="close">
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
                <form id="editIslanderModal_form" class="form" action="#">
                    <input type="hidden" name="id" id="edit_islander_id" value="">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="editIslanderModal_scroll"
                        data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                        data-kt-scroll-dependencies="#editIslanderModal_header"
                        data-kt-scroll-wrappers="#editIslanderModal_scroll" data-kt-scroll-offset="300px">

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
                                    <label class="fs-6 fw-semibold mb-2 required">Islander #</label>
                                    <small>(This will be the username.)</small>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="islander_no" id="edit_islander_no"
                                        class="form-control form-control-solid mb-3 mb-lg-0"
                                        placeholder="Enter islander number" value="" />
                                    <div class="fv-plugins-message-container invalid-feedback">
                                        <div class="fv-help-block" data-field="islander_no"></div>
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
                                        data-dropdown-parent="#editIslanderModal">
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
        <!--end::Input group-->                        <!--begin::Input group-->
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
                                    data-placeholder="Select gender" data-dropdown-parent="#editIslanderModal" required>
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
                                    data-dropdown-parent="#editIslanderModal" required>
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
                        <h4 class="fw-bold text-gray-800">Work Informations</h4>
                        <div class="separator separator-dashed mt-2 mb-7"></div>


                        <!--begin::Input group-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Division</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="division_id" id="edit_division_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select division"
                                    data-dropdown-parent="#editIslanderModal" required>
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
                                    data-dropdown-parent="#editIslanderModal" disabled required>
                                    <option value="">Select Division First</option>
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
                                <select name="section_id" id="edit_section_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select section"
                                    data-dropdown-parent="#editIslanderModal" disabled required>
                                    <option value="">Select Department First</option>
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
                                    data-dropdown-parent="#editIslanderModal" disabled required>
                                    <option value="">Select Section First</option>
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
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">House</label>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select name="house_id" id="edit_house_id" class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select house" data-dropdown-parent="#editIslanderModal" required>
                                    <option value="">Select House</option>
                                    <?php if (!empty($houses)): ?>
                                    <?php foreach ($houses as $house): ?>
                                    <option value="<?= esc($house['id']) ?>"><?= esc($house['name']) ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="house_id"></div>
                                </div>
                                <!--end::Select-->
                            </div>
                            <!--end::Col-->
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Join Date</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="date" name="join_date" id="edit_join_date" class="form-control form-control-solid"
                                    placeholder="Select join date" value="" required />
                                <div class="fv-plugins-message-container invalid-feedback">
                                    <div class="fv-help-block" data-field="join_date"></div>
                                </div>
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
                                    data-placeholder="Select role" data-dropdown-parent="#editIslanderModal" required>
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
                <button type="reset" id="kt_islanders_edit_cancel" class="btn btn-light me-3">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="submit" id="kt_islanders_edit_submit" class="btn btn-primary">
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
<!--end::Modal - Edit Islander-->

<script>
"use strict";

// Class definition
var EditIslanderModal = function() {
    var modal;
    var form;
    var submitButton;
    var cancelButton;
    var validator;

    // Initialize modal
    var initModal = function() {
        modal = new bootstrap.Modal(document.querySelector('#editIslanderModal'));
    };

    // Initialize form
    var initForm = function() {
        form = document.querySelector('#editIslanderModal_form');
        submitButton = document.querySelector('#kt_islanders_edit_submit');
        cancelButton = document.querySelector('#kt_islanders_edit_cancel');

        // Check if required elements exist
        if (!form || !submitButton || !cancelButton) {
            return;
        }

        // Try to initialize FormValidation if available
        try {
            if (typeof FormValidation !== 'undefined') {
                validator = FormValidation.formValidation(form, {
                    fields: {
                        'islander_no': {
                            validators: {
                                notEmpty: {
                                    message: 'Islander number is required'
                                }
                            }
                        },
                        'id_pp_wp_no': {
                            validators: {
                                notEmpty: {
                                    message: 'NID/PP/WP number is required'
                                }
                            }
                        },
                        'status_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Status is required'
                                }
                            }
                        },
                        'full_name': {
                            validators: {
                                notEmpty: {
                                    message: 'Full name is required'
                                }
                            }
                        },
                        'email': {
                            validators: {
                                notEmpty: {
                                    message: 'Email is required'
                                },
                                emailAddress: {
                                    message: 'Please enter a valid email address'
                                }
                            }
                        },
                        'phone': {
                            validators: {
                                notEmpty: {
                                    message: 'Phone number is required'
                                }
                            }
                        },
                        'gender_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Gender is required'
                                }
                            }
                        },
                        'nationality_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Nationality is required'
                                }
                            }
                        },
                        'date_of_birth': {
                            validators: {
                                notEmpty: {
                                    message: 'Date of birth is required'
                                }
                            }
                        },
                        'division_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Division is required'
                                }
                            }
                        },
                        'department_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Department is required'
                                }
                            }
                        },
                        'section_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Section is required'
                                }
                            }
                        },
                        'position_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Position is required'
                                }
                            }
                        },
                        'house_id': {
                            validators: {
                                notEmpty: {
                                    message: 'House is required'
                                }
                            }
                        },
                        'join_date': {
                            validators: {
                                notEmpty: {
                                    message: 'Join date is required'
                                }
                            }
                        },
                        'role_id': {
                            validators: {
                                notEmpty: {
                                    message: 'Role is required'
                                }
                            }
                        }
                    },
                    plugins: {
                        trigger: new FormValidation.plugins.Trigger(),
                        bootstrap: new FormValidation.plugins.Bootstrap5({
                            rowSelector: '.fv-row',
                            eleInvalidClass: '',
                            eleValidClass: ''
                        })
                    }
                });
            }
        } catch (error) {
            validator = null;
        }

        // Handle form submission
        submitButton.addEventListener('click', function(e) {
            e.preventDefault();

            if (validator) {
                validator.validate().then(function(status) {
                    if (status == 'Valid') {
                        submitForm();
                    } else {
                        if (validateForm()) {
                            submitForm();
                        }
                    }
                });
            } else {
                if (validateForm()) {
                    submitForm();
                }
            }
        });

        // Manual validation function
        function validateForm() {
            clearAllErrors();

            // Get form elements
            const islanderNo = form.querySelector('input[name="islander_no"]');
            const idPpWpNo = form.querySelector('input[name="id_pp_wp_no"]');
            const statusId = form.querySelector('select[name="status_id"]');
            const fullName = form.querySelector('input[name="full_name"]');
            const email = form.querySelector('input[name="email"]');
            const phone = form.querySelector('input[name="phone"]');
            const genderId = form.querySelector('select[name="gender_id"]');
            const nationalityId = form.querySelector('select[name="nationality_id"]');
            const dateOfBirth = form.querySelector('input[name="date_of_birth"]');
            const divisionId = form.querySelector('select[name="division_id"]');
            const departmentId = form.querySelector('select[name="department_id"]');
            const sectionId = form.querySelector('select[name="section_id"]');
            const positionId = form.querySelector('select[name="position_id"]');
            const houseId = form.querySelector('select[name="house_id"]');
            const joinDate = form.querySelector('input[name="join_date"]');
            const roleId = form.querySelector('select[name="role_id"]');

            let hasErrors = false;

            // Check all required fields and show errors
            if (!islanderNo || !islanderNo.value.trim()) {
                showFieldError('islander_no', 'Islander number is required');
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
            if (!dateOfBirth || !dateOfBirth.value.trim()) {
                showFieldError('date_of_birth', 'Date of birth is required');
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
            if (!houseId || !houseId.value) {
                showFieldError('house_id', 'House is required');
                hasErrors = true;
            }
            if (!joinDate || !joinDate.value.trim()) {
                showFieldError('join_date', 'Join date is required');
                hasErrors = true;
            }
            if (!roleId || !roleId.value) {
                showFieldError('role_id', 'Role is required');
                hasErrors = true;
            }

            if (hasErrors) {
                return false;
            }

            return true;
        }

        // Helper function to show field error
        function showFieldError(fieldName, message) {
            const field = form.querySelector(`[name="${fieldName}"]`);
            const errorContainer = form.querySelector(`[data-field="${fieldName}"]`);
            
            if (field && errorContainer) {
                // Add error class to field
                field.classList.add('is-invalid');
                
                // Show error message
                errorContainer.textContent = message;
                errorContainer.style.display = 'block';
            }
        }

        // Helper function to clear all errors
        function clearAllErrors() {
            // Remove error classes from all fields
            const fields = form.querySelectorAll('.is-invalid');
            fields.forEach(field => {
                field.classList.remove('is-invalid');
            });

            // Clear all error messages
            const errorContainers = form.querySelectorAll('[data-field]');
            errorContainers.forEach(container => {
                container.textContent = '';
                container.style.display = 'none';
            });
        }

        // Email validation helper
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
                    clearAllErrors();
                    modal.hide();
                }
            });
        });

        // Handle modal close
        document.querySelector('#editIslanderModal [data-kt-islanders-modal-action="close"]').addEventListener('click', function(e) {
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
                    clearAllErrors();
                    modal.hide();
                }
            });
        });
    };

    // Submit form with AJAX
    var submitForm = function() {
        submitButton.setAttribute('data-kt-indicator', 'on');
        submitButton.disabled = true;

        const formData = new FormData(form);
        const islanderId = document.getElementById('edit_islander_id').value;

        $.ajax({
            url: `<?= base_url('islanders') ?>/${islanderId}/update`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function() {
                // Request started
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        text: response.message || "Islander has been successfully updated!",
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
                    let errorMessage = response.message ||
                        'An error occurred while updating the islander.';

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
                let errorMessage = 'An error occurred while updating the islander.';
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
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            // jQuery not available, skipping Select2 initialization
            return;
        }

        $('#editIslanderModal').on('shown.bs.modal', function() {
            // Initialize Select2 for all select elements in the modal
            $(this).find('select[data-control="select2"]').each(function() {
                if (!$(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2({
                        dropdownParent: $('#editIslanderModal')
                    });
                }
            });
        });

        // Destroy Select2 when modal is hidden
        $('#editIslanderModal').on('hidden.bs.modal', function() {
            $(this).find('select[data-control="select2"]').each(function() {
                if ($(this).hasClass('select2-hidden-accessible')) {
                    $(this).select2('destroy');
                }
            });
        });
    };

    // Initialize cascading dropdowns for edit modal
    var initCascadingDropdowns = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            // jQuery not available, skipping cascading dropdown initialization
            return;
        }

        // Division change handler
        $(document).on('change', '#edit_division_id', function() {
            const divisionId = $(this).val();
            const $departmentSelect = $('#edit_department_id');
            const $sectionSelect = $('#edit_section_id');
            const $positionSelect = $('#edit_position_id');

            // Reset dependent dropdowns
            resetDropdown($departmentSelect, 'Select Division First', !divisionId);
            resetDropdown($sectionSelect, 'Select Department First', true);
            resetDropdown($positionSelect, 'Select Section First', true);

            if (divisionId) {
                // Enable and load departments
                loadDepartments(divisionId);
            }
        });

        // Department change handler
        $(document).on('change', '#edit_department_id', function() {
            const departmentId = $(this).val();
            const $sectionSelect = $('#edit_section_id');
            const $positionSelect = $('#edit_position_id');

            // Reset dependent dropdowns
            resetDropdown($sectionSelect, 'Select Department First', !departmentId);
            resetDropdown($positionSelect, 'Select Section First', true);

            if (departmentId) {
                // Enable and load sections
                loadSections(departmentId);
            }
        });

        // Section change handler
        $(document).on('change', '#edit_section_id', function() {
            const sectionId = $(this).val();
            const $positionSelect = $('#edit_position_id');

            // Reset dependent dropdown
            resetDropdown($positionSelect, 'Select Section First', !sectionId);

            if (sectionId) {
                // Enable and load positions
                loadPositions(sectionId);
            }
        });
    };

    // Helper function to reset dropdown
    var resetDropdown = function($select, placeholder, disable = false) {
        if ($select.hasClass('select2-hidden-accessible')) {
            $select.val('').trigger('change');
            $select.empty().append('<option value="">' + placeholder + '</option>');
            $select.prop('disabled', disable);
        } else {
            $select.empty().append('<option value="">' + placeholder + '</option>');
            $select.prop('disabled', disable);
        }
    };

    // Load departments by division
    var loadDepartments = function(divisionId) {
        const $departmentSelect = $('#edit_department_id');

        // Show loading state
        $departmentSelect.empty().append('<option value="">Loading departments...</option>');
        $departmentSelect.prop('disabled', false);

        $.ajax({
            url: '<?= base_url('islanders/departments-by-division') ?>',
            type: 'GET',
            data: {
                division_id: divisionId
            },
            dataType: 'json',
            success: function(departments) {
                $departmentSelect.empty().append('<option value="">Select Department</option>');

                if (departments && departments.length > 0) {
                    $.each(departments, function(index, department) {
                        $departmentSelect.append('<option value="' + department.id + '">' + department.name + '</option>');
                    });
                } else {
                    $departmentSelect.append('<option value="">No departments available</option>');
                }

                // Trigger change for Select2
                if ($departmentSelect.hasClass('select2-hidden-accessible')) {
                    $departmentSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                $departmentSelect.empty().append('<option value="">Error loading departments</option>');
            }
        });
    };

    // Load sections by department
    var loadSections = function(departmentId) {
        const $sectionSelect = $('#edit_section_id');

        // Show loading state
        $sectionSelect.empty().append('<option value="">Loading sections...</option>');
        $sectionSelect.prop('disabled', false);

        $.ajax({
            url: '<?= base_url('islanders/sections-by-department') ?>',
            type: 'GET',
            data: {
                department_id: departmentId
            },
            dataType: 'json',
            success: function(sections) {
                $sectionSelect.empty().append('<option value="">Select Section</option>');

                if (sections && sections.length > 0) {
                    $.each(sections, function(index, section) {
                        $sectionSelect.append('<option value="' + section.id + '">' + section.name + '</option>');
                    });
                } else {
                    $sectionSelect.append('<option value="">No sections available</option>');
                }

                // Trigger change for Select2
                if ($sectionSelect.hasClass('select2-hidden-accessible')) {
                    $sectionSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                $sectionSelect.empty().append('<option value="">Error loading sections</option>');
            }
        });
    };

    // Load positions by section
    var loadPositions = function(sectionId) {
        const $positionSelect = $('#edit_position_id');

        // Show loading state
        $positionSelect.empty().append('<option value="">Loading positions...</option>');
        $positionSelect.prop('disabled', false);

        $.ajax({
            url: '<?= base_url('islanders/positions-by-section') ?>',
            type: 'GET',
            data: {
                section_id: sectionId
            },
            dataType: 'json',
            success: function(positions) {
                $positionSelect.empty().append('<option value="">Select Position</option>');

                if (positions && positions.length > 0) {
                    $.each(positions, function(index, position) {
                        $positionSelect.append('<option value="' + position.id + '">' + position.name + '</option>');
                    });
                } else {
                    $positionSelect.append('<option value="">No positions available</option>');
                }

                // Trigger change for Select2
                if ($positionSelect.hasClass('select2-hidden-accessible')) {
                    $positionSelect.trigger('change');
                }
            },
            error: function(xhr, status, error) {
                $positionSelect.empty().append('<option value="">Error loading positions</option>');
            }
        });
    };

    // Initialize image inputs
    var initImageInputs = function() {
        // Check if jQuery is available
        if (typeof $ === 'undefined') {
            // jQuery not available, skipping image input validation
            return;
        }

        // Initialize KTImageInput for image uploads
        if (typeof KTImageInput !== 'undefined') {
            try {
                KTImageInput.createInstances('#editIslanderModal [data-kt-image-input="true"]');
            } catch (e) {
                // KTImageInput not available
            }
        }

        // File validation for image uploads
        $('#editIslanderModal input[name="profile_image"]')
            .on('change', function() {
                const file = this.files[0];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                const allowedTypes = ['image/png', 'image/jpg', 'image/jpeg', 'image/gif'];

                if (file) {
                    // Check file size
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

                    // Check file type
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

    // Populate form with islander data
    var populateForm = function(islander) {
        // Basic field population
        document.getElementById('edit_islander_id').value = islander.id || '';
        document.getElementById('edit_islander_no').value = islander.islander_no || '';
        document.getElementById('edit_id_pp_wp_no').value = islander.id_pp_wp_no || '';
        document.getElementById('edit_full_name').value = islander.full_name || '';
        document.getElementById('edit_email').value = islander.email || '';
        document.getElementById('edit_phone').value = islander.phone || '';
        document.getElementById('edit_address').value = islander.address || '';
        document.getElementById('edit_notes').value = islander.notes || '';

        // Handle password field (leave empty for security - user can change if needed)
        document.getElementById('edit_password').value = '';

        // Handle date fields
        if (islander.date_of_birth) {
            document.getElementById('edit_date_of_birth').value = islander.date_of_birth;
        }
        if (islander.date_of_joining) {
            document.getElementById('edit_join_date').value = islander.date_of_joining;
        }

        // Wait for Select2 to be fully initialized before setting values
        setTimeout(function() {
            // Handle non-cascading selects first
            if (islander.gender_id) {
                $('#edit_gender_id').val(islander.gender_id).trigger('change');
            }
            if (islander.house_id) {
                $('#edit_house_id').val(islander.house_id).trigger('change');
            }
            // Handle nationality with fallback field names
            if (islander.nationality_id) {
                $('#edit_nationality_id').val(islander.nationality_id).trigger('change');
            } else if (islander.nationality) {
                $('#edit_nationality_id').val(islander.nationality).trigger('change');
            }
            if (islander.status_id) {
                $('#edit_status_id').val(islander.status_id).trigger('change');
            }
            if (islander.role_id) {
                $('#edit_role_id').val(islander.role_id).trigger('change');
            }
        }, 200);

        // Handle cascading dropdowns with proper sequencing
        setTimeout(function() {
            // Set division first
            if (islander.division_id) {
                $('#edit_division_id').val(islander.division_id).trigger('change');

                // Wait for departments to load, then set department
                if (islander.department_id) {
                    setTimeout(function() {
                        $('#edit_department_id').val(islander.department_id).trigger('change');

                        // Wait for sections to load, then set section
                        if (islander.section_id) {
                            setTimeout(function() {
                                $('#edit_section_id').val(islander.section_id).trigger('change');

                                // Wait for positions to load, then set position
                                if (islander.position_id) {
                                    setTimeout(function() {
                                        $('#edit_position_id').val(islander.position_id).trigger('change');
                                    }, 300);
                                }
                            }, 300);
                        }
                    }, 300);
                }
            }
        }, 300);

        // Handle existing images
        if (islander.image) {
            // Check if the image path already includes the base path
            let profileImageUrl;
            if (islander.image.startsWith('assets/media/users/') || islander.image.startsWith('uploads/islanders/')) {
                profileImageUrl = '<?= base_url() ?>/' + islander.image;
            } else {
                // Fallback for legacy images
                profileImageUrl = '<?= base_url('assets/media/users/') ?>' + islander.image;
            }
            document.getElementById('edit_profile_image_preview').style.backgroundImage = `url('${profileImageUrl}')`;
        }
    };

    // Public methods
    return {
        init: function() {
            initModal();
            initForm();
            initSelect2();
            initCascadingDropdowns();
            initImageInputs();
        },
        populateForm: function(islander) {
            populateForm(islander);
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function() {
        EditIslanderModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            EditIslanderModal.init();
        } else {
            // Initialize anyway
            EditIslanderModal.init();
        }
    });
}
</script>