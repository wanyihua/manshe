<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: Useraccount.php
 * Date: 2016/11/27
 * Time: 23:48
 */

namespace app\home\controller;

use think\Request;
use think\Validate;
use think\Db;

use app\library\Base as BaseController;
use app\library\Error;
use app\home\model\UserAccount as UserAccountModel;

class Index extends BaseController
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
        return $this->fetch('test');
    }

}

