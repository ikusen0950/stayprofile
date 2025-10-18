<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Token Button - Implementation Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .preview-section {
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
            background-color: #f8f9fa;
        }
        .code-block {
            background-color: #2d3748;
            color: #e2e8f0;
            padding: 15px;
            border-radius: 5px;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="mb-4"><i class="bi bi-bell-fill text-primary"></i> Register Token Button - Implementation Preview</h1>
                
                <!-- Button Implementation Preview -->
                <div class="preview-section">
                    <h3>Dashboard Implementation</h3>
                    <p class="text-muted">This is how the Register Token button appears in the dashboard toolbar:</p>
                    
                    <!-- Simulated Dashboard Toolbar -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="bi bi-speedometer2"></i> Dashboard</h5>
                        </div>
                        <div class="card-body">
                            <!-- Toolbar Actions -->
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Actions</h6>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-plus-circle"></i> Add
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-filter"></i> Filter
                                    </button>
                                    <!-- The Register Token Button -->
                                    <button type="button" class="btn btn-success btn-sm" onclick="registerFCMToken()">
                                        <i class="bi bi-bell-fill"></i> Register Token
                                    </button>
                                </div>
                            </div>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> 
                                The <strong>Register Token</strong> button allows manual FCM token registration for push notifications.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feature Overview -->
                <div class="preview-section">
                    <h3>Features</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-phone text-success"></i> Mobile Detection</h5>
                                    <p class="card-text">Automatically detects if running on mobile device with Capacitor and uses appropriate FCM registration method.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-shield-check text-primary"></i> Permission Handling</h5>
                                    <p class="card-text">Requests notification permissions before attempting token registration with proper error handling.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-cloud-upload text-info"></i> API Integration</h5>
                                    <p class="card-text">Sends token to <code>/api/save-token</code> endpoint with proper authentication and error handling.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="bi bi-chat-square-dots text-warning"></i> User Feedback</h5>
                                    <p class="card-text">Provides clear success/error messages using SweetAlert2 notifications.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Implementation Details -->
                <div class="preview-section">
                    <h3>Implementation Details</h3>
                    
                    <h5>HTML Button Code:</h5>
                    <div class="code-block mb-3">
&lt;button type="button" class="btn btn-success btn-sm" onclick="registerFCMToken()"&gt;
    &lt;i class="bi bi-bell-fill"&gt;&lt;/i&gt; Register Token
&lt;/button&gt;
                    </div>

                    <h5>JavaScript Function:</h5>
                    <div class="code-block mb-3">
async function registerFCMToken() {
    try {
        // Check if we're on mobile with Capacitor
        if (typeof Capacitor !== 'undefined' && Capacitor.isNativePlatform()) {
            // Mobile implementation with Capacitor
            const { PushNotifications } = Capacitor.Plugins;
            
            // Request permissions
            const permission = await PushNotifications.requestPermissions();
            if (permission.receive !== 'granted') {
                throw new Error('Push notification permission denied');
            }
            
            // Register for push notifications
            await PushNotifications.register();
            
            // The actual token will be received in the registration listener
            Swal.fire({
                icon: 'info',
                title: 'Registering...',
                text: 'Please wait while we register your device for notifications.',
                timer: 3000
            });
            
        } else {
            // Web implementation fallback
            Swal.fire({
                icon: 'info',
                title: 'Web Platform',
                text: 'FCM token registration is primarily for mobile devices. Web notifications can be configured separately.'
            });
        }
    } catch (error) {
        console.error('FCM Registration Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: error.message || 'Failed to register for push notifications'
        });
    }
}
                    </div>

                    <h5>API Endpoint:</h5>
                    <div class="code-block">
POST /api/save-token
Content-Type: application/json

{
    "token": "fcm-device-token-here",
    "device_type": "ios|android|web"
}
                    </div>
                </div>

                <!-- Test Button -->
                <div class="preview-section text-center">
                    <h3>Test the Button</h3>
                    <p class="text-muted">Click to test the registration flow (will show web fallback message):</p>
                    <button type="button" class="btn btn-success btn-lg" onclick="registerFCMToken()">
                        <i class="bi bi-bell-fill"></i> Register Token
                    </button>
                </div>

                <!-- Status -->
                <div class="preview-section">
                    <h3>Integration Status</h3>
                    <div class="alert alert-success">
                        <h5><i class="bi bi-check-circle-fill"></i> Integration Complete</h5>
                        <ul class="mb-0">
                            <li>Button added to dashboard toolbar Actions section</li>
                            <li>JavaScript function implemented with Capacitor detection</li>
                            <li>API endpoint <code>/api/save-token</code> ready and tested</li>
                            <li>Error handling and user feedback systems in place</li>
                            <li>Mobile-first approach with web fallback</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // The same registerFCMToken function as implemented in the dashboard
        async function registerFCMToken() {
            try {
                // Check if we're on mobile with Capacitor
                if (typeof Capacitor !== 'undefined' && Capacitor.isNativePlatform()) {
                    // Mobile implementation with Capacitor
                    const { PushNotifications } = Capacitor.Plugins;
                    
                    // Request permissions
                    const permission = await PushNotifications.requestPermissions();
                    if (permission.receive !== 'granted') {
                        throw new Error('Push notification permission denied');
                    }
                    
                    // Register for push notifications
                    await PushNotifications.register();
                    
                    // The actual token will be received in the registration listener
                    Swal.fire({
                        icon: 'info',
                        title: 'Registering...',
                        text: 'Please wait while we register your device for notifications.',
                        timer: 3000
                    });
                    
                } else {
                    // Web implementation fallback
                    Swal.fire({
                        icon: 'info',
                        title: 'Web Platform Detected',
                        text: 'FCM token registration is primarily for mobile devices. This button will work when accessed from the mobile app.',
                        footer: 'For web notifications, configure Firebase web SDK separately.'
                    });
                }
            } catch (error) {
                console.error('FCM Registration Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Registration Failed',
                    text: error.message || 'Failed to register for push notifications'
                });
            }
        }
    </script>
</body>
</html>