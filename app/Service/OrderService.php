<?php

namespace Service;

use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrderProduct;

class OrderService
{
    public static function create(string $name, string $email, string $city, string $street, int $zip, string $payment, Cart $cart): void
    {
        $orderId = Order::createOrder($name, $email, $city, $street, $zip, $payment);
        $productsCart = CartProduct::getAllByCartId($cart->getId());

        foreach ($productsCart as $product) {
            $productId = $product->getProductId();
            OrderProduct::createOrderProduct($orderId, $cart->getId(), $productId, $product->getQuantity());
        }
        CartProduct::deleteProductsByCart($cart->getId());
    }
}