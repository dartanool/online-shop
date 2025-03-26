<?php
namespace Controllers;

use Model\UserProduct;
use Request\GetProductIdRequest;

class CartController extends BaseController
{
    //UserProduct
    public function getCart() : void
    {

        if (!$this->authService->check()) {
            header('Location: login');
        } else {

            $userProducts = $this->cartService->getUserProducts();

            require_once "../Views/cart_page.php";
        }
    }


    // Add and delete 1 product, if amount !=1
    public function addProduct(GetProductIdRequest $request) : void
    {
        if (!$this->authService->check()) {
            header('Location: login');
        } else {
//добавить валидацию
            $productId = $request->getProductId();

            $this->cartService->addProduct($productId);

            header("Location: catalog");
        }
    }


    public function decreaseProduct(GetProductIdRequest $request) : void
    {
        if (!$this->authService->check()){
            header('Location: login');
        } else {
            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $request->getProductId();

            $amount = UserProduct::getByUserIdProductId($userId, $productId)->getAmount();

            $this->cartService->decreaseProduct($productId, $amount);

            header("Location: catalog");

        }
    }


}