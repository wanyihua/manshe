<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-19
 * Time: 0:02
 */

namespace app\library;
use app\library\Redis;
use think\Cache;
use think\Log;


class Common
{
    /**
     * @desc 生成sessionid
     * @param $userid
     * @param $identifier
     * @param $credential
     * @return string
     */
    public static function gererateSession($userid, $identifier, $credential) {
        return md5($userid.$identifier.$credential);
    }

    /**
     * @desc 加密密码
     * @param $password
     * @return string
     */
    public static function encodePassword($password) {
        return md5($password);
    }

    /**
     * @desc 生成验证码
     * @param $phone
     * @param int $length
     * @param int $numeric
     * @return bool|string
     */
    public static function createVerificationCode($phone,$length = 6, $numeric = 0){
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
        $ret = Cache::set('sms:'.$phone,$hash,Flag::SMS_EXPIRE_TIME);
        if(false === $ret){
            Log::alert('Cache verification failed');
            return false;
        }
        return $hash;
    }

    /**
     * @desc 验证手机号是否正确
     * @param int $mobile
     */
    public static function isMobile($mobile) {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[^4]{1}\d{8}$|^17[0,6,7,8]{1}\d{8}$|^18[\d]{9}$#', $mobile) ? true : false;
    }
}