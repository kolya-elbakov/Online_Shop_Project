<?php

class App
{
    private array $routes = [
        '/registrate' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrate'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLogin'
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login'
            ]
        ],
        '/main' => [
            'GET' => [
                'class' => 'MainController',
                'method' => 'getProducts'
            ]
        ],
        '/logout' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'logout'
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
                $obj->$method();
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.php';
        }
    }
}
