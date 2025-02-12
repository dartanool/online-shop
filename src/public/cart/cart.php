<?php
session_start();

if  (!(isset($_SESSION['user_id']))){
    header('Location: login_form.php');
} else {
    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $statement = $pdo->query("SELECT * FROM user_products WHERE user_id = {$_SESSION['user_id']}");

    $orders = $statement->fetchAll();


    $count = 0;
    foreach ($orders as $order) {
        $productId = $order['product_id'];

        $productsStatement = $pdo->query("SELECT * FROM products WHERE id = {$productId}");
        $products[$count]= $productsStatement->fetch();
        $products[$count]['amount'] = $order['amount'];
        $count++;
    }

    require_once "./cart/cart_page.php";
}

