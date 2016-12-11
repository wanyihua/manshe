<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserAddress.php
 * Date: 2016/11/27
 * Time: 23:13
 */
namespace app\home\model;

use think\Model;

use app\home\library\Flag;

class UserAddress extends Model
{
    //set talbename
    protected $name = "user_address";


    /**
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     * @DESC 根据userid获取用户收货地址
     */
    public function getAddressByUserid($user_id)
    {
        $conds = array(
            'user_id' => $user_id,
            'status' => Flag::ADDRESS_STATUS_ACTIVE,
        );
        return $this->where($conds)->field('create_time,update_time',true)->select();
    }


    /**
     * @param $param
     * @return false|int
     */
    public function addAddress($param)
    {
        $this->data($param);
        return $this->allowField(true)->save();
    }

    /**
     * @param $address_id
     * @return int|string
     * @throws \think\Exception
     */
    public function removeAddress($address_id)
    {
        $conds = array(
            'address_id' => $address_id,
        );
        $field = array(
            'status' => Flag::ADDRESS_STATUS_DELETED,
        );
        return $this->where($conds)->update($field);
    }

    /**
     * @param $param
     * @return false|int
     */
    public function updateAddress($param)
    {
        $conds = array(
            'address_id' => $param['address_id'],
        );
        $field = array();
        foreach($param as $key => $value)
        {
            if($key == 'address_id')
            {
                continue;
            }
            $field[$key] = $value;
        }
        var_dump($field);
        return $this->isUpdate(true)->save($field,$conds);
    }
    /**
     * @param $address_id
     * @throws \think\Exception
     */
    public function setDefaultAddress($address_id)
    {
        $conds = array(
            'address_id' => $address_id,
        );
        $field = array(
            'is_default' => Flag::ADDRESS_DEFAUL_ON,
        );
        $this->where($conds)->update($field);
    }
}
