<?php

use Controllers\CartController;
use Controllers\OrderController;
use Controllers\ProductController;
use Controllers\UserController;
use Core\App;
use Core\Autoloader;
use Request\AddReviewRequest;
use Request\GetProductIdRequest;
use Request\CreateOrderRequest;
use Request\EditProfileRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;

require_once './../Core/Autoloader.php';

$path = dirname(__DIR__);
Autoloader::register($path);

$app = new App();

$app->get('/registration',UserController::class,'getRegistrate', RegistrateRequest::class);
$app->get('/user-orders', OrderController::class,'getAllOrders', CreateOrderRequest::class );
//$app->get('/product',ProductController::class,'getProduct', GetProductIdRequest::class );
$app->get('/catalog', ProductController::class,'getCatalog', RegistrateRequest::class );
$app->get('/logout', UserController::class,'logout', RegistrateRequest::class  );
$app->get('/cart', CartController::class,'getCart', RegistrateRequest::class );
$app->get('/create-order',OrderController::class,'getCreateForm', CreateOrderRequest::class );
//$app->get('/add-product',ProductController::class,'getCatalog',GetProductIdRequest::class );
$app->get('/user-profile', UserController::class,'getProfile', EditProfileRequest::class );
$app->get('/edit-user-profile', UserController::class,'getEditProfile', EditProfileRequest::class);
$app->get('/login', UserController::class,'getLogin', LoginRequest::class);

$app->post('/registration',UserController::class,'registrate', RegistrateRequest::class);
$app->post('/login', UserController::class,'login', LoginRequest::class);
$app->post('/edit-user-profile', UserController::class,'editProfile', EditProfileRequest::class);
$app->post('/add-product',CartController::class,'addProduct', GetProductIdRequest::class);
$app->post('/create-order',OrderController::class,'create', CreateOrderRequest::class );
$app->post('/decrease-product',CartController::class,'decreaseProduct', GetProductIdRequest::class );
$app->post('/product',ProductController::class,'getProduct', GetProductIdRequest::class );
$app->post('/add-review',ProductController::class,'addReview', AddReviewRequest::class );

$app->run();

