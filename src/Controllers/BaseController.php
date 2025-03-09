<?php

namespace Controllers;

use Service\AuthService;
use Service\CartService;
use Service\OrderService;

abstract class BaseController
{
    protected AuthService $authService;
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct()
    {
        $this->authService = new AuthService();
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
    }
}