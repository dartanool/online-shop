<?php

function validate(array $data): array
{
    $errors = [];

    if (!(isset($data['name']))) {
        $errors['name'] = "Name is not filled";
    } elseif (strlen($data['name']) < 3)
    {
        $errors['name'] = "Name {$data['name']} too short";
    }

    if (!(isset($data['password']) && isset($data['check_password'])))
    {
        $errors['password'] = "Password and Check_password are not filled";

    } elseif (!((strlen($data['password']) > 4 && strlen($data['password']) < 72) &&
        preg_match('/[A-Z]/', $data['password']) &&
        preg_match('/[a-z]/', $data['password']) &&
        preg_match('/[0-9]/', $data['password']) ))
    {
        $errors['password'] = "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
    } elseif ($data['check_password'] !== $data['password'])
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

$data = $_POST;
$errors = validate($data);

if (empty($errors))
{
    $name = $_POST['name'];
    $email = $_POST['mail'];
    $password = $_POST['password'];
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $statement = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $statement->execute([':name' => $name, ':email' => $email, ':password' => $password]);

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute([':email' => $email]);

    $result = $statement-> fetch();
    echo "<pre>";
    print_r($result);
    echo "</pre>";

}

require_once './registration_form.php';
