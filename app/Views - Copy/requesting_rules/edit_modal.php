<!--begin::Edit Requesting Rule Modal-->
<style>
/* Fullscreen modals on mobile */
@media (max-width: 767.98px) {
    #editAuthorizationRuleModal .modal-dialog {
        margin: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        height: 100% !important;
        max-height: 100% !important;
    }

    #editAuthorizationRuleModal .modal-content {
        height: 100vh !important;
        border: none !important;
        border-radius: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    #editAuthorizationRuleModal .modal-body {
        flex: 1 !important;
        overflow-y: auto !important;
        padding: 1rem !important;
    }

    #editAuthorizationRuleModal .modal-header {
        padding: 1rem !important;
        border-bottom: 1px solid var(--bs-border-color) !important;
        flex-shrink: 0 !important;
    }

    #editAuthorizationRuleModal .modal-footer {
        padding: 1rem !important;
        border-top: 1px solid var(--bs-border-color) !important;
        flex-shrink: 0 !important;
    }

    /* Ensure modal backdrop doesn't interfere */
    #editAuthorizationRuleModal .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
}

/* Better Select2 dropdown positioning in modals */
.select2-container--bootstrap5 .select2-dropdown {
    z-index: 1060;
}
</style>

<div class="modal fade" id="editAuthorizationRuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Requesting Rule</h2>
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
                            <div class="form-text">Each user can have only one Requesting Rule. If a user already has a rule, please edit the existing one.</div>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Multiple Rules Section-->
                        <div class="mb-7">
                            <!--begin::Section Header-->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold text-gray-900 mb-0">Requesting Rules</h5>
                                <button type="button" class="btn btn-sm btn-light-primary" id="editAddRuleBtn">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                    Add Rule
                                </button>
                            </div>
                            <!--end::Section Header-->
                            
                            <!--begin::Rules Container-->
                            <div id="editRulesContainer">
                                <!-- Rules will be added dynamically here -->
                            </div>
                            <!--end::Rules Container-->
                        </div>
                        <!--end::Multiple Rules Section-->

                        <!--begin::Global Settings-->
                        <div class="row mb-7">
                            
                                <!--begin::Input group - Description-->
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Description</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <textarea id="edit_description" name="description" class="form-control form-control-solid" rows="3" placeholder="Enter general description for all rules (optional)"></textarea>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                            
                            
                           
                        </div>
                        <!--end::Global Settings-->


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
                    <span class="indicator-label">Update Requesting Rules</span>
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
<!--end::Edit Requesting Rule Modal-->

<script>
// Global variables for edit modal multi-rule management
let editRuleCounter = 0;
const editDivisions = <?= json_encode($divisions ?? []) ?>;
const editDepartments = <?= json_encode($departments ?? []) ?>;
const editSections = <?= json_encode($sections ?? []) ?>;

document.addEventListener('DOMContentLoaded', function() {
    const editForm = document.getElementById('editAuthorizationRuleForm');
    const editModal = document.getElementById('editAuthorizationRuleModal');
    const submitBtn = document.getElementById('editAuthorizationRuleSubmitBtn');
    const addRuleBtn = document.getElementById('editAddRuleBtn');
    
    // Add rule button functionality
    if (addRuleBtn) {
        addRuleBtn.addEventListener('click', function() {
            addNewEditRule();
        });
    }
    
    if (editForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const ruleId = document.getElementById('edit_authorization_rule_id')?.value;
            if (!ruleId) {
                Swal.fire('Error', 'Requesting Rule ID not found', 'error');
                return;
            }
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            // Collect multiple rules data
            const rulesData = collectEditRulesData();
            
            if (!rulesData || rulesData.length === 0) {
                Swal.fire('Error', 'Please add at least one Requesting Rule', 'error');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            const formData = new FormData();
            formData.append('user_id', document.getElementById('edit_user_id').value);
            formData.append('description', document.getElementById('edit_description').value);
            formData.append('is_active', document.getElementById('edit_is_active').value);
            formData.append('rules', JSON.stringify(rulesData));
            
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
                    // Clear previous validation states
                    clearEditValidationErrors();
                    
                    // Show validation errors below each field
                    if (data.errors) {
                        showEditValidationErrors(data.errors);
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Failed to update Requesting Rule', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
            });
        });
    }
    
    // Initialize Select2 when modal is shown
    if (editModal) {
        editModal.addEventListener('shown.bs.modal', function () {// Initialize Select2 for edit modal
            if (typeof $ !== 'undefined') {
                $(editForm).find('select[data-control="select2"]').each(function() {
                    const $select = $(this);
                    if (!$select.hasClass('select2-hidden-accessible')) {$select.select2({
                            dropdownParent: $('#editAuthorizationRuleModal'),
                            width: '100%'
                        });
                    }
                });
                
                // Trigger a small delay to ensure Select2 is fully ready
                setTimeout(() => {
                }, 100);
            }
        });
    }
    
    // Reset form when modal is hidden
    if (editModal) {
        editModal.addEventListener('hidden.bs.modal', function () {
            editForm.reset();
            
            // Clear all rules and reset counter
            document.getElementById('editRulesContainer').innerHTML = '';
            editRuleCounter = 0;
            
            // Clear all validation errors
            clearEditValidationErrors();
            
            // Reset Select2 elements
            if (typeof $ !== 'undefined') {
                $(editForm).find('select[data-control="select2"]').val(null).trigger('change');
            }
        });
    }
});

