<?php

namespace App\Controllers;

use App\Models\GuestModel;
use CodeIgniter\HTTP\RedirectResponse;

class GuestsController extends BaseController
{
    protected $guestModel;
    protected $logModel;

    public function __construct()
    {
        $this->guestModel = new GuestModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Get current authenticated user ID
     */
    private function getCurrentUserId(): ?int
    {
        try {
            // Method 1: Try auth helper functions
            if (function_exists('user_id')) {
                $userId = user_id();
                if ($userId) {
                    return (int)$userId;
                }
            }
            
            if (function_exists('user')) {
                $user = user();
                if ($user && isset($user->id)) {
                    return (int)$user->id;
                }
            }
            
            // Method 2: Try session-based approach
            $session = session();
            $sessionUserId = $session->get('logged_in') ?? $session->get('user_id') ?? $session->get('id');
            if ($sessionUserId) {
                return (int)$sessionUserId;
            }
            
            // Method 3: Try to get from user data in session
            $userData = $session->get('user');
            if ($userData) {
                if (is_array($userData) && isset($userData['id'])) {
                    return (int)$userData['id'];
                } elseif (is_object($userData) && isset($userData->id)) {
                    return (int)$userData->id;
                }
            }
            
            // Method 4: Last resort - check if there's a specific auth session key
            foreach (['auth_user_id', 'user_session', 'current_user'] as $key) {
                $value = $session->get($key);
                if ($value) {
                    if (is_numeric($value)) {
                        return (int)$value;
                    } elseif (is_array($value) && isset($value['id'])) {
                        return (int)$value['id'];
                    } elseif (is_object($value) && isset($value->id)) {
                        return (int)$value->id;
                    }
                }
            }
            
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'Error getting current user ID: ' . $e->getMessage());
            return null;
        }
    }

    private function sanitizeGuestInput(array $data, bool $isUpdate = false): array
    {
        $sanitized = [
            'villa_id' => isset($data['villa_id']) ? (int)$data['villa_id'] : null,
            'full_name' => isset($data['full_name']) ? trim(strip_tags($data['full_name'])) : '',
            'phone' => isset($data['phone']) ? trim(strip_tags($data['phone'])) : '',
            'email' => isset($data['email']) ? trim(strip_tags($data['email'])) : '',
            'arrival_date' => isset($data['arrival_date']) ? $data['arrival_date'] : null,
            'departure_date' => isset($data['departure_date']) ? $data['departure_date'] : null,
            // Map form field names to database field names
            'arrival_to_here' => isset($data['arrival_time']) ? trim($data['arrival_time']) : (isset($data['arrival_to_here']) ? $data['arrival_to_here'] : null),
            'departure_from_here' => isset($data['departure_time']) ? trim($data['departure_time']) : (isset($data['departure_from_here']) ? $data['departure_from_here'] : null),
            'inclusive' => isset($data['inclusive']) ? trim(strip_tags($data['inclusive'])) : '',
            'guest_type' => isset($data['guest_type']) ? trim(strip_tags($data['guest_type'])) : 'adult',
            'status' => isset($data['status']) ? trim(strip_tags($data['status'])) : 'pending',
            'guest_token' => isset($data['guest_token']) ? trim(strip_tags($data['guest_token'])) : null,
            'reservation_code' => isset($data['reservation_code']) ? trim(strip_tags($data['reservation_code'])) : '',
            'notes' => isset($data['notes']) ? trim(strip_tags($data['notes'])) : '',
        ];

        // Get current user ID for tracking
        $currentUserId = $this->getCurrentUserId();
        
        // Set tracking fields
        if ($currentUserId) {
            if (!$isUpdate) {
                // For new records, set created_by
                $sanitized['created_by'] = $currentUserId;
            }
            // Always set updated_by for both create and update operations
            $sanitized['updated_by'] = $currentUserId;
        }

        // Generate guest token if not provided
        if (empty($sanitized['guest_token']) && !$isUpdate) {
            $sanitized['guest_token'] = $this->guestModel->generateGuestToken();
        }

        return $sanitized;
    }

