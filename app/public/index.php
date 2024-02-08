<?php

use Controller\CartController;
use Controller\MainController;
use Controller\OrderController;
use Controller\UserController;
use Elbakov\MyCore\App;
use Elbakov\MyCore\Autoloader;
use Elbakov\MyCore\Service\Authentication\SessionAuthenticationService;
use Request\DeleteRequest;
use Request\LoginRequest;
use Request\OrderRequest;
use Request\RegistrateRequest;
use Request\SignRequest;

require_once './../vendor/autoload.php'; //подключение содержимого другого файла

Autoloader::registrate(dirname(__DIR__)); //полный путь до директории файлов наших классов

$app = new App();

$app->get('/registrate', UserController::class, 'getRegistrate');
$app->post('/registrate', UserController::class, 'registrate', RegistrateRequest::class);

$app->get('/login', UserController::class, 'getLogin');
$app->post('/login', UserController::class, 'login', LoginRequest::class);

$app->get('/main', MainController::class, 'getProducts');
$app->get('/count', MainController::class, 'updateCount');

$app->get('/logout', SessionAuthenticationService::class, 'logout');

$app->get('/cart', CartController::class, 'getCartForm');

$app->get('/order', OrderController::class, 'getOrderForm');
$app->post('/order', OrderController::class, 'order', OrderRequest::class);

$app->get('/add-product', CartController::class, 'getCartForm');
//$app->post('/add-product', CartController::class, 'addProduct', SignRequest::class);

$app->post('/minus', CartController::class, 'decreaseQuantity', SignRequest::class);
$app->post('/plus', CartController::class, 'increaseQuantity', SignRequest::class);

$app->post('/delete', CartController::class, 'deleteProduct', DeleteRequest::class);

$app->get('/successful', OrderController::class, 'successForm');

$app->run();