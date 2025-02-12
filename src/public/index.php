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

//catalog
} elseif ($requestUri == '/catalog') {
    if ($requestMethod ==='GET'){
        require_once './catalog/catalog.php';
    } elseif ($requestMethod ==='POST'){
        require_once './catalog/catalog_page.php';
    }

}  elseif ($requestUri == '/user-profile') {
    require_once './classes/User.php';
    $user = new User();
    if ($requestMethod ==='GET'){
        $user->getProfile();
    }

} elseif ($requestUri == '/edit-user-profile') {
        require_once './editProfile/handle_edit_user_profile.php';

// Add Product
} elseif ($requestUri == '/add-product') {
    if ($requestMethod ==='GET'){
        require_once './addProduct/add_product_form.php';
    } elseif ($requestMethod ==='POST'){
        require_once './addProduct/handle_add_product.php';
    }

//cart
} elseif ($requestUri == '/cart') {
    require_once './cart/cart.php';
} else {
    http_response_code(404);
    require_once '404.php';
}
