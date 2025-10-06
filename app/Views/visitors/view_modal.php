<!--begin::Modal - View Visitor-->
<div class="modal fade" id="viewVisitorModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="viewVisitorModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Visitor Details</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-visitors-modal-action="close">
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
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="viewVisitorModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#viewVisitorModal_header" data-kt-scroll-wrappers="#viewVisitorModal_scroll" data-kt-scroll-offset="300px">
                    
                    <!--begin::Visitor Header-->
                    <div class="d-flex align-items-center mb-8">
                        <div class="symbol symbol-60px me-5" id="view_profile_image_container">
                            <div class="symbol-label fs-2 fw-semibold bg-light-primary text-primary rounded-circle" id="view_visitor_avatar">
                                V
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="text-gray-900 fw-bold mb-1" id="view_visitor_name">Visitor Name</h3>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light-info fw-bold me-3" id="view_visitor_number">VIS-001</span>
                                <span class="badge badge-light-success fw-bold" id="view_visitor_status">Active</span>
                            </div>
                        </div>
                    </div>
                    <!--end::Visitor Header-->

                    <!--begin::Cover Image Section (if available)-->
                    <div class="row mb-7" id="view_cover_image_section" style="display: none;">
                        <div class="col-12">
                            <label class="fw-semibold text-muted mb-3">Cover Image</label>
                            <div class="d-flex justify-content-center">
                                <div class="image-input image-input-outline" style="background-color: transparent;">
                                    <div class="image-input-wrapper w-200px h-125px" id="view_cover_image_preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Cover Image Section-->

                    <!--begin::Personal Information Section-->
                    <h4 class="fw-bold text-gray-800 mb-5">Personal Information</h4>
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
                        <label class="col-lg-4 fw-semibold text-muted">Visitor Number</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_visitor_no">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">NID/PP/WP #</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_id_pp_wp_no">-</span>
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
                            <span class="fw-bold fs-6 text-gray-800" id="view_email">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Phone</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_phone">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Gender</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_gender">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Nationality</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_nationality">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Date of Birth</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_date_of_birth">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Address</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_address">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Visit Information Section-->
                    <h4 class="fw-bold text-gray-800 mb-5 mt-10">Visit Information</h4>
                    <div class="separator separator-dashed mt-2 mb-7"></div>

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Visit Purpose</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_visit_purpose">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Check-in Date</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_checkin_date">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Check-out Date</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_checkout_date">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Accommodation</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_accommodation">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Status</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_status">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Notes</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_notes">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Separator-->
                    <div class="separator my-10"></div>
                    <!--end::Separator-->

                    <!--begin::Audit Information Section-->
                    <h4 class="fw-bold text-gray-800 mb-5">Record Information</h4>
                    <div class="separator separator-dashed mt-2 mb-7"></div>

                    <!--begin::Created info-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Created By</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_created_by">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Created At</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_created_at">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Last Updated By</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_updated_by">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Last Updated At</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_updated_at">-</span>
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
                <button type="button" id="viewVisitorModal_close" class="btn btn-light">Close</button>
                <!--end::Button-->
                <!--begin::Edit Button-->
                <?php if ($permissions['canEdit']): ?>
                <button type="button" id="viewVisitorModal_edit" class="btn btn-primary ms-3">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit Visitor
                </button>
                <?php endif; ?>
                <!--end::Edit Button-->
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - View Visitor-->

<script>
"use strict";

