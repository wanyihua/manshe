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
use think\Db;

use app\library\Flag;

class UserAddress extends Model
{
    //set talbename
    protected $table = 'user_address';
    //set primary key
    protected $pk = 'address_id';

    /**
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     * @DESC 根据userid获取用户收货地址
     */
    public function getAddressByUserid($user_id)
    {
        /*
        $conds = array(
            'user_id' => $user_id,
            'status' => Flag::ADDRESS_STATUS_ACTIVE,
        );
        */
        $conds = array(
            'user_id' => ['=',$user_id],
            'status' => ['=',Flag::ADDRESS_DEFAUL_ON],
        );
        $filter = 'create_time,update_time';
        return Db::table($this->table)->where($conds)->field($filter,true)->select();
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
        return $this->isUpdate(true)->save($field,$conds);
    }

}