    /**
     * Log guest operations to the logs table
     */
    private function logGuestOperation(string $action, array $guestData, int $guestId = null): void
    {
        try {
            $guestNumber = $guestId ?? ($guestData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Guest Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Guest Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Guest Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Guest ' . ucfirst($action);
                    break;
            }
            
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $guestNumber . "\n";
            $actionDescription .= "Guest Name: " . ($guestData['full_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Email: " . ($guestData['email'] ?? 'N/A') . "\n";
            $actionDescription .= "Phone: " . ($guestData['phone'] ?? 'N/A') . "\n";
            $actionDescription .= "Villa: " . ($guestData['villa_name'] ?? 'N/A') . "\n";
            $actionDescription .= "Guest Type: " . ($guestData['guest_type'] ?? 'N/A') . "\n";
            $actionDescription .= "Status: " . ($guestData['status'] ?? 'N/A') . "\n";
            $actionDescription .= "Guest Token: " . ($guestData['guest_token'] ?? 'N/A') . "\n";
            $actionDescription .= "Reservation Code: " . ($guestData['reservation_code'] ?? 'N/A') . "\n";
            $actionDescription .= "Arrival Date: " . ($guestData['arrival_date'] ?? 'N/A') . "\n";
            $actionDescription .= "Departure Date: " . ($guestData['departure_date'] ?? 'N/A') . "\n";
            $actionDescription .= "Inclusive: " . ($guestData['inclusive'] ?? 'N/A') . "\n";
            $actionDescription .= "Notes: " . ($guestData['notes'] ?? 'No notes provided');

            $logData = [
                'status_id' => $logStatusId,
                'module_id' => 5, // Assuming module ID 15 for guests (adjust as needed)
                'action' => $actionDescription,
            ];
            
            $result = $this->logModel->insert($logData);
            
            if ($result) {
                log_message('info', 'Successfully inserted guest log with ID: ' . $result);
            } else {
                $errors = $this->logModel->errors();
                log_message('error', 'Failed to insert guest log. Errors: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to log guest operation: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of guests
     */
    public function index()
    {
        // Check permissions (temporarily disabled like in islanders)
        // if (!has_permission('guests.view')) {
        //     return redirect()->to('/')->with('error', 'You do not have permission to view guests.');
        // }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        $guests = $this->guestModel->getGuestsWithPagination($search, $limit, $offset);
        $totalGuests = $this->guestModel->getGuestsCount($search);
        $totalPages = ceil($totalGuests / $limit);

        // Check if this is an AJAX request for pagination
        if ($this->request->isAJAX() || $this->request->getGet('ajax')) {
            return $this->response->setJSON([
                'success' => true,
                'guests' => $guests,
                'currentPage' => $page,
                'totalPages' => $totalPages,
                'totalGuests' => $totalGuests,
                'hasMore' => ($offset + $limit) < $totalGuests
            ]);
        }

        // Get dropdown data
        $villas = $this->guestModel->getActiveVillas();
        $guestTypes = $this->guestModel->getGuestTypes();
        $guestStatuses = $this->guestModel->getGuestStatuses();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => true, // Temporarily allow all (adjust based on your permission system)
            'canEdit' => true,
            'canView' => true,
            'canDelete' => true
        ];

        $data = [
            'title' => 'Guest Management',
            'guests' => $guests,
            'villas' => $villas,
            'guestTypes' => $guestTypes,
            'guestStatuses' => $guestStatuses,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalGuests' => $totalGuests,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('guests/index', $data);
    }

    /**
     * Store a newly created guest in database
     */
    public function store()
    {
        log_message('info', 'Guest store called. Method: ' . $this->request->getMethod());
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Check permissions
        // if (!has_permission('guests.create')) {
        //     if ($this->request->isAJAX()) {
        //         return $this->response->setJSON([
        //             'success' => false,
        //             'message' => 'You do not have permission to create guests.'
        //         ]);
        //     }
        //     return redirect()->back()->with('error', 'You do not have permission to create guests.');
        // }

        // Validate the input
        if (!$this->validate($this->guestModel->getValidationRules())) {
            log_message('error', 'Guest validation failed: ' . json_encode($this->validator->getErrors()));
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $this->validator->getErrors(),
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $this->validator->getErrors());
        }

        // Prepare data for insertion with sanitization
        $rawData = $this->request->getPost();
        $data = $this->sanitizeGuestInput($rawData, false);
        
        log_message('info', 'Raw POST data: ' . json_encode($rawData));
        log_message('info', 'Sanitized guest data: ' . json_encode($data));

        // Insert the guest
        if ($guestId = $this->guestModel->insert($data)) {
            log_message('info', 'Guest created successfully with ID: ' . $guestId);
            
            // Get the full guest data for logging
            $guestData = $this->guestModel->getGuest($guestId);
            
            // Log the create operation
            $this->logGuestOperation('create', $guestData, $guestId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Guest created successfully!'
                ]);
            }
            return redirect()->to('/guests')
                           ->with('success', 'Guest created successfully!');
        } else {
            log_message('error', 'Failed to create guest. Model errors: ' . json_encode($this->guestModel->errors()));
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create guest. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create guest. Please try again.');
        }
    }

    /**
     * Display the specified guest (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check permissions
        // if (!has_permission('guests.view')) {
        //     return $this->response->setStatusCode(403)->setJSON([
        //         'success' => false,
        //         'message' => 'You do not have permission to view guests.'
        //     ]);
        // }

        // Only allow AJAX requests for modals
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Guest ID is required.'
            ]);
        }

        $guest = $this->guestModel->getGuest($id);

        if (!$guest) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Guest not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'guest' => $guest
        ]);
    }

    /**
     * Update the specified guest in database
     */
    public function update($id = null)
    {
        // Check permissions
        // if (!has_permission('guests.edit')) {
        //     if ($this->request->isAJAX()) {
        //         return $this->response->setJSON([
        //             'success' => false,
        //             'message' => 'You do not have permission to edit guests.'
        //         ]);
        //     }
        //     return redirect()->back()->with('error', 'You do not have permission to edit guests.');
        // }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Guest ID is required.'
                ]);
            }
            return redirect()->to('/guests')
                           ->with('error', 'Guest ID is required.');
        }

