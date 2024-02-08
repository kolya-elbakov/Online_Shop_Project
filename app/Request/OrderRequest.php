<?php

namespace Request;

use Core\Request\Request;

class OrderRequest extends Request
{
    public function validateOrder()
    {
        $errors = [];

        $name = $this->body['name'];
        if(strlen($name) < 2) {
            $errors['name']= 'Имя указано неверно';
        }

        $email = $this->body['email'];
        if(strlen($email) < 4) {
            $errors['email']= 'Email указан неверный';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email должен содержать @';
        }

        $city = $this->body['city'];
        if(strlen($city) < 6) {
            $errors['city'] = 'Такого города не существует';
        }

        $words = ['улица', 'проспект', 'площадь'];
        $street = $this->body['street'];
        if(strlen($street) < 5) {
            $errors['street'] = 'Введите корректный адрес';
        } else {
            foreach ($words as $word){
                if(stripos($street, $word) !== false){
                    $errors['street'] = 'Адрес не должен содержать слово' . '"'.$word.'"';
                }
            }
        }

        $zip = $this->body['zip'];
        if(strlen($zip) < 6) {
            $errors['zip'] = 'Неверный почтовый индекс';
        }

        return $errors;
    }

    public function getName()
    {
        return $this->body['name'];
    }

    public function getEmail()
    {
        return $this->body['email'];
    }

    public function getCity()
    {
        return $this->body['city'];
    }

    public function getStreet()
    {
        return $this->body['street'];
    }

    public function getZip()
    {
        return $this->body['zip'];
    }

    public function getPayment()
    {
        return $this->body['payment'];
    }

}