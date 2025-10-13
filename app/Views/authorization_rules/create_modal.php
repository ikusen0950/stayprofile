<!--begin::Create Authorization Rule Modal-->
<div class="modal fade" id="createAuthorizationRuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-750px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Create Authorization Rules</h2>
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
                <form id="createAuthorizationRuleForm" class="form">
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">

                    <!--begin::Input group - Status-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Status</label>
                                    <!--end::Label-->
                                    <!--begin::Select-->
                                    <select name="is_active" class="form-select form-select-solid" data-control="select2" data-placeholder="Select status..." data-dropdown-parent="#createAuthorizationRuleModal">
                                        <option value="1" selected>Active</option>
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
                            <select name="user_id" class="form-select form-select-solid" data-control="select2" data-placeholder="Select a user..." data-dropdown-parent="#createAuthorizationRuleModal">
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

                        <!--begin::Multiple Rules Section-->
                        <div class="mb-7">
                            <!--begin::Section Header-->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 class="fw-bold text-gray-900 mb-0">Authorization Rules</h5>
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
                    <span class="indicator-label">Create Authorization Rules</span>
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
<!--end::Create Authorization Rule Modal-->

<script>
// Global variables for multi-rule management
let ruleCounter = 0;
const divisions = <?= json_encode($divisions ?? []) ?>;
const departments = <?= json_encode($departments ?? []) ?>;
const sections = <?= json_encode($sections ?? []) ?>;

document.addEventListener('DOMContentLoaded', function() {
    const createForm = document.getElementById('createAuthorizationRuleForm');
    const createModal = document.getElementById('createAuthorizationRuleModal');
    const submitBtn = document.getElementById('createAuthorizationRuleSubmitBtn');
    const addRuleBtn = document.getElementById('addRuleBtn');
    
    // Add initial rule when modal opens
    if (createModal) {
        createModal.addEventListener('shown.bs.modal', function() {
            if (document.getElementById('rulesContainer').children.length === 0) {
                addNewRule();
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
                Swal.fire('Error', 'Please add at least one authorization rule', 'error');
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
                return;
            }
            
            const formData = new FormData();
            formData.append('user_id', document.querySelector('select[name="user_id"]').value);
            formData.append('description', document.querySelector('textarea[name="description"]').value);
            formData.append('is_active', document.querySelector('select[name="is_active"]').value);
            formData.append('rules', JSON.stringify(rulesData));
            
            fetch('/authorization-rules/store-multiple', {
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
                Swal.fire('Error', 'Failed to create authorization rule', 'error');
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
            
            // Clear any validation states
            const inputs = createForm.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.classList.remove('is-invalid', 'is-valid');
            });
            
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
                    <label class="required fw-semibold fs-6 mb-2">Rule Type</label>
                    <select name="rules[${ruleCounter}][rule_type]" class="form-select form-select-solid rule-type-select" data-control="select2" data-placeholder="Select rule type..." data-dropdown-parent="#createAuthorizationRuleModal" onchange="handleRuleTypeChange('${ruleId}')">
                        <option value="">Select Rule Type</option>
                        <option value="all">All (Admin)</option>
                        <option value="division">Division</option>
                        <option value="department">Department</option>
                        <option value="section">Section</option>
                    </select>
                </div>
                
                <!-- Target Type -->
                <div class="col-md-4 mb-4">
                    <label class="required fw-semibold fs-6 mb-2">Target Type</label>
                    <select name="rules[${ruleCounter}][target_type]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select target type..." data-dropdown-parent="#createAuthorizationRuleModal">
                        <option value="">Select Target Type</option>
                        <option value="both">Both</option>
                        <option value="islanders">Islanders Only</option>
                        <option value="visitors">Visitors Only</option>
                    </select>
                </div>
                
                <!-- Approval Level -->
                <div class="col-md-4 mb-4">
                    <label class="required fw-semibold fs-6 mb-2">Approval Level</label>
                    <select name="rules[${ruleCounter}][approval_level]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select approval level..." data-dropdown-parent="#createAuthorizationRuleModal">
                        <option value="">Select Approval Level</option>
                        <option value="no_approval" selected>No Approval Required</option>
                        <option value="level_1">Level 1 Approval</option>
                        <option value="level_2">Level 2 Approval</option>
                        <option value="level_3">Level 3 Approval</option>
                    </select>
                </div>
            </div>
            
            <!-- Dynamic Selections -->
            <div class="row">
                <!-- Divisions -->
                <div class="col-12 mb-4" id="${ruleId}_division_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Divisions</label>
                    <select name="rules[${ruleCounter}][division_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select divisions..." data-dropdown-parent="#createAuthorizationRuleModal" multiple>
                        ${generateDivisionOptions()}
                    </select>
                </div>
                
                <!-- Departments -->
                <div class="col-12 mb-4" id="${ruleId}_department_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Departments</label>
                    <select name="rules[${ruleCounter}][department_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select departments..." data-dropdown-parent="#createAuthorizationRuleModal" multiple>
                        ${generateDepartmentOptions()}
                    </select>
                </div>
                
                <!-- Sections -->
                <div class="col-12 mb-4" id="${ruleId}_section_container" style="display: none;">
                    <label class="fw-semibold fs-6 mb-2">Sections</label>
                    <select name="rules[${ruleCounter}][section_ids][]" class="form-select form-select-solid" data-control="select2" data-placeholder="Select sections..." data-dropdown-parent="#createAuthorizationRuleModal" multiple>
                        ${generateSectionOptions()}
                    </select>
                </div>
            </div>
        </div>
    `;
    
    document.getElementById('rulesContainer').insertAdjacentHTML('beforeend', ruleHtml);
    
    // Initialize Select2 for the new elements
    if (typeof $ !== 'undefined') {
        $(`#${ruleId} select[data-control="select2"]`).select2({
            dropdownParent: $('#createAuthorizationRuleModal')
        });
    }
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