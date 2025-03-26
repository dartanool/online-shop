<?php

namespace Service;

use DTO\OrderCreateDTO;
use Model\Order;
use Model\OrderProduct;
use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class OrderService
{
    private AuthInterface $authService;
    private CartService $cartService;

    public function __construct()
    {
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

        $userProducts = UserProduct::getAllByUserId($user->getId());

        $orderId = Order::create(
            $data->getName(),
            $data->getPhone(),
            $data->getComment(),
            $data->getAddress(),
            $user->getId()
        );

        foreach ($userProducts as $userProduct)
        {
            OrderProduct::create($orderId, $userProduct->getProductId(), $userProduct->getAmount());
        }
        UserProduct::deleteByUserId($user->getId());
    }

    public function getAll() : array
    {
        $user = $this->authService->getCurrentUser();

        $orders = Order::getAllByUserId($user->getId());

        foreach ($orders as $order){
            $totalSum = 0;
            $orderProducts = OrderProduct::getAllByOrderIdWithProducts($order->getId());
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
