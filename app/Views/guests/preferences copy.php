<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> - Preferences <?= esc($guest['full_name']) ?></title>

    <!-- Favicons -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57" href="/favicons/apple-touch-icon-57x57.png" />
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="/favicons/apple-touch-icon-114x114.png" />
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/favicons/apple-touch-icon-72x72.png" />
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="/favicons/apple-touch-icon-144x144.png" />
    <link rel="apple-touch-icon-precomposed" sizes="60x60" href="/favicons/apple-touch-icon-60x60.png" />
    <link rel="apple-touch-icon-precomposed" sizes="120x120" href="/favicons/apple-touch-icon-120x120.png" />
    <link rel="apple-touch-icon-precomposed" sizes="76x76" href="/favicons/apple-touch-icon-76x76.png" />
    <link rel="apple-touch-icon-precomposed" sizes="152x152" href="/favicons/apple-touch-icon-152x152.png" />
    <link rel="icon" type="image/png" href="/favicons/favicon-196x196.png" sizes="196x196" />
    <link rel="icon" type="image/png" href="/favicons/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/favicons/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicons/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/png" href="/favicons/favicon-128.png" sizes="128x128" />
    <meta name="msapplication-TileImage" content="/favicons/mstile-144x144.png" />
    <meta name="msapplication-square70x70logo" content="/favicons/mstile-70x70.png" />
    <meta name="msapplication-square150x150logo" content="/favicons/mstile-150x150.png" />
    <meta name="msapplication-wide310x150logo" content="/favicons/mstile-310x150.png" />
    <meta name="msapplication-square310x310logo" content="/favicons/mstile-310x310.png" />
    <link rel="icon" type="image/svg+xml" href="/favicons/favicon-square.svg" />
    <link rel="shortcut icon" href="/favicons/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content=".Here" />
    <link rel="manifest" href="/favicons/site.webmanifest" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- Custom Fonts -->
    <link rel="stylesheet" href="/assets/media/fonts/Moeda.css">
    <style>
        @font-face {
            font-family: 'Moeda';
            src: url('/assets/media/fonts/Moeda.woff') format('woff'),
                url('/assets/media/fonts/Moeda.ttf') format('truetype'),
                url('/assets/media/fonts/Moeda.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'OpenSans';
            src: url('/assets/media/fonts/OpenSansRegular.woff') format('woff'),
                url('/assets/media/fonts/OpenSansRegular.ttf') format('truetype'),
                url('/assets/media/fonts/OpenSansRegular.otf') format('opentype');
            font-weight: normal;
            font-style: normal;
        }

        body,
        p,
        span,
        div,
        li,
        ul,
        ol,
        a,
        input,
        textarea,
        button,
        label {
            font-family: 'OpenSans', Arial, sans-serif;
            font-size: 1em;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Moeda', Arial, sans-serif;
            font-size: 2em;
        }

        /* Responsive tweaks */
        @media (max-width: 576px) {
            .container.my-5 {
                margin-top: 1rem !important;
                margin-bottom: 1rem !important;
            }

            .mb-4 {
                margin-bottom: 1rem !important;
            }

            .btn {
                font-size: 0.95rem;
                padding: 0.5rem 1rem;
            }
        }

        /* Welcome Page Specific Styles */
        .welcome-header {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('/assets/media/hotel/header.webp') center center/cover no-repeat;
        }

        .welcome-logo {
            height: 120px;
        }

        .welcome-content {
            max-width: 600px;
            width: 100%;
        }

        .preferences-form {
            max-width: 800px;
            margin: auto;
        }

        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .form-section h4 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control, .form-select {
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .form-control:focus, .form-select:focus {
            border-color: #666;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #333;
            border-color: #333;
            padding: 0.75rem 2rem;
            border-radius: 6px;
        }

        .btn-primary:hover {
            background-color: #555;
            border-color: #555;
        }

        .guest-info {
            background: #e9ecef;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
</head>

<body>
    <div class="container my-5 px-2 px-sm-3">
        <div class="mt-4">
            <!-- Header Section -->
            <div class="mb-4">
                <div class="welcome-header">
                    <img src="/assets/media/hotel/logo.png" alt="Company Logo" class="welcome-logo">
                </div>
            </div>

            <!-- Preferences Form -->
            <div class="mb-4">
                <div class="d-flex justify-content-center">
                    <div class="preferences-form">
                        <h2 class="text-center mb-4">MY .HERE PREFERENCES - <?= esc($guest['full_name']) ?></h2>
                        <p>An invitation to share the little details that will make your .Here time truly yours.</p>
                    

                        <!-- Preferences Form -->
                        <form id="preferencesForm" action="<?= base_url('preferences/save') ?>" method="POST">
                            <input type="hidden" name="guest_token" value="<?= esc($guest['guest_token']) ?>">
                            
                            <!-- Dietary Preferences -->
                            <div class="form-section">
                                <h4><i class="bi bi-cup-straw me-2"></i>Dietary Preferences</h4>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="dietary_restrictions" class="form-label">Dietary Restrictions</label>
                                        <select class="form-select" id="dietary_restrictions" name="dietary_restrictions">
                                            <option value="">Select dietary restrictions</option>
                                            <option value="none">No restrictions</option>
                                            <option value="vegetarian">Vegetarian</option>
                                            <option value="vegan">Vegan</option>
                                            <option value="gluten_free">Gluten Free</option>
                                            <option value="halal">Halal</option>
                                            <option value="kosher">Kosher</option>
                                            <option value="lactose_free">Lactose Free</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="food_allergies" class="form-label">Food Allergies</label>
                                        <input type="text" class="form-control" id="food_allergies" name="food_allergies" 
                                               placeholder="Please specify any food allergies">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="dining_preferences" class="form-label">Special Dining Preferences</label>
                                    <textarea class="form-control" id="dining_preferences" name="dining_preferences" rows="3" 
                                              placeholder="Any special dining requests or preferences..."></textarea>
                                </div>
                            </div>

                            <!-- Accommodation Preferences -->
                            <div class="form-section">
                                <h4><i class="bi bi-house me-2"></i>Accommodation Preferences</h4>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pillow_type" class="form-label">Pillow Preference</label>
                                        <select class="form-select" id="pillow_type" name="pillow_type">
                                            <option value="">Select pillow type</option>
                                            <option value="soft">Soft</option>
                                            <option value="medium">Medium</option>
                                            <option value="firm">Firm</option>
                                            <option value="memory_foam">Memory Foam</option>
                                            <option value="feather">Feather</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="room_temperature" class="form-label">Room Temperature Preference</label>
                                        <select class="form-select" id="room_temperature" name="room_temperature">
                                            <option value="">Select temperature</option>
                                            <option value="cool">Cool (18-20°C)</option>
                                            <option value="moderate">Moderate (21-23°C)</option>
                                            <option value="warm">Warm (24-26°C)</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="special_requests" class="form-label">Special Room Requests</label>
                                    <textarea class="form-control" id="special_requests" name="special_requests" rows="3" 
                                              placeholder="Any special accommodation requests..."></textarea>
                                </div>
                            </div>

                            <!-- Activities & Interests -->
                            <div class="form-section">
                                <h4><i class="bi bi-activity me-2"></i>Activities & Interests</h4>
                                
                                <div class="mb-3">
                                    <label class="form-label">Preferred Activities (Select all that apply)</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="snorkeling" id="activity_snorkeling" name="activities[]">
                                                <label class="form-check-label" for="activity_snorkeling">Snorkeling</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="diving" id="activity_diving" name="activities[]">
                                                <label class="form-check-label" for="activity_diving">Diving</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="fishing" id="activity_fishing" name="activities[]">
                                                <label class="form-check-label" for="activity_fishing">Fishing</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="spa" id="activity_spa" name="activities[]">
                                                <label class="form-check-label" for="activity_spa">Spa & Wellness</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="water_sports" id="activity_water_sports" name="activities[]">
                                                <label class="form-check-label" for="activity_water_sports">Water Sports</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="excursions" id="activity_excursions" name="activities[]">
                                                <label class="form-check-label" for="activity_excursions">Island Excursions</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="photography" id="activity_photography" name="activities[]">
                                                <label class="form-check-label" for="activity_photography">Photography</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="sunset_cruise" id="activity_sunset_cruise" name="activities[]">
                                                <label class="form-check-label" for="activity_sunset_cruise">Sunset Cruise</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="cultural_tours" id="activity_cultural_tours" name="activities[]">
                                                <label class="form-check-label" for="activity_cultural_tours">Cultural Tours</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="activity_notes" class="form-label">Additional Activity Interests</label>
                                    <textarea class="form-control" id="activity_notes" name="activity_notes" rows="3" 
                                              placeholder="Any other activities or experiences you're interested in..."></textarea>
                                </div>
                            </div>

                            <!-- Special Occasions -->
                            <div class="form-section">
                                <h4><i class="bi bi-calendar-heart me-2"></i>Special Occasions</h4>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="occasion_type" class="form-label">Celebrating any special occasion?</label>
                                        <select class="form-select" id="occasion_type" name="occasion_type">
                                            <option value="">Select occasion</option>
                                            <option value="honeymoon">Honeymoon</option>
                                            <option value="anniversary">Anniversary</option>
                                            <option value="birthday">Birthday</option>
                                            <option value="engagement">Engagement</option>
                                            <option value="wedding">Wedding</option>
                                            <option value="family_vacation">Family Vacation</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="occasion_date" class="form-label">Occasion Date (if during stay)</label>
                                        <input type="date" class="form-control" id="occasion_date" name="occasion_date">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="occasion_notes" class="form-label">Special Occasion Details</label>
                                    <textarea class="form-control" id="occasion_notes" name="occasion_notes" rows="3" 
                                              placeholder="Tell us more about your special occasion..."></textarea>
                                </div>
                            </div>

                            <!-- Additional Information -->
                            <div class="form-section">
                                <h4><i class="bi bi-chat-dots me-2"></i>Additional Information</h4>
                                
                                <div class="mb-3">
                                    <label for="additional_notes" class="form-label">Any other preferences or requests?</label>
                                    <textarea class="form-control" id="additional_notes" name="additional_notes" rows="4" 
                                              placeholder="Please share any other information that would help us make your stay perfect..."></textarea>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Save Preferences
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mb-4">
                <div class="mt-5 py-4 bg-light">
                    <div class="container d-flex justify-content-center">
                        <a href="https://www.here-maldives.com/" target="_blank" class="mx-3 text-secondary">
                            <i class="bi bi-globe"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61577687646689" target="_blank"
                            class="mx-3 text-secondary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/_.herebaaatoll" target="_blank" class="mx-3 text-secondary">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('preferencesForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get form data
            const formData = new FormData(this);
            
            // Convert checkbox values to array
            const activities = [];
            document.querySelectorAll('input[name="activities[]"]:checked').forEach(function(checkbox) {
                activities.push(checkbox.value);
            });
            
            // Create data object
            const data = {
                guest_token: formData.get('guest_token'),
                dietary_restrictions: formData.get('dietary_restrictions'),
                food_allergies: formData.get('food_allergies'),
                dining_preferences: formData.get('dining_preferences'),
                pillow_type: formData.get('pillow_type'),
                room_temperature: formData.get('room_temperature'),
                special_requests: formData.get('special_requests'),
                activities: activities,
                activity_notes: formData.get('activity_notes'),
                occasion_type: formData.get('occasion_type'),
                occasion_date: formData.get('occasion_date'),
                occasion_notes: formData.get('occasion_notes'),
                additional_notes: formData.get('additional_notes')
            };
            
            // Submit via AJAX
            fetch(this.action, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Preferences saved successfully!');
                    // Optionally redirect or close window
                    // window.close();
                } else {
                    alert('Error saving preferences: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving preferences. Please try again.');
            });
        });
    </script>
</body>

</html>