// Add new rule function for edit modal
function addNewEditRule() {
    editRuleCounter++;
    const ruleId = `edit_rule_${editRuleCounter}`;
    
    const ruleHtml = `
        <div class="rule-item border border-gray-300 rounded p-4 mb-4" id="${ruleId}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-gray-700 mb-0">Rule ${editRuleCounter}</h6>
                <button type="button" class="btn btn-sm btn-light-danger" onclick="removeEditRule('${ruleId}')">
                    <i class="ki-duotone ki-trash fs-5"></i>
                    Remove
                </button>
            </div>
            
            <div class="row">
                <!-- Rule Type -->
                <div class="col-md-4 mb-4">
                    <div class="fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Rule Type</label>
                        <select name="rules[${editRuleCounter}][rule_type]" class="form-select form-select-solid edit-rule-type-select" data-control="select2" data-placeholder="Select rule type..." data-dropdown-parent="#editAuthorizationRuleModal" onchange="handleEditRuleTypeChange('${ruleId}')">
                            <option value="">Select Rule Type</option>
                            <option value="all">All (Admin)</option>
                            <option value="division">Division</option>
                            <option value="department">Department</option>
                            <option value="section">Section</option>
                        </select>
                    </div>
                </div>
                
                <!-- Target Type -->
                <div class="col-md-4 mb-4">
                    <div class="fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Target Type</label>
                        <select name="rules[${editRuleCounter}][target_type]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select target type..." data-dropdown-parent="#editAuthorizationRuleModal">
                            <option value="">Select Target Type</option>
                            <option value="both">Both</option>
                            <option value="islanders">Islanders Only</option>
                            <option value="visitors">Visitors Only</option>
                        </select>
                    </div>
                </div>
                
                <!-- Approval Level -->
                <div class="col-md-4 mb-4">
                    <div class="fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Approval Level</label>
                        <select name="rules[${editRuleCounter}][approval_level]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select approval level..." data-dropdown-parent="#editAuthorizationRuleModal">
                            <option value="">Select Approval Level</option>
                            <option value="no_approval" selected>No Approval Required</option>
                            <option value="level_1">Level 1 Approval</option>
                            <option value="level_2">Level 2 Approval</option>
                            <option value="level_3">Level 3 Approval</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <!-- Dynamic Selections -->
            <div class="row">
                <!-- Divisions -->
                <div class="col-12 mb-4" id="${ruleId}_division_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Divisions</label>
                    <select name="rules[${editRuleCounter}][division_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select divisions..." data-dropdown-parent="#editAuthorizationRuleModal" multiple>
                        ${generateEditDivisionOptions()}
                    </select>
                </div>
                
                <!-- Departments -->
                <div class="col-12 mb-4" id="${ruleId}_department_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Departments</label>
                    <select name="rules[${editRuleCounter}][department_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select departments..." data-dropdown-parent="#editAuthorizationRuleModal" multiple>
                        ${generateEditDepartmentOptions()}
                    </select>
                </div>
                
                <!-- Sections -->
                <div class="col-12 mb-4" id="${ruleId}_section_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Sections</label>
                    <select name="rules[${editRuleCounter}][section_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select sections..." data-dropdown-parent="#editAuthorizationRuleModal" multiple>
                        ${generateEditSectionOptions()}
                    </select>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('editRulesContainer').insertAdjacentHTML('beforeend', ruleHtml);
    
    // Initialize Select2 for the new elements
    if (typeof $ !== 'undefined') {
        setTimeout(() => {
            $(`#${ruleId} select[data-control="select2"]`).each(function() {
                const $select = $(this);
                if (!$select.hasClass('select2-hidden-accessible')) {
                    $select.select2({
                        dropdownParent: $('#editAuthorizationRuleModal'),
                        width: '100%'
                    });
                }
            });
        }, 100);
    }
}

