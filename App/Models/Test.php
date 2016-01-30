<?php

namespace App\Models;


use Framework\Application\Database\DbModel;
use Framework\Application\Database\DbProperty;

class Test extends DbModel
{
    private $id;
    private $test;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTest($test)
    {
        $this->test = $test;
    }

    public function getTest()
    {
        return $this->test;
    }

    protected function loadMapping()
    {
        $this->map(new DbProperty('id', 'id', DbProperty::TYPE_INT));
        $this->map(new DbProperty('test', 'test', DbProperty::TYPE_VARCHAR));
    }
}