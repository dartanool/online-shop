<?php

namespace Controllers;

use Service\Auth\AuthInterface;
use Service\Auth\AuthSessionService;
use Service\CartService;
use Service\OrderService;

abstract class BaseController
{
    protected AuthInterface $authService;
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct()
    {
        $this->authService = new AuthSessionService();
        $this->cartService = new CartService();
        $this->orderService = new OrderService();
    }
}