<?php

namespace Service;

use Model\UserProduct;
use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;

class CartService
{
    private AuthInterface $authService;
    public function __construct()
    {
        $this->authService = new AuthSessionService();
    }

    public function addProduct(int $productId) : void
    {
        $user = $this->authService->getCurrentUser();

        $amount = 1;
        $data = UserProduct::getByUserIdProductId($user->getId(), $productId);

        if (!isset($data)) {
            UserProduct::insertByIdProductIdAmount($user->getId(), $productId, $amount);
        } else {
            $amount = $data->getAmount() + $amount;
            // update
            UserProduct::updateAmountByUserIdProductId($user->getId(), $productId, $amount);
        }
    }

    public function decreaseProduct(int $productId,int $amount) : void
    {
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();

        if ($amount === 1) {
            UserProduct::decreaseByUserIdProductId($userId, $productId);
        }  else {
            $amount = $amount - 1;
            UserProduct::updateAmountByUserIdProductId($userId, $productId, $amount);
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();

        if ($user === null){
            return [];
        }

        $userProducts = UserProduct::getAllByUserIdWithProducts($user->getId());

        foreach ($userProducts as $userProduct)
        {
            $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setTotalSum($totalSum);
        }
        return $userProducts;
    }

    public function getSum(): int
    {
        $total = 0;
        $userProducts = $this->getUserProducts();

        foreach ($userProducts as $userProduct)
        {
            $total += $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
        }
        return $total;
    }
}