<?php
session_start();

//if (!(isset($_COOKIE['user_id']))){
//    header("Location: /login_form.php");
//}

if  (!(isset($_SESSION['user_id']))){
    header('Location: login_form.php');
} else {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $statement = $pdo->query("SELECT * FROM products");

    $products = $statement->fetchAll();

    require_once "./catalog/catalog_page.php";
}

