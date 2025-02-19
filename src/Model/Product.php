<?php
require_once "../Model/Model.php";
class Product extends Model
{
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