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
    private Product $productModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();
        $this->authService = new AuthSessionService();
        $this->productModel = new Product();
    }

    public function create(OrderCreateDTO $data) : void
    {
        $user = $this->authService->getCurrentUser();

        $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());
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

        foreach ($orders as $userOrder) {

            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder->getId());
            $totalSum = 0;
            foreach ($orderProducts as $orderProduct) {
                $product = $this->productModel->getByProductId($orderProduct->getProductId()); // как передать product_id
                $orderProduct->setProduct($product);
                $itemSum = $orderProduct->getAmount() * $product->getPrice(); //amount?? userProduct
                $orderProduct->setSum($itemSum);
                $totalSum += $itemSum;
            }

            $userOrder->setOrderProducts($orderProducts);
            $userOrder->setSum($totalSum);

        }
        return $orders;
    }
}
