<?php

namespace Controller;

use Model\Product;

class OrderController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
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

    public function getProducts()
    {
//        session_start();
//        if(!isset($_SESSION['user_id'])) {
//            header("Location: /login");
//        }
//        else {
        $products = $this->productModel->getAll();
        require_once './../View/order.php';
    }
}