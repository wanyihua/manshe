<?php

/**
 * Created by PhpStorm.
 * User: wanyihua
 * Date: 2016/12/27
 * Time: 15:11
 */
namespace app\library;


use think\Log;

class Curl
{
    // 通过curl get数据
    public static function curlGet($url, $header = '', $timeout = 1) {
        $ch = curl_init();
        //$proxy = self::getProxy();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        /*
        if(!empty($proxy)){
            curl_setopt($ch, CURLOPT_PROXY, 'http://'.$proxy);
        }
         */
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array($header)); // 模拟的header头
        curl_setopt($ch, CURLOPT_PROXY, "10.199.180.48");
        curl_setopt($ch, CURLOPT_PROXYPORT, "8888");
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 获取代理IP
     */
    public static function getProxy(){
        $fetchUrl = Orp_FetchUrl::getInstance();
        $proxys = $fetchUrl->get_proxy_addr($https);//https
        if ($proxys && is_array($proxys)) {
            $randKey = array_rand($proxys);
            $proxy = $proxys[$randKey];
            return $proxy;
        }
        return false;
    }

    public static function http($url, $method = 'GET', $postfields = null, $multi = false, $header_array = array(), $ctime_out = 30, $time_out=30) {
        $ch = curl_init();

        /* Curl 设置 */
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0');
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $ctime_out);
        curl_setopt($ch, CURLOPT_TIMEOUT, $time_out);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_PROXY, "10.199.180.48");
        curl_setopt($ch, CURLOPT_PROXYPORT, "8888");
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
        curl_setopt($ch, CURLOPT_PROXY, "10.199.180.48");
        curl_setopt($ch, CURLOPT_PROXYPORT, "8888");
        $response = curl_exec($ch);
        curl_close ($ch);
        return $response;
    }


    // 通过curl post数据
    public static function curlPost($url, $post_data = array(), $header = array(),$cookie='', $timeout = 1) {
        $post_string = is_array($post_data)?http_build_query($post_data):$post_data;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); // 模拟的header头
        //设置连接结束后保存cookie信息的文件
        curl_setopt($ch,CURLOPT_COOKIE,$cookie);
        curl_setopt($ch, CURLOPT_PROXY, "10.199.180.48");
        curl_setopt($ch, CURLOPT_PROXYPORT, "8888");

        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //定位服务使用，有多次超时重连
    public static function get_content_from_url($url, $host = null, $timeout = 1, $retry = false, $extraHeaders = array())
    {
        $timer = new Timer();
        $timer->start();//记录开始时间

        $ch = curl_init();
        if(isset($host)){
            curl_setopt($ch, CURLOPT_HTTPHEADER, $host);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_PROXY, "10.199.180.48");
        curl_setopt($ch, CURLOPT_PROXYPORT, "8888");

        //curl_setopt($ch, CURLOPT_HTTPGET, 1);
        foreach ($extraHeaders as $key => $val){
            curl_setopt($ch, $key, $val);
        }
        $res = curl_exec($ch);

        $timer->stop();//记录结束时间
        $error_code = 0;
        $status = "succeed";
        if($res === false){
            $error_code = 1;
            $status = "error";
        }
        $arr_args = array(
            "curl-url" => $url,
            "curl-cost" => $timer->getTotalTime(),
            "curl-status" => $status
        );
        //记录运行状态
        //Log::info("", $error_code, $arr_args);

        $times = 1;
        //失败重试
        while(($res == FAlSE) && ($times <= 2) && $retry){
            $times++;

            // retry after 200ms
            usleep(200000);
            $res = curl_exec($ch);
            if($res != FAlSE) break;
        }

        if($res){
            $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $res = substr($res, $headerSize);
        }

        curl_close($ch);
        return $res;
    }

    /**
     * curl请求
     *
     * @param string $url 请求url
     * @param mixed $post 默认null, array时，key=>value. 字符串时，文件全路径
     * @param array $curlOptions curl选项，可以覆盖默认选项
     * @param int $retries 重试次数
     *
     * @return
     */
    public static function curl($url, $post = null, $curlOptions = array(), $retries = 2)
    {
        $ch = curl_init($url);

        if ($ch === false) {
            return false;
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36');
        curl_setopt($ch, CURLOPT_PROXY, "10.199.180.48");
        curl_setopt($ch, CURLOPT_PROXYPORT, "8888");

        if (isset($post) === true) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, (is_array($post) === true) ? http_build_query($post, "", "&") : $post);
        }
        if (!empty($curlOptions)) {
            curl_setopt_array($ch, $curlOptions);
        }
        $result = curl_exec($ch);
        while (($result === false) && ($retries-- > 0)) {
            $logStr = sprintf('url[%s] post[%s] option[%s] method[%s]', $url, serialize($post), json_encode($curlOptions),  __METHOD__);
            Log::alert($logStr);
            $result = curl_exec($ch);
        }
        curl_close($ch);
        return $result;
    }

    public static function https_request($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        return $data;
    }

}
