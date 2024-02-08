<?php

namespace Core\Service;

use Model\Cart;
use Model\CartProduct;
use Model\Model;
use Model\Order;
use Model\OrderProduct;
use Model\User;

class OrderService
{
    public static function create(Order $order, User $user): void
    {
        $pdo = Model::getPdo();

        $cart = Cart::getUserCart($user->getId());

        $productsCart = CartProduct::getAllByCartId($cart->getId());


        $pdo->beginTransaction();
        try {
            $order->save();
            $orderId = $order->getId();

            foreach ($productsCart as $product) {
                $productId = $product->getProductId();
                OrderProduct::createOrderProduct($orderId, $cart->getId(), $productId, $product->getQuantity());
            }

            CartProduct::deleteProductsByCart($cart->getId());

            $pdo->commit();
        } catch(\Throwable $exception) {
            $pdo->rollBack();
        }
    }
}