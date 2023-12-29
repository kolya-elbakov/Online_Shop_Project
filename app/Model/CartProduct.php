<?php

namespace Model;

class CartProduct extends Model
{

    public function createCartProduct(int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
}