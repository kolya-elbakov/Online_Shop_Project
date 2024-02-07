<?php

namespace Core\Model;

use PDO;

class Model
{
    protected static PDO $pdo;

    public static function getPdo(): PDO
    {
        if(isset(static::$pdo)){
            return static::$pdo;
        }
        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $dbuser = getenv('DB_USER');
        $dbpassword = getenv('DB_PASSWORD');

        static::$pdo = new PDO("pgsql:host=$dbhost;port=5432;dbname=$dbname;", "$dbuser", "$dbpassword");
        return static::$pdo;
    }
}