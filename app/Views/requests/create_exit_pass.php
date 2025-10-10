<?= $this->include('layout/header.php') ?>

<style>
.form-section {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 25px;
    margin-bottom: 20px;
    border-left: 4px solid var(--bs-success);
}

.form-section h4 {
    color: var(--bs-success);
    margin-bottom: 20px;
}

.btn-back {
    background: linear-gradient(45deg, #6c757d, #5a6268);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-back:hover {
    background: linear-gradient(45deg, #5a6268, #495057);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    color: white;
}

.btn-submit {
    background: linear-gradient(45deg, #28a745, #20c997);
    border: none;
    color: white;
    transition: all 0.3s ease;
}

.btn-submit:hover {
    background: linear-gradient(45deg, #20c997, #17a2b8);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    color: white;
}
</style>

<!--begin::Content-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-fluid">
            
            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success d-flex align-items-center p-5 mb-10">
                <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-success">Success</h4>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger d-flex align-items-center p-5 mb-10">
                <i class="ki-duotone ki-shield-cross fs-2hx text-danger me-4">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-danger">Error</h4>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!--begin::Card-->
            <div class="card shadow-sm">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2 class="fw-bold text-gray-800">
                            <i class="ki-duotone ki-exit-right fs-1 text-success me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Exit Pass Request
                        </h2>
                        <p class="text-muted fs-6 mt-2">Request permission to leave the premises temporarily</p>
                    </div>
                    <!--end::Card title-->
                    
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="/requests/add_request" class="btn btn-back me-3">
                            <i class="ki-duotone ki-arrow-left fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Back
                        </a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Form-->
                    <form id="exitPassForm" action="/requests/store" method="POST">
                        <input type="hidden" name="type" value="Exit Pass">
                        <input type="hidden" name="type_color" value="#28a745">
                        
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h4 class="text-success fw-bold mb-6">
                                <i class="ki-duotone ki-user fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Basic Information
                            </h4>
                            
                            <!--begin::Row-->
                            <div class="row g-6">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Requester</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select name="user_id" class="form-select form-select-solid" data-control="select2" 
                                                data-placeholder="Select a user..." required>
                                            <option></option>
                                            <?php if (!empty($users)): ?>
                                                <?php foreach ($users as $user): ?>
                                                    <option value="<?= esc($user['id']) ?>"><?= esc($user['full_name'] ?? 'Unknown') ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Status</label>
                                        <!--end::Label-->
                                        <!--begin::Select-->
                                        <select name="status_id" class="form-select form-select-solid" data-control="select2" 
                                                data-placeholder="Select a status..." required>
                                            <option></option>
                                            <?php if (!empty($statuses)): ?>
                                                <?php foreach ($statuses as $status): ?>
                                                    <option value="<?= esc($status['id']) ?>"><?= esc($status['name'] ?? 'Unknown') ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                        <!--end::Select-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>

                        <!-- Exit Details Section -->
                        <div class="form-section">
                            <h4 class="text-success fw-bold mb-6">
                                <i class="ki-duotone ki-calendar fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Exit Details
                            </h4>
                            
                            <!--begin::Row-->
                            <div class="row g-6">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Expected Departure Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" name="expected_departure_date" class="form-control form-control-solid" required />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="required fw-semibold fs-6 mb-2">Expected Departure Time</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="time" name="expected_departure_time" class="form-control form-control-solid" required />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                            
                            <!--begin::Row-->
                            <div class="row g-6 mt-3">
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Expected Return Date</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="date" name="expected_arrival_date" class="form-control form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                                
                                <!--begin::Col-->
                                <div class="col-md-6">
                                    <!--begin::Input group-->
                                    <div class="fv-row">
                                        <!--begin::Label-->
                                        <label class="fw-semibold fs-6 mb-2">Expected Return Time</label>
                                        <!--end::Label-->
                                        <!--begin::Input-->
                                        <input type="time" name="expected_arrival_time" class="form-control form-control-solid" />
                                        <!--end::Input-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Row-->
                        </div>

                        <!-- Purpose and Remarks Section -->
                        <div class="form-section">
                            <h4 class="text-success fw-bold mb-6">
                                <i class="ki-duotone ki-notepad fs-2 me-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Purpose & Remarks
                            </h4>
                            
                            <!--begin::Input group-->
                            <div class="fv-row mb-6">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Purpose of Exit</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="type_description" class="form-control form-control-solid" rows="3" 
                                          placeholder="Please describe the purpose of your exit..." required></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            
                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Additional Remarks</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="remarks" class="form-control form-control-solid" rows="3" 
                                          placeholder="Any additional remarks or special instructions (optional)"></textarea>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                        </div>

                        <!-- Submit Section -->
                        <div class="text-end">
                            <button type="button" class="btn btn-light me-3" onclick="window.location.href='/requests/add_request'">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-submit" id="submitBtn">
                                <span class="indicator-label">
                                    <i class="ki-duotone ki-check fs-2 me-2">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    Submit Exit Pass Request
                                </span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
</div>
<!--end::Content-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('exitPassForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form && submitBtn) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Show loading state
            submitBtn.setAttribute('data-kt-indicator', 'on');
            submitBtn.disabled = true;
            
            const formData = new FormData(form);
            
            fetch('/requests/store', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire('Success!', data.message, 'success').then(() => {
                        window.location.href = '/requests';
                    });
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
                Swal.fire('Error', 'Failed to submit request', 'error');
            })
            .finally(() => {
                // Hide loading state
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.disabled = false;
            });
        });
    }
});
</script>

<?= $this->include('layout/footer.php') ?>