<?php

namespace Framework\Application;


use Framework\Http\Request;
use Framework\Kernel;
use Framework\Views\Patemp\Template;

abstract class BaseController
{
    /**
     * @var Request
     */
    protected $request;

    protected $route;

    public $viewData = [];

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
        $action = $this->route->getAction();
        $parameters = Route::getRouteParameters($this->route, $this->request);
        return call_user_method_array($action, $this, $parameters);
    }

    public function view($templateName)
    {
        $template = new Template();
        $template->setFile(Kernel::instance()->getApplicationRoot() . "/../App/Views/" . $templateName . ".phtml");
        return new ActionResult($template, $this);
    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
    }
}