<?php
namespace Model;
class Product extends \Model\Model
{
    private int $id;
    private string $name;
    private int $price;
    private string|null $description;
    private string|null  $image_url;
    private int $totalSum;
    public function getById() : array | null
    {

        $statement = $this->pdo->query("SELECT * FROM products");

        $products = $statement->fetchAll();

        if ($products === false) {
            return null;
        }

        $objs = [];
        foreach ($products as $product) {
            $objs[] = $this->createObject($product);
        }
        return $objs;
    }

    public function getByProductId(int $productId) : self | null
    {

        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :productId");
        $statement->execute([':productId' => $productId]);

        $data = $statement->fetch();

        if ($data === false){
            return null;
        }
        return $this->createObject($data);
    }

    private function createObject(array $data) : self
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

    public function setTotalSum(int $totalSum): void
    {
        $this->totalSum = $totalSum;
    }

    public function getTotalSum(): int
    {
        return $this->totalSum;
    }
}