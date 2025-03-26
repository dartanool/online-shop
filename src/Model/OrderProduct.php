<?php

namespace Model;

class OrderProduct extends \Model\Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private Product $product;
    private int $sum;

    protected function getTableName(): string
    {
        return 'order_products';
    }
    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare
        (
            "INSERT INTO {$this->getTableName()}(order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)"
        );
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount]);
    }
    public function getAllByOrderIdWithProducts(int $orderId): array | null
    {
        $stmt = $this->pdo->prepare("SELECT * FROM {$this->getTableName()} t1
                                            INNER JOIN products t2 ON t1.product_id = t2.id
                                            WHERE order_id = :orderId");
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

    public static function createObject(array $data) : self
    {
        $obj = new self();

        $obj->id = $data['id'];
        $obj->orderId = $data['order_id'];
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

    public function getSum(): int
    {
        return $this->sum;
    }

    public function setSum(int $sum): void
    {
        $this->sum = $sum;
    }

}