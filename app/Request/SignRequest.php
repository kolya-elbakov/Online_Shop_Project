<?php

namespace Request;

class SignRequest extends Request
{
    public function validate(): array
    {
        $errors = [];
        $productId = $this->getProductId();

        if (empty($productId))
        {
            $errors['product'] =  "Выберете товар";
        }

        return $errors;
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }
}