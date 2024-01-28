<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\CartProduct;
use Model\Cart;
use Request\OrderRequest;
use Service\AuthenticationService;

class OrderController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
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

            $orderId = Order::createOrder($name, $email, $city, $street, $zip, $payment);
            session_start();
            $userId = $_SESSION['user_id'];
            $cart = Cart::getUserCart($userId);
            $productsCart = CartProduct::getAllByCartId($cart->getId());

            foreach ($productsCart as $product) {
                $productId = $product->getProductId();
                OrderProduct::createOrderProduct($orderId, $cart->getId(), $productId, $product->getQuantity());
            }

            CartProduct::deleteProducts($cart->getId(), $productId);

            header("Location: /successful");
        }

        require_once './../View/order.php';
    }

    public function successForm(): void
    {
        require_once './../View/successful.php';
    }
}