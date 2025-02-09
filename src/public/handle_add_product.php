<?php
session_start();

if  (!(isset($_SESSION['user_id']))){
    header('Location: login_form.php');
} else {

    $data = $_POST;

    $errors = validate($data);

    if (empty($errors)) {
        $user_id = $_SESSION['user_id'];
        $product_id = $_POST['product_id'];
        $amount = $_POST['amount'];
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $check = checksForReAdding($data, $_SESSION['user_id']);


        if (!(empty($check['product_id']))){
            $product_id = $check['product_id'];
            $new_amount = $check['amount']+$amount;
            // update
            $statement = $pdo->prepare("UPDATE user_products SET amount = :amount WHERE product_id = :product_id");
            $statement->execute([':amount' => $new_amount, 'product_id' => $product_id]);

        } else {

            $statement = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES ($user_id, :product_id, :amount)");
            $statement->execute([':product_id' => $product_id, ':amount' => $amount]);

            $result = $statement-> fetch();
        }

    }
    require_once "./add_product_form.php";
}



function validate(array $data) : array | string
{
    $errors = [];
    if (!(isset($data['product_id'])))
    {
        $errors['product_id'] = "Product id incorrect";
    } elseif (!is_int($data['product_id'])) {
        $errors['product_id'] = "Product id incorrect";
    }

    if (!(isset($data['amount'])))
    {
        $errors['amount'] = "Amount incorrect";
    } elseif (!is_int($data['amount'])) {
        $errors['amount'] = "Amount incorrect";
    }

    return $errors;
}

function checksForReAdding(array $data, int $user_id) :array
{
    $check =[];

    $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

    $statement = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :user_id");
    $statement->execute([':user_id'=> $user_id]);

    $orders = $statement->fetchAll();

    if ($orders === false) {
        return $check;
    } else {
        $check['amount'] = 0;
        foreach ($orders as $order) {
            if ($order['product_id'] == $data['product_id']) {
                $check['product_id'] = $data['product_id'] ;
                $check['amount'] += $order['amount'];

            }
        }
    }
    return $check;

}


