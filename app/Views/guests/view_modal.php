<!--begin::Modal - View Guest-->
<div class="modal fade" id="viewGuestModal" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="viewGuestModal_header">
                <!--begin::Modal title-->
                <h2 class="fw-bold">Guest Details</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-guests-view-modal-action="close">
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
                <!--begin::Scroll-->
                <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="viewGuestModal_scroll"
                    data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto"
                    data-kt-scroll-dependencies="#viewGuestModal_header"
                    data-kt-scroll-wrappers="#viewGuestModal_scroll" data-kt-scroll-offset="300px">

                    <!--begin::Guest basic info-->
                    <div class="card card-flush mb-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>Basic Information</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Full Name</label>
                                        <div class="fw-bold fs-6" id="view_full_name">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Email</label>
                                        <div class="fw-bold fs-6" id="view_email">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Phone</label>
                                        <div class="fw-bold fs-6" id="view_phone">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Guest Type</label>
                                        <div class="fw-bold fs-6" id="view_guest_type">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Status</label>
                                        <div id="view_status">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Villa</label>
                                        <div class="fw-bold fs-6" id="view_villa">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Guest Token</label>
                                        <div class="fw-bold fs-6" id="view_guest_token">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Reservation Code</label>
                                        <div class="fw-bold fs-6" id="view_reservation_code">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Guest basic info-->

                    <!--begin::Stay details-->
                    <div class="card card-flush mb-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>Stay Details</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Arrival Date</label>
                                        <div class="fw-bold fs-6" id="view_arrival_date">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Departure Date</label>
                                        <div class="fw-bold fs-6" id="view_departure_date">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Arrival Time to Here</label>
                                        <div class="fw-bold fs-6" id="view_arrival_to_here">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Departure Time from Here</label>
                                        <div class="fw-bold fs-6" id="view_departure_from_here">-</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Inclusive Details</label>
                                        <div class="fw-bold fs-6" id="view_inclusive">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Stay details-->

                    <!--begin::Additional info-->
                    <div class="card card-flush mb-6">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>Additional Information</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="mb-4">
                                <label class="fw-semibold fs-6 mb-2 text-gray-600">Notes</label>
                                <div class="fw-bold fs-6" id="view_notes">-</div>
                            </div>
                        </div>
                    </div>
                    <!--end::Additional info-->

                    <!--begin::System info-->
                    <div class="card card-flush">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>System Information</h3>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Created By</label>
                                        <div class="fw-bold fs-6" id="view_created_by">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Created At</label>
                                        <div class="fw-bold fs-6" id="view_created_at">-</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Updated By</label>
                                        <div class="fw-bold fs-6" id="view_updated_by">-</div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="fw-semibold fs-6 mb-2 text-gray-600">Updated At</label>
                                        <div class="fw-bold fs-6" id="view_updated_at">-</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::System info-->

                </div>
                <!--end::Scroll-->
            </div>
            <!--end::Modal body-->
            <!--begin::Modal footer-->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-kt-guests-view-modal-action="close">Close</button>
            </div>
            <!--end::Modal footer-->
        </div>
        <!--end::Modal content-->
    </div>
    <!--end::Modal dialog-->
</div>
<!--end::Modal - View Guest-->

<script>
"use strict";

// Class Definition
var ViewGuestModal = function() {
    var modal;
    var closeButton;

    // Populate modal with guest data
    var populateModal = function(guest) {
        try {
            // Basic information
            document.getElementById('view_full_name').textContent = guest.full_name || '-';
            document.getElementById('view_email').textContent = guest.email || '-';
            document.getElementById('view_phone').textContent = guest.phone || '-';
            document.getElementById('view_guest_type').textContent = guest.guest_type ? guest.guest_type.charAt(0).toUpperCase() + guest.guest_type.slice(1) : '-';
            document.getElementById('view_guest_token').textContent = guest.guest_token || '-';
            document.getElementById('view_reservation_code').textContent = guest.reservation_code || '-';

            // Status with color
            var statusElement = document.getElementById('view_status');
            if (guest.status) {
                var statusColors = {
                    'invited': '#3498db',
                    'pending': '#f39c12',
                    'submitted': '#9b59b6',
                    'checked_in': '#27ae60',
                    'checked_out': '#95a5a6',
                    'canceled': '#e74c3c'
                };
                var statusColor = statusColors[guest.status] || '#95a5a6';
                var hex = statusColor.replace('#', '');
                var r = parseInt(hex.substr(0, 2), 16);
                var g = parseInt(hex.substr(2, 2), 16);
                var b = parseInt(hex.substr(4, 2), 16);
                var lightBg = `rgba(${r}, ${g}, ${b}, 0.1)`;
                
                statusElement.innerHTML = `<span class="badge fw-bold" style="background-color: ${lightBg}; color: ${statusColor}; padding: 4px 8px; font-size: 11px; line-height: 1.2;">${guest.status.toUpperCase()}</span>`;
            } else {
                statusElement.textContent = '-';
            }

            // Villa information
            var villaText = '-';
            if (guest.villa_name) {
                villaText = guest.villa_name;
                if (guest.villa_code) {
                    villaText += ' (' + guest.villa_code + ')';
                }
            }
            document.getElementById('view_villa').textContent = villaText;

            // Stay details
            document.getElementById('view_arrival_date').textContent = guest.arrival_date ? new Date(guest.arrival_date).toLocaleDateString() : '-';
            document.getElementById('view_departure_date').textContent = guest.departure_date ? new Date(guest.departure_date).toLocaleDateString() : '-';
            document.getElementById('view_arrival_to_here').textContent = guest.arrival_to_here || '-';
            document.getElementById('view_departure_from_here').textContent = guest.departure_from_here || '-';
            document.getElementById('view_inclusive').textContent = guest.inclusive || '-';

            // Additional information
            document.getElementById('view_notes').textContent = guest.notes || '-';

            // System information
            document.getElementById('view_created_by').textContent = guest.created_by_name || '-';
            document.getElementById('view_created_at').textContent = guest.created_at ? new Date(guest.created_at).toLocaleString() : '-';
            document.getElementById('view_updated_by').textContent = guest.updated_by_name || '-';
            document.getElementById('view_updated_at').textContent = guest.updated_at ? new Date(guest.updated_at).toLocaleString() : '-';

        } catch (error) {
            console.error('Error populating guest view modal:', error);
            if (typeof toastr !== 'undefined') {
                toastr.error('Error displaying guest details');
            }
        }
    };

    // Close modal
    var handleClose = function() {
        closeButton.addEventListener('click', function(e) {
            e.preventDefault();
            modal.hide();
        });
    };

    return {
        // Public functions
        init: function() {
            // Elements
            modal = new bootstrap.Modal(document.querySelector('#viewGuestModal'));
            closeButton = document.querySelector('[data-kt-guests-view-modal-action="close"]');

            // Initialize only if elements exist
            if (closeButton) {
                handleClose();
            }
        },
        populateModal: populateModal
    };
}();

// On document ready
if (typeof KTUtil !== 'undefined' && KTUtil.onDOMContentLoaded) {
    KTUtil.onDOMContentLoaded(function() {
        ViewGuestModal.init();
    });
} else {
    document.addEventListener('DOMContentLoaded', function() {
        ViewGuestModal.init();
    });
}
</script>