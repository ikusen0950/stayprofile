<!--begin::Send Notification to All Users Modal-->
<div class="modal fade" id="sendBulkNotificationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Send Notification to All Active Users</h2>
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
                <div class="row">
                    <!--begin::Left side - Form-->
                    <div class="col-lg-7">
                        <!--begin::Form-->
                        <form id="bulkNotificationForm" class="form">
                            <!--begin::Alert-->
                            <div class="alert alert-info d-flex align-items-center p-5 mb-7">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-info">Bulk Notification</h4>
                                    <span>This will send a push notification to all active users who have device tokens registered.</span>
                                </div>
                            </div>
                            <!--end::Alert-->

                            <!--begin::Recipients Info-->
                            <div class="card card-flush mb-7">
                                <div class="card-header">
                                    <div class="card-title">
                                        <h3 class="fw-bold">Recipients</h3>
                                    </div>
                                </div>
                                <div class="card-body p-5">
                                    <div class="d-flex flex-wrap">
                                        <div class="border bg-secondary border-dashed rounded p-3 me-3 mb-3">
                                            <div class="fs-1 fw-bold text-gray-800" id="totalUsersCount">...</div>
                                            <div class="fs-7 fw-semibold text-gray-500">Total Active Users</div>
                                        </div>
                                        <div class="border bg-success border-dashed rounded p-3 me-3 mb-3">
                                            <div class="fs-1 fw-bold text-white" id="usersWithTokensCount">...</div>
                                            <div class="fs-7 fw-semibold text-white">With Device Tokens</div>
                                        </div>
                                        <div class="border bg-warning border-dashed rounded p-3 mb-3">
                                            <div class="fs-1 fw-bold text-white" id="deliveryPercentage">...</div>
                                            <div class="fs-7 fw-semibold text-white">Delivery Rate</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Recipients Info-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Notification Title</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="title" id="bulkNotificationTitle" class="form-control form-control-solid mb-3 mb-lg-0" 
                                       placeholder="Enter notification title" maxlength="50" />
                                <div class="form-text">Maximum 50 characters. <span id="titleCharCount">0/50</span></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Notification Message</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea name="body" id="bulkNotificationBody" class="form-control form-control-solid" rows="4" 
                                          placeholder="Enter notification message" maxlength="200"></textarea>
                                <div class="form-text">Maximum 200 characters. <span id="bodyCharCount">0/200</span></div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Action URL</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="url" id="bulkNotificationUrl" class="form-control form-control-solid mb-3 mb-lg-0" 
                                       placeholder="Enter URL to open when notification is tapped (optional)" />
                                <div class="form-text">Optional URL to redirect when notification is clicked</div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Schedule Options-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Delivery Options</label>
                                <!--end::Label-->
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_type" value="immediate" id="immediate" checked>
                                    <label class="form-check-label" for="immediate">
                                        Send Immediately
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="delivery_type" value="scheduled" id="scheduled">
                                    <label class="form-check-label" for="scheduled">
                                        Schedule for Later
                                    </label>
                                </div>
                                <div id="scheduleOptions" class="mt-3" style="display: none;">
                                    <input type="datetime-local" name="scheduled_at" class="form-control form-control-solid" />
                                </div>
                            </div>
                            <!--end::Schedule Options-->

                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Left side-->

                    <!--begin::Right side - Phone Preview-->
                    <div class="col-lg-5">
                        <div class="d-flex flex-column h-100">
                            <!--begin::Preview Label-->
                            <div class="mb-5">
                                <h3 class="fw-bold text-gray-800">Live Preview</h3>
                                <span class="text-gray-600">See how your notification will appear on users' devices</span>
                            </div>
                            <!--end::Preview Label-->

                            <!--begin::Phone Container-->
                            <div class="d-flex justify-content-center flex-grow-1">
                                <!--begin::Phone Frame-->
                                <div class="phone-container">
                                    <div class="phone-frame">
                                        <!--begin::Phone Screen-->
                                        <div class="phone-screen">
                                            <!--begin::Status Bar-->
                                            <div class="status-bar">
                                                <div class="status-left">
                                                    <span class="time">9:41</span>
                                                </div>
                                                <div class="status-right">
                                                    <i class="fas fa-signal"></i>
                                                    <i class="fas fa-wifi"></i>
                                                    <i class="fas fa-battery-three-quarters"></i>
                                                </div>
                                            </div>
                                            <!--end::Status Bar-->

                                            <!--begin::Notifications-->
                                            <div class="phone-notifications">
                                                <!--begin::Notification Preview-->
                                                <div class="notification-preview" id="notificationPreview">
                                                    <div class="notification-icon">
                                                        <img src="/assets/media/logos/favicon.ico" alt="App Icon" />
                                                    </div>
                                                    <div class="notification-content">
                                                        <div class="notification-header">
                                                            <span class="app-name">Islanders App</span>
                                                            <span class="notification-time">now</span>
                                                        </div>
                                                        <div class="notification-title" id="previewTitle">Notification Title</div>
                                                        <div class="notification-body" id="previewBody">Notification message will appear here...</div>
                                                    </div>
                                                </div>
                                                <!--end::Notification Preview-->
                                            </div>
                                            <!--end::Notifications-->
                                        </div>
                                        <!--end::Phone Screen-->
                                    </div>
                                </div>
                                <!--end::Phone Frame-->
                            </div>
                            <!--end::Phone Container-->
                        </div>
                    </div>
                    <!--end::Right side-->
                </div>
            </div>
            <!--end::Modal body-->
            
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="button" class="btn btn-primary" id="sendBulkNotificationBtn">
                    <span class="indicator-label">
                        <i class="ki-duotone ki-send fs-2 me-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Send to All Users
                    </span>
                    <span class="indicator-progress">Sending...
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
<!--end::Send Notification to All Users Modal-->

