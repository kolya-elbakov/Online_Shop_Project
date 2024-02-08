<?php

namespace Resource;

use Model\Cart;
use Model\CartProduct;


class CartResource
{
    public static function format(Cart $cart): array
    {
        $productsCart = CartProduct::getAllByCartId($cart->getId());
        $productsCount = CartProduct::getCountProductsByCartId($cart->getId());

        $products = [];
        foreach ($productsCart as $cartProduct) {
            $products[] = CartProductResource::format($cartProduct);
        }

        $totalPrice = 0;
        foreach ($products as $product) {
            $totalPrice += $product['total'];
        }

        return [
            'cart' => $cart,
            'products' => $products,
            'total' => $totalPrice,
            'count' => $productsCount
        ];
    }
}