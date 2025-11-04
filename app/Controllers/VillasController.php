<?php

namespace App\Controllers;

use App\Models\VillaModel;
use CodeIgniter\HTTP\RedirectResponse;

class VillasController extends BaseController
{
    protected $villaModel;
    protected $villaImageModel;
    protected $logModel;

    public function __construct()
    {
        $this->villaModel = new VillaModel();
        $this->villaImageModel = new \App\Models\VillaImageModel();
        $this->logModel = new \App\Models\LogModel();
    }

    /**
     * Sanitize input data for villa
     */
    private function sanitizeVillaInput(array $data): array
    {
        $sanitized = [
            'villa_name' => isset($data['villa_name']) ? trim(strip_tags($data['villa_name'])) : '',
            'villa_code' => isset($data['villa_code']) ? trim(strip_tags($data['villa_code'])) : '',
            'capacity' => isset($data['capacity']) ? (int)$data['capacity'] : 0,
            'description' => isset($data['description']) ? 
                trim(strip_tags($data['description'], '<p><br><strong><em><ul><ol><li>')) : '',
        ];

        // Add audit fields if present (these don't need sanitization as they're system-generated)
        if (isset($data['created_by'])) {
            $sanitized['created_by'] = (int)$data['created_by'];
        }
        if (isset($data['created_at'])) {
            $sanitized['created_at'] = $data['created_at'];
        }
        if (isset($data['updated_by'])) {
            $sanitized['updated_by'] = (int)$data['updated_by'];
        }
        if (isset($data['updated_at'])) {
            $sanitized['updated_at'] = $data['updated_at'];
        }

        return $sanitized;
    }

    /**
     * Log villa operations to the logs table
     */
    private function logVillaOperation(string $action, array $villaData, int $villaId = null): void
    {
        try {
            log_message('info', 'logVillaOperation called with action: ' . $action . ', villaId: ' . $villaId);
            
            $villaNumber = $villaId ?? ($villaData['id'] ?? 0);
            
            // Map actions to status IDs for logs
            $logStatusId = 1; // Default to active
            switch (strtolower($action)) {
                case 'created':
                case 'create':
                    $logStatusId = 3; // Success status for create
                    $actionPrefix = 'Villa Created';
                    break;
                case 'updated':
                case 'update':
                    $logStatusId = 4; // Success status for update
                    $actionPrefix = 'Villa Updated';
                    break;
                case 'deleted':
                case 'delete':
                    $logStatusId = 5; // Warning status for delete
                    $actionPrefix = 'Villa Deleted';
                    break;
                default:
                    $logStatusId = 1; // Default for other actions
                    $actionPrefix = 'Villa ' . ucfirst($action);
                    break;
            }
            
            log_message('info', 'Mapped status ID: ' . $logStatusId . ' for action: ' . $action);
            
            // Create structured action description in the requested format
            $actionDescription = $actionPrefix . "\n";
            $actionDescription .= "#: " . $villaNumber . "\n";
            $actionDescription .= "Villa Name: " . ($villaData['villa_name'] ?? 'Unknown') . "\n";
            $actionDescription .= "Villa Code: " . ($villaData['villa_code'] ?? 'Unknown') . "\n";
            $actionDescription .= "Capacity: " . ($villaData['capacity'] ?? 'Unknown') . "\n";
            $actionDescription .= "Description:\n";
            $actionDescription .= ($villaData['description'] ?? 'No description provided');

            $logData = [
                'status_id' => $logStatusId, // Use mapped status ID based on action
                'module_id' => 21, // Villas module ID (from modules table)
                'action' => $actionDescription, // Structured action text with details
            ];

            log_message('info', 'Attempting to insert log data: ' . json_encode($logData));
            
            $result = $this->logModel->insert($logData);
            
            if ($result) {
                log_message('info', 'Successfully inserted log with ID: ' . $result);
            } else {
                $errors = $this->logModel->errors();
                log_message('error', 'Failed to insert log. Errors: ' . json_encode($errors));
            }
        } catch (\Exception $e) {
            // Log the error but don't break the main operation
            log_message('error', 'Failed to log villa operation: ' . $e->getMessage());
            log_message('error', 'Exception trace: ' . $e->getTraceAsString());
        }
    }

