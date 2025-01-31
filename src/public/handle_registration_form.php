<?php
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
$errors = [];

if (isset($_GET['name'])) {
    $name = $_GET['name'];
    $errors['name'] = validateName($name);
} else {
    $errors['name'] = "Name is not filled";
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $errors['email'] = validateEmail($email);
} else {
    $errors['email'] = "Email is not filled";
}

if (isset($_GET['password']) && isset($_GET['check_password'])) {
    $password = $_GET['password'];
    $check_password = $_GET['check_password'];
    $errors['password'] = validatePassword($password, $check_password);
} else {
    $errors['password'] = "Password and Check_password are not filled";
}

function validateName($name) {
    if (strlen($name) < 3) {
        return "Name '$name' too short";
    }
}

function validateEmail($email)
{
    if (!(filter_var($email, FILTER_VALIDATE_EMAIL))) {
        return "Email '$email' не валиден.";
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
    }
}

if (empty($errors)) {
        $pdo->exec("INSERT INTO users (name, email, password)  VALUES ('$name', '$email', '$password')");
        $statement =$pdo -> query("SELECT * FROM users ORDER BY id DESC LIMIT 1 ");
        $result = $statement-> fetch();
        print_r($result);

}

require_once './registration_form.php';
