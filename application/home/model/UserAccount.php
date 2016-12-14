<?php
/**
 * Create By: PhpStorm
 * User: niechenguang
 * File: UserAccount.php
 * Date: 2016/11/27
 * Time: 23:13
 */
namespace app\home\model;

use think\Model;

class UserAccount extends Model
{
    //set talbename
    protected $name = "user_account";

    /**
     * @param $param
     * @return false|int
     */
    public function addUser($param)
    {
        $this->data($param);
        return $this->allowField(true)->save();
    }

    /**
     * @param $user_id
     * @return false|\PDOStatement|string|\think\Collection
     * @DESC 根据userid获取用户信息
     */
    public function getUserByUserid($user_id)
    {
        $conds = array(
            'id' => $user_id,
        );
        return $this->where($conds)->select();
    }

    /**
     * @param $address_id
     * @return int|string
     * @throws \think\Exception
     * @DESC 根据用户id删除用户
     */
    public function removeUser($user_id)
    {
        $conds = array(
            'id' => $user_id,
        );
        return $this->where($conds)->delete();
    }

    /**
     * @param $param
     * @return false|int
     */
    public function updateUser($param)
    {
        if (empty($param['userid'])) {
            return false;
        }
        $conds = array(
            'id' => $param['userid'],
        );
        unset($param['userid']);
        $field = array();
        foreach ($this->field as $val) {
            if (isset($param[$val])) {
                $field[$val] = $param[$val];
            }
        }
        return $this->isUpdate(true)->save($field, $conds);
    }
}
