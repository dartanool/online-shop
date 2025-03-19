<?php
namespace Core;
use Controllers\UserController;
use Controllers\ProductController;
use Controllers\CartController;
use Controllers\OrderController;
use Request\RegistrateRequest;
use Service\Log\LogInterface;
use Service\Log\LogFileService;

class App
{
    private array $routes;
    private LogInterface $logService;

//    private array $routes = [
//        '/registration' => [
//            'GET' => [
//                'class'=> UserController::class,
//                'method'=> 'getRegistrate'
//            ],
//            'POST' => [
//                'class'=> UserController::class,
//                'method'=> 'registrate'
//            ]
//        ],
//        '/login' => [
//            'GET' => [
//                'class'=> UserController::class,
//                'method'=> 'getLogin'
//            ],
//            'POST' => [
//                'class'=> UserController::class,
//                'method'=> 'login'
//            ],
//        ],
//        '/user-profile' => [
//            'GET' => [
//                'class'=> UserController::class,
//                'method'=> 'getProfile'
//            ],
//        ],
//        '/edit-user-profile' =>[
//            'GET' => [
//                'class'=> UserController::class,
//                'method'=> 'getEditProfile'
//            ],
//            'POST' => [
//                'class'=> UserController::class,
//                'method'=> 'editProfile'
//            ],
//        ],
//        '/add-product' => [
//            'GET' =>[
//                'class' => CartController::class,
//                'method'=> 'getCatalog',
//            ],
//            'POST' => [
//                'class'=> CartController::class,
//                'method'=> 'addProduct'
//            ],
//        ],
//        '/catalog' => [
//            'GET' => [
//                'class'=> ProductController::class,
//                'method'=> 'getCatalog'
//            ],
//        ],
//        '/cart' => [
//            'GET' => [
//                'class'=> CartController::class,
//                'method'=> 'getCart'
//            ],
//        ],
//        '/logout' => [
//            'GET' => [
//                'class'=> UserController::class,
//                'method'=> 'logout'
//            ]
//        ],
//        '/create-order' => [
//            'GET' => [
//                'class' => OrderController::class,
//                'method' => 'getCreateForm',
//            ],
//            'POST' => [
//                'class' => OrderController::class,
//                'method' => 'create',
//            ]
//        ],
//        '/user-orders' => [
//            'GET' => [
//                'class' => OrderController::class,
//                'method' => 'getAllOrders',
//            ]
//        ]
//    ];

    public function __construct()
    {
        $this->logService = new LogFileService("../Storage/errors.txt");
    }
    public function run() :void
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];


        if (isset($this->routes[$requestUri])){

            $routeMethods = $this->routes[$requestUri];

            if (isset($routeMethods[$requestMethod])){
                $handler = $routeMethods[$requestMethod];

                $class = $handler['class'];
                $method = $handler['method'];
                $request = $handler['request']; //в метод пост добавить ниже
                $controller = new $class();

                try {

                    if ($request !== null){
                        $requestObj = new $request($_POST);
                        $controller->$method($requestObj);
                    } else {
                        $controller->$method($_POST);
                    }
                } catch (\Throwable $exception) {

                    require_once '../Views/500.php';
                    $this->logService->log($exception);

                }


            } else {
                echo "$requestUri doesn't support $requestMethod";
            }
        } else {
            http_response_code(404);
            require_once '../Views/404.php';
        }
    }

    public function get(string $requestUri, string $class, string $method, string $request = null):void
    {

        $this->routes[$requestUri]['GET'] = [
            'class' => $class,
            'method' => $method,
            'request' => $request
        ];
    }

    public function post(string $requestUri, string $class, string $method, string $request = null):void
    {

        $this->routes[$requestUri]['POST'] = [
            'class' => $class,
            'method' => $method,
            'request' => $request
        ];
    }
}
