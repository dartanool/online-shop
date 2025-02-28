<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;

$autoLoad = function (string $path) {
    $elem = explode("\\", $path);
    $path = "../$elem[0]/$elem[1].php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};


spl_autoload_register($autoLoad);
$app = new App();
$app->addRoute('/registration', 'GET',UserController::class,'getRegistrate');
$app->addRoute('/registration', 'POST',UserController::class,'registrate');
$app->addRoute('/login', 'GET',UserController::class,'getLogin');
$app->addRoute('/login', 'POST',UserController::class,'login');
$app->addRoute('/user-profile', 'GET',UserController::class,'getProfile' );
$app->addRoute('/edit-user-profile', 'GET',UserController::class,'getEditProfile');
$app->addRoute('/edit-user-profile', 'POST',UserController::class,'editProfile');
$app->addRoute('/add-product','GET',CartController::class,'getCatalog');
$app->addRoute('/add-product','POST',CartController::class,'addProduct');
$app->addRoute('/catalog', 'GET',ProductController::class,'getCatalog');
$app->addRoute('/logout', 'GET',UserController::class,'logout' );
$app->addRoute('/cart', 'GET',CartController::class,'getCart' );
$app->addRoute('/create-order', 'GET',OrderController::class,'getCreateForm' );
$app->addRoute('/create-order', 'POST',OrderController::class,'create' );
$app->addRoute('/user-orders', 'GET',OrderController::class,'getAllOrders' );


$app->run();