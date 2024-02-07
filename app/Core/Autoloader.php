<?php

namespace Core;
class Autoloader
{
    public static function registrate(string $dir)
    {
        $autoloader = function (string $className) use ($dir) {
            $path = str_replace('\\', '/', $className); // Controller/CartController
            $path = $dir . '/' . $path . '.php';  //var/www/html/app/App.php
            if (file_exists($path)) {
                require_once $path;
            }
            return false;
        };

        spl_autoload_register($autoloader);
    }
}