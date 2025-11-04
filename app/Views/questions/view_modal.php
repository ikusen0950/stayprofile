<!--begin::View Question Modal-->
<div class="modal fade" id="viewQuestionModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Question Details</h2>
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
                <!--begin::Basic Information-->
                <div class="card card-flush mb-6">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Basic Information</h3>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <!--begin::Label-->
                        <div class="mb-4">
                            <label class="fw-semibold fs-6 mb-2 text-gray-600">Question Label</label>
                            <div class="fw-bold fs-6" id="view_question_label">-</div>
                        </div>
                        <!--end::Label-->

                        <!--begin::Description-->
                        <div class="mb-4" id="view_description_section">
                            <label class="fw-semibold fs-6 mb-2 text-gray-600">Description</label>
                            <div class="fw-bold fs-6" id="view_description">-</div>
                        </div>
                        <!--end::Description-->

                        <!--begin::Type-->
                        <div class="mb-4">
                            <label class="fw-semibold fs-6 mb-2 text-gray-600">Question Type</label>
                            <div id="view_type">-</div>
                        </div>
                        <!--end::Type-->
                    </div>
                </div>
                <!--end::Basic Information-->

                <!--begin::Configuration-->
                <div class="card card-flush mb-6">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Configuration</h3>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Page-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Page</label>
                                    <div class="fw-bold fs-6" id="view_page">-</div>
                                </div>
                                <!--end::Page-->

                                <!--begin::Sort Order-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Sort Order</label>
                                    <div class="fw-bold fs-6" id="view_sort_order">-</div>
                                </div>
                                <!--end::Sort Order-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Required-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Required</label>
                                    <div id="view_required">-</div>
                                </div>
                                <!--end::Required-->

                                <!--begin::Active-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Status</label>
                                    <div id="view_active">-</div>
                                </div>
                                <!--end::Active-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Configuration-->

                <!--begin::Options (for MCQ questions)-->
                <div class="card card-flush mb-6 d-none" id="view-options-section">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>Question Options</h3>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="view-options-container">
                            <!-- Options will be populated dynamically -->
                        </div>
                    </div>
                </div>
                <!--end::Options-->

                <!--begin::System Information-->
                <div class="card card-flush">
                    <div class="card-header">
                        <div class="card-title">
                            <h3>System Information</h3>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-md-6">
                                <!--begin::Created By-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Created By</label>
                                    <div class="fw-bold fs-6" id="view_created_by">-</div>
                                </div>
                                <!--end::Created By-->

                                <!--begin::Created At-->
                                <div class="mb-4">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Created At</label>
                                    <div class="fw-bold fs-6" id="view_created_at">-</div>
                                </div>
                                <!--end::Created At-->
                            </div>
                            <div class="col-md-6">
                                <!--begin::Updated By-->
                                <div class="mb-4" id="view_updated_by_section">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Updated By</label>
                                    <div class="fw-bold fs-6" id="view_updated_by">-</div>
                                </div>
                                <!--end::Updated By-->

                                <!--begin::Updated At-->
                                <div class="mb-4" id="view_updated_at_section">
                                    <label class="fw-semibold fs-6 mb-2 text-gray-600">Updated At</label>
                                    <div class="fw-bold fs-6" id="view_updated_at">-</div>
                                </div>
                                <!--end::Updated At-->
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::System Information-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <?php if ($permissions['canEdit']): ?>
                <button type="button" class="btn btn-primary" id="view_edit_btn" onclick="editQuestionFromView()">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    Edit Question
                </button>
                <?php endif; ?>
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::View Question Modal-->

