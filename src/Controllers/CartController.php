<?php
class CartController
{
    //Cart
    public function getCart() : void
    {
        session_start();

        if (!(isset($_SESSION['user_id']))) {
            header('Location: login_form.php');
        } else {
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

            $statement = $pdo->query("SELECT * FROM user_products WHERE user_id = {$_SESSION['user_id']}");

            $orders = $statement->fetchAll();


            $count = 0;
            foreach ($orders as $order) {
                $productId = $order['product_id'];

                $productsStatement = $pdo->query("SELECT * FROM products WHERE id = {$productId}");
                $products[$count] = $productsStatement->fetch();
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
            $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');
            $statement = $pdo->prepare("SELECT * FROM products WHERE id = :productId");
            $statement->execute([':productId' => $productId]);
            $data = $statement->fetch();

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
            header('Location: login_form.php');
        } else {

            $data = $_POST;
            $errors = $this->validateAddProduct($data);

            if (empty($errors)) {
                $userId = $_SESSION['user_id'];
                $productId = $_POST['product_id'];
                $amount = $_POST['amount'];
                $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

                $statement = $pdo->prepare("SELECT * FROM user_products WHERE product_id = :productId AND user_id =:userId");
                $statement->execute(['productId' => $productId, 'userId' => $userId]);

                $data = $statement->fetch();

                if ($data === false) {
                    $statement = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES ($userId, :product_id, :amount)");
                    $statement->execute(['product_id' => $productId, 'amount' => $amount]);
                } else {
                    $amount = $data['amount'] + $amount;
                    // update
                    $statement = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE user_id =:userId and product_id = :product_id");
                    $statement->execute(['amount' => $amount, 'userId' => $userId, 'product_id' => $productId]);
                }


            }
            header("Location: catalog");
//            require_once "./Views/catalog_page.php";
        }
    }
}