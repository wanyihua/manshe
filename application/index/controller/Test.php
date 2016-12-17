<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\View;

class Test extends Controller
{
    public function test()
    {
        //$view = new View();
        $this->assign('aaa', 'hello world!');
        return $this->fetch('test');
    }
}
