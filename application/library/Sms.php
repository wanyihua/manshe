<?php
namespace app\library;

use think\Log;

class Sms {
    static public function sendSms($phone)
    {
        if (empty($phone)) {
            Log::alert(__METHOD__.'param: '.json_encode($phone));
            return false;
        }
        /*
        if (empty($_SESSION['send_code']) or $send_code != $_SESSION['send_code']) {
            //防用户恶意请求
            //Log::alert();
            //return false
        }
        */
        // 注意使用GMT时间
        date_default_timezone_set("GMT");
        $code = Common::createVerificationCode($phone,6,1);
        $ParamString = "{\"name\":\"" . strval($code) . "\"}";
        $data = array(
            // 公共参数
            'SignName' => CommonConfig::SMS_SIGN_NAME,
            'Format' => CommonConfig::SMS_FORMAT,
            'Version' => CommonConfig::SMS_VERSION,
            'AccessKeyId' => CommonConfig::SMS_KEY_ID,
            'SignatureVersion' => CommonConfig::SMS_SIGNATURE_VERSION,
            'SignatureMethod' => CommonConfig::SMS_SIGNATURE_METHOD,
            'SignatureNonce' => uniqid(),
            'Timestamp' => date(CommonConfig::SMS_DATE_FORMATE),
            // 接口参数
            'Action' => CommonConfig::SMS_ACTION,
            'TemplateCode' => CommonConfig::SMS_TEMPLATE_CODE,
            'RecNum' => $phone,
            'ParamString' => $ParamString
        );

        // 计算签名并把签名结果加入请求参数
        $data['Signature'] = self::computeSignature($data, CommonConfig::SMS_KEY_SECRET);
        Log::info('Sms data'.json_encode($data));

        $url = CommonConfig::SMS_URL . http_build_query($data);
        $result = Curl::https_request($url);
        if(isset($result['Code'])){
            Log::alert('Send sms failed: '.$result);
            return false;
        }
        return true;
    }

    public static function xml_to_array($xml)
    {
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        $arr = [];
        if (preg_match_all($reg, $xml, $matches)) {
            $count = count($matches[0]);
            for ($i = 0; $i < $count; $i++) {
                $subxml = $matches[2][$i];
                $key = $matches[1][$i];

                if (preg_match($reg, $subxml)) {
                    $arr[$key] = self::xml_to_array($subxml);
                } else {
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }


    public static function percentEncode($str)
    {
        // 使用urlencode编码后，将"+","*","%7E"做替换即满足ECS API规定的编码规范
        $res = urlencode($str);
        $res = preg_replace('/\+/', '%20', $res);
        $res = preg_replace('/\*/', '%2A', $res);
        $res = preg_replace('/%7E/', '~', $res);
        return $res;
    }


    //计算签名
    public static function computeSignature($parameters, $accessKeySecret)
    {
        // 将参数Key按字典顺序排序
        ksort($parameters);
        // 生成规范化请求字符串
        $canonicalizedQueryString = '';
        foreach ($parameters as $key => $value) {
            $canonicalizedQueryString .= '&' . self::percentEncode($key)
                . '=' . self::percentEncode($value);
        }
        // 生成用于计算签名的字符串 stringToSign
        $stringToSign = 'GET&%2F&' . self::percentencode(substr($canonicalizedQueryString, 1));

        // 计算签名，注意accessKeySecret后面要加上字符'&'
        $signature = base64_encode(hash_hmac('sha1', $stringToSign, $accessKeySecret . '&', true));
        return $signature;
    }

}
