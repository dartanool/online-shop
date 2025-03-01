<?php

namespace Core;

class Autoloader
{
    public static function register(string $dir)
    {
        $autoLoad = function (string $pathToClass) use($dir)
        {
            $path = "../".str_replace('\\', '/', $pathToClass).".php";
            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };

        spl_autoload_register($autoLoad);

    }
}