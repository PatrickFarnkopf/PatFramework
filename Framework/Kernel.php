<?php

namespace Framework;


use Framework\Application\ControllerHandler;
use Framework\Application\Exception;
use Framework\Http\Request;
use Framework\Http\Session;
use Framework\Http\Url;

class Kernel
{
    private $applicationRoot;

    private function __construct()
    { }

    public function start($applicationRoot)
    {
        $this->applicationRoot = $applicationRoot;
        include $this->applicationRoot . "/../App/routes.php";

        $request = new Request();
        $request->setGet($_GET);
        $request->setPost($_POST);
        $request->setSession(new Session($_SESSION));
        $request->setUri($_SERVER["REQUEST_URI"]);
        $request->setRequestType($_SERVER['REQUEST_METHOD']);

        return $this->draw($request);
    }

    private function draw(Request $request)
    {
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
                switch (get_class($result))
                {
                    case "Framework\\Application\\ActionResult":
                        $viewData = $controller->viewData;
                        eval("?>" . $result->view());
                        return "";
                }
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
