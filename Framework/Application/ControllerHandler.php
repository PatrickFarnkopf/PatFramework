<?php

namespace Framework\Application;


use Framework\Http\Request;
use App\Controllers;

class ControllerHandler
{
    /**
     * @param Request $request
     * @return BaseController
     */
    public function create(Request $request)
    {
        $params = explode("/", explode(\Config\App\URL_PATH, $request->getUri())[1]);

        $controllerName = "\\App\\Controllers\\" . $params[0] . "Controller";
        $obj = new $controllerName();
        $obj->setRequest($request);
        return $obj;
    }

    private static $instance;

    /**
     * @return ControllerHandler
     */
    public static function instance()
    {
        if (ControllerHandler::$instance == null)
        {
            ControllerHandler::$instance = new ControllerHandler();
        }

        return ControllerHandler::$instance;
    }
}