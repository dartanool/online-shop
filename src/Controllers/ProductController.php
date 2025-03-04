<?php
namespace Controllers;

use Model\Product;

class ProductController
{
    private Product $productModel;

    public function __construct()
    {
        $this->productModel = new Product();
    }
    //Catalog
    public function getCatalog() : void
    {
        session_start();

        if (!(isset($_SESSION['user_id']))) {
            header('Location: login');
        } else {

            $products = $this->productModel->getById();

            require_once "../Views/catalog_page.php";
        }
    }


}