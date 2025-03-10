<?php
namespace Controllers;

use Model\User;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;

class UserController extends BaseController
{
    protected User $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();

    }

    //Registration
    public function registrate(RegistrateRequest $request) :void
    {
        $errors = $request->validateRegistration();

        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();

            $password = password_hash($password, PASSWORD_DEFAULT);

            $this->userModel->insertNameEmailPassword($name, $email, $password);

        }
        require_once '../Views/registration_form.php';

    }

    public function getRegistrate() : void
    {
        if ($this->authService->check()) {
            require '../Views/registration_form.php';

//            header('Location: /catalog');
            exit();
        }
        require '../Views/registration_form.php';
    }

    //Login
    public function login(LoginRequest $request) : void
    {
        $errors = [];
        $errors = $request->validateLogin();

        if (empty($errors)) {
            $result = $this->authService->auth($request->getName(), $request->getPassword());

            if ($result) {
                header("Location: /catalog");
                exit;
            } else {
                $errors = "username or password incorrect";

            }
        }
        require_once '../Views/login_form.php';
    }



    public function getLogin()
    {
        if ($this->authService->check()) {
            header('Location: /catalog');
        }
        require_once '../Views/login_form.php';
    }


//User_profile
    public function getProfile()
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {

            $userId = $this->authService->getCurrentUser()->getId();
            $user = $this->userModel->getById($userId);
        }
        require_once '../Views/user_profile_page.php';
    }


//Edit Profile
    public function editProfile(EditProfileRequest $request) : void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {

            $errors = $request->validateEdit();

            if (empty($errors)) //(!(isset($errors))) // или лучше empty  //  нет ошибок, массив пуст => true
            {
                $user = $this->authService->getCurrentUser();

                if (!(empty($request->getName()))) // не пустой => true
                {
                    $name = $request->getName();
                    $this->userModel->updateNameById($name, $user->getId());

                }

                if (!(empty($request->getEmail()))) {
                    $email = $request->getEmail();
                    $this->userModel->updateEmailById($email, $user->getId());
                }

                if (!(empty($request->getPassword()))) {
                    $password = $request->getPassword();
                    $this->userModel->updatePasswordById($password, $user->getId());
                }
                header('Location: /user-profile');
                exit;
            }

        }
        $userId = $this->authService->getCurrentUser()->getId();
        $user = $this->userModel->getById($userId);
        require_once '../Views/edit_user_profile_form.php';
    }


    public function getEditProfile() : void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
        }

        $user = $this->userModel->getById($this->authService->getCurrentUser()->getId());

        require_once '../Views/edit_user_profile_form.php';
    }

//logout
    public function logout(): void
    {
        $this->authService->logout();
        header('Location: /login');
        exit();
    }

}