<?php
/**
 * User: yuanxuncheng
 * File: User.php
 * Date: 2016/12/17
 * Time: 23:13
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use think\Request;
use app\library\Error;

class User extends BaseController {
    private $param;

    public function __construct() {
        $this->param = Request::instance()->param();
    }

    public function login() {
        if (!isset($this->param['identity_type'])
            || !isset($this->param['identifier'])
            || !isset($this->param['credential'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        return $this->getRes(Error::ERR_SUCCESS);
    }

    public function logout() {
        return $this->getRes(Error::ERR_SUCCESS);
    }
}