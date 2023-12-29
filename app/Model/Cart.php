<?php

namespace Model;

class Cart extends Model
{
    public function getUserCart(int $userId)
    {
        $statement = $this->pdo->prepare("INSERT INTO carts (user_id) VALUES (:user_id)");
        $statement->execute(['user_id' => $userId]);

        return $this->pdo->lastInsertId();
    }
}