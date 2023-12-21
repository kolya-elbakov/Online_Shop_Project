<?php

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");
    }
    public function getOneByEmail(string $email)
    {
        $statement = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);
        $data = $statement->fetch();

        return $data;
    }
    public function create(string $name, string $email, string $password)
    {
        $statement = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}