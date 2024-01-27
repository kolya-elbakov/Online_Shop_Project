<?php

namespace Service;

use Model\User;

class AuthenticationService
{
    public function check(): bool
    {
        session_start();

        return isset($_SESSION['user_id']);
    }

    public function getCurrentUserId(): int|null
    {
//        session_start();
        if(!isset($_SESSION['user_id'])){
            return null;
        }
        return $_SESSION['user_id'];
    }

    public function login(string $email, string $password): bool
    {
        $user = User::getOneByEmail($email);
        if(!$user){
            return false;
        }
        if(!password_verify($password, $user->getPassword())) {
            return false;
        }
        session_start();
        $_SESSION['user_id'] = $user->getId();

        return true;
    }
}