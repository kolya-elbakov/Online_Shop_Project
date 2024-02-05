<?php

namespace Service;

use Model\Cart;
use Model\CartProduct;
use Model\Order;
use Model\OrderProduct;
use Model\User;

class OrderService
{
    public static function create(Order $order, User $user): void
    {
        $order->save();
        $cart = Cart::getUserCart($user->getId());
        $productsCart = CartProduct::getAllByCartId($cart->getId());
        $orderId = $order->getId();

        foreach ($productsCart as $product) {
            $productId = $product->getProductId();
            OrderProduct::createOrderProduct($orderId, $cart->getId(), $productId, $product->getQuantity());
        }
        CartProduct::deleteProductsByCart($cart->getId());
    }
}