<!--begin::Modal - View Islander-->
<div class="modal fade" id="viewIslanderModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="viewIslanderModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Islander Details</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-islanders-modal-action="close">
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
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="viewIslanderModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#viewIslanderModal_header" data-kt-scroll-wrappers="#viewIslanderModal_scroll" data-kt-scroll-offset="300px">
                    
                    <!--begin::Islander Header-->
                    <div class="d-flex align-items-center mb-8">
                        <div class="symbol symbol-60px me-5" id="view_profile_image_container">
                            <div class="symbol-label fs-2 fw-semibold bg-light-primary text-primary rounded-circle" id="view_islander_avatar">
                                I
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h3 class="text-gray-900 fw-bold mb-1" id="view_islander_name">Islander Name</h3>
                            <div class="d-flex align-items-center">
                                <span class="badge badge-light-info fw-bold me-3" id="view_islander_number">ISL-001</span>
                                <span class="badge badge-light-success fw-bold" id="view_islander_status">Active</span>
                            </div>
                        </div>
                    </div>
                    <!--end::Islander Header-->

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
                            <span class="fw-bold fs-6 text-gray-800" id="view_islander_no">-</span>
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
                        <label class="col-lg-4 fw-semibold text-muted">Division</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_division">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Department</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_department">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Section</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_section">-</span>
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->

                    <!--begin::Row-->
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Position</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_position">-</span>
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
                        <label class="col-lg-4 fw-semibold text-muted">House</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_house">-</span>
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
                        <label class="col-lg-4 fw-semibold text-muted">Join Date</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                            <span class="fw-bold fs-6 text-gray-800" id="view_join_date">-</span>
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
                <button type="button" id="viewIslanderModal_close" class="btn btn-light">Close</button>
                <!--end::Button-->
                <!--begin::Edit Button-->
                <?php if ($permissions['canEdit']): ?>
                <button type="button" id="viewIslanderModal_edit" class="btn btn-primary ms-3">
                    <i class="ki-duotone ki-pencil fs-2">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>Edit Islander
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
<!--end::Modal - View Islander-->

<script>
"use strict";

