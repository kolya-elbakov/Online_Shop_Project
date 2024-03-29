<?php

namespace Request;

use Elbakov\MyCore\Request\Request;
use Model\User;

class LoginRequest extends Request
{
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

            $user = User::getOneByEmail($email);

            if(empty($this->body)) {
                $errors['email'] = 'Пользователя не существует';
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