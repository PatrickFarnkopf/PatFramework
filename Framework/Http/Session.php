<?php
/**
 * Created by PhpStorm.
 * User: patrick
 * Date: 29.01.16
 * Time: 22:26
 */

namespace Framework\Http;


use Framework\Utils\UnorderedMap;

class Session extends UnorderedMap
{
    public function __construct(array $session)
    {
        $this->data = $session;
    }
}
