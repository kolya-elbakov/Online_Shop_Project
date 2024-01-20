<?php

namespace Request;

class AddProductRequest extends Request
{
    public function validateAddProduct()
    {
        $errors = [];

        $productId = $this->body['product_id'];
        if($productId < 1) {
            $errors['product_id'] = 'Не верное значение';
        }

        $quantity = $this->body['quantity'];
        if($quantity < 1) {
            $errors['quantity'] = 'Не верное значение';
        }
        return $errors;
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }

    public function getQuantity()
    {
        return $this->body['quantity'];
    }
}