<?php

namespace Model;

class Cart extends Model
{
    private int $id;
    private int $userId;

    public function __construct(int $id, int $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }
    public static function getUserCart(int $userId)
    {
        $cart = static::getCartByUserId($userId);
        if(!empty($cart)){
            return $cart['id'];
        } else {
            $statement = static::getPdo()->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
            if($statement->execute(['user_id' => $userId])){
                return static::getPdo()->lastInsertId();
            } else {
                return false;
            }
        }
    }
    private static function getCartByUserId(int $userId): Cart|null
    {
        $statement = static::getPdo()->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);

        $data = $statement->fetch();
        if(!$data){
            return null;
        }

        return new self($data['id'], $data['user_id']);
    }
}