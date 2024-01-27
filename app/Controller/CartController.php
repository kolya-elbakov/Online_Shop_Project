<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Request\DeleteRequest;
use Service\AuthenticationService;

class CartController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }
    public function getCartForm(): void
    {
        $res = $this->authenticationService->check();
        if(!$res) {
            header("Location: /login");
        }

        $userId = $this->authenticationService->getCurrentUserId();
        $cart = Cart::getUserCart($userId);
        $productsCart = CartProduct::getProducts($cart->getId());

        $result = ['products' => []];
        $totalPrice = 0;
        foreach ($productsCart as $elem) {
            $productId = $elem->getProductId();
            $productInfo = Product::getProductInfo($productId);
            $productLineTotal = $elem->getQuantity() * $productInfo->getPrice();
            $totalPrice += $productLineTotal;

            $result['products'][] = [
                'id' => $productId,
                'name' => $productInfo->getName(),
                'model' => $productInfo->getModel(),
                'link' => $productInfo->getLink(),
                'price' => $productInfo->getPrice(),
                'quantity' => $elem->getQuantity(),
                'total' => $totalPrice
            ];
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
            CartProduct::deleteProducts($cart->getId(), $productId);
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

            $cart = Cart::getUserCart($userId);
            CartProduct::createCartProduct($cart->getId(), $productId, $quantity);

            header("Location: /main");
        }
        require_once './../View/main.php';
    }
}