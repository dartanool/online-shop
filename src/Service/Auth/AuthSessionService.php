<?php

namespace Service\Auth;

use Model\User;

class AuthSessionService implements AuthInterface
{
    protected User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getCurrentUser() : User | null
    {
        $this->startSession();
        if ( $this->check()) {
            $userId = $_SESSION['userId'];

            return $this->userModel->getById($userId);
        }else{
            return null;
        }
    }

    public function check() : bool
    {
        $this->startSession();
        return isset($_SESSION['userId']);
    }

    public function auth(string $email, string $password) :bool
    {
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

    public function logout()
    {
        $this->check();
        session_destroy();
    }

    private function startSession()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }
}