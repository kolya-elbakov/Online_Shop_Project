<?php

namespace Request;

class DeleteRequest extends Request
{
    public function validateDelete(): bool
    {
        session_start();
        return isset($_SESSION['user_id']) && ($this->body['product_id']);
    }

    public function getProductId()
    {
        return $this->body['product_id'];
    }
}