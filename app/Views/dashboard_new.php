<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<!-- Additional CSS for dashboard -->
<style>
    .stats-card {
        transition: transform 0.2s;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .session-info-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .user-info-card {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('page-actions') ?>
<div class="btn-group" role="group">
    <a href="<?= base_url('reset-my-agreement') ?>" class="btn btn-outline-warning btn-sm" 
       onclick="return confirm('This will reset your agreement status for testing. Continue?')">
        <i class="fas fa-undo me-1"></i>Reset Agreement
    </a>
    <a href="<?= base_url('logout') ?>" class="btn btn-outline-danger btn-sm">
        <i class="fas fa-sign-out-alt me-1"></i>Logout
    </a>
</div>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Welcome Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card user-info-card border-0">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="card-title mb-1">
                            <i class="fas fa-wave-square me-2"></i>
                            Hello, <?= esc($user->username) ?>!
                        </h4>
                        <p class="card-text mb-2">Welcome back to your dashboard. You have successfully logged in to your account.</p>
                        <div class="user-details">
                            <span class="badge bg-white text-dark me-2">
                                <i class="fas fa-envelope me-1"></i><?= esc($user->email) ?>
                            </span>
                            <span class="badge bg-white text-dark me-2">
                                <i class="fas fa-id-card me-1"></i>ID: <?= esc($user->id) ?>
                            </span>
                            <span class="badge bg-<?= $user->active ? 'success' : 'warning' ?> me-2">
                                <i class="fas fa-<?= $user->active ? 'check-circle' : 'clock' ?> me-1"></i>
                                <?= $user->active ? 'Active' : 'Inactive' ?>
                            </span>
                            <?php if (!empty($user->full_name)): ?>
                                <span class="badge bg-white text-dark me-2">
                                    <i class="fas fa-user me-1"></i><?= esc($user->full_name) ?>
                                </span>
                            <?php endif; ?>
                            <?php if (!empty($user->islander_no)): ?>
                                <span class="badge bg-white text-dark me-2">
                                    <i class="fas fa-island-tropical me-1"></i><?= esc($user->islander_no) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="user-avatar">
                            <?php if (!empty($user->image)): ?>
                                <img src="<?= base_url('assets/media/' . $user->image) ?>" alt="Profile" class="rounded-circle border border-white" width="80" height="80">
                            <?php else: ?>
                                <div class="bg-white text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                    <i class="fas fa-user fs-2"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Session Information Card -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card session-info-card border-0">
            <div class="card-body">
                <h5 class="card-title">
                    <i class="fas fa-shield-alt me-2"></i>Session Information
                </h5>
                <div class="row">
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="fas fa-fingerprint fs-1 mb-2"></i>
                            <h6>Session ID</h6>
                            <small><?= esc(substr($session_id ?? 'N/A', 0, 16)) ?>...</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="fas fa-database fs-1 mb-2"></i>
                            <h6>Storage</h6>
                            <small>Database</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="fas fa-clock fs-1 mb-2"></i>
                            <h6>Expiry</h6>
                            <small><?= esc($session_expiry_days ?? 90) ?> days</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="text-center">
                            <i class="fas fa-calendar fs-1 mb-2"></i>
                            <h6>Started</h6>
                            <small><?= date('M j, Y g:i A') ?></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="text-primary mb-3">
                    <i class="fas fa-user-cog fs-1"></i>
                </div>
                <h5 class="card-title">Account Settings</h5>
                <p class="card-text">Manage your account settings and preferences.</p>
                <a href="#" class="btn btn-primary" onclick="showComingSoon('Account Settings')">
                    <i class="fas fa-cog me-1"></i>Manage
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="text-success mb-3">
                    <i class="fas fa-user-edit fs-1"></i>
                </div>
                <h5 class="card-title">Edit Profile</h5>
                <p class="card-text">Update your profile information and details.</p>
                <a href="#" class="btn btn-success" onclick="showComingSoon('Profile Editor')">
                    <i class="fas fa-edit me-1"></i>Edit
                </a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card stats-card h-100">
            <div class="card-body text-center">
                <div class="text-info mb-3">
                    <i class="fas fa-chart-line fs-1"></i>
                </div>
                <h5 class="card-title">Analytics</h5>
                <p class="card-text">View your activity and system analytics.</p>
                <a href="#" class="btn btn-info" onclick="showComingSoon('Analytics')">
                    <i class="fas fa-chart-bar me-1"></i>View
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Agreement Modal (if needed) -->
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
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script>
function showComingSoon(feature) {
    alert(`${feature} feature is coming soon!\n\nThis feature will be available in the next version.`);
}

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
            document.querySelector('.main-content').insertBefore(alertDiv, document.querySelector('.page-content'));
            
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
<?= $this->endSection() ?>