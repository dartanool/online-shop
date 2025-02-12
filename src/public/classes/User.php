<?php
class User
{
    //Registration
    public function registrate()
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
        require_once './pages/registration_form.php';

    }
    public function getRegistrate(){
        session_status();
        if (isset($_SESSION['user_id'])){
            header('Location: /catalog');
        }
        require './pages/registration_form.php';
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
    public function login()
    {
        $errors = [];
        $errors = $this->validateLogin($_POST);

        if (empty($errors))
        {
            $username = $_POST['username'];
            $password = $_POST['password'];

            session_start();
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $statement->execute([':email' => $username]);

            $user = $statement->fetch();

            if ($user === false)
            {
                $errors = "username or password incorrect";
            } elseif ($username === $user['email'])
            {
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
        require_once './pages/login_form.php';
    }
    private function validateLogin(array $data) : array
    {
        $errors = [];
        if (!(isset($data['username'])))
        {
            $errors = "username incorrect";
        }
        if (!(isset($data['password'])))
        {
            $errors = "password incorrect";
        }

        return $errors;
    }

    public function getLogin(){
        session_status();
        if (isset($_SESSION['user_id'])){
            header('Location: /catalog');
        }
        require_once './pages/login_form.php';
    }

//User_profile
    public function getProfile(){

        session_start();
        if (!(isset($_SESSION['user_id']))) {
            header('Location: login');
        } else {
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
            $statement = $pdo->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
            $user = $statement->fetch();
        }

        require_once './pages/user_profile_page.php';
    }


}