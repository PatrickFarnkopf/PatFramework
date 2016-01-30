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

    public function view($templateName)
    {
        $template = new Template();
        $template->setFile(Kernel::instance()->getApplicationRoot() . "/../App/Views/" . $templateName . ".phtml");
        return new ActionResult($template);
    }
}