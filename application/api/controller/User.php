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
use app\api\model\UserAccount as UserAccountModel;
use think\Validate;

class User extends BaseController {
    private $param;
    private $userAccount;

    public function __construct() {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userAccount = new UserAccountModel();
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

    public function addUser() {

    }

    public function check($param) {
        $rule = array(
            'user_name' => 'require',
            'nick_name' => 'require',
            'phone' => 'require',
        );
        $msg = array(
            'user_name.require' => '参数用户名必填',
            'nick_name.require' => '参数昵称必填',
            'phone.require' => '参数手机号必填',
        );
        $validate = new Validate($rule,$msg);
        $result = $validate->check($param);
        if (!$result) {
            return $validate->getError();
        } else {
            return $result;
        }
    }
}