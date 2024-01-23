<?php

namespace Model;

class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private int $password;

    public function __construct(int $id, string $name, string $email, int $password)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }
    public static function getOneByEmail(string $email): User|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email' => $email]);

        $data = $statement->fetch();
        if(!$data){
            return null;
        }
        return new self($data['id'], $data['name'], $data['email'], $data['password']);
    }
    public static function create(string $name, string $email, string $password): void
    {
        $statement = static::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}