<?php

namespace App\Controllers;

use Framework\Application\BaseController;

class TestController extends BaseController
{
    public function index()
    {
        return $this->view("Test");
    }

    public function test()
    {
        return "test";
    }
}