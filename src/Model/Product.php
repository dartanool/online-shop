<?php
class Product
{

    public function getById() : array
    {
        require  "../../database.php";

        $statement = $pdo->query("SELECT * FROM products");

        $products = $statement->fetchAll();

        return $products;
    }

    public function getByProductId(int $productId) : array | false
    {

        $statement = $pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $statement->execute([':productId' => $productId]);

        $data = $statement->fetch();

        return $data;
    }
}