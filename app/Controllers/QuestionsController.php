<?php

namespace App\Controllers;

use App\Models\QuestionModel;
use App\Models\QuestionOptionModel;
use CodeIgniter\HTTP\RedirectResponse;

class QuestionsController extends BaseController
{
    protected $questionModel;
    protected $questionOptionModel;
    protected $logModel;

    public function __construct()
    {
        $this->questionModel = new QuestionModel();
        $this->questionOptionModel = new QuestionOptionModel();
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

    /**
     * Sanitize input data for question
     */
    private function sanitizeQuestionInput(array $data): array
    {
        $sanitized = [
            'label' => isset($data['label']) ? trim(strip_tags($data['label'])) : '',
            'description' => isset($data['description']) ? 
                trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
            'type' => isset($data['type']) ? trim(strip_tags($data['type'])) : 'text',
            'is_required' => isset($data['is_required']) ? (int)$data['is_required'] : 0,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'sort_order' => isset($data['sort_order']) ? (int)$data['sort_order'] : 0,
            'page' => isset($data['page']) ? trim(strip_tags($data['page'])) : '',
        ];

        // Get current user ID for tracking
        $currentUserId = $this->getCurrentUserId();
        
        // Set tracking fields
        if ($currentUserId) {
            if (!isset($data['id'])) {
                // For new records, set created_by
                $sanitized['created_by'] = $currentUserId;
            }
            // Always set updated_by for both create and update operations
            $sanitized['updated_by'] = $currentUserId;
        }

        return $sanitized;
    }

    /**
     * Log question operations to the logs table
     */
    private function logQuestionOperation(string $action, array $questionData, int $questionId = null): void
    {
        try {
            $questionNumber = $questionId ?? ($questionData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Question Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Question Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Question Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Question ' . ucfirst($action);
                    break;
            }
            
            // Create structured action description
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $questionNumber . "\n";
            $actionDescription .= "Label: " . ($questionData['label'] ?? 'Unknown') . "\n";
            $actionDescription .= "Type: " . ($questionData['type'] ?? 'N/A') . "\n";
            $actionDescription .= "Page: " . ($questionData['page'] ?? 'N/A') . "\n";
            $actionDescription .= "Required: " . (($questionData['is_required'] ?? 0) ? 'Yes' : 'No') . "\n";
            $actionDescription .= "Active: " . (($questionData['is_active'] ?? 0) ? 'Yes' : 'No') . "\n";
            $actionDescription .= "Sort Order: " . ($questionData['sort_order'] ?? '0') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($questionData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId,
                'module_id' => 6, // Assuming module ID 6 for questions (adjust as needed)
                'action' => $actionDescription,
            ];
            
            $result = $this->logModel->insert($logData);
            
            if ($result) {
                log_message('info', 'Successfully inserted question log with ID: ' . $result);
            } else {
                $errors = $this->logModel->errors();
                log_message('error', 'Failed to insert question log. Errors: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            log_message('error', 'Failed to log question operation: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of questions
     */
    public function index()
    {
        // Check permissions (temporarily disabled like in status)
        // if (!has_permission('questions.view')) {
        //     return redirect()->to('/')->with('error', 'You do not have permission to view questions.');
        // }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $questions = $this->questionModel->getQuestionsWithPagination($search, $limit, $offset);
        $totalQuestions = $this->questionModel->getQuestionsCount($search);
        $totalPages = ceil($totalQuestions / $limit);

        // Get question types for dropdown
        $questionTypes = $this->questionModel->getQuestionTypes();

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => true, // Temporarily allow all (adjust based on your permission system)
            'canEdit' => true,
            'canView' => true,
            'canDelete' => true
        ];

        $data = [
            'title' => 'Questions Management',
            'questions' => $questions,
            'questionTypes' => $questionTypes,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalQuestions' => $totalQuestions,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('questions/index', $data);
    }

    /**
     * Store a newly created question in database
     */
    public function store()
    {
        log_message('info', 'Question store called. Method: ' . $this->request->getMethod());
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Check permissions
        // if (!has_permission('questions.create')) {
        //     if ($this->request->isAJAX()) {
        //         return $this->response->setJSON([
        //             'success' => false,
        //             'message' => 'You do not have permission to create questions.'
        //         ]);
        //     }
        //     return redirect()->back()->with('error', 'You do not have permission to create questions.');
        // }

        // Prepare data for validation
        $rawData = $this->request->getPost();
        $data = $this->sanitizeQuestionInput($rawData);
        
        log_message('info', 'Raw POST data: ' . json_encode($rawData));
        log_message('info', 'Sanitized question data: ' . json_encode($data));

        // Validate using type-specific rules
        $validationErrors = $this->questionModel->validateForType($data);
        
        // Get options data for MCQ questions
        $options = $this->request->getPost('options') ?? [];
        $questionType = $data['type'] ?? '';
        
        // Validate options for MCQ questions
        if (in_array($questionType, ['single_mcq', 'multi_mcq'])) {
            $optionErrors = $this->questionOptionModel->validateOptionsForQuestionType($questionType, $options);
            if (!empty($optionErrors)) {
                $validationErrors['options'] = implode(', ', $optionErrors);
            }
        }

        if (!empty($validationErrors)) {
            log_message('error', 'Question validation failed: ' . json_encode($validationErrors));
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $validationErrors,
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validationErrors);
        }

        // Insert the question
        if ($questionId = $this->questionModel->insert($data)) {
            log_message('info', 'Question created successfully with ID: ' . $questionId);
            
            // Save options for MCQ questions
            if (in_array($questionType, ['single_mcq', 'multi_mcq']) && !empty($options)) {
                $optionsSaved = $this->questionOptionModel->saveOptionsForQuestion($questionId, $options);
                if (!$optionsSaved) {
                    log_message('error', 'Failed to save question options for question ID: ' . $questionId);
                    // Delete the question since options failed to save
                    $this->questionModel->delete($questionId);
                    
                    if ($this->request->isAJAX()) {
                        return $this->response->setJSON([
                            'success' => false,
                            'message' => 'Failed to save question options. Please try again.'
                        ]);
                    }
                    return redirect()->back()
                                   ->withInput()
                                   ->with('error', 'Failed to save question options. Please try again.');
                }
            }
            
            // Get the full question data for logging
            $questionData = $this->questionModel->getQuestion($questionId);
            
            // Log the create operation
            $this->logQuestionOperation('create', $questionData, $questionId);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Question created successfully!'
                ]);
            }
            return redirect()->to('/questions')
                           ->with('success', 'Question created successfully!');
        } else {
            log_message('error', 'Failed to create question. Model errors: ' . json_encode($this->questionModel->errors()));
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create question. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create question. Please try again.');
        }
    }

    /**
     * Display the specified question (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check permissions
        // if (!has_permission('questions.view')) {
        //     return $this->response->setStatusCode(403)->setJSON([
        //         'success' => false,
        //         'message' => 'You do not have permission to view questions.'
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
                'message' => 'Question ID is required.'
            ]);
        }

        $question = $this->questionModel->getQuestion($id);

        if (!$question) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Question not found.'
            ]);
        }

        // Get options for MCQ questions
        $options = [];
        if (in_array($question['type'], ['single_mcq', 'multi_mcq'])) {
            $options = $this->questionOptionModel->getOptionsByQuestionId($id);
        }

        return $this->response->setJSON([
            'success' => true,
            'question' => $question,
            'options' => $options
        ]);
    }

    /**
     * Update the specified question in database
     */
    public function update($id = null)
    {
        // Check permissions
        // if (!has_permission('questions.edit')) {
        //     if ($this->request->isAJAX()) {
        //         return $this->response->setJSON([
        //             'success' => false,
        //             'message' => 'You do not have permission to edit questions.'
        //         ]);
        //     }
        //     return redirect()->back()->with('error', 'You do not have permission to edit questions.');
        // }

        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Question ID is required.'
                ]);
            }
            return redirect()->to('/questions')
                           ->with('error', 'Question ID is required.');
        }

        $question = $this->questionModel->getQuestion($id);

        if (!$question) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Question not found.'
                ]);
            }
            return redirect()->to('/questions')
                           ->with('error', 'Question not found.');
        }

        // Sanitize and validate the input
        $rawData = $this->request->getPost();
        $inputData = $this->sanitizeQuestionInput($rawData);
        
        log_message('info', 'Raw POST data for update: ' . json_encode($rawData));
        log_message('info', 'Sanitized question update data: ' . json_encode($inputData));
        
        // Validate using type-specific rules
        $validationErrors = $this->questionModel->validateForType($inputData);
        
        // Get options data for MCQ questions
        $options = $this->request->getPost('options') ?? [];
        $questionType = $inputData['type'] ?? '';
        
        // Validate options for MCQ questions
        if (in_array($questionType, ['single_mcq', 'multi_mcq'])) {
            $optionErrors = $this->questionOptionModel->validateOptionsForQuestionType($questionType, $options);
            if (!empty($optionErrors)) {
                $validationErrors['options'] = implode(', ', $optionErrors);
            }
        }
        
        if (!empty($validationErrors)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'errors' => $validationErrors,
                    'message' => 'Validation failed.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('errors', $validationErrors);
        }

        // Update the question
        try {
            $this->questionModel->skipValidation(true);
            $result = $this->questionModel->update($id, $inputData);
            $this->questionModel->skipValidation(false);
            
            if ($result) {
                // Save options for MCQ questions
                if (in_array($questionType, ['single_mcq', 'multi_mcq'])) {
                    $optionsSaved = $this->questionOptionModel->saveOptionsForQuestion($id, $options);
                    if (!$optionsSaved) {
                        log_message('error', 'Failed to update question options for question ID: ' . $id);
                        if ($this->request->isAJAX()) {
                            return $this->response->setJSON([
                                'success' => false,
                                'message' => 'Question updated but failed to save options. Please edit again.'
                            ]);
                        }
                        return redirect()->back()
                                       ->withInput()
                                       ->with('error', 'Question updated but failed to save options. Please edit again.');
                    }
                } else {
                    // If question type changed from MCQ to non-MCQ, delete existing options
                    $this->questionOptionModel->deleteOptionsByQuestionId($id);
                }
                
                // Get the updated question data for logging
                $updatedQuestion = $this->questionModel->getQuestion($id);
                
                // Log the update operation
                $this->logQuestionOperation('update', $updatedQuestion, $id);
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Question updated successfully!'
                    ]);
                }
                return redirect()->to('/questions')
                               ->with('success', 'Question updated successfully!');
            } else {
                $errors = $this->questionModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update question: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update question: ' . $errorMessage);
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
     * Remove the specified question from database
     */
    public function delete($id = null)
    {
        // Check permissions
        // if (!has_permission('questions.delete')) {
        //     return $this->response->setJSON([
        //         'success' => false,
        //         'message' => 'You do not have permission to delete questions.'
        //     ]);
        // }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Question ID is required.'
            ]);
        }

        $question = $this->questionModel->getQuestion($id);

        if (!$question) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Question not found.'
            ]);
        }

        // Delete the question
        if ($this->questionModel->delete($id)) {
            // Log the delete operation
            $this->logQuestionOperation('delete', $question, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Question deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete question. Please try again.'
            ]);
        }
    }

    /**
     * Get questions for AJAX requests
     */
    public function getQuestions()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $questions = $this->questionModel->getQuestionsWithPagination($search, $limit, $offset);
        $totalQuestions = $this->questionModel->getQuestionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $questions,
            'total' => $totalQuestions
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

        $questions = $this->questionModel->getQuestionsWithPagination($search, $limit, $offset);
        $totalQuestions = $this->questionModel->getQuestionsCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $questions,
            'total' => $totalQuestions,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalQuestions
        ]);
    }
}