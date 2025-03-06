<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;
use Core\Autoloader;

require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
Autoloader::register($path);

$app = new App();
$app->get('/registration',UserController::class,'getRegistrate');
$app->post('/registration',UserController::class,'registrate');
$app->get('/login', UserController::class,'getLogin');
$app->post('/login', UserController::class,'login');
$app->get('/user-profile',UserController::class,'getProfile' );
$app->get('/edit-user-profile', UserController::class,'getEditProfile');
$app->post('/edit-user-profile', UserController::class,'editProfile');
$app->get('/add-product',CartController::class,'getCatalog');
$app->post('/add-product',CartController::class,'addProduct');
$app->get('/catalog', ProductController::class,'getCatalog');
$app->get('/logout', UserController::class,'logout' );
$app->get('/cart', CartController::class,'getCart' );
$app->get('/create-order',OrderController::class,'getCreateForm' );
$app->post('/create-order',OrderController::class,'create' );
$app->get('/user-orders', OrderController::class,'getAllOrders' );
$app->post('/decrease-product',CartController::class,'decreaseProduct' );
$app->post('/product',ProductController::class,'getProduct' );
$app->get('/product',ProductController::class,'getProduct' );
$app->post('/add-review',ProductController::class,'addReview' );

$app->run();

