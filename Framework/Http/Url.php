<?php 

namespace Framework\Http;

class Url
{
    public static function Content($path)
    {
        $path = str_replace("~", \Config\App\URL_PATH, $path);
        $path = str_replace("//", "/", $path);
        echo $path;
    }

    public static function Redirect($path)
    {
        $path = str_replace("~", \Config\App\URL_PATH, $path);
        $path = str_replace("//", "/", $path);
        header('Location: ' . \Config\App\URL . $path);
        exit;
    }
}