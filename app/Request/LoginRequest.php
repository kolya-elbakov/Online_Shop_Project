<?php

namespace Request;

use Model\User;

class LoginRequest extends Request
{
    private User $modelUser;

    public function __construct(array $body)
    {
        parent::__construct($body);
        $this->modelUser = new User();
    }
    public function validateLog()
    {
        $errors = [];

        $email = $this->body['email'];
        if(empty($email)){
            $errors['email'] = 'Введите email';
        }

        $password = $this->body['password'];
        if(empty($password)) {
            $errors['password'] = 'Введите пароль';
        }

        if(empty($errors)) {
            $password = $this->getPassword();
            $email = $this->getEmail();

            $user = $this->modelUser->getOneByEmail($email);

            if(empty($this->body)) {
                $errors['email'] = 'Пользователя не существует';
            } elseif(!password_verify($password, $user['password'])) {
                $errors['password'] = 'Неверный логин или пароль';
            }
        }
        return $errors;
    }

    public function getPassword()
    {
        return $this->body['password'];
    }

    public function getEmail()
    {
        return $this->body['email'];
    }
}