<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 07:32
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */
namespace Base;

use Base\Core\BaseApi;

class Init extends BaseApi
{
    //获取授权码(code) https://open.douyin.com/platform/doc/6848834666171009035
    public function connect($scope, $redirect_url, $state = "")
    {

        $api_url = self::Douyin_Url . '/platform/oauth/connect/';
        $params = [
            'client_key' => $this->client_key,
            'response_type' => 'code',
            'scope' => implode(',', $scope),
            'redirect_uri' => $redirect_url,
        ];

        if ($state) {
            $params['state'] = $state;
        }

        return $api_url . '?' . http_build_query($params);
    }
    //获取access_token https://open.douyin.com/platform/doc/6848806493387606024
    public function access_token($code)
    {
        $api_url = self::Douyin_Url . '/oauth/access_token/';
        $params = [
            'client_key' => $this->client_key,
            'client_secret' => $this->client_secret,
            'code' => $code,
            'grant_type' => 'authorization_code'
        ];

        return $this->https_get($api_url, $params);

    }

    //刷新refresh_token https://open.douyin.com/platform/doc/6848806519174154248
    public function refresh_token($refresh_token)
    {
        $api_url = self::Douyin_Url . '/oauth/refresh_token/';
        $params = [
            'client_key' => $this->client_key,
            'grant_type' => 'refresh_token',
            'refresh_token' => $refresh_token
        ];
        return $this->https_get($api_url, $params);
    }

    //刷新refresh_token https://open.douyin.com/platform/doc/6848806519174154248
    public function renew_refresh_token($refresh_token)
    {
        $api_url = self::Douyin_Url . '/oauth/renew_refresh_token/';
        $params = [
            'client_key' => $this->client_key,
            'refresh_token' => $refresh_token
        ];
        return $this->https_get($api_url, $params);
    }
    //生成client_token https://open.douyin.com/platform/doc/6848806493387573256
    public function client_token()
    {
        $api_url = self::Douyin_Url . '/oauth/client_token/';
        $params = [
            'client_key' => $this->client_key,
            'client_secret' => $this->client_secret,
            'grant_type' => 'client_credential'
        ];
        return $this->https_get($api_url, $params);
    }
    //抖音静默授权授权码 https://open.douyin.com/platform/doc/6848834666170959883
    public function silence_connect($scope,$redirect_url,$state = "")
    {
        $api_url = self::Douyin_Url . '/oauth/authorize/v2/';
        $params = [
            'client_key' => $this->client_key,
            'response_type' => "code",
            'scope' => implode(',', $scope),
            'redirect_uri' => $redirect_url,
            'state' => $state
        ];
        return $this->https_get($api_url, $params);
    }
}
