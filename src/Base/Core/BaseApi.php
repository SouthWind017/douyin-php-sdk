<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 05:59
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */
namespace Base\Core;
class BaseApi{
    const Douyin_Url = "https://open.douyin.com";//抖音链接
    const TouTiao_Url = "https://open.snssdk.com";//头条链接
    public $client_key = null;
    public $client_secret = null;

    public function __construct($config)
    {
        $this->client_key = $config['client_key'];
        $this->client_secret = $config['client_secret'];
        var_dump($config);

    }

}