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
        $params = explode("/", explode(\Config\App\URL_PATH, $this->request->getUri())[1]);
        $action = $params[1];
        return $this->$action();
    }
}