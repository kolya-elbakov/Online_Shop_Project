<?php

require_once './../Model/User.php';
class UserController
{
    private User $modelUser;

    public function __construct()
    {
        $this->modelUser = new User();
    }

    public function getRegistrate(): void
    {
        require_once './../View/registrate.php';
    }
    public function registrate(): void
    {
        $errors = $this->validateReg($_POST);

        if(empty($errors)) {
            $password = $_POST['psw'];
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->modelUser->create($name, $email, $password);

            header("Location: /login");
        }

        require_once './../View/registrate.php';
    }

    private function validateReg(array $data): array
    {
        $errors = [];

        $name = $data['name'];
        if(strlen($name) < 2) {
            $errors['name']= 'Имя указано неверно';
        }

        $email = $data['email'];
        if(strlen($email) < 4) {
            $errors['email']= 'Email указан неверный';
        } else {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email должен содержать @';
            }
        }

        $password = $data['psw'];
        if(strlen($password) < 8) {
            $errors['password'] = 'Пароль должен быть не менее 8 символов';
        }

        $psw_repeat = $data['psw-repeat'];
        if ($psw_repeat !== $password){
            $errors['repeat-psw'] = 'Пароли не совпадают';
        }
        return $errors;
    }

    public function getLogin()
    {
        require_once './../View/login.php';
    }
    public function login()
    {
        $errors = $this->validateLog($_POST);

        if(empty($errors)) {
            $password = $_POST['password'];
            $email = $_POST['email'];

            $data = $this->modelUser->getOneByEmail($email);
            session_start();
            $_SESSION['user_id'] = $data['id'];
            header("Location: /main");
        }
        require_once './../View/login.php';
    }

    public function validateLog(array $array): array
    {
        $errors = [];

        $email = $array['email'];
        if(empty($email)){
            $errors['email'] = 'Введите email';
        }

        $password = $array['password'];
        if(empty($password)) {
            $errors['password'] = 'Введите пароль';
        }

        if(empty($errors)) {
            $password = $_POST['password'];
            $email = $_POST['email'];

            $data = $this->modelUser->getOneByEmail($email);

            if(empty($data)) {
                $errors['email'] = 'Пользователя не существует';
            } elseif(!password_verify($password, $data['password'])) {
                $errors['password'] = 'Неверный логин или пароль';
            }
        }
        return $errors;
    }

    public function logout(): void
    {
        session_start();
        if (isset($_SESSION['user_id'])) {
            session_destroy();
            header('Location: /login' );
        }
    }
}