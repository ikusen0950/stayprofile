<!--begin::Edit Authorization Rule Modal-->
<div class="modal fade" id="editAuthorizationRuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Authorization Rule</h2>
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
                <form id="editAuthorizationRuleForm" class="form">
                    <input type="hidden" id="edit_authorization_rule_id" name="rule_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!--begin::Input group - User-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">User</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_user_id" name="user_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a user..." data-dropdown-parent="#editAuthorizationRuleModal">
                                <option></option>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <option value="<?= esc($user['id']) ?>"><?= esc($user['display_name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group - Rule Type-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Rule Type</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select id="edit_rule_type" name="rule_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Select rule type..." data-dropdown-parent="#editAuthorizationRuleModal" onchange="handleRuleTypeChange('edit')">
                                        <option></option>
                                        <option value="all">All (Admin)</option>
                                        <option value="division">Division</option>
                                        <option value="department">Department</option>
                                        <option value="section">Section</option>
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                            
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <!--begin::Input group - Target Type-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Target Type</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select id="edit_target_type" name="target_type" class="form-select form-select-solid" data-control="select2" data-placeholder="Select target type..." data-dropdown-parent="#editAuthorizationRuleModal">
                                        <option></option>
                                        <option value="both">Both</option>
                                        <option value="islanders">Islanders Only</option>
                                        <option value="visitors">Visitors Only</option>
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Row-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-xl-6">
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Approval Level</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="approval_level" id="edit_approval_level" class="form-select form-select-solid" data-control="select2" data-placeholder="Select approval level..." data-dropdown-parent="#editAuthorizationRuleModal" required>
                                        <option></option>
                                        <option value="no_approval">No Approval Required</option>
                                        <option value="level_1">Level 1 Approval</option>
                                        <option value="level_2">Level 2 Approval</option>
                                        <option value="level_3">Level 3 Approval</option>
                                    </select>
                                    <div class="form-text">Select the required approval level for this authorization rule</div>
                                    <!--end::Select-->
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->

                        <!--begin::Division Selection-->
                        <div class="fv-row mb-7" id="edit_division_container" style="display: none;">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Divisions</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select name="division_ids[]" id="edit_division_ids" class="form-select form-select-solid" data-control="select2" data-placeholder="Select divisions..." data-dropdown-parent="#editAuthorizationRuleModal" multiple onchange="handleDivisionChange('edit')">
                                <?php if (!empty($divisions)): ?>
                                    <?php foreach ($divisions as $division): ?>
                                        <option value="<?= esc($division['id']) ?>"><?= esc($division['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Select one or more divisions for this rule</div>
                            <!--end::Select-->
                        </div>
                        <!--end::Division Selection-->

                        <!--begin::Department Selection-->
                        <div class="fv-row mb-7" id="edit_department_container" style="display: none;">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Departments</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select name="department_ids[]" id="edit_department_ids" class="form-select form-select-solid" data-control="select2" data-placeholder="Select departments..." data-dropdown-parent="#editAuthorizationRuleModal" multiple onchange="handleDepartmentChange('edit')">
                                <?php if (!empty($departments)): ?>
                                    <?php foreach ($departments as $department): ?>
                                        <option value="<?= esc($department['id']) ?>"><?= esc($department['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Select one or more departments for this rule</div>
                            <!--end::Select-->
                        </div>
                        <!--end::Department Selection-->

                        <!--begin::Section Selection-->
                        <div class="fv-row mb-7" id="edit_section_container" style="display: none;">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Sections</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select name="section_ids[]" id="edit_section_ids" class="form-select form-select-solid" data-control="select2" data-placeholder="Select sections..." data-dropdown-parent="#editAuthorizationRuleModal" multiple>
                                <?php if (!empty($sections)): ?>
                                    <?php foreach ($sections as $section): ?>
                                        <option value="<?= esc($section['id']) ?>"><?= esc($section['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Select one or more sections for this rule</div>
                            <!--end::Select-->
                        </div>
                        <!--end::Section Selection-->

                        <!--begin::Row-->
                        <div class="row">
                            <!--begin::Col-->
                            <div class="col-md-8">
                                <!--begin::Input group - Description-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea id="edit_description" name="description" class="form-control form-control-solid" rows="4" placeholder="Enter authorization rule description (optional)"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                            
                            <!--begin::Col-->
                            <div class="col-md-4">
                                <!--begin::Input group - Status-->
                                <div class="fv-row mb-7">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select id="edit_is_active" name="is_active" class="form-select form-select-solid" data-control="select2" data-placeholder="Select status..." data-dropdown-parent="#editAuthorizationRuleModal">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Row-->
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
                <button type="button" class="btn btn-primary" id="editAuthorizationRuleSubmitBtn">
                    <span class="indicator-label">Update Authorization Rule</span>
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
<!--end::Edit Authorization Rule Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editAuthorizationRuleForm');
    const editModal = document.getElementById('editAuthorizationRuleModal');
    const submitBtn = document.getElementById('editAuthorizationRuleSubmitBtn');
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const ruleId = document.getElementById('edit_authorization_rule_id')?.value;
            if (!ruleId) {
                Swal.fire('Error', 'Authorization Rule ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(editForm);
            
            fetch(`/authorization-rules/update/${ruleId}`, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.status === 401 || response.status === 403) {
                    // Session expired - redirect to login
                    window.location.href = '/login';
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
                Swal.fire('Error', 'Failed to update authorization rule', 'error');
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
            
            // Reset rule type specific containers
            handleRuleTypeChange('edit');
            
            // Clear any validation states
            const inputs = editForm.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            
            // Reset Select2 elements
            if (typeof $ !== 'undefined') {
                $(editForm).find('select[data-control="select2"]').val(null).trigger('change');
            }
        });
    }
});

// Function to populate edit modal (called from index.php)
function populateEditAuthorizationRuleModal(rule) {
    document.getElementById('edit_authorization_rule_id').value = rule.id;
    document.getElementById('edit_user_id').value = rule.user_id;
    document.getElementById('edit_rule_type').value = rule.rule_type;
    document.getElementById('edit_target_type').value = rule.target_type;
    document.getElementById('edit_approval_level').value = rule.approval_level || 'no_approval';
    document.getElementById('edit_description').value = rule.description || '';
    document.getElementById('edit_is_active').value = rule.is_active;
    
    // Handle rule type specific fields
    handleRuleTypeChange('edit');
    
    // Trigger Select2 updates for basic fields
    if (typeof $ !== 'undefined') {
        $('#edit_user_id').trigger('change');
        $('#edit_rule_type').trigger('change');
        $('#edit_target_type').trigger('change');
        $('#edit_approval_level').trigger('change');
        $('#edit_is_active').trigger('change');
    }
    
    // Set specific ID arrays after rule type is handled
    setTimeout(() => {
        if (typeof $ !== 'undefined') {
            // Set division IDs if available
            if (rule.division_ids && rule.division_ids.length > 0) {
                $('#edit_division_ids').val(rule.division_ids).trigger('change');
            }
            
            // Set department IDs if available
            if (rule.department_ids && rule.department_ids.length > 0) {
                $('#edit_department_ids').val(rule.department_ids).trigger('change');
            }
            
            // Set section IDs if available
            if (rule.section_ids && rule.section_ids.length > 0) {
                $('#edit_section_ids').val(rule.section_ids).trigger('change');
            }
        }
    }, 100);
}
</script>