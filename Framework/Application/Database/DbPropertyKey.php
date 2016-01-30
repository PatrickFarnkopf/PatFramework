<?php

namespace Framework\Application\Database;


class DbPropertyKey
{
    const PRIMARY   = 1;
    const UNIQUE    = 2;

    protected $key = [];
    protected $keyType;

    public function __construct($type = self::PRIMARY)
    {
        $this->keyType = $type;
    }

    /**
     * @param DbProperty $property
     * @return DbPropertyKey
     * @throws Exception
     */
    public function add(DbProperty $property)
    {
        if (in_array($property, $this->key))
        {
            throw new Exception("key already exists");
        }

        $this->key[] = $property;
        return $this;
    }
}