<?php

namespace Core\Service\Authentication;

use Model\User;

interface AuthenticationInterface
{
    public function check(): bool;

    public function getCurrentUserId(): User|null;

    public function login(string $email, string $password): bool;

    public function logout(): void;
}