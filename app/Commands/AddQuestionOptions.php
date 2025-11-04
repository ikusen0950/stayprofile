<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class AddQuestionOptions extends BaseCommand
{
    protected $group       = 'App';
    protected $name        = 'app:add-question-options';
    protected $description = 'Add sample options for MCQ questions';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        // Insert sample options for question 5 (MCQ question)
        $options = [
            ['question_id' => 5, 'label' => 'Option A', 'sort_order' => 1, 'is_active' => 1],
            ['question_id' => 5, 'label' => 'Option B', 'sort_order' => 2, 'is_active' => 1],
            ['question_id' => 5, 'label' => 'Option C', 'sort_order' => 3, 'is_active' => 1]
        ];

        foreach ($options as $option) {
            $option['created_at'] = date('Y-m-d H:i:s');
            $db->table('question_options')->insert($option);
        }

        CLI::write('Question options added successfully!', 'green');
    }
}