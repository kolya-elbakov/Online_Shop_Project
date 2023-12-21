<?php

class Product
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");
    }
    public function getAll(): array
    {
        $statement = $this->pdo->query("SELECT * FROM products");
        $products = $statement->fetchAll();

        return $products;
    }
}