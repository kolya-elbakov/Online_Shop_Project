<?php

namespace Model;

class OrderProduct extends Model
{
    public function createOrderProduct(int $orderId, int $cartId, int $productId, int $quantity)
    {
        $statement = $this->pdo->prepare("INSERT INTO orders (order_id, cart_id, product_id, quantity) VALUES (:order_id, :cart_id, :product_id, :quantity)");
        return $statement->execute(['order_id' => $orderId, 'cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
}