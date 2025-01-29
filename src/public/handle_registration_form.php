<?php
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['password'];
$check_password = $_GET['check_password'];

$pdo->exec("INSERT INTO users (name, email, password)  VALUES ('$name', '$email', '$password')");
$statement =$pdo -> query("SELECT * FROM users ORDER BY id DESC LIMIT 1 ");
$result = $statement-> fetch();
print_r($result);