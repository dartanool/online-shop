<?php

$errors =[];
$errors = validate($_POST);

if (empty($errors))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    session_start();
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute([':email'=> $username]);

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
            header("Location: /catalog.php");

        } else {
            $errors = "username or password incorrect";
        }
    } else {
        $errors = "username or password incorrect";
    }
}
function validate(array $data) : array | string
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

require_once './login_form.php';
