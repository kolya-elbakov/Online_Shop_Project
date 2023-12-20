<?php
//print_r($_POST);

$errors = [];

$name = $_POST['name'];
if(strlen($name) < 2) {
    $errors['name']= 'Имя указано неверно';
}

$email = $_POST['email'];
if(strlen($email) < 4) {
    $errors['email']= 'Email указан неверный';
} else {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email должен содержать @';
    }
}

$password = $_POST['psw'];
if(strlen($password) < 8) {
    $errors['password'] = 'Пароль должен быть не менее 8 символов';
}

$psw_repeat = $_POST['psw-repeat'];
if ($psw_repeat !== $password){
    $errors['repeat-psw'] = 'Пароли не совпадают';
}
$password = password_hash($password, PASSWORD_DEFAULT);

if(empty($errors)) {
    $pdo = new PDO("pgsql:host=db;port=5432;dbname=postgres;", "dbuser", "dbpwd");

    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $statement->execute(['name' => $name, 'email' => $email, 'password' => $password]);

    header("Location: /login");
}

require_once './html/registrate.php';
?>

