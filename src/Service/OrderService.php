<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\Product;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private UserProduct $userProductModel;
    private OrderProduct $orderProductModel;
    private Order $orderModel;
    private AuthInterface $authService;
    private CartService $cartService;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
    }

    public function create(OrderCreateDTO $data) : void
    {

        $sum = $this->cartService->getSum();

        if ($sum < 100){
            throw new \Exception('Для формирования заказа сумма заказа должна быть больше 100 рублей');
        }

        $user = $this->authService->getCurrentUser();

        $userProducts = $this->userProductModel->getAllByUserId($user->getId());

        $orderId = $this->orderModel->create(
            $data->getName(),
            $data->getPhone(),
            $data->getComment(),
            $data->getAddress(),
            $user->getId()
        );

        foreach ($userProducts as $userProduct)
        {
            $this->orderProductModel->create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
        }
        $this->userProductModel->deleteByUserId($user->getId());
    }

    public function getAll() : array
    {
        $user = $this->authService->getCurrentUser();

        $orders = $this->orderModel->getAllByUserId($user->getId());

        foreach ($orders as $order){
            $totalSum = 0;
            $orderProducts = $this->orderProductModel->getAllByOrderIdWithProducts($order->getId());
            foreach ($orderProducts as $orderProduct)
            {
                $itemSum = $orderProduct->getAmount() * $orderProduct->getProduct()->getPrice();
                $orderProduct->setSum($itemSum);
                $totalSum += $itemSum;
            }

            $order->setOrderProducts($orderProducts);
            $order->setSum($totalSum);
        }

        return $orders;
    }
}
