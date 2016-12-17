<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-18
 * Time: 0:28
 */

namespace app\library;

use think\cache\driver\Redis;

class RedisMgr
{
    private static $_instance = null;

    public static function getInstance() {
        if (self::$_instance) {
            return self::$_instance;
        }

        self::$_instance = new Redis();
        return self::$_instance;
    }
}