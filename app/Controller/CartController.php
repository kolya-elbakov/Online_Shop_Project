<?php

namespace Controller;

use Elbakov\MyCore\Service\Authentication\AuthenticationInterface;
use Model\Cart;
use Model\CartProduct;
use Request\DeleteRequest;
use Request\SignRequest;
use Resource\CartResource;

class CartController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
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

        require_once './../View/cart.php';
    }

    public function deleteProduct(DeleteRequest $request): void
    {
        $result = $this->authenticationService->check();

        if(!$result){
            header("Location: /login");
        }

        if (empty($request->validateDelete()))
        {
            $userId = $this->authenticationService->getCurrentUserId()->getId();
            $cart = Cart::getUserCart($userId);
            $productId = $request->getProductId();
            CartProduct::deleteProduct($cart->getId(), $productId);
            header("Location: /cart");
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
                        CartProduct::deleteProduct($cart->getId(), $productId);
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