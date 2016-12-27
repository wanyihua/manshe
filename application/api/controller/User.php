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
use app\library\Common;

class User extends BaseController {
    private $param;
    private $userAccount;
    private $userAuths;
    private $sessionRedis;

    public function __construct() {
        parent::__construct();
        $this->param = Request::instance()->param();
        $this->userAccount = new UserAccountModel();
        $this->userAuths =  new UserAuthsModel();
        $this->sessionRedis = new Redis();
    }

    /**
     * @return array
     */
    public function register() {
        if (!isset($this->param['identity_type'])
            || !isset(Flag::$arr_identify_type[$this->param['identity_type']])
            || !isset($this->param['identifier'])
            || !isset($this->param['credential'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $time = time();
        $addUserAccount = array();
        $addUserAccount['create_time'] = $time;
        $addUserAccount['update_time'] = $time;
        $userid = $this->userAccount->addUserAccount($addUserAccount);
        if ($userid) {
            $addUserAuths = array();
            $addUserAuths['user_id'] = $userid;
            $addUserAuths['identity_type'] = $this->param['identity_type'];
            $addUserAuths['identifier'] = $this->param['identifier'];
            $addUserAuths['credential'] = Common::encodePassword($this->param['credential']);
            $this->userAuths->saveUserAuths($addUserAuths);
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

        $result = $this->userAuths->getUserAuths($this->param);
        if ($result) {
            $userid = $result['user_id'];
            $identifier =  $result['identifier'];
            $credential =  $result['credential'];
            if (Common::encodePassword($this->param['credential']) == $identifier) {
                $sessionKey = Common::gererateSession($userid, $identifier, $credential);
                $this->sessionRedis->write($sessionKey, array());
                $this->data = array(
                    'session' => $sessionKey,
                );
            }
        }

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
