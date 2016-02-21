<?php

namespace Framework\Application;

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

    public static function findRoutesByName($routeName)
    {
        $routes = [];

        foreach (self::$routes as $route)
        {
            if ($route->routeName == $routeName)
            {
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
