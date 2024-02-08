<?php

namespace Model;

use Elbakov\MyCore\Model\Model;

class User extends Model
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }
    private string $email;

    public function getEmail(): string
    {
        return $this->email;
    }
    private string $password;

    public function getPassword(): string
    {
        return $this->password;
    }

    public function __construct(int $id, string $name, string $email, string $password)
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
        return self::hydrate($data);    }

    public static function getById(int $id): User|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM users WHERE id = :id");
        $statement->execute(['id' => $id]);
        $data = $statement->fetch();

        if(!$data){
            return null;
        }
        return self::hydrate($data);
    }
    public static function create(string $name, string $email, string $password): void
    {
        $statement = static::getPdo()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    private static function hydrate($data): User
    {
        return new self($data['id'], $data['name'], $data['email'], $data['password']);
    }

}