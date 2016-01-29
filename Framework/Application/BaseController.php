<?php

namespace Framework\Application;


use Framework\Http\Request;

abstract class BaseController
{
    /**
     * @var Request
     */
    protected $request;

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function executeAction()
    {
        $action = $this->request->getGet()["action"];
        return $this->$action();
    }
}