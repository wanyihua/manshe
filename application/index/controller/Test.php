<?php
namespace app\index\controller;

use think\cache\driver\Redis;
use think\Db;

class Test
{
    public function test()
    {
        $ret = Db::table('test')->where('user_name',1)->select();
        Db::query('select * from think_user where id=?',[8]);
        $objRedis = new Redis();
        $objRedis->set('aaaaa', 'acacac');
        $ret = $objRedis->get('aaaaa');
        var_dump($ret);
        return array('a'=>1, 'b'=>'c');
    }
}
