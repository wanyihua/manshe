<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: UserAccount.php
 * Date: 2016/11/27
 * Time: 23:48
 */

namespace app\home\controller;

use app\home\library\Flag;
use think\Controller;
use think\Request;
use think\Validate;
use think\Db;

use app\home\controller\Base as BaseController;
use app\home\library\Error;
use app\home\model\UserAccount as UserAccountModel;

class UserAccount extends BaseController
{
    private $param;

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
        if (!$this->check($this->param)) {
            return $this->getRes(Error::ERR_PARAM);
        }
        
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
        
    }

    /**
     * @return array
     * @DESC 获取用户信息
     */
    public function getUser()
    {
        //默认查询有效的地址
        //$this->data = Db::table($this->table_name)->where('status',1)->field('create_time,update_time',true)->select();
        if (!isset($this->param['user_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        
    }


    /**
     * @param $param
     * @return array|bool
     * @DESC 验证接口字段
     */
    private function check($param)
    {
        $rule = [
            'user_name' => 'require|max:16',
            'user_id' => 'require|max:16',
        ];
        $msg = [
            'user_name.require' => '名称必须且最多16个字符',
            'nick_name.max' => '昵称最多不能超过16个字符',
        ];
        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            return $validate->getError();
        }
        return $result;
    }

}

