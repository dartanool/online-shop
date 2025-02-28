<?php

namespace Model;

class OrderProduct extends \Model\Model
{
    public function create(int $orderId, int $productId, int $amount)
    {
        $stmt = $this->pdo->prepare
        (
            "INSERT INTO order_products(order_id, product_id, amount) VALUES (:order_id, :product_id, :amount)"
        );
        $stmt->execute(['order_id' => $orderId, 'product_id' => $productId, 'amount' => $amount]);
    }
    public function getAllByOrderId(int $orderId): array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM order_products WHERE order_id = :orderId");
        $stmt->execute(['orderId' => $orderId]);
        $orderProducts = $stmt->fetchAll();
        return $orderProducts;
    }




}