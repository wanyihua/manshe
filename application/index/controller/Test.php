<?php
namespace app\index\controller;

use think\Db;
use think\View;

class Test
{
    public function test()
    {
        $view = new View();
        $view->assign('aaa', 'hello world!');
        return $view->fetch('test');
    }
}
