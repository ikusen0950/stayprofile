<!--begin::View Authorization Rule Modal-->
<style>
/* Fullscreen modals on mobile */
@media (max-width: 767.98px) {
    #viewAuthorizationRuleModal .modal-dialog {
        margin: 0 !important;
        max-width: 100% !important;
        width: 100% !important;
        height: 100% !important;
        max-height: 100% !important;
    }

    #viewAuthorizationRuleModal .modal-content {
        height: 100vh !important;
        border: none !important;
        border-radius: 0 !important;
        display: flex !important;
        flex-direction: column !important;
    }

    #viewAuthorizationRuleModal .modal-body {
        flex: 1 !important;
        overflow-y: auto !important;
        padding: 1rem !important;
    }

    #viewAuthorizationRuleModal .modal-header {
        padding: 1rem !important;
        border-bottom: 1px solid var(--bs-border-color) !important;
        flex-shrink: 0 !important;
    }

    #viewAuthorizationRuleModal .modal-footer {
        padding: 1rem !important;
        border-top: 1px solid var(--bs-border-color) !important;
        flex-shrink: 0 !important;
    }

    /* Ensure modal backdrop doesn't interfere */
    #viewAuthorizationRuleModal .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }
}

/* Better Select2 dropdown positioning in modals */
.select2-container--bootstrap5 .select2-dropdown {
    z-index: 1060;
}
</style>

<div class="modal fade" id="viewAuthorizationRuleModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Authorization Rule Details</h2>
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
                <!--begin::Details-->
                <div class="d-flex flex-column">
                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Col-->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">User:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_user_name">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Status:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6" id="view_status">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Col-->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Rule Type:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_rule_type">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Target Type:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_target_type">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Col-->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Approval Level:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_approval_level">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Divisions Row-->
                    <div class="row mb-7" id="view_divisions_row" style="display: none;">
                        <!--begin::Col-->
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Divisions:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_divisions">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Divisions Row-->

                    <!--begin::Departments Row-->
                    <div class="row mb-7" id="view_departments_row" style="display: none;">
                        <!--begin::Col-->
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Departments:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_departments">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Departments Row-->

                    <!--begin::Sections Row-->
                    <div class="row mb-7" id="view_sections_row" style="display: none;">
                        <!--begin::Col-->
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Sections:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_sections">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Sections Row-->

                    <!--begin::Description Row-->
                    <div class="row mb-7">
                        <!--begin::Col-->
                        <div class="col-12">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Description:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-800" id="view_description">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Description Row-->

                    <!--begin::Audit Row-->
                    <div class="row mb-4">
                        <!--begin::Col-->
                        <div class="col-lg-6 mb-4 mb-lg-0">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Created At:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-600" id="view_created_at">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                        <!--begin::Col-->
                        <div class="col-lg-6">
                            <!--begin::Label-->
                            <label class="fw-bold fs-6 mb-2">Created By:</label>
                            <!--end::Label-->
                            <!--begin::Value-->
                            <div class="fs-6 text-gray-600" id="view_created_by">-</div>
                            <!--end::Value-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Audit Row-->
                </div>
                <!--end::Details-->
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                <!--end::Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::View Authorization Rule Modal-->

<script>
// Function to populate view modal (called from index.php)
window.populateViewAuthorizationRuleModal = function(rule, callback) {
    // Populate basic information
    document.getElementById('view_user_name').textContent = rule.user_display_name || rule.user_name || 'Unknown';
    document.getElementById('view_rule_type').textContent = rule.rule_type || '-';
    document.getElementById('view_target_type').textContent = rule.target_type || '-';
    document.getElementById('view_description').textContent = rule.description || 'No description provided';
    document.getElementById('view_created_at').textContent = rule.created_at || '-';
    document.getElementById('view_created_by').textContent = rule.created_by_name || 'Unknown';
    
    // Handle status display
    const statusElement = document.getElementById('view_status');
    if (rule.is_active == 1) {
        statusElement.innerHTML = '<span class="badge badge-light-success">Active</span>';
    } else {
        statusElement.innerHTML = '<span class="badge badge-light-danger">Inactive</span>';
    }
    
    // Handle approval level display with color-coded badges
    const approvalLevelElement = document.getElementById('view_approval_level');
    const approvalLevel = rule.approval_level || 'no_approval';
    switch (approvalLevel) {
        case 'level_1':
            approvalLevelElement.innerHTML = '<span class="badge badge-light-warning">Level 1</span>';
            break;
        case 'level_2':
            approvalLevelElement.innerHTML = '<span class="badge badge-light-primary">Level 2</span>';
            break;
        case 'level_3':
            approvalLevelElement.innerHTML = '<span class="badge badge-light-info">Level 3</span>';
            break;
        case 'no_approval':
        default:
            approvalLevelElement.innerHTML = '<span class="badge badge-light-secondary">No Approval</span>';
            break;
    }
    
    // Handle divisions display
    const divisionsRow = document.getElementById('view_divisions_row');
    if (rule.division_names && rule.division_names.length > 0) {
        document.getElementById('view_divisions').textContent = rule.division_names.join(', ');
        divisionsRow.style.display = 'block';
    } else {
        divisionsRow.style.display = 'none';
    }
    
    // Handle departments display
    const departmentsRow = document.getElementById('view_departments_row');
    if (rule.department_names && rule.department_names.length > 0) {
        document.getElementById('view_departments').textContent = rule.department_names.join(', ');
        departmentsRow.style.display = 'block';
    } else {
        departmentsRow.style.display = 'none';
    }
    
    // Handle sections display
    const sectionsRow = document.getElementById('view_sections_row');
    if (rule.section_names && rule.section_names.length > 0) {
        document.getElementById('view_sections').textContent = rule.section_names.join(', ');
        sectionsRow.style.display = 'block';
    } else {
        sectionsRow.style.display = 'none';
    }
    
    // Call callback if provided
    if (typeof callback === 'function') {
        callback();
    }
};
</script>