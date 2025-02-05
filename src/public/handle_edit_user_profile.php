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


    if (empty($errors)) //(!(isset($errors))) // или лучше empty  //  нет ошибок, массив пуст => true
    {
        if (!(empty($data['name']))) // не пустой => true
        {
            $name = $_POST['name'];
            $statement = $pdo->prepare("UPDATE users SET name = :name WHERE id = {$_SESSION['user_id']}");
            $statement->execute([':name' => $name]);
        }

        if (!(empty($data['email'])))
        {
            $email = $_POST['email'];
            $statement = $pdo->prepare("UPDATE users SET email = :email WHERE id = {$_SESSION['user_id']}");
            $statement->execute([':email' => $email]);
        }

        if (!(empty($data['password'])))
        {
            $password = $_POST['password'];
            $statement = $pdo->prepare("UPDATE users SET password = :password WHERE id = {$_SESSION['user_id']}");
            $statement->execute([':password' => $password]);

        }


    }
}


function validate(array $data): array
{
    $errors = [];

    if (!(empty($data['name']))) // не пусто, имя ЕСТЬ => true
    {
        if (strlen($data['name']) < 3)
        {
            $errors['name'] = "Name {$data['name']} too short";
        }
    }

    if (!(empty($data['email'])))
    {
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

    if (!(empty($data['password'])))
    {
        if (!(empty($data['checkPassword'])))
        {
            if (!((strlen($data['password']) > 4 && strlen($data['password']) < 72) &&
                preg_match('/[A-Z]/', $data['password']) &&
                preg_match('/[a-z]/', $data['password']) &&
                preg_match('/[0-9]/', $data['password'])))
            {
                $errors['password'] = "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";

            } elseif ($data['checkPassword'] !== $data['password'])
            {
                $errors['password'] = "Пароли не совпадают";
            }
        }
    }
    return $errors;
}

require_once './edit_user_profile_form.php';
