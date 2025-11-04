<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title) ?> - <?= esc($guest['full_name']) ?></title>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    
    <!-- Custom Fonts -->
    <!-- <link rel="stylesheet" href="/assets/media/fonts/Moeda.css"> -->
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
            src: url('/assets/media/fonts/OpenSansRegular.ttf') format('truetype'),
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
            /* background: #f8f9fa; */
            /* border-radius: 8px; */
            /* padding: 1rem; */
            /* margin-bottom: 1rem; */
        }

        .form-section h4 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .form-label {
            font-weight: 100;
            color: #000000;
            font-size: 1.1rem;
        }

        .text-muted {
            font-size: 0.85rem;
        }

        .form-section .text-muted.mb-3 {
            font-size: 0.85rem;
        }

        .form-control, .form-select {
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .form-control:focus, .form-select:focus {
            border-color: #666;
            box-shadow: 0 0 0 0.2rem rgba(0, 0, 0, 0.1);
        }

        /* Multi-choice horizontal layout */
        .multi-choice-horizontal {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .multi-choice-horizontal .form-check {
            flex: 0 0 auto;
            margin-bottom: 0;
        }

        /* Responsive adjustments for mobile */
        @media (max-width: 768px) {
            .multi-choice-horizontal {
                flex-direction: column;
                gap: 0.5rem;
            }
        }

        /* Validation styles */
        .validation-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: block;
        }

        /* Follow-up field validation styling */
        .followup-field .validation-error {
            margin-left: 0;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .form-check-input.is-invalid {
            border-color: #dc3545;
        }

        .form-check-input.is-invalid:checked {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .question-group.has-error {
            border-left: 3px solid #dc3545;
            padding-left: 1rem;
            margin-left: -1rem;
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
                        <h2 class="text-center mb-4">My .Here Preferences - <?= esc($guest['full_name']) ?></h2>
                        <!-- <p>An invitation to share the little details that will make your .Here time truly yours.</p> -->
                    

                        <!-- Preferences Form -->
                        <form id="preferencesForm" action="<?= base_url('preferences/save') ?>" method="POST" novalidate>
                            <input type="hidden" name="guest_token" value="<?= esc($guest['guest_token']) ?>">
                            
                            <!-- Questions Container -->
                            <div id="questionsContainer">
                                <?php if (!empty($questions)): ?>
                                    <?php foreach ($questions as $question): ?>
                                        <div class="form-section">
                                            <?php if ($question['type'] !== 'text_block'): ?>
                                                <h4>
                                                    <?php if (!empty($question['label'])): ?>
                                                        <?= esc($question['label']) ?>
                                                    <?php endif; ?>
                                                    <?php if ($question['is_required']): ?>
                                                        <span class="text-danger">*</span>
                                                    <?php endif; ?>
                                                </h4>
                                            <?php endif; ?>
                                            
                                            <?php if (!empty($question['description']) && $question['type'] !== 'text_block'): ?>
                                                <p class="text-muted mb-3"><?= esc($question['description']) ?></p>
                                            <?php endif; ?>
                                            
                                            <?php switch ($question['type']): 
                                                case 'text': ?>
                                                    <div class="mb-3">
                                                        <input type="text" 
                                                               class="form-control" 
                                                               id="question_<?= $question['id'] ?>" 
                                                               name="questions[<?= $question['id'] ?>]" 
                                                               <?= $question['is_required'] ? 'required' : '' ?>>
                                                    </div>
                                                    <?php break; 
                                                    
                                                case 'textarea': ?>
                                                    <div class="mb-3">
                                                        <textarea class="form-control" 
                                                                  id="question_<?= $question['id'] ?>" 
                                                                  name="questions[<?= $question['id'] ?>]" 
                                                                  rows="3" 
                                                                  <?= $question['is_required'] ? 'required' : '' ?>></textarea>
                                                    </div>
                                                    <?php break; 
                                                    
                                                case 'single_mcq': ?>
                                                    <div class="mb-3">
                                                        <?php if (!empty($questionOptions[$question['id']])): ?>
                                                            <?php foreach ($questionOptions[$question['id']] as $option): ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" 
                                                                           type="radio" 
                                                                           value="<?= esc($option['label']) ?>" 
                                                                           id="question_<?= $question['id'] ?>_<?= $option['id'] ?>" 
                                                                           name="questions[<?= $question['id'] ?>]"
                                                                           data-has-followup="<?= $option['has_followup'] ?>"
                                                                           data-followup-target="followup_<?= $question['id'] ?>_<?= $option['id'] ?>"
                                                                           data-followup-required="<?= $option['followup_required'] ?>"
                                                                           <?= $question['is_required'] ? 'required' : '' ?>
                                                                           onchange="toggleFollowup(this)">
                                                                    <label class="form-check-label" for="question_<?= $question['id'] ?>_<?= $option['id'] ?>">
                                                                        <?= esc($option['label']) ?>
                                                                    </label>
                                                                </div>
                                                                <?php if ($option['has_followup'] == 1): ?>
                                                                    <div class="followup-field ms-4 mt-2" id="followup_<?= $question['id'] ?>_<?= $option['id'] ?>" style="display: none;">
                                                                        <label class="form-label text-muted"><?= esc($option['followup_label']) ?></label>
                                                                        <input type="text" 
                                                                               class="form-control form-control-sm" 
                                                                               name="followup[<?= $question['id'] ?>_<?= $option['id'] ?>]"
                                                                               placeholder="<?= esc($option['followup_placeholder']) ?>"
                                                                               <?= $option['followup_required'] == 1 ? 'required' : '' ?>>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php break; 
                                                    
                                                case 'multi_mcq': ?>
                                                    <div class="mb-3">
                                                        <?php if (!empty($questionOptions[$question['id']])): ?>
                                                            <div class="multi-choice-horizontal">
                                                                <?php foreach ($questionOptions[$question['id']] as $option): ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" 
                                                                               type="checkbox" 
                                                                               value="<?= esc($option['label']) ?>" 
                                                                               id="question_<?= $question['id'] ?>_<?= $option['id'] ?>" 
                                                                               name="questions[<?= $question['id'] ?>][]"
                                                                               data-has-followup="<?= $option['has_followup'] ?>"
                                                                               data-followup-target="followup_<?= $question['id'] ?>_<?= $option['id'] ?>"
                                                                               data-followup-required="<?= $option['followup_required'] ?>"
                                                                               data-question-id="<?= $question['id'] ?>"
                                                                               <?= $question['is_required'] ? 'required' : '' ?>
                                                                               onchange="toggleFollowup(this)">
                                                                        <label class="form-check-label" for="question_<?= $question['id'] ?>_<?= $option['id'] ?>">
                                                                            <?= esc($option['label']) ?>
                                                                        </label>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </div>
                                                            <!-- Follow-up fields container -->
                                                            <?php foreach ($questionOptions[$question['id']] as $option): ?>
                                                                <?php if ($option['has_followup'] == 1): ?>
                                                                    <div class="followup-field ms-4 mt-2" id="followup_<?= $question['id'] ?>_<?= $option['id'] ?>" style="display: none;">
                                                                        <label class="form-label text-muted"><?= esc($option['followup_label']) ?></label>
                                                                        <input type="text" 
                                                                               class="form-control form-control-sm" 
                                                                               name="followup[<?= $question['id'] ?>_<?= $option['id'] ?>]"
                                                                               placeholder="<?= esc($option['followup_placeholder']) ?>"
                                                                               <?= $option['followup_required'] == 1 ? 'required' : '' ?>>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php break; 
                                                    
                                                case 'text_block': ?>
                                                    <div class="mb-3">
                                                        <?php if (!empty($question['label'])): ?>
                                                            <h4><?= esc($question['label']) ?></h4>
                                                        <?php endif; ?>
                                                        <?php if (!empty($question['description'])): ?>
                                                            <p><?= nl2br(esc($question['description'])) ?></p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php break; 
                                                    
                                                default: ?>
                                                    <div class="mb-3">
                                                        <p class="text-warning">Unknown question type: <?= esc($question['type']) ?></p>
                                                    </div>
                                            <?php endswitch; ?>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="text-center py-4">
                                        <p class="text-muted">No questions available for this page.</p>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Page Navigation -->
                            <div class="d-flex justify-content-between align-items-center mt-4 mb-3">
                                <div>
                                    <span class="text-muted">Page <?= $currentPage ?> of <?= $totalPages ?></span>
                                </div>
                                <div>
                                    <?php if ($currentPage > 1): ?>
                                        <button type="button" class="btn btn-sm btn-secondary me-2" id="prevPageBtn">
                                            <i class="bi bi-arrow-left me-1"></i>Previous
                                        </button>
                                    <?php endif; ?>
                                    
                                    <?php if ($hasNextPage): ?>
                                        <button type="button" class="btn btn-sm btn-dark" id="nextPageBtn">
                                            Next<i class="bi bi-arrow-right ms-1"></i>
                                        </button>
                                    <?php else: ?>
                                        <!-- Submit Button - only show on last page -->
                                        <button type="submit" class="btn btn-sm btn-dark">
                                            <i class="bi bi-check-circle me-2"></i>Save Preferences
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mb-4">
                <div class="mt-5 py-4 bg-light">
                    <div class="container d-flex justify-content-center">
                        <a href="https://www.facebook.com/profile.php?id=61577687646689" target="_blank"
                            class="mx-3 text-secondary">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="https://www.instagram.com/_.herebaaatoll" target="_blank" class="mx-3 text-secondary">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.here-maldives.com/" target="_blank" class="mx-3 text-secondary">
                            <i class="bi bi-globe2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Store responses from all pages
        let allResponses = {};
        let currentPage = <?= $currentPage ?>;
        let totalPages = <?= $totalPages ?>;
        const guestToken = '<?= esc($guest['guest_token']) ?>';

        // Load saved preferences from server-side data
        const savedPreferences = <?= json_encode($savedPreferences ?? []) ?>;
        const followupPreferences = <?= json_encode($followupPreferences ?? []) ?>;
        
        console.log('Loaded saved preferences from database:', savedPreferences);
        console.log('Loaded followup preferences from database:', followupPreferences);

        // Load existing responses from database if available
        function loadStoredResponses() {
            console.log('Loading preferences from database...');
            
            // Initialize with saved preferences from database
            allResponses = {...savedPreferences};
            
            // Add followup preferences
            if (Object.keys(followupPreferences).length > 0) {
                allResponses.followups = followupPreferences;
            }
            
            console.log('Loaded database preferences:', allResponses);
            
            // Check if current page has required fields that aren't filled
            setTimeout(() => {
                checkPageCompletionAndRedirect();
            }, 500);
            
            // Populate the form with loaded data
            populateFormWithResponses();
        }

        // Check if current page is incomplete and redirect if needed
        function checkPageCompletionAndRedirect() {
            // Don't redirect if we're on the first page
            if (currentPage <= 1) {
                console.log('On first page, no redirect needed');
                return;
            }
            
            console.log('Checking page completion for page', currentPage);
            
            // Get all required inputs on current page
            const requiredInputs = document.querySelectorAll('#questionsContainer input[required], #questionsContainer textarea[required]');
            let hasIncompleteFields = false;
            
            requiredInputs.forEach(input => {
                if (input.type === 'radio') {
                    const groupName = input.name;
                    const checkedRadio = document.querySelector(`input[name="${groupName}"]:checked`);
                    if (!checkedRadio) {
                        hasIncompleteFields = true;
                        console.log('Incomplete radio group:', groupName);
                    }
                } else if (input.type === 'checkbox') {
                    const questionId = input.getAttribute('data-question-id');
                    if (questionId) {
                        const checkedBoxes = document.querySelectorAll(`input[data-question-id="${questionId}"]:checked`);
                        if (checkedBoxes.length === 0) {
                            hasIncompleteFields = true;
                            console.log('Incomplete checkbox group:', questionId);
                        }
                    }
                } else {
                    // Text input or textarea
                    if (!input.value || !input.value.trim()) {
                        hasIncompleteFields = true;
                        console.log('Incomplete text field:', input.name || input.id);
                    }
                }
            });
            
            // Check follow-up fields
            const visibleFollowupInputs = document.querySelectorAll('#questionsContainer .followup-field[style*="block"] input[required]');
            visibleFollowupInputs.forEach(input => {
                if (!input.value || !input.value.trim()) {
                    hasIncompleteFields = true;
                    console.log('Incomplete follow-up field:', input.name);
                }
            });
            
            if (hasIncompleteFields) {
                console.log('Page has incomplete required fields, redirecting to page 1');
                // Redirect to first page
                window.location.href = window.location.pathname + '?page=1';
            } else {
                console.log('Page is complete, staying on current page');
            }
        }

        // Save current page responses (temporary storage for page navigation)
        function saveCurrentPageResponses() {
            const formData = new FormData(document.getElementById('preferencesForm'));
            
            // Clear previous responses for current page questions to avoid stale data
            const currentPageQuestionIds = new Set();
            document.querySelectorAll('#questionsContainer input[name^="questions["], #questionsContainer textarea[name^="questions["]').forEach(input => {
                const match = input.name.match(/questions\[(\d+)\]/);
                if (match) {
                    currentPageQuestionIds.add(match[1]);
                }
            });
            
            // Remove old responses for current page questions
            currentPageQuestionIds.forEach(questionId => {
                delete allResponses[questionId];
            });
            
            // Collect all question responses from current page
            for (let [key, value] of formData.entries()) {
                if (key.startsWith('questions[')) {
                    // Extract question ID from key like "questions[123]" or "questions[123][]"
                    const match = key.match(/questions\[(\d+)\](\[\])?/);
                    if (match) {
                        const questionId = match[1];
                        const isArray = !!match[2];
                        
                        // Only save non-empty values
                        if (value && value.trim() !== '') {
                            if (isArray) {
                                // Multiple choice question
                                if (!allResponses[questionId]) {
                                    allResponses[questionId] = [];
                                }
                                if (!allResponses[questionId].includes(value)) {
                                    allResponses[questionId].push(value);
                                }
                            } else {
                                // Single value question
                                allResponses[questionId] = value;
                            }
                        }
                    }
                } else if (key.startsWith('followup[')) {
                    // Handle follow-up responses
                    const followupMatch = key.match(/followup\[(.+)\]/);
                    if (followupMatch && value && value.trim() !== '') {
                        const followupKey = followupMatch[1];
                        if (!allResponses.followups) {
                            allResponses.followups = {};
                        }
                        allResponses.followups[followupKey] = value;
                    }
                }
            }

            console.log('Current page responses collected:', allResponses);
            // Note: No localStorage saving - responses only kept in memory for page navigation
        }

        // Populate form with stored responses
        function populateFormWithResponses() {
            // Only populate if we have actual stored responses
            if (!allResponses || Object.keys(allResponses).length === 0) {
                console.log('No responses to populate');
                return;
            }

            console.log('Populating form with responses:', allResponses);

            for (let questionId in allResponses) {
                if (questionId === 'followups') continue; // Handle followups separately
                
                const value = allResponses[questionId];
                
                // Skip empty values completely
                if (!value || (typeof value === 'string' && value.trim() === '')) {
                    console.log(`Skipping empty value for question ${questionId}`);
                    continue;
                }
                
                if (Array.isArray(value) && value.length > 0) {
                    // Multiple choice - check checkboxes (only if array has values)
                    value.forEach(val => {
                        if (val && val.trim() !== '') {
                            const checkbox = document.querySelector(`input[name="questions[${questionId}][]"][value="${val}"]`);
                            if (checkbox) {
                                checkbox.checked = true;
                                // Trigger follow-up display if needed
                                toggleFollowup(checkbox);
                            }
                        }
                    });
                } else if (typeof value === 'string' && value.trim() !== '') {
                    // Single value - text, textarea, or radio (only if value is not empty)
                    const textInput = document.querySelector(`input[name="questions[${questionId}]"]`);
                    const textareaInput = document.querySelector(`textarea[name="questions[${questionId}]"]`);
                    const radioInput = document.querySelector(`input[name="questions[${questionId}]"][value="${value}"]`);
                    
                    if (textInput && (textInput.type === 'text' || textInput.type === 'email')) {
                        textInput.value = value;
                    } else if (textareaInput) {
                        textareaInput.value = value;
                    } else if (radioInput) {
                        radioInput.checked = true;
                        // Trigger follow-up display if needed
                        toggleFollowup(radioInput);
                    }
                }
            }
            
            // Restore follow-up field values (ensure fields are visible first)
            // Use a small delay to ensure DOM is fully updated after main form population
            setTimeout(() => {
                if (allResponses.followups) {
                    console.log('=== FOLLOW-UP RESTORATION DEBUG ===');
                    console.log('Follow-up data to restore:', allResponses.followups);
                    
                    // Get all available follow-up fields for mapping
                    const allFollowupFields = document.querySelectorAll('.followup-field');
                    const fieldMapping = {};
                    allFollowupFields.forEach(field => {
                        const fieldId = field.id;
                        const input = field.querySelector('input');
                        if (fieldId && input) {
                            fieldMapping[fieldId] = input.name;
                        }
                    });
                    console.log('Available field mapping:', fieldMapping);
                    
                    for (let followupKey in allResponses.followups) {
                        const followupValue = allResponses.followups[followupKey];
                        console.log(`Processing follow-up: ${followupKey} = "${followupValue}"`);
                        
                        if (followupValue && followupValue.trim() !== '') {
                            // Find the follow-up field container and input
                            let followupFieldId = `followup_${followupKey}`;
                            let followupInputName = `followup[${followupKey}]`;
                            
                            let followupField = document.getElementById(followupFieldId);
                            let followupInput = document.querySelector(`input[name="${followupInputName}"]`);
                            
                            // If not found and this looks like old format (e.g., "5_0"), try to map to actual option IDs
                            if (!followupField && followupKey.includes('_')) {
                                const [questionId, indexOrOptionId] = followupKey.split('_');
                                console.log(`Trying to map old format: question ${questionId}, index/option ${indexOrOptionId}`);
                                
                                // Look for any follow-up field for this question
                                const questionFollowupFields = Array.from(allFollowupFields).filter(field => 
                                    field.id.startsWith(`followup_${questionId}_`)
                                );
                                
                                console.log(`Found ${questionFollowupFields.length} follow-up fields for question ${questionId}:`, 
                                           questionFollowupFields.map(f => f.id));
                                
                                if (questionFollowupFields.length > 0) {
                                    // Use the first available field for this question
                                    followupField = questionFollowupFields[0];
                                    followupFieldId = followupField.id;
                                    followupInput = followupField.querySelector('input');
                                    followupInputName = followupInput ? followupInput.name : null;
                                    
                                    console.log(`Mapped ${followupKey} to field ${followupFieldId}`);
                                }
                            }
                            
                            console.log(`Looking for field ID: "${followupFieldId}"`);
                            console.log(`Looking for input name: "${followupInputName}"`);
                            console.log(`Found field:`, followupField);
                            console.log(`Found input:`, followupInput);
                            
                            if (followupField && followupInput) {
                                console.log(`✅ Restoring follow-up field ${followupKey} with value: "${followupValue}"`);
                                
                                // Make sure the follow-up field is visible
                                followupField.style.display = 'block';
                                console.log(`Set field visibility to block`);
                                
                                // Set the value
                                followupInput.value = followupValue;
                                console.log(`Set input value to: "${followupInput.value}"`);
                                
                                // Make field required if needed (based on trigger element)
                                const triggerElement = document.querySelector(`input[data-followup-target="${followupFieldId}"]:checked`);
                                console.log(`Trigger element:`, triggerElement);
                                
                                if (triggerElement && triggerElement.getAttribute('data-followup-required') === '1') {
                                    followupInput.required = true;
                                    console.log(`Set field as required`);
                                }
                            } else {
                                console.log(`❌ Could not find follow-up field or input for key: ${followupKey}`);
                                console.log(`Expected field ID: "${followupFieldId}"`);
                                console.log(`Expected input name: "${followupInputName}"`);
                                
                                // Debug: List all follow-up fields that exist
                                console.log(`Available follow-up fields:`, allFollowupFields);
                                allFollowupFields.forEach(field => {
                                    console.log(`  - ID: "${field.id}", Input name: "${field.querySelector('input')?.name}"`);
                                });
                            }
                        }
                    }
                    console.log('=== FOLLOW-UP RESTORATION COMPLETE ===');
                }
            }, 200); // Increased delay to 200ms
        }

        // Navigate to next page
        function goToNextPage() {
            if (currentPage < totalPages) {
                // Validate current page before proceeding
                if (validateCurrentPage()) {
                    saveCurrentPageResponses();
                    loadPage(currentPage + 1);
                }
            }
        }

        // Validate current page fields
        function validateCurrentPage() {
            clearValidationErrors();
            let isValid = true;
            const validationErrors = [];
            
            console.log('=== VALIDATION DEBUG START ===');
            console.log('Starting validation for page', currentPage);
            
            // Get all required fields on current page
            const allRequiredInputs = document.querySelectorAll('#questionsContainer input[required], #questionsContainer textarea[required]');
            console.log('All required inputs found:', allRequiredInputs.length);
            allRequiredInputs.forEach((input, index) => {
                console.log(`Required input ${index + 1}:`, {
                    type: input.type,
                    name: input.name,
                    id: input.id,
                    value: input.value,
                    checked: input.checked,
                    required: input.required
                });
            });
            
            const requiredRadioGroups = new Set();
            
            // Collect required radio button groups
            document.querySelectorAll('#questionsContainer input[type="radio"][required]').forEach(radio => {
                requiredRadioGroups.add(radio.name);
            });
            
            console.log('Found required radio groups:', Array.from(requiredRadioGroups));
            
            // Validate text inputs and textareas
            const textInputs = document.querySelectorAll('#questionsContainer input[required]:not([type="radio"]):not([type="checkbox"]), #questionsContainer textarea[required]');
            console.log('Text inputs to validate:', textInputs.length);
            
            textInputs.forEach((input, index) => {
                const value = input.value ? input.value.trim() : '';
                console.log(`Text input ${index + 1} (${input.name || input.id}): "${value}" (empty: ${!value})`);
                
                if (!value) {
                    console.log(`❌ Validation failed for text input: ${input.name || input.id}`);
                    showValidationError(input, 'This field is required');
                    validationErrors.push(`Text field: ${input.name || input.id}`);
                    isValid = false;
                } else {
                    console.log(`✅ Text input valid: ${input.name || input.id}`);
                }
            });

            // Collect required checkbox groups (multiple choice questions)
            const requiredCheckboxGroups = new Set();
            document.querySelectorAll('#questionsContainer input[type="checkbox"][required]').forEach(checkbox => {
                const questionId = checkbox.getAttribute('data-question-id');
                if (questionId) {
                    requiredCheckboxGroups.add(questionId);
                }
            });

            console.log('Found required checkbox groups:', Array.from(requiredCheckboxGroups));

            // Validate required checkbox groups (at least one must be selected)
            requiredCheckboxGroups.forEach(questionId => {
                const allCheckboxes = document.querySelectorAll(`input[data-question-id="${questionId}"]`);
                const checkedBoxes = document.querySelectorAll(`input[data-question-id="${questionId}"]:checked`);
                console.log(`Checkbox group ${questionId}: ${checkedBoxes.length}/${allCheckboxes.length} selected`);
                
                if (checkedBoxes.length === 0) {
                    const firstCheckbox = document.querySelector(`input[data-question-id="${questionId}"]`);
                    if (firstCheckbox) {
                        console.log(`❌ Validation failed for checkbox group: ${questionId}`);
                        showValidationError(firstCheckbox, 'Please select at least one option', 'radio-group');
                        validationErrors.push(`Checkbox group: ${questionId}`);
                        isValid = false;
                    }
                } else {
                    console.log(`✅ Checkbox group valid: ${questionId}`);
                }
            });

            // Validate required radio button groups
            requiredRadioGroups.forEach(groupName => {
                const allRadios = document.querySelectorAll(`input[name="${groupName}"]`);
                const checkedRadio = document.querySelector(`input[name="${groupName}"]:checked`);
                console.log(`Radio group ${groupName}: ${checkedRadio ? 'selected' : 'none selected'} (${allRadios.length} total)`);
                
                if (!checkedRadio) {
                    const firstRadio = document.querySelector(`input[name="${groupName}"]`);
                    if (firstRadio) {
                        console.log(`❌ Validation failed for radio group: ${groupName}`);
                        showValidationError(firstRadio, 'Please select an option', 'radio-group');
                        validationErrors.push(`Radio group: ${groupName}`);
                        isValid = false;
                    }
                } else {
                    console.log(`✅ Radio group valid: ${groupName}`);
                }
            });

            // Validate follow-up fields that should be required based on selections
            const allFollowupInputs = document.querySelectorAll('#questionsContainer .followup-field input[required]');
            console.log('Follow-up inputs to check:', allFollowupInputs.length);
            
            allFollowupInputs.forEach((input, index) => {
                const followupField = input.closest('.followup-field');
                if (followupField) {
                    const targetId = followupField.id;
                    const triggerElement = document.querySelector(`input[data-followup-target="${targetId}"]:checked`);
                    const value = input.value ? input.value.trim() : '';
                    
                    console.log(`Follow-up ${index + 1} (${targetId}): trigger=${!!triggerElement}, value="${value}"`);
                    
                    if (triggerElement && !value) {
                        console.log(`❌ Validation failed for followup field: ${targetId}`);
                        followupField.style.display = 'block';
                        showValidationError(input, 'This follow-up field is required', 'followup');
                        validationErrors.push(`Followup field: ${targetId}`);
                        isValid = false;
                    } else if (triggerElement) {
                        console.log(`✅ Follow-up field valid: ${targetId}`);
                    }
                }
            });
            
            console.log('=== VALIDATION SUMMARY ===');
            console.log('Valid:', isValid);
            console.log('Errors:', validationErrors);
            
            if (!isValid) {
                console.log('❌ Validation failed! Errors:', validationErrors);
                // Scroll to the first error
                const firstErrorElement = document.querySelector('.is-invalid');
                if (firstErrorElement) {
                    console.log('Scrolling to first error element:', firstErrorElement);
                    firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                } else {
                    console.log('No .is-invalid element found to scroll to');
                }
            } else {
                console.log('✅ All validation passed');
            }
            console.log('=== VALIDATION DEBUG END ===');
            
            return isValid;
        }

        // Show validation error
        function showValidationError(element, message, type = 'input') {
            // Remove existing error for this specific element first
            removeValidationError(element);
            
            element.classList.add('is-invalid');
            
            if (type === 'radio-group') {
                // For radio groups, show error after the entire radio group
                const groupName = element.name;
                const radios = document.querySelectorAll(`input[name="${groupName}"]`);
                const lastRadio = radios[radios.length - 1];
                const errorDiv = document.createElement('div');
                errorDiv.className = 'validation-error text-danger small mt-1';
                errorDiv.textContent = message;
                
                // Find the container that holds all radio options
                const radioContainer = lastRadio.closest('.form-section') || lastRadio.closest('.mb-3');
                if (radioContainer) {
                    radioContainer.insertAdjacentElement('afterend', errorDiv);
                } else {
                    lastRadio.closest('.form-check').insertAdjacentElement('afterend', errorDiv);
                }
                
                // Add error styling to question group
                const questionGroup = lastRadio.closest('.form-section');
                if (questionGroup) {
                    questionGroup.classList.add('has-error');
                }
            } else if (type === 'followup') {
                // For follow-up fields, show error directly below the input field
                const errorDiv = document.createElement('div');
                errorDiv.className = 'validation-error text-danger small mt-1';
                errorDiv.textContent = message;
                
                // Position error right after the input field within the follow-up container
                element.insertAdjacentElement('afterend', errorDiv);
            } else {
                // For regular inputs (text, textarea), show error directly below the input
                const errorDiv = document.createElement('div');
                errorDiv.className = 'validation-error text-danger small mt-1';
                errorDiv.textContent = message;
                
                // Insert error directly after the input element
                element.insertAdjacentElement('afterend', errorDiv);
            }
        }

        // Remove validation error for specific element
        function removeValidationError(element) {
            // Remove is-invalid class
            element.classList.remove('is-invalid');
            
            // Remove validation error that might be directly after this element
            let nextSibling = element.nextElementSibling;
            while (nextSibling && nextSibling.classList.contains('validation-error')) {
                const toRemove = nextSibling;
                nextSibling = nextSibling.nextElementSibling;
                toRemove.remove();
            }
            
            // For radio groups and checkbox groups, also check for errors after containers
            if (element.type === 'radio') {
                // Check after form-check container
                const formCheck = element.closest('.form-check');
                if (formCheck) {
                    let nextElement = formCheck.nextElementSibling;
                    while (nextElement && nextElement.classList.contains('validation-error')) {
                        const toRemove = nextElement;
                        nextElement = nextElement.nextElementSibling;
                        toRemove.remove();
                    }
                }
                
                // Check after form-section container
                const formSection = element.closest('.form-section');
                if (formSection) {
                    let nextElement = formSection.nextElementSibling;
                    while (nextElement && nextElement.classList.contains('validation-error')) {
                        const toRemove = nextElement;
                        nextElement = nextElement.nextElementSibling;
                        toRemove.remove();
                    }
                }
            } else if (element.type === 'checkbox') {
                // For checkbox groups, also remove errors from the question container
                const questionContainer = element.closest('.multi-choice-horizontal') || element.closest('.question-block');
                if (questionContainer) {
                    let nextEl = questionContainer.nextElementSibling;
                    while (nextEl && nextEl.classList.contains('validation-error')) {
                        const toRemove = nextEl;
                        nextEl = nextEl.nextElementSibling;
                        toRemove.remove();
                    }
                }
                
                // Also check after form-section for checkbox groups
                const formSection = element.closest('.form-section');
                if (formSection) {
                    let nextElement = formSection.nextElementSibling;
                    while (nextElement && nextElement.classList.contains('validation-error')) {
                        const toRemove = nextElement;
                        nextElement = nextElement.nextElementSibling;
                        toRemove.remove();
                    }
                }
            }
        }

        // Clear validation errors
        function clearValidationErrors() {
            // Remove error classes
            document.querySelectorAll('.is-invalid').forEach(el => {
                el.classList.remove('is-invalid');
            });
            
            // Remove error messages
            document.querySelectorAll('.validation-error').forEach(el => {
                el.remove();
            });
            
            // Remove error styling from question groups
            document.querySelectorAll('.has-error').forEach(el => {
                el.classList.remove('has-error');
            });
        }

        // Navigate to previous page
        function goToPreviousPage() {
            if (currentPage > 1) {
                saveCurrentPageResponses();
                loadPage(currentPage - 1);
            }
        }

        // Load specific page via AJAX
        function loadPage(page) {
            const url = window.location.pathname + `?page=${page}`;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    currentPage = data.currentPage;
                    totalPages = data.totalPages;
                    
                    // Clear any existing validation errors before loading new page
                    clearValidationErrors();
                    
                    // Update the questions container
                    updateQuestionsHTML(data.questions, data.questionOptions);
                    
                    // Update navigation
                    updateNavigation(data.hasNextPage);
                    
                    // IMPORTANT: Preserve existing responses and merge with saved preferences
                    // Don't overwrite allResponses, instead merge saved preferences into existing responses
                    if (data.savedPreferences) {
                        // Only merge database values for keys that don't exist in current session
                        for (let key in data.savedPreferences) {
                            if (!(key in allResponses)) {
                                allResponses[key] = data.savedPreferences[key];
                            }
                        }
                        console.log('Merged saved preferences while preserving current session:', allResponses);
                    }
                    if (data.followupPreferences) {
                        // Merge follow-up preferences carefully
                        if (!allResponses.followups) {
                            allResponses.followups = {};
                        }
                        for (let key in data.followupPreferences) {
                            if (!(key in allResponses.followups)) {
                                allResponses.followups[key] = data.followupPreferences[key];
                            }
                        }
                        console.log('Merged followup preferences while preserving current session:', allResponses.followups);
                    }
                    
                    // Populate form with stored responses
                    populateFormWithResponses();
                    
                    // Update URL without page reload
                    history.pushState({page: currentPage}, '', url);
                } else {
                    alert('Error loading page: ' + (data.message || 'Unknown error'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading page. Please try again.');
            });
        }

        // Update questions HTML
        function updateQuestionsHTML(questions, questionOptions) {
            const container = document.getElementById('questionsContainer');
            let html = '';

            if (questions && questions.length > 0) {
                questions.forEach(question => {
                    html += '<div class="form-section">';
                    
                    if (question.type !== 'text_block') {
                        html += '<h4>';
                        if (question.label) {
                            html += escapeHtml(question.label);
                        }
                        if (question.is_required == 1) {
                            html += '<span class="text-danger">*</span>';
                        }
                        html += '</h4>';
                    }

                    if (question.description && question.type !== 'text_block') {
                        html += `<p class="text-muted mb-3">${escapeHtml(question.description)}</p>`;
                    }

                    switch (question.type) {
                        case 'text':
                            html += `
                                <div class="mb-3">
                                    <input type="text" 
                                           class="form-control" 
                                           id="question_${question.id}" 
                                           name="questions[${question.id}]" 
                                           value=""
                                           ${question.is_required == 1 ? 'required' : ''}>
                                </div>`;
                            break;

                        case 'textarea':
                            html += `
                                <div class="mb-3">
                                    <textarea class="form-control" 
                                              id="question_${question.id}" 
                                              name="questions[${question.id}]" 
                                              rows="3" 
                                              ${question.is_required == 1 ? 'required' : ''}></textarea>
                                </div>`;
                            break;

                        case 'single_mcq':
                            html += '<div class="mb-3">';
                            if (questionOptions[question.id]) {
                                questionOptions[question.id].forEach(option => {
                                    html += `
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="radio" 
                                                   value="${escapeHtml(option.label)}" 
                                                   id="question_${question.id}_${option.id}" 
                                                   name="questions[${question.id}]"
                                                   data-has-followup="${option.has_followup || 0}"
                                                   data-followup-target="followup_${question.id}_${option.id}"
                                                   data-followup-required="${option.followup_required || 0}"
                                                   onchange="toggleFollowup(this)"
                                                   ${question.is_required == 1 ? 'required' : ''}>
                                            <label class="form-check-label" for="question_${question.id}_${option.id}">
                                                ${escapeHtml(option.label)}
                                            </label>
                                        </div>`;
                                    
                                    // Add follow-up field if option has one
                                    if (option.has_followup == 1) {
                                        html += `
                                            <div class="followup-field ms-4 mt-2" id="followup_${question.id}_${option.id}" style="display: none;">
                                                <label class="form-label text-muted">${escapeHtml(option.followup_label || '')}</label>
                                                <input type="text" 
                                                       class="form-control form-control-sm" 
                                                       name="followup[${question.id}_${option.id}]"
                                                       value=""
                                                       placeholder="${escapeHtml(option.followup_placeholder || '')}"
                                                       ${option.followup_required == 1 ? 'required' : ''}>
                                            </div>`;
                                    }
                                });
                            }
                            html += '</div>';
                            break;

                        case 'multi_mcq':
                            html += '<div class="mb-3">';
                            if (questionOptions[question.id]) {
                                // Create horizontal container for checkboxes
                                html += '<div class="multi-choice-horizontal">';
                                questionOptions[question.id].forEach(option => {
                                    html += `
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   value="${escapeHtml(option.label)}" 
                                                   id="question_${question.id}_${option.id}" 
                                                   name="questions[${question.id}][]"
                                                   data-has-followup="${option.has_followup || 0}"
                                                   data-followup-target="followup_${question.id}_${option.id}"
                                                   data-followup-required="${option.followup_required || 0}"
                                                   data-question-id="${question.id}"
                                                   ${question.is_required == 1 ? 'required' : ''}
                                                   onchange="toggleFollowup(this)">
                                            <label class="form-check-label" for="question_${question.id}_${option.id}">
                                                ${escapeHtml(option.label)}
                                            </label>
                                        </div>`;
                                });
                                html += '</div>'; // Close horizontal container
                                
                                // Add follow-up fields after the horizontal container
                                questionOptions[question.id].forEach(option => {
                                    if (option.has_followup == 1) {
                                        html += `
                                            <div class="followup-field ms-4 mt-2" id="followup_${question.id}_${option.id}" style="display: none;">
                                                <label class="form-label text-muted">${escapeHtml(option.followup_label || '')}</label>
                                                <input type="text" 
                                                       class="form-control form-control-sm" 
                                                       name="followup[${question.id}_${option.id}]"
                                                       value=""
                                                       placeholder="${escapeHtml(option.followup_placeholder || '')}"
                                                       ${option.followup_required == 1 ? 'required' : ''}>
                                            </div>`;
                                    }
                                });
                            }
                            html += '</div>';
                            break;

                        case 'text_block':
                            html += '<div class="mb-3">';
                            if (question.label) {
                                html += `<h4>${escapeHtml(question.label)}</h4>`;
                            }
                            if (question.description) {
                                html += `<p>${escapeHtml(question.description).replace(/\n/g, '<br>')}</p>`;
                            }
                            html += '</div>';
                            break;

                        default:
                            html += `<div class="mb-3"><p class="text-warning">Unknown question type: ${escapeHtml(question.type)}</p></div>`;
                            break;
                    }

                    html += '</div>';
                });
            } else {
                html = '<div class="text-center py-4"><p class="text-muted">No questions available for this page.</p></div>';
            }

            container.innerHTML = html;
            
            // Ensure no pre-selected options after dynamic loading
            console.log('Questions HTML updated - checking for pre-selections');
            setTimeout(() => {
                debugPreselectedOptions();
            }, 100);
        }

        // Update navigation buttons
        function updateNavigation(hasNextPage) {
            const navigationDiv = document.querySelector('.d-flex.justify-content-between.align-items-center.mt-4.mb-3');
            
            let navHTML = `
                <div>
                    <span class="text-muted">Page ${currentPage} of ${totalPages}</span>
                </div>
                <div>`;

            if (currentPage > 1) {
                navHTML += `
                    <button type="button" class="btn btn-sm btn-secondary me-2" id="prevPageBtn">
                        <i class="bi bi-arrow-left me-1"></i>Previous
                    </button>`;
            }

            if (hasNextPage) {
                navHTML += `
                    <button type="button" class="btn btn-sm btn-dark" id="nextPageBtn">
                        Next<i class="bi bi-arrow-right ms-1"></i>
                    </button>`;
            } else {
                navHTML += `
                    <button type="submit" class="btn btn-sm btn-dark">
                        <i class="bi bi-check-circle me-2"></i>Save Preferences
                    </button>`;
            }

            navHTML += '</div>';
            navigationDiv.innerHTML = navHTML;

            // Reattach event listeners
            attachNavigationListeners();
        }

        // Attach event listeners to navigation buttons
        function attachNavigationListeners() {
            const nextBtn = document.getElementById('nextPageBtn');
            const prevBtn = document.getElementById('prevPageBtn');

            if (nextBtn) {
                nextBtn.addEventListener('click', goToNextPage);
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', goToPreviousPage);
            }
        }

        // Escape HTML to prevent XSS
        function escapeHtml(text) {
            const map = {
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;',
                "'": '&#039;'
            };
            return text.replace(/[&<>"']/g, function(m) { return map[m]; });
        }

        // Toggle follow-up fields based on option selection
        function toggleFollowup(element) {
            const hasFollowup = element.getAttribute('data-has-followup') === '1';
            const targetId = element.getAttribute('data-followup-target');
            
            if (element.type === 'radio') {
                // For radio buttons, hide all follow-ups in the same group first
                const groupName = element.name;
                const allRadios = document.querySelectorAll(`input[name="${groupName}"]`);
                allRadios.forEach(radio => {
                    const radioTarget = radio.getAttribute('data-followup-target');
                    if (radioTarget) {
                        const radioFollowup = document.getElementById(radioTarget);
                        const radioInput = radioFollowup ? radioFollowup.querySelector('input') : null;
                        if (radioFollowup) {
                            radioFollowup.style.display = 'none';
                        }
                        if (radioInput) {
                            radioInput.required = false;
                            radioInput.value = '';
                        }
                    }
                });
                
                // Show the selected option's follow-up if it has one
                if (element.checked && hasFollowup && targetId) {
                    const followupField = document.getElementById(targetId);
                    const followupInput = followupField ? followupField.querySelector('input') : null;
                    if (followupField) {
                        followupField.style.display = 'block';
                        if (followupInput && element.getAttribute('data-followup-required') === '1') {
                            followupInput.required = true;
                        }
                    }
                }
            } else if (element.type === 'checkbox') {
                // For checkboxes, toggle the specific follow-up
                if (hasFollowup && targetId) {
                    const followupField = document.getElementById(targetId);
                    const followupInput = followupField ? followupField.querySelector('input') : null;
                    if (followupField) {
                        if (element.checked) {
                            followupField.style.display = 'block';
                            if (followupInput && element.getAttribute('data-followup-required') === '1') {
                                followupInput.required = true;
                            }
                        } else {
                            followupField.style.display = 'none';
                            if (followupInput) {
                                followupInput.required = false;
                                followupInput.value = '';
                            }
                        }
                    }
                }
            }
        }

        // Show thank you page after successful submission
        function showThankYouPage() {
            // Hide the entire form content
            document.querySelector('.container.my-5').innerHTML = `
                <div class="mt-4">
                    <!-- Header Section -->
                    <div class="mb-4">
                        <div class="welcome-header">
                            <img src="/assets/media/hotel/logo.png" alt="Company Logo" class="welcome-logo">
                        </div>
                    </div>

                    <!-- Thank You Content -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-center">
                            <div class="preferences-form text-center">
                                <div class="mb-4">
                                    <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                                </div>
                                
                                <h2 class="text-center mb-4">Thank You!</h2>
                                
                                <div class="mb-4">
                                    <p class="lead">Your preferences have been saved successfully.</p>
                                    <p class="text-muted">We'll use these details to personalize your .Here experience and make your stay truly memorable.</p>
                                </div>
                                
                                
                                
                                <div class="mt-5 pt-4 border-top">
                                    <p class="text-muted small">
                                        If you need to make any changes to your preferences, 
                                        please revisit the preferences page.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mb-4">
                        <div class="mt-5 py-4 bg-light">
                            <div class="container d-flex justify-content-center">
                                <a href="https://www.facebook.com/profile.php?id=61577687646689" target="_blank"
                                    class="mx-3 text-secondary">
                                    <i class="bi bi-facebook"></i>
                                </a>
                                <a href="https://www.instagram.com/_.herebaaatoll" target="_blank" class="mx-3 text-secondary">
                                    <i class="bi bi-instagram"></i>
                                </a>
                                <a href="https://www.here-maldives.com/" target="_blank" class="mx-3 text-secondary">
                                    <i class="bi bi-globe2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        }

        // Handle form submission
        document.getElementById('preferencesForm').addEventListener('submit', function(e) {
            console.log('Form submission started...');
            
            // CRITICAL: Prevent default form submission first
            e.preventDefault();
            e.stopPropagation();
            
            console.log('Form submission prevented, running validation...');
            
            // Clear any existing validation errors first
            clearValidationErrors();
            
            // Validate current page before submitting
            console.log('Starting validation...');
            const validationResult = validateCurrentPage();
            console.log('Validation result:', validationResult);
            
            if (!validationResult) {
                console.log('❌ Validation failed - preventing submission');
                
                // Force show validation errors
                setTimeout(() => {
                    const errors = document.querySelectorAll('.validation-error');
                    const invalidInputs = document.querySelectorAll('.is-invalid');
                    console.log('Validation errors after timeout:', errors.length);
                    console.log('Invalid inputs after timeout:', invalidInputs.length);
                    
                    // Scroll to first error
                    const firstError = document.querySelector('.is-invalid');
                    if (firstError) {
                        console.log('Scrolling to first error:', firstError);
                        firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    } else {
                        console.log('No invalid inputs found to scroll to');
                    }
                }, 100);
                
                return false;
            }
            
            console.log('✅ Validation passed - proceeding with submission');
            
            // Save current page responses before submitting
            saveCurrentPageResponses();
            
            console.log('Submitting preferences...');
            console.log('All responses:', allResponses);
            
            // Show loading state
            const submitBtn = document.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
            submitBtn.disabled = true;
            
            // Create data object with all collected responses
            const data = {
                guest_token: guestToken,
                questions: allResponses
            };
            
            console.log('Sending data:', data);
            
            // Get the form action URL for debugging
            const formAction = document.getElementById('preferencesForm').action;
            console.log('Form action URL:', formAction);
            
            // Submit via AJAX
            fetch(formAction, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    console.log('✅ Preferences saved to database');
                    showThankYouPage();
                } else {
                    console.error('❌ Failed to save preferences:', data.message);
                    alert('Error saving preferences: ' + (data.message || 'Unknown error'));
                    // Restore button state
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving preferences. Please try again.');
                // Restore button state
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
        }, false);

        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Check for any pre-selected options that shouldn't be there
            debugPreselectedOptions();
            
            loadStoredResponses();
            attachNavigationListeners();
            attachValidationListeners();
            
            // Add submit button click handler to ensure validation works
            const submitBtn = document.querySelector('button[type="submit"]');
            if (submitBtn) {
                console.log('Adding click handler to submit button');
                submitBtn.addEventListener('click', function(e) {
                    console.log('Submit button clicked directly');
                    e.preventDefault();
                    e.stopPropagation();
                    
                    console.log('Running validation before form submission...');
                    
                    // Clear existing validation errors first
                    clearValidationErrors();
                    
                    // Run validation with the same logic as Next button
                    const validationResult = validateCurrentPage();
                    console.log('Submit button validation result:', validationResult);
                    
                    if (!validationResult) {
                        console.log('Validation failed - showing errors and stopping submission');
                        
                        // Scroll to the first error (same as Next button behavior)
                        setTimeout(() => {
                            const firstError = document.querySelector('.is-invalid');
                            if (firstError) {
                                console.log('Scrolling to first error element');
                                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        }, 100);
                        
                        return false;
                    }
                    
                    // If validation passes, proceed with form submission
                    console.log('Validation passed - proceeding with form submission');
                    
                    // Save current page responses before submitting
                    saveCurrentPageResponses();
                    
                    // Manually trigger the form submit event to proceed with AJAX submission
                    const form = document.getElementById('preferencesForm');
                    const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
                    form.dispatchEvent(submitEvent);
                    
                    return false;
                });
            } else {
                console.log('Submit button not found!');
            }
        });

        // Debug function to check for pre-selected options
        function debugPreselectedOptions() {
            const preselectedRadios = document.querySelectorAll('input[type="radio"]:checked');
            const preselectedCheckboxes = document.querySelectorAll('input[type="checkbox"]:checked');
            
            if (preselectedRadios.length > 0) {
                console.log('Found pre-selected radio buttons (from database):', preselectedRadios);
                preselectedRadios.forEach(radio => {
                    console.log('Pre-selected radio:', radio.name, '=', radio.value);
                });
            }
            
            if (preselectedCheckboxes.length > 0) {
                console.log('Found pre-selected checkboxes (from database):', preselectedCheckboxes);
                preselectedCheckboxes.forEach(checkbox => {
                    console.log('Pre-selected checkbox:', checkbox.name, '=', checkbox.value);
                });
            }

            console.log('Database-loaded preferences will be shown on form');
        }

        // Clear all form selections (for fresh start)
        function clearAllSelections() {
            // Clear all radio buttons
            document.querySelectorAll('input[type="radio"]').forEach(radio => {
                radio.checked = false;
            });
            
            // Clear all checkboxes
            document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Clear all text inputs
            document.querySelectorAll('input[type="text"], textarea').forEach(input => {
                input.value = '';
            });
            
            // Hide all follow-up fields
            document.querySelectorAll('.followup-field').forEach(field => {
                field.style.display = 'none';
                const input = field.querySelector('input');
                if (input) {
                    input.required = false;
                    input.value = '';
                }
            });
            
            console.log('All form selections cleared');
        }

        // Attach real-time validation listeners
        function attachValidationListeners() {
            // Clear validation on input for text fields
            document.addEventListener('input', function(e) {
                if (e.target.matches('input[type="text"], input[type="email"], textarea')) {
                    if (e.target.classList.contains('is-invalid')) {
                        e.target.classList.remove('is-invalid');
                        removeValidationError(e.target);
                    }
                }
            });

            // Clear validation on change for radio buttons and checkboxes
            document.addEventListener('change', function(e) {
                if (e.target.matches('input[type="radio"], input[type="checkbox"]')) {
                    if (e.target.classList.contains('is-invalid')) {
                        // For radio groups, clear all radios in the group
                        if (e.target.type === 'radio') {
                            const groupName = e.target.name;
                            document.querySelectorAll(`input[name="${groupName}"]`).forEach(radio => {
                                radio.classList.remove('is-invalid');
                            });
                            removeValidationErrorFromGroup(groupName);
                        } else if (e.target.type === 'checkbox') {
                            // For checkbox groups, check if any checkbox in the question is now selected
                            const questionId = e.target.getAttribute('data-question-id');
                            if (questionId) {
                                const checkedBoxes = document.querySelectorAll(`input[data-question-id="${questionId}"]:checked`);
                                if (checkedBoxes.length > 0) {
                                    // Clear validation for all checkboxes in this question group
                                    document.querySelectorAll(`input[data-question-id="${questionId}"]`).forEach(checkbox => {
                                        checkbox.classList.remove('is-invalid');
                                        removeValidationError(checkbox);
                                    });
                                }
                            } else {
                                e.target.classList.remove('is-invalid');
                                removeValidationError(e.target);
                            }
                        }
                    }
                }
            });
        }

        // Remove validation error for a specific element
        function removeValidationError(element) {
            const container = element.closest('.mb-3') || element.closest('.followup-field') || element.parentElement;
            const errorElement = container.nextElementSibling;
            if (errorElement && errorElement.classList.contains('validation-error')) {
                errorElement.remove();
            }
        }

        // Remove validation error for radio group
        function removeValidationErrorFromGroup(groupName) {
            const radios = document.querySelectorAll(`input[name="${groupName}"]`);
            const lastRadio = radios[radios.length - 1];
            if (lastRadio) {
                const questionGroup = lastRadio.closest('.form-section');
                if (questionGroup) {
                    questionGroup.classList.remove('has-error');
                }
                
                // Find and remove error message
                let nextElement = lastRadio.closest('.form-check').nextElementSibling;
                if (nextElement && nextElement.classList.contains('validation-error')) {
                    nextElement.remove();
                }
            }
        }

        // Handle browser back/forward buttons
        window.addEventListener('popstate', function(event) {
            if (event.state && event.state.page) {
                loadPage(event.state.page);
            }
        });
    </script>
</body>

</html>