// Remove rule function for edit modal
function removeEditRule(ruleId) {
    const ruleElement = document.getElementById(ruleId);
    if (ruleElement) {
        ruleElement.remove();
    }
    
    // If no rules left, add one
    if (document.getElementById('editRulesContainer').children.length === 0) {
        addNewEditRule();
    }
}

// Generate options functions for edit modal
function generateEditDivisionOptions() {
    return editDivisions.map(division => 
        `<option value="${division.id}">${division.name}</option>`
    ).join('');
}

function generateEditDepartmentOptions() {
    return editDepartments.map(department => 
        `<option value="${department.id}">${department.name}</option>`
    ).join('');
}

function generateEditSectionOptions() {
    return editSections.map(section => 
        `<option value="${section.id}">${section.name}</option>`
    ).join('');
}

// Handle rule type changes for dynamic rules in edit modal
function handleEditRuleTypeChange(ruleId) {
    const ruleElement = document.getElementById(ruleId);
    const ruleTypeSelect = ruleElement.querySelector('.edit-rule-type-select');
    const ruleType = ruleTypeSelect.value;
    
    // Get containers
    const divisionContainer = document.getElementById(`${ruleId}_division_container`);
    const departmentContainer = document.getElementById(`${ruleId}_department_container`);
    const sectionContainer = document.getElementById(`${ruleId}_section_container`);
    
    // Hide all containers
    divisionContainer.style.display = 'none';
    departmentContainer.style.display = 'none';
    sectionContainer.style.display = 'none';
    
    // Show appropriate container based on rule type
    switch(ruleType) {
        case 'division':
            divisionContainer.style.display = 'block';
            break;
        case 'department':
            departmentContainer.style.display = 'block';
            break;
        case 'section':
            sectionContainer.style.display = 'block';
            break;
        case 'all':
            // No additional selections needed
            break;
    }
}

// Clear validation errors for edit modal
function clearEditValidationErrors() {
    // Remove all validation classes and error messages
    const form = document.getElementById('editAuthorizationRuleForm');
    
    // Clear field validation states
    const inputs = form.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.classList.remove('is-invalid', 'is-valid');
        
        // Remove existing error messages
        const existingError = input.parentElement.querySelector('.invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
    });
    
    // Clear rule-specific errors
    const ruleElements = document.querySelectorAll('.rule-item');
    ruleElements.forEach(ruleElement => {
        // Remove border error styling from rule container
        ruleElement.classList.remove('border-danger');
        
        const ruleInputs = ruleElement.querySelectorAll('.form-select');
        ruleInputs.forEach(input => {
            input.classList.remove('is-invalid');
            // Look for error message in fv-row or parent element
            const fvRow = input.closest('.fv-row') || input.parentElement;
            const existingError = fvRow.querySelector('.invalid-feedback');
            if (existingError) {
                existingError.remove();
            }
        });
    });
}

// Show validation errors below each field for edit modal
function showEditValidationErrors(errors) {
    // Handle main form field errors
    for (const fieldName in errors) {
        if (fieldName.startsWith('Rule ')) {
            // Handle rule-specific errors
            showEditRuleValidationErrors(fieldName, errors[fieldName]);
        } else {
            // Handle main form errors (user_id, description, is_active)
            const field = document.querySelector(`#edit_${fieldName}`) || document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                showEditFieldError(field, errors[fieldName]);
            }
        }
    }
}

// Show error for a specific field in edit modal
function showEditFieldError(field, errorMessage) {
    field.classList.add('is-invalid');
    
    // Create error message element
    const errorDiv = document.createElement('div');
    errorDiv.classList.add('invalid-feedback');
    errorDiv.style.display = 'block';
    errorDiv.textContent = Array.isArray(errorMessage) ? errorMessage[0] : errorMessage;
    
    // Insert error message in the appropriate container (fv-row or parent)
    const container = field.closest('.fv-row') || field.parentElement;
    container.appendChild(errorDiv);
}

