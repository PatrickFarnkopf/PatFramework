<?php

namespace Framework\Application;

use Framework\Http\Request;

class Route
{ 
    const METHOD_POST   = 0;
    const METHOD_GET    = 1;

    public static $routes;

    private $routeName;
    private $controllerName;
    private $action;
    private $method;
    private $isDefaultRoute;
    private $parameters = [];

    private function __construct($routeName, $controllerName, $action, $method) 
    {
        $this->routeName = $routeName;
        $this->controllerName = $controllerName;
        $this->action = $action;
        $this->method = $method;
        $this->isDefaultRoute = false;
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function defaultRoute()
    {
        $this->isDefaultRoute = true;
        return $this;
    }

    public function getAction()
    {
        return $this->action;
    }

    public static function getRouteParameters(Route $route, Request $request)
    {
        $requestRoute = explode("/", $request->getRoutePart());
        $defRoute = explode("/", $route->routeName);
        $parameterStore = [];

        for ($i = 0; $i < count($requestRoute); ++$i)
        {
            if ($defRoute[$i] == "{value}")
            {
                $parameterStore[] = $requestRoute[$i];
            }
        }

        return $parameterStore;
    }

    public static function findRoutesByName($routeName)
    {
        $routes = [];

        foreach (self::$routes as $route)
        {
            $isCompatible = false;
            $elements = explode("/", $route->routeName);
            $reqElements = explode("/", $routeName);

            if (count($elements) == count($reqElements))
            {
                for ($i = 0; $i < count($elements); ++$i)
                {
                    if ($elements[$i] == "{value}" || $elements[$i] == $reqElements[$i])
                    {
                        $isCompatible = true;
                    }
                    else
                    {
                        $isCompatible = false;
                        break;
                    }
                }

                if ($isCompatible)
                    $routes[] = $route;
            }
        }

        return $routes;
    }

    public static function findRoute($routeName, $method)
    {
        $routes = self::findRoutesByName($routeName);
        foreach ($routes as $route)
        {
            if ($route->method == $method)
            {
                return $route;
            }
        }

        return null;
    }

    public static function post($routeName, $controllerName, $action)
    {
        return self::create($routeName, $controllerName, $action, Route::METHOD_POST);
    }

    public static function get($routeName, $controllerName, $action)
    {
        return self::create($routeName, $controllerName, $action, Route::METHOD_GET);
    }

    private static function create($routeName, $controllerName, $action, $method)
    {
        $route = new Route($routeName, $controllerName, $action, $method);
        self::$routes[] = $route;
        return $route;
    }

    public static function getDefault()
    {
        foreach (self::$routes as $route)
        {
            if ($route->isDefaultRoute)
            {
                return $route;
            }
        }

        return null;
    }
}
