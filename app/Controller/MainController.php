<?php

namespace Controller;

use Model\Product;
//use Model\User;
//use PDO;

class MainController
{

    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }

    public function getProducts()
    {
        session_start();
        if(!isset($_SESSION['user_id'])) {
            header("Location: /login");
        }
        else {
            $products = $this->productModel->getAll();
        }
        require_once './../View/main.php';
    }
}