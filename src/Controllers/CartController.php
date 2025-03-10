<?php
namespace Controllers;

use Model\Product;
use Model\UserProduct;

class CartController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        parent::__construct();
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }

    //UserProduct
    public function getCart() : void
    {

        if (!$this->authService->check()) {
            header('Location: login');
        } else {

            $user = $this->authService->getCurrentUser();

            $userProducts = $this->userProductModel->getAllUserProductsByUserId($user->getId());
            $newUserProducts = [];
            foreach ($userProducts as $userProduct)
            {
                $product = $this->productModel->getByProductId($userProduct->getProductId());
                $userProduct->setProduct($product);
                $newUserProducts[] = $userProduct;
            }

            require_once "../Views/cart_page.php";
        }
    }


    // Add and delete 1 product, if amount !=1
    public function addProduct(array $data) : void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {

            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $data['product_id'];

            $this->cartService->addProduct($productId, $userId);

            header("Location: catalog");
        }
    }

    public function decreaseProduct(array $data) : void
    {
        if (!$this->authService->check()){
            header('Location: login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $data['product_id'];

            $amount = $this->userProductModel->getByUserIdProductId($userId, $productId)->getAmount();

            $this->cartService->decreaseProduct($productId, $userId,$amount);

            header("Location: catalog");

        }
    }

    private function validateAddProduct(array $data): array
    {
        $errors = [];
        $productId = (int)$data['product_id'];
        $amount = (int)$data['amount'];
        if (!isset($productId)) {
            $errors['productId'] = "ProductController id incorrect";
        } else {

            $data = $this->productModel->getByProductId($productId);

            if ($data === false) {
                $errors['productId'] = "ProductController doesn't exist";
            }
        }

        if (!isset($amount)) {
            $errors['amount'] = "Amount incorrect";
        }

        return $errors;
    }
}