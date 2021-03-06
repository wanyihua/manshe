<?php
/**
 * User: yuanxuncheng
 * File: User.php
 * Date: 2016/12/17
 * Time: 23:13
 */

namespace app\api\controller;

use app\library\Base as BaseController;
use app\library\Sms;
use think\Cache;
use think\Log;
use app\library\Error;
use app\api\model\UserAccount as UserAccountModel;
use app\api\model\UserAuths as UserAuthsModel;
use app\library\Flag;
use app\library\Common;
use app\library\Ip;

class User extends BaseController {
    private $userAccount;
    private $userAuths;


    public function __construct() {
        parent::__construct();
        $this->userAccount = new UserAccountModel();
        $this->userAuths =  new UserAuthsModel();
    }

    /**
     * @desc 注册
     * @return array
     */
    public function register() {
        if (!isset($this->param['identity_type'])
                || !isset(Flag::$arr_identify_type[$this->param['identity_type']])
                || !isset($this->param['identifier'])
                || !isset($this->param['credential'])
                || !isset($this->param['verification_code'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        $time = time();

        // 手机号注册
        if (Flag::IDENTIFY_TYPE_PHONE == $this->param['identity_type']) {
            $ret = $this->userAccount->getUserAccountByPhone($this->param['identifier']);
            if(count($ret) != 0){
                return $this->getRes(Error::ERR_REGISTERED);
            }

            // 验证短信验证码
            $verifiyCode = Cache::get('sms:'.$this->param['identifier']);
            if ($this->param['verification_code'] != $verifiyCode) {
                return $this->getRes(Error::ERR_VERIFY_CODE);
            }

            $addUserAccount = array();
            $addUserAccount['phone'] = $this->param['identifier'];
            $addUserAccount['reg_ip'] = Ip::getClientIp();
            $addUserAccount['reg_time'] = $time;
            $addUserAccount['create_time'] = $time;
            $addUserAccount['update_time'] = $time;
            $addUserAccount['extend_info'] = '';
            $userid = $this->userAccount->addUserAccount($addUserAccount);
            if ($userid) {
                $addUserAuths = array();
                $addUserAuths['user_id'] = $userid;
                $addUserAuths['identity_type'] = $this->param['identity_type'];
                $addUserAuths['identifier'] = $this->param['identifier'];
                $addUserAuths['credential'] = Common::encodePassword($this->param['credential']);
                //$this->userAuths->saveUserAuths($addUserAuths);
            }
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

        $result = $this->userAuths->getUserAuths($this->param['identity_type'], $this->param['identifier']);
        if (count($result)) {
            $userid = $result[0]['user_id'];
            $identifier =  $result[0]['identifier'];
            $credential =  $result[0]['credential'];
            if (Common::encodePassword($this->param['credential']) == $credential) {
                $sessionid = Common::gererateSession($userid, $identifier, $credential);
                Cache::set('userid:'.$userid, $sessionid);
                $this->data = array(
                        'userid' => $userid,
                        'sessionid' => $sessionid,
                );
            } else {
                return $this->getRes(Error::ERR_PASSWORD);
            }
        }
        else
        {
            return $this->getRes(Error::ERR_USER_NOT_EXIST);
        }


        return $this->getRes();
    }

    /**
     * @desc 退出系统
     * @return array
     */
    public function logout() {
        if (!isset($this->param['userid'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        // 删除sessionid
        Cache::rm('userid:'.$this->param['userid']);

        $this->data = array();
        return $this->getRes();
    }

    /**
     * @desc 忘记密码
     * @return array
     */
    public function forgot() {
        if (!isset($this->param['identity_type'])
                || !isset(Flag::$arr_identify_type[$this->param['identity_type']])
                || !isset($this->param['identifier'])
                || !isset($this->param['credential'])
                || !isset($this->param['verification_code'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        // 手机号注册
        if (Flag::IDENTIFY_TYPE_PHONE == $this->param['identity_type']) {
            $ret = $this->userAccount->getUserAccountByPhone($this->param['identifier']);
            if(count($ret) == 0){
                return $this->getRes(Error::ERR_NOT_REGISTERED);
            }

            // 验证短信验证码
            $verfiyCode = Cache::get('sms:'.$this->param['identifier']);
            if ($this->param['verification_code'] != $verfiyCode) {
                return $this->getRes(Error::ERR_VERIFY_CODE);
            }

            $credential = Common::encodePassword($this->param['credential']);
            $result = $this->userAuths->updateUserAuths($this->param['identifier'], $this->param['identity_type'], $credential);

        }

        $this->data = array();
        return $this->getRes();
    }

    /**
     * @desc 发送短信并验证手机号码
     * @return array
     */
    public function getVerifyCode() {
        if (!isset($this->param['identity_type'])
                || !isset(Flag::$arr_identify_type[$this->param['identity_type']])
                || !isset($this->param['identifier'])) {
            return $this->getRes(Error::ERR_PARAM);
        }

        // 验证手机号码
        if (!Common::isMobile($this->param['identifier'])) {
            return $this->getRes(Error::ERR_PHONE_FORMAT);
        }

        // 接收到手机号并发送短信
        $ret = Sms::sendSms($this->param['identifier']);
        if(false === $ret){
            Log::alert("Send sms failed".json_encode($this->param));
            $this->getRes(Error::ERR_SYS);
        }
        return $this->getRes();
    }

    /**
     * @desc 更新用户信息
     * @return array
     */
    public function update() {
        $this->data = array();
        return $this->getRes();
    }
}
