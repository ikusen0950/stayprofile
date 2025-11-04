<?php

namespace App\Models;

use CodeIgniter\Model;

class PreferenceModel extends Model
{
    protected $table = 'preferences';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'guest_id',
        'question_id',
        'answer_text',
        'answer_values_json',
        'followup_text'
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $validationRules = [
        'guest_id' => 'required|integer',
        'question_id' => 'required|integer'
    ];

    protected $validationMessages = [
        'guest_id' => [
            'required' => 'Guest ID is required',
            'integer' => 'Guest ID must be an integer'
        ],
        'question_id' => [
            'required' => 'Question ID is required',
            'integer' => 'Question ID must be an integer'
        ]
    ];

    /**
     * Save preference data for a guest and question
     * This will either insert new preference or update existing one
     */
    public function savePreference($guestId, $questionId, $answerText = null, $answerValues = null, $followupText = null)
    {
        $data = [
            'guest_id' => $guestId,
            'question_id' => $questionId,
            'answer_text' => $answerText,
            'answer_values_json' => $answerValues ? json_encode($answerValues) : null,
            'followup_text' => $followupText
        ];

        // Check if preference already exists
        $existing = $this->where([
            'guest_id' => $guestId,
            'question_id' => $questionId
        ])->first();

        if ($existing) {
            // Update existing preference
            return $this->update($existing['id'], $data);
        } else {
            // Insert new preference
            return $this->insert($data);
        }
    }

    /**
     * Get all preferences for a specific guest
     */
    public function getGuestPreferences($guestId)
    {
        return $this->select('preferences.*, questions.label as question_label, questions.type as question_type')
                    ->join('questions', 'questions.id = preferences.question_id')
                    ->where('preferences.guest_id', $guestId)
                    ->findAll();
    }

    /**
     * Get preference for a specific guest and question
     */
    public function getGuestQuestionPreference($guestId, $questionId)
    {
        return $this->where([
            'guest_id' => $guestId,
            'question_id' => $questionId
        ])->first();
    }

    /**
     * Delete all preferences for a guest
     */
    public function deleteGuestPreferences($guestId)
    {
        return $this->where('guest_id', $guestId)->delete();
    }

    /**
     * Save multiple preferences at once for a guest
     */
    public function saveGuestPreferences($guestId, $preferences, $followups = [])
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            foreach ($preferences as $questionId => $answer) {
                $answerText = null;
                $answerValues = null;
                $followupText = null;

                // Determine answer format based on type
                if (is_array($answer)) {
                    // Multiple choice answers
                    $answerValues = $answer;
                } else {
                    // Single text answer
                    $answerText = $answer;
                }

                // Check for follow-up responses
                if (!empty($followups)) {
                    $followupData = [];
                    foreach ($followups as $followupKey => $followupValue) {
                        if (strpos($followupKey, $questionId . '_') === 0 && !empty($followupValue)) {
                            // Store the full key-value mapping instead of just values
                            $followupData[$followupKey] = $followupValue;
                        }
                    }
                    if (!empty($followupData)) {
                        // Store as JSON to preserve the key-value mapping
                        $followupText = json_encode($followupData);
                    }
                }

                // Save the preference
                $this->savePreference($guestId, $questionId, $answerText, $answerValues, $followupText);
            }

            $db->transComplete();
            return $db->transStatus();
        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Error saving guest preferences: ' . $e->getMessage());
            return false;
        }
    }
}