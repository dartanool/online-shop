<?php
$autoLoad = function (string $path) {
    $elem = explode("\\", $path);
    $path = "../$elem[0]/$elem[1].php";
    if (file_exists($path)) {
        require_once $path;
        return true;
    }
    return false;
};


spl_autoload_register($autoLoad);
$app = new \Core\App();
$app->run();