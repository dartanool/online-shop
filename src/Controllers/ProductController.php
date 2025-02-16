<?php

class ProductController
{

    //Catalog
    public function getCatalog() : void
    {
        session_start();

        if (!(isset($_SESSION['user_id']))) {
            header('Location: login');
        } else {

            require_once "../Model/Product.php";
            $productModel = new Product();
            $products = $productModel->getById();

            require_once "../Views/catalog_page.php";
        }
    }


}