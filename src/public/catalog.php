<?php
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

$statement = $pdo->query("SELECT * FROM products");

$products = $statement->fetchAll();



require_once "./catalog_page.php";
