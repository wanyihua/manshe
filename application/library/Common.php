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
    public static function gererateSession($userid, $identifier, $credential) {
        return md5($userid.$identifier.$credential);
    }

    public static function encodePassword($password) {
        return md5($password);
    }

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

    public static function getVerificationCode(){

    }
}