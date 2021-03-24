<?php
/**
 * GitHub:https://github.com/SouthWind017/
 * Name:zhang tian yu
 * CreateTime:2021/3/25 0025 07:27
 * IdeName:PhpStorm
 * FileName:douyin-php-sdk
 * @copyright (c) douyin-php-sdk All Rights Reserved
 */
namespace Base;

use Base\Core\BaseApi;

class Video extends BaseApi
{
    //查询指定视频数据
    public function video_data($item_ids, $openid, $access_token)
    {

        // $api = self::BASE_API . '/data/external/item/base/';
        $api = self::Douyin_Url . '/video/data/';
        $params = [
            'open_id' => $openid,
            'access_token' => $access_token
        ];
        $api = $api . '?' . http_build_query($params);

        return $this->https_post($api, ["item_ids" => $item_ids], true);
    }

    //查询授权账号视频列表
    public function video_list($openid, $access_token, $page = 0, $cursor = 10)
    {
        $params = [
            'open_id' => $openid,
            'access_token' => $access_token,
            'count' => $cursor,
            'cursor' => $page
        ];
        $url = self::Douyin_Url . '/video/list/';
        return $this->https_get($url, $params);
    }

    //上传抖音视频
    public function video_upload($open_id, $access_token, $file)
    {
        $url = self::Douyin_Url . '/video/upload/?open_id=' . $open_id . '&access_token=' . $access_token;
        return $this->https_byte($url, $file);
    }

    //创建抖音视频
    public function video_create($open_id, $access_token, $video_id, $text = '', $othes = [])
    {
        $url = self::Douyin_Url . '/video/create/?open_id=' . $open_id . '&access_token=' . $access_token;
        $params = [
            'open_id' => $open_id,
            'access_token' => $access_token,
            'video_id' => $video_id,
            'text' => $text,
            'real_share' => !empty($othes['real_share']) ? $othes['real_share'] : '',
            'real_openid' => !empty($othes['real_openid']) ? $othes['real_openid'] : '',
        ];
        if (!empty($othes['real_openid'])) {
            $params['at_users'] = array(
                $othes['real_openid']
            );
        }
        if (empty($othes['aimingAt'])) {
            $params['poi_id'] = !empty($othes['poi_id']) ? $othes['poi_id'] : '';
            $params['poi_name'] = !empty($othes['poi_name']) ? $othes['poi_name'] : '';
            $params['poi_share'] = !empty($othes['poi_share']) ? $othes['poi_share'] : '';
        } else {
            $params['micro_app_id'] = !empty($othes['micro_app_id']) ? $othes['micro_app_id'] : '';
            $params['micro_app_title'] = !empty($othes['micro_app_title']) ? $othes['micro_app_title'] : '';
            $params['micro_app_url'] = !empty($othes['micro_app_url']) ? $othes['micro_app_url'] : '';
        }
        return $this->https_post($url, $params);
    }

    //初始化分片上传
    public function video_part_init($open_id, $access_token)
    {
        $url = self::Douyin_Url . '/video/part/init/';
        $params = [
            'openid_id' => $open_id,
            'access_token' => $access_token
        ];
        return $this->https_post($url, $params);
    }

    //上传视频分片到文件服务器
    public function video_part_upload($open_id, $access_token, $upload_id, $part_number, $video)
    {
        $params = [
            'openid_id' => $open_id,
            'access_token' => $access_token,
            'upload_id' => $upload_id,
            'part_number' => $part_number,
        ];
        $url = self::Douyin_Url . '/video/part/upload/' . '?' . http_build_query($params);

        return $this->https_byte($url, $video);
    }


    //用户评论
    public function usercomment($access_token, $openid, $data)
    {
        $url = self::Douyin_Url . '/item/comment/reply/?open_id=' . $openid . '&access_token=' . $access_token;
        $params = [
            'item_id' => $data['item_id'],
            'content' => $data['content']
        ];
        return $this->https_post($url, $params);
    }

    //分片完成上传
    public function video_part_complete($open_id, $access_token, $upload_id)
    {
        $params = [
            'openid_id' => $open_id,
            'access_token' => $access_token,
            'upload_id' => $upload_id
        ];
        $url = self::Douyin_Url . '/video/part/upload/';

        return $this->https_post($url, $params);
    }
}
