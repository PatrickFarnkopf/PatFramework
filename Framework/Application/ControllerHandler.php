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
        $controllerName = "\\App\\Controllers\\" . $request->getGet()["controller"] . "Controller";
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