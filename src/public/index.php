<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

//Registration
if ($requestUri == '/registration') {
    require_once './classes/User.php';
    $user = new User();
        if ($requestMethod ==='GET'){
            $user->getRegistrate();
        } elseif ($requestMethod ==='POST'){
            $user->registrate();
        }

//login
} elseif ($requestUri == '/login') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod ==='GET'){
        $user->getLogin();
    } elseif ($requestMethod ==='POST'){
        $user->login();
    }


//User Profile
}  elseif ($requestUri == '/user-profile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod ==='GET'){
        $user->getProfile();
    }

//Edit Profile
} elseif ($requestUri == '/edit-user-profile') {
    require_once './classes/User.php';
    $user = new User();
    $user->editProfile();

// Add Product
} elseif ($requestUri == '/add-product') {
    require_once './classes/Products.php';
    $product = new Products();
    $product->addProduct();

//catalog
} elseif ($requestUri == '/catalog') {
    require_once './classes/Products.php';
    $product = new Products();
    $product->getCatalog();

//cart
} elseif ($requestUri == '/cart') {
    require_once './classes/Products.php';
    $product = new Products();
    $product->getCart();
} else {
    http_response_code(404);
    require_once '404.php';
}
