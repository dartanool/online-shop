<?php

namespace Service;

use Model\Product;
use Model\UserProduct;

class CartService
{
    private UserProduct $userProductModel;
    private AuthService $authService;
    private Product $productModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->authService = new AuthService();
        $this->productModel = new Product();
    }

    public function addProduct(int $productId)
    {
        $user = $this->authService->getCurrentUser();

        $amount = 1;
        $data = $this->userProductModel->getByUserIdProductId($user->getId(), $productId);

        if (!isset($data)) {
            $this->userProductModel->insertByIdProductIdAmount($user->getId(), $productId, $amount);
        } else {
            $amount = $data->getAmount() + $amount;
            // update
            $this->userProductModel->updateAmountByUserIdProductId($user->getId(), $productId, $amount);
        }
    }

    public function decreaseProduct(int $productId,int $amount)
    {
        $user = $this->authService->getCurrentUser();
        $userId = $user->getId();

        if ($amount === 1) {
            $this->userProductModel->decreaseByUserIdProductId($userId, $productId);
        }  else {
            $amount = $amount - 1;
            $this->userProductModel->updateAmountByUserIdProductId($userId, $productId, $amount);
        }
    }

    public function getUserProducts(): array
    {
        $user = $this->authService->getCurrentUser();

        if ($user === null){
            return [];
        }

        $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());

        foreach ($userProducts as $userProduct)
        {
            $product = $this->productModel->getByProductId($userProduct->getProductId());
            $userProduct->setProduct($product);
            $totalSum = $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
            $userProduct->setTotalSum($totalSum);
        }
        return $userProducts;
    }

    public function getSum(): int
    {
        $total = 0;
        foreach ($this->getUserProducts() as $userProduct)
        {
            $total += $userProduct->getAmount() * $userProduct->getProduct()->getPrice();
        }
        return $total;
    }
}