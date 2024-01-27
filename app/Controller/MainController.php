<?php

namespace Controller;

use Model\Product;
use Service\AuthenticationService;


class MainController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }
    public function getProducts(): void
    {
        $res = $this->authenticationService->check();
        if(!$res) {
            header("Location: /login");
        } else {
            $products = Product::getAll();
        }
        require_once './../View/main.php';
    }
}