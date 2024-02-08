<?php

namespace Model;

use Core\Model\Model;

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

    public static function isProductById(int $cartId, int $productId): CartProduct|false
    {
        $statement = static::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);

        $result = $statement->fetch();

        if (!$result)
        {
            return false;
        }
        return self::hydrate($result);
    }

    public static function updateQuantity(int $cartId, int $productId, int $quantity): void
    {
        $statement = static::getPdo()->prepare("UPDATE cart_products SET quantity = :quantity WHERE cart_id = :cart_id AND product_id = :product_id");
        $statement->execute(['cart_id' => $cartId, 'product_id' => $productId, 'quantity' => $quantity]);
    }

    public static function getAllByCartId(int $cartId): array
    {
        $statement = static::getPdo()->prepare("SELECT * FROM cart_products WHERE cart_id = :cart_id");
        $statement->execute(['cart_id' => $cartId]);
        $products = $statement->fetchAll();

        $result = [];
        foreach ($products as $product){
            $result[] = self::hydrate($product);
        }
        return $result;
    }

    public static function getCountProductsByCartId(int $cartId): int
    {
        $statement = static::getPdo()->prepare("SELECT COUNT (DISTINCT product_id) AS count FROM cart_products WHERE cart_id = :cart_id");
        $statement->execute(['cart_id' => $cartId]);
        $result = $statement->fetch();
        return $result['count'];
    }

    public static function deleteProduct(int $cartId, int $productId): bool
    {
        $statement = static::getPdo()->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id AND product_id = :product_id");
        return $statement->execute(['cart_id' => $cartId, 'product_id' => $productId]);
    }

    public static function deleteProductsByCart(int $cartId): bool
    {
        $statement = static::getPdo()->prepare("DELETE FROM cart_products WHERE cart_id = :cart_id");
        return $statement->execute(['cart_id' => $cartId]);
    }


    private static function hydrate($product): CartProduct
    {
        return new self($product['id'], $product['cart_id'], $product['product_id'], $product['quantity']);
    }
}