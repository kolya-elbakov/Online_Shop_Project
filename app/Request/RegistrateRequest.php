<?php

namespace Request;

use Core\Request\Request;
use Model\User;

class RegistrateRequest extends Request
{
    public function validateReg()
    {
        $errors = [];

        $name = $this->body['name'];
        if(strlen($name) < 2) {
            $errors['name']= 'Имя указано неверно';
        }

        $email = $this->body['email'];
        if(strlen($email) < 4) {
            $errors['email']= 'Email указан неверный';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email должен содержать @';
        } else {
            $data1 = User::getOneByEmail($email);
            if($data1){
                $errors['email'] = 'Email уже используется';
            }
        }

        $password = $this->body['psw'];
        if(strlen($password) < 8) {
            $errors['password'] = 'Пароль должен быть не менее 8 символов';
        }

        $psw_repeat = $this->body['psw-repeat'];
        if ($psw_repeat !== $password){
            $errors['repeat-psw'] = 'Пароли не совпадают';
        }
        return $errors;
    }

    public function getName()
    {
        return $this->body['name'];
    }

    public function getEmail()
    {
        return $this->body['email'];
    }

    public function getPassword()
    {
        return $this->body['psw'];
    }
}