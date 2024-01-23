<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\DeleteRequest;

class CartController
{
    public function getCartForm(): void
    {
        session_start();
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        } else {
            $userId = $_SESSION['user_id'];
            $cartId = Cart::getUserCart($userId);
            $productsCart = CartProduct::getProducts($cartId);

            $productsCartInfo = [];
            foreach ($productsCart as $elem) {
                $name = Product::getProductName($elem['product_id']);
                $model = Product::getProductModel($elem['product_id']);
                $link = Product::getProductLink($elem['product_id']);
                $price = Product::getProductPrice($elem['product_id']);

                $productsCartInfo[] = ['name' => $name, 'model' => $model, 'link' => $link, 'price' => $price];
            }

            $productsCartQuantity = [];
            foreach ($productsCart as $elem) {
                $quantity = CartProduct::getProductQuantity($cartId, $elem['product_id']);
                $productsCartQuantity[] = ['quantity' => $quantity];
            }

            $productsTotal = [];
            $totalPrice = 0;
            foreach ($productsCart as $elem) {
                $price = Product::getProductPrice($elem['product_id']);
                $quantity = CartProduct::getProductQuantity($cartId, $elem['product_id']);
                $total = $quantity * $price;
                $productsTotal[] = ['total' => $total];

                $totalPrice += $total;
            }
        }
        require_once './../View/cart.php';
    }

    public function deleteProduct(DeleteRequest $request): void
    {
        if ($request->validateDelete())
        {
            $userId = $_SESSION['user_id'];
            $cart = Cart::getUserCart($userId);
            $productId = $request->getProductId();
            CartProduct::deleteProducts($cart, $productId);
            header("Location: /cart");
        } else {
            header("Location: /login");
        }
    }


    public function addProduct(AddProductRequest $request): void
    {
        $errors = $request->validateAddProduct();

        if(empty($errors)) {
            session_start();
            $userId = $_SESSION['user_id'];
            $productId = $request->getProductId();
            $quantity = $request->getQuantity();

            $cartId = Cart::getUserCart($userId);
            CartProduct::createCartProduct($cartId, $productId, $quantity);

            header("Location: /main");
        }
        require_once './../View/main.php';
    }
}