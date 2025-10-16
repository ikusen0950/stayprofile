<!--begin::Create Requesting Rule Modal-->
<style>
/* Fullscreen modals on mobile */
@media (max-width: 767.98px) {
    #createRequestingRuleModal .modal-dialog {
        margin: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        height: 100% !important;
        max-height: 100% !important;
    }

    #createRequestingRuleModal .modal-content {
        height: 100vh !important;
        border: none !important;
        border-radius: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    #createRequestingRuleModal .modal-body {
        flex: 1 !important;
        overflow-y: auto !important;
        padding: 1rem !important;
    }

    #createRequestingRuleModal .modal-header {
        padding: 1rem !important;
        border-bottom: 1px solid var(--bs-border-color) !important;
        flex-shrink: 0 !important;
    }

    #createRequestingRuleModal .modal-footer {
        padding: 1rem !important;
        border-top: 1px solid var(--bs-border-color) !important;
        flex-shrink: 0 !important;
    }

    /* Ensure modal backdrop doesn't interfere */
    #createRequestingRuleModal .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
}

/* Better Select2 dropdown positioning in modals */
.select2-container--bootstrap5 .select2-dropdown {
    z-index: 1060;
}
</style>

<div class="modal fade" id="createRequestingRuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Create Requesting Rules</h2>
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
                <form id="createRequestingRuleForm" class="form">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">

                    <!--begin::Input group - Status-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="is_active" class="form-select form-select-solid" data-control="select2" data-placeholder="Select status..." data-dropdown-parent="#createRequestingRuleModal">
                                        <option value="1" selected>Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                    <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group - Can Request-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Can Request</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="can_request" class="form-select form-select-solid" data-control="select2" data-placeholder="Select request permission..." data-dropdown-parent="#createRequestingRuleModal">
                                        <option value="1" selected>Yes</option>
                                        <option value="0">No</option>
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
                            <select name="user_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a user..." data-dropdown-parent="#createRequestingRuleModal">
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
                                <button type="button" class="btn btn-sm btn-light-primary" id="addRuleBtn">
                                    <i class="ki-duotone ki-plus fs-3"></i>
                                    Add Rule
                                </button>
                            </div>
                            <!--end::Section Header-->
                            
                            <!--begin::Rules Container-->
                            <div id="rulesContainer">
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
                                    <textarea name="description" class="form-control form-control-solid" rows="3" placeholder="Enter general description for all rules (optional)"></textarea>
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
                <button type="button" class="btn btn-primary" id="createAuthorizationRuleSubmitBtn">
                    <span class="indicator-label">Create Requesting Rules</span>
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
<!--end::Create Requesting Rule Modal-->

<script>
// Global variables for multi-rule management
let ruleCounter = 0;
const divisions = <?= json_encode($divisions ?? []) ?>;
const departments = <?= json_encode($departments ?? []) ?>;
const sections = <?= json_encode($sections ?? []) ?>;

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createRequestingRuleForm');
    const createModal = document.getElementById('createRequestingRuleModal');
    const submitBtn = document.getElementById('createAuthorizationRuleSubmitBtn');
    const addRuleBtn = document.getElementById('addRuleBtn');
    
    // Add initial rule when modal opens
    if (createModal) {
        createModal.addEventListener('shown.bs.modal', function() {
            if (document.getElementById('rulesContainer').children.length === 0) {
                addNewRule();
            }
            
            // Initialize Select2 for existing elements
            if (typeof $ !== 'undefined') {
                $(createModal).find('select[data-control="select2"]').each(function() {
                    if (!$(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2({
                            dropdownParent: $('#createRequestingRuleModal')
                        });
                    }
                });
            }
        });
    }
    
    // Add rule button functionality
    if (addRuleBtn) {
        addRuleBtn.addEventListener('click', function() {
            addNewRule();
        });
    }
    
    if (createForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            // Collect multiple rules data
            const rulesData = collectRulesData();
            if (!rulesData || rulesData.length === 0) {
                Swal.fire('Error', 'Please add at least one Requesting Rule', 'error');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            const formData = new FormData();
            formData.append('user_id', document.querySelector('select[name="user_id"]').value);
            formData.append('description', document.querySelector('textarea[name="description"]').value);
            formData.append('is_active', document.querySelector('select[name="is_active"]').value);
            formData.append('rules', JSON.stringify(rulesData));
            
            fetch('/requesting-rules/store-multiple', {
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
                    const modal = bootstrap.Modal.getInstance(createModal);
                    modal.hide();
                    
                    // Reset form
                    createForm.reset();
                    
                    // Show success message
                    Swal.fire('Success!', data.message, 'success');
                    
                    // Reload page
                    window.location.reload();
                } else {
                    // Clear previous validation states
                    clearValidationErrors();
                    
                    // Show validation errors below each field
                    if (data.errors) {
                        showValidationErrors(data.errors);
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                Swal.fire('Error', 'Failed to create Requesting Rule', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
            });
        });
    }
    
    // Reset form when modal is hidden
    if (createModal) {
        createModal.addEventListener('hidden.bs.modal', function () {
            createForm.reset();
            
            // Clear all rules and reset counter
            document.getElementById('rulesContainer').innerHTML = '';
            ruleCounter = 0;
            
            // Clear all validation errors
            clearValidationErrors();
            
            // Reset Select2 elements
            if (typeof $ !== 'undefined') {
                $(createForm).find('select[data-control="select2"]').val(null).trigger('change');
            }
        });
    }
});

