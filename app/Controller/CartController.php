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
    public function getAddProductForm()
    {
        session_start();
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            require_once './../View/add-product.php';
        }
    }

    public function addProduct(array $data)
    {
//        print_r($data);
        session_start();
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $productId = $data['product_id'];
            $quantity = $data['quantity'];

            $cartId = $this->cartModel->getUserCart($userId);
            $this->cartProductModel->createCartProduct($cartId, $productId, $quantity);

            header("Location: /add-product");
        }
        require_once './../View/main.php';
    }
}