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

    public function getByProductId(int $productId) : array | false
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');


        $statement = $pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $statement->execute([':productId' => $productId]);

        $data = $statement->fetch();

        return $data;
    }
}