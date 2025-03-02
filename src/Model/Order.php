<?php

namespace Model;

class Order extends \Model\Model
{
    private int $id;
    private string $contact_name;
    private string $contact_phone;
    private string|null $comment;
    private int $userId;
    private string $address;
    private int $total;
    private Product $products;

    public function create(array $data, int $userId): int
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO orders (contact_name, contact_phone, comment, user_id, address)
                    VALUES (:name, :phone, :comment, :user_id, :address) RETURNING id"
        );
        $stmt->execute([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'comment' => $data['comment'],
            'address' => $data['address'],
            'user_id' => $userId
        ]);
        $dataId = $stmt->fetch();
        return $dataId['id'];
    }

    public function getAllByUserId($userId): array|null
    {
        $stmt = $this->pdo->prepare('SELECT * FROM orders WHERE user_id = :user_id');
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

        $obj->id = $data['id'];
        $obj->contact_name = $data['contact_name'];
        $obj->contact_phone = $data['contact_phone'];
        $obj->comment = $data['comment'];
        $obj->address = $data['address'];

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

    public function getProducts(): Product
    {
        return $this->products;
    }

    public function getTotal(): int
    {
        return $this->total;
    }
    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

    public function setProducts(Product $products): void
    {
        $this->products = $products;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

}