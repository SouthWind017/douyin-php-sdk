<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 05:48
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */

namespace Douyin;


class Douyin {

    public static function __callStatic($name , $arguments)
    {

        $name = ucfirst(strtolower($name)); //类名重定义
        var_dump($name);
    }

}