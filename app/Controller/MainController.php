<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Resource\CartResource;
use Service\SessionAuthenticationService;


class MainController
{
    private SessionAuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new SessionAuthenticationService();
    }
    public function getProducts(): void
    {
        $res = $this->authenticationService->check();
        if(!$res) {
            header("Location: /login");
        } else {
            $products = Product::getAll();
        }

        $userId = $this->authenticationService->getCurrentUserId()->getId();
        $cart = Cart::getUserCart($userId);
        $viewData = CartResource::format($cart);
        $quantityInput = [];

        if (!empty($cart)) {
            $cartProducts = CartProduct::getAllByCartId($cart->getId());

            foreach ($cartProducts as $cartProduct) {
                $productId = $cartProduct->getProductId();
                $quantity = $cartProduct->getQuantity();
                $quantityInput[$productId] = $quantity;
            }
        }
        require_once './../View/main.php';
    }
}