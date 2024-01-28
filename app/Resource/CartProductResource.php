<?php

namespace Resource;

use Model\CartProduct;
use Model\Product;

class CartProductResource
{
    public static function format(CartProduct $cartProduct): array
    {
        $productId = $cartProduct->getProductId();
        $product = Product::getOneById($productId);
        $productTotal = $cartProduct->getQuantity() * $product->getPrice();

        return [
            'id' => $productId,
            'name' => $product->getName(),
            'model' => $product->getModel(),
            'link' => $product->getLink(),
            'price' => $product->getPrice(),
            'quantity' => $cartProduct->getQuantity(),
            'total' => $productTotal
        ];
    }
}