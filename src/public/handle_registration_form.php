<?php

function validate(array $data)
{
    $errors = [];

    if (isset($data['name'])) {
        $errors['name'] = validateName($data);
    } else {
        $errors['name'] = "Name is not filled";
    }

    if (isset($data['password']) && isset($data['check_password'])) {
        $password = $data['password'];
        $check_password = $data['check_password'];
        $errors['password'] = validatePassword($data);
    } else {
        $errors['password'] = "Password and Check_password are not filled";
    }

    if (isset($data['email'])) {
        $email = $data['email'];
        $errors['email'] = validateEmail($data);
    } else {
        $errors['email'] = "Email is not filled";
    }
    return $errors;
}

function validateName(array $data)
{
    if (strlen($data['name']) < 3) {
        return "Name {$data['name']} too short";
    } else {
        return  null;
    }
}


function validateEmail(array $data)
{
    if (!(filter_var($data['email'], FILTER_VALIDATE_EMAIL))) {
        return "Email {$data['email']} не валиден.";
    } else {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email'=>$data['email']]);

        if (!(empty($statement->fetch()))) {
            return "Email {$data['email']} already exists";
        } else return null;
    }
}

function validatePassword(array $data)
{
    if (!((strlen($data['password']) > 4 && strlen($data['password']) < 72) &&
        preg_match('/[A-Z]/', $data['password']) &&
        preg_match('/[a-z]/', $data['password']) &&
        preg_match('/[0-9]/', $data['password']) ))
    {
        return "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
    } elseif ($data['check_password'] !== $data['password']) {
        return  "Пароли не совпадают";
    } else {
        return null;
    }
}
$data = $_POST;
$errors = validate($data);
print_r($errors);

if (empty($errors)) {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $statement = $pdo->prepare("INSERT INTO users (name, email, password)  VALUES (:name, :email, :password)");
    $statement->execute(['name'=>$data['name'],'email'=>$data['email'], 'password'=>$data['password'],]);

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute(['email'=>$data['email']]);

    $result = $statement-> fetch();
    echo "<pre>";
    print_r($result);
    echo "</pre>";

}

require_once './registration_form.php';
