<?php

namespace Controllers;

use DTO\OrderCreateDTO;
use Request\CreateOrderRequest;


class OrderController extends BaseController
{

    public function getCreateForm()
    {
        if ($this->authService->check()) {
            $userProducts = $this->cartService->getUserProducts();

            if(empty($userProducts))
            {
                header('Location: /catalog');
                exit();
            }
            $total = $this->cartService->getSum();
            require_once '../Views/order_page.php';
        } else {
            header('Location: /login');
            exit();
        }
    }
    public function getAllOrders()
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit();
        }

        $userOrders = $this->orderService->getAll();

        require_once '../Views/user_orders.php';
    }
    public function create(CreateOrderRequest $request) : void
    {
        if (!$this->authService->check()) {
            header('Location: /login');
            exit();
        }

        $errors = $request->validate();
        $total = $this->cartService->getSum();

        if (empty($errors)) {
            $dto = new OrderCreateDTO($request->getName(), $request->getPhone(), $request->getComment(), $request->getAddress());

            $this->orderService->create($dto);

            header('Location: /user-orders');
            exit();
        }else{
            $userProducts = $this->cartService->getUserProducts();
            $total = $this->cartService->getSum();

            require_once '../Views/order_page.php';
        }

    }



}