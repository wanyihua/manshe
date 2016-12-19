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
    private static $_options = [];

    public static function getInstance($options) {
        if (is_array($options)) {
            self::$_options = $options;
        }

        if (self::$_instance) {
            return self::$_instance;
        }

        self::$_instance = new Redis(self::$_options);
        return self::$_instance;
    }
}