// Add new rule function
function addNewRule() {
    ruleCounter++;
    const ruleId = `rule_${ruleCounter}`;
    
    const ruleHtml = `
        <div class="rule-item border border-gray-300 rounded p-4 mb-4" id="${ruleId}">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold text-gray-700 mb-0">Rule ${ruleCounter}</h6>
                <button type="button" class="btn btn-sm btn-light-danger" onclick="removeRule('${ruleId}')">
                    <i class="ki-duotone ki-trash fs-5"></i>
                    Remove
                </button>
            </div>
            
            <div class="row">
                <!-- Rule Type -->
                <div class="col-md-4 mb-4">
                    <div class="fv-row">
                        <label class="required fw-semibold fs-6 mb-2">Rule Type</label>
                        <select name="rules[${ruleCounter}][rule_type]" class="form-select form-select-solid rule-type-select" data-control="select2" data-placeholder="Select rule type..." data-dropdown-parent="#createRequestingRuleModal" onchange="handleRuleTypeChange('${ruleId}')">
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
                        <select name="rules[${ruleCounter}][target_type]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select target type..." data-dropdown-parent="#createRequestingRuleModal">
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
                        <select name="rules[${ruleCounter}][approval_level]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select approval level..." data-dropdown-parent="#createRequestingRuleModal">
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
                    <select name="rules[${ruleCounter}][division_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select divisions..." data-dropdown-parent="#createRequestingRuleModal" multiple>
                        ${generateDivisionOptions()}
                    </select>
                </div>
                
                <!-- Departments -->
                <div class="col-12 mb-4" id="${ruleId}_department_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Departments</label>
                    <select name="rules[${ruleCounter}][department_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select departments..." data-dropdown-parent="#createRequestingRuleModal" multiple>
                        ${generateDepartmentOptions()}
                    </select>
                </div>
                
                <!-- Sections -->
                <div class="col-12 mb-4" id="${ruleId}_section_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Sections</label>
                    <select name="rules[${ruleCounter}][section_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select sections..." data-dropdown-parent="#createRequestingRuleModal" multiple>
                        ${generateSectionOptions()}
                    </select>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('rulesContainer').insertAdjacentHTML('beforeend', ruleHtml);
    
    // Initialize Select2 for the new elements with a small delay
    setTimeout(() => {
        if (typeof $ !== 'undefined') {
            try {
                $(`#${ruleId} select[data-control="select2"]`).each(function() {
                    if (!$(this).hasClass('select2-hidden-accessible')) {
                        $(this).select2({
                            dropdownParent: $('#createRequestingRuleModal'),
                            width: '100%'
                        });
                    }
                });
            } catch (error) {
                console.warn('Select2 initialization error:', error);
            }
        }
    }, 100);
}

// Remove rule function
function removeRule(ruleId) {
    const ruleElement = document.getElementById(ruleId);
    if (ruleElement) {
        ruleElement.remove();
    }
    
    // If no rules left, add one
    if (document.getElementById('rulesContainer').children.length === 0) {
        addNewRule();
    }
}

// Generate options functions
function generateDivisionOptions() {
    return divisions.map(division => 
        `<option value="${division.id}">${division.name}</option>`
    ).join('');
}

function generateDepartmentOptions() {
    return departments.map(department => 
        `<option value="${department.id}">${department.name}</option>`
    ).join('');
}

function generateSectionOptions() {
    return sections.map(section => 
        `<option value="${section.id}">${section.name}</option>`
    ).join('');
}

// Handle rule type changes for dynamic rules
function handleRuleTypeChange(ruleId) {
    const ruleElement = document.getElementById(ruleId);
    const ruleTypeSelect = ruleElement.querySelector('.rule-type-select');
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

// Clear validation errors
function clearValidationErrors() {
    // Remove all validation classes and error messages
    const form = document.getElementById('createRequestingRuleForm');
    
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

// Show validation errors below each field
function showValidationErrors(errors) {
    // Handle main form field errors
    for (const fieldName in errors) {
        if (fieldName.startsWith('Rule ')) {
            // Handle rule-specific errors
            showRuleValidationErrors(fieldName, errors[fieldName]);
        } else {
            // Handle main form errors (user_id, description, is_active)
            const field = document.querySelector(`[name="${fieldName}"]`);
            if (field) {
                showFieldError(field, errors[fieldName]);
            }
        }
    }
}

// Show error for a specific field
function showFieldError(field, errorMessage) {
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

// Show rule-specific validation errors
function showRuleValidationErrors(ruleName, ruleErrors) {
    // Extract rule number from "Rule 1", "Rule 2", etc.
    const ruleNumber = ruleName.match(/Rule (\d+)/)[1];
    const ruleElement = document.getElementById(`rule_${ruleNumber}`);
    
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
                    showFieldError(field, ruleErrors[fieldName]);
                }
            }
        }
    }
}

// Collect rules data for submission
function collectRulesData() {
    const rules = [];
    const ruleElements = document.querySelectorAll('.rule-item');
    
    ruleElements.forEach((ruleElement, index) => {
        const ruleTypeSelect = ruleElement.querySelector('select[name*="[rule_type]"]');
        const targetTypeSelect = ruleElement.querySelector('select[name*="[target_type]"]');
        const approvalLevelSelect = ruleElement.querySelector('select[name*="[approval_level]"]');
        
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
        }
    });
    
    return rules;
}
</script>
