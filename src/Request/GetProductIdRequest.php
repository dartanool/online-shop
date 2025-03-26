<?php

namespace Request;

use Model\Product;

class GetProductIdRequest
{
    public function __construct(private array $data)
    {
    }

    public function getProductId() : int
    {
        return $this->data['product_id'];
    }

    public function validateAddProduct(): array
    {
        $errors = [];
        $productId = (int)$this->data['product_id'];
        $amount = (int)$this->data['amount'];
        if (!isset($productId)) {
            $errors['productId'] = "ProductController id incorrect";
        } else {

            $data = Product::getByProductId($productId);

            if ($data === false) {
                $errors['productId'] = "ProductController doesn't exist";
            }
        }

        if (!isset($amount)) {
            $errors['amount'] = "Amount incorrect";
        }

        return $errors;
    }

}