<?php

namespace Model;

class OrderProduct extends \Model\Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $total;

    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare
        (
            "INSERT INTO order_products(order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)"
        );
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount]);
    }
    public function getAllByOrderId(int $orderId): array | null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();

        if ($orderProducts === false) {
            return null;
        }

        $objs =[];
        foreach ($orderProducts as $orderProduct) {
            $objs[] = $this->createObject($orderProduct);
        }

        return $objs;
    }

    private function createObject(array $data) : self
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->orderId = $data['order_id'];
        $obj->productId = $data['product_id'];
        $obj->amount = $data['amount'];

        return $obj;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
    public function setProduct(Product $product) : void
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function setTotal(int $total): void
    {
        $this->total = $total;
    }

}