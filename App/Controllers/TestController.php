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
        $testObject = new \App\Models\Test();
        
        $dbObject = $testObject->get()->First();
        $dbObject->setTest("Neuer Wert");
        $dbObject->save();

        return "test";
    }
}