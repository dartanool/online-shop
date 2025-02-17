<?php

class App
{
    private array $routes = [
        '/registration' => [
            'GET' => [
                'class'=> 'UserController',
                'method'=> 'getRegistrate'
            ],
            'POST' => [
                'class'=> 'UserController',
                'method'=> 'registrate'
            ]
        ],
        '/login' => [
            'GET' => [
                'class'=> 'UserController',
                'method'=> 'getLogin'
            ],
            'POST' => [
                'class'=> 'UserController',
                'method'=> 'login'
            ],
        ],
        '/user-profile' => [
            'GET' => [
                'class'=> 'UserController',
                'method'=> 'getProfile'
            ],
        ],
        '/edit-user-profile' =>[
            'GET' => [
                'class'=> 'UserController',
                'method'=> 'getEditProfile'
            ],
            'POST' => [
                'class'=> 'UserController',
                'method'=> 'editProfile'
            ],
        ],
        '/add-product' => [
            'POST' => [
                'class'=> 'CartController',
                'method'=> 'addProduct'
            ],
        ],
        '/catalog' => [
            'GET' => [
                'class'=> 'ProductController',
                'method'=> 'getCatalog'
            ],
        ],
        '/cart' => [
            'GET' => [
                'class'=> 'CartController',
                'method'=> 'getCart'
            ],
        ],

    ];

    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];


        if (isset($this->routes[$requestUri])){

            $routeMethods = $this->routes[$requestUri];

            if (isset($routeMethods[$requestMethod])){
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];

                require_once "../Controllers/$class.php";

                $controller = new $class();
                $controller ->$method();


            } else {
                echo "$requestUri doesn't support $requestMethod";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }
    }
}
