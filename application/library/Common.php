<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016-12-19
 * Time: 0:02
 */

namespace app\library;
use app\library\RedisMgr;

class Common
{

    // Redis Key 前缀
    const REDIS_SEESSION_PRE = 'ms:'; // SESSION前缀

    // SESSION过期时间
    const REDIS_SESSION_EXPIRE = 7200;

    /**
     * @desc 获取登录session
     * @param $sessionid
     * @return mixed
     */
    public static function getSession($sessionid) {
        $redis = RedisMgr::getInstance([]);
        return $redis->get($sessionid);
    }

    /**
     * @desc 删除登录session
     * @param $sessionid
     * @return bool
     */
    public static function removeSession($sessionid) {
        $redis = RedisMgr::getInstance([]);
        return $redis->rm($sessionid);
    }

    /**
     * @desc 设置登录session
     * @param $sessionid
     * @return bool
     */
    public static function setSession($sessionid) {
        $options = array(
            'expire' => Common::REDIS_SESSION_EXPIRE,
            'prefix' => Common::REDIS_SEESSION_PRE,
        );
        $redis = RedisMgr::getInstance($options);
        return $redis->set('token', $sessionid);
    }
}