<?php
print_r($_POST);

$errors = [];

$name = $_POST['name'];
if(strlen($name) < 2) {
    $errors['name'] = 'Имя указано неверно';
}

$email = $_POST['email'];
if(strlen($email) < 4) {
    $errors['email'] = 'Email указан неверный';
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email должен содержать @';
    }
}

$password = $_POST['psw'];
$psw_repeat = $_POST['psw-repeat'];
if(strlen($password) < 8) {
    $errors['password'] = 'Пароль должен быть не менее 8 символов';
} else {
    if ($psw_repeat !== $password){
        $errors['password'] = 'Пароли не совпадают';
    }
}

if(empty($errors)) {
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");

    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    $statement = $pdo->prepare("SELECT * FROM users WHERE name = :name");
    $statement->execute(['name' => $name]);
    $res = $statement->fetch();
    print_r($res);
} else {
    foreach($errors as $elem){
        foreach($elem as $message) {
            echo $message . "<br>";
        }
    }
}