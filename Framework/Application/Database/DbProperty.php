<?php

namespace Framework\Application\Database;


class DbProperty
{
    const TYPE_VARCHAR   = 1;
    const TYPE_INT       = 2;
    const TYPE_TEXT      = 3;
    const TYPE_FLOAT     = 4;
    const TYPE_DATE      = 5;

    protected $modelPropertyName;
    protected $dbPropertyName;
    protected $dbPropertyType;

    public function __construct($modelName, $dbName, $dbType = self::TYPE_VARCHAR)
    {
        $this->modelPropertyName = $modelName;
        $this->dbPropertyName = $dbName;
        $this->dbPropertyType = $dbType;
    }

    public function getModelPropertyName()
    {
        return $this->modelPropertyName;
    }

    public function getDbPropertyName()
    {
        return $this->dbPropertyName;
    }

    public function getDbPropertyType()
    {
        return $this->dbPropertyType;
    }
}