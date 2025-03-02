<?php

namespace Controllers;

use Model\UserProduct;
use Model\Order;
use Model\OrderProduct;
use Model\Product;


class OrderController
{
    private UserProduct $userProductModel;
    private Product $productModel;
    private OrderProduct $orderProductModel;
    private Order $orderModel;
    public function __construct()
    {
        $this->userProductModel = new UserProduct();
        $this->productModel = new Product();
        $this->orderProductModel = new OrderProduct();
        $this->orderModel = new Order();
    }

    public function getCreateForm()  //форма order если моя корзина не пустая
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }


        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $orderProducts = $this->userProductModel->getById($userId);

            if(empty($orderProducts))
            {
                header('Location: /catalog');
                exit();
            }
            $newOrderProducts = $this->newOrderProducts($orderProducts);
            $total = $this->totalOrderProducts($newOrderProducts);
            require_once '../Views/order_page.php';
        } else {
            header('Location: /login');
            exit();
        }
    }
    public function getAllOrders()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
        $userId = $_SESSION['user_id'];

        $userOrders = $this->orderModel->getAllByUserId($userId);

        $newUserOrders = [];

        foreach ($userOrders as $userOrder) {
            $orderProducts = $this->orderProductModel->getAllByOrderId($userOrder['id']);
            $newOrderProducts = $this->newOrderProducts($orderProducts);
            $userOrder['total'] = $this->totalOrderProducts($newOrderProducts);
            $userOrder['products'] = $newOrderProducts;
            $newUserOrders[] = $userOrder;
        }

        require_once '../Views/user_orders.php';
    }
    public function create()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        $data = $_POST;
        $errors = $this->validate($data);
        $userId = $_SESSION['user_id'];
        $orderProducts = $this->userProductModel->getById($userId);
        $newOrderProducts = $this->newOrderProducts($orderProducts);
        $total = $this->totalOrderProducts($newOrderProducts);

        if (empty($errors)) {
            $userId = $_SESSION['user_id'];

            $orderId = $this->orderModel->create($data, $userId);

            foreach ($orderProducts as $orderProduct)
            {
                $this->orderProductModel->create($orderId, $orderProduct->getProductId(), $orderProduct->getAmount());
            }
            $this->userProductModel->deleteByUserId($userId);
            header('Location: /user-orders');
            exit();
        }else{
            require_once '../Views/order_page.php';
        }

    }
    private function validate(array $data): array
    {
        $errors = [];

        if (isset($data['name'])) {
            if (strlen($data['name']) < 2) {
                $errors['name'] = 'Имя пользователя должно быть больше 2 символов';
            } elseif (!preg_match('/^[a-zA-Zа-яА-Я0-9_\-\.]+$/u', $data['name'])) {
                $errors['name'] = "Имя пользователя может содержать только буквы, цифры, символы '_', '-', '.'";
            }
        } else {
            $errors['name'] = 'Введите имя';
        }

        if (isset($data['address'])) {
            if (!preg_match('/^[\d\s\w\.,-]+$/u', $data['address'])) {
                $errors['address'] = "Адрес содержит недопустимые символы";
            }elseif (!preg_match('/[а-яА-ЯёЁ]+\s+\d+/', $data['address'])) {
                $errors['address'] = "Адрес должен содержать номер дома и улицу";
            }
        } else {
            $errors['address'] = 'Введите адрес';
        }

        if (isset($data['phone'])) {
            $cleanedPhone = preg_replace('/\D/', '', $data['phone']);
            if(strlen($cleanedPhone) < 11) {
                $errors['phone'] = 'Номер телефона не может быть меньше 11 символов';
            }elseif (!preg_match('/^\+\d+$/', $data['phone'])) {
                $errors['phone'] = "Номер телефона должен начинаться с '+' и содержать только цифры после него";
            }
        } else {
            $errors['phone'] = 'Введите имя';
        }
        return $errors;
    }
    private function newOrderProducts(array $orderProducts): array
    {
        $newOrderProducts = [];
        foreach ($orderProducts as $orderProduct)
        {
            $product = $this->productModel->getByProductId($orderProduct->getProductId());
            $orderProduct['name'] = $product['name'];
            $orderProduct['price'] = $product['price'];
            $orderProduct['totalSum'] = $orderProduct['amount'] * $orderProduct['price'];
            $newOrderProducts[] = $orderProduct;
        }
        return $newOrderProducts;
    }
    private function totalOrderProducts(array $newOrderProducts): int
    {
        $total = 0;
        foreach ($newOrderProducts as $newOrderProduct)
        {
            $total += $newOrderProduct['totalSum'];
        }
        return $total;
    }
}