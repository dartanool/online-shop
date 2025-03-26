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

    protected static function getTableName() : string
    {
        return 'user_products';
    }
    public static function getAllByUserId(int $id) : array | null
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->query("SELECT * FROM $tableName WHERE user_id = {$id}");

        $orders = $statement->fetchAll();

        if ($orders === false) {
            return null;
        }

        $objs = [];

        foreach ($orders as $order) {
            $obj = static::createObject($order);
            $objs[] = $obj;
        }

        return $objs;
    }

    public static function getAllByUserIdWithProducts(int $id) : array | null
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->query("SELECT * FROM $tableName up
                                                INNER JOIN products p ON up.product_id = p.id WHERE user_id = {$id} ");

        $userProducts = $statement->fetchAll();

        if ($userProducts === false) {
            return null;
        }

        $objs = [];

        foreach ($userProducts as $userProduct) {
            $obj = static::createObject($userProduct);
            $objs[] = $obj;
        }

        return $objs;
    }

    public static function getByUserIdProductId(int $userId, int $productId) : self | null
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare(
                                      "SELECT * FROM $tableName
                                            WHERE product_id = :productId AND user_id =:userId");

        $statement->execute(['productId' => $productId, 'userId' => $userId]);

        $data = $statement->fetch();

        if ($data === false) {
            return null;
        }
        $obj = static::createObject($data);

        return $obj;
    }

    public static function insertByIdProductIdAmount(int $userId, int $productId, int $amount) : void
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare(
            "INSERT INTO $tableName (user_id, product_id, amount) VALUES ($userId, :product_id, :amount)");
        $statement->execute(['product_id' => $productId, 'amount' => $amount]);
    }

    public static function updateAmountByUserIdProductId(int $userId, int $productId, int $amount) : void
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare(
            "UPDATE $tableName SET amount = :amount WHERE user_id =:userId and product_id = :product_id");
        $statement->execute(['amount' => $amount, 'userId' => $userId, 'product_id' => $productId]);
    }

    public static function deleteByUserId(int $userId) : void
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare("DELETE FROM $tableName WHERE user_id = :userId");
        $statement->execute(['userId' => $userId]);
    }


    public static function decreaseByUserIdProductId(int $userId, int $productId) : void
    {
        $tableName = static::getTableName();
        $statement = static::getPDO()->query(
            "DELETE FROM $tableName WHERE user_id = {$userId} AND product_id = {$productId}");

    }

    private static function createObject(array $data) : UserProduct
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->userId = $data['user_id'];
        $obj->productId = $data['product_id'];
        $obj->amount = $data['amount'];

        if (isset($data['name'])){
            $productData = [
                'id' => $data['product_id'],
                'name' => $data['name'],
                'description' => $data['description'],
                'price' => $data['price'],
                'image_url' => $data['image_url']
            ];

            $product = Product::createObject($productData);
            $obj->setProduct($product);
        }


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