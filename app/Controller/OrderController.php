<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\CartProduct;
use Model\Cart;
use Request\OrderRequest;

class OrderController
{
    private Order $modelOrder;
    private OrderProduct $modelOrderProduct;
    private CartProduct $cartProductModel;
    private Cart $cartModel;

    public function __construct()
    {
        $this->modelOrder = new Order();
        $this->modelOrderProduct = new OrderProduct();
        $this->cartProductModel = new CartProduct();
        $this->cartModel = new Cart();
    }

    public function getOrderForm(): void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
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

            $orderId = $this->modelOrder->createOrder($name, $email, $city, $street, $zip, $payment);
            session_start();
            $userId = $_SESSION['user_id'];
            $cartId = $this->cartModel->getUserCart($userId);
            $productsCart = $this->cartProductModel->getProducts($cartId);

            foreach ($productsCart as $product) {
                $this->modelOrderProduct->createOrderProduct($orderId, $cartId, $product['product_id'], $product['quantity']);
            }

            $this->cartProductModel->deleteProducts($cartId, $product['product_id']);

            header("Location: /successful");
        }

        require_once './../View/order.php';
    }

    public function successForm(): void
    {
        require_once './../View/successful.php';
    }
}