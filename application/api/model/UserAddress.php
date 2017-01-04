<?php
/**
 * Create By: PhpStorm
 * User: yihua
 * File: UserAddress.php
 * Date: 2016/11/27
 * Time: 23:13
 */
namespace app\api\model;

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
        $conds = array(
            'user_id' => ['=',$user_id],
            'status' => ['=',Flag::ADDRESS_STATUS_ACTIVE],
        );
        $field = 'create_time,update_time';
        return Db::table($this->table)->where($conds)->field($field,true)->select();
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

    /**
     * @param $address_id
     * @param $user_id
     * @return bool
     * @DESC 设置用户的默认配送地址
     */
    public function setDefaultAddress($address_id,$user_id){
        // 启动事务
        Db::startTrans();
        try{
            $arrUserAddress = Db::table($this->table)->where(['user_id' => $user_id])->select();
            foreach($arrUserAddress as $arr){
                if($arr['is_default'] == Flag::ADDRESS_DEFAULT){
                    Db::table($this->table)->where(['address_id' => $arr['address_id']])->setField(['is_default' => Flag::ADDRESS_NOT_DEFAULT]);
                }
            }// 提交事务
            Db::table($this->table)->where(['address_id' => $address_id])->setField(['is_default' => Flag::ADDRESS_DEFAULT]);
            Db::commit();
            return true;
        } catch (\Exception $e) {
            var_dump($e);
            // 回滚事务
            Db::rollback();
            return false;
        }
    }

}
