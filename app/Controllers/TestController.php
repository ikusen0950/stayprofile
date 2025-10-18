<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class TestController extends BaseController
{
    public function test()
    {
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Test controller works'
        ]);
    }
}