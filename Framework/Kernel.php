<?php

namespace Framework;


use Framework\Application\ControllerHandler;
use Framework\Application\Exception;
use Framework\Http\Request;
use Framework\Http\Session;

class Kernel
{
    private $applicationRoot;

    private function __construct()
    { }

    public function start($root = false)
    {
        if ($root === false)
        {
            $this->applicationRoot = $_SERVER['DOCUMENT_ROOT'];
        }
        else
        {
            $this->applicationRoot = $root;
        }

        $request = new Request();
        $request->setGet($_GET);
        $request->setPost($_POST);
        $request->setSession(new Session($_SESSION));
        $request->setUri('http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}");

        $controller = ControllerHandler::instance()->create($request);
        $result = $controller->executeAction();

        switch (gettype($result))
        {
            case "string":
            case "integer":
            case "boolean":
            case "double":
                return $result;
            case "object":
                throw new Exception("not supported");
            default:
                throw new Exception("not supported");
        }
    }

    public function getApplicationRoot()
    {
        return $this->applicationRoot;
    }

    private static $instance;

    /**
     * @return Kernel
     */
    public static function instance()
    {
        if (Kernel::$instance == null)
        {
            Kernel::$instance = new Kernel();
        }

        return Kernel::$instance;
    }
}
