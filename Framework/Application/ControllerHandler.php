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
        $route = Route::findRoute($request->getRoutePart(), $request->getRequestType() == 'GET' ? Route::METHOD_GET : Route::METHOD_POST);
        if ($route == null)
            $route = Route::getDefault();
        
        $controllerName = "\\App\\Controllers\\" . $route->getControllerName();
        $obj = new $controllerName();
        $obj->setRequest($request);
        $obj->setRoute($route);

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