<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

//Registration
if ($requestUri == '/registration') {
    if ($requestMethod ==='GET'){
        require_once './registration/registration_form.php';
    } elseif ($requestMethod ==='POST'){
        require_once './registration/handle_registration_form.php';
    }

//login
} elseif ($requestUri == '/login') {
    if ($requestMethod ==='GET'){
        require_once './login/login_form.php';
    } elseif ($requestMethod ==='POST'){
        require_once './/login/handle_login.php';
    }

//catalog
} elseif ($requestUri == '/catalog') {
    if ($requestMethod ==='GET'){
        require_once './catalog/catalog.php';
    } elseif ($requestMethod ==='POST'){
        require_once './catalog/catalog_page.php';
    }

}  elseif ($requestUri == '/user-profile') {
    require_once './profile/handle_user_profile.php';

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
