<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:28
 */

namespace app\library;
use app\library\RedisMgr;


class Redis
{
     // Redis Key 前缀
    const REDIS_USER_PRE = 'ms:user'; // SESSION前缀


    /**
     * @desc 生成自增ID
     * @param $autoid
     * @return mixed
     */
    public static function getAutoID() {
        $redis = RedisMgr::getInstance([]);
        return $redis->inc(Redis::REDIS_USER_PRE);
    }
    
}