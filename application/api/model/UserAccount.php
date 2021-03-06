<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:39
 */

namespace app\api\model;

use think\Model;
use think\Db;

class UserAccount extends Model
{
    //set talbename
    protected $table = 'user_account';
    //set primary key
    protected $pk = 'id';

    public function addUserAccount($param)
    {
        $this->data($param);
        $this->save();
        return $this->data[$this->pk];
    }

    public function updateUserAccount($param) {
        $field = array();
        $conds = array();
        return $this->isUpdate(true)->save($field,$conds);
    }

    public function getUserAccount($param) {
        $conds = array(
                'user_id' => $param['user_id'],
                );
        $field= 'user_name,nick_name,phone,flag,age,sex,avatar,level';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
    public function getUserAccountByPhone($phone) {
        $conds = array(
                'phone' => $phone,
                );
        $field= 'user_name,nick_name,phone,flag,age,sex,avatar,level';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }

}