// Class definition
var ViewIslanderModal = function () {
    var modal;
    var closeButton;
    var editButton;

    // Initialize modal
    var initModal = function () {
        modal = new bootstrap.Modal(document.querySelector('#viewIslanderModal'));
    };

    // Initialize buttons
    var initButtons = function () {
        closeButton = document.querySelector('#viewIslanderModal_close');
        editButton = document.querySelector('#viewIslanderModal_edit');

        // Handle close button
        closeButton.addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle modal close button
        document.querySelector('#viewIslanderModal [data-kt-islanders-modal-action="close"]').addEventListener('click', function (e) {
            e.preventDefault();
            modal.hide();
        });

        // Handle edit button
        if (editButton) {
            editButton.addEventListener('click', function (e) {
                e.preventDefault();
                const islanderId = this.getAttribute('data-islander-id');
                if (islanderId) {
                    modal.hide();
                    // Load and show edit modal
                    loadEditModal(islanderId);
                }
            });
        }
    };

    // Load edit modal
    var loadEditModal = function (islanderId) {
        $.ajax({
            url: `<?= base_url('islanders') ?>/${islanderId}`,
            type: 'GET',
            data: { ajax: 1 },
            success: function (response) {
                if (response.success) {
                    // Populate edit modal and show it
                    if (typeof EditIslanderModal !== 'undefined' && typeof $ !== 'undefined') {
                        EditIslanderModal.populateForm(response.islander);
                        $('#editIslanderModal').modal('show');
                    }
                } else {
                    if (typeof toastr !== 'undefined') {
                        toastr.error(response.message || 'Failed to load islander details');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('Error loading islander for edit:', error);
                toastr.error('Failed to load islander details');
            }
        });
    };

    // Populate modal with islander data
    var populateModal = function (islander) {
        // Check if islander data exists
        if (!islander) {
            console.error('Islanders data is undefined or null');
            return;
        }
        
        // Header information
        const avatarElement = document.getElementById('view_islander_avatar');
        const nameElement = document.getElementById('view_islander_name');
        const numberElement = document.getElementById('view_islander_number');
        const statusElement = document.getElementById('view_islander_status');

        if (avatarElement && islander.full_name) {
            avatarElement.textContent = islander.full_name.charAt(0).toUpperCase();
        }
        if (nameElement) {
            nameElement.textContent = islander.full_name || 'N/A';
        }
        if (numberElement) {
            numberElement.textContent = islander.islander_no ? islander.islander_no.toUpperCase() : 'N/A';
        }
        if (statusElement) {
            statusElement.textContent = islander.status_name ? islander.status_name.toUpperCase() : 'N/A';
            // Apply status color if available
            if (islander.status_color) {
                statusElement.style.backgroundColor = islander.status_color + '1a';
                statusElement.style.color = islander.status_color;
                statusElement.className = 'badge fw-bold';
            }
        }

        // Basic information
        document.getElementById('view_full_name').textContent = islander.full_name || '-';
        document.getElementById('view_islander_no').textContent = islander.islander_no || '-';
        document.getElementById('view_email').textContent = islander.email || '-';
        document.getElementById('view_phone').textContent = islander.phone || '-';

        // Organizational information
        document.getElementById('view_division').textContent = islander.division_name || '-';
        document.getElementById('view_department').textContent = islander.department_name || '-';
        document.getElementById('view_section').textContent = islander.section_name || '-';
        document.getElementById('view_position').textContent = islander.position_name || '-';

        // Personal information
        document.getElementById('view_gender').textContent = islander.gender_name || '-';
        document.getElementById('view_nationality').textContent = islander.nationality_name || '-';

        // House information with color
        const houseElement = document.getElementById('view_house');
        if (islander.house_name) {
            houseElement.textContent = islander.house_name;
            if (islander.house_color) {
                houseElement.style.backgroundColor = islander.house_color + '1a';
                houseElement.style.color = islander.house_color;
                houseElement.className = 'badge fw-bold';
                houseElement.style.padding = '4px 8px';
                houseElement.style.fontSize = '11px';
                houseElement.style.lineHeight = '1.2';
            }
        } else {
            houseElement.textContent = '-';
        }

        // Status information
        const statusDetailElement = document.getElementById('view_status');
        if (islander.status_name) {
            statusDetailElement.textContent = islander.status_name;
            if (islander.status_color) {
                statusDetailElement.style.backgroundColor = islander.status_color + '1a';
                statusDetailElement.style.color = islander.status_color;
                statusDetailElement.className = 'badge fw-bold';
                statusDetailElement.style.padding = '4px 8px';
                statusDetailElement.style.fontSize = '11px';
                statusDetailElement.style.lineHeight = '1.2';
            }
        } else {
            statusDetailElement.textContent = '-';
        }

        // Dates
        document.getElementById('view_date_of_birth').textContent = islander.date_of_birth ? 
            new Date(islander.date_of_birth).toLocaleDateString() : '-';
        document.getElementById('view_join_date').textContent = islander.join_date ? 
            new Date(islander.join_date).toLocaleDateString() : '-';

        // Additional information
        document.getElementById('view_address').textContent = islander.address || '-';
        document.getElementById('view_notes').textContent = islander.notes || '-';

        // Audit information
        document.getElementById('view_created_by').textContent = islander.created_by_name || '-';
        document.getElementById('view_created_at').textContent = islander.created_at ? 
            new Date(islander.created_at).toLocaleString() : '-';
        document.getElementById('view_updated_by').textContent = islander.updated_by_name || '-';
        document.getElementById('view_updated_at').textContent = islander.updated_at ? 
            new Date(islander.updated_at).toLocaleString() : '-';

        // Handle profile image
        const profileImageContainer = document.getElementById('view_profile_image_container');
        
        if (islander.image && profileImageContainer) {
            // Check if the image path already includes the base path
            let profileImageUrl;
            if (islander.image.startsWith('assets/media/users/') || islander.image.startsWith('uploads/islanders/')) {
                profileImageUrl = '<?= base_url() ?>/' + islander.image;
            } else {
                // Fallback for legacy images
                profileImageUrl = '<?= base_url('assets/media/users/') ?>' + islander.image;
            }
            // Replace avatar with actual image
            profileImageContainer.innerHTML = `<img src="${profileImageUrl}" alt="Profile Image" class="rounded-circle" style="width: 60px; height: 60px; object-fit: cover;" />`;
        } else if (avatarElement && islander.full_name) {
            // Keep the avatar letter if no image
            avatarElement.textContent = islander.full_name.charAt(0).toUpperCase();
        }

        // Handle cover image
        const coverImageSection = document.getElementById('view_cover_image_section');
        const coverImagePreview = document.getElementById('view_cover_image_preview');
        
        if (islander.cover_image && coverImageSection && coverImagePreview) {
            // Check if the cover image path already includes the base path
            let coverImageUrl;
            if (islander.cover_image.startsWith('assets/media/cover_image/') || islander.cover_image.startsWith('uploads/islanders/')) {
                coverImageUrl = '<?= base_url() ?>/' + islander.cover_image;
            } else {
                // Fallback for legacy images
                coverImageUrl = '<?= base_url('assets/media/cover_image/') ?>' + islander.cover_image;
            }
            coverImagePreview.style.backgroundImage = `url('${coverImageUrl}')`;
            coverImagePreview.style.backgroundSize = 'cover';
            coverImagePreview.style.backgroundPosition = 'center';
            coverImageSection.style.display = 'block';
        } else if (coverImageSection) {
            coverImageSection.style.display = 'none';
        }

        // Set islander ID for edit button
        if (editButton) {
            editButton.setAttribute('data-islander-id', islander.id);
        }
    };

    // Public methods
    return {
        init: function () {
            initModal();
            initButtons();
        },
        populateModal: function (islander) {
            populateModal(islander);
        }
    };
}();

// On document ready
if (typeof $ !== 'undefined') {
    $(document).ready(function () {
        ViewIslanderModal.init();
    });
} else {
    // Fallback if jQuery is not available
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof $ !== 'undefined') {
            ViewIslanderModal.init();
        } else {
            console.log('jQuery not available for ViewIslanderModal');
        }
    });
}
</script>