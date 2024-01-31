<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Request\AddProductRequest;
use Request\DeleteRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Service\AuthenticationService;

require_once './../Autoloader.php'; //подключение содержимого другого файла

Autoloader::registrate(dirname(__DIR__)); //полный путь до директории файлов наших классов

$app = new App();

$app->get('/registrate', UserController::class, 'getRegistrate');
$app->post('/registrate', UserController::class, 'registrate', RegistrateRequest::class);

$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', LoginRequest::class);

$app->get('/main', MainController::class, 'getProducts');

$app->get('/logout', AuthenticationService::class, 'logout');

$app->get('/cart', CartController::class, 'getCartForm');

$app->get('/order', OrderController::class, 'getOrderForm');
$app->post('/order', OrderController::class, 'order', OrderRequest::class);

//$app->get('/add-product', CartController::class, 'getAddProductForm');
$app->post('/add-product', CartController::class, 'addProduct', AddProductRequest::class);

$app->post('/delete', CartController::class, 'deleteProduct', DeleteRequest::class);

$app->get('/successful', OrderController::class, 'successForm');

$app->run();