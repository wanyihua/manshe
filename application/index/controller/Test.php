<?php
namespace app\index\controller;

use think\cache\driver\Redis;

class Test
{
    public function test()
    {
        $objRedis = new Redis();
        $objRedis->set('aaaaa', 'acacac');
        $ret = $objRedis->get('aaaaa');
        var_dump($ret);
        return array('a'=>1, 'b'=>'c');
    }
}
