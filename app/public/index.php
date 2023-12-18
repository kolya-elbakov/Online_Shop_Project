<?php
$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if($requestUri === '/registrate'){
    if($requestMethod === 'GET'){
        require_once './get_registrate.php';
    } elseif($requestMethod === 'POST') {
        require_once './post_registrate.php';
    }
} elseif($requestUri === '/login'){
    if($requestMethod === 'GET'){
        require_once './get_login.php';
    } elseif($requestMethod === 'POST') {
        require_once './post_login.php';
    }
} elseif($requestUri === '/main') {
    if ($requestMethod === 'GET') {
        require_once './main.php';
    }
} else {
    require_once './not_found.php';
}