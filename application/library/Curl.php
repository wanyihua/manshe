<?php

/**
 * Created by PhpStorm.
 * User: wanyihua
 * Date: 2016/12/27
 * Time: 15:11
 */
namespace app\library;


class Curl
{
    // 通过curl get数据
    public static function curlGet($url, $header = '', $timeout = 1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); // 模拟的header头
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function http($url, $method = 'GET', $postfields = null, $multi = false, $header_array = array())
    {
        $ch = curl_init();

        /* Curl 设置 */
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        //print_r($postfields);

        $method = strtoupper($method);
        switch ($method) {
            case 'GET':
                $url = is_array($postfields) ? $url . '?' . http_build_query($postfields) : $url;
                break;
            case 'POST':
                curl_setopt($ch, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postfields));
                }
                break;
            case 'DELETE':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
        }

        $header_array2 = array();

        if ($multi)
            $header_array2 = array('Content-Type: multipart/form-data; boundary=' . self::$boundary, 'Expect: ');
        if (is_array($header_array)) {
            foreach ($header_array as $k => $v)
                array_push($header_array2, $k . ': ' . $v);
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header_array2);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


    // 通过curl post数据
    public static function curlPost($url, $post_data = array(), $header = array(), $cookie = '', $timeout = 1)
    {
        $post_string = is_array($post_data) ? http_build_query($post_data) : $post_data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // 模拟的header头
        //设置连接结束后保存cookie信息的文件
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //定位服务使用，有多次超时重连
    public static function get_content_from_url($url, $host = null, $timeout = 1, $retry = false, $extraHeaders = array())
    {
        $timer = new Bd_Timer();
        $timer->start();//记录开始时间

        $ch = curl_init();
        if (isset($host)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

        //curl_setopt($ch, CURLOPT_HTTPGET, 1);
        foreach ($extraHeaders as $key => $val) {
            curl_setopt($ch, $key, $val);
        }
        $res = curl_exec($ch);

        $timer->stop();//记录结束时间
        $error_code = 0;
        $status = "succeed";
        if ($res === false) {
            $error_code = 1;
            $status = "error";
        }
        $arr_args = array(
            "curl-url" => $url,
            "curl-cost" => $timer->getTotalTime(),
            "curl-status" => $status
        );
        //记录运行状态
        //Bd_Log::trace("", $error_code, $arr_args);

        $times = 1;
        //失败重试
        while (($res == FAlSE) && ($times <= 2) && $retry) {
            $times++;

            // retry after 200ms
            usleep(200000);
            $res = curl_exec($ch);
            if ($res != FAlSE) break;
        }

        if ($res) {
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $res = substr($res, $headerSize);
        }

        curl_close($ch);
        return $res;
    }


}
