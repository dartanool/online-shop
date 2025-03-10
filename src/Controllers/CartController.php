<?php
namespace Controllers;

use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;

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
    public function addProduct(AddProductRequest $request) : void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {
//добавить валидацию
            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $request->getProductId();

            $this->cartService->addProduct($productId, $userId);

            header("Location: catalog");
        }
    }


    public function decreaseProduct(AddProductRequest $request) : void
    {
        if (!$this->authService->check()){
            header('Location: login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $request->getProductId();

            $amount = $this->userProductModel->getByUserIdProductId($userId, $productId)->getAmount();

            $this->cartService->decreaseProduct($productId, $userId,$amount);

            header("Location: catalog");

        }
    }


}