// Class definition
var ViewVisitorModal = function () {
    var modal;
    var closeButton;
    var editButton;

    // Initialize modal
    var initModal = function () {
        modal = new bootstrap.Modal(document.querySelector('#viewVisitorModal'));
    };

    // Initialize buttons
    var initButtons = function () {
        closeButton = document.querySelector('#viewVisitorModal_close');
        editButton = document.querySelector('#viewVisitorModal_edit');

        // Handle close button
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle modal close button
        document.querySelector('#viewVisitorModal [data-kt-visitors-modal-action="close"]').addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle edit button
        if (editButton) {
            editButton.addEventListener('click', function (e) {
                e.preventDefault();
                const visitorId = this.getAttribute('data-visitor-id');
                if (visitorId) {
                    modal.hide();
                    // Load and show edit modal
                    loadEditModal(visitorId);
                }
            });
        }
    };

    // Load edit modal
    var loadEditModal = function (visitorId) {
        $.ajax({
            url: `<?= base_url('visitors') ?>/${visitorId}`,
            type: 'GET',
            data: { ajax: 1 },
            success: function (response) {
                if (response.success) {
                    // Populate edit modal and show it
                    if (typeof EditVisitorModal !== 'undefined' && typeof $ !== 'undefined') {
                        EditVisitorModal.populateForm(response.visitor);
                        $('#editVisitorModal').modal('show');
                    }
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load visitor details');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading visitor for edit:', error);
                toastr.error('Failed to load visitor details');
            }
        });
    };

    // Populate modal with visitor data
    var populateModal = function (visitor) {
        // Check if visitor data exists
        if (!visitor) {
            console.error('Visitor data is undefined or null');
            return;
        }
        
        // Header information
        const avatarElement = document.getElementById('view_visitor_avatar');
        const nameElement = document.getElementById('view_visitor_name');
        const numberElement = document.getElementById('view_visitor_number');
        const statusElement = document.getElementById('view_visitor_status');

        if (avatarElement && visitor.full_name) {
            avatarElement.textContent = visitor.full_name.charAt(0).toUpperCase();
        }
        if (nameElement) {
            nameElement.textContent = visitor.full_name || 'N/A';
        }
        if (numberElement) {
            numberElement.textContent = visitor.visitor_no ? visitor.visitor_no.toUpperCase() : 'N/A';
        }
        if (statusElement) {
            statusElement.textContent = visitor.status_name ? visitor.status_name.toUpperCase() : 'N/A';
            // Apply status color if available
            if (visitor.status_color) {
                statusElement.style.backgroundColor = visitor.status_color + '1a';
                statusElement.style.color = visitor.status_color;
                statusElement.className = 'badge fw-bold';
            }
        }

        // Personal information
        document.getElementById('view_full_name').textContent = visitor.full_name || '-';
        document.getElementById('view_visitor_no').textContent = visitor.visitor_no || '-';
        document.getElementById('view_id_pp_wp_no').textContent = visitor.id_pp_wp_no || '-';
        document.getElementById('view_email').textContent = visitor.email || '-';
        document.getElementById('view_phone').textContent = visitor.phone || '-';
        document.getElementById('view_gender').textContent = visitor.gender_name || '-';
        document.getElementById('view_nationality').textContent = visitor.nationality_name || '-';
        document.getElementById('view_date_of_birth').textContent = visitor.date_of_birth ? 
            new Date(visitor.date_of_birth).toLocaleDateString() : '-';
        document.getElementById('view_address').textContent = visitor.address || '-';

        // Visit information
        document.getElementById('view_visit_purpose').textContent = visitor.visit_purpose || '-';
        document.getElementById('view_checkin_date').textContent = visitor.checkin_date ? 
            new Date(visitor.checkin_date).toLocaleDateString() : '-';
        document.getElementById('view_checkout_date').textContent = visitor.checkout_date ? 
            new Date(visitor.checkout_date).toLocaleDateString() : '-';
        document.getElementById('view_accommodation').textContent = visitor.accommodation || '-';

        // Status information
        const statusDetailElement = document.getElementById('view_status');
        if (visitor.status_name) {
            statusDetailElement.textContent = visitor.status_name;
            if (visitor.status_color) {
                statusDetailElement.style.backgroundColor = visitor.status_color + '1a';
                statusDetailElement.style.color = visitor.status_color;
                statusDetailElement.className = 'badge fw-bold';
                statusDetailElement.style.padding = '4px 8px';
                statusDetailElement.style.fontSize = '11px';
                statusDetailElement.style.lineHeight = '1.2';
            }
        } else {
            statusDetailElement.textContent = '-';
        }

        // Additional information
        document.getElementById('view_notes').textContent = visitor.notes || '-';

        // Audit information
        document.getElementById('view_created_by').textContent = visitor.created_by_name || '-';
        document.getElementById('view_created_at').textContent = visitor.created_at ? 
            new Date(visitor.created_at).toLocaleString() : '-';
        document.getElementById('view_updated_by').textContent = visitor.updated_by_name || '-';
        document.getElementById('view_updated_at').textContent = visitor.updated_at ? 
            new Date(visitor.updated_at).toLocaleString() : '-';

        // Handle profile image
        const profileImageContainer = document.getElementById('view_profile_image_container');
        
        if (visitor.image && profileImageContainer) {
            // Check if the image path already includes the base path
            let profileImageUrl;
            if (visitor.image.startsWith('assets/media/users/') || visitor.image.startsWith('uploads/visitors/')) {
                profileImageUrl = '<?= base_url() ?>/' + visitor.image;
            } else {
                // Fallback for legacy images
                profileImageUrl = '<?= base_url('assets/media/users/') ?>' + visitor.image;
            }
            // Replace avatar with actual image
            profileImageContainer.innerHTML = `<img src="${profileImageUrl}" alt="Profile Image" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" />`;
        } else if (avatarElement && visitor.full_name) {
            // Keep the avatar letter if no image
            avatarElement.textContent = visitor.full_name.charAt(0).toUpperCase();
        }

        // Handle cover image
        const coverImageSection = document.getElementById('view_cover_image_section');
        const coverImagePreview = document.getElementById('view_cover_image_preview');
        
        if (visitor.cover_image && coverImageSection && coverImagePreview) {
            // Check if the cover image path already includes the base path
            let coverImageUrl;
            if (visitor.cover_image.startsWith('assets/media/cover_image/') || visitor.cover_image.startsWith('uploads/visitors/')) {
                coverImageUrl = '<?= base_url() ?>/' + visitor.cover_image;
            } else {
                // Fallback for legacy images
                coverImageUrl = '<?= base_url('assets/media/cover_image/') ?>' + visitor.cover_image;
            }
            coverImagePreview.style.backgroundImage = `url('${coverImageUrl}')`;
            coverImagePreview.style.backgroundSize = 'cover';
            coverImagePreview.style.backgroundPosition = 'center';
            coverImageSection.style.display = 'block';
        } else if (coverImageSection) {
            coverImageSection.style.display = 'none';
        }

        // Set visitor ID for edit button
        if (editButton) {
            editButton.setAttribute('data-visitor-id', visitor.id);
        }
    };

    // Public methods
    return {
        init: function () {
            initModal();
            initButtons();
        },
        populateModal: function (visitor) {
            populateModal(visitor);
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function () {
        ViewVisitorModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            ViewVisitorModal.init();
        } else {
            console.log('jQuery not available for ViewVisitorModal');
        }
    });
}
</script>