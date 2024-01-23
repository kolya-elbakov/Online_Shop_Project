<?php

namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController
{
    public function getRegistrate(): void
    {
        require_once './../View/registrate.php';
    }

    public function registrate(RegistrateRequest $request): void
    {
        $errors = $request->validateReg();

        if(empty($errors)) {
            $password = $request->getPassword();
            $name = $request->getName();
            $email = $request->getEmail();
            $password = password_hash($password, PASSWORD_DEFAULT);

            User::create($name, $email, $password);

            header("Location: /login");
        }

        require_once './../View/registrate.php';
    }

    public function getLogin()
    {
        require_once './../View/login.php';
    }
    public function login(LoginRequest $request)
    {
        $errors = $request->validateLog();

        if(empty($errors)) {
            $password = $request->getPassword();
            $email = $request->getEmail();

            $user = User::getOneByEmail($email);
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: /main");
        }
        require_once './../View/login.php';
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