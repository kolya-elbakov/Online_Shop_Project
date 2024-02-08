<?php

namespace Model;

use Elbakov\MyCore\Model\Model;

class OrderProduct extends Model
{
    public static function createOrderProduct(int $orderId, int $cartId, int $productId, int $quantity): bool
    {
        $statement = static::getPdo()->prepare("INSERT INTO order_product (order_id, cart_id, product_id, quantity) VALUES (:order_id, :cart_id, :product_id, :quantity)");
        return $statement->execute(['order_id' => $orderId, 'cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
}