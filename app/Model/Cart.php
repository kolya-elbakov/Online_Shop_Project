<?php

namespace Model;


use Core\Model\Model;

class Cart extends Model
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
    private int $userId;

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function __construct(int $id, int $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public static function createCart(int $userId): bool
    {
        $statement = static::getPdo()->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        return $statement->execute(['user_id' => $userId]);
    }

    public static function getUserCart(int $userId): Cart|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);
        $data = $statement->fetch();

        if (!$data)
        {
            return null;
        }

        return self::hydrate($data);
    }
    private static function getCartByUserId(int $userId): Cart|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);

        $data = $statement->fetch();
        if(!$data){
            return null;
        }

        return self::hydrate($data);
    }

    private static function hydrate($data): Cart
    {
        return new self($data['id'], $data['user_id']);
    }
}