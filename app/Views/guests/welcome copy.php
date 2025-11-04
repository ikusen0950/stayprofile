<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title) ?> - Welcome <?= esc($guest['full_name']) ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .welcome-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .welcome-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .welcome-header {
            margin-bottom: 30px;
        }
        
        .welcome-icon {
            font-size: 4rem;
            color: #667eea;
            margin-bottom: 20px;
        }
        
        .guest-name {
            color: #333;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .welcome-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 30px;
        }
        
        .guest-details {
            background: rgba(248, 249, 250, 0.8);
            border-radius: 15px;
            padding: 25px;
            margin: 30px 0;
            text-align: left;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }
        
        .detail-row:last-child {
            border-bottom: none;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
            display: flex;
            align-items: center;
        }
        
        .detail-label i {
            margin-right: 8px;
            width: 20px;
            color: #667eea;
        }
        
        .detail-value {
            color: #333;
            font-weight: 500;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-confirmed {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }
        
        .status-pending {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }
        
        .status-cancelled {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
        }
        
        .welcome-footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .contact-info {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-top: 20px;
        }
        
        .contact-info h5 {
            margin-bottom: 15px;
            font-weight: 600;
        }
        
        .contact-info p {
            margin-bottom: 5px;
        }
        
        @media (max-width: 768px) {
            .welcome-card {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .guest-name {
                font-size: 1.8rem;
            }
            
            .detail-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 5px;
            }
        }
        
        .floating-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }
        
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 20s infinite linear;
        }
        
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 70%;
            right: 10%;
            animation-delay: 5s;
        }
        
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            top: 50%;
            left: 80%;
            animation-delay: 10s;
        }
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px) rotate(0deg);
            }
            33% {
                transform: translateY(-30px) rotate(120deg);
            }
            66% {
                transform: translateY(30px) rotate(240deg);
            }
        }
    </style>
</head>
<body>
    <!-- Floating background shapes -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="welcome-container">
        <div class="welcome-card">
            <div class="welcome-header">
                <div class="welcome-icon">
                    <i class="fas fa-home"></i>
                </div>
                <h1 class="guest-name">Welcome, <?= esc($guest['full_name']) ?>!</h1>
                <p class="welcome-subtitle">
                    We're delighted to have you stay with us. Here are your reservation details:
                </p>
            </div>

            <div class="guest-details">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-id-card"></i>
                        Guest ID
                    </span>
                    <span class="detail-value">#<?= esc($guest['id']) ?></span>
                </div>

                <?php if (!empty($guest['villa_name'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-building"></i>
                        Villa
                    </span>
                    <span class="detail-value"><?= esc($guest['villa_name']) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['reservation_code'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-ticket-alt"></i>
                        Reservation Code
                    </span>
                    <span class="detail-value"><?= esc($guest['reservation_code']) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['arrival_date'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-calendar-check"></i>
                        Arrival Date
                    </span>
                    <span class="detail-value"><?= date('F j, Y', strtotime($guest['arrival_date'])) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['departure_date'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-calendar-times"></i>
                        Departure Date
                    </span>
                    <span class="detail-value"><?= date('F j, Y', strtotime($guest['departure_date'])) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['arrival_to_here'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-plane-arrival"></i>
                        Arrival Time
                    </span>
                    <span class="detail-value"><?= esc($guest['arrival_to_here']) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['departure_from_here'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-plane-departure"></i>
                        Departure Time
                    </span>
                    <span class="detail-value"><?= esc($guest['departure_from_here']) ?></span>
                </div>
                <?php endif; ?>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-user-tag"></i>
                        Guest Type
                    </span>
                    <span class="detail-value"><?= ucfirst(esc($guest['guest_type'])) ?></span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-info-circle"></i>
                        Status
                    </span>
                    <span class="detail-value">
                        <span class="status-badge status-<?= esc($guest['status']) ?>">
                            <?= ucfirst(esc($guest['status'])) ?>
                        </span>
                    </span>
                </div>

                <?php if (!empty($guest['inclusive'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-utensils"></i>
                        Package
                    </span>
                    <span class="detail-value"><?= esc($guest['inclusive']) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['phone'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-phone"></i>
                        Phone
                    </span>
                    <span class="detail-value"><?= esc($guest['phone']) ?></span>
                </div>
                <?php endif; ?>

                <?php if (!empty($guest['email'])): ?>
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-envelope"></i>
                        Email
                    </span>
                    <span class="detail-value"><?= esc($guest['email']) ?></span>
                </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($guest['notes'])): ?>
            <div class="guest-details">
                <div class="detail-row">
                    <span class="detail-label">
                        <i class="fas fa-sticky-note"></i>
                        Special Notes
                    </span>
                </div>
                <div class="mt-2">
                    <p class="detail-value mb-0"><?= nl2br(esc($guest['notes'])) ?></p>
                </div>
            </div>
            <?php endif; ?>

            <div class="contact-info">
                <h5><i class="fas fa-headset me-2"></i>Need Assistance?</h5>
                <p><i class="fas fa-phone me-2"></i>Reception: +1 (555) 123-4567</p>
                <p><i class="fas fa-envelope me-2"></i>concierge@stayprofile.com</p>
                <p><i class="fas fa-clock me-2"></i>Available 24/7</p>
            </div>

            <div class="welcome-footer">
                <p class="text-muted mb-0">
                    <i class="fas fa-heart text-danger"></i>
                    Thank you for choosing Stay Profile. We hope you have a wonderful stay!
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>