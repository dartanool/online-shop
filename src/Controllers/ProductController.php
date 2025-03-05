<?php
namespace Controllers;

use Model\Product;
use Model\UserProduct;

class ProductController extends BaseController
{
    private Product $productModel;
    private UserProduct $userProductModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new Product();
        $this->userProductModel = new UserProduct();
    }
    //Catalog
    public function getCatalog() : void
    {
        if (!($this->authService->check())) {
            header('Location: login');
        } else {

            $products = $this->productModel->getById();
            $userProduct =$this->userProductModel->getAllUserProductsByUserId($this->authService->check());

            require_once "../Views/catalog_page.php";
        }
    }


}