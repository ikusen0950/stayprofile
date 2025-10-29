<!-- View Role Modal -->
<div class="modal fade" id="viewRoleModal" tabindex="-1" aria-labelledby="viewRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="viewRoleModalLabel">
                    <i class="ki-duotone ki-eye fs-2 text-primary me-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                    Role Details
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <!-- Role Information -->
                <div class="card border-0">
                    <div class="card-header bg-light-primary">
                        <h6 class="card-title mb-0 text-primary">
                            <i class="ki-duotone ki-profile-user fs-3 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                                <span class="path4"></span>
                            </i>
                            Role Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <!-- Role Name -->
                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label class="fw-bold text-muted">Role Name</label>
                            </div>
                            <div class="col-lg-8">
                                <span id="view_role_name" class="fw-bold text-dark fs-6"></span>
                            </div>
                        </div>

                        <!-- Description -->
                        <div id="view_description_section" class="row mb-4">
                            <div class="col-lg-4">
                                <label class="fw-bold text-muted">Description</label>
                            </div>
                            <div class="col-lg-8">
                                <span id="view_description" class="text-dark"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <?php if (isset($permissions['canEdit']) && $permissions['canEdit']): ?>
                <button type="button" id="view_edit_btn" class="btn btn-primary" onclick="editRoleFromView()">
                    <i class="ki-duotone ki-pencil fs-2"></i>
                    Edit Role
                </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
function editRoleFromView() {
    const roleId = document.getElementById('view_edit_btn').getAttribute('data-role-id');
    if (roleId) {
        // Close view modal
        const viewModal = bootstrap.Modal.getInstance(document.getElementById('viewRoleModal'));
        viewModal.hide();
        
        // Wait for modal to close, then open edit modal
        setTimeout(() => {
            editRole(roleId);
        }, 300);
    }
}
</script>