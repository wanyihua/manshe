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
    // ͨ��curl get����
    public static function curlGet($url, $header = '', $timeout = 1)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); // ģ���headerͷ
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    public static function http($url, $method = 'GET', $postfields = null, $multi = false, $header_array = array())
    {
        $ch = curl_init();

        /* Curl ���� */
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


    // ͨ��curl post����
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
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // ģ���headerͷ
        //�������ӽ����󱣴�cookie��Ϣ���ļ�
        curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //��λ����ʹ�ã��ж�γ�ʱ����
    public static function get_content_from_url($url, $host = null, $timeout = 1, $retry = false, $extraHeaders = array())
    {
        $timer = new Bd_Timer();
        $timer->start();//��¼��ʼʱ��

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

        $timer->stop();//��¼����ʱ��
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
        //��¼����״̬
        //Bd_Log::trace("", $error_code, $arr_args);

        $times = 1;
        //ʧ������
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
