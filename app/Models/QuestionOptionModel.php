<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionOptionModel extends Model
{
    protected $table = 'question_options';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'question_id',
        'label',
        'sort_order',
        'has_followup',
        'followup_label',
        'followup_placeholder',
        'followup_required'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validation
    protected $validationRules = [
        'question_id' => 'required|is_natural_no_zero',
        'label' => 'required|min_length[1]|max_length[255]',
        'sort_order' => 'permit_empty|is_natural',
        'has_followup' => 'permit_empty|in_list[0,1]',
        'followup_label' => 'permit_empty|max_length[255]',
        'followup_placeholder' => 'permit_empty|max_length[255]',
        'followup_required' => 'permit_empty|in_list[0,1]'
    ];

    protected $validationMessages = [
        'question_id' => [
            'required' => 'Question ID is required',
            'is_natural_no_zero' => 'Question ID must be a valid number'
        ],
        'label' => [
            'required' => 'Option label is required',
            'min_length' => 'Option label must be at least 1 character',
            'max_length' => 'Option label cannot exceed 255 characters'
        ],
        'sort_order' => [
            'is_natural' => 'Sort order must be a valid number'
        ]
    ];

    protected $skipValidation = false;

    /**
     * Get options for a specific question
     */
    public function getOptionsByQuestionId($questionId)
    {
        return $this->where('question_id', $questionId)
                   ->orderBy('sort_order', 'ASC')
                   ->orderBy('id', 'ASC')
                   ->findAll();
    }

    /**
     * Save multiple options for a question
     */
    public function saveOptionsForQuestion($questionId, $options)
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            // Delete existing options for this question
            $this->where('question_id', $questionId)->delete();

            // Insert new options
            if (!empty($options)) {
                foreach ($options as $index => $option) {
                    if (!empty($option['label'])) {
                        $optionData = [
                            'question_id' => $questionId,
                            'label' => trim($option['label']),
                            'sort_order' => $option['sort_order'] ?? ($index + 1),
                            'has_followup' => isset($option['has_followup']) && $option['has_followup'] == '1' ? 1 : 0,
                            'followup_label' => isset($option['followup_label']) ? trim($option['followup_label']) : null,
                            'followup_placeholder' => isset($option['followup_placeholder']) ? trim($option['followup_placeholder']) : null,
                            'followup_required' => isset($option['followup_required']) && $option['followup_required'] == '1' ? 1 : 0
                        ];
                        $this->insert($optionData);
                    }
                }
            }

            $db->transComplete();
            return $db->transStatus();

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Failed to save question options: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete options for a question
     */
    public function deleteOptionsByQuestionId($questionId)
    {
        return $this->where('question_id', $questionId)->delete();
    }

    /**
     * Get options count for a question
     */
    public function getOptionsCountByQuestionId($questionId)
    {
        return $this->where('question_id', $questionId)->countAllResults();
    }

    /**
     * Validate options based on question type
     */
    public function validateOptionsForQuestionType($questionType, $options = [])
    {
        $errors = [];

        switch ($questionType) {
            case 'single_mcq':
            case 'multi_mcq':
                // MCQ questions require at least 2 options
                $validOptions = array_filter($options, function($option) {
                    return !empty($option['label']);
                });
                
                if (count($validOptions) < 2) {
                    $errors[] = ucfirst(str_replace('_', ' ', $questionType)) . ' questions require at least 2 options';
                }
                break;

            case 'text':
            case 'textarea':
                // Text questions don't need options
                break;

            case 'text_block':
                // Text block questions don't need options
                break;

            default:
                $errors[] = 'Invalid question type';
                break;
        }

        return $errors;
    }
}