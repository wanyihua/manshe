<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\View;

class Test extends Controller
{
    public function test()
    {
        $view = new View();
        $view->assign('aaa', 'hello world!');
        return $view->fetch('test');
    }
}
