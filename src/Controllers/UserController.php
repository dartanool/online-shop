<?php
namespace Controllers;

use Model\User;

class UserController extends BaseController
{
    protected User $userModel;
    public function __construct()
    {
        parent::__construct();
        $this->userModel = new User();

    }

    //Registration
    public function registrate() :void
    {
        $data = $_POST;
        $errors = $this->validateRegistration($data);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

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

    private function validateRegistration(array $data): array
    {
        $errors = [];

        if (!(isset($data['name']))) {
            $errors['name'] = "Name is not filled";
        } elseif (strlen($data['name']) < 3) {
            $errors['name'] = "Name {$data['name']} too short";
        }

        if (!(isset($data['password']))) {
            $errors['password'] = "Password is not filled";
        } elseif (!(isset($data['check_password']))) {

            $errors['password'] = "Check_password is not filled";

        } elseif (!((strlen($data['password']) > 4 && strlen($data['password']) < 72) &&
            preg_match('/[A-Z]/', $data['password']) &&
            preg_match('/[a-z]/', $data['password']) &&
            preg_match('/[0-9]/', $data['password']))) {
            $errors['password'] = "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
        } elseif ($data['check_password'] !== $data['password']) {
            $errors['password'] = "Пароли не совпадают";
        }

        if (!(isset($data['email']))) {
            $errors['email'] = "Email is not filled";
        } elseif (!(filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
            $errors['email'] = "Email {$data['email']} не валиден.";
        } else {

            $statement = $this->userModel->getByEmail($data['email']);

            if (!(empty($statement))) {
                $errors['email'] = "Email {$data['email']} already exists";
            }
        }
        return $errors;
    }


    //Login
    public function login() : void
    {
        $errors = [];
        $errors = $this->validateLogin($_POST);

        if (empty($errors)) {
            $result = $this->authService->auth($_POST['username'], $_POST['password']);

            if ($result) {
                header("Location: /catalog");
                exit;
            } else {
                $errors = "username or password incorrect";

            }
        }
        require_once '../Views/login_form.php';
    }

    private function validateLogin(array $data): array
    {
        $errors = [];
        if (!(isset($data['username']))) {
            $errors = "username incorrect";
        }
        if (!(isset($data['password']))) {
            $errors = "password incorrect";
        }

        return $errors;
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

    private function validateEdit(array $data): array
    {
        $errors = [];

        if (!(empty($data['name']))) // не пусто, имя ЕСТЬ => true
        {
            if (strlen($data['name']) < 3) {
                $errors['name'] = "Name {$data['name']} too short";
            }
        }

        if (!(empty($data['email']))) {
            if (!(filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
                $errors['email'] = "Email {$data['email']} не валиден.";
            } else {

                $statement= $this->userModel->getByEmail($data['email']);

                if (!empty($statement)) {
                    $errors['email'] = "Email {$data['email']} already exists";
                }
            }
        }

        if (!(empty($data['password']))) {
            if (!(empty($data['checkPassword']))) {
                if (!((strlen($data['password']) > 4 && strlen($data['password']) < 72) &&
                    preg_match('/[A-Z]/', $data['password']) &&
                    preg_match('/[a-z]/', $data['password']) &&
                    preg_match('/[0-9]/', $data['password']))) {
                    $errors['password'] = "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";

                } elseif ($data['checkPassword'] !== $data['password']) {
                    $errors['password'] = "Пароли не совпадают";
                }
            }
        }
        return $errors;
    }

    public function editProfile() : void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {
            $data = $_POST;

            $errors = $this->validateEdit($data);

            if (empty($errors)) //(!(isset($errors))) // или лучше empty  //  нет ошибок, массив пуст => true
            {
                $user = $this->authService->getCurrentUser();

                if (!(empty($data['name']))) // не пустой => true
                {
                    $name = $_POST['name'];
                    $this->userModel->updateNameById($name, $user->getId());

                }

                if (!(empty($data['email']))) {
                    $email = $_POST['email'];
                    $this->userModel->updateEmailById($email, $user->getId());
                }

                if (!(empty($data['password']))) {
                    $password = $_POST['password'];
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
        parent::logout();
        header('Location: /login');
        exit();
    }
}