        $guest = $this->guestModel->getGuest($id);

        if (!$guest) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Guest not found.'
                ]);
            }
            return redirect()->to('/guests')
                           ->with('error', 'Guest not found.');
        }

        // Sanitize and validate the input
        $rawData = $this->request->getPost();
        $inputData = $this->sanitizeGuestInput($rawData, true);
        
        log_message('info', 'Raw POST data for update: ' . json_encode($rawData));
        log_message('info', 'Sanitized guest update data: ' . json_encode($inputData));
        
        $validationResult = $this->guestModel->validateForUpdate($inputData, $id);
        
        if ($validationResult !== true) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $validationResult,
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validationResult);
        }

        // Update the guest
        try {
            $this->guestModel->skipValidation(true);
            $result = $this->guestModel->update($id, $inputData);
            $this->guestModel->skipValidation(false);
            
            if ($result) {
                // Get the updated guest data for logging
                $updatedGuest = $this->guestModel->getGuest($id);
                
                // Log the update operation
                $this->logGuestOperation('update', $updatedGuest, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Guest updated successfully!'
                    ]);
                }
                return redirect()->to('/guests')
                               ->with('success', 'Guest updated successfully!');
            } else {
                $errors = $this->guestModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update guest: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update guest: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database error: ' . $e->getMessage()
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Database error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified guest from database
     */
    public function delete($id = null)
    {
        // Check permissions
        // if (!has_permission('guests.delete')) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'You do not have permission to delete guests.'
        //     ]);
        // }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Guest ID is required.'
            ]);
        }

        $guest = $this->guestModel->getGuest($id);

        if (!$guest) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Guest not found.'
            ]);
        }

        // Delete the guest
        if ($this->guestModel->delete($id)) {
            // Log the delete operation
            $this->logGuestOperation('delete', $guest, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Guest deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete guest. Please try again.'
            ]);
        }
    }

    /**
     * Get guests for AJAX requests
     */
    public function getGuests()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $guests = $this->guestModel->getGuestsWithPagination($search, $limit, $offset);
        $totalGuests = $this->guestModel->getGuestsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $guests,
            'total' => $totalGuests
        ]);
    }

    /**
     * API endpoint for mobile infinite scroll
     */
    public function api()
    {
        // Only allow AJAX requests
        if (!$this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Access denied'
            ]);
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = ($page - 1) * $limit;

        $guests = $this->guestModel->getGuestsWithPagination($search, $limit, $offset);
        $totalGuests = $this->guestModel->getGuestsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $guests,
            'total' => $totalGuests,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalGuests
        ]);
    }
    
    /**
     * Display welcome page for guests (public access)
     */
    public function welcome($guestToken = null)
    {
        if ($guestToken === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Find guest by token
        $guest = $this->guestModel->where('guest_token', $guestToken)->first();

        if (!$guest) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get additional guest details with villa information
        $guestDetails = $this->guestModel->getGuest($guest['id']);
        
        // Get all guests with the same reservation code
        $allReservationGuests = [];
        if (!empty($guestDetails['reservation_code'])) {
            $allReservationGuests = $this->guestModel
                ->select('id, full_name, guest_token, guest_type')
                ->where('reservation_code', $guestDetails['reservation_code'])
                ->findAll();
        }

        $data = [
            'title' => 'Welcome to Stay Profile',
            'guest' => $guestDetails,
            'allReservationGuests' => $allReservationGuests
        ];

        return view('guests/welcome', $data);
    }

    /**
     * Display preferences page for guests (public access)
     */
    public function preferences($guestToken = null)
    {
        if ($guestToken === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Find guest by token
        $guest = $this->guestModel->where('guest_token', $guestToken)->first();

        if (!$guest) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get additional guest details with villa information
        $guestDetails = $this->guestModel->getGuest($guest['id']);

        // Get current page from query parameter, default to 1
        $currentPage = (int)($this->request->getGet('page') ?? 1);

        // Load QuestionModel to get active questions for current page
        $questionModel = new \App\Models\QuestionModel();
        $questions = $questionModel->getActiveQuestionsByPage($currentPage);

        // Get total pages to determine if there are more pages
        $totalPages = $questionModel->getTotalPages();

        // Get question options for MCQ questions
        $questionOptions = [];
        if (!empty($questions)) {
            $db = \Config\Database::connect();
            foreach ($questions as $question) {
                if (in_array($question['type'], ['single_mcq', 'multi_mcq'])) {
                    $options = $db->table('question_options')
                        ->where('question_id', $question['id'])
                        ->where('is_active', 1)
                        ->orderBy('sort_order', 'ASC')
                        ->get()
                        ->getResultArray();
                    $questionOptions[$question['id']] = $options;
                }
            }
        }

        // Load saved preferences from database
        $preferenceModel = new \App\Models\PreferenceModel();
        $savedPreferences = $preferenceModel->getGuestPreferences($guest['id']);
        
        // Convert saved preferences to format suitable for form population
        $formPreferences = [];
        $followupPreferences = [];
        
        foreach ($savedPreferences as $pref) {
            $questionId = $pref['question_id'];
            
            // Handle answer values
            if (!empty($pref['answer_text'])) {
                $formPreferences[$questionId] = $pref['answer_text'];
            } elseif (!empty($pref['answer_values_json'])) {
                $values = json_decode($pref['answer_values_json'], true);
                if (is_array($values)) {
                    $formPreferences[$questionId] = $values;
                }
            }
            
            // Handle follow-up text
            if (!empty($pref['followup_text'])) {
                log_message('info', "Processing follow-up text for question {$questionId}: " . $pref['followup_text']);
                
                // Try to parse as JSON first (new format)
                $followupData = json_decode($pref['followup_text'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($followupData)) {
                    // New JSON format - use the data directly
                    log_message('info', "Using new JSON format for question {$questionId}");
                    foreach ($followupData as $key => $value) {
                        $followupPreferences[$key] = $value;
                        log_message('info', "Added followup: {$key} = {$value}");
                    }
                } else {
                    // Old format: Parse follow-up text (format: "value1; value2; value3")
                    // This is for backward compatibility
                    log_message('info', "Using old string format for question {$questionId}");
                    $followupValues = explode('; ', $pref['followup_text']);
                    foreach ($followupValues as $i => $value) {
                        if (!empty($value)) {
                            // Create a followup key - we'll need to match this with option IDs
                            $followupPreferences["{$questionId}_{$i}"] = $value;
                            log_message('info', "Added old format followup: {$questionId}_{$i} = {$value}");
                        }
                    }
                }
            }
        }

        // If this is an AJAX request (for page navigation), return JSON
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'questions' => $questions,
                'questionOptions' => $questionOptions,
                'currentPage' => $currentPage,
                'totalPages' => $totalPages,
                'hasNextPage' => $currentPage < $totalPages,
                'savedPreferences' => $formPreferences,
                'followupPreferences' => $followupPreferences
            ]);
        }

        $data = [
            'title' => 'My .Here Preferences',
            'guest' => $guestDetails,
            'questions' => $questions,
            'questionOptions' => $questionOptions,
            'currentPage' => $currentPage,
            'totalPages' => $totalPages,
            'hasNextPage' => $currentPage < $totalPages,
            'savedPreferences' => $formPreferences,
            'followupPreferences' => $followupPreferences
        ];

        return view('guests/preferences', $data);
    }

    /**
     * Test endpoint for debugging
     */
    public function testEndpoint()
    {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Test endpoint reached successfully',
            'method' => $this->request->getMethod(),
            'time' => date('Y-m-d H:i:s')
        ]);
    }

    /**
     * Save guest preferences (public access)
     */
    public function savePreferences()
    {
        // Debug the request
        log_message('info', '=== SAVE PREFERENCES DEBUG START ===');
        log_message('info', 'savePreferences called - Method: ' . $this->request->getMethod());
        log_message('info', 'isAJAX: ' . ($this->request->isAJAX() ? 'true' : 'false'));
        log_message('info', 'Request URI: ' . $this->request->getUri());
        log_message('info', 'Content-Type: ' . $this->request->getHeaderLine('Content-Type'));
        log_message('info', 'X-Requested-With: ' . $this->request->getHeaderLine('X-Requested-With'));
        log_message('info', 'Raw Input: ' . $this->request->getBody());
        log_message('info', '=== SAVE PREFERENCES DEBUG END ===');
        
        // Temporarily allow any method for debugging
        $method = strtolower($this->request->getMethod());
        if ($method !== 'post') {
            log_message('error', 'Not a POST request, method was: ' . $method);
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method - must be POST, got: ' . $method,
                'debug' => [
                    'method' => $method,
                    'isAjax' => $this->request->isAJAX(),
                    'contentType' => $this->request->getHeaderLine('Content-Type')
                ]
            ]);
        }

        // Check for AJAX indicators (more permissive)
        $hasXRequestedWith = $this->request->hasHeader('X-Requested-With');
        $isJsonContent = strpos($this->request->getHeaderLine('Content-Type'), 'application/json') !== false;
        $isAjax = $this->request->isAJAX() || $hasXRequestedWith || $isJsonContent;
                  
        log_message('info', 'AJAX check details: isAJAX=' . ($this->request->isAJAX() ? 'true' : 'false') . 
                    ', hasXRequestedWith=' . ($hasXRequestedWith ? 'true' : 'false') . 
                    ', isJsonContent=' . ($isJsonContent ? 'true' : 'false') . 
                    ', final=' . ($isAjax ? 'true' : 'false'));
                  
        if (!$isAjax) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request - AJAX required',
                'debug' => [
                    'isAJAX' => $this->request->isAJAX(),
                    'hasXRequestedWith' => $hasXRequestedWith,
                    'contentType' => $this->request->getHeaderLine('Content-Type')
                ]
            ]);
        }

        // Get JSON data
        $jsonData = $this->request->getJSON(true);
        log_message('info', 'JSON data received: ' . json_encode($jsonData));
        
        if (empty($jsonData['guest_token'])) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Guest token is required'
            ]);
        }

        // Find guest by token
        $guest = $this->guestModel->where('guest_token', $jsonData['guest_token'])->first();

        if (!$guest) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Guest not found'
            ]);
        }

        try {
            // Load the PreferenceModel
            $preferenceModel = new \App\Models\PreferenceModel();
            
            // Extract question responses and follow-ups from the JSON data
            $questionResponses = $jsonData['questions'] ?? [];
            $followupResponses = $jsonData['questions']['followups'] ?? [];
            
            // Remove followups from main questions array to avoid confusion
            unset($questionResponses['followups']);
            
            log_message('info', 'Saving preferences for guest ID: ' . $guest['id']);
            log_message('info', 'Question responses: ' . json_encode($questionResponses));
            log_message('info', 'Followup responses: ' . json_encode($followupResponses));
            
            // Save all preferences using the model's batch save method
            $result = $preferenceModel->saveGuestPreferences(
                $guest['id'], 
                $questionResponses, 
                $followupResponses
            );

            if ($result) {
                // Log the successful save operation
                $this->logGuestOperation('preferences_saved', [
                    'id' => $guest['id'],
                    'full_name' => $guest['full_name'],
                    'email' => $guest['email'],
                    'phone' => $guest['phone'],
                    'villa_name' => $guest['villa_name'] ?? 'N/A',
                    'guest_type' => $guest['guest_type'],
                    'status' => $guest['status'],
                    'guest_token' => $guest['guest_token'],
                    'reservation_code' => $guest['reservation_code'],
                    'arrival_date' => $guest['arrival_date'],
                    'departure_date' => $guest['departure_date'],
                    'inclusive' => $guest['inclusive'],
                    'notes' => 'Preferences saved with ' . count($questionResponses) . ' responses'
                ], $guest['id']);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Preferences saved successfully!'
                ]);
            } else {
                log_message('error', 'Failed to save preferences for guest ID: ' . $guest['id']);
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save preferences. Please try again.'
                ]);
            }

        } catch (\Exception $e) {
            log_message('error', 'Error saving guest preferences: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'An error occurred while saving preferences: ' . $e->getMessage()
            ]);
        }
    }
}
