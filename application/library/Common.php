<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-19
 * Time: 0:02
 */

namespace app\library;
use app\library\Redis;


class Common
{
    public static function gererateUserid() {
        $time = time();
        return $time.Redis::getAutoID();
    }
}