<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Model\Product;
//use Request\AddProductRequest;
use Resource\CartResource;
use Service\AuthenticationInterface;


class MainController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
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
        $quantityInput = [];

        if (!empty($cart)) {
            $cartProducts = CartProduct::getAllByCartId($cart->getId());

            foreach ($cartProducts as $cartProduct) {
                $productId = $cartProduct->getProductId();
                $quantity = $cartProduct->getQuantity();
                $quantityInput[$productId] = $quantity;
            }
        }
        $cartResource = CartResource::format($cart);
        $count = $cartResource['count'];

        require_once './../View/main.php';
    }

    public function updateCount(): void
    {
        $userId = $this->authenticationService->getCurrentUserId()->getId();
        $cart = Cart::getUserCart($userId);

        $cartResource = CartResource::format($cart);
        $updateCount = $cartResource['count'];

        echo $updateCount;
    }
}