<?php

namespace Service\Auth;

use Model\User;

class AuthCookieService implements AuthInterface
{
    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getCurrentUser() : User | null
    {
        if ( $this->check()) {
            $userId = $_COOKIE['userId'];

            return $this->userModel->getById($userId);
        }else{
            return null;
        }
    }

    public function check() : bool
    {
        return isset($_COOKIE['userId']);
    }

    public function auth(string $email, string $password) :bool
    {
        $user = $this->userModel->getByEmail($email);

        if (!$user) {
            return false;
        } else {
            $passwordDb = $user->getPassword();
            if (password_verify($password, $passwordDb)) {
                setcookie('userId', $user->getId());
                return true;
            } else {
                return false;
            }
        }
    }

    public function logout()
    {
        setcookie('userId', '', time() - 3600, '/');
        unset($_COOKIE['userId']);
    }

}