<?php
class CartController
{
    //UserProduct
    public function getCart() : void
    {
        session_start();

        if (!(isset($_SESSION['user_id']))) {
            header('Location: login');
        } else {

            require_once "../Model/UserProduct.php";
            $productModel = new \Model\UserProduct();
            $orders = $productModel->getById($_SESSION['user_id']);

            $count = 0;
            foreach ($orders as $order) {
                $productId = $order['product_id'];

                require_once "../Model/Product.php";
                $cartModel = new \Model\Product();

                $products[$count] = $cartModel->getByProductId($productId);
                $products[$count]['amount'] = $order['amount'];
                $count++;
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
            require_once "../Model/Product.php";
            $productModel = new \Model\Product();

            $data = $productModel->getByProductId($productId);

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
        session_start();

        if (!(isset($_SESSION['user_id']))) {
            header('Location: login');
        } else {

            $data = $_POST;
            $errors = $this->validateAddProduct($data);

            if (empty($errors)) {
                $userId = $_SESSION['user_id'];
                $productId = $_POST['product_id'];
                $amount = $_POST['amount'];

                require_once "../Model/UserProduct.php";

                $cartModel = new \Model\UserProduct();

                $data = $cartModel->getByIdProductId($userId, $productId);

                if ($data === false) {
                    $cartModel->insertByIdProductIdAmount($userId, $productId, $amount);
                } else {
                    $amount = $data['amount'] + $amount;
                    // update
                    $cartModel->updateByIdProductIdAmount($userId, $productId, $amount);
                }


            }
            header("Location: catalog");
//            require_once "./Views/catalog_page.php";
        }
    }
}