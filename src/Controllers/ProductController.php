<?php
namespace Controllers;

use Model\Product;

class ProductController extends BaseController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }
    //Catalog
    public function getCatalog() : void
    {
        if (!($this->check())) {
            header('Location: login');
        } else {

            $products = $this->productModel->getById();

            require_once "../Views/catalog_page.php";
        }
    }


}