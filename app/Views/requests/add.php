<?= $this->include('layout/header.php') ?>

<style>
/* Custom styles for the add request page */
.request-type-card {
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid transparent;
    position: relative;
    overflow: hidden;
}

.request-type-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    border-color: var(--bs-primary);
}

.request-type-card.disabled {
    opacity: 0.6;
    cursor: not-allowed;
    background: #f8f9fa;
}

.request-type-card.disabled:hover {
    transform: none;
    box-shadow: none;
    border-color: transparent;
}

.coming-soon-banner {
    position: absolute;
    top: 15px;
    right: -35px;
    background: linear-gradient(45deg, #ff6b6b, #ee5a52);
    color: white;
    padding: 5px 40px;
    font-size: 12px;
    font-weight: bold;
    transform: rotate(45deg);
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    text-transform: uppercase;
    letter-spacing: 1px;
}

.request-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    transition: all 0.3s ease;
}

.request-type-card:hover .request-icon {
    transform: scale(1.1);
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

/* Mobile responsive */
@media (max-width: 768px) {
    .request-type-card {
        margin-bottom: 20px;
    }
    
    .coming-soon-banner {
        font-size: 10px;
        padding: 4px 30px;
        top: 12px;
        right: -30px;
    }
}

/* Enhanced animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease forwards;
}

.delay-1 { animation-delay: 0.1s; }
.delay-2 { animation-delay: 0.2s; }
.delay-3 { animation-delay: 0.3s; }
.delay-4 { animation-delay: 0.4s; }
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
                            <i class="ki-duotone ki-plus-square fs-1 text-primary me-3">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                            Add New Request
                        </h2>
                        <p class="text-muted fs-6 mt-2">Choose the type of request you want to create</p>
                    </div>
                    <!--end::Card title-->
                    
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="/requests" class="btn btn-back">
                            <i class="ki-duotone ki-arrow-left fs-2 me-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Back to Requests
                        </a>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Row-->
                    <div class="row g-6 g-xl-8">
                        
                        <!--begin::Exit Pass Card-->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 fade-in-up delay-1">
                            <div class="card request-type-card h-100" data-type="exit-pass" onclick="selectRequestType('exit-pass')">
                                <div class="card-body text-center p-8">
                                    <div class="request-icon bg-light-success">
                                        <i class="ki-duotone ki-exit-right fs-2x text-success">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <h4 class="fw-bold text-gray-800 mb-3">Exit Pass</h4>
                                    <p class="text-muted fs-6 mb-4">Request permission to leave the premises temporarily</p>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge badge-light-success fs-7">Available</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Exit Pass Card-->
                        
                        <!--begin::Transfer Card-->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 fade-in-up delay-2">
                            <div class="card request-type-card h-100" data-type="transfer" onclick="selectRequestType('transfer')">
                                <div class="card-body text-center p-8">
                                    <div class="request-icon bg-light-primary">
                                        <i class="ki-duotone ki-airplane-square fs-2x text-primary">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                            <span class="path4"></span>
                                        </i>
                                    </div>
                                    <h4 class="fw-bold text-gray-800 mb-3">Transfer</h4>
                                    <p class="text-muted fs-6 mb-4">Request transportation and transfer arrangements</p>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge badge-light-primary fs-7">Available</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Transfer Card-->
                        
                        <!--begin::Repair Card-->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 fade-in-up delay-3">
                            <div class="card request-type-card h-100 disabled" data-type="repair">
                                <div class="coming-soon-banner">Coming Soon</div>
                                <div class="card-body text-center p-8">
                                    <div class="request-icon bg-light-warning">
                                        <i class="ki-duotone ki-wrench fs-2x text-warning">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <h4 class="fw-bold text-gray-500 mb-3">Repair</h4>
                                    <p class="text-muted fs-6 mb-4">Request maintenance and repair services</p>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge badge-light-warning fs-7">Coming Soon</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::Repair Card-->
                        
                        <!--begin::IT Requests Card-->
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 fade-in-up delay-4">
                            <div class="card request-type-card h-100 disabled" data-type="it-requests">
                                <div class="coming-soon-banner">Coming Soon</div>
                                <div class="card-body text-center p-8">
                                    <div class="request-icon bg-light-info">
                                        <i class="ki-duotone ki-laptop fs-2x text-info">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                    </div>
                                    <h4 class="fw-bold text-gray-500 mb-3">IT Requests</h4>
                                    <p class="text-muted fs-6 mb-4">Request IT support and technical assistance</p>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="badge badge-light-info fs-7">Coming Soon</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--end::IT Requests Card-->
                        
                    </div>
                    <!--end::Row-->
                    
                    <!--begin::Help Section-->
                    <div class="row mt-10">
                        <div class="col-12">
                            <div class="card bg-light-primary">
                                <div class="card-body p-6">
                                    <div class="d-flex align-items-center">
                                        <i class="ki-duotone ki-information-2 fs-2x text-primary me-4">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        <div>
                                            <h5 class="fw-bold text-primary mb-1">Need Help?</h5>
                                            <p class="text-primary-emphasis mb-0">
                                                Click on any available request type to start creating your request. 
                                                Items marked as "Coming Soon" will be available in future updates.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Help Section-->
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
    // Initialize animations
    const cards = document.querySelectorAll('.fade-in-up');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});

function selectRequestType(type) {
    // Check if the card is disabled
    const card = document.querySelector(`[data-type="${type}"]`);
    if (card.classList.contains('disabled')) {
        Swal.fire({
            icon: 'info',
            title: 'Coming Soon',
            text: 'This request type will be available in future updates.',
            confirmButtonText: 'OK',
            confirmButtonColor: '#009ef7'
        });
        return;
    }
    
    // Handle different request types
    switch(type) {
        case 'exit-pass':
            handleExitPassRequest();
            break;
        case 'transfer':
            handleTransferRequest();
            break;
        default:
            console.log('Unknown request type:', type);
            break;
    }
}

function handleExitPassRequest() {
    Swal.fire({
        icon: 'question',
        title: 'Exit Pass Request',
        text: 'You are about to create an Exit Pass request. Continue?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Continue',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#009ef7',
        cancelButtonColor: '#f1416c'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to exit pass form or open modal
            window.location.href = '/requests/create?type=exit-pass';
        }
    });
}

function handleTransferRequest() {
    Swal.fire({
        icon: 'question',
        title: 'Transfer Request',
        text: 'You are about to create a Transfer request. Continue?',
        showCancelButton: true,
        confirmButtonText: 'Yes, Continue',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#009ef7',
        cancelButtonColor: '#f1416c'
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect to transfer form or open modal
            window.location.href = '/requests/create?type=transfer';
        }
    });
}

// Add keyboard navigation
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        window.location.href = '/requests';
    }
});

// Add hover effects for better UX
document.querySelectorAll('.request-type-card:not(.disabled)').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.borderColor = 'var(--bs-primary)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.borderColor = 'transparent';
    });
});
</script>

<?= $this->include('layout/footer.php') ?>