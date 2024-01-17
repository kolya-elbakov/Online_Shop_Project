<?php

namespace Model;

class Cart extends Model
{
    public function getUserCart(int $userId): bool|array|string
    {
        $cart = $this->getCartByUserId($userId);
        if(!empty($cart)){
            return $cart['id'];
        } else {
            $statement = $this->pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
            if($statement->execute(['user_id' => $userId])){
                return $this->pdo->lastInsertId();
            } else {
                return false;
            }
        }
    }
    private function getCartByUserId(int $userId): array|false
    {
        $statement = $this->pdo->prepare("SELECT * FROM carts WHERE user_id = :user_id");
        $statement->execute(['user_id' => $userId]);

        return $statement->fetch();
    }
}