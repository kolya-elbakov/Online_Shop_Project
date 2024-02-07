<?php

namespace Request;

use Core\Request\Request;

class DeleteRequest extends Request
{
    public function validateDelete(): array
    {
        $errors = [];
        if(empty($this->body['product_id'])){
            $errors['delete'] = 'Ошибка';
        }
        return $errors;
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }
}