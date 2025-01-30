<?php
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['password'];
$check_password = $_GET['check_password'];

function validateEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        echo "Email '$email' не валиден.";
    }
}
function validatePassword($password, $check_password)
{
    if ((strlen($password) > 4 || strlen($password) < 72) ||
        (preg_match('/[A-Z]/', $password) ||
        preg_match('/[a-z]/', $password) ||
        preg_match('/[0-9]/', $password) ))
    {
        if ($check_password == $password) {
            return true;
        } else {
            echo "Пароли не совпадают";
        }
    } else {
        echo "Некорректный пароль.
             Пароль должен содержать от 4 до 72 символов, хотя бы одну строчную букву, хотя бы одну заглавную букву, хотя бы одну цифру.";
    }
}

if (validateEmail($email)) {
    if (validatePassword($password, $check_password)) {
        $pdo->exec("INSERT INTO users (name, email, password)  VALUES ('$name', '$email', '$password')");
        $statement =$pdo -> query("SELECT * FROM users ORDER BY id DESC LIMIT 1 ");
        $result = $statement-> fetch();
        print_r($result);
    }
}

