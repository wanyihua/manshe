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

class UserAccount extends BaseController
{
    private $param;
    private $modelUserAccount;

    public function __construct()
    {
        parent::__construct();
        
        $this->modelUserAccount = new UserAccountModel();
        
        $this->param = Request::instance()->param();
    }

    /**
     * @return array
     * @DESC 新增用户
     */
    public function addUser()
    {
        $strErrmsg = $this->check($this->param);
        if ($strErrmsg) {
            return $this->getRes(Error::ERR_PARAM, $strErrmsg);
        }
        return $this->getRes();
    }

    /**
     * @return array
     * @DESC 删除用户
     */
    public function removeUser()
    {
        if (!isset($this->param['address_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        return $this->getRes();
    }

    /**
     * @return array
     * @DESC 更新用户信息
     */
    public function updateUser()
    {
        if(!isset($this->param['address_id']))
        {
            return $this->getRes(Error::ERR_PARAM);
        }
        return $this->getRes();
    }

    /**
     * @return array
     * @DESC 获取用户信息
     */
    public function getUser()
    {
        if (!isset($this->param['user_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        return $this->getRes();
    }

    /**
     * @return array
     * @DESC 获取用户信息
     */
    public function getUserHtml()
    {
        $this->assign('aaa', 'hello world!');
        return $this->fetch('test');
    }


    /**
     * @param $param
     * @return array|bool
     * @DESC 验证接口字段
     */
    private function check($param)
    {
        $errmsg = '';
        
        $rule = [
            'user_name' => 'require|max:16',
            'nick_name' => 'require|max:16',
        ];
        $msg = [
            'user_name.require' => '名称必须且最多16个字符',
            'nick_name.max'     => '昵称最多不能超过16个字符',
        ];
        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            $errmsg = $validate->getError();
        }
        return $errmsg;
    }

}

