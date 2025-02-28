<?php
namespace Model;

class UserProduct extends \Model\Model
{
    public function getById(int $id) : array
    {

        $statement = $this->pdo->query("SELECT * FROM user_products WHERE user_id = {$id}");

        $orders = $statement->fetchAll();

        return $orders;
    }

    public function getByUserIdProductId(int $userId, int $productId) : array | false
    {

        $statement = $this->pdo->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id =:userId");
        $statement->execute(['productId' => $productId, 'userId' => $userId]);

        $data = $statement->fetch();

        return $data;
    }

    public function insertByIdProductIdAmount(int $userId, int $productId, int $amount) : void
    {

        $statement = $this->pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES ($userId, :product_id, :amount)");
        $statement->execute(['product_id' => $productId, 'amount' => $amount]);
    }

    public function updateByIdProductIdAmount(int $userId, int $productId, int $amount) : void
    {

        $statement = $this->pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id =:userId and product_id = :product_id");
        $statement->execute(['amount' => $amount, 'userId' => $userId, 'product_id' => $productId]);
    }

    public function deleteByUserId(int $userId)
    {
        $statement = $this->pdo->prepare("DELETE FROM user_products WHERE user_id = :userId");
        $statement->execute(['userId' => $userId]);
    }
}