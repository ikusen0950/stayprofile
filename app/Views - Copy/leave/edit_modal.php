<!--begin::Edit Leave Modal-->
<style>
@media (max-width: 576px) {
    #editLeaveModal .modal-dialog {
        max-width: 100vw;
        width: 100vw;
        height: 100vh;
        margin: 0;
        padding: 0;
    }
    #editLeaveModal .modal-content {
        height: 100vh;
        border-radius: 0;
    }
    #editLeaveModal .modal-body {
        height: calc(100vh - 56px - 56px);
        overflow-y: auto;
    }
    #editLeaveModal .modal-header,
    #editLeaveModal .modal-footer {
        border-radius: 0;
    }
}
</style>
<div class="modal fade" id="editLeaveModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Edit Leave</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <div class="modal-body scroll-y p-4">
                <form id="editLeaveForm" class="form">
                    <input type="hidden" id="edit_leave_id" name="leave_id" />
                    <div class="d-flex flex-column">
                        <div class="fv-row mb-7">
                            <label class="required fw-semibold fs-6 mb-2">Leave Name</label>
                            <input type="text" id="edit_leave_name" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter leave name" />
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Module</label>
                            <select id="edit_module_id" name="module_id" class="form-select form-select-solid mb-3 mb-lg-0">
                                <option value="">Select module</option>
                                <?php if (!empty($modules)): ?>
                                    <?php foreach ($modules as $module): ?>
                                        <option value="<?= esc($module['id']) ?>"><?= esc($module['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Status</label>
                            <select id="edit_status_id" name="status_id" class="form-select form-select-solid mb-3 mb-lg-0">
                                <option value="">Select status</option>
                                <?php if (!empty($statuses)): ?>
                                    <?php foreach ($statuses as $status): ?>
                                        <option value="<?= esc($status['id']) ?>"><?= esc($status['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="fv-row mb-7">
                            <label class="fw-semibold fs-6 mb-2">Description</label>
                            <textarea id="edit_description" name="description" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                </form>
                    <div class="modal-footer d-flex justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="editLeaveSaveBtn">
                            <span class="indicator-label">Save</span>
                            <span class="indicator-progress" style="display: none;">Saving...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
            </div>
        </div>
    </div>
</div>
