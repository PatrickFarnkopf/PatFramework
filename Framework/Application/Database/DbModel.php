<?php

namespace Framework\Application\Database;

abstract class DbModel
{
    protected $isNew = true;
    protected $tableMap = [];
    protected $keys = [];
    protected $tableName;

    public function __construct()
    {
        $this->tableName = $this->getClassName();
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

    public function get(array $where = [])
    {
        $this->isNew = false;
        $condition = DbModel::buildWhere($where);
        $query = "SELECT * FROM $this->tableName " . ($condition != null ? 'WHERE ' . $condition : "");

        $datastore = new DbModelStore();

        $itr = 0;
        $stmt = DbConnection::getDefault()->prepare($query);
        $stmt->execute();

        while ($row = $stmt->fetch(\PDO::FETCH_ASSOC))
        {
            $classname = get_class($this);
            $model = new $classname;

            foreach ($this->tableMap as $prop)
            {
                $setter = "set" . ucfirst($prop->getModelPropertyName());
                $model->$setter($row[$prop->getDbPropertyName()]);
            }

            $model->isNew = false;

            $datastore->Add($itr++, $model);
        }

        return $datastore;
    }

    public function delete()
    {
        $this->isNew = false;
        $query = "DELETE FROM $this->tableName WHERE ";
        $condition = [];

        foreach ($this->tableMap as $prop)
        {
            $getter = "get" . ucfirst($prop->getModelPropertyName());
            $condition[] = $prop->getDbPropertyName() . " = '" . $this->$getter() . "'";
        }

        $query .= implode(" AND ", $condition);
        $stmt = DbConnection::getDefault()->prepare($query);
        $stmt->execute();

        unset($this);
    }

    public function save()
    {
        $dbValues = [];
        $dbProps = [];

        foreach ($this->tableMap as $prop)
        {
            $getter = "get" . ucfirst($prop->getModelPropertyName());

            if ($prop->hasAutoIncrement() && $this->$getter() == null)
                $dbValues[] = "NULL";
            else
                $dbValues[] = "'" . $this->$getter() . "'";

            $dbProps[] = $prop->getDbPropertyName();
        }

        $query = "REPLACE INTO $this->tableName (" . implode(",", $dbProps) . ") VALUES (" . implode(",", $dbValues) . ")";
        $stmt = DbConnection::getDefault()->prepare($query);
        $stmt->execute();

        $this->isNew = false;

        return $this;
    }

    protected static function buildWhere(array $where)
    {
        $conditionStr = "";
        $condition = [];

        foreach ($where as $cell => $data)
        {
            $condition[] = $cell . " = " . $data;
        }

        if (count($condition) > 0)
        {
            $conditionStr = implode(" AND ", $condition);
            return $conditionStr;
        }

        return null;
    }

    public function getClassName()
    {
        $fullName = get_class($this);
        $parts = explode("\\", $fullName);
        return $parts[count($parts) - 1];
    }

    protected abstract function loadMapping();
}