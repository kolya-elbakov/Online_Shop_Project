<?php

namespace Model;

class CartProduct extends Model
{
    private int $id;

    public function getId(): int
    {
        return $this->id;
    }
    private int $cartId;

    public function getCartId(): int
    {
        return $this->cartId;
    }
    private int $productId;

    public function getProductId(): int
    {
        return $this->productId;
    }
    private int $quantity;

    public function getQuantity(): int
    {
        return $this->quantity;
    }


    public function __construct(int $id, int $cartId, int $productId, int $quantity)
    {
        $this->id = $id;
        $this->cartId = $cartId;
        $this->productId = $productId;
        $this->quantity = $quantity;
    }

    public static function createCartProduct(int $cartId, int $productId, int $quantity): bool
    {
        if(self::isProductById($cartId, $productId)){
            self::updateQuantity($cartId, $productId, $quantity);
        } else {
            $statement = static::getPdo()->prepare("INSERT INTO cart_products (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, :quantity)");
            return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
        }
       return true;
    }

    private static function isProductById(int $cartId, int $productId): bool
    {
        $statement = static::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);

        return $statement->rowCount() > 0;
    }

    private static function updateQuantity(int $cartId, int $productId, int $quantity): void
    {
        $statement = static::getPdo()->prepare("UPDATE cart_products SET quantity = quantity + :quantity WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getProducts(int $cartId): array
    {
        $statement = static::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
        $statement->execute(['cart_id' => $cartId]);
        $products = $statement->fetchAll();

        $result = [];
        foreach ($products as $product){
            $result[] = new self($product['id'], $product['cart_id'], $product['product_id'], $product['quantity']);
        }
        return $result;
    }

    public static function getProductQuantity(int $cartId, int $productId)
    {
        $statement = static::getPdo()->prepare("SELECT quantity FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
        return $statement->fetchColumn();
    }

    public static function deleteProducts(int $cartId, int $productId): bool
    {
        $statement = static::getPdo()->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
    }


}