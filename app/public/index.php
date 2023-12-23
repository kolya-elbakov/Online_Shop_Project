<?php

$controllerAutoloader = function (string $className)
{
    if(file_exists("./../Controller/$className.php")) {
        require_once "./../Controller/$className.php";
    }
    return false;
};
$modelAutoloader = function (string $className)
{
    if(file_exists("./../Model/$className.php")) {
        require_once "./../Model/$className.php";
    }
    return false;
};
spl_autoload_register($controllerAutoloader);
spl_autoload_register($modelAutoloader);

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestUri === '/registrate'){
    $userController = new UserController();
    if($requestMethod === 'GET'){
        $userController->getRegistrate();
    } elseif($requestMethod === 'POST') {
        $userController->registrate();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif($requestUri === '/login'){
    $userController = new UserController();
    if($requestMethod === 'GET'){
        $userController->getLogin();
    } elseif($requestMethod === 'POST') {
        $userController->login();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif($requestUri === '/main') {
    $mainController = new MainController();
    if ($requestMethod === 'GET') {
        $mainController->getProducts();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} elseif($requestUri === '/logout') {
    $userController = new UserController();
    if ($requestMethod === 'GET') {
        $userController->logout();
    } else {
        echo "Метод $requestMethod не поддерживается для $requestUri";
    }
} else {
    require_once './html/not_found.php';
}