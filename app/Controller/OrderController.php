<?php

namespace Controller;

use Model\Cart;
use Request\OrderRequest;
use Service\AuthenticationInterface;
use Service\OrderService;

class OrderController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function getOrderForm(): void
    {
        $res = $this->authenticationService->check();
        if(!$res) {
            header("Location: /login");
        } else {
            require_once './../View/order.php';
        }
    }

    public function order(OrderRequest $request): void
    {
        $errors = $request->validateOrder();

        if(empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $city = $request->getCity();
            $street = $request->getStreet();
            $zip = $request->getZip();
            $payment = $request->getPayment();
            $userId = $this->authenticationService->getCurrentUserId()->getId();
            $cart = Cart::getUserCart($userId);

            OrderService::create($name, $email, $city, $street, $zip, $payment, $cart);

            header("Location: /successful");
        }

        require_once './../View/order.php';
    }

    public function successForm(): void
    {
        require_once './../View/successful.php';
    }
}