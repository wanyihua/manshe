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
        return $this->save();
    }

    public function updateUserAccount($param) {

    }

    public function getUserAccount($param) {
        $conds = array(
            'user_id' => $param['user_id'],
        );
        $field= 'user_name,nick_name,phone,flag,age,sex,avatar,level';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }

}