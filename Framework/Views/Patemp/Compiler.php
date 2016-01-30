<?php

namespace Framework\Views\Patemp;


class Compiler
{
    private function __construct()
    { }

    public function build(Template $template)
    {
        $buffer = $template->getContent();

        preg_match_all('/\{{(.*?)\}}/', $template->getContent(), $logic);

        foreach ($logic[1] as $key => $value)
        {
            $tmp = trim($value);
            $mustEcho = false;

            if (strpos($tmp, " ") === false && strpos($tmp, "--") === false && strpos($tmp, "++") === false && strpos($tmp, "=") === false && $tmp[0] === "$" )
                $mustEcho = true;

            $buffer = str_replace($logic[0][$key], ($mustEcho ? "<?=" : '<?php ') . $value . ' ?>', $buffer);
        }

        return $buffer;
    }

    private static $instance;

    /**
     * @return Compiler
     */
    public static function instance()
    {
        if (Compiler::$instance == null)
        {
            Compiler::$instance = new Compiler();
        }

        return Compiler::$instance;
    }
}