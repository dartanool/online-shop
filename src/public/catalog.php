<?php
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

$statement = $pdo->query("SELECT * FROM products");

$products = $statement->fetchAll();

if (!(isset($_COOKIE['user_id']))){
    header('Location: /login_form.php');
}

require_once "./catalog_page.php";
