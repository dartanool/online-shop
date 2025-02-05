<?php
session_start();

if  (!(isset($_SESSION['user_id']))){
    header('Location: login_form.php');
} else {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
    $statement = $pdo->query("SELECT * FROM users WHERE id = {$_SESSION['user_id']}");
    $user = $statement->fetch();
}





require_once './user_profile_page.php';