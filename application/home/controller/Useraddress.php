<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: Useraddress.php
 * Date: 2016/11/27
 * Time: 23:48
 */

namespace app\home\controller;

use app\home\library\Flag;
use think\Request;
use think\Validate;
use think\Db;
use think\Log;

use app\home\controller\Base as BaseController;
use app\home\library\Error;
use app\home\model\UserAddress as UserAddressModel;

class UserAddress extends BaseController
{
    private $tableUserAddress;
    private $table_name = 'user_address';
    private $param;

    public function __construct()
    {
        parent::__construct();
        $this->userAddress = new UserAddressModel();
        $this->tableUserAddress = Db::table('user_address');
        $this->param = Request::instance()->param();
    }

    /**
     * @return array
     * @DESC 增加用户收货地址
     */
    public function addUserAddress()
    {
        // $param = Request::instance()->param();

        if (!$this->check($this->param)) {
            return $this->getRes(Error::ERR_PARAM);
        }
        if (isset($this->param['is_default'])) {
            //查找出默认的地址，置为非默认地址
            $arrUserAddress = $this->userAddress->getAddressByUserid($this->param['user_id']);
            if ($arrUserAddress != 0) {
                $conds = array(
                    'user_id' => $this->param['user_id'],
                );
                $field = array(
                    'is_default' => Flag::ADDRESS_DEFAUL_OFF,
                );
                $res = $this->userAddress->where($conds)->update($field);
                if ($res != 0) {
                    Log::notice("change  old default address status to anti-default,address_id: " . var_export($arrUserAddress, true));
                    Log::notice("change  old default address status to anti-default,address_id: " . json_encode($arrUserAddress));
                }
            }
        }
        //每个用户只能保存5个地址
        $arrAddress = $this->userAddress->getAddressByUserid($this->param['user_id']);
        if (count($arrAddress) >= Flag::ADDRESS_MAX) {
            return $this->getRes(Error::ERR_USER_ADDRESS_MAX);
        }

        $result = $this->userAddress->addAddress($this->param);
        if ($result === false) {
            return $this->getRess(Error::ERR_SYS);
        } else {
            return $this->getRes();
        }
    }

    /**
     * @return array
     * @DESC 删除收货地址
     */
    public function removeUserAddress()
    {
        if (!isset($this->param['address_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        /*
        $arrData = array(
            'status' => Flag::ADDRESS_STATUS_DELETED,
        );
        $res = $this->tableUserAddress->where('address_id', $param['address_id'])->update($arrData);
        */
        $res = $this->userAddress->removeAddress($this->param['address_id']);
        if ($res != 0) {
            return $this->getRes();
        } else {
            $this->data = $res;
            return $this->getRes(Error::ERR_USER_ADDRES_REMOVE);
        }
    }

    /**
     * @return array
     * @DESC 更新收货地址
     */
    public function updateUseraddress()
    {
        if (!isset($this->param['address_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        $res = $this->userAddress->updateAddress($this->param);
        if (false === $res) {
            return $this->getRes(Error::ERR_USER_ADDRES_UPDATE);
        } else {
            return $this->getRes();
        }
    }

    /**
     * @return array
     * @DESC 获取用户收货地址
     */
    public function getUserAddress()
    {
        //默认查询有效的地址
        //$this->data = Db::table($this->table_name)->where('status',1)->field('create_time,update_time',true)->select();
        if (!isset($this->param['user_id'])) {
            return $this->getRes(Error::ERR_PARAM);
        }
        $res = $this->userAddress->getAddressByUserid($this->param['user_id']);
        if ($res) {
            $this->data = $res;
            return $this->getRes();
        } else {
            return $this->getRes(Error::ERR_SYS);
        }
    }


    /**
     * @param $param
     * @return array|bool
     * @DESC 验证接口字段
     */
    public function check($param)
    {
        $rule = [
            'address_name' => 'require|max:25',
            'user_id' => 'require',
            'consignee' => 'require',
            'address' => 'require',
            'mobile' => 'require',
            'province' => 'require',
            'city' => 'require',
            'district' => 'require',
        ];
        $msg = [
            'address_name.require' => '名称必须',
            'address_name.max' => '名称最多不能超过25个字符',
            'user_id.require' => 'userid必须',
            'consignee.require' => 'consignee必须',
            'address.require' => 'address必须',
            'mobile.require' => 'mobile必须',
            'province.require' => 'province必须',
            'city.require' => 'city必须',
            'district.require' => 'district必须',
            'age.number' => '年龄必须是数字',
        ];
        $data = [
            'name' => 'thinkphp',
            'age' => 121,
            'email' => 'thinkphp@qq.com',
        ];
        $validate = new Validate($rule, $msg);
        $result = $validate->check($param);
        if (!$result) {
            return $validate->getError();
        }
        return $result;
    }
}

