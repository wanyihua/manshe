<?php
/**
 * Created by PhpStorm.
 * User: yuanxuncheng
 * Date: 2016-12-21
 * Time: 22:40
 */

namespace app\api\model;

use think\Model;
use think\Db;


class UserAuths extends Model
{
    //set talbename
    protected $table = 'user_auths';
    //set primary key
    protected $pk = 'id';

    public function saveUserAuths($param) {
        $this->data($param);
        return $this->save();
    }

    public function updateUserAuths($param) {

    }

    public function getUserAuths($param) {
        $conds = array(
            'identity_type' => $param['identity_type'],
            'identifier' => $param['identifier'],
        );
        $field= 'user_id';
        return Db::table($this->table)->where($conds)->field($field)->select();
    }
}