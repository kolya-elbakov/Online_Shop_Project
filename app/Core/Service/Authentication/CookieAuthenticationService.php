<?php

namespace Core\Service\Authentication;

use Model\User;

class CookieAuthenticationService implements AuthenticationInterface
{
    private User $user;

    public function check(): bool
    {
        return isset($_COOKIE['user_id']);
    }

    public function getCurrentUserId(): User|null
    {
        if (isset($this->user)) {
            return $this->user;
        }

        if (isset($_COOKIE['user_id'])) {
            $this->user = User::getById($_COOKIE['user_id']);
            return $this->user;
        }

        return null;
    }

    public function login(string $email, string $password): bool
    {
        $user = User::getOneByEmail($email);
        if (!$user) {
            return false;
        }
        if (!password_verify($password, $user->getPassword())) {
            return false;
        }

        setcookie('user_id', $user->getId(), time() + 7200, '/');

        return true;
    }

    public function logout(): void
    {
        $res = self::check();
        if ($res) {
            setcookie('user_id', '', time() - 7200, '/');
            header('Location: /login');
        }
    }
}