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
use app\api\model\UserAuths as UserAuthsModel;
use think\Validate;
use think\session\driver\Redis;
use app\library\Flag;

class User extends BaseController {
    private $param;
    private $userAccount;
    private $userAuths;

    public function __construct() {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userAccount = new UserAccountModel();
        $this->userAuths =  new UserAuthsModel();
    }

    /**
     * @return array
     */
    public function register() {
        if (!isset($this->param['identity_type'])
            || !isset($this->param['identifier'])
            || !isset($this->param['credential'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        // 手机号注册
        if (Flag::IDENTIFY_TYPE_PHONE == $this->param['identity_type']) {
            
        }

        // 微信
        if (Flag::IDENTIFY_TYPE_WEIXIN == $this->param['identity_type']) {

        }

        // 微博
        if (Flag::IDENTIFY_TYPE_WEIBO == $this->param['identity_type']) {

        }

        // EMAIL
        if (Flag::IDENTIFY_TYPE_EMAIL == $this->param['identity_type']) {

        }

        $this->data = array();
        return $this->getRes();
    }

    /**
     * @return array
     */
    public function login() {
        if (!isset($this->param['identity_type'])
            || !isset($this->param['identifier'])
            || !isset($this->param['credential'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $this->data = array();
        return $this->getRes();
    }

    /**
     * @return array
     */
    public function logout() {
        $this->data = array();
        return $this->getRes();
    }

    /**
     * 忘记密码
     */
    public function forgot() {
        $this->data = array();
        return $this->getRes();
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