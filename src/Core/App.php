<?php
namespace Core;
use Controllers\UserController;
use Controllers\ProductController;
use Controllers\CartController;
use Controllers\OrderController;
use Request\RegistrateRequest;
use Service\Log\LogDbService;
use Service\Log\LogInterface;
use Service\Log\LogFileService;

class App
{
    private array $routes;
    private LogInterface $logService;

    public function __construct()
    {
        $this->logService = new LogFileService();
//        $this->logService = new LogDbService();
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
                    $this->logService->log($exception);

                    require_once '../Views/500.php';

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
