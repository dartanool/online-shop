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
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            $statement = $pdo->query("SELECT * FROM products");

            $products = $statement->fetchAll();

            require_once "../Views/catalog_page.php";
        }
    }


}