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

class Admin extends Model
{
    //set talbename
    protected $name = "admin";

    /**
     * @param $param
     * @return false|int
     */
    public function addAdmin($param)
    {
        $this->data($param);
        return $this->allowField(true)->save();
    }

    /**
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @DESC 根据id获取管理员信息
     */
    public function getAdminByid($id)
    {
        $conds = array(
            'id' => $id,
        );
        return $this->where($conds)->select();
    }

    /**
     * @param $address_id
     * @return int|string
     * @throws \think\Exception
     * @DESC 根据用户id删除用户
     */
    public function removeAdmin($id)
    {
        $conds = array(
            'id' => $id,
        );
        return $this->where($conds)->delete();
    }

    /**
     * @param $param
     * @return false|int
     */
    public function updateAdmin($param)
    {
        if (empty($param['id'])) {
            return false;
        }
        $conds = array(
            'id' => $param['id'],
        );
        unset($param['id']);
        $field = array();
        foreach ($this->field as $val) {
            if (isset($param[$val])) {
                $field[$val] = $param[$val];
            }
        }
        return $this->isUpdate(true)->save($field, $conds);
    }
}
