<?php

namespace Framework\Utils;


abstract class UnorderedMap
{
    protected $data = [];

    public function Add($key, $value)
    {
        if (isset($this->data[$key]))
        {
            throw new Exception("key already exists");
        }

        $this->data[$key] = $value;
    }

    public function AddRange(array $data)
    {
        if (count(array_intersect_key(array_flip($data), $this->data)) !== 0)
        {
            throw new Exception("one or more keys already exist");
        }

        array_push($this->data, $data);
    }

    public function Get($key)
    {
        if (!isset($this->data[$key]))
        {
            throw new Exception("key doesn't exist");
        }

        return $this->data[$key];
    }

    public function GetMany(array $keys)
    {
        $result = [];
        foreach ($keys as $key)
        {
            if (isset($this->data[$key]))
            {
                $result[] = $this->data[$key];
            }
        }
        return $result;
    }

    public function Remove($key)
    {
        if (!isset($this->data[$key]))
        {
            throw new Exception("key doesn't exist");
        }

        unset($this->data[$key]);
    }

    public function ContainsKey($key)
    {
        return isset($this->data[$key]);
    }

    public function ToArray()
    {
        return $this->data;
    }

    public function ToString()
    {
        return var_export($this->data, true);
    }

    public function First()
    {
        return array_values($this->data)[0];
    }
}
