<?php

namespace Service;

use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;

class OrderService
{
    private Order $orderModel;
    private UserProduct $userProductModel;
    private AuthService $authService;
    private OrderProduct $orderProductModel;

    public function __construct()
    {
        $this->orderModel = new Order();
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthService();
        $this->orderProductModel = new OrderProduct();
    }

    public function create(int $orderId, int $userId)
    {
        $orderProducts = $this->userProductModel->getAllUserProductsByUserId($userId);

        foreach ($orderProducts as $orderProduct)
        {
            $this->orderProductModel->create($orderId, $orderProduct->getProductId(), $orderProduct->getAmount());
        }
        $this->userProductModel->deleteByUserId($userId);
    }
}
