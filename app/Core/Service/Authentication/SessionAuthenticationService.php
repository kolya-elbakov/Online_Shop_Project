<?php

namespace Core\Service\Authentication;

use Model\User;

class SessionAuthenticationService implements AuthenticationInterface
{
    private User $user;

    public function check(): bool
    {
        session_start();

        return isset($_SESSION['user_id']);
    }

    public function getCurrentUserId(): User|null
    {
        if (isset($this->user))
        {
            return $this->user;
        }

        if(!isset($_SESSION))
        {
            session_start();
        }
        if (isset($_SESSION['user_id']))
        {
            $this->user = User::getById($_SESSION['user_id']);
            return $this->user;
        }
        return null;
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

    public function logout(): void
    {
        $res = self::check();
        if($res) {
            session_destroy();
            header('Location: /login');
        }
    }
}