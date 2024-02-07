<?php

namespace Controller;

use Core\Service\Authentication\AuthenticationInterface;
use Model\User;
use Request\LoginRequest;
use Request\RegistrateRequest;


class UserController
{
    private AuthenticationInterface $authenticationService;

    public function __construct(AuthenticationInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
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

    public function getLogin(): void
    {
        require_once './../View/login.php';
    }
    public function loginn(LoginRequest $request): void
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