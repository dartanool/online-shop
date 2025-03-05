<?php

namespace Controllers;

use Model\User;

class BaseController
{
    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getCurrentUserId() : int
    {
        $this->startSession();
        return $_SESSION['userId'];
    }

    public function check() : bool
    {
        $this->startSession();
        return isset($_SESSION['userId']);
    }

    public function auth(string $email, string $password) :bool
    {
//        $userModel = new User();
        $user = $this->userModel->getByEmail($email);

        if (!$user) {
            return false;
        } else {
            $passwordDb = $user->getPassword();
            if (password_verify($password, $passwordDb)) {
                $this->startSession();
                $_SESSION['userId'] = $user->getId();

                return true;
            } else {
                return false;
            }
        }
    }

    private function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}