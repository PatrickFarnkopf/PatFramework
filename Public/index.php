<?php

session_start();

require_once '../Config/App.php';

function __autoload($namespace)
{
    $path = '../' . str_replace("\\", DIRECTORY_SEPARATOR, $namespace) . '.php';

    if (file_exists($path))
        require_once $path;
}

echo \Framework\Kernel::instance()->start();
