<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri == '/registration') {
    if ($requestMethod ==='GET'){
        require_once 'registration_form.php';
    } elseif ($requestMethod ==='POST'){
        require_once 'handle_registration_form.php';
    }
}