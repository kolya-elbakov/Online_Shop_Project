<?php

//print_r($_POST);

$errors = [];

$email = $_POST['email'];
if(empty($email)){
    $errors['email'] = 'Введите email';
}

$password = $_POST['password'];
if(empty($password)) {
    $errors['password'] = 'Введите пароль';
}

if(empty($errors)) {
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute(['email' => $email]);
    $res = $statement->fetch();

    if($res == 0) {
        $errors['email'] = 'Пользователя не существует';
    } else {
        if(password_verify($password, $res['password'])) {
            session_start();
            $_SESSION['user_id'] = $res['id'];
            header("Location: /main.php");
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    }
}

require_once './get_login.php';
