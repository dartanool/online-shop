<?php
session_start();


if  (!(isset($_SESSION['user_id']))){
    header('Location: login_form.php');
} else {
    $data = $_POST;

    $errors = validate($data);

    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
    $statement = $pdo->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
    $user = $statement->fetch();

// а можно ли user не находить, но чтобы в форме все равно он отображался


    if (isset($errors)) // или лучше empty
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (isset($name))
        {
            $statement = $pdo->prepare("UPDATE users SET name = :name WHERE id = {$_SESSION['user_id']}");
            $statement->execute([':name' => $name]);
        }

        if (isset($email))
        {
            $statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = {$_SESSION['user_id']}");
            $statement->execute([':email' => $email]);
        }

        if (isset($password))
        {
            $statement = $pdo->prepare("UPDATE users SET password = :password WHERE id = {$_SESSION['user_id']}");
            $statement->execute([':password' => $password]);
        }
        require_once './edit_user_profile_form.php';

    }
}


function validate(array $data): array
{
    $errors = [];

    if (!(isset($data['name']))) {
        $errors['name'] = "Name is not filled";
    } elseif (strlen($data['name']) < 3)
    {
        $errors['name'] = "Name {$data['name']} too short";
    }

    if (!(isset($data['password']))) {
        $errors['password'] = "Password is not filled";
    } elseif (!(isset($data['checkPassword']))){
        $errors['password'] = "Confirm password is not filled";
    } elseif (!((strlen($data['password']) > 4 && strlen($data['password']) < 72) &&
        preg_match('/[A-Z]/', $data['password']) &&
        preg_match('/[a-z]/', $data['password']) &&
        preg_match('/[0-9]/', $data['password']) ))
    {
        $errors['password'] = "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
    } elseif ($data['checkPassword'] !== $data['password'])
    {
        $errors['password'] = "Пароли не совпадают";
    }

    if (!(isset($data['email'])))
    {
        $errors['email'] = "Email is not filled";


    } elseif (!(filter_var($data['email'], FILTER_VALIDATE_EMAIL)))
    {
        $errors['email'] = "Email {$data['email']} не валиден.";
    } else {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email'=>$data['email']]);

        if (!(empty($statement->fetch())))
        {
            $errors['email'] = "Email {$data['email']} already exists";
        }
    }

    return $errors;
}

