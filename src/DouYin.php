<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 06:44
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */

class Douyin{

    public static function __callStatic($name , $arguments)
    {
        $name = ucfirst(strtolower($name));
        $class = "\\Base\\{$name}";
        if (!empty($class) && class_exists($class)) {
            $option = array_shift($arguments);
            $config =  $option;
            return new $class($config);
        }
        return "找不到对应的函数或类";
    }
}