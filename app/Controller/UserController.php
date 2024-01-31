<?php

namespace Controller;

use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;
use Service\AuthenticationService;

class UserController
{
    private AuthenticationService $authenticationService;

    public function __construct()
    {
        $this->authenticationService = new AuthenticationService();
    }

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
            $this->authenticationService->login($email, $password);

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

            $result = $this->authenticationService->login($email, $password);
            if($result){
                header("Location: /main");
            } else {
                $errors['email'] = 'Логин или пароль указан не верно';
            }
        }
        require_once './../View/login.php';
    }
}