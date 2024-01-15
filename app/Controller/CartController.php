<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;

class CartController
{
    private Cart $cartModel;
    private CartProduct $cartProductModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->cartProductModel = new CartProduct();
    }
    public function getCartForm(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            require_once './../View/cart.php';
        }
    }

    public function addProduct(array $data): void
    {
        $errors = $this->validateAdd($_POST);

        if(empty($errors)) {

            session_start();
            $userId = $_SESSION['user_id'];
            $productId = $data['product_id'];
            $quantity = $data['quantity'];

            $cartId = $this->cartModel->getUserCart($userId);
            $this->cartProductModel->createCartProduct($cartId, $productId, $quantity);

            header("Location: /main");
        }
        require_once './../View/main.php';
    }

    public function validateAdd(array $data): array
    {
        $errors = [];

        $productId = $data['product_id'];
        if($productId < 1) {
            $errors['product_id'] = 'Не верное значение';
        }

        $quantity = $data['quantity'];
        if($quantity < 1) {
            $errors['quantity'] = 'Не верное значение';
        }
        return $errors;
    }
}