<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;
use Request\AddProductRequest;
use Resource\CartResource;
use Service\AuthenticationService;


class MainController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }
    public function getProducts(): void
    {
        $res = $this->authenticationService->check();
        if(!$res) {
            header("Location: /login");
        } else {
            $products = Product::getAll();
            $userId = $this->authenticationService->getCurrentUserId()->getId();
            $cart = Cart::getUserCart($userId);
            $viewData = CartResource::format($cart);
        }
        require_once './../View/main.php';
    }
}