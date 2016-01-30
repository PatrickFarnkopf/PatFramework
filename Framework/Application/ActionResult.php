<?php

namespace Framework\Application;


use Framework\Views\Patemp\Compiler;
use Framework\Views\Patemp\Template;

class ActionResult
{
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function view()
    {
        return Compiler::instance()->build($this->template);
    }
}