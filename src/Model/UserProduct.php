<?php

class Cart
{
    public function getById(int $id) : array
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $statement = $pdo->query("SELECT * FROM user_products WHERE user_id = {$id}");

        $orders = $statement->fetchAll();

        return $orders;
    }

    public function getByProductId(int $productId) : array
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $productsStatement = $pdo->query("SELECT * FROM products WHERE id = {$productId}");
        $order = $productsStatement->fetch();

        return $order;
    }

}