<style>
/* Phone Preview Styles */
.phone-container {
    perspective: 1000px;
}

.phone-frame {
    width: 300px;
    height: 600px;
    background: linear-gradient(145deg, #2c3e50, #34495e);
    border-radius: 30px;
    padding: 20px 15px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    position: relative;
    transform: rotateY(-5deg) rotateX(5deg);
    transition: transform 0.3s ease;
}

.phone-frame:hover {
    transform: rotateY(0deg) rotateX(0deg);
}

.phone-screen {
    width: 100%;
    height: 100%;
    background: linear-gradient(180deg, #1a1a1a 0%, #2d2d2d 100%);
    border-radius: 20px;
    overflow: hidden;
    position: relative;
}

.status-bar {
    height: 30px;
    background: rgba(0,0,0,0.8);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 15px;
    font-size: 12px;
    font-weight: 600;
}

.status-right i {
    margin-left: 4px;
    font-size: 10px;
}

.phone-notifications {
    padding: 10px;
    background: linear-gradient(180deg, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0.7) 100%);
    height: calc(100% - 30px);
    overflow-y: auto;
}

.notification-preview {
    background: rgba(255,255,255,0.95);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 8px;
    display: flex;
    align-items: flex-start;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    transition: all 0.3s ease;
    border-left: 4px solid #3b82f6;
}

.notification-preview.sample {
    opacity: 0.6;
    border-left-color: #6b7280;
}

.notification-preview:hover {
    transform: translateX(2px);
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.notification-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    background: #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    flex-shrink: 0;
}

.notification-icon img {
    width: 20px;
    height: 20px;
    border-radius: 4px;
}

.notification-icon i {
    font-size: 14px;
}

.notification-content {
    flex: 1;
    min-width: 0;
}

.notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2px;
}

