<?php
namespace Model;
class Product extends \Model\Model
{
    private int $id;
    private string $name;
    private int $price;
    private string|null $description;
    private string|null  $image_url;

    protected static function getTableName(): string
    {
        return 'products';
    }
    public static function getById() : array | null
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->query("SELECT * FROM $tableName");

        $products = $statement->fetchAll();

        if ($products === false) {
            return null;
        }

        $objs = [];
        foreach ($products as $product) {
            $objs[] = static::createObject($product);
        }
        return $objs;
    }

    public static function getByProductId(int $productId) : self | null
    {

        $tableName = static::getTableName();
        $statement = static::getPDO()->prepare("SELECT * FROM $tableName WHERE id = :productId");
        $statement->execute([':productId' => $productId]);

        $data = $statement->fetch();

        if ($data === false){
            return null;
        }
        return static::createObject($data);
    }

    public static function createObject(array $data) : self
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->name = $data['name'];
        $obj->price = $data['price'];
        $obj->description = $data['description'];
        $obj->image_url = $data['image_url'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }

    public function getImageUrl(): string|null
    {
        return $this->image_url;
    }


}