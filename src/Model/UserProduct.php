<?php
namespace Model;

class UserProduct extends \Model\Model
{
    private int $id;
    private int $userId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $totalSum;

    protected function getTableName() : string
    {
        return 'user_products';
    }
    public function getAllUserProductsByUserId(int $id) : array | null
    {

        $statement = $this->pdo->query("SELECT * FROM {$this->getTableName()} WHERE user_id = {$id}");

        $orders = $statement->fetchAll();

        if ($orders === false) {
            return null;
        }

        $objs = [];

        foreach ($orders as $order) {
            $obj = $this->createObject($order);
            $objs[] = $obj;
        }

        return $objs;
    }

    public function getByUserIdProductId(int $userId, int $productId) : self | null
    {

        $statement = $this->pdo->prepare(
            "SELECT * FROM {$this->getTableName()} WHERE product_id = :productId AND user_id =:userId");
        $statement->execute(['productId' => $productId, 'userId' => $userId]);

        $data = $statement->fetch();

        if ($data === false) {
            return null;
        }
        $obj = $this->createObject($data);

        return $obj;
    }

    public function insertByIdProductIdAmount(int $userId, int $productId, int $amount) : void
    {

        $statement = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (user_id, product_id, amount) VALUES ($userId, :product_id, :amount)");
        $statement->execute(['product_id' => $productId, 'amount' => $amount]);
    }

    public function updateAmountByUserIdProductId(int $userId, int $productId, int $amount) : void
    {

        $statement = $this->pdo->prepare(
            "UPDATE {$this->getTableName()} SET amount = :amount WHERE user_id =:userId and product_id = :product_id");
        $statement->execute(['amount' => $amount, 'userId' => $userId, 'product_id' => $productId]);
    }

    public function deleteByUserId(int $userId) : void
    {
        $statement = $this->pdo->prepare("DELETE FROM {$this->getTableName()} WHERE user_id = :userId");
        $statement->execute(['userId' => $userId]);
    }


    public function decreaseByUserIdProductId(int $userId, int $productId) : void
    {
        $statement = $this->pdo->query(
            "DELETE FROM {$this->getTableName()} WHERE user_id = {$userId} AND product_id = {$productId}");

    }

    private function createObject(array $data) : UserProduct
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }
    public function setTotalSum(int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }

    public function getTotalSum(): int
    {
        return $this->totalSum;
    }
}