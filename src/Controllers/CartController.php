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
        parent::__construct();
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


    // Add and delete 1 product, if amount !=0
    public function addProduct() : void
    {
        if (!$this->check()) {
            header('Location: login');
        } else {

            $userId = $this->getCurrentUserId();
            $productId = $_POST['product_id'];
            $amount = 1;

            $data = $this->userProductModel->getByUserIdProductId($userId, $productId);

            if (!isset($data)) {
                $this->userProductModel->insertByIdProductIdAmount($userId, $productId, $amount);
            } else {
//                $amount = $this->userProductModel->getByUserIdProductId($userId, $productId)->getAmount() + $amount;
                $amount = $data->getAmount() + $amount;
                // update
                $this->userProductModel->updateAmountByUserIdProductId($userId, $productId, $amount);
            }

            header("Location: catalog");
        }
    }

    public function decreaseProduct() : void
    {
        if (!$this->check()){
            header('Location: login');
        } else {
            $userId = $this->getCurrentUserId();
            $productId = $_POST['product_id'];

            $data = $this->userProductModel->getByUserIdProductId($userId, $productId);
            $amount = $data->getAmount();


            if ($amount === 1) {
                $this->userProductModel->decreaseByUserIdProductId($userId, $productId);
            }  else {
                $amount = $amount = $data->getAmount() -1;
                $this->userProductModel->updateAmountByUserIdProductId($userId, $productId, $amount);
            }

            header("Location: catalog");

        }
    }
}