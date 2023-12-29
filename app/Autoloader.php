<?php

class Autoloader
{
    public static function registrate(string $dir)
    {
        $autoloader = function (string $className) use ($dir)
        {
            $path = str_replace('\\', DIRECTORY_SEPARATOR, $className);
            $path = $dir . '/' . $path . '.php';
            if(file_exists($path)) {
                require_once $path;
            }
            return false;
        };

//        $routingAutoloader = function (string $className)
//        {
//            if(file_exists("./../$className.php")) {
//                require_once "./../$className.php";
//            }
//            return false;
//        };
        spl_autoload_register($autoloader);
//        spl_autoload_register($routingAutoloader);
    }
}