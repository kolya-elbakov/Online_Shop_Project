<?php
require_once './../Controller/UserController.php';
require_once './../Controller/MainController.php';

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