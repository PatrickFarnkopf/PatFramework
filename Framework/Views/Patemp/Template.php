<?php

namespace Framework\Views\Patemp;


class Template
{
    private $file;

    public function setFile($f)
    {
        $this->file = $f;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function getContent()
    {
        return file_get_contents($this->file);
    }
}
