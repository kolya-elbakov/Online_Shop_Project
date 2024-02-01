<?php

namespace Controller;

use Model\Cart;
use Model\CartProduct;
use Request\SignRequest;
use Request\DeleteRequest;
use Resource\CartResource;
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

        $userId = $this->authenticationService->getCurrentUserId()->getId();
        $cart = Cart::getUserCart($userId);
        $productsCart = CartProduct::getAllByCartId($cart->getId());
        $viewData = CartResource::format($cart);
//        var_dump($viewData['count']);die;

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

    public function decreaseQuantity(SignRequest $request): void
    {
        $result = $this->authenticationService->check();
        if (!$result)
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors))
        {
            $productId = $request->getProductId();

            $userId = $this->authenticationService->getCurrentUserId()->getId();
            $cart = Cart::getUserCart($userId);

            if (!empty($cart)) {
                $cartProduct = CartProduct::isProductById($cart->getId(), $productId);

                if (!empty($cartProduct)) {
                    $currentQuantity = $cartProduct->getQuantity();
                    if ($currentQuantity > 1) {
                        $newQuantity = $currentQuantity - 1;
                        CartProduct::updateQuantity($cart->getId(), $productId, $newQuantity);
                    } else {
                        CartProduct::deleteProducts($cart->getId(), $productId);
                    }
                }
            }

            header("Location: /main");
            require_once './../View/main.php';
        }
    }

    public function increaseQuantity(SignRequest $request): void
    {
        $result = $this->authenticationService->check();
        if (!$result)
        {
            header("Location: /login");
        }

        $errors = $request->validate();

        if (empty($errors))
        {
            $productId = $request->getProductId();

            $userId = $this->authenticationService->getCurrentUserId()->getId();
            $cart = Cart::getUserCart($userId);

            if (!empty($cart)) {
                $cartProduct = CartProduct::isProductById($cart->getId(), $productId);

                if (empty($cartProduct)) {
                    CartProduct::createCartProduct($cart->getId(), $productId, 1);
                } else {
                    $currentQuantity = $cartProduct->getQuantity();
                    $newQuantity = $currentQuantity + 1;
                    CartProduct::updateQuantity($cart->getId(), $productId, $newQuantity);
                }
            } else {
                Cart::createCart($userId);
                $cart = Cart::getUserCart($userId);
                CartProduct::createCartProduct($cart->getId(), $productId, 1);
            }

            header("Location: /main");
        }
    }
}