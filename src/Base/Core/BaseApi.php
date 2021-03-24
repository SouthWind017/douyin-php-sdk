<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 06:47
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */

namespace Base\Core;


class BaseApi
{
    const Douyin_Url = "https://open.douyin.com";
    public $client_key = null;
    public $client_secret = null;

    public $response = null;

    public function __construct($config= null)
    {
        $this->client_key = $config['client_key'];
        $this->client_secret = $config['client_secret'];

    }

    public function toArray()
    {
        return $this->response ? json_decode($this->response, true) : true;
    }

    public function https_get($url, $params = [])
    {
        if ($params) {
            $url = $url . '?' . http_build_query($params);
        }
        $this->response = $this->https_request($url);
        $result = json_decode($this->response, true);
        return $result;
    }

    public function https_post($url, $data = [])
    {
        $header = [
            'Accept:application/json', 'Content-Type:application/json'
        ];
        $this->response = $this->https_request($url, json_encode($data), $header);
        $result = json_decode($this->response, true);
        return $result;
    }

    public function https_request($url, $data = null, $headers = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        if (!empty($headers)) {
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        //设置curl默认访问为IPv4
        if (defined('CURLOPT_IPRESOLVE') && defined('CURL_IPRESOLVE_V4')) {
            curl_setopt($curl, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        }
        $output = curl_exec($curl);
        curl_close($curl);
        return ($output);
    }

    public function https_byte($url, $file)
    {
        $payload = '';
        $params = "--__X_PAW_BOUNDARY__\r\n"
            . "Content-Type: application/x-www-form-urlencoded\r\n"
            . "\r\n"
            . $payload . "\r\n"
            . "--__X_PAW_BOUNDARY__\r\n"
            . "Content-Type: video/mp4\r\n"
            . "Content-Disposition: form-data; name=\"video\"; filename=\"123456.mp4\"\r\n"
            . "\r\n"
            . file_get_contents($file) . "\r\n"
            . "--__X_PAW_BOUNDARY__--";

        $first_newline = strpos($params, "\r\n");
        $multipart_boundary = substr($params, 2, $first_newline - 2);
        $request_headers = array();
        $request_headers[] = 'Content-Length: ' . strlen($params);
        $request_headers[] = 'Content-Type: multipart/form-data; boundary=' . $multipart_boundary;

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $request_headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($curl);
        curl_close($curl);

        $result = json_decode($output, true);
        return $result;
    }
}