    /**
     * Handle multiple image uploads for a villa
     */
    private function handleImageUploads(int $villaId, array $files): array
    {
        $uploadedImages = [];
        $errors = [];
        
        log_message('info', 'handleImageUploads called with villa ID: ' . $villaId . ', files count: ' . count($files));
        
        // Create upload directory if it doesn't exist
        $uploadPath = FCPATH . 'assets/media/villas/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
            log_message('info', 'Created upload directory: ' . $uploadPath);
        }
        
        // Process each uploaded file
        foreach ($files as $index => $file) {
            log_message('info', 'Processing file ' . ($index + 1) . ': ' . $file->getClientName() . ', isValid: ' . ($file->isValid() ? 'true' : 'false'));
            
            if (!$file->isValid()) {
                $error = "File " . ($index + 1) . ": " . $file->getErrorString();
                $errors[] = $error;
                log_message('error', 'File validation failed: ' . $error);
                continue;
            }
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $mimeType = $file->getMimeType();
            log_message('info', 'File mime type: ' . $mimeType);
            
            if (!in_array($mimeType, $allowedTypes)) {
                $error = "File " . ($index + 1) . ": Invalid file type. Only JPEG, PNG, GIF, and WebP images are allowed.";
                $errors[] = $error;
                log_message('error', 'Invalid file type: ' . $error);
                continue;
            }
            
            // Validate file size (max 5MB)
            $maxSize = 5 * 1024 * 1024; // 5MB in bytes
            $fileSize = $file->getSize();
            log_message('info', 'File size: ' . $fileSize . ' bytes');
            
            if ($fileSize > $maxSize) {
                $error = "File " . ($index + 1) . ": File size too large. Maximum 5MB allowed.";
                $errors[] = $error;
                log_message('error', 'File too large: ' . $error);
                continue;
            }
            
            // Generate unique filename
            $originalName = $file->getClientName();
            $extension = $file->getClientExtension();
            $newName = 'villa_' . $villaId . '_' . time() . '_' . uniqid() . '.' . $extension;
            
            try {
                // Move file to upload directory
                log_message('info', 'Attempting to move file: ' . $newName . ' to: ' . $uploadPath);
                
                if ($file->move($uploadPath, $newName)) {
                    log_message('info', 'File moved successfully: ' . $newName);
                    
                    // Save to database
                    $imageData = [
                        'villa_id' => $villaId,
                        'image_path' => $newName,
                        'image_name' => $originalName,
                        'alt_text' => 'Villa image',
                        'display_order' => $index,
                        'is_primary' => ($index === 0) ? 1 : 0, // First image is primary
                        'file_size' => $fileSize,
                        'mime_type' => $mimeType,
                        'created_by' => user_id(),
                        'created_at' => date('Y-m-d H:i:s')
                    ];
                    
                    log_message('info', 'Attempting to insert image data: ' . json_encode($imageData));
                    
                    if ($imageId = $this->villaImageModel->insert($imageData)) {
                        log_message('info', 'Image saved to database with ID: ' . $imageId);
                        $uploadedImages[] = [
                            'id' => $imageId,
                            'path' => $newName,
                            'name' => $originalName,
                            'is_primary' => $imageData['is_primary']
                        ];
                    } else {
                        // If database insert fails, remove the uploaded file
                        unlink($uploadPath . $newName);
                        $error = "File " . ($index + 1) . ": Failed to save image information.";
                        $errors[] = $error;
                        log_message('error', 'Database insert failed: ' . $error);
                        log_message('error', 'VillaImageModel errors: ' . json_encode($this->villaImageModel->errors()));
                    }
                } else {
                    $error = "File " . ($index + 1) . ": Failed to upload file.";
                    $errors[] = $error;
                    log_message('error', 'File move failed: ' . $error);
                }
            } catch (\Exception $e) {
                $error = "File " . ($index + 1) . ": " . $e->getMessage();
                $errors[] = $error;
                log_message('error', 'Exception during file upload: ' . $error);
            }
        }
        
        log_message('info', 'handleImageUploads completed. Uploaded: ' . count($uploadedImages) . ', Errors: ' . count($errors));
        
