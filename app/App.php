<?php

use Request\Request;

class App
{
    private array $routes = [];
    public function run(): void
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
                $requestClass = $handler['request'] ?? Request::class;

                $obj = new $class();
                $request = new $requestClass($_POST);
                $obj->$method($request);
            } else {
                echo "Метод $requestMethod не поддерживается для $requestUri";
            }
        } else {
            require_once './../View/not_found.php';
        }
    }

    public function get(string $route, string $class, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['GET'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function post(string $route, string $class, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['POST'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function put(string $route, string $class, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['PUT'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }

    public function delete(string $route, string $class, string $method, string $requestClass = null): void
    {
        $this->routes[$route]['DELETE'] = [
            'class' => $class,
            'method' => $method,
            'request' => $requestClass
        ];
    }
}
