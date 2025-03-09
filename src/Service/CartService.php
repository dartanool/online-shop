<?php

namespace Service;

use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
    }

    public function addProduct(int $productId, int $userId)
    {
        $amount = 1;
        $data = $this->userProductModel->getByUserIdProductId($userId, $productId);

        if (!isset($data)) {
            $this->userProductModel->insertByIdProductIdAmount($userId, $productId, $amount);
        } else {
            $amount = $data->getAmount() + $amount;
            // update
            $this->userProductModel->updateAmountByUserIdProductId($userId, $productId, $amount);
        }
    }

    public function decreaseProduct(int $productId, int $userId,int $amount)
    {
        if ($amount === 1) {
            $this->userProductModel->decreaseByUserIdProductId($userId, $productId);
        }  else {
            $amount = $amount - 1;
            $this->userProductModel->updateAmountByUserIdProductId($userId, $productId, $amount);
        }
    }
}