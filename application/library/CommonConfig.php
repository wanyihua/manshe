<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-27
 * Time: 23:17
 */

namespace app\library;

class CommonConfig {
    // 阿里云短信配置
    const SMS_URL = 'https://sms.aliyuncs.com/?';
    const SMS_DATE_FORMATE = 'Y-m-d\TH:i:s\Z'; // ISO8601规范
    const SMS_KEY_ID = 'LTAIOFNv24vMvUNZ';      // 这里填写您的Access Key ID
    const SMS_KEY_SECRET = 'I98e0hT7o8vRvL4cDkxdeI5tFBnIdp';  // 这里填写您的Access Key Secret
    const SMS_SIGN_NAME = '漫社互动';
    const SMS_FORMAT = 'json';
    const SMS_SIGNATURE_METHOD = 'HMAC-SHA1';
    const SMS_VERSION = '2016-09-27';
    const SMS_SIGNATURE_VERSION = '1.0';
    const SMS_ACTION = 'SingleSendSms';
    const SMS_TEMPLATE_CODE = 'SMS_35965121';


}