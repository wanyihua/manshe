<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Home.php
 * Date: 2016/11/27
 * Time: 23:48
 */

namespace app\home\controller;

use think\Request;
use think\Validate;
use think\Db;

use app\library\Base as BaseController;
use app\library\Error;

class Home extends BaseController
{
    private $param;

    public function __construct()
    {
        parent::__construct();
        
        $this->param = Request::instance()->param();
    }

    /**
     * @DESC 首页
     */
    public function index()
    {
        return $this->fetch('index');
    }

}

