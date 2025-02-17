<?php

class UserProduct
{
    public function getById(int $id) : array
    {
        $pdo = new PDO('pgsql:host=postgres_db;port=5432;dbname = mydb', 'user', 'pass');

        $statement = $pdo->query("SELECT * FROM user_products WHERE user_id = {$id}");

        $orders = $statement->fetchAll();

        return $orders;
    }



}