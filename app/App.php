<?php

use Controller\CartController;
use Controller\CheckoutController;
use Controller\OrderController;
use \Controller\UserController;
use \Controller\MainController;

class App
{
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login'
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => MainController::class,
                'method' => 'getProducts'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'logout'
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCartForm'
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrderForm'
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'order'
            ]
        ],
        '/add-product' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getAddProductForm'
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'addProduct'
            ]
        ],
        '/delete' => [
            'POST' => [
                'class' => CartController::class,
                'method' => 'deleteProduct'
            ]
        ],
        '/successful' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'successForm'
            ]
        ]
    ];

    public function run()
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        $address = $this->routes[$requestUri];
        if (isset($address)) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            $routesMethod = $address;

            if (isset($routesMethod[$requestMethod])) {
                $handler = $routesMethod[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                $obj = new $class();
                $obj->$method($_POST);
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.php';
        }
    }
}
