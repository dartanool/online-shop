<?php
namespace Model;
class Product extends \Model\Model
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