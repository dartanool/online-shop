<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

//Registration
if ($requestUri == '/registration') {
    require_once '../Controllers/UserController.php';
    $user = new UserController();
        if ($requestMethod ==='GET'){
            $user->getRegistrate();
        } elseif ($requestMethod ==='POST'){
            $user->registrate();
        }

//login
} elseif ($requestUri == '/login') {
    require_once '../Controllers/UserController.php';
    $user = new UserController();
    if ($requestMethod ==='GET'){
        $user->getLogin();
    } elseif ($requestMethod ==='POST'){
        $user->login();
    }


//UserController Profile
}  elseif ($requestUri == '/user-profile') {
    require_once '../Controllers/UserController.php';
    $user = new UserController();
    if ($requestMethod ==='GET'){
        $user->getProfile();
    }

//Edit Profile
} elseif ($requestUri == '/edit-user-profile') {
    require_once '../Controllers/UserController.php';
    $user = new UserController();
    if ($requestMethod ==='GET'){
        $user->getEditProfile();
    } elseif ($requestMethod ==='POST'){
        $user->editProfile();
    }


// Add Product
} elseif ($requestUri == '/add-product') {
    require_once '../Controllers/CartController.php';
    $product = new CartController();
    $product->addProduct();

//catalog
} elseif ($requestUri == '/catalog') {
    require_once '../Controllers/ProductController.php';
    $product = new ProductController();
    $product->getCatalog();

//cart
} elseif ($requestUri == '/cart') {
    require_once '../Controllers/CartController.php';
    $product = new CartController();
    $product->getCart();
} else {
    http_response_code(404);
    require_once '404.php';
}
