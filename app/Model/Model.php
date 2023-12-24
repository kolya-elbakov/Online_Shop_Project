<?php
//namespace Model;
class Model
{
    protected PDO $pdo;

    public function __construct()
    {
        $dbhost = getenv('DB_HOST');
        $dbname = getenv('DB_NAME');
        $dbuser = getenv('DB_USER');
        $dbpassword = getenv('DB_PASSWORD');

        $this->pdo = new PDO("pgsql:host=$dbhost;port=5432;dbname=$dbname;", "$dbuser", "$dbpassword");
    }
}