// Show rule-specific validation errors for edit modal
function showEditRuleValidationErrors(ruleName, ruleErrors) {
    // Extract rule number from "Rule 1", "Rule 2", etc.
    const ruleNumber = ruleName.match(/Rule (\d+)/)[1];
    const ruleElement = document.getElementById(`edit_rule_${ruleNumber}`);
    
    if (ruleElement) {
        // Add error styling to rule container
        ruleElement.classList.add('border-danger');
        
        // Show errors for each field in the rule
        for (const fieldName in ruleErrors) {
            let fieldSelector = '';
            
            switch (fieldName) {
                case 'rule_type':
                    fieldSelector = `select[name*="[rule_type]"]`;
                    break;
                case 'target_type':
                    fieldSelector = `select[name*="[target_type]"]`;
                    break;
                case 'approval_level':
                    fieldSelector = `select[name*="[approval_level]"]`;
                    break;
            }
            
            if (fieldSelector) {
                const field = ruleElement.querySelector(fieldSelector);
                if (field) {
                    showEditFieldError(field, ruleErrors[fieldName]);
                }
            }
        }
    }
}

// Collect rules data for submission in edit modal
function collectEditRulesData() {
    const rules = [];
    const ruleElements = document.querySelectorAll('#editRulesContainer .rule-item');
    
    ruleElements.forEach((ruleElement, index) => {
        
        const ruleTypeSelect = ruleElement.querySelector('select[name*="[rule_type]"]');
        const targetTypeSelect = ruleElement.querySelector('select[name*="[target_type]"]');
        const approvalLevelSelect = ruleElement.querySelector('select[name*="[approval_level]"]');
        
        if (!ruleTypeSelect || !targetTypeSelect || !approvalLevelSelect) {
            return;
        }
        
        const ruleType = ruleTypeSelect.value;
        const targetType = targetTypeSelect.value;
        const approvalLevel = approvalLevelSelect.value;
        
        if (ruleType && targetType && approvalLevel) {
            const ruleData = {
                rule_type: ruleType,
                target_type: targetType,
                approval_level: approvalLevel,
                division_ids: [],
                department_ids: [],
                section_ids: []
            };
            
            // Collect specific selections based on rule type
            if (ruleType === 'division') {
                const divisionSelect = ruleElement.querySelector('select[name*="[division_ids]"]');
                if (divisionSelect && typeof $ !== 'undefined') {
                    ruleData.division_ids = $(divisionSelect).val() || [];
                }
            } else if (ruleType === 'department') {
                const departmentSelect = ruleElement.querySelector('select[name*="[department_ids]"]');
                if (departmentSelect && typeof $ !== 'undefined') {
                    ruleData.department_ids = $(departmentSelect).val() || [];
                }
            } else if (ruleType === 'section') {
                const sectionSelect = ruleElement.querySelector('select[name*="[section_ids]"]');
                if (sectionSelect && typeof $ !== 'undefined') {
                    ruleData.section_ids = $(sectionSelect).val() || [];
                }
            }
            rules.push(ruleData);
        } else {
            // If we have at least ruleType, still try to collect it
            if (ruleType) {
                const ruleData = {
                    rule_type: ruleType,
                    target_type: targetType || 'both', // fallback
                    approval_level: approvalLevel || 'no_approval', // fallback
                    division_ids: [],
                    department_ids: [],
                    section_ids: []
                };
                
                // Collect organizational units even with partial data
                if (ruleType === 'division') {
                    const divisionSelect = ruleElement.querySelector('select[name*="[division_ids]"]');
                    if (divisionSelect && typeof $ !== 'undefined') {
                        ruleData.division_ids = $(divisionSelect).val() || [];
                    }
                } else if (ruleType === 'department') {
                    const departmentSelect = ruleElement.querySelector('select[name*="[department_ids]"]');
                    if (departmentSelect && typeof $ !== 'undefined') {
                        ruleData.department_ids = $(departmentSelect).val() || [];
                    }
                } else if (ruleType === 'section') {
                    const sectionSelect = ruleElement.querySelector('select[name*="[section_ids]"]');
                    if (sectionSelect && typeof $ !== 'undefined') {
                        ruleData.section_ids = $(sectionSelect).val() || [];
                    }
                }
                
                rules.push(ruleData);
            }
        }
    });
    
    return rules;
}

