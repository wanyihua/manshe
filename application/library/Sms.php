<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: SMS.php
 * Date: 2016/12/26
 * Time: 22:48
 */
//namespace app\library;


class SMS
{

    public  function sendSMS()
    {
        $target = "https://sms.aliyuncs.com/?";

        $mobile_code = $this->random(6, 1);

        if (empty($mobile)) {
            //exit('手机号码不能为空');
        }

        if (empty($_SESSION['send_code']) or $send_code != $_SESSION['send_code']) {
            //防用户恶意请求
            //exit('请求超时，请刷新页面后重试');
        }
        // 注意使用GMT时间
        date_default_timezone_set("GMT");
        $dateTimeFormat = 'Y-m-d\TH:i:s\Z'; // ISO8601规范
        $accessKeyId = 'LTAIOFNv24vMvUNZ';      // 这里填写您的Access Key ID
        $accessKeySecret = 'I98e0hT7o8vRvL4cDkxdeI5tFBnIdp';  // 这里填写您的Access Key Secret
        $ParamString = "{\"name\":\"" . strval($mobile_code) . "\"}";

        $data = array(
            // 公共参数
            'SignName' => '漫社互动',
            'Format' => 'json',
            'Version' => '2016-09-27',
            'AccessKeyId' => $accessKeyId,
            'SignatureVersion' => '1.0',
            'SignatureMethod' => 'HMAC-SHA1',
            'SignatureNonce' => uniqid(),
            'Timestamp' => date($dateTimeFormat),
            // 接口参数
            'Action' => 'SingleSendSms',
            'TemplateCode' => 'SMS_35965121',
            'RecNum' => '18801113786',
            'ParamString' => $ParamString
        );
// 计算签名并把签名结果加入请求参数
//echo $data['Version']."<br>";
//echo $data['Timestamp']."<br>";
        $data['Signature'] = $this->computeSignature($data, $accessKeySecret);

        //$result = $this->xml_to_array($this->https_request($target . http_build_query($data)));
        $result = $this->https_request($target . http_build_query($data));
        //echo $result['Error']['Code'] . "--->" . $result['Error']['Message'];
        //var_dump($result);

        echo "<br><br>" . $target . http_build_query($data);
    }

    public function https_request($url)
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

    public function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];
                if (preg_match($reg, $subxml)) {
                    $arr[$key] = $this->xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    public function random($length = 6, $numeric = 0)
    {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if ($numeric) {
            $hash = sprintf('%0' . $length . 'd', mt_rand(0, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for ($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }


    public function percentEncode($str)
    {
        // 使用urlencode编码后，将"+","*","%7E"做替换即满足ECS API规定的编码规范
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }


    public function computeSignature($parameters, $accessKeySecret)
    {
        // 将参数Key按字典顺序排序
        ksort($parameters);
        // 生成规范化请求字符串
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . $this->percentEncode($key)
                . '=' . $this->percentEncode($value);
        }
        // 生成用于计算签名的字符串 stringToSign
        $stringToSign = 'GET&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));
        var_dump($stringToSign);
        //echo "<br>".$stringToSign."<br>";
        // 计算签名，注意accessKeySecret后面要加上字符'&'
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
        return $signature;
    }


}





/*
class SMS {
    private $actionName = 'SingleSendSms';
    private $signName = '漫社互动';
    private $templateCode = 'SMS_35965121';
    private $phonelist = 18515030719;
    private $paramString = array('name' => '123456');
    private $accessKeyID = 'LTAIOFNv24vMvUNZ';
    //private $acccessKeySecret = 'I98e0hT7o8vRvL4cDkxdeI5tFBnIdp';

    //公共请求参数
    private $format = json;//返回值的类型，支持JSON与XML。默认为XML(非必须)
    private $version = '2016-09-27';//API版本号，为日期形式：YYYY-MM-DD，本版本对应为2016-09-27
    //private $Signature;//签名结果串
    private $SignatureMethod ;//签名方式，目前支持HMAC-SHA1
    private $Timestamp;//2015-11-23T04:00:00Z
    private $SignatureVersion;//签名算法版本，目前版本是1.0
    private $SignatureNonce;//唯一随机数，用于防止网络重放攻击。用户在不同请求间要使用不同的随机数值
    private $RegionId;//机房信息（非必须）

AccessKeyId=testid&
Action=SingleSendSms&
Format=XML&
ParamString={"name":"d","name1":"d"}&
RecNum=13098765432&
RegionId=cn-hangzhou&
SignName=标签测试&
SignatureMethod=HMAC-SHA1&
SignatureNonce=9e030f6b-03a2-40f0-a6ba-157d44532fd0&
SignatureVersion=1.0&
TemplateCode=SMS_1650053&
Timestamp=2016-10-20T05:37:52Z&
Version=2016-09-27
    public static function sendSMS(){

    }
}
*/
