<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;
use Core\Autoloader;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;

require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
Autoloader::register($path);

$app = new App();

$app->get('/registration',UserController::class,'getRegistrate', RegistrateRequest::class);
//$app->get('/user-orders', OrderController::class,'getAllOrders' );
//$app->get('/product',ProductController::class,'getProduct' );
//$app->get('/catalog', ProductController::class,'getCatalog');
//$app->get('/logout', UserController::class,'logout' );
//$app->get('/cart', CartController::class,'getCart' );
//$app->get('/create-order',OrderController::class,'getCreateForm' );
//$app->get('/add-product',CartController::class,'getCatalog');
//$app->get('/user-profile',UserController::class,'getProfile' );
$app->get('/edit-user-profile', UserController::class,'getEditProfile', EditProfileRequest::class);
$app->get('/login', UserController::class,'getLogin', LoginRequest::class);

$app->post('/registration',UserController::class,'registrate', RegistrateRequest::class);
$app->post('/login', UserController::class,'login', LoginRequest::class);
$app->post('/edit-user-profile', UserController::class,'editProfile', EditProfileRequest::class);
//$app->post('/add-product',CartController::class,'addProduct');
//$app->post('/create-order',OrderController::class,'create' );
//$app->post('/decrease-product',CartController::class,'decreaseProduct' );
//$app->post('/product',ProductController::class,'getProduct' );
//$app->post('/add-review',ProductController::class,'addReview' );

$app->run();

