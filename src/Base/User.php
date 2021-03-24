<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 06:47
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */
namespace Base;

use Base\Core\BaseApi;

class User extends BaseApi{
    //获取用户详细信息
    public function getUserDetailedData($access_token,$openid,$date_type,$type){
        switch ($type) {
            case 'like':
                $api_url = self::Douyin_Url . '/data/external/user/like/';
                break;
            case 'comment':
                $api_url = self::Douyin_Url . '/data/external/user/comment/';
                break;
            case 'profile':
                $api_url = self::Douyin_Url . '/data/external/user/profile/';
                break;
            case 'share':
                $api_url = self::Douyin_Url . '/data/external/user/share/';
                break;
            case 'fans':
                $api_url = self::Douyin_Url . '/data/external/user/fans/';
                break;
            default:
                // code...
                break;
        }

        $params = [
            'access_token'  => $access_token,
            'open_id'       => $openid,
            'date_type'     => $date_type,
        ];
        return $this->https_get($api_url , $params);
    }


    //获取用户信息
    public function userinfo($access_token , $openid){
        $api_url = self::Douyin_Url . '/oauth/userinfo/';

        $params = [
            'access_token'  => $access_token,
            'open_id'       => $openid
        ];

        return $this->https_get($api_url , $params);
    }




    //抖音的APP调用
    public function get_rela_share($real_share)
    {
        $resStr = $this->getUserUidUrl($real_share);
        $tiktokuid   = $this->cut("user/","?u_code",$resStr);
        return "snssdk1128://user/profile/".$tiktokuid."?refer=web&gd_label=click_wap_download_follow&type=need_follow&needlaunchlog=1";
    }
    //获取跳转后网页用户的UID
    public function getUserUidUrl($url){

        $ch = curl_init();
        curl_setopt( $ch , CURLOPT_URL, $url );
        // 不需要页面内容
        curl_setopt( $ch , CURLOPT_NOBODY, 1);
        // 不直接输出
        curl_setopt( $ch , CURLOPT_RETURNTRANSFER, 1);
        // 返回最后的Location
        curl_setopt( $ch , CURLOPT_FOLLOWLOCATION, 1);
        curl_exec( $ch );
        $info = curl_getinfo( $ch ,CURLINFO_EFFECTIVE_URL);
        curl_close( $ch );
        return $info ;

    }
    //找2个值之间的值$begin开始 $end结束 $str 文本
    public function cut($begin,$end,$str){
        $b = mb_strpos($str,$begin) + mb_strlen($begin);
        $e = mb_strpos($str,$end) - $b;
        return mb_substr($str,$b,$e);
    }

    //获取粉丝列表
    public function fans($openid , $access_token , $page = 0 , $cursor = 30){
        $api_url = self::Douyin_Url . '/fans/list/';

        $params = [
            'open_id'   => $openid,
            'access_token'  => $access_token,
            'count'         => $page,
            'cursor'        => $cursor
        ];
        return $this->https_get($api_url, $params);
    }
    //获取关注列表
    public function following_list($openid , $access_token , $page = 0 , $cursor = 30){
        $api_url = self::Douyin_Url . '/following/list/';

        $params = [
            'open_id'   => $openid,
            'access_token'  => $access_token ,
            'count'         => $page,
            'cursor'        => $cursor
        ];
        return $this->https_get($api_url, $params);
    }
    /**
     * 解密手机号
     */
    public function decryptMobile($encryptedData)
    {

        return $this->stripPkcs7Padding($this->client_secret,$encryptedData);
    }
    function stripPkcs7Padding($key,$str) {
        $iv = substr($key,0,16);
        $str = base64_decode($str);
        $string = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_CBC, $iv);
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }

}