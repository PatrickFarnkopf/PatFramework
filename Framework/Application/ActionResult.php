<?php

namespace Framework\Application;


use Framework\Views\Patemp\Compiler;
use Framework\Views\Patemp\Template;

class ActionResult
{
    private $template;
    private $controller;

    public function __construct(Template $template, BaseController $controller)
    {
        $this->template = $template;
        $this->controller = $controller;
    }

    public function view()
    {
        return Compiler::instance()->build($this->template, $this->controller->viewData);
    }
}