.app-name {
    font-size: 11px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.notification-time {
    font-size: 10px;
    color: #9ca3af;
}

.notification-title {
    font-size: 13px;
    font-weight: 600;
    color: #111827;
    margin-bottom: 2px;
    line-height: 1.3;
    word-wrap: break-word;
}

.notification-body {
    font-size: 12px;
    color: #4b5563;
    line-height: 1.4;
    word-wrap: break-word;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Character count styles */
.form-text {
    font-size: 11px;
}

.char-warning {
    color: #f59e0b !important;
}

.char-danger {
    color: #ef4444 !important;
}

/* Animation for new notifications */
@keyframes slideIn {
    from {
        transform: translateY(-20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.notification-preview.fresh {
    animation: slideIn 0.5s ease-out;
}

/* Responsive adjustments */
@media (max-width: 991px) {
    .phone-frame {
        width: 250px;
        height: 500px;
        transform: none;
    }
    
    .modal-dialog.modal-xl {
        max-width: 90%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bulkForm = document.getElementById('bulkNotificationForm');
    const bulkModal = document.getElementById('sendBulkNotificationModal');
    const submitBtn = document.getElementById('sendBulkNotificationBtn');
    
    // Form elements
    const titleInput = document.getElementById('bulkNotificationTitle');
    const bodyInput = document.getElementById('bulkNotificationBody');
    const urlInput = document.getElementById('bulkNotificationUrl');
    
    // Preview elements
    const previewTitle = document.getElementById('previewTitle');
    const previewBody = document.getElementById('previewBody');
    const notificationPreview = document.getElementById('notificationPreview');
    
    // Character count elements
    const titleCharCount = document.getElementById('titleCharCount');
    const bodyCharCount = document.getElementById('bodyCharCount');
    
    // Schedule options
    const scheduleRadio = document.getElementById('scheduled');
    const immediateRadio = document.getElementById('immediate');
    const scheduleOptions = document.getElementById('scheduleOptions');
    
    // Load recipient statistics
    loadRecipientStats();
    
    // Real-time preview updates
    if (titleInput && previewTitle) {
        titleInput.addEventListener('input', function() {
            const value = this.value || 'Notification Title';
            previewTitle.textContent = value;
            
            // Update character count
            const count = this.value.length;
            titleCharCount.textContent = `${count}/50`;
            
            if (count > 40) {
                titleCharCount.classList.add('char-warning');
            } else {
                titleCharCount.classList.remove('char-warning');
            }
            
            if (count >= 50) {
                titleCharCount.classList.add('char-danger');
                titleCharCount.classList.remove('char-warning');
            } else {
                titleCharCount.classList.remove('char-danger');
            }
            
            // Add animation effect
            notificationPreview.classList.add('fresh');
            setTimeout(() => notificationPreview.classList.remove('fresh'), 500);
        });
    }
    
    if (bodyInput && previewBody) {
        bodyInput.addEventListener('input', function() {
            const value = this.value || 'Notification message will appear here...';
            previewBody.textContent = value;
            
            // Update character count
            const count = this.value.length;
            bodyCharCount.textContent = `${count}/200`;
            
            if (count > 160) {
                bodyCharCount.classList.add('char-warning');
            } else {
                bodyCharCount.classList.remove('char-warning');
            }
            
            if (count >= 200) {
                bodyCharCount.classList.add('char-danger');
                bodyCharCount.classList.remove('char-warning');
            } else {
                bodyCharCount.classList.remove('char-danger');
            }
            
            // Add animation effect
            notificationPreview.classList.add('fresh');
            setTimeout(() => notificationPreview.classList.remove('fresh'), 500);
        });
    }
    
    // Schedule options toggle
    if (scheduleRadio && immediateRadio) {
        scheduleRadio.addEventListener('change', function() {
            if (this.checked) {
                scheduleOptions.style.display = 'block';
            }
        });
        
        immediateRadio.addEventListener('change', function() {
            if (this.checked) {
                scheduleOptions.style.display = 'none';
            }
        });
    }
    
    // Form submission
    if (bulkForm && submitBtn) {
        submitBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Validate form
            if (!titleInput.value.trim()) {
                Swal.fire('Validation Error', 'Please enter a notification title', 'error');
                titleInput.focus();
                return;
            }
            
            if (!bodyInput.value.trim()) {
                Swal.fire('Validation Error', 'Please enter a notification message', 'error');
                bodyInput.focus();
                return;
            }
            
            // Show confirmation dialog
            Swal.fire({
                title: 'Send Bulk Notification?',
                html: `
                    <div class="text-start">
                        <p><strong>Title:</strong> ${titleInput.value}</p>
                        <p><strong>Message:</strong> ${bodyInput.value}</p>
                        <p><strong>Recipients:</strong> All active users with device tokens</p>
                        <div class="alert alert-warning mt-3">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            This action cannot be undone. The notification will be sent immediately to all recipients.
                        </div>
                    </div>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Send Now',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    sendBulkNotification();
                }
            });
        });
    }
    
    function sendBulkNotification() {
        // Show loading state
        submitBtn.setAttribute('data-kt-indicator', 'on');
        submitBtn.disabled = true;
        
        const formData = new FormData(bulkForm);
        
        secureFetch('/notifications/send-bulk', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
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
                // Hide modal
                const modal = bootstrap.Modal.getInstance(bulkModal);
                modal.hide();
                
                // Reset form
                bulkForm.reset();
                resetPreview();
                
                // Show detailed success message
                Swal.fire({
                    title: 'Notifications Sent!',
                    html: `
                        <div class="text-start">
                            <p><i class="fas fa-check-circle text-success me-2"></i><strong>Sent successfully:</strong> ${data.sent_count || 0} notifications</p>
                            ${data.failed_count > 0 ? `<p><i class="fas fa-times-circle text-danger me-2"></i><strong>Failed:</strong> ${data.failed_count} notifications</p>` : ''}
                            <p><i class="fas fa-clock text-info me-2"></i><strong>Processing time:</strong> ${data.processing_time || 'N/A'}</p>
                        </div>
                    `,
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
                
            } else {
                Swal.fire('Error', data.message || 'Failed to send notifications', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error', 'Failed to send notifications', 'error');
        })
        .finally(() => {
            // Hide loading state
            submitBtn.removeAttribute('data-kt-indicator');
            submitBtn.disabled = false;
        });
    }
    
    function loadRecipientStats() {
        console.log('Loading recipient stats...');
        
        secureFetch('/notifications/recipient-stats', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            if (response.status === 401 || response.status === 403) {
                handleSessionExpired();
                return;
            }
            return response.json();
        })
        .then(data => {
            console.log('Stats data received:', data);
            if (data && data.success) {
                const totalElement = document.getElementById('totalUsersCount');
                const tokensElement = document.getElementById('usersWithTokensCount');
                const percentageElement = document.getElementById('deliveryPercentage');
                
                if (totalElement) totalElement.textContent = data.total_users || 0;
                if (tokensElement) tokensElement.textContent = data.users_with_tokens || 0;
                
                const percentage = data.total_users > 0 ? 
                    Math.round((data.users_with_tokens / data.total_users) * 100) : 0;
                if (percentageElement) percentageElement.textContent = percentage + '%';
                
                console.log('Stats updated successfully');
            } else {
                console.error('Stats API returned error:', data);
                // Set default values
                const totalElement = document.getElementById('totalUsersCount');
                const tokensElement = document.getElementById('usersWithTokensCount');
                const percentageElement = document.getElementById('deliveryPercentage');
                
                if (totalElement) totalElement.textContent = '0';
                if (tokensElement) tokensElement.textContent = '0';
                if (percentageElement) percentageElement.textContent = '0%';
            }
        })
        .catch(error => {
            console.error('Error loading stats:', error);
            // Set default values on error
            const totalElement = document.getElementById('totalUsersCount');
            const tokensElement = document.getElementById('usersWithTokensCount');
            const percentageElement = document.getElementById('deliveryPercentage');
            
            if (totalElement) totalElement.textContent = '0';
            if (tokensElement) tokensElement.textContent = '0';
            if (percentageElement) percentageElement.textContent = '0%';
        });
    }
    
    function resetPreview() {
        previewTitle.textContent = 'Notification Title';
        previewBody.textContent = 'Notification message will appear here...';
        titleCharCount.textContent = '0/50';
        bodyCharCount.textContent = '0/200';
        titleCharCount.classList.remove('char-warning', 'char-danger');
        bodyCharCount.classList.remove('char-warning', 'char-danger');
    }
    
    // Reset form when modal is hidden
    if (bulkModal) {
        bulkModal.addEventListener('hidden.bs.modal', function () {
            bulkForm.reset();
            resetPreview();
            scheduleOptions.style.display = 'none';
        });
    }
    
    // Define secureFetch if not already defined
    if (typeof secureFetch === 'undefined') {
        window.secureFetch = function(url, options = {}) {
            const defaultOptions = {
                credentials: 'same-origin',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    ...options.headers
                }
            };

            return fetch(url, {
                ...defaultOptions,
                ...options
            });
        };
    }
    
    // Define handleSessionExpired if not already defined
    if (typeof handleSessionExpired === 'undefined') {
        window.handleSessionExpired = function() {
            // Clear any stored session data
            localStorage.removeItem('user');
            sessionStorage.clear();

            // Show alert and redirect
            Swal.fire({
                icon: 'warning',
                title: 'Session Expired',
                text: 'Your session has expired. Please log in again.',
                confirmButtonText: 'Login',
                allowOutsideClick: false,
                allowEscapeKey: false
            }).then(() => {
                window.location.href = '/login';
            });
        };
    }
});
</script>