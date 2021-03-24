<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 06:36
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */
require_once "autoload.php";
$cfg = [
    'client_key'=>"请填写实际开发环境的参数",
    'client_secret'=>"请填写实际开发环境的参数"

];
$data = [
    'access_token'=>"请填写实际开发环境的参数",
    'open_id'=>'请填写实际开发环境的参数'
];
//实例
$User = Douyin::User($cfg);
$Vide = Douyin::Video($cfg);
$Init = Douyin::Init($cfg);
//------------------Init----------------------



//------------------User----------------------
//获取抖音信息 ---- 实例
$userinfo = $User->userinfo($data['access_token'],$data['open_id']);
print_r($userinfo,false);

//------------------Video----------------------
