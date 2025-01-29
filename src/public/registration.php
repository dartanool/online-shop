<?php
$pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

$pdo->exec("INSERT INTO users (name, email, password)  VALUES ('Ivan2','fwefwe','cdfvcsd')");
$statement =$pdo -> query("SELECT * FROM users WHERE name = 'Alex'");
$reuslt =  $statement -> fetchAll();
print_r($reuslt);