        return [
            'uploaded' => $uploadedImages,
            'errors' => $errors
        ];
    }

    /**
     * Delete a specific villa image
     */
    public function deleteImage($imageId = null)
    {
        // Check if user has permission to edit villas
        if (!has_permission('villas.edit')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete villa images.'
            ]);
        }

        if (!$imageId) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Image ID is required.'
            ]);
        }

        // Get image details
        $image = $this->villaImageModel->find($imageId);
        if (!$image) {
            return $this->response->setStatusCode(404)->setJSON([
                'success' => false,
                'message' => 'Image not found.'
            ]);
        }

        // Delete the image
        if ($this->villaImageModel->deleteImageWithFile($imageId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Image deleted successfully.'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to delete image.'
            ]);
        }
    }

    /**
     * Set primary image for a villa
     */
    public function setPrimaryImage()
    {
        // Check if user has permission to edit villas
        if (!has_permission('villas.edit')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to modify villa images.'
            ]);
        }

        $villaId = $this->request->getPost('villa_id');
        $imageId = $this->request->getPost('image_id');

        if (!$villaId || !$imageId) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'Villa ID and Image ID are required.'
            ]);
        }

        if ($this->villaImageModel->setPrimaryImage($villaId, $imageId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Primary image updated successfully.'
            ]);
        } else {
            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Failed to update primary image.'
            ]);
        }
    }

    /**
     * Display a listing of villas
     */
    public function index()
    {
        // Check if user has permission to view villas
        if (!has_permission('villas.view')) {
            return redirect()->to('/')->with('error', 'You do not have permission to view villas.');
        }

        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $page = (int)($this->request->getGet('page') ?? 1);
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $villas = $this->villaModel->getVillasWithPagination($search, $limit, $offset);
        $totalVillas = $this->villaModel->getVillasCount($search);
        $totalPages = ceil($totalVillas / $limit);

        // Check user permissions for buttons
        $permissions = [
            'canCreate' => has_permission('villas.create'),
            'canEdit' => has_permission('villas.edit'),
            'canView' => has_permission('villas.view'),
            'canDelete' => has_permission('villas.delete')
        ];

        $data = [
            'title' => 'Villa Management',
            'villas' => $villas,
            'search' => $search,
            'currentPage' => $page,
            'totalPages' => $totalPages,
            'totalVillas' => $totalVillas,
            'limit' => $limit,
            'permissions' => $permissions
        ];

        return view('villas/index', $data);
    }

    /**
     * Store a newly created villa in database
     */
    public function store()
    {
        // Check if user has permission to create villas
        if (!has_permission('villas.create')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to create villas.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to create villas.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Villa store called. POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Files: ' . json_encode(array_keys($this->request->getFiles())));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        // Get form data
        $postData = [
            'villa_name' => $this->request->getPost('villa_name'),
            'villa_code' => $this->request->getPost('villa_code'),
            'capacity' => $this->request->getPost('capacity'),
            'description' => $this->request->getPost('description')
        ];
        
        log_message('info', 'Parsed POST data: ' . json_encode($postData));
        
        // Validate the input using the parsed data
        if (!$this->validate($this->villaModel->getValidationRules(), $postData)) {
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
        $data = $this->sanitizeVillaInput($postData);

        // Insert the villa
        if ($villaId = $this->villaModel->insert($data)) {
            // Handle image uploads if any
            $imageResults = ['uploaded' => [], 'errors' => []];
            $uploadedFiles = $this->request->getFiles();
            
            log_message('info', 'All uploaded files: ' . json_encode(array_keys($uploadedFiles)));
            
            if (isset($uploadedFiles['villa_images'])) {
                log_message('info', 'villa_images found, type: ' . gettype($uploadedFiles['villa_images']) . ', count: ' . (is_array($uploadedFiles['villa_images']) ? count($uploadedFiles['villa_images']) : 'not array'));
                
                // Check if it's a valid file array with actual files
                $validFiles = [];
                if (is_array($uploadedFiles['villa_images'])) {
                    foreach ($uploadedFiles['villa_images'] as $index => $file) {
                        if ($file && $file->getName() !== '') {
                            $validFiles[] = $file;
                            log_message('info', 'Valid file ' . $index . ': ' . $file->getName() . ', size: ' . $file->getSize());
                        } else {
                            log_message('info', 'Empty file at index ' . $index);
                        }
                    }
                } else {
                    // Single file case
                    if ($uploadedFiles['villa_images']->getName() !== '') {
                        $validFiles[] = $uploadedFiles['villa_images'];
                        log_message('info', 'Single valid file: ' . $uploadedFiles['villa_images']->getName());
                    }
                }
                
                if (!empty($validFiles)) {
                    $imageResults = $this->handleImageUploads($villaId, $validFiles);
                } else {
                    log_message('info', 'No valid files to upload');
                }
            } else {
                log_message('info', 'No villa_images in uploaded files');
            }
            
            // Get the full villa data for logging
            $villaData = $this->villaModel->getVilla($villaId);
            
            // Log the create operation
            $this->logVillaOperation('create', $villaData, $villaId);
            
            // Prepare response message
            $message = 'Villa created successfully!';
            if (!empty($imageResults['uploaded'])) {
                $message .= ' ' . count($imageResults['uploaded']) . ' image(s) uploaded.';
            }
            if (!empty($imageResults['errors'])) {
                $message .= ' However, some images failed to upload: ' . implode(', ', $imageResults['errors']);
            }
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => $message,
                    'villa_id' => $villaId,
                    'images' => $imageResults
                ]);
            }
            return redirect()->to('/villas')
                           ->with('success', $message);
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to create villa. Please try again.'
                ]);
            }
            return redirect()->back()
                           ->withInput()
                           ->with('error', 'Failed to create villa. Please try again.');
        }
    }

    /**
     * Display the specified villa (AJAX only for modals)
     */
    public function show($id = null)
    {
        // Check if user has permission to view villas
        if (!has_permission('villas.view')) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'You do not have permission to view villas.'
            ]);
        }

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
                'message' => 'Villa ID is required.'
            ]);
        }

        $villa = $this->villaModel->getVillaWithImages($id);

        if (!$villa) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Villa not found.'
            ]);
        }

        return $this->response->setJSON([
            'success' => true,
            'data' => $villa
        ]);
    }

    /**
     * Update the specified villa in database
     */
    public function update($id = null)
    {
        // Check if user has permission to edit villas
        if (!has_permission('villas.edit')) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You do not have permission to edit villas.'
                ]);
            }
            return redirect()->back()->with('error', 'You do not have permission to edit villas.');
        }

        // Debug: Log the incoming request
        log_message('info', 'Villa update called for ID: ' . $id);
        log_message('info', 'Request method: ' . $this->request->getMethod());
        log_message('info', 'POST data: ' . json_encode($this->request->getPost()));
        log_message('info', 'Files: ' . json_encode(array_keys($this->request->getFiles())));
        log_message('info', 'Content Type: ' . $this->request->getHeaderLine('Content-Type'));
        log_message('info', 'Is AJAX: ' . ($this->request->isAJAX() ? 'yes' : 'no'));
        
        if ($id === null) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Villa ID is required.'
                ]);
            }
            return redirect()->to('/villas')
                           ->with('error', 'Villa ID is required.');
        }

        $villa = $this->villaModel->getVilla($id);

        if (!$villa) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Villa not found.'
                ]);
            }
            return redirect()->to('/villas')
                           ->with('error', 'Villa not found.');
        }

        // Get form data explicitly from POST
        $rawData = [
            'villa_name' => $this->request->getPost('villa_name'),
            'villa_code' => $this->request->getPost('villa_code'),
            'capacity' => $this->request->getPost('capacity'),
            'description' => $this->request->getPost('description')
        ];
        
        log_message('info', 'Parsed update data: ' . json_encode($rawData));

        // Sanitize and validate the input using model's custom validation for updates
        $inputData = $this->sanitizeVillaInput($rawData);
        
        $validationResult = $this->villaModel->validateForUpdate($inputData, $id);
        
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

        // Prepare data for update
        $data = $inputData;

        // Update the villa
        try {
            // Skip model validation since we already validated
            $this->villaModel->skipValidation(true);
            $result = $this->villaModel->update($id, $data);
            $this->villaModel->skipValidation(false); // Reset validation
            
            if ($result) {
                // Handle new image uploads if any
                $imageResults = ['uploaded' => [], 'errors' => []];
                $uploadedFiles = $this->request->getFiles();
                
                log_message('info', 'Update - All uploaded files: ' . json_encode(array_keys($uploadedFiles)));
                
                if (isset($uploadedFiles['villa_images'])) {
                    log_message('info', 'Update - villa_images found, type: ' . gettype($uploadedFiles['villa_images']) . ', count: ' . (is_array($uploadedFiles['villa_images']) ? count($uploadedFiles['villa_images']) : 'not array'));
                    
                    // Check if it's a valid file array with actual files
                    $validFiles = [];
                    if (is_array($uploadedFiles['villa_images'])) {
                        foreach ($uploadedFiles['villa_images'] as $index => $file) {
                            if ($file && $file->getName() !== '') {
                                $validFiles[] = $file;
                                log_message('info', 'Update - Valid file ' . $index . ': ' . $file->getName() . ', size: ' . $file->getSize());
                            } else {
                                log_message('info', 'Update - Empty file at index ' . $index);
                            }
                        }
                    } else {
                        // Single file case
                        if ($uploadedFiles['villa_images']->getName() !== '') {
                            $validFiles[] = $uploadedFiles['villa_images'];
                            log_message('info', 'Update - Single valid file: ' . $uploadedFiles['villa_images']->getName());
                        }
                    }
                    
                    if (!empty($validFiles)) {
                        $imageResults = $this->handleImageUploads($id, $validFiles);
                    } else {
                        log_message('info', 'Update - No valid files to upload');
                    }
                } else {
                    log_message('info', 'Update - No villa_images in uploaded files');
                }
                
                // Get the updated villa data for logging
                $updatedVilla = $this->villaModel->getVilla($id);
                
                // Log the update operation
                $this->logVillaOperation('update', $updatedVilla, $id);
                
                // Prepare response message
                $message = 'Villa updated successfully!';
                if (!empty($imageResults['uploaded'])) {
                    $message .= ' ' . count($imageResults['uploaded']) . ' new image(s) uploaded.';
                }
                if (!empty($imageResults['errors'])) {
                    $message .= ' However, some images failed to upload: ' . implode(', ', $imageResults['errors']);
                }
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => $message,
                        'images' => $imageResults
                    ]);
                }
                return redirect()->to('/villas')
                               ->with('success', $message);
            } else {
                // Get model errors if any
                $errors = $this->villaModel->errors();
                $errorMessage = !empty($errors) ? implode(', ', $errors) : 'Unknown database error occurred.';
                
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update villa: ' . $errorMessage
                    ]);
                }
                return redirect()->back()
                               ->withInput()
                               ->with('error', 'Failed to update villa: ' . $errorMessage);
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
     * Remove the specified villa from database
     */
    public function delete($id = null)
    {
        // Check if user has permission to delete villas
        if (!has_permission('villas.delete')) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You do not have permission to delete villas.'
            ]);
        }

        if ($id === null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Villa ID is required.'
            ]);
        }

        $villa = $this->villaModel->getVilla($id);

        if (!$villa) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Villa not found.'
            ]);
        }

        // Delete the villa
        if ($this->villaModel->delete($id)) {
            // Log the delete operation
            $this->logVillaOperation('delete', $villa, $id);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Villa deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to delete villa. Please try again.'
            ]);
        }
    }

    /**
     * Get villas for AJAX requests
     */
    public function getVillas()
    {
        $search = trim(strip_tags($this->request->getGet('search') ?? ''));
        $limit = (int)($this->request->getGet('limit') ?? 10);
        $offset = (int)($this->request->getGet('offset') ?? 0);

        $villas = $this->villaModel->getVillasWithPagination($search, $limit, $offset);
        $totalVillas = $this->villaModel->getVillasCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $villas,
            'total' => $totalVillas
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

        $villas = $this->villaModel->getVillasWithPagination($search, $limit, $offset);
        $totalVillas = $this->villaModel->getVillasCount($search);

        return $this->response->setJSON([
            'success' => true,
            'data' => $villas,
            'total' => $totalVillas,
            'page' => $page,
            'limit' => $limit,
            'hasMore' => ($offset + $limit) < $totalVillas
        ]);
    }
}