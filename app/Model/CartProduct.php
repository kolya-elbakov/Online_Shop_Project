<?php

namespace Model;

class CartProduct extends Model
{

    public function createCartProduct(int $cartId, int $productId, int $quantity): bool
    {
        if($this->isProductById($cartId, $productId)){
            $this->updateQuantity($cartId, $productId, $quantity);
        } else {
            $statement = $this->pdo->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
            return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
        }
       return true;
    }

    public function isProductById(int $cartId, int $productId): bool
    {
        $statement = $this->pdo->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);

        return $statement->rowCount() > 0;
    }

    public function updateQuantity(int $cartId, int $productId, int $quantity): bool
    {
        $statement = $this->pdo->prepare("UPDATE cart_products SET quantity = quantity + :quantity WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }
}