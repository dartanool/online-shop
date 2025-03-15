<?php

namespace Service\Auth;

use Model\User;

interface AuthInterface
{
    public function getCurrentUser() : User | null;

    public function check() : bool;

    public function auth(string $email, string $password) :bool;

    public function logout();

}