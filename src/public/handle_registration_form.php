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
        return false;
    }
}

if (validateEmail($email)) {
    if ($check_password == $password) {
        $pdo->exec("INSERT INTO users (name, email, password)  VALUES ('$name', '$email', '$password')");
        $statement =$pdo -> query("SELECT * FROM users ORDER BY id DESC LIMIT 1 ");
        $result = $statement-> fetch();
        print_r($result);
    } else {
        echo "Пароли не совпадают";
    }
} else {
    echo "Email '$email' не валиден.";
}

