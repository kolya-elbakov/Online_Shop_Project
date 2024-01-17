<?php

namespace Controller;

use Model\Order;

class OrderController
{
    private Order $modelOrder;

    public function __construct()
    {
        $this->modelOrder = new Order();
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

    public function order(): void
    {
        $errors = $this->validateOrder($_POST);

        if(empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $city = $_POST['city'];
            $street = $_POST['street'];
            $zip = $_POST['zip'];
            $payment = $_POST['payment'];

            $this->modelOrder->createOrder($name, $email, $city, $street, $zip, $payment);

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