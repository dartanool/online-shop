<?php
namespace Controllers;

use Model\Product;
use Model\User;
use Model\UserProduct;

class CartController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
    }

    //UserProduct
    public function getCart() : void
    {

        if (!$this->check()) {
            header('Location: login');
        } else {

            $userId = $this->getCurrentUserId();

            $userProducts = $this->userProductModel->getById($userId);
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

    //Add ProductController

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

    public function addProduct() : void
    {
        if (!$this->check()) {
            header('Location: login');
        } else {

            $data = $_POST;
            $errors = $this->validateAddProduct($data);

            if (empty($errors)) {
                $userId = $this->getCurrentUserId();
                $productId = $_POST['product_id'];
                $amount = $_POST['amount'];

                $data = $this->userProductModel->getByUserIdProductId($userId, $productId);

                if ($data === false) {
                    $this->userProductModel->insertByIdProductIdAmount($userId, $productId, $amount);
                } else {
                    $amount = $data['amount'] + $amount;
                    // update
                    $this->userProductModel->updateByIdProductIdAmount($userId, $productId, $amount);
                }


            }
            header("Location: catalog");
//            require_once "./Views/catalog_page.php";
        }
    }
}