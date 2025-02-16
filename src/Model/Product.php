<?php
class Product
{
    public function getById() : array
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $statement = $pdo->query("SELECT * FROM products");

        $products = $statement->fetchAll();

        return $products;
    }
}