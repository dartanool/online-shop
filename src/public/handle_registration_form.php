<?php
$errors = [];

if (isset($_POST['name'])) {
    $name = $_POST['name'];
    $nameError = validateName($name);
    if ($nameError) {
        $errors['name'] = $nameError;
    }
} else {
    $errors['name'] = "Name is not filled";
}


if (isset($_POST['password']) && isset($_POST['check_password'])) {
    $password = $_POST['password'];
    $check_password = $_POST['check_password'];
    $passwordError = validatePassword($password, $check_password);
    if ($passwordError) {
        $errors['password'] = $passwordError;
    }
} else {
    $errors['password'] = "Password and Check_password are not filled";
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $emailError = validateEmail($email);
    if ($emailError) {
        $errors['email'] = $emailError;
    }
} else {
    $errors['email'] = "Email is not filled";
}

function validateName($name) {
    if (strlen($name) < 3) {
        return "Name '$name' too short";
    } else {
        return  null;
    }
}

function validateEmail($email)
{
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        return "Email '$email' не валиден.";
    } else {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $statement->execute(['email'=>$email]);

        if (!(empty($statement->fetch()))) {
            return "Email '$email' already exists";
        } else return null;
    }
}

function validatePassword($password, $check_password)
{
    if (!((strlen($password) > 4 && strlen($password) < 72) &&
        preg_match('/[A-Z]/', $password) &&
        preg_match('/[a-z]/', $password) &&
        preg_match('/[0-9]/', $password) ))
    {
        return "Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
    } elseif ($check_password !== $password) {
        return  "Пароли не совпадают";
    } else {
        return null;
    }
}

if (empty($errors)) {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $password = password_hash($password, PASSWORD_DEFAULT);

    $statement = $pdo->prepare("INSERT INTO users (name, email, password)  VALUES (:name, :email, :password)");
    $statement->execute(['name'=>$name,'email'=>$email, 'password'=>$password]);

    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $statement->execute(['email'=>$email]);

    $result = $statement-> fetch();
    echo "<pre>";
    print_r($result);
    echo "</pre>";

}

require_once './registration_form.php';
