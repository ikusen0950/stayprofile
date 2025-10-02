<?php helper('auth'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Islanders Finolhu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3>Welcome to your Dashboard</h3>
                        <div>
                            <a href="<?= base_url('reset-my-agreement') ?>" class="btn btn-outline-warning btn-sm me-2" 
                               onclick="return confirm('This will reset your agreement status for testing. Continue?')">
                                <i class="fas fa-undo me-1"></i>Reset Agreement
                            </a>
                            <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">Logout</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('message')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i><?= session()->getFlashdata('message') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Hello, <?= esc($user->username) ?>!</h4>
                            <p>You have successfully logged in to your account.</p>
                            <hr>
                            <p class="mb-0">
                                <strong>Email:</strong> <?= esc($user->email) ?><br>
                                <strong>User ID:</strong> <?= esc($user->id) ?><br>
                                <strong>Active:</strong> <?= $user->active ? 'Yes' : 'No' ?><br>
                                <?php if (!empty($user->full_name)): ?>
                                <strong>Full Name:</strong> <?= esc($user->full_name) ?><br>
                                <?php endif; ?>
                                <?php if (!empty($user->islander_no)): ?>
                                <strong>Islander No:</strong> <?= esc($user->islander_no) ?><br>
                                <?php endif; ?>
                            </p>
                        </div>
                        
                        <div class="alert alert-info" role="alert">
                            <h5 class="alert-heading">Session Information</h5>
                            <p class="mb-0">
                                <strong>Session ID:</strong> <?= esc($session_id ?? 'N/A') ?><br>
                                <strong>Session Storage:</strong> Database<br>
                                <strong>Session Expiry:</strong> <?= esc($session_expiry_days ?? 90) ?> days<br>
                                <strong>Session Started:</strong> <?= date('Y-m-d H:i:s') ?>
                            </p>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Account Settings</h5>
                                        <p class="card-text">Manage your account settings and preferences.</p>
                                        <a href="#" class="btn btn-primary">Settings</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Profile</h5>
                                        <p class="card-text">Update your profile information.</p>
                                        <a href="#" class="btn btn-primary">Edit Profile</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Software Agreement Modal -->
    <?php if ($show_agreement_modal ?? false): ?>
    <div class="modal fade" id="agreementModal" tabindex="-1" aria-labelledby="agreementModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="agreementModalLabel">
                        <i class="fas fa-file-contract me-2"></i>Software License Agreement
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="agreement-content">
                        <h6 class="fw-bold">Islanders Finolhu Software License Agreement</h6>
                        <p class="text-muted">Last updated: <?= date('F j, Y') ?></p>
                        
                        <div class="agreement-text" style="max-height: 400px; overflow-y: auto; border: 1px solid #dee2e6; padding: 15px; background-color: #f8f9fa;">
                            <h6>1. ACCEPTANCE OF TERMS</h6>
                            <p>By accessing and using the Islanders Finolhu software system, you acknowledge that you have read, understood, and agree to be bound by the terms and conditions of this Software License Agreement.</p>
                            
                            <h6>2. PERMITTED USE</h6>
                            <p>This software is provided for the exclusive use of authorized Islanders Finolhu employees and contractors. You may use this system solely for legitimate business purposes related to your employment or contract with Islanders Finolhu.</p>
                            
                            <h6>3. RESTRICTIONS</h6>
                            <p>You agree NOT to:</p>
                            <ul>
                                <li>Share your login credentials with unauthorized persons</li>
                                <li>Attempt to reverse engineer, decompile, or disassemble the software</li>
                                <li>Use the system for any illegal or unauthorized purpose</li>
                                <li>Access data or functionality beyond your authorized scope</li>
                                <li>Download, copy, or distribute confidential company information without authorization</li>
                            </ul>
                            
                            <h6>4. DATA PROTECTION & PRIVACY</h6>
                            <p>You acknowledge that this system may contain sensitive and confidential information. You agree to maintain the confidentiality of all data accessed through this system and comply with all applicable data protection regulations.</p>
                            
                            <h6>5. MONITORING & COMPLIANCE</h6>
                            <p>Your use of this system may be monitored for security, compliance, and operational purposes. By using this system, you consent to such monitoring activities.</p>
                            
                            <h6>6. TERMINATION</h6>
                            <p>This license is effective until terminated. Your access may be terminated immediately without notice if you violate any terms of this agreement or upon termination of your employment/contract with Islanders Finolhu.</p>
                            
                            <h6>7. LIMITATION OF LIABILITY</h6>
                            <p>Islanders Finolhu shall not be liable for any damages arising from the use or inability to use this software, except as required by applicable law.</p>
                            
                            <div class="alert alert-warning mt-3">
                                <strong>Important:</strong> You must accept this agreement to continue using the system. If you do not agree to these terms, please contact your system administrator.
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" onclick="logout()">
                        <i class="fas fa-times me-1"></i>Decline & Logout
                    </button>
                    <button type="button" class="btn btn-success" id="acceptAgreementBtn">
                        <i class="fas fa-check me-1"></i>I Accept the Agreement
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
    
    <script>
        <?php if ($show_agreement_modal ?? false): ?>
        // Show the agreement modal on page load
        document.addEventListener('DOMContentLoaded', function() {
            var agreementModal = new bootstrap.Modal(document.getElementById('agreementModal'));
            agreementModal.show();
        });

        // Handle agreement acceptance
        document.getElementById('acceptAgreementBtn').addEventListener('click', function() {
            this.disabled = true;
            this.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span>Processing...';
            
            fetch('<?= base_url('accept-agreement') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_token() ?>'
                },
                body: JSON.stringify({
                    '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Close modal and reload page
                    var agreementModal = bootstrap.Modal.getInstance(document.getElementById('agreementModal'));
                    agreementModal.hide();
                    
                    // Show success message
                    const alertDiv = document.createElement('div');
                    alertDiv.className = 'alert alert-success alert-dismissible fade show';
                    alertDiv.innerHTML = `
                        <i class="fas fa-check-circle me-2"></i>${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    `;
                    document.querySelector('.container').insertBefore(alertDiv, document.querySelector('.row'));
                    
                    // Auto-dismiss after 5 seconds
                    setTimeout(() => {
                        alertDiv.remove();
                    }, 5000);
                } else {
                    alert('Error: ' + data.message);
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-check me-1"></i>I Accept the Agreement';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                this.disabled = false;
                this.innerHTML = '<i class="fas fa-check me-1"></i>I Accept the Agreement';
            });
        });
        <?php endif; ?>

        // Logout function for decline button
        function logout() {
            if (confirm('Are you sure you want to decline the agreement and logout?')) {
                window.location.href = '<?= base_url('logout') ?>';
            }
        }
    </script>
</body>
</html>