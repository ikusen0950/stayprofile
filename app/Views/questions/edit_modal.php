<!--begin::Edit Question Modal-->
<div class="modal fade" id="editQuestionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Edit Question</h2>
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
                <form id="editQuestionForm" class="form">
                    <input type="hidden" id="edit_question_id" name="question_id" />
                    <!--begin::Scroll-->
                    <div class="d-flex flex-column">
                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Question Label</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" id="edit_label" name="label" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter question label" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <textarea id="edit_description" name="description" class="form-control form-control-solid" rows="3" placeholder="Enter question description (optional)"></textarea>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="required fw-semibold fs-6 mb-2">Question Type</label>
                            <!--end::Label-->
                            <!--begin::Select-->
                            <select id="edit_type" name="type" class="form-select form-select-solid" data-control="select2" data-placeholder="Select question type..." data-dropdown-parent="#editQuestionModal">
                                <option></option>
                                <?php if (!empty($questionTypes)): ?>
                                    <?php foreach ($questionTypes as $type): ?>
                                        <option value="<?= esc($type['value']) ?>"><?= esc($type['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <!--end::Select-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Options section (for MCQ questions)-->
                        <div id="edit-options-section" class="d-none mb-7">
                            <div class="separator separator-dashed my-3"></div>
                            
                            <!--begin::Options header-->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <label class="fw-semibold fs-6 mb-0 text-gray-800">Question Options</label>
                                <button type="button" id="edit-add-option-btn" class="btn btn-sm btn-light-primary">
                                    <i class="ki-duotone ki-plus fs-2"></i>Add Option
                                </button>
                            </div>
                            <!--end::Options header-->
                            
                            <!--begin::Options container-->
                            <div id="edit-options-container">
                                <!-- Options will be added dynamically -->
                            </div>
                            <!--end::Options container-->
                            
                            <!--begin::Options help text-->
                            <div class="text-muted fs-7 mt-2">
                                <i class="ki-duotone ki-information-5 fs-6 text-primary me-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                                Add at least 2 options for multiple choice questions.
                            </div>
                            <!--end::Options help text-->
                        </div>
                        <!--end::Options section-->

                        <!--begin::Input group row-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Page</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" id="edit_page" name="page" class="form-control form-control-solid" placeholder="Enter page name" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Col-->
                            
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Sort Order</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="number" id="edit_sort_order" name="sort_order" class="form-control form-control-solid" placeholder="0" min="0" />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group row-->

                        <!--begin::Input group row-->
                        <div class="row mb-7">
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Required</label>
                                    <!--end::Label-->
                                    <!--begin::Switch-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="is_required" value="1" id="edit_is_required" />
                                        <label class="form-check-label fw-semibold text-gray-400 ms-3" for="edit_is_required">
                                            Make this question required
                                        </label>
                                    </div>
                                    <!--end::Switch-->
                                </div>
                            </div>
                            <!--end::Col-->
                            
                            <!--begin::Col-->
                            <div class="col-md-6">
                                <div class="fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Active</label>
                                    <!--end::Label-->
                                    <!--begin::Switch-->
                                    <div class="form-check form-switch form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="edit_is_active" />
                                        <label class="form-check-label fw-semibold text-gray-400 ms-3" for="edit_is_active">
                                            Make this question active
                                        </label>
                                    </div>
                                    <!--end::Switch-->
                                </div>
                            </div>
                            <!--end::Col-->
                        </div>
                        <!--end::Input group row-->

                    </div>
                    <!--end::Scroll-->
                </form>
                <!--end::Form-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="editQuestionBtn">
                    <span class="indicator-label">Update Question</span>
                    <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Edit Question Modal-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editQuestionForm = document.getElementById('editQuestionForm');
    const editQuestionBtn = document.getElementById('editQuestionBtn');
    const editQuestionModal = document.getElementById('editQuestionModal');

    if (editQuestionBtn && editQuestionForm) {
        editQuestionBtn.addEventListener('click', function() {
            const questionId = document.getElementById('edit_question_id').value;
            
            if (!questionId) {
                Swal.fire('Error', 'Question ID is missing', 'error');
                return;
            }

            // Show loading state
            editQuestionBtn.setAttribute('data-kt-indicator', 'on');
            editQuestionBtn.disabled = true;

            // Get form data
            const formData = new FormData(editQuestionForm);
            
            // Handle checkboxes - if not checked, they won't be in FormData
            if (!editQuestionForm.querySelector('input[name="is_required"]').checked) {
                formData.append('is_required', '0');
            }
            if (!editQuestionForm.querySelector('input[name="is_active"]').checked) {
                formData.append('is_active', '0');
            }

            // Collect options data including follow-up configurations
            const questionType = editQuestionForm.querySelector('select[name="type"]').value;
            if (questionType === 'single_mcq' || questionType === 'multi_mcq') {
                const optionInputs = editQuestionForm.querySelectorAll('input[name^="options["]');
                optionInputs.forEach(input => {
                    formData.append(input.name, input.value);
                });
                
                // Handle follow-up checkboxes that aren't checked
                const optionItems = editQuestionForm.querySelectorAll('.option-item');
                optionItems.forEach((item, index) => {
                    const hasFollowupCheckbox = item.querySelector(`input[name="options[${index}][has_followup]"]`);
                    const followupRequiredCheckbox = item.querySelector(`input[name="options[${index}][followup_required]"]`);
                    
                    if (hasFollowupCheckbox && !hasFollowupCheckbox.checked) {
                        formData.append(`options[${index}][has_followup]`, '0');
                    }
                    if (followupRequiredCheckbox && !followupRequiredCheckbox.checked) {
                        formData.append(`options[${index}][followup_required]`, '0');
                    }
                });
            }

            // Submit form
            secureFetch(`/questions/${questionId}/update`, {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (response.status === 401 || response.status === 403) {
                    handleSessionExpired();
                    return;
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(editQuestionModal);
                    modal.hide();
                    
                    // Show success message
                    Swal.fire('Success!', data.message, 'success');
                    
                    // Reload page
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    // Show error
                    if (data.errors) {
                        let errorMsg = '';
                        for (const field in data.errors) {
                            errorMsg += data.errors[field] + '\n';
                        }
                        Swal.fire('Validation Error', errorMsg, 'error');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'An unexpected error occurred', 'error');
            })
            .finally(() => {
                // Reset loading state
                editQuestionBtn.removeAttribute('data-kt-indicator');
                editQuestionBtn.disabled = false;
            });
        });
    }

    // Initialize Select2 for the modal
    if (editQuestionModal) {
        editQuestionModal.addEventListener('shown.bs.modal', function() {
            // Initialize Select2 dropdowns
            $(editQuestionModal).find('[data-control="select2"]').select2({
                dropdownParent: $(editQuestionModal)
            });
            
            // Handle question type change for Select2
            $(editQuestionModal).find('select[name="type"]').on('change', function() {
                const selectedType = this.value;
                const optionsSection = document.getElementById('edit-options-section');
                const optionsContainer = document.getElementById('edit-options-container');
                
                console.log('Edit modal - Question type changed to:', selectedType); // Debug log
                
                if (selectedType === 'single_mcq' || selectedType === 'multi_mcq') {
                    // Show options section for MCQ questions
                    optionsSection.classList.remove('d-none');
                    
                    // If no options exist, add 2 default options
                    if (optionsContainer.children.length === 0) {
                        addEditOption('');
                        addEditOption('');
                    }
                } else {
                    // Hide options section for non-MCQ questions
                    optionsSection.classList.add('d-none');
                }
            });
        });
    }

    // Handle add option button in edit modal
    const editAddOptionBtn = document.getElementById('edit-add-option-btn');
    if (editAddOptionBtn) {
        editAddOptionBtn.addEventListener('click', function() {
            addEditOption('');
        });
    }

    // Function to add an option in edit modal
    function addEditOption(value = '') {
        const optionsContainer = document.getElementById('edit-options-container');
        const optionIndex = optionsContainer.children.length;
        
        const optionDiv = document.createElement('div');
        optionDiv.className = 'mb-4 option-item border p-3 rounded';
        optionDiv.innerHTML = `
            <div class="d-flex align-items-start">
                <div class="flex-grow-1 me-3">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Option Text</label>
                        <input type="text" name="options[${optionIndex}][label]" class="form-control form-control-solid" placeholder="Enter option text" value="${value}" required />
                        <input type="hidden" name="options[${optionIndex}][sort_order]" value="${optionIndex + 1}" />
                    </div>
                    
                    <!-- Follow-up Configuration -->
                    <div class="separator separator-dashed my-3"></div>
                    <div class="mb-3">
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input followup-toggle" type="checkbox" name="options[${optionIndex}][has_followup]" value="1" id="edit_followup_${optionIndex}" onchange="toggleEditFollowupFields(this)" />
                            <label class="form-check-label fw-semibold text-gray-700" for="edit_followup_${optionIndex}">
                                Show follow-up field when this option is selected
                            </label>
                        </div>
                    </div>
                    
                    <!-- Follow-up fields (initially hidden) -->
                    <div class="followup-config d-none" id="edit_followup_config_${optionIndex}">
                        <div class="bg-light-primary p-3 rounded">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary">Follow-up Field Label</label>
                                <input type="text" name="options[${optionIndex}][followup_label]" class="form-control form-control-solid" placeholder="e.g., Please tell us more..." />
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-primary">Follow-up Field Placeholder</label>
                                <input type="text" name="options[${optionIndex}][followup_placeholder]" class="form-control form-control-solid" placeholder="e.g., Enter details here..." />
                            </div>
                            <div class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" name="options[${optionIndex}][followup_required]" value="1" id="edit_followup_required_${optionIndex}" />
                                <label class="form-check-label fw-semibold text-primary" for="edit_followup_required_${optionIndex}">
                                    Make follow-up field required
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light-danger remove-edit-option-btn" onclick="removeEditOption(this)">
                    <i class="ki-duotone ki-trash fs-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                        <span class="path4"></span>
                        <span class="path5"></span>
                    </i>
                </button>
            </div>
        `;
        
        optionsContainer.appendChild(optionDiv);
    }

    // Function to remove an option in edit modal
    window.removeEditOption = function(button) {
        const optionItem = button.closest('.option-item');
        const optionsContainer = document.getElementById('edit-options-container');
        
        // Don't allow removing if there are only 2 options (minimum for MCQ)
        if (optionsContainer.children.length <= 2) {
            Swal.fire('Warning', 'At least 2 options are required for multiple choice questions.', 'warning');
            return;
        }
        
        optionItem.remove();
        
        // Re-index the remaining options
        const remainingOptions = optionsContainer.querySelectorAll('.option-item');
        remainingOptions.forEach((option, index) => {
            const labelInput = option.querySelector('input[name*="[label]"]');
            const sortInput = option.querySelector('input[name*="[sort_order]"]');
            const followupToggle = option.querySelector('input[name*="[has_followup]"]');
            const followupLabel = option.querySelector('input[name*="[followup_label]"]');
            const followupPlaceholder = option.querySelector('input[name*="[followup_placeholder]"]');
            const followupRequired = option.querySelector('input[name*="[followup_required]"]');
            
            if (labelInput) labelInput.name = `options[${index}][label]`;
            if (sortInput) {
                sortInput.name = `options[${index}][sort_order]`;
                sortInput.value = index + 1;
            }
            if (followupToggle) {
                followupToggle.name = `options[${index}][has_followup]`;
                followupToggle.id = `edit_followup_${index}`;
                const followupToggleLabel = option.querySelector(`label[for*="edit_followup_"]`);
                if (followupToggleLabel) followupToggleLabel.setAttribute('for', `edit_followup_${index}`);
            }
            if (followupLabel) followupLabel.name = `options[${index}][followup_label]`;
            if (followupPlaceholder) followupPlaceholder.name = `options[${index}][followup_placeholder]`;
            if (followupRequired) {
                followupRequired.name = `options[${index}][followup_required]`;
                followupRequired.id = `edit_followup_required_${index}`;
                const followupRequiredLabel = option.querySelector(`label[for*="edit_followup_required_"]`);
                if (followupRequiredLabel) followupRequiredLabel.setAttribute('for', `edit_followup_required_${index}`);
            }
        });
    };
});

// Function to toggle follow-up fields in edit modal
window.toggleEditFollowupFields = function(checkbox) {
    const optionItem = checkbox.closest('.option-item');
    const followupConfig = optionItem.querySelector('.followup-config');
    
    if (checkbox.checked) {
        followupConfig.classList.remove('d-none');
    } else {
        followupConfig.classList.add('d-none');
        // Clear the follow-up fields when disabled
        const inputs = followupConfig.querySelectorAll('input[type="text"]');
        inputs.forEach(input => input.value = '');
        const requiredCheckbox = followupConfig.querySelector('input[type="checkbox"]');
        if (requiredCheckbox) requiredCheckbox.checked = false;
    }
}

// Function to populate edit modal
function populateEditModal(questionData) {
    const question = questionData.question;
    const options = questionData.options || [];
    
    document.getElementById('edit_question_id').value = question.id;
    document.getElementById('edit_label').value = question.label || '';
    document.getElementById('edit_description').value = question.description || '';
    document.getElementById('edit_page').value = question.page || '';
    document.getElementById('edit_sort_order').value = question.sort_order || 0;
    
    // Set checkboxes
    document.getElementById('edit_is_required').checked = question.is_required == 1;
    document.getElementById('edit_is_active').checked = question.is_active == 1;
    
    // Set Select2 value
    const typeSelect = document.getElementById('edit_type');
    if (typeSelect) {
        typeSelect.value = question.type || '';
        $(typeSelect).trigger('change');
    }
    
    // Handle options for MCQ questions
    const optionsSection = document.getElementById('edit-options-section');
    const optionsContainer = document.getElementById('edit-options-container');
    
    // Clear existing options
    optionsContainer.innerHTML = '';
    
    if (question.type === 'single_mcq' || question.type === 'multi_mcq') {
        // Show options section
        optionsSection.classList.remove('d-none');
        
        // Add existing options
        if (options.length > 0) {
            options.forEach((option, index) => {
                addEditOptionWithValue(option.label, index + 1, {
                    has_followup: option.has_followup,
                    followup_label: option.followup_label,
                    followup_placeholder: option.followup_placeholder,
                    followup_required: option.followup_required
                });
            });
        } else {
            // Add 2 default empty options
            addEditOptionWithValue('', 1);
            addEditOptionWithValue('', 2);
        }
    } else {
        // Hide options section for non-MCQ questions
        optionsSection.classList.add('d-none');
    }
}

// Helper function to add option with specific value and sort order
function addEditOptionWithValue(value = '', sortOrder = 1, followupData = {}) {
    const optionsContainer = document.getElementById('edit-options-container');
    const optionIndex = optionsContainer.children.length;
    
    const hasFollowup = followupData.has_followup == 1;
    const followupLabel = followupData.followup_label || '';
    const followupPlaceholder = followupData.followup_placeholder || '';
    const followupRequired = followupData.followup_required == 1;
    
    const optionDiv = document.createElement('div');
    optionDiv.className = 'mb-4 option-item border p-3 rounded';
    optionDiv.innerHTML = `
        <div class="d-flex align-items-start">
            <div class="flex-grow-1 me-3">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Option Text</label>
                    <input type="text" name="options[${optionIndex}][label]" class="form-control form-control-solid" placeholder="Enter option text" value="${value}" required />
                    <input type="hidden" name="options[${optionIndex}][sort_order]" value="${sortOrder}" />
                </div>
                
                <!-- Follow-up Configuration -->
                <div class="separator separator-dashed my-3"></div>
                <div class="mb-3">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input followup-toggle" type="checkbox" name="options[${optionIndex}][has_followup]" value="1" id="edit_followup_${optionIndex}" onchange="toggleEditFollowupFields(this)" ${hasFollowup ? 'checked' : ''} />
                        <label class="form-check-label fw-semibold text-gray-700" for="edit_followup_${optionIndex}">
                            Show follow-up field when this option is selected
                        </label>
                    </div>
                </div>
                
                <!-- Follow-up fields -->
                <div class="followup-config ${hasFollowup ? '' : 'd-none'}" id="edit_followup_config_${optionIndex}">
                    <div class="bg-light-primary p-3 rounded">
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">Follow-up Field Label</label>
                            <input type="text" name="options[${optionIndex}][followup_label]" class="form-control form-control-solid" placeholder="e.g., Please tell us more..." value="${followupLabel}" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold text-primary">Follow-up Field Placeholder</label>
                            <input type="text" name="options[${optionIndex}][followup_placeholder]" class="form-control form-control-solid" placeholder="e.g., Enter details here..." value="${followupPlaceholder}" />
                        </div>
                        <div class="form-check form-switch form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" name="options[${optionIndex}][followup_required]" value="1" id="edit_followup_required_${optionIndex}" ${followupRequired ? 'checked' : ''} />
                            <label class="form-check-label fw-semibold text-primary" for="edit_followup_required_${optionIndex}">
                                Make follow-up field required
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-sm btn-light-danger remove-edit-option-btn" onclick="removeEditOption(this)">
                <i class="ki-duotone ki-trash fs-5">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                </i>
            </button>
        </div>
    `;
    
    optionsContainer.appendChild(optionDiv);
}
</script>