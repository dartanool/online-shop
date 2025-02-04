<?php
session_start();
$username = $_POST['username'];
$password = $_POST['password'];

$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

$statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
$statement->execute([':email'=> $username]);

$user = $statement->fetch();

if ($user === false) {
    $errors = "username doesn't exist";
} else {
    $errors =validation($username, $password, $user);
}

function validation($username, $password, array $user){
    if (!(isset($username) && isset($password))){
        return "username or password incorrect";
    } elseif ($user === false){
        return "username or password incorrect";
    } elseif ($username === $user['email']) {
        $password_DB = $user['password'];
        if (!(password_verify($password, $password_DB))) {
            return "username or password incorrect";
        } else {
//            setcookie('user_id', $user['id']);
            $_SESSION['user_id'] = $user['id'];
            header("Location: /catalog.php");
            require_once './catalog.php';
        }
    }
}

require_once './login_form.php';
