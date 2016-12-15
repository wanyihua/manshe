<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserFeedback.php
 * Date: 2016/12/16
 * Time: 0:16
 */

namespace app\api\controller;

use think\Request;
use app\library\Base as BaseController;

class UserFeedback extends BaseController
{
    private $param;

    public function __construct()
    {
        parent::__construct();
        $this->param = Request::instance()->param();
    }

    public function addFeedback()
    {
        return $this->getRes();
    }

    public function getFeedback()
    {
        return $this->getRes();
    }

    public function check()
    {

    }
}
