<?php

namespace Framework\Application\Database;

use Config;

class DbConnection extends \PDO
{
    public function __construct($hostname, $username, $password, $database, array $options = [])
    {
        parent::__construct("mysql:host=$hostname;dbname=$database", $username, $password, $options);
    }

    public static function getDefault()
    {
        return new DbConnection(\Config\App\MYSQL_HOSTNAME, \Config\App\MYSQL_USERNAME, \Config\App\MYSQL_PASSWORD, \Config\App\MYSQL_DATABASE);
    }
}