<script>
// Function to populate view modal
function populateViewModal(responseData) {
    const question = responseData.question;
    const options = responseData.options || [];
    
    // Basic question info
    document.getElementById('view_question_label').textContent = question.label || '-';
    
    // Description (show/hide based on availability)
    const description = document.getElementById('view_description');
    const descriptionSection = document.getElementById('view_description_section');
    
    if (question.description && question.description.trim() !== '') {
        description.textContent = question.description;
        descriptionSection.style.display = 'block';
    } else {
        description.textContent = 'No description provided';
        descriptionSection.style.display = 'block';
    }
    
    // Question type with badge
    const typeElement = document.getElementById('view_type');
    const typeNames = {
        'text': 'Text Input',
        'textarea': 'Textarea',
        'single_mcq': 'Single Choice (MCQ)',
        'multi_mcq': 'Multiple Choice (MCQ)',
        'text_block': 'Text Block'
    };
    const typeColors = {
        'text': 'bg-light-primary',
        'textarea': 'bg-light-info',
        'single_mcq': 'bg-light-warning',
        'multi_mcq': 'bg-light-success',
        'text_block': 'bg-light-secondary'
    };
    
    const typeName = typeNames[question.type] || question.type || 'Unknown';
    const typeColor = typeColors[question.type] || 'bg-light-secondary';
    typeElement.innerHTML = `<span class="badge ${typeColor} type-badge">${typeName}</span>`;
    
    // Configuration
    document.getElementById('view_page').textContent = question.page || '-';
    document.getElementById('view_sort_order').textContent = question.sort_order || '0';
    
    // Required status
    const requiredElement = document.getElementById('view_required');
    if (question.is_required == 1) {
        requiredElement.innerHTML = '<span class="badge bg-light-danger question-required">Yes</span>';
    } else {
        requiredElement.innerHTML = '<span class="badge bg-light-secondary">No</span>';
    }
    
    // Active status
    const activeElement = document.getElementById('view_active');
    if (question.is_active == 1) {
        activeElement.innerHTML = '<span class="badge bg-light-success">Active</span>';
    } else {
        activeElement.innerHTML = '<span class="badge bg-light-danger">Inactive</span>';
    }
    
    // Handle options for MCQ questions
    const optionsSection = document.getElementById('view-options-section');
    const optionsContainer = document.getElementById('view-options-container');
    
    if (question.type === 'single_mcq' || question.type === 'multi_mcq') {
        // Show options section
        optionsSection.classList.remove('d-none');
        
        // Clear existing options
        optionsContainer.innerHTML = '';
        
        if (options.length > 0) {
            options.forEach((option, index) => {
                const optionDiv = document.createElement('div');
                optionDiv.className = 'mb-2 p-3 bg-light rounded';
                optionDiv.innerHTML = `
                    <div class="d-flex align-items-center">
                        <span class="badge badge-circle badge-light-primary me-3">${index + 1}</span>
                        <span class="fw-semibold">${option.label}</span>
                    </div>
                `;
                optionsContainer.appendChild(optionDiv);
            });
        } else {
            optionsContainer.innerHTML = '<div class="text-muted fst-italic">No options defined</div>';
        }
    } else {
        // Hide options section for non-MCQ questions
        optionsSection.classList.add('d-none');
    }
    
    // Audit info
    document.getElementById('view_created_by').textContent = question.created_by_name || 'System';
    document.getElementById('view_created_at').textContent = question.created_at ? 
        new Date(question.created_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        }) : '-';
    
    // Updated info (show/hide based on availability)
    const updatedBySection = document.getElementById('view_updated_by_section');
    const updatedAtSection = document.getElementById('view_updated_at_section');
    
    if (question.updated_by_name) {
        document.getElementById('view_updated_by').textContent = question.updated_by_name;
        updatedBySection.style.display = 'block';
    } else {
        updatedBySection.style.display = 'none';
    }
    
    if (question.updated_at) {
        document.getElementById('view_updated_at').textContent = new Date(question.updated_at).toLocaleDateString('en-US', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
        updatedAtSection.style.display = 'block';
    } else {
        updatedAtSection.style.display = 'none';
    }
    
    // Set question ID for edit button if it exists
    const editBtn = document.getElementById('view_edit_btn');
    if (editBtn) {
        editBtn.setAttribute('data-question-id', question.id);
    }
}

// Function to edit question from view modal
function editQuestionFromView() {
    const questionId = document.getElementById('view_edit_btn').getAttribute('data-question-id');
    if (questionId) {
        // Hide view modal
        const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewQuestionModal'));
        viewModal.hide();
        
        // Show edit modal
        editQuestion(questionId);
    }
}
</script>