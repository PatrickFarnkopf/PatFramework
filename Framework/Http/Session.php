<?php

namespace Framework\Http;

use Framework\Utils\UnorderedMap;

class Session extends UnorderedMap
{
    public function __construct(array $session)
    {
        $this->data = $session;
    }
}
