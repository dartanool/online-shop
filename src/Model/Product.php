<?php
class Product
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
    }
    public function getById() : array
    {

        $statement = $this->pdo->query("SELECT * FROM products");

        $products = $statement->fetchAll();

        return $products;
    }

    public function getByProductId(int $productId) : array | false
    {

        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $statement->execute([':productId' => $productId]);

        $data = $statement->fetch();

        return $data;
    }
}