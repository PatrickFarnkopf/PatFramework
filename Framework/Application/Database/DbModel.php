<?php

namespace Framework\Application\Database;


abstract class DbModel
{
    protected $isNew = true;
    protected $tableMap = [];
    protected $keys = [];

    protected function __construct()
    {
        $this->loadMapping();
    }

    protected function map(DbProperty $property, $isPrimaryKey = false)
    {
        if (in_array($property, $this->tableMap))
        {
            throw new Exception("property already mapped");
        }

        $this->tableMap[] = $property;

        if ($isPrimaryKey)
        {
            $primaryKey = new DbPropertyKey(DbPropertyKey::PRIMARY);
            $primaryKey->add($property);
            $this->setKey($property->getDbPropertyName(), $primaryKey);
        }
    }

    protected function setKey($key, DbPropertyKey $propertyKey)
    {
        if (isset($this->keys[$key]))
        {
            throw new Exception("key already exists");
        }

        $this->keys[$key] = $propertyKey;
    }

    public function get(array $where)
    {
        $this->isNew = false;

        // Todo: do db stuff

        return $this;
    }

    public function delete()
    {
        $this->isNew = false;

        // Todo: do db stuff

        unset($this);
    }

    public function save()
    {
        if ($this->isNew)
        {
            // Todo: do insert
        }
        else
        {
            // Todo: do update
        }

        $this->isNew = false;
        return $this;
    }

    protected abstract function loadMapping();
}