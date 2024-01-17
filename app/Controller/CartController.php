<?php

namespace Controller;
use Model\Cart;
use Model\CartProduct;
use Model\Product;

class CartController
{
    private Cart $cartModel;
    private CartProduct $cartProductModel;
    private Product $productModel;

    public function __construct()
    {
        $this->cartModel = new Cart();
        $this->cartProductModel = new CartProduct();
        $this->productModel = new Product();
    }
    public function getCartForm(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cartId = $this->cartModel->getUserCart($userId);
            $productsCart = $this->cartProductModel->getProducts($cartId);

            $productsCartInfo = [];
            foreach ($productsCart as $elem) {
                $name = $this->productModel->getProductName($elem['product_id']);
                $model = $this->productModel->getProductModel($elem['product_id']);
                $link = $this->productModel->getProductLink($elem['product_id']);
                $price = $this->productModel->getProductPrice($elem['product_id']);

                $productsCartInfo[] = ['name' => $name, 'model' => $model, 'link' => $link, 'price' => $price];
            }

            $productsCartQuantity = [];
            foreach ($productsCart as $elem) {
                $quantity = $this->cartProductModel->getProductQuantity($cartId, $elem['product_id']);
                $productsCartQuantity[] = ['quantity' => $quantity];
            }

            $productsTotal = [];
            $totalPrice = 0;
            foreach ($productsCart as $elem) {
                $price = $this->productModel->getProductPrice($elem['product_id']);
                $quantity = $this->cartProductModel->getProductQuantity($cartId, $elem['product_id']);
                $total = $quantity * $price;
                $productsTotal[] = ['total' => $total];

                $totalPrice += $total;
            }
        }
        require_once './../View/cart.php';
    }

    public function deleteProduct(array $data): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            if (isset($data['product_id']))
            {
                $userId = $_SESSION['user_id'];
                $cart = $this->cartModel->getUserCart($userId);
                $productId = $data['product_id'];
                $this->cartProductModel->deleteProducts($cart, $productId);
            }
            header("Location: /cart");
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