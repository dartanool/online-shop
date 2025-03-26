<?php

namespace Model;

use DTO\OrderCreateDTO;

class Order extends \Model\Model
{
    private int $id;
    private string $contact_name;
    private string $contact_phone;
    private string|null $comment;
    private int $userId;
    private string $address;
    private int $sum;
    private Product $product;
    private array $orderProducts;

    protected function getTableName(): string
    {
        return 'orders';
    }
    public function create(string $name, string $phone, string $comment, string $address, int $userId): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->getTableName()} (contact_name, contact_phone, comment, user_id, address)
                    VALUES (:name, :phone, :comment, :user_id, :address) RETURNING id"
        );
        $stmt->execute([
            'name' => $name,
            'phone' => $phone,
            'comment' => $comment,
            'address' => $address,
            'user_id' => $userId
        ]);
        $dataId = $stmt->fetch();
        return $dataId['id'];
    }

    public function getAllByUserId($userId): array|null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        $orders = $stmt->fetchAll();

        if ($orders === false){
            return null;
        }


        $objs = [];
        foreach ($orders as $order)
        {
            $objs[] = $this->createObject($order);
        }

        return $objs;
    }

    private function createObject(array $data) : self
    {
        $obj = new self ();

//        print_r($data);

        $obj->id = $data['id'];
        $obj->contact_name = $data['contact_name'];
        $obj->contact_phone = $data['contact_phone'];
        $obj->comment = $data['comment'];
        $obj->address = $data['address'];
        $obj->userId = $data['user_id'];

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

    public function getContactName(): string
    {
        return $this->contact_name;
    }

    public function getContactPhone(): string
    {
        return $this->contact_phone;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getSum(): int
    {
        return $this->sum;
    }
    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    public function getOrderProducts(): array
    {
        return $this->orderProducts;
    }
    public function setOrderProducts(array $orderProducts): void
    {
        $this->orderProducts = $orderProducts;
    }

}