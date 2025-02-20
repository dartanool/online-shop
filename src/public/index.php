<?php

$autoLoadCore = function (string $className) {
    $path = "../Core/$className.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};

$autoLoadController = function (string $className) {
    $path = "../Controllers/$className.php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};

spl_autoload_register($autoLoadCore);
spl_autoload_register($autoLoadController);


$app = new App();
$app->run();