<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri == '/registration') {
    if ($requestMethod ==='GET'){
        require_once 'registration_form.php';
    } elseif ($requestMethod ==='POST'){
        require_once 'handle_registration_form.php';
    }
} elseif ($requestUri == '/login') {
    if ($requestMethod ==='GET'){
        require_once 'login_form.php';
    } elseif ($requestMethod ==='POST'){
        require_once 'handle_login.php';
    }
} elseif ($requestUri == '/catalog') {
    require_once 'catalog.php';
}  elseif ($requestUri == '/user_profile') {
    require_once 'handle_user_profile.php';
} elseif ($requestUri == '/edit_user_profile') {
        require_once 'handle_edit_user_profile.php';
}
