<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;

class OrderService
{
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private Order $orderModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();

    }

    public function create(OrderCreateDTO $data)
    {
        $orderProducts = $this->userProductModel->getAllUserProductsByUserId($data->getUser()->getId());
        $orderId = $this->orderModel->create(
            $data->getName(),
            $data->getPhone(),
            $data->getComment(),
            $data->getAddress(),
            $data->getUser()->getId()
        );

        foreach ($orderProducts as $orderProduct)
        {
            $this->orderProductModel->create($orderId, $orderProduct->getProductId(), $orderProduct->getAmount());
        }
        $this->userProductModel->deleteByUserId($data->getUser()->getId());
    }
}
