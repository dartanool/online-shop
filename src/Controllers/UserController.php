<?php
class UserController
{

    //Registration
    public function registrate() :void
    {
        $data = $_POST;
        $errors = $this->validateRegistration($data);

        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            $password = password_hash($password, PASSWORD_DEFAULT);

            $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $statement->execute([':name' => $name, ':email' => $email, ':password' => $password]);

            $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $statement->execute([':email' => $email]);

            $result = $statement->fetch();
        }
        require_once '../Views/registration_form.php';

    }

    public function getRegistrate() : void
    {
        session_status();
        if (isset($_SESSION['user_id'])) {
            header('Location: /catalog');
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
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $statement->execute(['email' => $data['email']]);

            if (!(empty($statement->fetch()))) {
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
            $username = $_POST['username'];
            $password = $_POST['password'];

            session_start();
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $statement->execute([':email' => $username]);

            $user = $statement->fetch();

            if ($user === false) {
                $errors = "username or password incorrect";
            } elseif ($username === $user['email']) {
                $passwordDb = $user['password'];
                if (password_verify($password, $passwordDb)) {

                    $_SESSION['user_id'] = $user['id'];
                    //setcookie('user_id', $user['id']);
                    header("Location: /catalog");

                } else {
                    $errors = "username or password incorrect";
                }
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
        session_status();
        if (isset($_SESSION['user_id'])) {
            header('Location: /catalog');
        }
        require_once './Views/login_form.php';
    }

//User_profile
    public function getProfile()
    {

        session_start();
        if (!(isset($_SESSION['user_id']))) {
            header('Location: login');
        } else {
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
            $statement = $pdo->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
            $user = $statement->fetch();
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
                $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

                $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
                $statement->execute(['email' => $data['email']]);

                if (!(empty($statement->fetch()))) {
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
        session_start();

        if (!(isset($_SESSION['user_id']))) {
            header('Location: login_form.php');
        } else {
            $data = $_POST;

            $errors = $this->validateEdit($data);

            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            if (empty($errors)) //(!(isset($errors))) // или лучше empty  //  нет ошибок, массив пуст => true
            {
                if (!(empty($data['name']))) // не пустой => true
                {
                    $name = $_POST['name'];
                    $statement = $pdo->prepare("UPDATE users SET name = :name WHERE id = {$_SESSION['user_id']}");
                    $statement->execute([':name' => $name]);
                }

                if (!(empty($data['email']))) {
                    $email = $_POST['email'];
                    $statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = {$_SESSION['user_id']}");
                    $statement->execute([':email' => $email]);
                }

                if (!(empty($data['password']))) {
                    $password = $_POST['password'];
                    $statement = $pdo->prepare("UPDATE users SET password = :password WHERE id = {$_SESSION['user_id']}");
                    $statement->execute([':password' => $password]);

                }
            }
            header('Location: /user-profile');
            exit;
        }
        require_once '../Views/edit_user_profile_form.php';
    }


    public function getEditProfile() : void
    {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
        }
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
        $statement = $pdo->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
        $user = $statement->fetch();

        require_once '../Views/edit_user_profile_form.php';
    }
}