// Function to populate edit modal (called from index.php)
window.populateEditAuthorizationRuleModal = function(rule, callback) {
    
    // Set basic field values
    document.getElementById('edit_authorization_rule_id').value = rule.id;
    document.getElementById('edit_user_id').value = rule.user_id;
    document.getElementById('edit_description').value = rule.description || '';
    document.getElementById('edit_is_active').value = rule.is_active;
    
    // Clear existing rules
    document.getElementById('editRulesContainer').innerHTML = '';
    editRuleCounter = 0;
    
    // Immediate basic field updates
    if (typeof $ !== 'undefined') {
        $('#edit_user_id').val(rule.user_id).trigger('change');
        $('#edit_is_active').val(rule.is_active).trigger('change');
    }
    
    // Wait for modal to be fully ready
    setTimeout(() => {// Check if this is a multiple rule or single rule
        if (rule.rule_type === 'multiple') {const rulesToCreate = [];
            
            // First, try to get rules from rules_config
            let rulesFromConfig = [];
            if (rule.rules_config) {
                try {
                    let rulesConfig;
                    if (typeof rule.rules_config === 'string') {
                        rulesConfig = JSON.parse(rule.rules_config);
                    } else {
                        rulesConfig = rule.rules_config;
                    }if (Array.isArray(rulesConfig) && rulesConfig.length > 0) {rulesConfig.forEach((ruleConfig, index) => {// Parse organizational unit IDs for each rule config
                            const configDivisionIds = parseJsonField(ruleConfig.division_ids);
                            const configDepartmentIds = parseJsonField(ruleConfig.department_ids);
                            const configSectionIds = parseJsonField(ruleConfig.section_ids);rulesFromConfig.push({
                                rule_type: ruleConfig.rule_type,
                                target_type: ruleConfig.target_type,
                                approval_level: ruleConfig.approval_level || 'no_approval',
                                division_ids: configDivisionIds,
                                department_ids: configDepartmentIds,
                                section_ids: configSectionIds
                            });
                        });
                    } else {}
                } catch (e) {}
            } else {}
            
            // Always create rules from main rule data since rules_config might be incomplete// Parse the organizational unit IDs from main rule
            const divisionIds = parseJsonField(rule.division_ids);
            const departmentIds = parseJsonField(rule.department_ids);
            const sectionIds = parseJsonField(rule.section_ids);// Always create all three rules if the data exists
            // Create division rule if there are divisions
            if (divisionIds && divisionIds.length > 0) {rulesToCreate.push({
                    rule_type: 'division',
                    target_type: rule.target_type === 'multiple' ? 'both' : rule.target_type,
                    approval_level: rule.approval_level || 'no_approval',
                    division_ids: divisionIds,
                    department_ids: [],
                    section_ids: []
                });
            }
            
            // Create department rule if there are departments
            if (departmentIds && departmentIds.length > 0) {rulesToCreate.push({
                    rule_type: 'department',
                    target_type: rule.target_type === 'multiple' ? 'both' : rule.target_type,
                    approval_level: rule.approval_level || 'no_approval',
                    division_ids: [],
                    department_ids: departmentIds,
                    section_ids: []
                });
            }
            
            // Create section rule if there are sections
            if (sectionIds && sectionIds.length > 0) {rulesToCreate.push({
                    rule_type: 'section',
                    target_type: rule.target_type === 'multiple' ? 'both' : rule.target_type,
                    approval_level: rule.approval_level || 'no_approval',
                    division_ids: [],
                    department_ids: [],
                    section_ids: sectionIds
                });
            }// Create all the rules
            if (rulesToCreate.length > 0) {
                // Initialize callback tracking
                window.editModalCallback = callback;
                window.editModalRulesCompleted = 0;
                window.editModalTotalRules = rulesToCreate.length;
                
                rulesToCreate.forEach((ruleData, index) => {addEditRuleWithData(ruleData, index);
                });
            } else {// Initialize callback tracking for default rule
                window.editModalCallback = callback;
                window.editModalRulesCompleted = 0;
                window.editModalTotalRules = 1;
                
                addEditRuleWithData({
                    rule_type: '',
                    target_type: '',
                    approval_level: 'no_approval',
                    division_ids: [],
                    department_ids: [],
                    section_ids: []
                }, 0);
            }
        } else {// Initialize callback tracking for single rule
            window.editModalCallback = callback;
            window.editModalRulesCompleted = 0;
            window.editModalTotalRules = 1;
            
            addEditRuleWithData({
                rule_type: rule.rule_type,
                target_type: rule.target_type,
                approval_level: rule.approval_level || 'no_approval',
                division_ids: parseJsonField(rule.division_ids),
                department_ids: parseJsonField(rule.department_ids),
                section_ids: parseJsonField(rule.section_ids)
            }, 0);
        }
    }, 800);
}

