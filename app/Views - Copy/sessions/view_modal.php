<!--begin::Modal - View Session-->
<div class="modal fade" id="viewSessionModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="viewSessionModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Session Details</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-sessions-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body px-5 my-7">
                <!--begin::Content-->
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="viewSessionModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#viewSessionModal_header" data-kt-scroll-wrappers="#viewSessionModal_scroll" data-kt-scroll-offset="300px">
                    
                    <!--begin::Session Header-->
                    <div class="d-flex align-items-center mb-8">
                        <div class="symbol symbol-60px me-5" id="view_profile_image_container">
                            <div class="symbol-label fs-2 fw-semibold bg-light-primary text-primary rounded-circle" id="view_user_avatar">
                                U
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="text-gray-900 fw-bold mb-1" id="view_user_name">User Name</h3>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light-info fw-bold me-3" id="view_islander_no">N/A</span>
                                <span class="badge badge-light-success fw-bold" id="view_session_status">Active</span>
                            </div>
                        </div>
                    </div>
                    <!--end::Session Header-->

                    <!--begin::Session Information Section-->
                    <h4 class="fw-bold text-gray-800 mb-5">Session Information</h4>
                    <div class="separator separator-dashed mt-2 mb-7"></div>

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Session ID</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_session_id">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">IP Address</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_ip_address">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Last Activity</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_last_activity">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Time Ago</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_time_ago">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::User Information Section-->
                    <h4 class="fw-bold text-gray-800 mb-5 mt-10">User Information</h4>
                    <div class="separator separator-dashed mt-2 mb-7"></div>

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_full_name">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Islander Number</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_user_islander_no">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Email</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_user_email">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Session Data Section-->
                    <h4 class="fw-bold text-gray-800 mb-5 mt-10">Session Data</h4>
                    <div class="separator separator-dashed mt-2 mb-7"></div>

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Login Status</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_login_status">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Session Data</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <div class="bg-light-info rounded p-3" id="view_session_data">
                                <pre class="mb-0" style="white-space: pre-wrap; font-size: 12px;" id="view_session_data_content">-</pre>
                            </div>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                </div>
                <!--end::Content-->
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button type="button" id="viewSessionModal_close" class="btn btn-light">Close</button>
                <!--end::Button-->
                <!--begin::Force Logout Button-->
                <?php if ($permissions['canDelete']): ?>
                <button type="button" id="viewSessionModal_logout" class="btn btn-danger ms-3">
                    <i class="ki-duotone ki-exit-right fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Force Logout
                </button>
                <?php endif; ?>
                <!--end::Force Logout Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - View Session-->

<script>
"use strict";

// Class definition
var ViewSessionModal = function () {
    var modal;
    var closeButton;
    var logoutButton;

    // Initialize modal
    var initModal = function () {
        modal = new bootstrap.Modal(document.querySelector('#viewSessionModal'));
    };

    // Initialize buttons
    var initButtons = function () {
        closeButton = document.querySelector('#viewSessionModal_close');
        logoutButton = document.querySelector('#viewSessionModal_logout');

        // Handle close button
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle modal close button
        document.querySelector('#viewSessionModal [data-kt-sessions-modal-action="close"]').addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle logout button
        if (logoutButton) {
            logoutButton.addEventListener('click', function (e) {
                e.preventDefault();
                const sessionId = this.getAttribute('data-session-id');
                if (sessionId && typeof forceLogoutSession === 'function') {
                    modal.hide();
                    forceLogoutSession(sessionId);
                } else if (sessionId) {
                    // Fallback if the function is not available globally
                    window.location.reload();
                }
            });
        }
    };

    // Populate modal with session data
    var populateModal = function (session) {
        // Check if session data exists
        if (!session) {
            console.error('Session data is undefined or null');
            return;
        }
        
        // Header information
        const avatarElement = document.getElementById('view_user_avatar');
        const nameElement = document.getElementById('view_user_name');
        const islanderNoElement = document.getElementById('view_islander_no');
        const statusElement = document.getElementById('view_session_status');

        if (avatarElement && session.user_name) {
            avatarElement.textContent = session.user_name.charAt(0).toUpperCase();
        }
        if (nameElement) {
            nameElement.textContent = session.user_name || 'Unknown User';
        }
        if (islanderNoElement) {
            islanderNoElement.textContent = session.islander_no || 'N/A';
        }
        if (statusElement) {
            // Determine if session is active (less than 1 hour old)
            const isActive = (Date.now() / 1000 - new Date(session.timestamp).getTime() / 1000) < 3600;
            statusElement.textContent = isActive ? 'ACTIVE' : 'EXPIRED';
            statusElement.className = isActive ? 'badge badge-light-success fw-bold' : 'badge badge-light-danger fw-bold';
        }

        // Session information
        document.getElementById('view_session_id').textContent = session.id || '-';
        document.getElementById('view_ip_address').textContent = session.ip_address || '-';
        document.getElementById('view_last_activity').textContent = session.formatted_timestamp || 
            (session.timestamp ? new Date(session.timestamp).toLocaleString() : '-');
        document.getElementById('view_time_ago').textContent = session.time_ago || '-';

        // User information
        document.getElementById('view_full_name').textContent = session.user_name || '-';
        document.getElementById('view_user_islander_no').textContent = session.islander_no || '-';
        document.getElementById('view_user_email').textContent = session.user_email || '-';

        // Session data information
        const loginStatusElement = document.getElementById('view_login_status');
        const sessionDataElement = document.getElementById('view_session_data_content');
        
        if (session.parsed_data) {
            // Check if user is logged in
            const isLoggedIn = session.parsed_data.logged_in || false;
            loginStatusElement.textContent = isLoggedIn ? 'Logged In' : 'Not Logged In';
            loginStatusElement.className = isLoggedIn ? 'badge badge-light-success fw-bold' : 'badge badge-light-secondary fw-bold';
            
            // Display session data (formatted JSON)
            try {
                const formattedData = JSON.stringify(session.parsed_data, null, 2);
                sessionDataElement.textContent = formattedData;
            } catch (e) {
                sessionDataElement.textContent = 'Unable to parse session data';
            }
        } else {
            loginStatusElement.textContent = 'Unknown';
            loginStatusElement.className = 'badge badge-light-secondary fw-bold';
            sessionDataElement.textContent = 'No session data available';
        }

        // Handle profile image
        const profileImageContainer = document.getElementById('view_profile_image_container');
        
        if (session.user_image && profileImageContainer) {
            const profileImageUrl = '<?= base_url('assets/media/users/') ?>' + session.user_image;
            // Replace avatar with actual image
            profileImageContainer.innerHTML = `<img src="${profileImageUrl}" alt="Profile Image" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" />`;
        } else if (avatarElement && session.user_name) {
            // Keep the avatar letter if no image
            avatarElement.textContent = session.user_name.charAt(0).toUpperCase();
        }

        // Set session ID for logout button
        if (logoutButton) {
            logoutButton.setAttribute('data-session-id', session.id);
        }
    };

    // Public methods
    return {
        init: function () {
            initModal();
            initButtons();
        },
        populateModal: function (session) {
            populateModal(session);
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function () {
        ViewSessionModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            ViewSessionModal.init();
        } else {
            console.log('jQuery not available for ViewSessionModal');
        }
    });
}
</script>