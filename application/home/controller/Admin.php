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
use app\home\model\Admin as AdminModel;

class Admin extends BaseController
{
    private $param;
    private $modelAdmin;

    public function __construct()
    {
        parent::__construct();
        
        $this->modelAdmin = new AdminModel();
        
        $this->param = Request::instance()->param();
    }

    /**
     * @return array
     * @DESC 新增用户
     */
    public function addAdmin()
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
    public function removeAdmin()
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
    public function updateAdmin()
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
    public function getAdmin()
    {
        if (!isset($this->param['id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        return $this->getRes();
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
            'passwd' => 'require|max:16',
        ];
        $msg = [
            'user_name.require' => '用户名必须有',
            'user_name.max'     => '用户名最多16个字符',
            'passwd.require'    => '密码必须有',
            'passwd.max'        => '密码最多16个字符',
        ];
        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            $errmsg = $validate->getError();
        }
        return $errmsg;
    }

}