// Helper function to parse JSON fields
function parseJsonField(field) {
    if (!field) return [];
    if (Array.isArray(field)) return field;
    if (typeof field === 'string') {
        try {
            return JSON.parse(field);
        } catch (e) {return [];
        }
    }
    return [];
}

// New function to add rule with data
function addEditRuleWithData(ruleData, index) {// Add the rule first
    addNewEditRule();
    const currentRuleNumber = editRuleCounter;
    
    // Wait for DOM to be ready, then populate
    setTimeout(() => {setEditRuleValues(currentRuleNumber, ruleData);
    }, 300 * (index + 1)); // Stagger each rule by 300ms
}

// New function to set rule values
function setEditRuleValues(ruleNumber, ruleData) {
    const ruleId = `edit_rule_${ruleNumber}`;
    const ruleElement = document.getElementById(ruleId);
    
    if (!ruleElement) {return;
    }const ruleTypeSelect = ruleElement.querySelector('select[name*="[rule_type]"]');
    const targetTypeSelect = ruleElement.querySelector('select[name*="[target_type]"]');
    const approvalLevelSelect = ruleElement.querySelector('select[name*="[approval_level]"]');
    
    if (!ruleTypeSelect || !targetTypeSelect || !approvalLevelSelect) {return;
    }
    
    // Set values directly first
    ruleTypeSelect.value = ruleData.rule_type || '';
    targetTypeSelect.value = ruleData.target_type || '';
    approvalLevelSelect.value = ruleData.approval_level || 'no_approval';if (typeof $ !== 'undefined') {
        // Wait for Select2 to be ready
        setTimeout(() => {// Force Select2 updates with explicit values
            $(ruleTypeSelect).val(ruleData.rule_type || '').trigger('change');
            $(targetTypeSelect).val(ruleData.target_type || '').trigger('change');
            
            // For approval level, ensure we have a valid value
            let approvalLevelValue = ruleData.approval_level || 'no_approval';
            
            // Map any invalid values to valid ones
            if (!['no_approval', 'level_1', 'level_2', 'level_3'].includes(approvalLevelValue)) {approvalLevelValue = 'level_1'; // Default to Level 1 instead of no approval
            }$(approvalLevelSelect).val(approvalLevelValue).trigger('change');
            
            // Verify the value was set
            setTimeout(() => {
                const currentValue = $(approvalLevelSelect).val();if (!currentValue || currentValue === '') {$(approvalLevelSelect).val('level_1').trigger('change');
                }
            }, 100);
            
            // Trigger rule type change to show containers
            setTimeout(() => {handleEditRuleTypeChange(ruleId);
                
                // Set organizational units
                setTimeout(() => {
                    setOrganizationalUnits(ruleElement, ruleData, ruleNumber);
                    
                    // Mark this rule as completed and check if all are done
                    window.editModalRulesCompleted++;
                    checkEditModalCompletion();
                }, 300);
            }, 200);
        }, 400);
    }
}

// Function to set organizational units
function setOrganizationalUnits(ruleElement, ruleData, ruleNumber) {if (ruleData.division_ids && ruleData.division_ids.length > 0) {
        const divisionSelect = ruleElement.querySelector('select[name*="[division_ids]"]');
        if (divisionSelect && $(divisionSelect).is(':visible')) {$(divisionSelect).val(ruleData.division_ids).trigger('change');
        }
    }
    
    if (ruleData.department_ids && ruleData.department_ids.length > 0) {
        const departmentSelect = ruleElement.querySelector('select[name*="[department_ids]"]');
        if (departmentSelect && $(departmentSelect).is(':visible')) {$(departmentSelect).val(ruleData.department_ids).trigger('change');
        }
    }
    
    if (ruleData.section_ids && ruleData.section_ids.length > 0) {
        const sectionSelect = ruleElement.querySelector('select[name*="[section_ids]"]');
        if (sectionSelect && $(sectionSelect).is(':visible')) {$(sectionSelect).val(ruleData.section_ids).trigger('change');
        }
    }}

// Global callback tracker for edit modal
window.editModalCallback = null;
window.editModalRulesCompleted = 0;
window.editModalTotalRules = 0;

// Function to check if all rules are completed and call callback
function checkEditModalCompletion() {
    if (window.editModalRulesCompleted >= window.editModalTotalRules && window.editModalCallback) {window.editModalCallback();
        window.editModalCallback = null; // Clear callback to prevent multiple calls
    }
};
</script>
