<?php

namespace Controller;

use Model\Order;
use Model\OrderProduct;
use Model\CartProduct;
use Model\Cart;

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

    public function order($data): void
    {
        $errors = $this->validateOrder($data);

        if(empty($errors)) {
            $name = $data['name'];
            $email = $data['email'];
            $city = $data['city'];
            $street = $data['street'];
            $zip = $data['zip'];
            $payment = $data['payment'];

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

    private function validateOrder(array $data): array
    {
        $errors = [];

        $name = $data['name'];
        if(strlen($name) < 2) {
            $errors['name']= 'Имя указано неверно';
        }

        $email = $data['email'];
        if(strlen($email) < 4) {
            $errors['email']= 'Email указан неверный';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email должен содержать @';
        }

        $city = $data['city'];
        if(strlen($city) < 6) {
            $errors['city'] = 'Такого города не существует';
        }

        $words = ['улица', 'проспект', 'площадь'];
        $street = $data['street'];
        if(strlen($street) < 5) {
            $errors['street'] = 'Введите корректный адрес';
        } else {
            foreach ($words as $word){
                if(stripos($street, $word) !== false){
                    $errors['street'] = 'Адрес не должен содержать слово' . '"'.$word.'"';
                }
            }
        }

        $zip = $data['zip'];
        if(strlen($zip) < 6) {
            $errors['zip'] = 'Неверный почтовый индекс';
        }

        return $errors;
    }

    public function successForm(): void
    {
        require_once './../View/successful.php';
    }
}